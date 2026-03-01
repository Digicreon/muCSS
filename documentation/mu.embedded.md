# µEmbedded

**µEmbedded** describes the styling of embedded content in [µCSS](.): images (`<img>`), videos (`<video>`), audio (`<audio>`), SVG, and canvas.

---

## Usage

Images are responsive by default:

```html
<img src="photo.jpg" alt="Description de la photo">
```

---

## Images

Images receive `max-width: 100%` and `height: auto`, making them responsive without any additional class:

```html
<img src="large-photo.jpg" alt="Photo responsive">
```

| Property | Value |
|----------|-------|
| `max-width` | `100%` |
| `height` | `auto` |
| `border-style` | `none` |

The image never exceeds the width of its container and maintains its aspect ratio.

---

## Video and audio

The `<video>` and `<audio>` elements are displayed as `inline-block`:

```html
<video controls>
    <source src="video.mp4" type="video/mp4">
</video>

<audio controls>
    <source src="audio.mp3" type="audio/mpeg">
</audio>
```

An `<audio>` element without the `controls` attribute is hidden (`display: none`).

---

## SVG

SVGs inherit the text color via `fill: currentColor`, making them automatically theme-aware:

```html
<svg width="24" height="24" viewBox="0 0 24 24">
    <path d="M12 2L2 22h20L12 2z"/>
</svg>
```

The SVG will adapt to the surrounding text color, including when toggling between light and dark modes.

---

## Canvas

The `<canvas>` element is displayed as `inline-block`:

```html
<canvas width="300" height="150"></canvas>
```

---

## Inside a figure

Combine embedded content with `<figure>` to add a caption:

```html
<figure>
    <img src="photo.jpg" alt="Paysage">
    <figcaption>Un paysage de montagne</figcaption>
</figure>
```

See [µFigure](mu.figure.md) for more details.

---

## Accessibility

- Always provide a descriptive `alt` attribute on `<img>` elements. Use `alt=""` for decorative images.
- Add subtitles (`<track>`) to `<video>` elements.
- The `controls` attribute on `<audio>` and `<video>` is essential for accessibility.
- Inline SVGs should have a `role="img"` and an `aria-label` or an internal `<title>`.

---

> See also : [µFigure](mu.figure.md) · [µTypography](mu.typography.md)
