# µCheckbox & Radio

**µCheckbox & Radio** describes the native checkbox and radio button styling provided by [µCSS](.) via PicoCSS. These are standard HTML form controls (`<input type="checkbox">` and `<input type="radio">`) that PicoCSS styles automatically without any additional classes.

---

## Checkboxes

### Basic usage

Wrap each `<input type="checkbox">` inside a `<label>` for proper styling and accessibility. Use a `<fieldset>` with `<legend>` to group related checkboxes.

```html
<fieldset>
    <legend>Select your interests</legend>
    <label><input type="checkbox" checked> Design</label>
    <label><input type="checkbox"> Development</label>
    <label><input type="checkbox"> Marketing</label>
    <label><input type="checkbox" disabled> Disabled option</label>
</fieldset>
```

### Indeterminate state

The indeterminate state is set via JavaScript and represents a "partially checked" visual state.

```html
<label>
    <input type="checkbox" id="indeterminate-check"> Indeterminate state
</label>
<script>document.getElementById('indeterminate-check').indeterminate = true;</script>
```

### Checkbox validation

Use `aria-invalid` to visually indicate valid or invalid checkboxes.

```html
<label><input type="checkbox" aria-invalid="false" checked> Valid checkbox</label>
<label><input type="checkbox" aria-invalid="true"> Invalid checkbox</label>
```

---

## Radio buttons

### Basic usage

Radio buttons use `<input type="radio">` with a shared `name` attribute to form a mutually exclusive group. Wrap them in a `<fieldset>` with `<legend>`.

```html
<fieldset>
    <legend>Choose a plan</legend>
    <label><input type="radio" name="plan" checked> Free</label>
    <label><input type="radio" name="plan"> Pro</label>
    <label><input type="radio" name="plan"> Enterprise</label>
    <label><input type="radio" name="plan" disabled> Deprecated plan</label>
</fieldset>
```

### Radio validation

Use `aria-invalid` on individual radio inputs to indicate validation state.

```html
<fieldset>
    <legend>Select a valid option</legend>
    <label><input type="radio" name="valid-radio" aria-invalid="false" checked> Valid choice</label>
    <label><input type="radio" name="invalid-radio" aria-invalid="true"> Invalid choice</label>
</fieldset>
```

---

## In a form

Checkboxes and radio buttons can be combined inside a card (`<article>`) for structured forms.

```html
<article>
    <header>Registration</header>
    <fieldset>
        <legend>Account type</legend>
        <label><input type="radio" name="type" checked> Personal</label>
        <label><input type="radio" name="type"> Business</label>
    </fieldset>
    <fieldset>
        <legend>Agreements</legend>
        <label><input type="checkbox" required> I accept the terms and conditions</label>
        <label><input type="checkbox"> Subscribe to newsletter</label>
    </fieldset>
</article>
```

---

## States reference

| Attribute          | Effect                                           |
|--------------------|--------------------------------------------------|
| `checked`          | Sets the default checked state                   |
| `disabled`         | Prevents interaction, muted visual style         |
| `required`         | Marks the field as mandatory for form submission |
| `aria-invalid="false"` | Green/success visual indicator              |
| `aria-invalid="true"`  | Red/error visual indicator                  |
| `indeterminate` (JS) | Partially checked visual state (checkbox only) |

---

## Accessibility

- Always wrap inputs in a `<label>` to associate the label text with the control.
- Use `<fieldset>` and `<legend>` to group related checkboxes or radio buttons. Screen readers announce the group label when entering the fieldset.
- Radio buttons sharing the same `name` attribute are announced as a group by screen readers.
- The `disabled` attribute natively prevents focus and interaction and is communicated to assistive technologies.
- Use `aria-invalid` to communicate validation state to screen readers.
- The `required` attribute is announced by screen readers and triggers native browser validation.

---

→ [Voir l'exemple](../examples/checkbox-radio.html)
