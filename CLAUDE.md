# CLAUDE.md — µCSS Project Instructions

## Project overview

µCSS is a CSS framework derived from PicoCSS v2 (MIT), part of the Temma-UI project. Version 2.0 (branch `v2`) makes it fully standalone: the Pico code now lives in µCSS source files. All tooling is PHP (no Node.js). CSS files are plain CSS (no preprocessor).

## Key files

- `build/mu-build.php` — Main build script, generates themed CSS files into `dist/`
- `build/mu.manifest.json`: ordered list of the CSS files concatenated by the build (`@colors` marks where the generated theme colors go); the order decides the cascade (tooltip must precede button and modal; the grid must follow the forms; nav must follow mu.colors and hero, breadcrumb must follow nav; accordion precedes nav, and has more specific rules for what it keeps inside it; card must follow modal and dropdown; mu.utilities comes last); every `css/mu.*.css` file must be listed
- `build/mu-color-gen.php` — Color generator, reads PicoCSS palette + theme → CSS variables
- `build/mu.theme.json` — Array of 20 theme definitions (one per PicoCSS color)
- `build/mu-compat.php`: reports CSS features that break the 2.0 browser baseline (Chrome 49+, Firefox 31+, Safari 10+, Edge 16+); `--strict` fails
- `build/pico.colors.css`: Pico palette, still read by `mu-color-gen.php` until the new palette exists
- `tests/visual/mu-visual.php`: visual regression tool (captures every example page in light/dark at 390/768/1280/1536 px with headless Chrome, compares two sets); captures in `tests/visual/shots/` (git-ignored)
- `css/mu.base.css`: root variables, document, landmarks, embedded content
- `css/mu.scheme.css`: surface and element colors for light/dark modes (temporary, moves to the theme generator)
- `css/mu.typography.css`, `css/mu.links.css`, `css/mu.code.css`: text elements
- `css/mu.forms.css`, `css/mu.forms.checkbox.css`, `css/mu.forms.range.css`: form elements, groups, field classes
- `css/mu.accessibility.css`: interaction cursors, reduced motion
- `css/mu.grid.css`: `.container` / `.container-fluid` and the 12-column responsive grid (breakpoints: sm 576px, md 768px, lg 1024px, xl 1280px, xxl 1536px)
- `css/mu.colors.css`: color utility classes (`.c-*`, `.bg-*`, `.border-*`)
- `css/mu.utilities.css`: display, positioning and cursor utilities (`.d-*`, `.sticky-top`, `.fixed-top`, `.fixed-bottom`, `.clickable`)
- `css/mu.component.*.css`: one file per component, native element styles and µCSS classes together (accordion, alert, badge, breadcrumb, button, card, dropdown, hero, loading, modal, nav, pagination, progress, skeleton, spinner, table, tabs, toast, tooltip)
- Code derived from Pico CSS keeps its copyright notice in the file header ("Portions derived from Pico CSS v2.1.1")
- `dist/` — Build output (21 CSS files: `mu.css` + 20 `mu.{color}.css`)
- `examples/` — HTML demos (49 files: index + 19 component pages + 9 native element pages + 20 theme recap pages)
- `README.md` — Project documentation with installation, components, grid, dark mode, build

## Build commands

```bash
php build/mu-build.php              # Build all 20 themes → dist/
php build/mu-build.php --list       # List themes and base files
php build/mu-build.php --no-minify  # Readable output (minified by default)
php build/mu-build.php --output=f   # Backward compat: single theme → file
php build/mu-compat.php [--verbose]  # Browser baseline report (on a readable build)
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

## Design choices

Choices that differ from Pico CSS, the code µCSS is derived from. The former Pico bug fixes are now part of the modules, in the original rule or next to it (Pico issue numbers are in `DECISIONS.md`):

- Cards: the last content element of an `article` has no bottom margin; colored cards shade their `header`/`footer` with `color-mix()`
- `.tabs li { list-style: none }` and `.breadcrumb li` / `.breadcrumb li a` reset the generic list and nav spacing
- `.table-hover` / `.table-striped` color `th`/`td`, not `tr` (cells have their own `background-color`); `.table-bordered` uses a `color-mix()` blend for lighter borders
- Tables are full width by default (`:where(table) { width: 100% }`), no `.table-fullwidth` class
- `nav a { text-decoration: none }`, even on hover; nav/header with `.bg-*` get a gradient via `color-mix(in oklch)` (same as hero)
- Nested lists have no bottom margin
- `:where(nav li)::before` uses a plain space without float (the float broke dropdown text in Safari 18.2+)
- `nav details.dropdown { display: inline-block }` (full-width nav dropdowns in Firefox)
- Helper text (`<small>`) after a `[role=group]` / `[role=search]` is styled like after a field
- Tooltips: `[data-tooltip]` is `inline-block` (Chromium misplaced inline ones); they use `--mu-inverted-background` / `--mu-inverted-color` (the themed contrast color is not always readable); text wraps (`white-space: pre-line`, explicit line breaks allowed) up to `max-width: 20rem`
- Busy element with a tooltip: the loading indicator takes the place of the tooltip (both use `::before`)
- Classes that should not be mixed on the same element (`.btn.badge`, `.modal-close.col-6`...) are not handled
- Nested dropdowns: the inner one has no click-catching overlay (it covered the outer menu)
- `small` applies `font-size: var(--mu-font-size)` (0.875em)
- Inline `code, kbd, samp` padding: `0.125rem 0.375rem`
- The Pico `.outline` button style (3 colors) still coexists with `.btn-outline` (11 colors) until the button rework
