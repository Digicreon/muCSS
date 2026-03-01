# µGroup

**µGroup** allows visually grouping form fields and buttons on a single line, using the `role="group"` attribute styled by [µCSS](.). Grouped elements share common borders and align horizontally.

---

## Button group

The `role="group"` attribute on a container groups buttons into a horizontal bar with merged borders.

```html
<div role="group">
    <button>Left</button>
    <button>Center</button>
    <button>Right</button>
</div>
```

---

## Input + button

Combine an input field and a button in the same group to create a compact inline form.

```html
<div role="group">
    <input type="email" placeholder="Enter your email">
    <button>Subscribe</button>
</div>
```

---

## Search group

Use `role="search"` for a group semantically identified as a search area. The visual rendering is identical to `role="group"`.

```html
<div role="search">
    <input type="search" placeholder="Search...">
    <button>Search</button>
</div>
```

---

## Input + select + button

A group can contain more than two elements, for example a `<select>`, an `<input>` and a `<button>`.

```html
<div role="group">
    <select>
        <option>USD</option>
        <option>EUR</option>
        <option>GBP</option>
    </select>
    <input type="number" placeholder="Amount">
    <button>Convert</button>
</div>
```

---

## Outline buttons

`.outline` buttons also work within a group, providing a toggle bar style.

```html
<div role="group">
    <button class="outline">Day</button>
    <button class="outline">Week</button>
    <button class="outline">Month</button>
</div>
```

---

## Role summary

| Attribute | Usage |
|-----------|-------|
| `role="group"` | Generic group (buttons, inputs, selects) |
| `role="search"` | Search group (semantic) |

## Supported elements in a group

| Element | Behavior |
|---------|----------|
| `<button>` | Action button |
| `<input>` | Input field (text, email, search, number, etc.) |
| `<select>` | Selection list |

---

## Accessibility

- `role="group"` informs assistive technologies that the elements are related and form a logical set.
- `role="search"` semantically identifies the area as a search feature, which helps screen reader navigation.
- Elements within the group remain individually accessible via keyboard (`Tab` navigation).

> See also : [µForms](mu.forms.md) · [µButton](mu.button.md)

> [See example](../examples/group.html)
