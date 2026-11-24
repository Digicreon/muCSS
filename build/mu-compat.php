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
 * A rule (or an at-rule block) is a comfort rule when it is inside an @supports block (except
 * "@supports not", which old browsers apply), or when the comment right before it contains "@mu-comfort".
 * Comfort findings are reported but never fail the check, with one exception: a comfort rule mixing, in
 * the same selector list, selectors that need a recent feature and selectors that do not. Old browsers
 * would drop the plain ones too, so this is a baseline finding.
 *
 * Limits: "gap" is matched with "display: flex" on the same selector only; a feature that only
 * degrades to a harmless default (accent-color, text-underline-offset...) is not listed.
 *
 * Usage: php mu-compat.php [--strict] [--verbose] [file.css ...]
 *   file.css   readable (non-minified) files to check; the build strips the comments of minified files,
 *              including @mu-comfort. Default: a readable build of the first theme.
 *   --strict   exit with status 1 if a baseline rule uses a forbidden feature
 *   --verbose  list every offending rule
 *   --help     show this help
 *
 * The exit status is 2 if the check cannot be run (unknown option, unreadable file, failed build).
 */

$opts  = [];
$files = [];
foreach (array_slice($argv, 1) as $arg) {
	if (!str_starts_with($arg, '-')) {
		$files[] = $arg;
	} elseif (in_array($arg, ['--strict', '--verbose', '--help'], true)) {
		$opts[substr($arg, 2)] = true;
	} else {
		fwrite(STDERR, "Error: unknown option: $arg (see --help)\n");
		exit(2);
	}
}
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
	$tmp = tempnam(sys_get_temp_dir(), 'mu-compat-');
	register_shutdown_function(fn() => @unlink($tmp));
	exec(escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg(__DIR__ . '/mu-build.php') . ' --no-minify --output=' . escapeshellarg($tmp) . ' 2>&1', $log, $status);
	if ($status !== 0) {
		fwrite(STDERR, "Error: the build failed:\n" . implode("\n", $log) . "\n");
		exit(2);
	}
	$files = [$tmp];
}
$strict  = isset($opts['strict']);
$verbose = isset($opts['verbose']);

/**
 * Forbidden features: [label, where (selector|value|property|declaration|atrule), regular expression].
 * The 'value' patterns are matched against declaration values, 'property' against property names,
 * 'declaration' against "property:value".
 * Strings, url() contents and attribute selectors are emptied before matching.
 */
const FEATURES = [
	[':where()',               'selector', '/:where\(/i'],
	[':is() / :matches()',     'selector', '/:(?:is|matches|any)\(/i'],
	[':has()',                 'selector', '/:has\(/i'],
	[':not() with a list',     'selector', '/:not\((?:[^()]|\([^()]*\))*,/i'],
	[':nth-child(... of ...)', 'selector', '/:nth-(?:last-)?child\([^)]*\bof\b/i'],
	[':focus-visible',         'selector', '/:focus-visible/i'],
	[':focus-within',          'selector', '/:focus-within/i'],
	[':any-link',              'selector', '/:any-link/i'],
	[':placeholder-shown',     'selector', '/:placeholder-shown/i'],
	[':dir()',                 'selector', '/:dir\(/i'],
	[':host',                  'selector', '/:host\b/i'],
	['color-mix()',            'value',    '/\bcolor-mix\(/i'],
	['oklch() / oklab()',      'value',    '/\bokl(?:ch|ab)\(/i'],
	['lch() / lab()',          'value',    '/(?<![\w-])l(?:ch|ab)\(/i'],
	['hwb() / color()',        'value',    '/(?<![\w-])(?:hwb|color)\(/i'],
	['light-dark()',           'value',    '/\blight-dark\(/i'],
	['rgb()/hsl() without commas', 'value', '/\b(?:rgb|hsl)a?\([^,()]*\)/i'],
	['rgb()/hsl() alpha syntax', 'value', '/\b(?:rgb|hsl)\((?:[^(),]*,){3}|\b(?:rgb|hsl)a\((?:[^(),]*,){3}[^(),]*%/i'],
	['rgb() with decimals',    'value',    '/\brgba?\((?:[^(),]*,){0,2}\s*\d+\.\d+\s*[,)]/i'],
	['hex color with alpha',   'value',    '/#(?:[0-9a-f]{8}|[0-9a-f]{4})\b/i'],
	['clamp() / min() / max()','value',    '/(?<![\w-])(?:clamp|min|max)\(/i'],
	['min/max/fit-content',    'value',    '/(?<![\w-])(?:min|max|fit)-content\b/i'],
	['dvh, svh, lvh units',    'value',    '/\d(?:dvh|svh|lvh|dvw|svw|lvw)\b/i'],
	['revert',                 'value',    '/^revert(?:-layer)?$/i'],
	['display: grid, contents, flow-root', 'declaration', '/^display:.*\b(?:grid|contents|flow-root)\b/i'],
	['aspect-ratio',           'property', '/^aspect-ratio$/i'],
	['inset',                  'property', '/^inset(?:-block|-inline)?(?:-start|-end)?$/i'],
	['logical properties',     'property', '/^(?:margin|padding|border|scroll-margin|scroll-padding)-(?:block|inline)\b|^(?:(?:min|max)-)?(?:block|inline)-size$|^border-(?:start|end)-(?:start|end)-radius$/i'],
	['@layer',                 'atrule',   '/^@layer\b/i'],
	['@import layer / supports', 'atrule', '/^@import\b.*\b(?:layer|supports)\b/i'],
	['@container',             'atrule',   '/^@container\b/i'],
	['media range syntax',     'atrule',   '/^@media\b.*[<>]/i'],
];
const FLEX_GAP       = 'gap in a flex container';
const NOT_COMPLEX    = ':not() with a compound';
const PSEUDO_ELEMENT = 'pseudo-element in a list';
const NESTED         = 'nested rule';
const MIXED_COMFORT  = 'mixed comfort rule';
const ATTRIBUTE_FLAG = 'attribute selector flag';
const PREFIX         = 'missing vendor prefix';
const EXTRA_LABELS   = [NOT_COMPLEX, ATTRIBUTE_FLAG, PSEUDO_ELEMENT, NESTED, MIXED_COMFORT, PREFIX, FLEX_GAP];
/** Vendor prefixes needed next to a property, in the same rule: -webkit- for Safari 10, -moz- for Firefox 31. */
const PREFIXED_PROPERTIES = [
	'appearance'           => ['-webkit-', '-moz-'],
	'backdrop-filter'      => ['-webkit-'],
	'box-decoration-break' => ['-webkit-'],
	'clip-path'            => ['-webkit-'],
	'hyphens'              => ['-webkit-', '-moz-'],
	'mask'                 => ['-webkit-'],
	'mask-image'           => ['-webkit-'],
	'mask-position'        => ['-webkit-'],
	'mask-repeat'          => ['-webkit-'],
	'mask-size'            => ['-webkit-'],
	'text-size-adjust'     => ['-webkit-', '-moz-'],
	'user-select'          => ['-webkit-', '-moz-'],
];
/** Pseudo-elements known by the whole baseline. */
const SAFE_PSEUDO_ELEMENTS = ['before', 'after', 'first-line', 'first-letter'];

$total = 0;
foreach ($files as $file) {
	if (!is_file($file) || !is_readable($file)) {
		fprintf(STDERR, "Error: cannot read %s\n", $file);
		exit(2);
	}
	$css      = file_get_contents($file);
	$findings = [];
	$pos      = 0;
	$flex     = [];
	parseRules($css, $pos, false, $findings, $flex);
	checkFlexGap($flex, $findings);
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
 * @param	array	$flex		Flex containers and gaps by selector (updated).
 */
function parseRules(string $css, int &$pos, bool $comfort, array &$findings, array &$flex) : void {
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
			// only the comment right before the rule counts
			$markComfort = str_contains(substr($css, $pos, $end - $pos), '@mu-comfort');
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
				$inSupports = preg_match('/^@supports\b/i', $prelude) && !preg_match('/(?<![:\w-])not\b/i', emptyStrings($prelude));
				parseRules($css, $pos, $isComfort || $inSupports, $findings, $flex);
			}
			continue;
		}
		$prelude = preg_replace('#/\*.*?\*/#s', '', $prelude);
		$decls   = readDeclarations($css, $pos, $nested);
		checkRule($prelude, $decls, $start, $isComfort, $findings, $flex);
		if ($nested) {
			$findings[] = [NESTED, $isComfort, $prelude, $start];
		}
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
 * @param	?bool	$nested	Set to true if the block contains a nested rule.
 * @return	array	List of [property, value], including those of nested rules.
 */
function readDeclarations(string $css, int &$pos, ?bool &$nested = false) : array {
	$decls  = [];
	$nested = false;
	$len    = strlen($css);
	while ($pos < $len) {
		$text = readUntil($css, $pos, '{;}');
		if ($pos < $len && $css[$pos] === '{') {
			$pos++;
			$decls  = array_merge($decls, readDeclarations($css, $pos));
			$nested = true;
			continue;
		}
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

/**
 * Empties the strings, the url() contents and the attribute selectors of a text.
 */
function emptyStrings(string $text) : string {
	$text = preg_replace('/"(?:[^"\\\\]|\\\\.)*"|\'(?:[^\'\\\\]|\\\\.)*\'/s', '""', $text);
	$text = preg_replace('/\burl\([^()]*\)/i', 'url()', $text);
	return preg_replace('/\[[^\]]*\]/', '[]', $text);
}

/**
 * Splits a selector list on its top-level commas.
 * @return	array	Selectors.
 */
function splitSelectors(string $list) : array {
	$out = [];
	$pos = 0;
	while ($pos < strlen($list)) {
		$out[] = trim(preg_replace(['/\s+/', '/ ?([>+~]) ?/'], [' ', ' $1 '], readUntil($list, $pos, ',')));
		$pos++;
	}
	return array_values(array_filter($out, fn($s) => $s !== ''));
}

/* ---------- Checks ---------- */

/**
 * Checks an at-rule prelude.
 */
function checkAtRule(string $prelude, int $offset, bool $comfort, array &$findings) : void {
	foreach (FEATURES as [$label, $where, $regex]) {
		if ($where === 'atrule' && preg_match($regex, emptyStrings($prelude))) {
			$findings[] = [$label, $comfort, $prelude, $offset];
		}
	}
}

/**
 * Returns the recent features a single selector needs.
 * @return	array	Labels.
 */
function selectorFeatures(string $selector) : array {
	$text  = emptyStrings($selector);
	$found = [];
	foreach (FEATURES as [$label, $where, $regex]) {
		if ($where === 'selector' && preg_match($regex, $text)) {
			$found[] = $label;
		}
	}
	// [attr=value i]
	if (preg_match('/\[[^\]]*[=][^\]]*["\w]\s+[is]\s*\]/i', preg_replace('/"(?:[^"\\\\]|\\\\.)*"|\'(?:[^\'\\\\]|\\\\.)*\'/s', '""', $selector))) {
		$found[] = ATTRIBUTE_FLAG;
	}
	// :not() of the baseline accepts one simple selector: an element, or one class, id, attribute or pseudo-class
	if (preg_match_all('/:not\(\s*((?:[^()]|\((?:[^()]|\([^()]*\))*\))*)\)/i', $text, $m)) {
		foreach ($m[1] as $arg) {
			if (!str_contains($arg, ',') && !preg_match('/^(?:\*|[a-z][\w-]*|[.#][\w-]+|\[\]|:[a-z-]+(?:\([^()]*\))?)$/i', trim($arg))) {
				$found[] = NOT_COMPLEX;
				break;
			}
		}
	}
	return $found;
}

/**
 * Returns the group of the uncommon pseudo-element of a selector: its vendor prefix, or its name; '' if none.
 */
function pseudoElementGroup(string $selector) : string {
	if (!preg_match('/::?(-(?:webkit|moz|ms|o)-)[\w-]+|::([\w-]+)/i', emptyStrings($selector), $m)) {
		return '';
	}
	if ($m[1] !== '') {
		return strtolower($m[1]);
	}
	$name = strtolower($m[2]);
	return in_array($name, SAFE_PSEUDO_ELEMENTS, true) ? '' : $name;
}

/**
 * Tells if a declaration of a rule lacks a vendor prefixed version in the same rule.
 */
function lacksPrefix(array $decls) : bool {
	$props = array_column($decls, 0);
	foreach ($decls as [$prop, $value]) {
		foreach (PREFIXED_PROPERTIES[$prop] ?? [] as $prefix) {
			if (!in_array($prefix . $prop, $props, true)) {
				return true;
			}
		}
		if (($prop === 'position' && preg_match('/^sticky\b/i', $value) && !in_array(['position', '-webkit-sticky'], $decls, true)) ||
		    ($prop === 'background-clip' && preg_match('/\btext\b/i', $value) && !in_array('-webkit-background-clip', $props, true))) {
			return true;
		}
	}
	return false;
}

/**
 * Checks a style rule: its selectors, its properties and its values.
 */
function checkRule(string $selector, array $decls, int $offset, bool $comfort, array &$findings, array &$flex) : void {
	$found     = [];
	$selectors = splitSelectors($selector);
	$plain     = 0;
	foreach ($selectors as $one) {
		$needed = selectorFeatures($one);
		$found += array_fill_keys($needed, true);
		$plain += $needed ? 0 : 1;
	}
	$recent = count($selectors) - $plain;
	// an unknown pseudo-element invalidates the whole list: it must not be grouped with something else
	$groups = array_unique(array_map('pseudoElementGroup', $selectors));
	if (count($groups) > 1) {
		$found[PSEUDO_ELEMENT] = true;
	}
	foreach (FEATURES as [$label, $where, $regex]) {
		foreach ($decls as [$prop, $value]) {
			if (($where === 'property' && preg_match($regex, $prop)) ||
			    ($where === 'value' && preg_match($regex, emptyStrings($value))) ||
			    ($where === 'declaration' && preg_match($regex, $prop . ':' . emptyStrings($value)))) {
				$found[$label] = true;
			}
		}
	}
	if (lacksPrefix($decls)) {
		$found[PREFIX] = true;
	}
	foreach (array_keys($found) as $label) {
		$findings[] = [$label, $comfort, $selector, $offset];
	}
	if ($comfort && (($plain && $recent) || isset($found[PSEUDO_ELEMENT]))) {
		$findings[] = [MIXED_COMFORT, false, $selector, $offset];
	}
	// flex containers and gaps, checked once the whole file is read
	foreach ($decls as [$prop, $value]) {
		foreach ($selectors as $one) {
			if ($prop === 'display' && preg_match('/\b(?:inline-)?flex\b/', $value)) {
				$flex[$one]['flex'] = true;
			} elseif (preg_match('/^(?:row-|column-|grid-)?gap$/', $prop) && !preg_match('/^(?:(?:0[a-z%]*|normal)\s*)+$/i', $value)) {
				$flex[$one]['gaps'][] = [$comfort, $offset];
			}
		}
	}
}

/**
 * Checks the gaps set on flex containers, possibly from another rule with the same selector.
 */
function checkFlexGap(array $flex, array &$findings) : void {
	foreach ($flex as $selector => $info) {
		if (isset($info['flex'], $info['gaps'])) {
			foreach ($info['gaps'] as [$comfort, $offset]) {
				$findings[] = [FLEX_GAP, $comfort, (string)$selector, $offset];
			}
		}
	}
}

/* ---------- Report ---------- */

/**
 * Prints the findings of a file.
 * @return	int	Number of baseline findings.
 */
function report(string $file, string $css, array $findings, bool $verbose) : int {
	$labels = array_merge(array_column(FEATURES, 0), EXTRA_LABELS);
	$count  = array_fill_keys($labels, [0, 0]);
	foreach ($findings as [$label, $comfort]) {
		$count[$label][$comfort ? 1 : 0]++;
	}
	$baseline = array_sum(array_column($count, 0));
	$comfort  = array_sum(array_column($count, 1));
	printf("%s\n", str_starts_with(basename($file), 'mu-compat-') ? 'readable build of the first theme' : $file);
	printf("  %-36s %8s %8s\n", 'feature', 'baseline', 'comfort');
	foreach ($count as $label => [$b, $c]) {
		if ($b || $c) {
			printf("  %-36s %8d %8d\n", $label, $b, $c);
		}
	}
	printf("  %-36s %8d %8d\n", 'total (findings)', $baseline, $comfort);
	if ($verbose) {
		foreach ($findings as [$label, $isComfort, $text, $offset]) {
			// in a readable build, locate the rule in its source file
			$before = substr($css, 0, $offset);
			$mark   = preg_match_all('#/\* === (.+?) === \*/\n#', $before, $m, PREG_OFFSET_CAPTURE) ? end($m[0]) : null;
			$source = $mark ? end($m[1])[0] : basename($file);
			$line   = substr_count($before, "\n", $mark ? $mark[1] + strlen($mark[0]) : 0) + 1;
			$text = preg_replace('/\s+/', ' ', $text);
			if (strlen($text) > 110) {
				$text = substr($text, 0, 107) . '...';
			}
			printf("  %s:%d  [%s%s]  %s\n", $source, $line, $label, $isComfort ? ', comfort' : '', $text);
		}
	}
	return $baseline;
}
