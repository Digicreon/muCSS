#!/usr/bin/env php
<?php
/**
 * µCSS Compatibility Checker
 *
 * Scans CSS files for features that would break the µCSS 2.0 browser baseline
 * (Chrome 49+, Firefox 31+, Safari 10+, Edge 16+): an unknown selector invalidates its whole rule,
 * and an unsupported value function makes the declaration fall back to its initial value.
 *
 * Comfort rules are allowed to use recent features, because the page stays usable without them.
 * A rule (or an at-rule block) is a comfort rule when it is inside an @supports block, or when it is
 * preceded by a comment containing "@mu-comfort". Comfort findings are reported but never fail the check.
 *
 * Usage: php mu-compat.php [--strict] [--verbose] [file.css ...]
 *   file.css   files to check (default: ../dist/mu.css)
 *   --strict   exit with status 1 if a baseline rule uses a forbidden feature
 *   --verbose  list every offending rule
 */

$opts  = getopt('', ['strict', 'verbose', 'help'], $restIndex);
$files = array_slice($argv, $restIndex);
if (isset($opts['help'])) {
	foreach (file(__FILE__) as $line) {
		if (str_starts_with($line, ' */')) {
			break;
		}
		if (str_starts_with($line, ' *')) {
			echo substr($line, 3);
		}
	}
	exit(0);
}
if (!$files) {
	$files = [dirname(__DIR__) . '/dist/mu.css'];
}
$strict  = isset($opts['strict']);
$verbose = isset($opts['verbose']);

/**
 * Forbidden features: [label, where (selector|value|property|atrule), regular expression].
 * The 'value' patterns are matched against declaration values, 'property' against property names.
 */
const FEATURES = [
	[':where()',               'selector', '/:where\(/i'],
	[':is()',                  'selector', '/:is\(/i'],
	[':has()',                 'selector', '/:has\(/i'],
	[':not() with a list',     'selector', '/:not\((?:[^()]|\([^()]*\))*,/i'],
	[':nth-child(... of ...)', 'selector', '/:nth-(?:last-)?child\([^)]*\bof\b/i'],
	[':focus-visible',         'selector', '/:focus-visible/i'],
	[':focus-within',          'selector', '/:focus-within/i'],
	[':host',                  'selector', '/:host\b/i'],
	['color-mix()',            'value',    '/\bcolor-mix\(/i'],
	['oklch() / oklab()',      'value',    '/\bokl(?:ch|ab)\(/i'],
	['lch() / lab()',          'value',    '/(?<![\w-])l(?:ch|ab)\(/i'],
	['light-dark()',           'value',    '/\blight-dark\(/i'],
	['clamp() / min() / max()','value',    '/(?<![\w-])(?:clamp|min|max)\(/i'],
	['aspect-ratio',           'property', '/^aspect-ratio$/i'],
	['inset',                  'property', '/^inset(?:-block|-inline)?(?:-start|-end)?$/i'],
	['@layer',                 'atrule',   '/^@layer\b/i'],
	['@container',             'atrule',   '/^@container\b/i'],
];
const FLEX_GAP = 'gap in a flex container';

$total = 0;
foreach ($files as $file) {
	if (!is_readable($file)) {
		fprintf(STDERR, "Error: cannot read %s\n", $file);
		exit(2);
	}
	$css      = file_get_contents($file);
	$findings = [];
	$pos      = 0;
	parseRules($css, $pos, false, $findings);
	$total += report($file, $css, $findings, $verbose);
}
exit(($strict && $total > 0) ? 1 : 0);

/* ---------- Parser ---------- */

/**
 * Parses a list of rules until the end of the text or a closing brace.
 * @param	string	$css		CSS text.
 * @param	int	$pos		Current position (updated).
 * @param	bool	$comfort	True inside a comfort block.
 * @param	array	$findings	Findings (updated).
 */
function parseRules(string $css, int &$pos, bool $comfort, array &$findings) : void {
	$len         = strlen($css);
	$markComfort = false;
	while ($pos < $len) {
		// whitespace and comments
		if (ctype_space($css[$pos])) {
			$pos++;
			continue;
		}
		if (substr($css, $pos, 2) === '/*') {
			$end = strpos($css, '*/', $pos + 2);
			$end = ($end === false) ? $len : $end + 2;
			if (str_contains(substr($css, $pos, $end - $pos), '@mu-comfort')) {
				$markComfort = true;
			}
			$pos = $end;
			continue;
		}
		if ($css[$pos] === '}') {
			$pos++;
			return;
		}
		$start   = $pos;
		$prelude = trim(readUntil($css, $pos, '{;}'));
		$isComfort = $comfort || $markComfort;
		$markComfort = false;
		if ($pos >= $len || $css[$pos] === '}') {
			continue;
		}
		if ($css[$pos] === ';') {
			// statement at-rule (@import, @layer a, b;)
			$pos++;
			checkAtRule($prelude, $start, $isComfort, $findings);
			continue;
		}
		$pos++; // '{'
		if (str_starts_with($prelude, '@')) {
			checkAtRule($prelude, $start, $isComfort, $findings);
			if (preg_match('/^@(?:font-face|page|property|counter-style)\b/i', $prelude)) {
				readDeclarations($css, $pos);
			} else {
				$inSupports = (bool)preg_match('/^@supports\b/i', $prelude);
				parseRules($css, $pos, $isComfort || $inSupports, $findings);
			}
			continue;
		}
		$decls = readDeclarations($css, $pos);
		checkRule($prelude, $decls, $start, $isComfort, $findings);
	}
}

/**
 * Reads text until one of the stop characters, outside strings, comments and parentheses.
 * @param	string	$css	CSS text.
 * @param	int	$pos	Current position (updated, left on the stop character).
 * @param	string	$stops	Stop characters.
 * @return	string	Text read.
 */
function readUntil(string $css, int &$pos, string $stops) : string {
	$len   = strlen($css);
	$start = $pos;
	$depth = 0;
	while ($pos < $len) {
		$c = $css[$pos];
		if ($c === '"' || $c === "'") {
			$end = $pos + 1;
			while ($end < $len && $css[$end] !== $c) {
				$end += ($css[$end] === '\\') ? 2 : 1;
			}
			$pos = $end + 1;
			continue;
		}
		if ($c === '/' && ($css[$pos + 1] ?? '') === '*') {
			$end = strpos($css, '*/', $pos + 2);
			$pos = ($end === false) ? $len : $end + 2;
			continue;
		}
		if ($c === '(') {
			$depth++;
		} elseif ($c === ')') {
			$depth--;
		} elseif ($depth <= 0 && str_contains($stops, $c)) {
			break;
		}
		$pos++;
	}
	return substr($css, $start, $pos - $start);
}

/**
 * Reads the declarations of a block, up to and including its closing brace.
 * @param	string	$css	CSS text.
 * @param	int	$pos	Position after the opening brace (updated).
 * @return	array	List of [property, value].
 */
function readDeclarations(string $css, int &$pos) : array {
	$decls = [];
	$len   = strlen($css);
	while ($pos < $len) {
		$text = readUntil($css, $pos, ';}');
		$text = trim(preg_replace('#/\*.*?\*/#s', '', $text));
		if ($text !== '' && ($colon = strpos($text, ':')) !== false) {
			$decls[] = [strtolower(trim(substr($text, 0, $colon))), trim(substr($text, $colon + 1))];
		}
		if ($pos >= $len) {
			break;
		}
		$c = $css[$pos++];
		if ($c === '}') {
			break;
		}
	}
	return $decls;
}

/* ---------- Checks ---------- */

/**
 * Checks an at-rule prelude.
 */
function checkAtRule(string $prelude, int $offset, bool $comfort, array &$findings) : void {
	foreach (FEATURES as [$label, $where, $regex]) {
		if ($where === 'atrule' && preg_match($regex, $prelude)) {
			$findings[] = [$label, $comfort, $prelude, $offset];
		}
	}
}

/**
 * Checks a style rule: its selector, its properties and its values.
 */
function checkRule(string $selector, array $decls, int $offset, bool $comfort, array &$findings) : void {
	$found = [];
	foreach (FEATURES as [$label, $where, $regex]) {
		if ($where === 'selector' && preg_match($regex, $selector)) {
			$found[$label] = true;
		}
		foreach ($decls as [$prop, $value]) {
			if (($where === 'property' && preg_match($regex, $prop)) ||
			    ($where === 'value' && preg_match($regex, $value))) {
				$found[$label] = true;
			}
		}
	}
	// gap is only a problem when the same rule makes a flex container
	$props = array_column($decls, 1, 0);
	if ((isset($props['gap']) || isset($props['row-gap']) || isset($props['column-gap'])) &&
	    isset($props['display']) && preg_match('/\b(?:inline-)?flex\b/', $props['display'])) {
		$found[FLEX_GAP] = true;
	}
	foreach (array_keys($found) as $label) {
		$findings[] = [$label, $comfort, $selector, $offset];
	}
}

/* ---------- Report ---------- */

/**
 * Prints the findings of a file.
 * @return	int	Number of baseline findings.
 */
function report(string $file, string $css, array $findings, bool $verbose) : int {
	$labels = array_merge(array_column(FEATURES, 0), [FLEX_GAP]);
	$count  = array_fill_keys($labels, [0, 0]);
	foreach ($findings as [$label, $comfort]) {
		$count[$label][$comfort ? 1 : 0]++;
	}
	$baseline = array_sum(array_column($count, 0));
	$comfort  = array_sum(array_column($count, 1));
	printf("%s\n", $file);
	printf("  %-26s %8s %8s\n", 'feature', 'baseline', 'comfort');
	foreach ($count as $label => [$b, $c]) {
		if ($b || $c) {
			printf("  %-26s %8d %8d\n", $label, $b, $c);
		}
	}
	printf("  %-26s %8d %8d\n", 'total (rules)', $baseline, $comfort);
	if ($verbose) {
		foreach ($findings as [$label, $isComfort, $text, $offset]) {
			$line = substr_count($css, "\n", 0, $offset) + 1;
			$text = preg_replace('/\s+/', ' ', $text);
			if (strlen($text) > 110) {
				$text = substr($text, 0, 107) . '...';
			}
			printf("  %s:%d  [%s%s]  %s\n", basename($file), $line, $label, $isComfort ? ', comfort' : '', $text);
		}
	}
	return $baseline;
}
