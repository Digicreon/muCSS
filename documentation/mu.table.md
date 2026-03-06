# µTable

**µTable** provides enhanced table styles for the [µCSS](.) framework. It adds hover highlights, striped rows, bordered cells, compact padding, and fullwidth layout on top of the default table styling.

---

## Usage

Apply one or more modifier classes directly on the `<table>` element:

```html
<table class="table-hover">
    <thead>
        <tr><th>Name</th><th>Role</th><th>Status</th></tr>
    </thead>
    <tbody>
        <tr><td>Alice</td><td>Developer</td><td>Active</td></tr>
        <tr><td>Bob</td><td>Designer</td><td>Active</td></tr>
        <tr><td>Charlie</td><td>Manager</td><td>Away</td></tr>
    </tbody>
</table>
```

---

## Variants

### Hover

Highlights a row when the user hovers over it.

```html
<table class="table-hover">
    ...
</table>
```

### Striped

Applies an alternating background on odd rows for better readability.

```html
<table class="table-striped">
    ...
</table>
```

### Bordered

Adds a 1px border around the table and every cell.

```html
<table class="table-bordered">
    ...
</table>
```

### Compact

Reduces cell padding to `0.25rem 0.5rem` for denser data display.

```html
<table class="table-compact">
    ...
</table>
```

### Fullwidth

Forces the table to take up 100% of its container width.

```html
<table class="table-fullwidth">
    ...
</table>
```

---

## Combining variants

All modifier classes can be combined freely. Common combinations:

```html
<!-- Hover + bordered + fullwidth -->
<table class="table-hover table-bordered table-fullwidth">
    <thead>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>
    </thead>
    <tbody>
        <tr><td>1</td><td>Alice</td><td>alice@example.com</td><td>Developer</td></tr>
        <tr><td>2</td><td>Bob</td><td>bob@example.com</td><td>Designer</td></tr>
    </tbody>
</table>

<!-- Compact + bordered + fullwidth -->
<table class="table-compact table-bordered table-fullwidth">
    <thead>
        <tr><th>Key</th><th>Value</th><th>Type</th></tr>
    </thead>
    <tbody>
        <tr><td>host</td><td>localhost</td><td>string</td></tr>
        <tr><td>port</td><td>8080</td><td>integer</td></tr>
    </tbody>
</table>

<!-- Striped + hover + bordered + fullwidth -->
<table class="table-striped table-hover table-bordered table-fullwidth">
    ...
</table>
```

---

## Class reference

| Class              | Effect                                                                 |
|--------------------|------------------------------------------------------------------------|
| `.table-hover`     | Background highlight on row hover (`--mu-secondary-background`)      |
| `.table-striped`   | Alternating background on odd rows (50% `--mu-secondary-background`) |
| `.table-bordered`  | 1px solid border on table, `<th>`, and `<td>`                          |
| `.table-compact`   | Reduced padding: `0.25rem 0.5rem`                                      |
| `.table-fullwidth` | `width: 100%`                                                          |

---

## Responsive tables

For tables wider than their container, wrap them in a scrollable `<div>`:

```html
<div style="overflow-x: auto;">
    <table class="table-bordered table-fullwidth">
        ...
    </table>
</div>
```

---

## Implementation note

The base styles set `background-color` on individual `<th>` and `<td>` cells rather than on `<tr>` rows. For this reason, `.table-hover` and `.table-striped` target `th` and `td` elements directly instead of `tr`. This ensures the hover and stripe backgrounds correctly override default cell styles.

The `.table-bordered` variant uses `color-mix()` to blend `--mu-muted-color` (30%) with `--mu-muted-border-color` (70%) for visible but not heavy cell borders.

---

## Accessibility

- Use `<caption>` to provide a descriptive title for the table.
- Use `<thead>`, `<tbody>`, and `<tfoot>` to group rows semantically.
- Use `scope="col"` on header cells in `<thead>` and `scope="row"` on row headers.
- For complex tables, use `aria-describedby` to reference a longer description.
- Avoid using tables for layout — only use them for tabular data.

---

> See also : [µForms](mu.forms.md) · [µGrid](mu.grid.md)

→ [See example](../examples/table.html)
