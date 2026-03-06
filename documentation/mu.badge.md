# µBadge

**µBadge** is an inline label and counter component, part of the [µCSS](.) framework. It supports 11 color variants, outline style, pill shape, three sizes, and an attached positioning mode for notification counters.

---

## Basic usage

Apply `.badge` along with a color variant class to a `<span>`:

```html
<span class="badge badge-primary">Primary</span>
```

The default badge (without a color class) uses `--mu-contrast` as its background color.

---

## Color variants (filled)

All 11 color roles are available:

```html
<span class="badge badge-primary">Primary</span>
<span class="badge badge-secondary">Secondary</span>
<span class="badge badge-tertiary">Tertiary</span>
<span class="badge badge-contrast">Contrast</span>
<span class="badge badge-success">Success</span>
<span class="badge badge-info">Info</span>
<span class="badge badge-warning">Warning</span>
<span class="badge badge-error">Error</span>
<span class="badge badge-accent">Accent</span>
<span class="badge badge-pop">Pop</span>
<span class="badge badge-spark">Spark</span>
```

| Class | Background | Text color | Border |
|-------|-----------|------------|--------|
| `.badge-primary` | `--mu-primary` | `--mu-primary-inverse` | `--mu-primary` |
| `.badge-secondary` | `--mu-secondary` | `--mu-secondary-inverse` | `--mu-secondary` |
| `.badge-tertiary` | `--mu-tertiary` | `--mu-tertiary-inverse` | `--mu-tertiary` |
| `.badge-contrast` | `--mu-contrast` | `--mu-contrast-inverse` | `--mu-contrast` |
| `.badge-success` | `--mu-success` | `--mu-success-inverse` | `--mu-success` |
| `.badge-info` | `--mu-info` | `--mu-info-inverse` | `--mu-info` |
| `.badge-warning` | `--mu-warning` | `--mu-warning-inverse` | `--mu-warning` |
| `.badge-error` | `--mu-error` | `--mu-error-inverse` | `--mu-error` |
| `.badge-accent` | `--mu-accent` | `--mu-accent-inverse` | `--mu-accent` |
| `.badge-pop` | `--mu-pop` | `--mu-pop-inverse` | `--mu-pop` |
| `.badge-spark` | `--mu-spark` | `--mu-spark-inverse` | `--mu-spark` |

---

## Outline variant

Add `.badge-outline` to remove the background and keep only the border and colored text:

```html
<span class="badge badge-outline badge-primary">Primary</span>
<span class="badge badge-outline badge-secondary">Secondary</span>
<span class="badge badge-outline badge-tertiary">Tertiary</span>
<span class="badge badge-outline badge-contrast">Contrast</span>
<span class="badge badge-outline badge-success">Success</span>
<span class="badge badge-outline badge-info">Info</span>
<span class="badge badge-outline badge-warning">Warning</span>
<span class="badge badge-outline badge-error">Error</span>
<span class="badge badge-outline badge-accent">Accent</span>
<span class="badge badge-outline badge-pop">Pop</span>
<span class="badge badge-outline badge-spark">Spark</span>
```

The `.badge-outline` class sets `background-color: transparent` and changes the text color to match the role color.

---

## Pill shape

Add `.badge-pill` for fully rounded corners (useful for counters and short labels):

```html
<span class="badge badge-primary badge-pill">12</span>
<span class="badge badge-success badge-pill">99+</span>
<span class="badge badge-error badge-pill">New</span>
<span class="badge badge-outline badge-info badge-pill">Beta</span>
```

---

## Sizes

Three sizes are available:

```html
<span class="badge badge-primary badge-sm">Small</span>
<span class="badge badge-primary">Default</span>
<span class="badge badge-primary badge-lg">Large</span>
```

| Class | Font size | Padding |
|-------|-----------|---------|
| `.badge-sm` | `0.6875rem` | `0.15em 0.4em` |
| *(default)* | `0.75rem` | `0.2em 0.55em` |
| `.badge-lg` | `0.875rem` | `0.3em 0.7em` |

---

## Attached (notification counter)

Use `.badge-attached` to position a badge as a notification counter on the corner of a parent element. The parent must have `position: relative`:

```html
<span style="position: relative; display: inline-block; padding: 0.5rem 1rem; border: 1px solid var(--mu-secondary-background); border-radius: 0.375rem;">
    Inbox
    <span class="badge badge-error badge-attached badge-pill">3</span>
</span>

<span style="position: relative; display: inline-block; padding: 0.5rem 1rem; border: 1px solid var(--mu-secondary-background); border-radius: 0.375rem;">
    Notifications
    <span class="badge badge-warning badge-attached badge-pill">12</span>
</span>
```

The `.badge-attached` class uses absolute positioning (`top: -0.4em; right: -0.4em`) and a pill border-radius. It has a smaller font size (`0.625rem`) and minimum dimensions of `1.2em`.

---

## As links

Badges can be rendered as `<a>` or `<button>` elements for clickable behavior:

```html
<a class="badge badge-primary" href="#">Clickable</a>
<a class="badge badge-outline badge-success" href="#">Link badge</a>
```

Link and button badges remove text-decoration, use a pointer cursor, and reduce opacity to `0.85` on hover.

---

## CSS classes reference

| Class | Description |
|-------|-------------|
| `.badge` | Base badge (inline-flex, padding, font-size, border-radius) |
| `.badge-{color}` | Color variant (`primary`, `secondary`, `tertiary`, `contrast`, `success`, `info`, `warning`, `error`, `accent`, `pop`, `spark`) |
| `.badge-outline` | Transparent background, colored text and border |
| `.badge-pill` | Fully rounded corners (`border-radius: 50rem`) |
| `.badge-sm` | Small size |
| `.badge-lg` | Large size |
| `.badge-attached` | Absolute positioning for notification counters |

---

## Styling details

| Property | Value |
|----------|-------|
| Default border radius | `0.25rem` |
| Font weight | `600` |
| Line height | `1` |
| Default font size | `0.75rem` |

---

## Accessibility

- Badges used as links should have descriptive text or `aria-label` for screen readers.
- Ensure sufficient color contrast between badge text and background (WCAG AA minimum).
- Avoid using color alone to convey meaning — pair colored badges with text labels.
- For notification badges (counts), use `aria-label` to describe the count in context (e.g., `aria-label="3 unread messages"`).

---

> See also : [µAlert](mu.alert.md) · [µButton](mu.button.md)

→ [See example](../examples/badge.html)
