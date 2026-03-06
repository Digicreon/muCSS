# µToast

**µToast** is a fixed-position notification wrapper, part of the [µCSS](.) framework. It uses the existing [alert](mu.alert.md) component for content styling and adds 6 positioning options.

---

## Basic usage

Wrap an `.alert` inside a `.toast` container with a position class:

```html
<div class="toast toast-top-right">
    <div class="alert alert-success" role="alert">
        <p>Changes saved.</p>
    </div>
</div>
```

---

## Positions

6 position classes are available:

```html
<div class="toast toast-top-right">...</div>
<div class="toast toast-top-left">...</div>
<div class="toast toast-top-center">...</div>
<div class="toast toast-bottom-right">...</div>
<div class="toast toast-bottom-left">...</div>
<div class="toast toast-bottom-center">...</div>
```

| Class | Placement |
|-------|-----------|
| `.toast-top-right` | `top: 1rem; right: 1rem` |
| `.toast-top-left` | `top: 1rem; left: 1rem` |
| `.toast-top-center` | `top: 1rem; left: 50%; transform: translateX(-50%)` |
| `.toast-bottom-right` | `bottom: 1rem; right: 1rem` |
| `.toast-bottom-left` | `bottom: 1rem; left: 1rem` |
| `.toast-bottom-center` | `bottom: 1rem; left: 50%; transform: translateX(-50%)` |

---

## Color variants

Toasts reuse the alert color variants. All 11 color roles are available:

```html
<div class="toast toast-top-right">
    <div class="alert alert-primary" role="alert"><p>Primary toast.</p></div>
</div>

<div class="toast toast-top-right">
    <div class="alert alert-error" role="alert"><p>Error toast.</p></div>
</div>
```

Available variants: `alert-primary`, `alert-secondary`, `alert-tertiary`, `alert-contrast`, `alert-accent`, `alert-success`, `alert-info`, `alert-warning`, `alert-error`, `alert-pop`, `alert-spark`.

---

## With title

Use `.alert-title` for a bold heading inside the toast:

```html
<div class="toast toast-top-right">
    <div class="alert alert-success" role="alert">
        <span class="alert-title">Saved!</span>
        <p>Your changes have been saved.</p>
    </div>
</div>
```

---

## Dismissible

Add `.alert-dismissible` and an `.alert-close` button:

```html
<div class="toast toast-top-right">
    <div class="alert alert-info alert-dismissible" role="alert">
        <p>This toast can be dismissed.</p>
        <button class="alert-close" aria-label="Close" onclick="this.closest('.toast').remove()">&times;</button>
    </div>
</div>
```

---

## CSS classes reference

| Class | Description |
|-------|-------------|
| `.toast` | Fixed-position wrapper (`position: fixed`, `z-index: 1050`, `max-width: 350px`) |
| `.toast-top-right` | Position top-right |
| `.toast-top-left` | Position top-left |
| `.toast-top-center` | Position top-center |
| `.toast-bottom-right` | Position bottom-right |
| `.toast-bottom-left` | Position bottom-left |
| `.toast-bottom-center` | Position bottom-center |

---

## Responsive behavior

On viewports narrower than 640px, all toast positions switch to full-width (`left: 1rem; right: 1rem; max-width: none`) to avoid content overflow on mobile devices.

---

## Styling details

| Property | Value |
|----------|-------|
| Position | `fixed` |
| Z-index | `1050` |
| Max-width | `350px` (none on mobile) |
| Spacing from edge | `1rem` |

---

## Accessibility

- Use `role="alert"` on the inner alert element so screen readers announce the notification.
- Dismissible toasts should include `aria-label="Close"` on the close button.
- Auto-dismiss timing (e.g. 4 seconds) is the application's JS responsibility — µCSS provides only the CSS positioning.

---

> See also : [µAlert](mu.alert.md)

→ [See example](../examples/toast.html)
