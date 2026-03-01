# µSwitch

**µSwitch** describes the toggle switch controls available natively in [µCSS](.). Switches are standard checkboxes enhanced with `role="switch"`, which µCSS styles as visual toggle switches without any additional CSS or JavaScript.

---

## Usage

A switch is a standard `<input type="checkbox">` with the `role="switch"` attribute, wrapped in a `<label>`.

```html
<label>
    <input type="checkbox" role="switch">
    Enable notifications
</label>
```

---

## Basic switch

Use `checked` to set the initial state.

```html
<label>
    <input type="checkbox" role="switch">
    Enable notifications
</label>
<label>
    <input type="checkbox" role="switch" checked>
    Dark mode
</label>
```

---

## Disabled state

Add the `disabled` attribute to prevent interaction. The switch renders in a muted style.

```html
<label>
    <input type="checkbox" role="switch" disabled>
    Disabled off
</label>
<label>
    <input type="checkbox" role="switch" disabled checked>
    Disabled on
</label>
```

---

## Validation states

Use `aria-invalid` to indicate valid or invalid states visually.

```html
<label>
    <input type="checkbox" role="switch" aria-invalid="false" checked>
    Valid switch
</label>
<label>
    <input type="checkbox" role="switch" aria-invalid="true">
    Invalid switch
</label>
```

| `aria-invalid` value | Visual feedback                |
|----------------------|--------------------------------|
| `"false"`            | Green/success indicator        |
| `"true"`             | Red/error indicator            |

---

## In a form context

Switches work well inside cards (`<article>`) for settings or preference panels.

```html
<article>
    <header>Preferences</header>
    <label>
        <input type="checkbox" role="switch" checked>
        Receive email updates
    </label>
    <label>
        <input type="checkbox" role="switch">
        Make profile public
    </label>
    <label>
        <input type="checkbox" role="switch" checked>
        Enable two-factor authentication
    </label>
</article>
```

---

## Accessibility

- The `role="switch"` attribute tells screen readers to announce the control as a toggle switch rather than a checkbox.
- Always wrap the input inside a `<label>` to provide an accessible label.
- Screen readers will announce the state as "on" or "off" rather than "checked" or "unchecked".
- Use `aria-invalid` to communicate validation state to assistive technologies.
- The `disabled` attribute is natively understood by all screen readers.

---

> See also : [µCheckbox & Radio](mu.checkbox-radio.md) · [µForms](mu.forms.md)

→ [See example](../examples/switch.html)
