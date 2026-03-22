# DECISIONS.md — PicoCSS PRs/issues evaluated for µCSS

This file tracks PicoCSS pull requests and issues that have been evaluated for integration into µCSS, to avoid re-analyzing the same topics.

## Applied

Fixes integrated into µCSS. The "Temporary" column indicates workarounds that should be removed if PicoCSS integrates the fix upstream.

| PR/Issue | Subject | µCSS file(s) | Temporary |
|----------|---------|--------------|-----------|
| #540, #700 | Helper text (`<small>`) not styled after input groups | mu.utilities.css | Yes |
| #634, #664 | Safari 18.2+ truncates dropdown text in nav | mu.component.nav.css | Yes |
| #651 | Inline code/kbd/samp vertical padding too thick | mu.utilities.css, mu.component.var.css | Yes |
| #663 | Striped table: hidden rows break odd/even alternation | mu.component.table.css | Yes |
| #665, #715 | Tooltip overflow on long text, multiline support | mu.utilities.css | Yes |
| #672 | Nested lists have unwanted bottom margin | mu.utilities.css | Yes |
| #678, #694 | Tooltip mispositioned on inline elements (Chromium) | mu.utilities.css | Yes |
| #701 | Nav dropdown full-width on Firefox | mu.component.nav.css | Yes |
| — | Tooltip: inverted surface colors (themed contrast is not always readable) | mu.utilities.css, mu-color-gen.php | No |
| — | Tooltip: comfortable width (max-content + max-width) | mu.utilities.css | No |

## Rejected

PRs/issues evaluated and deliberately not integrated.

| PR/Issue | Subject | Reason |
|----------|---------|--------|
| #544 | Button followed by textarea: missing spacing | Root cause is `<button>` without `type` lacking margin-bottom; global fix too risky, would affect all buttons |
| #553 | Notification component (`<dialog role="alert">`) | µCSS already has toast and alert components covering these use cases |
| #557 | Last child margin in containers | Already fixed in µCSS card component (`article > *:last-child`) |
| #599 | RTL support via logical properties | Product decision needed — µCSS does not currently target RTL. Significant cross-cutting chantier |
| #635 | Remove `cursor: pointer` from buttons | Against µCSS philosophy — µCSS uses `cursor: pointer` on interactive elements and provides `.clickable` utility |
| #638 | Yohn mega-PR (133 commits, grid, utils, fixes…) | Too massive and unfocused; individual useful fixes are covered by cleaner PRs (#663, #664) |
| #646 | Scope vertical nav styling to `<nav>` only | Change in pico.css base only; µCSS nav component is already scoped to `nav` |
| #689 | Custom SVG clear button on search input | Cosmetic only — browser-native clear button works, just not visually homogeneous |
| #719 | Replace Sass `if()` with CSS `if()` | µCSS does not use Sass — irrelevant |
| #720 | 12-column grid | µCSS already has a more complete grid with 6 breakpoints |
| #727 | Dropdown `<summary>` offscreen fix | Fix too simplistic — moves the problem instead of solving it |

## Deferred

PRs/issues of interest but not ready for integration.

| PR/Issue | Subject | Reason |
|----------|---------|--------|
| #685 | Accordion open/close transition (`interpolate-size`) | Browser support too low (~70%); revisit when support improves |
