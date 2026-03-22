# CLAUDE.md — µCSS Project Instructions

## Project overview

µCSS is a CSS framework built on PicoCSS v2, part of the Temma-UI project. All tooling is PHP (no Node.js). CSS files are plain CSS (no preprocessor).

## Key files

- `build/mu-build.php` — Main build script, generates themed CSS files into `dist/`
- `build/mu-color-gen.php` — Color generator, reads PicoCSS palette + theme → CSS variables
- `build/mu.theme.json` — Array of 20 theme definitions (one per PicoCSS color)
- `build/pico.css`, `build/pico.colors.css` — PicoCSS v2 base (external, do not modify)
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
```

## Conventions

- Respond in **French** to the user
- Keep responses **concise and factual**
- All CSS variables use the `--mu-` prefix (PicoCSS `--pico-` vars are renamed at build time)
- Components follow naming pattern `mu.component.{name}.css`
- 11 color roles: primary, secondary, tertiary, contrast, accent, success, info, warning, error, pop, spark
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
- `nav details.dropdown { display: inline-block }` — Fix Firefox full-width nav dropdowns (picocss/pico#701) — remove when fixed upstream
- `:where([role=group], [role=search]) + small` — Fix helper text not styled after input groups (picocss/pico#540, picocss/pico#700) — remove when fixed upstream
- `[data-tooltip] { display: inline-block }` — Fix tooltip mispositioned on inline elements in Chromium (picocss/pico#678) — remove when fixed upstream
- `[data-tooltip]::before { white-space: pre-line; max-width: 20rem }` — Fix tooltip overflow on long text, support explicit line breaks (picocss/pico#665, picocss/pico#715) — remove when fixed upstream
- PicoCSS sets `:where(table) { width: 100% }` — all tables are fullwidth by default, no `.table-fullwidth` class needed
- PicoCSS `.outline` button style (3 colors) coexists with µCSS `.btn-outline` (11 colors) — different selectors, no conflict
