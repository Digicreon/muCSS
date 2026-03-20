# µUtilities

**µUtilities** provides generic CSS utility classes in [µCSS](.). These classes can be applied to any element.

---

## Positioning

Three classes for sticky and fixed positioning, defined in `css/mu.utilities.css`:

| Class | Effect |
|-------|--------|
| `.sticky-top` | `position: sticky; top: 0` — stays in flow, sticks to the top on scroll |
| `.fixed-top` | `position: fixed; top: 0; right: 0; left: 0` — always fixed to the viewport top |
| `.fixed-bottom` | `position: fixed; bottom: 0; right: 0; left: 0` — fixed to the viewport bottom |

### Usage examples

**Sticky navigation bar** (recommended for navbars):

```html
<nav class="sticky-top">
    <ul><li><strong>Brand</strong></li></ul>
    <input type="checkbox" id="nav-s" class="navbar-toggle" hidden>
    <label for="nav-s" class="navbar-burger">☰</label>
    <ul class="navbar-menu">
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
    </ul>
</nav>
```

**Sticky table header**:

```html
<table>
    <thead class="sticky-top">
        <tr><th>Name</th><th>Email</th></tr>
    </thead>
    <tbody>…</tbody>
</table>
```

**Sticky sidebar / table of contents**:

```html
<aside class="sticky-top" style="top: 1rem;">
    <nav>
        <ul>
            <li><a href="#section-1">Section 1</a></li>
            <li><a href="#section-2">Section 2</a></li>
        </ul>
    </nav>
</aside>
```

**Fixed bottom action bar** (mobile):

```html
<div class="fixed-bottom" style="padding: 1rem; background: var(--mu-background-color);">
    <button class="btn btn-primary" style="width: 100%;">Confirm</button>
</div>
```

### Nav-specific overrides

When used on a `<nav>`, these classes automatically add `z-index: 100` and `box-shadow` to elevate the navbar above content. See [µNav](mu.nav.md#sticky-and-fixed-navbars).

### Notes

- `.sticky-top` requires a scrollable ancestor — the element stays in the document flow and sticks when scrolled past.
- `.fixed-top` and `.fixed-bottom` remove the element from the flow — add `padding-top` or `padding-bottom` on `<body>` to prevent content from being hidden behind.
- Override the default `top: 0` on `.sticky-top` via inline style if you need an offset (e.g., `style="top: 1rem"`).

---

## Cursor

| Class | Effect |
|-------|--------|
| `.clickable` | `cursor: pointer` — shows a pointer cursor on hover |

Use `.clickable` on elements that are interactive via JavaScript but are not `<a>` or `<button>` (which already show a pointer cursor natively).

```html
<tr class="clickable" onclick="openDetail(this)">
    <td>Row content</td>
</tr>
```

---

## Color utilities

Text, background, and border color classes are documented in [µColors](mu.colors.md#utility-classes).

---

> See also : [µColors](mu.colors.md) · [µNav](mu.nav.md) · [µTable](mu.table.md)
