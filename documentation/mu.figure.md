# µFigure

**µFigure** describes the styling of the `<figure>` element and its `<figcaption>` caption in [µCSS](.).

---

## Usage

Wrap illustrative content in `<figure>` with a `<figcaption>` caption:

```html
<figure>
    <img src="photo.jpg" alt="Mountain landscape">
    <figcaption>View from the top of the pass</figcaption>
</figure>
```

---

## Style

The `<figure>` element is reset with no margins or padding. The `<figcaption>` caption uses a muted color:

| Element | Property | Value |
|---------|----------|-------|
| `<figure>` | `display` | `block` |
| `<figure>` | `margin` | `0` |
| `<figure>` | `padding` | `0` |
| `<figcaption>` | `padding` | `calc(var(--mu-spacing) * 0.5) 0` |
| `<figcaption>` | `color` | `--mu-muted-color` |

---

## With an image

```html
<figure>
    <img src="chart.png" alt="Sales chart">
    <figcaption>Quarterly sales, 2024</figcaption>
</figure>
```

The image is responsive by default (`max-width: 100%`, see [µEmbedded](mu.embedded.md)).

---

## With a code block

`<figure>` can wrap a code block:

```html
<figure>
    <pre><code>const greeting = "Hello, World!";
console.log(greeting);</code></pre>
    <figcaption>JavaScript code example</figcaption>
</figure>
```

---

## With a quote

```html
<figure>
    <blockquote>
        Simplicity is the ultimate sophistication.
    </blockquote>
    <figcaption>Leonardo da Vinci</figcaption>
</figure>
```

---

## Accessibility

- Always provide an `alt` attribute on images contained within `<figure>`.
- `<figcaption>` serves as an accessible caption; it is automatically associated with the `<figure>` by screen readers.
- For figures without `<figcaption>`, add an `aria-label` on the `<figure>`.

---

> See also : [µEmbedded](mu.embedded.md) · [µCode](mu.code.md) · [µTypography](mu.typography.md)
