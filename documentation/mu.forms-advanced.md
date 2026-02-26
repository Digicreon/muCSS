# µForms (advanced)

**µForms (advanced)** describes the specialized native input types styled by [µCSS](.) via PicoCSS. These include color pickers, date/time inputs, file uploads, search fields, and other input types, all styled automatically without additional classes.

---

## Color picker

The `<input type="color">` renders a native color picker widget.

```html
<label>Pick a color
    <input type="color" value="#0172ad">
</label>
```

---

## Date & time inputs

PicoCSS styles all native date and time input types consistently.

```html
<label>Date
    <input type="date">
</label>
<label>Time
    <input type="time">
</label>
<label>Date and time
    <input type="datetime-local">
</label>
<label>Month
    <input type="month">
</label>
<label>Week
    <input type="week">
</label>
```

| Input type         | Description                          |
|--------------------|--------------------------------------|
| `date`             | Date picker (year-month-day)         |
| `time`             | Time picker (hours-minutes)          |
| `datetime-local`   | Combined date and time picker        |
| `month`            | Month and year picker                |
| `week`             | Week and year picker                 |

---

## File upload

The `<input type="file">` renders a styled file selection button. Add `multiple` to allow selecting more than one file.

```html
<label>Choose a file
    <input type="file">
</label>
<label>Multiple files
    <input type="file" multiple>
</label>
```

---

## Search

The `<input type="search">` renders a text field with a search-specific style (including a clear button in some browsers).

```html
<label>Search
    <input type="search" placeholder="Search...">
</label>
```

### Search with group

Wrap a search input and button inside a `<div role="search">` for a grouped search bar layout.

```html
<div role="search">
    <input type="search" placeholder="Search...">
    <button>Go</button>
</div>
```

---

## Other input types

PicoCSS styles several additional input types natively.

```html
<label>Number
    <input type="number" value="42" min="0" max="100">
</label>
<label>URL
    <input type="url" placeholder="https://example.com">
</label>
<label>Telephone
    <input type="tel" placeholder="+1 (555) 123-4567">
</label>
<label>Password
    <input type="password" value="secret123">
</label>
```

---

## Disabled & readonly

Use `disabled` to prevent all interaction, or `readonly` to allow selection and copying but prevent editing.

```html
<label>Disabled input
    <input type="text" value="Cannot edit" disabled>
</label>
<label>Readonly input
    <input type="text" value="Read only" readonly>
</label>
```

| Attribute   | User can select text | User can edit | Submitted with form |
|-------------|---------------------|---------------|---------------------|
| `disabled`  | No                  | No            | No                  |
| `readonly`  | Yes                 | No            | Yes                 |

---

## Validation states & helper text

Use `aria-invalid` to indicate validation state visually. Add a `<small>` element after the input inside the `<label>` for helper or error messages.

```html
<label>Email
    <input type="email" placeholder="user@example.com" aria-invalid="true">
    <small>Please enter a valid email address.</small>
</label>
<label>Username
    <input type="text" value="johndoe" aria-invalid="false">
    <small>Username is available.</small>
</label>
```

| `aria-invalid` value | Visual feedback                          |
|----------------------|------------------------------------------|
| `"true"`             | Red/error border and helper text color   |
| `"false"`            | Green/success border and helper text color |

---

## Accessibility

- Always wrap inputs in a `<label>` to provide an accessible name.
- Use `aria-invalid` to communicate validation state to screen readers.
- The `<small>` helper text following an input is visually associated; for explicit screen reader association, use `aria-describedby`.
- `disabled` and `readonly` states are natively communicated to assistive technologies.
- The `role="search"` landmark on the search group container helps screen readers identify the search region.
- File inputs announce the selected file name(s) to screen readers.
- Date and time pickers use native browser widgets that provide built-in keyboard and screen reader support.

---

→ [Voir l'exemple](../examples/forms-advanced.html)
