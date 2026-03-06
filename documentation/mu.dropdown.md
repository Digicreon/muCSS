# µDropdown

**µDropdown** provides pure CSS dropdown menus via the `<details class="dropdown">` element, styled by [µCSS](.). No JavaScript is required: opening and closing are handled natively by the browser.

---

## Basic usage

A dropdown is built with `<details class="dropdown">`. The `<summary>` serves as the trigger and the `<ul>` list contains the options.

```html
<details class="dropdown">
    <summary>Select an option</summary>
    <ul>
        <li><a href="#">Option 1</a></li>
        <li><a href="#">Option 2</a></li>
        <li><a href="#">Option 3</a></li>
    </ul>
</details>
```

---

## Button style

Add `role="button"` to the `<summary>` to give it the appearance of a button.

```html
<details class="dropdown">
    <summary role="button">Actions</summary>
    <ul>
        <li><a href="#">Edit</a></li>
        <li><a href="#">Duplicate</a></li>
        <li><a href="#">Archive</a></li>
        <li><a href="#">Delete</a></li>
    </ul>
</details>
```

---

## Native variants

µCSS provides style variants via classes on the `<summary role="button">`:

| Class | Appearance |
|-------|------------|
| *(none)* | Primary (default) |
| `.secondary` | Secondary |
| `.contrast` | Contrast |
| `.outline` | Outline |

```html
<details class="dropdown">
    <summary role="button">Primary</summary>
    <ul>
        <li><a href="#">Item A</a></li>
        <li><a href="#">Item B</a></li>
    </ul>
</details>

<details class="dropdown">
    <summary role="button" class="secondary">Secondary</summary>
    <ul>
        <li><a href="#">Item A</a></li>
        <li><a href="#">Item B</a></li>
    </ul>
</details>

<details class="dropdown">
    <summary role="button" class="contrast">Contrast</summary>
    <ul>
        <li><a href="#">Item A</a></li>
        <li><a href="#">Item B</a></li>
    </ul>
</details>

<details class="dropdown">
    <summary role="button" class="outline">Outline</summary>
    <ul>
        <li><a href="#">Item A</a></li>
        <li><a href="#">Item B</a></li>
    </ul>
</details>
```

---

## µCSS color variants

µCSS extends dropdowns with `.btn-*` classes on the `<summary>` for the 11 color roles:

| Class | Color |
|-------|-------|
| `.btn-primary` | Primary |
| `.btn-secondary` | Secondary |
| `.btn-tertiary` | Tertiary |
| `.btn-contrast` | Contrast |
| `.btn-accent` | Accent |
| `.btn-success` | Success |
| `.btn-info` | Info |
| `.btn-warning` | Warning |
| `.btn-error` | Error |
| `.btn-pop` | Pop |
| `.btn-spark` | Spark |

```html
<details class="dropdown">
    <summary role="button" class="btn-primary">Primary</summary>
    <ul>
        <li><a href="#">Item A</a></li>
        <li><a href="#">Item B</a></li>
    </ul>
</details>

<details class="dropdown">
    <summary role="button" class="btn-success">Success</summary>
    <ul>
        <li><a href="#">Item A</a></li>
        <li><a href="#">Item B</a></li>
    </ul>
</details>

<details class="dropdown">
    <summary role="button" class="btn-error">Error</summary>
    <ul>
        <li><a href="#">Item A</a></li>
        <li><a href="#">Item B</a></li>
    </ul>
</details>
```

---

## Select replacement

A dropdown can serve as a styled alternative to a native `<select>` by placing it inside a `<label>`.

```html
<label>Choose a fruit
    <details class="dropdown">
        <summary>Pick one...</summary>
        <ul>
            <li><a href="#">Apple</a></li>
            <li><a href="#">Banana</a></li>
            <li><a href="#">Cherry</a></li>
            <li><a href="#">Mango</a></li>
            <li><a href="#">Orange</a></li>
        </ul>
    </details>
</label>
```

**Note:** unlike a native `<select>`, the selected value is not managed automatically. A minimum of application JavaScript is required to update the `<summary>` text after selection.

---

## Structure

```
<details class="dropdown">
    <summary [role="button"] [class="btn-*"]>Trigger text</summary>
    <ul>
        <li><a href="#">Menu item</a></li>
        ...
    </ul>
</details>
```

| Element | Role |
|---------|------|
| `<details class="dropdown">` | Dropdown container |
| `<summary>` | Trigger (text or button) |
| `<summary role="button">` | Trigger with button appearance |
| `<ul>` | Options list |
| `<li><a>` | Clickable menu item |

---

## Accessibility

- The component relies on the native `<details>`/`<summary>` element, which is keyboard accessible by default (opens via `Enter` or `Space`).
- The `role="button"` attribute on `<summary>` informs assistive technologies that the element acts as a button.
- The menu closes automatically when the user clicks outside (native `<details>` behavior).

> See also : [µNav](mu.nav.md) · [µButton](mu.button.md)

> [See example](../examples/dropdown.html)
