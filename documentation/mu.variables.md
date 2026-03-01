# µVariables

**µVariables** is the reference for CSS variables (`--mu-*`) available in [µCSS](.). All variables are defined on `:root` and can be overridden to customize the framework.

---

## Typography

| Variable | Default | Description |
|----------|---------|-------------|
| `--mu-font-family-sans-serif` | `system-ui, "Segoe UI", Roboto, Helvetica, Arial, sans-serif` | Sans-serif font stack |
| `--mu-font-family-monospace` | `ui-monospace, SFMono-Regular, "SF Mono", Menlo, Consolas, monospace` | Monospace font stack |
| `--mu-font-family` | `var(--mu-font-family-sans-serif)` | Active font |
| `--mu-font-size` | `100%` | Base size (responsive: 106.25% to 131.25%) |
| `--mu-font-weight` | `400` | Normal weight |
| `--mu-line-height` | `1.5` | Line height |
| `--mu-text-underline-offset` | `0.1rem` | Underline offset |

### Responsive sizing

The base font size increases at each breakpoint:

| Breakpoint | `--mu-font-size` |
|------------|------------------|
| < 576px | 100% |
| ≥ 576px | 106.25% |
| ≥ 768px | 112.5% |
| ≥ 1024px | 118.75% |
| ≥ 1280px | 125% |
| ≥ 1536px | 131.25% |

---

## Spacing

| Variable | Default | Description |
|----------|---------|-------------|
| `--mu-spacing` | `1rem` | Base unit (padding, margins) |
| `--mu-typography-spacing-vertical` | `1rem` | Typographic vertical spacing |
| `--mu-block-spacing-vertical` | `var(--mu-spacing)` | Vertical spacing between sections |
| `--mu-block-spacing-horizontal` | `var(--mu-spacing)` | Horizontal spacing between sections |
| `--mu-grid-column-gap` | `var(--mu-spacing)` | Grid column gutter |
| `--mu-grid-row-gap` | `var(--mu-spacing)` | Grid row gutter |

---

## Borders and outlines

| Variable | Default | Description |
|----------|---------|-------------|
| `--mu-border-radius` | `0.25rem` | Corner rounding |
| `--mu-border-width` | `0.0625rem` | Border thickness (1px) |
| `--mu-outline-width` | `0.125rem` | Focus outline thickness (2px) |

---

## Transitions

| Variable | Default | Description |
|----------|---------|-------------|
| `--mu-transition` | `0.2s ease-in-out` | Animation duration and easing |

---

## Navigation

| Variable | Default | Description |
|----------|---------|-------------|
| `--mu-nav-element-spacing-vertical` | `1rem` | Vertical padding of nav items |
| `--mu-nav-element-spacing-horizontal` | `0.5rem` | Horizontal padding of nav items |
| `--mu-nav-link-spacing-vertical` | `0.5rem` | Vertical padding of nav links |
| `--mu-nav-link-spacing-horizontal` | `0.5rem` | Horizontal padding of nav links |
| `--mu-nav-breadcrumb-divider` | `">"` | Breadcrumb separator |

---

## Forms

| Variable | Default | Description |
|----------|---------|-------------|
| `--mu-form-element-spacing-vertical` | `0.75rem` | Vertical padding of fields |
| `--mu-form-element-spacing-horizontal` | `1rem` | Horizontal padding of fields |
| `--mu-form-element-border-color` | `#cfd5e2` | Field border |
| `--mu-form-element-active-border-color` | `var(--mu-primary-border)` | Border on focus |
| `--mu-form-element-disabled-opacity` | `0.5` | Opacity of disabled fields |

---

## Base colors

These variables change between light and dark themes (see [µDark Mode](mu.dark-mode.md)).

| Variable | Light | Dark | Description |
|----------|-------|------|-------------|
| `--mu-background-color` | `#fff` | `rgb(19, 22.5, 30.5)` | Page background |
| `--mu-color` | `#373c44` | `#c2c7d0` | Main text |
| `--mu-muted-color` | `#646b79` | `#8891a4` | Secondary text |
| `--mu-muted-border-color` | `rgb(231, 234, 239.5)` | `rgb(48, 54.5, 69)` | Subtle borders |
| `--mu-text-selection-color` | `rgba(2, 154, 232, 0.25)` | `rgba(1, 170, 255, 0.1875)` | Selection highlight |

---

## Role colors

8 color roles, each providing 7 variants. Values depend on the theme (see `build/mu.theme.json`).

### Variants per role

For each role (`primary`, `secondary`, `tertiary`, `contrast`, `success`, `info`, `warning`, `error`):

| Suffix | Description |
|--------|-------------|
| *(base)* | Main color of the role |
| `-background` | Colored background (light tint in light mode, dark tint in dark mode) |
| `-hover` | Hover color |
| `-hover-background` | Hover background |
| `-focus` | Focus ring color (semi-transparent) |
| `-inverse` | Text on colored background (`#fff` or `#000`) |
| `-underline` | Semi-transparent underline |

### Example

```css
.custom-element {
    color: var(--mu-primary);
    background-color: var(--mu-primary-background);
    border: 1px solid var(--mu-primary);
}

.custom-element:hover {
    color: var(--mu-primary-hover);
    background-color: var(--mu-primary-hover-background);
}
```

---

## Headings

| Variable | Description |
|----------|-------------|
| `--mu-h1-color` | `<h1>` color |
| `--mu-h2-color` | `<h2>` color |
| `--mu-h3-color` | `<h3>` color |
| `--mu-h4-color` | `<h4>` color |
| `--mu-h5-color` | `<h5>` color |
| `--mu-h6-color` | `<h6>` color |

Each heading level uses a slightly lighter shade than the previous one.

---

## Components

### Code

| Variable | Description |
|----------|-------------|
| `--mu-code-background-color` | Background of `<code>`, `<pre>`, `<samp>` elements |
| `--mu-code-color` | Code text |
| `--mu-code-kbd-background-color` | Background of `<kbd>` |
| `--mu-code-kbd-color` | Text of `<kbd>` |

### Card

| Variable | Description |
|----------|-------------|
| `--mu-card-background-color` | Card background |
| `--mu-card-border-color` | Card border |
| `--mu-card-box-shadow` | Card shadow |
| `--mu-card-sectioning-background-color` | Header/footer background |

### Table

| Variable | Description |
|----------|-------------|
| `--mu-table-border-color` | Table border |
| `--mu-table-row-stripped-background-color` | Striped row background |

### Accordion

| Variable | Description |
|----------|-------------|
| `--mu-accordion-border-color` | Accordion border |
| `--mu-accordion-active-summary-color` | Active title color |
| `--mu-accordion-close-summary-color` | Closed title color |
| `--mu-accordion-open-summary-color` | Open title color |

### Dropdown

| Variable | Description |
|----------|-------------|
| `--mu-dropdown-background-color` | Menu background |
| `--mu-dropdown-border-color` | Menu border |
| `--mu-dropdown-color` | Menu text |
| `--mu-dropdown-hover-background-color` | Hover background |
| `--mu-dropdown-box-shadow` | Menu shadow |

### Progress

| Variable | Description |
|----------|-------------|
| `--mu-progress-background-color` | Bar background |
| `--mu-progress-color` | Progress color |

### Tooltip

| Variable | Description |
|----------|-------------|
| `--mu-tooltip-background-color` | Tooltip background |
| `--mu-tooltip-color` | Tooltip text |

### Switch

| Variable | Description |
|----------|-------------|
| `--mu-switch-background-color` | Unchecked background |
| `--mu-switch-checked-background-color` | Checked background |
| `--mu-switch-color` | Thumb color |

### Range

| Variable | Description |
|----------|-------------|
| `--mu-range-border-color` | Track border |
| `--mu-range-active-border-color` | Active border |
| `--mu-range-thumb-color` | Thumb color |
| `--mu-range-thumb-active-color` | Active thumb |

### Blockquote

| Variable | Description |
|----------|-------------|
| `--mu-blockquote-border-color` | Quote border |
| `--mu-blockquote-footer-color` | Quote footer color |

### Modal

| Variable | Description |
|----------|-------------|
| `--mu-modal-overlay-background-color` | Overlay background |
| `--mu-modal-overlay-backdrop-filter` | Blur filter (`blur(0.375rem)`) |

### Buttons

| Variable | Description |
|----------|-------------|
| `--mu-button-box-shadow` | Button shadow |
| `--mu-button-hover-box-shadow` | Hover shadow |

### Shadows

| Variable | Description |
|----------|-------------|
| `--mu-box-shadow` | Default shadow (used by cards, dropdowns) |

---

## Global override

To customize the framework, override the variables on `:root`:

```css
:root {
    --mu-font-family: "Inter", sans-serif;
    --mu-border-radius: 0.5rem;
    --mu-spacing: 1.25rem;
    --mu-primary: #e63946;
}
```

For theme-specific overrides, target the corresponding selectors (see [µDark Mode](mu.dark-mode.md)).

---

> See also : [µDark Mode](mu.dark-mode.md) · [µContainer](mu.container.md) · [µGrid](mu.grid.md)
