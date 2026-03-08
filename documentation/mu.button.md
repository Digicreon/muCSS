# µButton

**µButton** is a button component, part of the [µCSS](.) framework. It provides 11 color roles in filled and outline variants, a link style, three sizes, and works on both `<button>` and `<a>` elements.

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

## Filled variants (11 colors)

All 11 color roles are available as filled buttons:

```html
<button class="btn btn-primary">Primary</button>
<button class="btn btn-secondary">Secondary</button>
<button class="btn btn-tertiary">Tertiary</button>
<button class="btn btn-contrast">Contrast</button>
<button class="btn btn-success">Success</button>
<button class="btn btn-info">Info</button>
<button class="btn btn-warning">Warning</button>
<button class="btn btn-error">Error</button>
<button class="btn btn-accent">Accent</button>
<button class="btn btn-pop">Pop</button>
<button class="btn btn-spark">Spark</button>
```

Each filled button has a solid background, matching border, and an inverse text color. On hover, the background and border shift to the `-hover` variant of the color.

| Class | Background | Text color | Hover background |
|-------|-----------|------------|-----------------|
| `.btn-primary` | `--mu-primary` | `--mu-primary-inverse` | `--mu-primary-hover` |
| `.btn-secondary` | `--mu-secondary` | `--mu-secondary-inverse` | `--mu-secondary-hover` |
| `.btn-tertiary` | `--mu-tertiary` | `--mu-tertiary-inverse` | `--mu-tertiary-hover` |
| `.btn-contrast` | `--mu-contrast` | `--mu-contrast-inverse` | `--mu-contrast-hover` |
| `.btn-success` | `--mu-success` | `--mu-success-inverse` | `--mu-success-hover` |
| `.btn-info` | `--mu-info` | `--mu-info-inverse` | `--mu-info-hover` |
| `.btn-warning` | `--mu-warning` | `--mu-warning-inverse` | `--mu-warning-hover` |
| `.btn-error` | `--mu-error` | `--mu-error-inverse` | `--mu-error-hover` |
| `.btn-accent` | `--mu-accent` | `--mu-accent-inverse` | `--mu-accent-hover` |
| `.btn-pop` | `--mu-pop` | `--mu-pop-inverse` | `--mu-pop-hover` |
| `.btn-spark` | `--mu-spark` | `--mu-spark-inverse` | `--mu-spark-hover` |

---

## Outline variant

Add `.btn-outline` alongside a color class for a transparent background with visible border and colored text:

```html
<button class="btn btn-outline btn-primary">Primary</button>
<button class="btn btn-outline btn-secondary">Secondary</button>
<button class="btn btn-outline btn-tertiary">Tertiary</button>
<button class="btn btn-outline btn-contrast">Contrast</button>
<button class="btn btn-outline btn-success">Success</button>
<button class="btn btn-outline btn-info">Info</button>
<button class="btn btn-outline btn-warning">Warning</button>
<button class="btn btn-outline btn-error">Error</button>
<button class="btn btn-outline btn-accent">Accent</button>
<button class="btn btn-outline btn-pop">Pop</button>
<button class="btn btn-outline btn-spark">Spark</button>
```

Outline buttons have `background-color: transparent`, text color matching the role, and a matching border. On hover, the background fills with the role color and the text switches to its inverse.

---

## Link style

Use `.btn-link` for a button that looks like a text link (no background, no border, underlined):

```html
<button class="btn btn-link">Link button</button>
```

The link style uses `--mu-primary` as its text color and `--mu-primary-hover` on hover.

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
<a class="btn btn-outline btn-success" href="#">Outline link</a>
<a class="btn btn-error btn-lg" href="#">Large link</a>
```

---

## CSS classes reference

| Class | Description |
|-------|-------------|
| `.btn` | Base button (inline-flex, padding, font-weight 600, border-radius, transitions) |
| `.btn-{color}` | Filled color variant (`primary`, `secondary`, `tertiary`, `contrast`, `success`, `info`, `warning`, `error`, `accent`, `pop`, `spark`) |
| `.btn-outline` | Transparent background, colored border and text |
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

- Each color variant has a dedicated `:focus-visible` outline using the `--mu-{color}-focus` variable with a `2px` outline offset.
- The `.btn-link` variant follows link color conventions for consistency with standard anchor styling.
- Use `<button>` for actions and `<a>` for navigation to maintain proper semantics.

---

> See also : [µLink](mu.link.md) · [µForms](mu.forms.md)

→ [See example](../examples/button.html)
