# µAccordion

**µAccordion** is a collapsible sections component, part of the [µCSS](.) framework. It is built entirely on native HTML `<details>` and `<summary>` elements -- no JavaScript required for basic open/close functionality.

---

## Usage

Wrap one or more `<details>` elements inside a container with the `.accordion` class:

```html
<div class="accordion">
    <details>
        <summary>Section One</summary>
        <p>Content for section one.</p>
    </details>
    <details>
        <summary>Section Two</summary>
        <p>Content for section two.</p>
    </details>
    <details>
        <summary>Section Three</summary>
        <p>Content for section three.</p>
    </details>
</div>
```

The component automatically:
- Draws a border around the group with rounded corners
- Separates each item with a bottom border
- Displays a chevron indicator on the right side of each `<summary>`
- Rotates the chevron when a section is expanded

---

## Open by default

Add the `open` attribute to any `<details>` element to have it expanded on page load:

```html
<div class="accordion">
    <details open>
        <summary>Section One</summary>
        <p>This section is open by default.</p>
    </details>
    <details>
        <summary>Section Two</summary>
        <p>This section starts closed.</p>
    </details>
</div>
```

Multiple sections can be open simultaneously -- the browser handles each `<details>` independently.

---

## Rich content

Accordion sections can contain any HTML content, not just paragraphs:

```html
<div class="accordion">
    <details open>
        <summary>With nested elements</summary>
        <p>Accordions can contain any HTML:</p>
        <ul>
            <li>Unordered lists</li>
            <li>Paragraphs and <strong>inline formatting</strong></li>
            <li>Any block-level content</li>
        </ul>
    </details>
    <details>
        <summary>With a table</summary>
        <table>
            <thead><tr><th>Name</th><th>Value</th></tr></thead>
            <tbody>
                <tr><td>Alpha</td><td>100</td></tr>
                <tr><td>Beta</td><td>200</td></tr>
            </tbody>
        </table>
    </details>
</div>
```

Lists (`<ul>`, `<ol>`) inside accordion sections receive adjusted left padding (`2.5rem`) so they align properly within the panel.

---

## CSS classes reference

| Class | Element | Description |
|-------|---------|-------------|
| `.accordion` | Container `<div>` | Wraps the group of `<details>` elements, applies border, rounded corners, and overflow hidden |

No additional CSS classes are needed on child elements. All styling targets the structure `.accordion > details > summary` and `.accordion > details > :not(summary)` directly.

---

## Styling details

| Property | Value |
|----------|-------|
| Border | `1px solid var(--pico-secondary-background)` |
| Border radius | `0.375rem` |
| Summary padding | `0.75rem 1rem` |
| Content padding | `0.75rem 1rem` |
| Chevron transition | `transform 0.2s ease` |

---

## Accessibility

- Built on native `<details>` / `<summary>` elements, so keyboard navigation and screen reader support work out of the box.
- The browser handles `Enter` / `Space` key toggling of sections natively.
- No ARIA attributes are required since the semantics are provided by the HTML elements themselves.

---

→ [Voir l'exemple](../examples/accordion.html)
