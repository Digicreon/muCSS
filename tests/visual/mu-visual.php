#!/usr/bin/env php
<?php
/**
 * µCSS Visual Regression Tool
 *
 * Captures every page of examples/ with headless Chrome, in light and dark mode,
 * at several viewport widths, and compares two sets of captures pixel by pixel.
 *
 * Usage:
 *   php mu-visual.php capture <set> [--widths=390,768,1280,1536] [--modes=light,dark]
 *                                   [--pages=button,card] [--jobs=8] [--chrome=/path/to/chrome]
 *   php mu-visual.php compare <reference-set> <set> [--threshold=0]
 *   php mu-visual.php list
 *
 * Captures are stored in tests/visual/shots/<set>/<page>.<mode>.<width>.png (git-ignored).
 * A comparison writes tests/visual/shots/<reference-set>--<set>/index.html, showing each
 * differing capture next to its reference, with a difference image.
 * The comparison exits with status 1 when at least one capture differs.
 *
 * To make two captures of an unchanged page identical, the pages and dist/ are copied to a temporary
 * directory. A small snippet injected in each page forces the colour scheme with data-theme on <html>
 * and disables animations, transitions and the text caret; animations embedded in SVG data URLs
 * (such as the aria-busy spinner) are removed from the copied stylesheets.
 * Each capture is full height: the page is first loaded at 900 px high to measure its height.
 */

const DEFAULT_WIDTHS = [390, 768, 1280, 1536];
const DEFAULT_MODES  = ['light', 'dark'];
const MEASURE_HEIGHT = 900;
const TIME_BUDGET    = 3000;

$root        = dirname(__DIR__, 2);
$examplesDir = "$root/examples";
$distDir     = "$root/dist";
$shotsDir    = __DIR__ . '/shots';

$args    = array_slice($argv, 1);
$command = array_shift($args) ?? 'help';
$options = [];
$params  = [];
foreach ($args as $arg) {
	if (preg_match('/^--([a-z-]+)(?:=(.*))?$/', $arg, $m)) {
		$options[$m[1]] = $m[2] ?? true;
	} else {
		$params[] = $arg;
	}
}

switch ($command) {
	case 'capture':
		if (count($params) !== 1) {
			usage("capture: expected a set name");
		}
		exit(capture($params[0], $options));
	case 'compare':
		if (count($params) !== 2) {
			usage("compare: expected a reference set and a set");
		}
		exit(compare($params[0], $params[1], $options));
	case 'list':
		exit(listSets());
	default:
		usage();
}

/* ---------- Commands ---------- */

/**
 * Captures the example pages into the given set.
 * @param	string	$set		Name of the set (directory under shots/).
 * @param	array	$options	Command-line options.
 * @return	int	Exit status.
 */
function capture(string $set, array $options) : int {
	global $examplesDir, $distDir, $shotsDir;

	checkSetName($set);
	$chrome = $options['chrome'] ?? findChrome();
	$widths = isset($options['widths']) ? array_map('intval', explode(',', $options['widths'])) : DEFAULT_WIDTHS;
	$modes  = isset($options['modes']) ? explode(',', $options['modes']) : DEFAULT_MODES;
	$jobs   = max(1, (int)($options['jobs'] ?? 8));
	$pages  = array_map(fn($f) => basename($f, '.html'), glob("$examplesDir/*.html"));
	if (isset($options['pages'])) {
		$wanted = explode(',', $options['pages']);
		$pages  = array_values(array_intersect($pages, $wanted));
	}
	foreach ($modes as $mode) {
		if (!in_array($mode, DEFAULT_MODES, true)) {
			fail("unknown mode: $mode");
		}
	}
	if (!$pages) {
		fail("no page to capture");
	}

	// temporary copy of dist/, without the animations embedded in SVG data URLs
	$tmp = sys_get_temp_dir() . '/mu-visual-' . getmypid();
	mkdir("$tmp/dist", 0777, true);
	foreach (glob("$distDir/*.css") as $css) {
		$text = preg_replace_callback('/url\("data:image\/svg\+xml,[^"]*"\)/', fn($m) => preg_replace('/animation:[^;%]*;?/', '', $m[0]), file_get_contents($css));
		file_put_contents("$tmp/dist/" . basename($css), $text);
	}
	// temporary copy of the pages, one directory per mode, with dist/ linked next to it
	foreach ($modes as $mode) {
		mkdir("$tmp/$mode/examples", 0777, true);
		symlink("$tmp/dist", "$tmp/$mode/dist");
		foreach ($pages as $page) {
			$html = file_get_contents("$examplesDir/$page.html");
			$html = preg_replace('/<head\b[^>]*>/i', '$0' . snippet($mode), $html, 1);
			file_put_contents("$tmp/$mode/examples/$page.html", $html);
		}
	}

	$outDir = "$shotsDir/$set";
	if (!is_dir($outDir)) {
		mkdir($outDir, 0777, true);
	}

	// list of captures
	$shots = [];
	foreach ($pages as $page) {
		foreach ($modes as $mode) {
			foreach ($widths as $width) {
				$shots[] = [
					'page'  => $page,
					'mode'  => $mode,
					'width' => $width,
					'url'   => "file://$tmp/$mode/examples/$page.html",
					'file'  => "$outDir/$page.$mode.$width.png",
				];
			}
		}
	}
	$total = count($shots);
	printf("Capturing %d pages × %d modes × %d widths = %d captures into %s\n", count($pages), count($modes), count($widths), $total, $outDir);

	// pass 1: measure page heights
	$cmds = [];
	foreach ($shots as $i => $shot) {
		$cmds[$i] = chromeCommand($chrome, "$tmp/profile-m$i", $shot['width'], MEASURE_HEIGHT, '--dump-dom', $shot['url']) .
		            ' > ' . escapeshellarg("$tmp/dom-$i.html") . ' 2>/dev/null';
	}
	runPool($cmds, $jobs, 'Measuring');
	foreach ($shots as $i => $shot) {
		$dom = @file_get_contents("$tmp/dom-$i.html");
		if ($dom !== false && preg_match('/MUH:(\d+)/', $dom, $m)) {
			$shots[$i]['height'] = max(MEASURE_HEIGHT, (int)$m[1]);
		} else {
			fprintf(STDERR, "Warning: cannot measure %s (%s, %d px), using 4000 px\n", $shot['page'], $shot['mode'], $shot['width']);
			$shots[$i]['height'] = 4000;
		}
	}

	// pass 2: full-height screenshots
	$cmds = [];
	foreach ($shots as $i => $shot) {
		@unlink($shot['file']);
		$cmds[$i] = chromeCommand($chrome, "$tmp/profile-c$i", $shot['width'], $shot['height'], '--screenshot=' . $shot['file'], $shot['url']) .
		            ' > /dev/null 2>&1';
	}
	runPool($cmds, $jobs, 'Capturing');

	$missing = array_filter($shots, fn($s) => !is_file($s['file']));
	removeTree($tmp);
	foreach ($missing as $shot) {
		fprintf(STDERR, "Error: capture failed: %s\n", basename($shot['file']));
	}
	printf("%d captures written, %d failed.\n", $total - count($missing), count($missing));
	return $missing ? 1 : 0;
}

/**
 * Compares a set of captures with a reference set.
 * @param	string	$refSet		Name of the reference set.
 * @param	string	$set		Name of the compared set.
 * @param	array	$options	Command-line options.
 * @return	int	Exit status (1 if at least one capture differs, is missing or is new).
 */
function compare(string $refSet, string $set, array $options) : int {
	global $shotsDir;

	checkSetName($refSet);
	checkSetName($set);
	if (!class_exists('Imagick')) {
		fail("the Imagick extension is required to compare captures");
	}
	$threshold = (int)($options['threshold'] ?? 0);
	$refDir    = "$shotsDir/$refSet";
	$setDir    = "$shotsDir/$set";
	foreach ([$refDir, $setDir] as $dir) {
		if (!is_dir($dir)) {
			fail("no such set: " . basename($dir));
		}
	}
	$outDir = "$shotsDir/$refSet--$set";
	removeTree($outDir);
	mkdir($outDir, 0777, true);

	$refFiles = array_map('basename', glob("$refDir/*.png"));
	$setFiles = array_map('basename', glob("$setDir/*.png"));
	$same     = 0;
	$diffs    = [];
	foreach ($refFiles as $file) {
		if (!in_array($file, $setFiles, true)) {
			$diffs[] = ['file' => $file, 'status' => 'missing'];
			continue;
		}
		if (md5_file("$refDir/$file") === md5_file("$setDir/$file")) {
			$same++;
			continue;
		}
		$a = new Imagick("$refDir/$file");
		$b = new Imagick("$setDir/$file");
		$sizeA = $a->getImageWidth() . '×' . $a->getImageHeight();
		$sizeB = $b->getImageWidth() . '×' . $b->getImageHeight();
		if ($sizeA !== $sizeB) {
			$diffs[] = ['file' => $file, 'status' => "size $sizeA → $sizeB"];
			continue;
		}
		[$diffImage, $pixels] = $a->compareImages($b, Imagick::METRIC_ABSOLUTEERRORMETRIC);
		if ($pixels <= $threshold) {
			$same++;
			continue;
		}
		$diffImage->setImageFormat('png');
		$diffImage->writeImage("$outDir/$file");
		$diffs[] = ['file' => $file, 'status' => sprintf('%d pixels', $pixels), 'diff' => true];
	}
	foreach (array_diff($setFiles, $refFiles) as $file) {
		$diffs[] = ['file' => $file, 'status' => 'new'];
	}

	writeReport("$outDir/index.html", $refSet, $set, $same, $diffs);
	printf("%d identical, %d different.\n", $same, count($diffs));
	foreach ($diffs as $d) {
		printf("  %-40s %s\n", $d['file'], $d['status']);
	}
	if ($diffs) {
		printf("Report: %s/index.html\n", $outDir);
	}
	return $diffs ? 1 : 0;
}

/**
 * Lists the existing sets of captures.
 * @return	int	Exit status.
 */
function listSets() : int {
	global $shotsDir;

	foreach (glob("$shotsDir/*", GLOB_ONLYDIR) ?: [] as $dir) {
		if (str_contains(basename($dir), '--')) {
			continue;
		}
		printf("%-30s %d captures\n", basename($dir), count(glob("$dir/*.png")));
	}
	return 0;
}

/* ---------- Helpers ---------- */

/**
 * Returns the snippet injected at the top of <head>.
 * @param	string	$mode	Colour scheme ('light' or 'dark').
 * @return	string	HTML snippet.
 */
function snippet(string $mode) : string {
	return "\n<script>document.documentElement.setAttribute('data-theme', '$mode');" .
	       "addEventListener('load', function () { document.title = 'MUH:' + Math.ceil(Math.max(document.documentElement.scrollHeight, document.body.scrollHeight)); });</script>" .
	       "<style>*, *::before, *::after { animation: none !important; transition: none !important; caret-color: transparent !important; }</style>\n";
}

/**
 * Builds a headless Chrome command line.
 * @param	string	$chrome		Path to the Chrome binary.
 * @param	string	$profile	Profile directory (one per process, so that processes can run in parallel).
 * @param	int	$width		Viewport width.
 * @param	int	$height		Viewport height.
 * @param	string	$action		'--dump-dom' or '--screenshot=<file>'.
 * @param	string	$url		Page URL.
 * @return	string	Shell command.
 */
function chromeCommand(string $chrome, string $profile, int $width, int $height, string $action, string $url) : string {
	$args = [
		'--headless=new', '--disable-gpu', '--hide-scrollbars', '--force-device-scale-factor=1',
		'--no-first-run', '--no-default-browser-check', '--disable-extensions', '--allow-file-access-from-files',
		'--user-data-dir=' . $profile, "--window-size=$width,$height", '--virtual-time-budget=' . TIME_BUDGET,
		$action, $url,
	];
	return escapeshellarg($chrome) . ' ' . implode(' ', array_map('escapeshellarg', $args));
}

/**
 * Runs shell commands in parallel.
 * @param	array	$cmds	Commands.
 * @param	int	$jobs	Maximum number of simultaneous processes.
 * @param	string	$label	Label for the progress line.
 */
function runPool(array $cmds, int $jobs, string $label) : void {
	$queue   = $cmds;
	$running = [];
	$done    = 0;
	$total   = count($cmds);
	while ($queue || $running) {
		while ($queue && count($running) < $jobs) {
			$cmd       = array_shift($queue);
			$running[] = proc_open($cmd, [['file', '/dev/null', 'r']], $pipes);
		}
		foreach ($running as $k => $proc) {
			if (!proc_get_status($proc)['running']) {
				proc_close($proc);
				unset($running[$k]);
				$done++;
				fprintf(STDERR, "\r%s: %d/%d", $label, $done, $total);
			}
		}
		usleep(20000);
	}
	fprintf(STDERR, "\n");
}

/**
 * Finds a Chrome or Chromium binary.
 * @return	string	Path to the binary.
 */
function findChrome() : string {
	foreach (['google-chrome', 'google-chrome-stable', 'chromium', 'chromium-browser'] as $name) {
		$path = trim((string)shell_exec('command -v ' . escapeshellarg($name) . ' 2>/dev/null'));
		if ($path !== '') {
			return $path;
		}
	}
	fail("Chrome not found, use --chrome=/path/to/chrome");
}

/**
 * Writes the HTML comparison report.
 * @param	string	$file	Output file.
 * @param	string	$refSet	Name of the reference set.
 * @param	string	$set	Name of the compared set.
 * @param	int	$same	Number of identical captures.
 * @param	array	$diffs	Differing captures.
 */
function writeReport(string $file, string $refSet, string $set, int $same, array $diffs) : void {
	$e    = fn($s) => htmlspecialchars($s, ENT_QUOTES);
	$rows = '';
	foreach ($diffs as $d) {
		$f     = rawurlencode($d['file']);
		$cells = ($d['status'] === 'new' ? '<div></div>' : "<a href=\"../{$e($refSet)}/$f\"><img src=\"../{$e($refSet)}/$f\" alt=\"\"></a>") .
		         ($d['status'] === 'missing' ? '<div></div>' : "<a href=\"../{$e($set)}/$f\"><img src=\"../{$e($set)}/$f\" alt=\"\"></a>") .
		         (!empty($d['diff']) ? "<a href=\"$f\"><img src=\"$f\" alt=\"\"></a>" : '<div></div>');
		$rows .= "<section><h2>{$e($d['file'])} <small>{$e($d['status'])}</small></h2><div class=\"cols\">$cells</div></section>\n";
	}
	$html = <<<HTML
	<!doctype html>
	<html lang="en">
	<head>
	<meta charset="utf-8">
	<title>µCSS visual comparison: {$e($refSet)} → {$e($set)}</title>
	<style>
	body { font: 14px/1.5 system-ui, sans-serif; margin: 24px; color: #222; }
	h1 { font-size: 20px; } h2 { font-size: 15px; margin: 32px 0 8px; } small { color: #666; font-weight: 400; }
	.cols { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; align-items: start; }
	.cols img { width: 100%; border: 1px solid #ccc; }
	.head { position: sticky; top: 0; background: #fff; padding: 8px 0; font-weight: 600; }
	</style>
	</head>
	<body>
	<h1>{$e($refSet)} → {$e($set)}</h1>
	<p>{$same} identical, {$e((string)count($diffs))} different.</p>
	<div class="cols head"><div>{$e($refSet)}</div><div>{$e($set)}</div><div>difference</div></div>
	$rows
	</body>
	</html>
	HTML;
	file_put_contents($file, $html);
}

/**
 * Checks that a set name is safe to use as a directory name.
 * @param	string	$set	Name of the set.
 */
function checkSetName(string $set) : void {
	if (!preg_match('/^[A-Za-z0-9._-]+$/', $set) || str_contains($set, '--') || $set[0] === '.') {
		fail("invalid set name: $set (letters, digits, '.', '_' and '-' only, no '--')");
	}
}

/**
 * Removes a directory recursively (symbolic links are removed, not followed).
 * @param	string	$dir	Directory.
 */
function removeTree(string $dir) : void {
	if (!is_dir($dir) || is_link($dir)) {
		return;
	}
	foreach (scandir($dir) as $entry) {
		if ($entry === '.' || $entry === '..') {
			continue;
		}
		$path = "$dir/$entry";
		if (is_link($path) || !is_dir($path)) {
			unlink($path);
		} else {
			removeTree($path);
		}
	}
	rmdir($dir);
}

/**
 * Prints an error and exits.
 * @param	string	$message	Error message.
 */
function fail(string $message) : never {
	fprintf(STDERR, "Error: %s\n", $message);
	exit(2);
}

/**
 * Prints the usage and exits.
 * @param	?string	$error	Optional error message.
 */
function usage(?string $error = null) : never {
	if ($error) {
		fprintf(STDERR, "Error: %s\n\n", $error);
	}
	foreach (file(__FILE__) as $line) {
		if (str_starts_with($line, ' */')) {
			break;
		}
		if (str_starts_with($line, ' *')) {
			echo substr($line, 3);
		}
	}
	exit($error ? 2 : 0);
}
