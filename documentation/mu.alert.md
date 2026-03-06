# µAlert

**µAlert** is a notification banner component, part of the [µCSS](.) framework. It provides 11 color variants, an optional title, inline links, and a dismissible close button.

---

## Basic usage

Apply `.alert` along with a color variant class to a `<div>`:

```html
<div class="alert alert-info">
    <p>This is an informational alert.</p>
</div>
```

---

## Color variants

All 11 color roles are available:

```html
<div class="alert alert-primary"><p>This is a <strong>primary</strong> alert.</p></div>
<div class="alert alert-secondary"><p>This is a <strong>secondary</strong> alert.</p></div>
<div class="alert alert-tertiary"><p>This is a <strong>tertiary</strong> alert.</p></div>
<div class="alert alert-contrast"><p>This is a <strong>contrast</strong> alert.</p></div>
<div class="alert alert-success"><p>This is a <strong>success</strong> alert.</p></div>
<div class="alert alert-info"><p>This is an <strong>info</strong> alert.</p></div>
<div class="alert alert-warning"><p>This is a <strong>warning</strong> alert.</p></div>
<div class="alert alert-error"><p>This is an <strong>error</strong> alert.</p></div>
<div class="alert alert-accent"><p>This is an <strong>accent</strong> alert.</p></div>
<div class="alert alert-pop"><p>This is a <strong>pop</strong> alert.</p></div>
<div class="alert alert-spark"><p>This is a <strong>spark</strong> alert.</p></div>
```

| Class | Text color | Background |
|-------|-----------|------------|
| `.alert-primary` | `--mu-primary` | `--mu-primary-background` |
| `.alert-secondary` | `--mu-secondary` | `--mu-secondary-background` |
| `.alert-tertiary` | `--mu-tertiary` | `--mu-tertiary-background` |
| `.alert-contrast` | `--mu-contrast` | `--mu-contrast-background` |
| `.alert-success` | `--mu-success` | `--mu-success-background` |
| `.alert-info` | `--mu-info` | `--mu-info-background` |
| `.alert-warning` | `--mu-warning` | `--mu-warning-background` |
| `.alert-error` | `--mu-error` | `--mu-error-background` |
| `.alert-accent` | `--mu-accent` | `--mu-accent-background` |
| `.alert-pop` | `--mu-pop` | `--mu-pop-background` |
| `.alert-spark` | `--mu-spark` | `--mu-spark-background` |

---

## With title

Add a `<span class="alert-title">` inside the alert for a bold heading:

```html
<div class="alert alert-success">
    <span class="alert-title">Operation successful</span>
    <p>Your changes have been saved. You can continue editing or return to the dashboard.</p>
</div>

<div class="alert alert-error">
    <span class="alert-title">Something went wrong</span>
    <p>Unable to process your request. Please try again later.</p>
</div>
```

The `.alert-title` is displayed as a block element with `font-weight: 700` and a small bottom margin.

---

## Dismissible alerts

Add `.alert-dismissible` to the alert and include a `.alert-close` button:

```html
<div class="alert alert-info alert-dismissible">
    <span class="alert-title">Heads up!</span>
    <p>This alert can be dismissed with the close button.</p>
    <button class="alert-close" aria-label="Close" onclick="this.parentElement.remove()">&times;</button>
</div>

<div class="alert alert-warning alert-dismissible">
    <p>A simple dismissible warning.</p>
    <button class="alert-close" aria-label="Close" onclick="this.parentElement.remove()">&times;</button>
</div>
```

- `.alert-dismissible` adds right padding (`3rem`) to make room for the close button.
- `.alert-close` is absolutely positioned on the right side of the alert, centered vertically.
- The close button inherits the alert's text color and transitions opacity on hover (0.6 to 1).

---

## With links

Links inside alerts are styled with `font-weight: 600`, inherit the alert color, and have an underline:

```html
<div class="alert alert-primary">
    <p>Check the <a href="#">documentation</a> for more details.</p>
</div>
```

---

## CSS classes reference

| Class | Description |
|-------|-------------|
| `.alert` | Base alert container (padding, border-radius, margin-bottom) |
| `.alert-{color}` | Color variant (`primary`, `secondary`, `tertiary`, `contrast`, `success`, `info`, `warning`, `error`, `accent`, `pop`, `spark`) |
| `.alert-title` | Bold title block inside the alert |
| `.alert-dismissible` | Adds right padding for the close button |
| `.alert-close` | Close button, positioned absolutely at the right |

---

## Styling details

| Property | Value |
|----------|-------|
| Padding | `0.75rem 1rem` |
| Border radius | `0.375rem` |
| Font size | `0.9375rem` |
| Margin bottom | `1rem` |
| Close button width | `3rem` |

---

## Accessibility

- Use `aria-label="Close"` on the `.alert-close` button so screen readers announce its purpose.
- The close button has a `:focus-visible` outline (`2px solid currentColor`) for keyboard navigation.
- The dismiss behavior (removing the element) is handled by application JavaScript -- µCSS provides only the CSS styling.

---

> See also : [µToast](mu.toast.md) · [µBadge](mu.badge.md)

→ [See example](../examples/alert.html)
