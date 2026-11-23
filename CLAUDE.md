# CLAUDE.md — µCSS Project Instructions

## Project overview

µCSS is a CSS framework derived from PicoCSS v2 (MIT), part of the Temma-UI project. Version 2.0 (branch `v2`) makes it fully standalone: the Pico code now lives in µCSS source files. All tooling is PHP (no Node.js). CSS files are plain CSS (no preprocessor).

## Key files

- `build/mu-build.php` — Main build script, generates themed CSS files into `dist/`
- `build/mu.manifest.json`: ordered list of the CSS files concatenated by the build (`@colors` marks where the generated theme colors go); the order decides the cascade
- `build/mu-color-gen.php` — Color generator, reads PicoCSS palette + theme → CSS variables
- `build/mu.theme.json` — Array of 20 theme definitions (one per PicoCSS color)
- `build/mu-compat.php`: reports CSS features that break the 2.0 browser baseline (Chrome 49+, Firefox 31+, Safari 10+, Edge 16+); `--strict` fails
- `build/pico.colors.css`: Pico palette, still read by `mu-color-gen.php` until the new palette exists
- `build/pico.css`: original Pico CSS v2.1.1, kept for reference only (no longer read by the build; to be removed)
- `css/core/*.css`: Pico-derived code (26 files, in Pico's original order, `--mu-` variables); to be merged into the µCSS modules
- `tests/visual/mu-visual.php`: visual regression tool (captures every example page in light/dark at 390/768/1280/1536 px with headless Chrome, compares two sets); captures in `tests/visual/shots/` (git-ignored)
- `css/mu.grid.css` — 12-column responsive grid (6 breakpoints: sm 576px, md 768px, lg 1024px, xl 1280px, xxl 1536px — aligned with PicoCSS container)
- `css/mu.colors.css` — Color utility classes (`.c-*`, `.bg-*`, `.border-*`)
- `css/mu.utilities.css` — Positioning utilities (`.sticky-top`, `.fixed-top`, `.fixed-bottom`)
- `css/mu.component.*.css` — UI components (18 files)
- `dist/` — Build output (21 CSS files: `mu.css` + 20 `mu.{color}.css`)
- `examples/` — HTML demos (49 files: index + 19 component pages + 9 native element pages + 20 theme recap pages)
- `README.md` — Project documentation with installation, components, grid, dark mode, build

## Build commands

```bash
php build/mu-build.php              # Build all 20 themes → dist/
php build/mu-build.php --list       # List themes and base files
php build/mu-build.php --minify     # Build minified
php build/mu-build.php --output=f   # Backward compat: single theme → file
php build/mu-compat.php [--verbose]  # Browser baseline report on dist/mu.css
php tests/visual/mu-visual.php capture <set>          # Capture all example pages
php tests/visual/mu-visual.php compare <ref> <set>    # Pixel comparison + HTML report
```

## Conventions

- Respond in **French** to the user
- Keep responses **concise and factual**
- All CSS variables use the `--mu-` prefix
- Components follow naming pattern `mu.component.{name}.css`
- 11 color roles: primary, secondary, tertiary, contrast, spark, accent, pop, success, info, warning, error (spark is the light variant of contrast, pop the light variant of accent)
- No JavaScript in CSS files — behavior is the application's JS responsibility
- Mobile-first, accessible (ARIA), semantic HTML
- PHP tooling only, no Node.js/SASS dependencies
- Examples load `../dist/mu.css` (or `../dist/mu.{color}.css` for theme pages)
- Each example page: HTML5, `<main class="container">`, dark mode toggle, back link to index
- After modifying CSS, always rebuild with `php build/mu-build.php`

## Known PicoCSS overrides

These µCSS rules exist to fix PicoCSS default behaviors:

- `article > *:last-child:not(header):not(footer) { margin-bottom: 0 }` — Remove bottom margin on last content element in cards (PicoCSS `<p>` margin)
- `.tabs li { list-style: none }` — Override PicoCSS `ul li { list-style: square }`
- `.breadcrumb li { padding: 0; margin: 0 }` / `.breadcrumb li a { margin: 0; padding: 0 }` — Neutralize PicoCSS nav spacing on breadcrumb items
- `.table-hover` / `.table-striped` target `th`/`td` not `tr` — PicoCSS sets `background-color` on cells, not rows
- Card `header`/`footer` override `background-color: var(--pico-card-sectioning-background-color)` with `color-mix()` shade
- `nav a { text-decoration: none }` — Remove underline on all nav links (PicoCSS hover underline)
- `.table-bordered` border uses `color-mix()` blend for visible but lighter cell borders
- Nav/header with `.bg-*` get a gradient via `color-mix(in oklch)` (same as hero)
- `li ul, li ol { margin-bottom: 0 }` — Fix nested list extra margin (picocss/pico#672) — remove when fixed upstream
- `:where(nav li)::before { float: none; content: " " }` — Fix Safari 18.2+ dropdown text truncation (picocss/pico#634, picocss/pico#664) — remove when fixed upstream
- `nav details.dropdown { display: inline-block }` — Fix Firefox full-width nav dropdowns (picocss/pico#701) — remove when fixed upstream
- `:where([role=group], [role=search]) + small` — Fix helper text not styled after input groups (picocss/pico#540, picocss/pico#700) — remove when fixed upstream
- `[data-tooltip] { display: inline-block }` — Fix tooltip mispositioned on inline elements in Chromium (picocss/pico#678) — remove when fixed upstream
- `[data-tooltip]::before/::after` use `--mu-inverted-background`/`--mu-inverted-color` instead of themed contrast — PicoCSS contrast is theme-dependent in µCSS, not always readable as tooltip background
- `[data-tooltip]::before { white-space: pre-line; width: max-content; max-width: 20rem }` — Fix tooltip overflow on long text, support explicit line breaks, comfortable width (picocss/pico#665, picocss/pico#715) — remove when fixed upstream
- `details.dropdown details.dropdown[open] > summary::before { display: none }` — Fix nested dropdowns blocking parent clicks (picocss/pico#614) — remove when fixed upstream
- `small { font-size: var(--mu-font-size) }` — Fix `<small>` font-size not applied (picocss/pico#561) — remove when fixed upstream
- `code, kbd, samp { padding: 0.125rem 0.375rem }` — Fix inline code vertical padding too thick (picocss/pico#651) — remove when fixed upstream
- PicoCSS sets `:where(table) { width: 100% }` — all tables are fullwidth by default, no `.table-fullwidth` class needed
- PicoCSS `.outline` button style (3 colors) coexists with µCSS `.btn-outline` (11 colors) — different selectors, no conflict
