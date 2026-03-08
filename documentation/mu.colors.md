# µColors

**µColors** describes the color system in [µCSS](.). The framework provides 11 semantic color roles, each with 7 CSS variable variants, color classes for the main visual components, and utility classes for text, background, and border colors.

---

## Color roles

µCSS defines 11 color roles. Each role is mapped to a color family via the theme file (`build/mu.theme.json`).

| Role | Purpose |
|------|---------|
| `primary` | Main action color — links, buttons, active states |
| `secondary` | Supporting color — secondary buttons, muted elements |
| `tertiary` | Accent color — additional highlights |
| `contrast` | High-contrast color — strong emphasis |
| `accent` | Eye-catching color — chromatically distant from primary |
| `success` | Positive feedback — validation, confirmations |
| `info` | Informational — notices, tips |
| `warning` | Caution — alerts requiring attention |
| `error` | Negative feedback — errors, destructive actions |
| `pop` | Lighter variant of accent — derived from the accent color family with brighter shades |
| `spark` | Lighter variant of contrast — derived from the contrast color family with brighter shades |

> **Note:** `pop` and `spark` are derived roles — `pop` uses the same color family as `accent`, and `spark` uses the same color family as `contrast`, both with lighter shade values. They do not appear in the theme JSON.

---

## CSS variables per role

Each role generates 7 CSS variables, automatically adapted for light and dark modes:

| Variable | Description |
|----------|-------------|
| `--mu-{role}` | Base color |
| `--mu-{role}-background` | Tinted background (light tint in light mode, dark tint in dark mode) |
| `--mu-{role}-hover` | Hover state color |
| `--mu-{role}-hover-background` | Hover background |
| `--mu-{role}-focus` | Focus ring color (semi-transparent) |
| `--mu-{role}-inverse` | Text color on a filled background (`#fff` or `#000`) |
| `--mu-{role}-underline` | Semi-transparent underline |

### Example

```css
.custom-banner {
    color: var(--mu-info);
    background-color: var(--mu-info-background);
    border-left: 4px solid var(--mu-info);
}

.custom-banner:hover {
    color: var(--mu-info-hover);
}
```

---

## Utility classes

µCSS provides 34 utility classes in `css/mu.colors.css`:

### Text color

| Class | Effect |
|-------|--------|
| `.c-primary` … `.c-spark` | Sets `color` to the role's base color |

### Text color (inverse)

| Class | Effect |
|-------|--------|
| `.c-inverse` | Sets `color` to the primary inverse color (white or black, for readable text on filled backgrounds) |

### Background color

| Class | Effect |
|-------|--------|
| `.bg-primary` … `.bg-spark` | Sets `background-color` to the role's base color, `color` to inverse (white/black), and links inherit the inverse color |

### Border color

| Class | Effect |
|-------|--------|
| `.border-primary` … `.border-spark` | Sets `border-color` to the role's base color |

```html
<p class="c-error">Red text</p>
<div class="bg-accent">Accent background — text and links are automatically white</div>
<div class="border-success" style="border:2px solid">Green border</div>
```

> **Note:** On `<nav>` or on a parent of `<nav>` (e.g. `<header>`), `.bg-*` classes also apply a gradient (same as [µHero](mu.hero.md)). See [µNav](mu.nav.md#colored-navbars).

---

## Color classes by component

The following components accept color classes for all 11 roles:

### Button

Filled buttons use the role color as background. Outline buttons use it as text and border only.

| Class | Style |
|-------|-------|
| `.btn-primary` … `.btn-spark` | Filled background with inverse text |
| `.btn-outline.btn-primary` … `.btn-outline.btn-spark` | Transparent background, colored text and border |
| `.btn-link` | Link appearance using primary color |

```html
<button class="btn btn-success">Save</button>
<button class="btn btn-outline btn-error">Delete</button>
<button class="btn btn-accent">Highlight</button>
<button class="btn btn-pop">Pop action</button>
<button class="btn btn-spark">Spark action</button>
```

### Alert

```html
<div class="alert alert-warning">Caution: this action cannot be undone.</div>
```

| Class | Style |
|-------|-------|
| `.alert-primary` … `.alert-spark` | Colored text, tinted background |

### Badge

Solid badges use the role color as background. Outline badges use it as text and border only.

```html
<span class="badge badge-success">Active</span>
<span class="badge badge-outline badge-error">Expired</span>
```

| Class | Style |
|-------|-------|
| `.badge-primary` … `.badge-spark` | Filled background with inverse text |
| `.badge-outline.badge-primary` … `.badge-outline.badge-spark` | Transparent background, colored text and border |

### Card

```html
<article class="card-info">
    <header>Note</header>
    <p>Card content with a colored left border and tinted background.</p>
</article>
```

| Class | Style |
|-------|-------|
| `.card-primary` … `.card-spark` | Tinted background, shaded header/footer |

### Hero

```html
<section class="hero hero-primary">
    <h1>Welcome</h1>
</section>
```

| Class | Style |
|-------|-------|
| `.hero-primary` … `.hero-spark` | Gradient background with inverse text |

### Spinner

```html
<div class="spinner spinner-success"></div>
```

| Class | Style |
|-------|-------|
| `.spinner-primary` … `.spinner-spark` | Colored spinning border |

### Progress

```html
<progress class="progress-success" value="75" max="100"></progress>
```

| Class | Style |
|-------|-------|
| `.progress-primary` … `.progress-spark` | Colored progress bar |

### Forms

Form validation uses a subset of roles:

| Class | Style |
|-------|-------|
| `.input-success` | Green border and focus ring |
| `.input-warning` | Amber border and focus ring |
| `aria-invalid="true"` | Red border and focus ring (built-in) |

---

## Link color variants

Links support 3 color variants via CSS classes:

```html
<a href="#">Primary link (default)</a>
<a href="#" class="secondary">Secondary link</a>
<a href="#" class="contrast">Contrast link</a>
```

| Class | Color variable |
|-------|----------------|
| *(default)* | `--mu-primary` |
| `.secondary` | `--mu-secondary` |
| `.contrast` | `--mu-contrast` |

---

## Components with implicit colors

These components use color roles internally but do not expose color classes:

| Component | Colors used |
|-----------|-------------|
| Pagination | `--mu-primary` (active), `--mu-secondary` (borders, disabled) |
| Tabs | `--mu-primary` (active tab), `--mu-secondary` (inactive) |
| Breadcrumb | `--mu-primary` (links), `--mu-secondary` (dividers, last item) |
| Accordion | `--mu-secondary-background` (borders) |
| Table | `--mu-secondary-background` (stripes, hover, borders) |
| Skeleton | `--mu-secondary-background` (placeholder background) |
| Modal | `--mu-secondary` (close button) |
| Toast | Inherits alert colors via `.alert-{role}` |

---

## Base theme colors

These variables define the overall page appearance and adapt between light and dark modes:

| Variable | Light | Dark |
|----------|-------|------|
| `--mu-background-color` | `#fff` | `rgb(19, 22.5, 30.5)` |
| `--mu-color` | `#373c44` | `#c2c7d0` |
| `--mu-muted-color` | `#646b79` | `#8891a4` |
| `--mu-muted-border-color` | `rgb(231, 234, 239.5)` | `rgb(48, 54.5, 69)` |
| `--mu-mark-background-color` | `rgb(252.5, 230.5, 191.5)` | `rgb(252.5, 230.5, 191.5)` |
| `--mu-h1-color` … `--mu-h6-color` | Graded shades from dark to muted | Graded shades from light to muted |

The full variable reference is available in [µVariables](mu.variables.md).

---

## Pre-built themes

µCSS includes 20 pre-built color themes, each generating a dedicated CSS file (`mu.{name}.css`). The default theme is **azure** (`mu.css`).

Each theme is named after its `primary` color family and remaps the 11 roles accordingly. Most themes share the same defaults for secondary (slate), tertiary (sand), success (green), info (cyan), warning (amber), and error (red) — the `primary`, `contrast`, and `accent` roles vary per theme. The `pop` role always derives from `accent` with lighter shades, and the `spark` role always derives from `contrast` with lighter shades.

Available themes: **azure** (default), **red**, **pink**, **fuchsia**, **purple**, **violet**, **indigo**, **blue**, **cyan**, **jade**, **green**, **lime**, **yellow**, **amber**, **pumpkin**, **orange**, **sand**, **grey**, **zinc**, **slate**.

To use a theme, load its CSS file instead of the default:

```html
<link rel="stylesheet" href="dist/mu.pink.css">
```

Themes are defined in `build/mu.theme.json`. Each entry maps the 9 configurable roles (all except `pop` and `spark`) to color families from a palette of 20 colors.

---

## Customization

Override role colors on `:root` to change them globally:

```css
:root {
    --mu-primary: #e63946;
    --mu-primary-hover: #c5303b;
    --mu-primary-focus: rgba(230, 57, 70, 0.375);
    --mu-primary-inverse: #fff;
}
```

For theme-based color generation, edit `build/mu.theme.json` and rebuild:

```json
{
    "primary": "red",
    "secondary": "slate",
    "tertiary": "sand",
    "contrast": "indigo",
    "accent": "jade",
    "success": "green",
    "info": "azure",
    "warning": "amber",
    "error": "pink"
}
```

```bash
php build/mu-build.php
```

---

> See also : [µVariables](mu.variables.md) · [µDark Mode](mu.dark-mode.md) · [µButton](mu.button.md) · [µAlert](mu.alert.md)

→ [See example](../examples/colors.html)
