# µVar

**µVar** styles the `<var>` HTML element to match the appearance of `<code>`, `<kbd>`, and `<samp>` in [µCSS](.). PicoCSS does not style `<var>`, so this component fills the gap.

---

## Usage

Use `<var>` to represent a variable name in code or a mathematical expression:

```html
<p>Set <var>x</var> to the return value of <code>getData()</code>.</p>
```

No class is needed — the styling applies directly to the `<var>` element.

---

## Styling details

| Property | Value |
|----------|-------|
| Font family | `--mu-font-family-monospace` |
| Font size | `0.875em` |
| Font style | `italic` |
| Padding | `0.375rem` |
| Border radius | `--mu-border-radius` |
| Background | `--mu-code-background-color` |
| Color | `--mu-code-color` |

The italic style distinguishes `<var>` from `<code>`, `<kbd>`, and `<samp>`.

---

## Comparison

| Element | Semantic meaning | Italic |
|---------|-----------------|--------|
| `<code>` | Code fragment | No |
| `<kbd>` | Keyboard input | No |
| `<samp>` | Program output | No |
| `<var>` | Variable or placeholder | Yes |

---

## Accessibility

- Use `<var>` only for variable names or placeholders — not for general emphasis (use `<em>` instead).
- Screen readers may announce `<var>` differently depending on the browser, helping distinguish it from surrounding code.

---

> See also : [Typography](../examples/typography.html)
