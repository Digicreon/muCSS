# µButton

**µButton** is a button component, part of the [µCSS](.) framework. It provides 8 color roles in filled and ghost variants, a link style, three sizes, and works on both `<button>` and `<a>` elements.

---

## Basic usage

Apply `.btn` along with a color variant class:

```html
<button class="btn btn-primary">Primary</button>
```

The `.btn` class can also be applied to `<a>` elements to render links as buttons:

```html
<a class="btn btn-primary" href="#">Link as button</a>
```

---

## Filled variants (8 colors)

All 8 color roles are available as filled buttons:

```html
<button class="btn btn-primary">Primary</button>
<button class="btn btn-secondary">Secondary</button>
<button class="btn btn-tertiary">Tertiary</button>
<button class="btn btn-contrast">Contrast</button>
<button class="btn btn-success">Success</button>
<button class="btn btn-info">Info</button>
<button class="btn btn-warning">Warning</button>
<button class="btn btn-error">Error</button>
```

Each filled button has a solid background, matching border, and an inverse text color. On hover, the background and border shift to the `-hover` variant of the color.

| Class | Background | Text color | Hover background |
|-------|-----------|------------|-----------------|
| `.btn-primary` | `--pico-primary` | `--pico-primary-inverse` | `--pico-primary-hover` |
| `.btn-secondary` | `--pico-secondary` | `--pico-secondary-inverse` | `--pico-secondary-hover` |
| `.btn-tertiary` | `--pico-tertiary` | `--pico-tertiary-inverse` | `--pico-tertiary-hover` |
| `.btn-contrast` | `--pico-contrast` | `--pico-contrast-inverse` | `--pico-contrast-hover` |
| `.btn-success` | `--pico-success` | `--pico-success-inverse` | `--pico-success-hover` |
| `.btn-info` | `--pico-info` | `--pico-info-inverse` | `--pico-info-hover` |
| `.btn-warning` | `--pico-warning` | `--pico-warning-inverse` | `--pico-warning-hover` |
| `.btn-error` | `--pico-error` | `--pico-error-inverse` | `--pico-error-hover` |

---

## Ghost variant

Add `.btn-ghost` alongside a color class for a transparent background with visible border and colored text:

```html
<button class="btn btn-ghost btn-primary">Primary</button>
<button class="btn btn-ghost btn-secondary">Secondary</button>
<button class="btn btn-ghost btn-tertiary">Tertiary</button>
<button class="btn btn-ghost btn-contrast">Contrast</button>
<button class="btn btn-ghost btn-success">Success</button>
<button class="btn btn-ghost btn-info">Info</button>
<button class="btn btn-ghost btn-warning">Warning</button>
<button class="btn btn-ghost btn-error">Error</button>
```

Ghost buttons have `background-color: transparent`, text color matching the role, and a matching border. On hover, opacity is reduced to `0.8`.

---

## Link style

Use `.btn-link` for a button that looks like a text link (no background, no border, underlined):

```html
<button class="btn btn-link">Link button</button>
```

The link style uses `--pico-primary` as its text color and `--pico-primary-hover` on hover.

---

## Sizes

Three sizes are available:

```html
<button class="btn btn-primary btn-sm">Small</button>
<button class="btn btn-primary">Default</button>
<button class="btn btn-primary btn-lg">Large</button>
```

| Class | Font size | Padding |
|-------|-----------|---------|
| `.btn-sm` | `0.8125rem` | `0.375rem 0.625rem` |
| *(default)* | `1rem` | `0.5rem 1rem` |
| `.btn-lg` | `1.125rem` | `0.75rem 1.25rem` |

---

## As links

Any `<a>` element can use `.btn` classes to look like a button:

```html
<a class="btn btn-primary" href="#">Link as button</a>
<a class="btn btn-ghost btn-success" href="#">Ghost link</a>
<a class="btn btn-error btn-lg" href="#">Large link</a>
```

---

## CSS classes reference

| Class | Description |
|-------|-------------|
| `.btn` | Base button (inline-flex, padding, font-weight 600, border-radius, transitions) |
| `.btn-{color}` | Filled color variant (`primary`, `secondary`, `tertiary`, `contrast`, `success`, `info`, `warning`, `error`) |
| `.btn-ghost` | Transparent background, colored border and text |
| `.btn-link` | Looks like a text link (transparent, underlined, primary color) |
| `.btn-sm` | Small size |
| `.btn-lg` | Large size |

---

## Styling details

| Property | Value |
|----------|-------|
| Border radius | `0.375rem` |
| Font weight | `600` |
| Line height | `1.5` |
| Gap (for icons) | `0.5em` |
| Transition | `background-color, border-color, color` at `0.15s ease-in-out` |

---

## Accessibility

- Each color variant has a dedicated `:focus-visible` outline using the `--pico-{color}-focus` variable with a `2px` outline offset.
- The `.btn-link` variant follows link color conventions for consistency with standard anchor styling.
- Use `<button>` for actions and `<a>` for navigation to maintain proper semantics.

---

→ [Voir l'exemple](../examples/button.html)
