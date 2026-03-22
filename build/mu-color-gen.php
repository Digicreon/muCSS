#!/usr/bin/env php
<?php
/**
 * µCSS Color Generator
 *
 * Reads PicoCSS color palette from pico.colors.css, applies a theme
 * configuration from mu.theme.json, and generates mu.colors.css with
 * all role-based CSS variables for light and dark modes.
 *
 * Usage: php mu-color-gen.php [--theme=mu.theme.json] [--theme-data='{"primary":"azure",...}'] [--pico=pico.colors.css] [--output=mu.colors.css]
 */

$opts = getopt('', ['theme:', 'theme-data:', 'pico:', 'output:', 'help']);
if (isset($opts['help'])) {
	fprintf(STDERR, "Usage: %s [--theme=mu.theme.json] [--theme-data=JSON] [--pico=pico.colors.css] [--output=mu.colors.css]\n", $argv[0]);
	exit(0);
}

$themeFile  = $opts['theme'] ?? __DIR__ . '/mu.theme.json';
$themeData  = $opts['theme-data'] ?? null;
$picoFile   = $opts['pico']  ?? __DIR__ . '/pico.colors.css';
$outFile    = $opts['output'] ?? __DIR__ . '/mu.colors.css';

const SHADE_MAP = [
	'light' => [
		'base'       => 550,
		'background' => 150,
		'hover'      => 700,
		'focus'      => 0.375,
		'underline'  => 0.5,
	],
	'dark' => [
		'base'       => 450,
		'background' => 850,
		'hover'      => 300,
		'focus'      => 0.375,
		'underline'  => 0.5,
	],
];

const POP_SHADE_MAP = [
	'light' => [
		'base'       => 350,
		'background' => 100,
		'hover'      => 500,
		'focus'      => 0.375,
		'underline'  => 0.5,
	],
	'dark' => [
		'base'       => 250,
		'background' => 900,
		'hover'      => 150,
		'focus'      => 0.375,
		'underline'  => 0.5,
	],
];

const ROLES = ['primary', 'secondary', 'tertiary', 'contrast', 'accent', 'success', 'info', 'warning', 'error', 'pop', 'spark'];

// Derived roles: the role inherits its color family from another role
const DERIVED_ROLES = ['pop' => 'accent', 'spark' => 'contrast'];


function parsePicoColors(string $file): array {
	if (!is_readable($file)) {
		fprintf(STDERR, "Error: cannot read PicoCSS colors file: %s\n", $file);
		exit(1);
	}
	$css = file_get_contents($file);
	$palette = [];
	if (preg_match_all('/--pico-color-([a-z]+)-(\d+)\s*:\s*(#[0-9a-fA-F]{3,8})\s*;/', $css, $m, PREG_SET_ORDER)) {
		foreach ($m as $match) {
			$palette[$match[1]][(int) $match[2]] = $match[3];
		}
	}
	if (empty($palette)) {
		fprintf(STDERR, "Error: no colors found in %s\n", $file);
		exit(1);
	}
	foreach ($palette as &$shades) {
		ksort($shades);
	}
	unset($shades);
	ksort($palette);
	return $palette;
}

function validateTheme(array $theme): array {
	foreach (ROLES as $role) {
		// Skip derived roles (e.g. pop derives from accent)
		if (isset(DERIVED_ROLES[$role])) continue;
		if (!isset($theme[$role]) || !is_string($theme[$role])) {
			fprintf(STDERR, "Error: missing or invalid role '%s' in theme\n", $role);
			exit(1);
		}
	}
	return $theme;
}

function readTheme(string $file): array {
	if (!is_readable($file)) {
		fprintf(STDERR, "Error: cannot read theme file: %s\n", $file);
		exit(1);
	}
	$json = json_decode(file_get_contents($file), true);
	if (!is_array($json)) {
		fprintf(STDERR, "Error: invalid JSON in theme file: %s\n", $file);
		exit(1);
	}
	return validateTheme($json);
}

function readThemeData(string $jsonStr): array {
	$json = json_decode($jsonStr, true);
	if (!is_array($json)) {
		fprintf(STDERR, "Error: invalid JSON in --theme-data\n");
		exit(1);
	}
	return validateTheme($json);
}

function hexToRgb(string $hex): array {
	$hex = ltrim($hex, '#');
	if (strlen($hex) === 3) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	return [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
}

function luminance(string $hex): float {
	[$r, $g, $b] = hexToRgb($hex);
	$channels = [];
	foreach ([$r, $g, $b] as $c) {
		$c /= 255.0;
		$channels[] = ($c <= 0.03928) ? $c / 12.92 : pow(($c + 0.055) / 1.055, 2.4);
	}
	return 0.2126 * $channels[0] + 0.7152 * $channels[1] + 0.0722 * $channels[2];
}

function inverseColor(string $hex): string {
	return luminance($hex) > 0.4 ? '#000' : '#fff';
}

function hexToRgba(string $hex, float $opacity): string {
	[$r, $g, $b] = hexToRgb($hex);
	return sprintf('rgba(%d, %d, %d, %s)', $r, $g, $b, rtrim(rtrim(sprintf('%.4f', $opacity), '0'), '.'));
}

function resolveShade(array $shades, int $target, string $family): string {
	if (isset($shades[$target])) {
		return $shades[$target];
	}
	$nearest = null;
	$minDist = PHP_INT_MAX;
	foreach ($shades as $s => $hex) {
		$dist = abs($s - $target);
		if ($dist < $minDist) {
			$minDist = $dist;
			$nearest = $hex;
		}
	}
	if ($nearest === null) {
		fprintf(STDERR, "Error: no shades available for family '%s'\n", $family);
		exit(1);
	}
	fprintf(STDERR, "Warning: shade %d not found for '%s', using nearest\n", $target, $family);
	return $nearest;
}

function generateRoleVars(string $role, string $family, array $palette, string $mode, ?array $shadeMap = null): array {
	$shades = $palette[$family];
	$map = ($shadeMap ?? SHADE_MAP)[$mode];
	$baseHex  = resolveShade($shades, $map['base'], $family);
	$bgHex    = resolveShade($shades, $map['background'], $family);
	$hoverHex = resolveShade($shades, $map['hover'], $family);
	$prefix = "--mu-{$role}";
	return [
		$prefix                      => $baseHex,
		"{$prefix}-background"       => $bgHex,
		"{$prefix}-hover"            => $hoverHex,
		"{$prefix}-hover-background" => $baseHex,
		"{$prefix}-focus"            => hexToRgba($baseHex, $map['focus']),
		"{$prefix}-inverse"          => inverseColor($baseHex),
		"{$prefix}-underline"        => hexToRgba($baseHex, $map['underline']),
	];
}

function buildCss(array $theme, array $palette): string {
	$out = [];
	$out[] = '/*';
	$out[] = ' * µCSS Colors — generated by mu-color-gen.php';
	$out[] = ' * Theme: ' . implode(', ', array_map(fn($r, $f) => "$r=$f", array_keys($theme), $theme));
	$out[] = ' * Generated: ' . date('Y-m-d H:i:s');
	$out[] = ' */';
	$out[] = '';

	$out[] = '/* Light color scheme (Default) */';
	$out[] = '[data-theme="light"],';
	$out[] = ':root:not([data-theme="dark"]) {';
	foreach (ROLES as $role) {
		$family = isset(DERIVED_ROLES[$role]) ? $theme[DERIVED_ROLES[$role]] : $theme[$role];
		$shadeMap = isset(DERIVED_ROLES[$role]) ? POP_SHADE_MAP : null;
		$vars = generateRoleVars($role, $family, $palette, 'light', $shadeMap);
		$out[] = '';
		$out[] = "\t/* {$role} ({$family}) */";
		foreach ($vars as $name => $value) {
			$out[] = "\t{$name}: {$value};";
		}
	}
	$out[] = '';
	$out[] = "\t/* Inverted surface (always opposite of page background, theme-independent) */";
	$out[] = "\t--mu-inverted-background: #181c25;";
	$out[] = "\t--mu-inverted-color: #fff;";
	$out[] = '}';
	$out[] = '';

	$out[] = '/* Dark color scheme (Auto) */';
	$out[] = '@media only screen and (prefers-color-scheme: dark) {';
	$out[] = "\t:root:not([data-theme]) {";
	foreach (ROLES as $role) {
		$family = isset(DERIVED_ROLES[$role]) ? $theme[DERIVED_ROLES[$role]] : $theme[$role];
		$shadeMap = isset(DERIVED_ROLES[$role]) ? POP_SHADE_MAP : null;
		$vars = generateRoleVars($role, $family, $palette, 'dark', $shadeMap);
		$out[] = '';
		$out[] = "\t\t/* {$role} ({$family}) */";
		foreach ($vars as $name => $value) {
			$out[] = "\t\t{$name}: {$value};";
		}
	}
	$out[] = '';
	$out[] = "\t\t/* Inverted surface (always opposite of page background, theme-independent) */";
	$out[] = "\t\t--mu-inverted-background: #eff1f4;";
	$out[] = "\t\t--mu-inverted-color: #000;";
	$out[] = "\t}";
	$out[] = '}';
	$out[] = '';

	$out[] = '/* Dark color scheme (Forced) */';
	$out[] = '[data-theme="dark"] {';
	foreach (ROLES as $role) {
		$family = isset(DERIVED_ROLES[$role]) ? $theme[DERIVED_ROLES[$role]] : $theme[$role];
		$shadeMap = isset(DERIVED_ROLES[$role]) ? POP_SHADE_MAP : null;
		$vars = generateRoleVars($role, $family, $palette, 'dark', $shadeMap);
		$out[] = '';
		$out[] = "\t/* {$role} ({$family}) */";
		foreach ($vars as $name => $value) {
			$out[] = "\t{$name}: {$value};";
		}
	}
	$out[] = '';
	$out[] = "\t/* Inverted surface (always opposite of page background, theme-independent) */";
	$out[] = "\t--mu-inverted-background: #eff1f4;";
	$out[] = "\t--mu-inverted-color: #000;";
	$out[] = '}';
	$out[] = '';

	return implode("\n", $out) . "\n";
}

// Main
fprintf(STDERR, "µCSS Color Generator\n");
fprintf(STDERR, "  PicoCSS colors: %s\n", $picoFile);
fprintf(STDERR, "  Theme:          %s\n", $themeData !== null ? '(inline JSON)' : $themeFile);
fprintf(STDERR, "  Output:         %s\n\n", $outFile);

$palette = parsePicoColors($picoFile);
fprintf(STDERR, "Parsed %d color families (%d total colors)\n",
	count($palette), array_sum(array_map('count', $palette)));

$theme = $themeData !== null ? readThemeData($themeData) : readTheme($themeFile);
fprintf(STDERR, "Theme: %s\n", json_encode($theme, JSON_UNESCAPED_SLASHES));

foreach ($theme as $role => $family) {
	if (isset(DERIVED_ROLES[$role])) continue;
	if (!isset($palette[$family])) {
		fprintf(STDERR, "Error: color family '%s' (role '%s') not found in palette\n", $family, $role);
		fprintf(STDERR, "Available families: %s\n", implode(', ', array_keys($palette)));
		exit(1);
	}
}

$css = buildCss($theme, $palette);

if (file_put_contents($outFile, $css) === false) {
	fprintf(STDERR, "Error: cannot write to %s\n", $outFile);
	exit(1);
}
fprintf(STDERR, "Generated %s (%d bytes)\n", $outFile, strlen($css));
