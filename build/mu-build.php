#!/usr/bin/env php
<?php
/**
 * µCSS Build Script
 *
 * Assembles mu.css files by concatenating:
 *   1. pico.css, 2. mu.colors.css, 3. mu.grid.css, 4. mu.component.*.css
 *
 * Reads an array of themes from mu.theme.json and generates one CSS file per theme in dist/.
 *
 * Usage: php mu-build.php [--dir=.] [--css-dir=../css] [--dist-dir=../dist] [--output=mu.css] [--no-minify] [--list]
 */

$opts = getopt('', ['dir:', 'css-dir:', 'dist-dir:', 'output:', 'pico:', 'pico-colors:', 'theme:', 'minify', 'no-minify', 'no-banner', 'list', 'help']);

if (isset($opts['help'])) {
	$lines = file(__FILE__);
	foreach ($lines as $line) {
		if (str_starts_with($line, ' *')) echo substr($line, 3);
		elseif (str_starts_with($line, ' */')) break;
	}
	exit(0);
}

$dir        = rtrim($opts['dir'] ?? __DIR__, '/');
$cssDir     = rtrim($opts['css-dir'] ?? dirname(__DIR__) . '/css', '/');
$distDir    = rtrim($opts['dist-dir'] ?? dirname(__DIR__) . '/dist', '/');
$outFile    = $opts['output'] ?? null;
$picoFile   = $opts['pico'] ?? $dir . '/pico.css';
$picoColors = $opts['pico-colors'] ?? $dir . '/pico.colors.css';
$themeFile  = $opts['theme'] ?? $dir . '/mu.theme.json';
$minify     = !isset($opts['no-minify']);
$noBanner   = isset($opts['no-banner']);
$listOnly   = isset($opts['list']);

// Read version from package.json
$packageFile = dirname(__DIR__) . '/package.json';
$version = 'dev';
if (is_readable($packageFile)) {
	$pkg = json_decode(file_get_contents($packageFile), true);
	if (!empty($pkg['version'])) {
		$version = $pkg['version'];
	}
}

// --- Read themes ---
if (!is_readable($themeFile)) {
	fprintf(STDERR, "Error: cannot read theme file: %s\n", $themeFile);
	exit(1);
}
$themes = json_decode(file_get_contents($themeFile), true);
if (!is_array($themes) || empty($themes)) {
	fprintf(STDERR, "Error: invalid or empty themes in %s\n", $themeFile);
	exit(1);
}
// Support legacy single-object format
if (isset($themes['primary'])) {
	$themes = [$themes];
}

// --- Collect base files (everything except colors) ---
$baseFiles = [];
if (!is_readable($picoFile)) {
	fprintf(STDERR, "Error: PicoCSS not found: %s\n", $picoFile);
	exit(1);
}
$baseFiles[] = ['label' => 'PicoCSS base', 'path' => $picoFile];

$gridFile = $cssDir . '/mu.grid.css';
if (is_readable($gridFile)) {
	$baseFiles[] = ['label' => 'µCSS grid', 'path' => $gridFile];
}

$colorsUtilFile = $cssDir . '/mu.colors.css';
if (is_readable($colorsUtilFile)) {
	$baseFiles[] = ['label' => 'µCSS color utilities', 'path' => $colorsUtilFile];
}

$utilitiesFile = $cssDir . '/mu.utilities.css';
if (is_readable($utilitiesFile)) {
	$baseFiles[] = ['label' => 'µCSS utilities', 'path' => $utilitiesFile];
}

$components = glob($cssDir . '/mu.component.*.css') ?: [];
sort($components);
foreach ($components as $comp) {
	if (preg_match('/^mu\.component\.(.+)\.css$/', basename($comp), $m)) {
		$baseFiles[] = ['label' => "µCSS component: {$m[1]}", 'path' => $comp];
	}
}

function formatSize(int $b): string {
	if ($b < 1024) return $b . ' B';
	if ($b < 1048576) return round($b / 1024, 1) . ' KB';
	return round($b / 1048576, 1) . ' MB';
}

// --- List mode ---
if ($listOnly) {
	fprintf(STDERR, "µCSS themes (%d):\n\n", count($themes));
	foreach ($themes as $i => $theme) {
		$primary = $theme['primary'] ?? '?';
		$file = $i === 0 ? "mu.css + mu.{$primary}.css" : "mu.{$primary}.css";
		fprintf(STDERR, "  %2d. %-10s → %s\n", $i + 1, $primary, $file);
	}
	fprintf(STDERR, "\nBase files:\n");
	foreach ($baseFiles as $j => $f) {
		$s = filesize($f['path']);
		fprintf(STDERR, "  %2d. %-25s %s (%s)\n", $j + 1, $f['label'], $f['path'], formatSize($s));
	}
	exit(0);
}

// --- Build ---
$genScript = __DIR__ . '/mu-color-gen.php';
if (!is_file($genScript)) {
	fprintf(STDERR, "Error: mu-color-gen.php not found\n");
	exit(1);
}

// If --output is set, only build the first theme to that path (backward compat)
if ($outFile !== null) {
	$themes = [array_shift($themes)];
}

// Ensure dist directory exists
if ($outFile === null && !is_dir($distDir)) {
	if (!mkdir($distDir, 0755, true)) {
		fprintf(STDERR, "Error: cannot create dist directory: %s\n", $distDir);
		exit(1);
	}
}

// Read base file contents once
$baseContents = [];
foreach ($baseFiles as $f) {
	$content = file_get_contents($f['path']);
	$content = str_replace("\xEF\xBB\xBF", '', $content);
	$content = preg_replace('/@charset\s+"[^"]*"\s*;?\s*/', '', $content);
	// Rename PicoCSS namespace to µCSS
	if ($f['label'] === 'PicoCSS base') {
		$content = str_replace('--pico-', '--mu-', $content);
	}
	$baseContents[] = ['label' => $f['label'], 'content' => trim($content)];
}

$built = 0;
foreach ($themes as $i => $theme) {
	$primary = $theme['primary'] ?? 'unknown';

	// Generate colors via mu-color-gen.php --theme-data
	$tmpFile = tempnam(sys_get_temp_dir(), 'mu-colors-');
	$themeJson = json_encode($theme, JSON_UNESCAPED_SLASHES);
	$cmd = sprintf('%s %s --theme-data=%s --pico=%s --output=%s',
		PHP_BINARY,
		escapeshellarg($genScript),
		escapeshellarg($themeJson),
		escapeshellarg($picoColors),
		escapeshellarg($tmpFile)
	);
	fprintf(STDERR, "[%d/%d] Generating colors for '%s'...\n", $i + 1, count($themes), $primary);
	passthru($cmd, $ret);
	if ($ret !== 0) {
		fprintf(STDERR, "Error: color generation failed for theme '%s'\n", $primary);
		@unlink($tmpFile);
		exit(1);
	}

	$colorsContent = file_get_contents($tmpFile);
	@unlink($tmpFile);

	// Assemble
	$parts = [];
	if (!$noBanner) {
		$parts[] = "/*!\n * µCSS v{$version} — theme: {$primary}\n * Built on PicoCSS v2 — https://picocss.com\n * Generated: " . date('Y-m-d H:i:s') . "\n */\n";
	}

	// PicoCSS base + colors
	foreach ($baseContents as $j => $bc) {
		$parts[] = "/* === {$bc['label']} === */\n";
		$parts[] = $bc['content'] . "\n\n";
		// Insert mu.colors right after PicoCSS colors (index 1) or after base if no pico colors
		if (($j === 1 && count($baseContents) > 1) || ($j === 0 && count($baseContents) === 1)) {
			// This would be wrong — colors should go after pico colors but before grid
		}
	}

	// Actually, let's assemble properly: pico.css, pico.colors.css, mu.colors, grid, components
	$parts = [];
	if (!$noBanner) {
		$parts[] = "/*!\n * µCSS v{$version} — theme: {$primary}\n * Built on PicoCSS v2 — https://picocss.com\n * Generated: " . date('Y-m-d H:i:s') . "\n */\n";
	}

	$colorsInserted = false;
	foreach ($baseContents as $bc) {
		$parts[] = "/* === {$bc['label']} === */\n";
		$parts[] = $bc['content'] . "\n\n";

		// Insert mu.colors right after PicoCSS base
		if (!$colorsInserted && $bc['label'] === 'PicoCSS base') {
			$parts[] = "/* === µCSS colors === */\n";
			$parts[] = trim($colorsContent) . "\n\n";
			$colorsInserted = true;
		}
	}
	// If pico.colors.css wasn't found, insert colors after pico base
	if (!$colorsInserted) {
		// Insert at position after banner + pico base (index 2 if banner, 1 if no banner)
		$insertPos = $noBanner ? 2 : 3;
		array_splice($parts, $insertPos, 0, [
			"/* === µCSS colors === */\n",
			trim($colorsContent) . "\n\n",
		]);
	}

	$output = implode('', $parts);

	if ($minify) {
		// Strip all comments (including /*! */ banners)
		$output = preg_replace('/\/\*[^*]*\*+(?:[^\/][^*]*\*+)*\//', '', $output);
		$output = preg_replace('/\s+/', ' ', $output);
		$output = preg_replace('/\s*([{};:,])\s*/', '$1', $output);
		$output = str_replace(';}', '}', $output);
		$banner = $noBanner ? '' : "/* µCSS (muCSS) - mucss.org */\n";
		$output = $banner . trim($output) . "\n";
	}

	// Write output
	if ($outFile !== null) {
		// Backward compat: single file output
		$dest = $outFile;
		if (file_put_contents($dest, $output) === false) {
			fprintf(STDERR, "Error: cannot write %s\n", $dest);
			exit(1);
		}
		fprintf(STDERR, "  → %s (%s)%s\n", $dest, formatSize(strlen($output)), $minify ? ' [minified]' : '');
	} else {
		// Multi-theme output to dist/
		$namedDest = $distDir . "/mu.{$primary}.css";
		if (file_put_contents($namedDest, $output) === false) {
			fprintf(STDERR, "Error: cannot write %s\n", $namedDest);
			exit(1);
		}
		fprintf(STDERR, "  → %s (%s)%s\n", $namedDest, formatSize(strlen($output)), $minify ? ' [minified]' : '');

		// Theme index 0 also generates mu.css (default)
		if ($i === 0) {
			$defaultDest = $distDir . '/mu.css';
			if (file_put_contents($defaultDest, $output) === false) {
				fprintf(STDERR, "Error: cannot write %s\n", $defaultDest);
				exit(1);
			}
			fprintf(STDERR, "  → %s (default copy)%s\n", $defaultDest, $minify ? ' [minified]' : '');
		}
	}

	$built++;
}

fprintf(STDERR, "\nµCSS build complete: %d theme(s) built%s\n", $built, $minify ? ' [minified]' : '');
