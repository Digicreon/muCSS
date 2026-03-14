# µCSS

Full-featured themeable CSS framework built on [PicoCSS v2](https://picocss.com/).

## Features

- **20 color themes** — One CSS file per theme, ready to use
- **12-column responsive grid** — 6 breakpoints, offsets, ordering, display utilities
- **17 UI components** — Accordion, Alert, Badge, Breadcrumb, Button, Card, Forms, Hero, Modal, Nav, Pagination, Progress, Skeleton, Spinner, Table, Toast, Tabs
- **Utility classes** — Color (text, background, border), positioning (sticky, fixed)
- **Dark mode** — Automatic (prefers-color-scheme) or manual (`data-theme`)
- **Pure CSS** — No JavaScript dependency
- **PHP tooling** — Build and theming via PHP scripts, no Node.js/SASS required

## Installation

### CDN (jsDelivr)

```html
<!-- Default theme (azure) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@digicreon/mucss/dist/mu.css">

<!-- Or pick a specific color theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@digicreon/mucss/dist/mu.violet.css">
```

### npm

```bash
npm install @digicreon/mucss
```

### Local

```html
<!-- Default theme (azure) -->
<link rel="stylesheet" href="dist/mu.css">

<!-- Or pick a specific color theme -->
<link rel="stylesheet" href="dist/mu.violet.css">
```

Each file is self-contained (PicoCSS base + colors + grid + all components).

## Available themes

| | | | |
|---|---|---|---|
| azure (default) | red | pink | fuchsia |
| purple | violet | indigo | blue |
| cyan | jade | green | lime |
| yellow | amber | pumpkin | orange |
| sand | grey | zinc | slate |

## µCSS components

| Component | Description | Example |
|-----------|-------------|---------|
| Accordion | Collapsible sections using `<details>` | [accordion.html](examples/accordion.html) |
| Alert | Notification banners, 11 colors, dismissible | [alert.html](examples/alert.html) |
| Badge | Inline labels, pills, outline, attached | [badge.html](examples/badge.html) |
| Breadcrumb | Navigation trail, 4 separator styles, boxed | [breadcrumb.html](examples/breadcrumb.html) |
| Button | 11 colors, outline, link, 3 sizes | [button.html](examples/button.html) |
| Card | Colored `<article>` with header/footer | [card.html](examples/card.html) |
| Forms | Input sizes (sm/lg) and validation states | [forms.html](examples/forms.html) |
| Hero | Full-width hero sections, 11 colors, gradient | [hero.html](examples/hero.html) |
| Modal | Dialog sizes (sm/default/lg/fullscreen) | [modal.html](examples/modal.html) |
| Nav | Responsive navbar, burger menu, colored, sticky/fixed | [nav.html](examples/nav.html) |
| Pagination | Aligned, sized, borderless, responsive | [pagination.html](examples/pagination.html) |
| Progress | Colored progress bars | [progress.html](examples/progress.html) |
| Skeleton | Loading placeholders, text, title, avatar, image | [skeleton.html](examples/skeleton.html) |
| Spinner | Loading spinners, 11 colors, 3 sizes | [spinner.html](examples/spinner.html) |
| Table | Hover, striped, bordered, compact | [table.html](examples/table.html) |
| Toast | Fixed-position notifications, 6 positions, 11 colors | [toast.html](examples/toast.html) |
| Tabs | Standard, pills, aligned, fullwidth | [tabs.html](examples/tabs.html) |

## PicoCSS native

| Component | Description | Example |
|-----------|-------------|---------|
| Typography | Headings, blockquote, lists, code, kbd, mark | [typography.html](examples/typography.html) |
| Tooltip | `data-tooltip` with 4 placements | [tooltip.html](examples/tooltip.html) |
| Dropdown | `<details class="dropdown">` menus | [dropdown.html](examples/dropdown.html) |
| Group | Input/button groups via `role="group"` | [group.html](examples/group.html) |
| Loading | Loading states via `aria-busy="true"` | [loading.html](examples/loading.html) |
| Switch | Toggle switches via `<input role="switch">` | [switch.html](examples/switch.html) |
| Checkbox & Radio | Checkboxes, radios, indeterminate, validation | [checkbox-radio.html](examples/checkbox-radio.html) |
| Range | Range sliders with output | [range.html](examples/range.html) |
| Forms (advanced) | Color, date, time, file, search, helper text | [forms-advanced.html](examples/forms-advanced.html) |

## Grid

Flexbox 12-column grid with 6 breakpoints:

| Breakpoint | Prefix | Min-width |
|------------|--------|-----------|
| Default | `col-` | 0 |
| Small | `col-sm-` | 576px |
| Medium | `col-md-` | 768px |
| Large | `col-lg-` | 1024px |
| Extra-large | `col-xl-` | 1280px |
| Extra-extra-large | `col-xxl-` | 1536px |

```html
<div class="row">
  <div class="col-12 col-md-6 col-lg-4">Responsive column</div>
  <div class="col-12 col-md-6 col-lg-8">Responsive column</div>
</div>
```

Offsets (`offset-{n}`, `offset-md-{n}`...), ordering (`order-first`, `order-md-2`...) and display utilities (`d-none`, `d-md-block`...) are included.

See [grid example](examples/grid.html).

## Utilities

### Color classes

33 utility classes for text, background, and border colors:

- `.c-{role}` — text color (`.c-primary`, `.c-success`, …)
- `.bg-{role}` — background color with automatic inverse text and link color
- `.border-{role}` — border color
- `.c-inverse` — white/black text for use on filled backgrounds

On `<nav>` or its parent (e.g. `<header>`), `.bg-*` classes also apply a gradient.

### Positioning

| Class | Effect |
|-------|--------|
| `.sticky-top` | Sticks to top on scroll (stays in flow) |
| `.fixed-top` | Fixed to viewport top (out of flow) |
| `.fixed-bottom` | Fixed to viewport bottom (out of flow) |

On `<nav>`, these classes automatically add `z-index` and `box-shadow`.

## Dark mode

µCSS supports three modes:

```html
<!-- Automatic (follows OS preference) -->
<html>

<!-- Force light -->
<html data-theme="light">

<!-- Force dark -->
<html data-theme="dark">
```

## Build

Requires PHP. No other dependencies.

```bash
php build/mu-build.php              # Build all 20 themes into dist/
php build/mu-build.php --minify     # Build minified
php build/mu-build.php --list       # List themes and base files
```

## Project structure

```
mucss/
  build/
    mu-build.php          # Build script
    mu-color-gen.php      # Color variable generator
    mu.theme.json         # 20 theme definitions
    pico.css              # PicoCSS v2 base (external)
    pico.colors.css       # PicoCSS palette (external)
  css/
    mu.grid.css           # 12-column grid
    mu.colors.css         # Color utility classes
    mu.utilities.css      # Positioning utilities (sticky, fixed)
    mu.component.*.css    # UI components (17 files)
  dist/                   # Build output (21 CSS files)
  documentation/          # Component and feature documentation
  examples/               # HTML demos for each component
```

## Color roles

Each theme maps 11 semantic roles to PicoCSS color families:

**primary** · **secondary** · **tertiary** · **contrast** · **accent** · **success** · **info** · **warning** · **error** · **pop** · **spark**

> `pop` and `spark` are derived roles — `pop` uses the same color family as `accent` with lighter shades, and `spark` uses the same color family as `contrast` with lighter shades. They do not appear in the theme JSON.

µCSS also provides utility classes for color and positioning — see [Utilities](#utilities).

## License

See [LICENSE](LICENSE).
