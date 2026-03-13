# µGrid

**µGrid** is a lightweight flexbox-based 12-column responsive grid system, part of the [µCSS](.) framework. It provides a Bootstrap-compatible grid fallback for CSS frameworks that lack a built-in responsive grid (such as PicoCSS v2).

**Weight:** ~4 KB uncompressed, ~1 KB gzipped.

---

## Breakpoints

µGrid uses a mobile-first approach with 5 breakpoints:

| Name | Prefix | Min-width | Typical use          |
|------|--------|-----------|----------------------|
| —    | *(none)* | 0       | Mobile (default)     |
| sm   | `-sm-` | 576px     | Mobile landscape     |
| md   | `-md-` | 768px     | Tablet               |
| lg   | `-lg-` | 1024px    | Desktop              |
| xl   | `-xl-` | 1280px    | Large desktop        |
| xxl  | `-xxl-`| 1536px    | Extra-large desktop  |

All classes without a breakpoint prefix apply to all screen sizes. Prefixed classes apply from the specified breakpoint and up.

---

## Container

Containers center and constrain content horizontally.

```html
<!-- Fixed-width container (max-width: 1200px) -->
<div class="container">...</div>

<!-- Full-width container -->
<div class="container-fluid">...</div>
```

Both containers have `1rem` horizontal padding.

---

## Row

A `.row` creates a flex container for columns. It uses negative margins to compensate for column gutters.

```html
<div class="container">
    <div class="row">
        <div class="col-6">Half</div>
        <div class="col-6">Half</div>
    </div>
</div>
```

---

## Columns

Columns are defined using `.col-{n}` and `.col-{bp}-{n}` classes, where `{n}` is a number from 1 to 12.

Each column has a `0.75rem` padding on each side (1.5rem gutter between columns).

### Basic usage

```html
<div class="row">
    <div class="col-12">Full width</div>
</div>

<div class="row">
    <div class="col-4">One third</div>
    <div class="col-8">Two thirds</div>
</div>
```

### Responsive columns

```html
<div class="row">
    <!-- Full width on mobile, half on tablet, one third on desktop -->
    <div class="col-12 col-md-6 col-lg-4">Content</div>
    <div class="col-12 col-md-6 col-lg-4">Content</div>
    <div class="col-12 col-md-12 col-lg-4">Content</div>
</div>
```

### Column reference

| Class pattern    | Width      |
|------------------|------------|
| `.col-{bp}-1`    | 8.3333%    |
| `.col-{bp}-2`    | 16.6667%   |
| `.col-{bp}-3`    | 25%        |
| `.col-{bp}-4`    | 33.3333%   |
| `.col-{bp}-5`    | 41.6667%   |
| `.col-{bp}-6`    | 50%        |
| `.col-{bp}-7`    | 58.3333%   |
| `.col-{bp}-8`    | 66.6667%   |
| `.col-{bp}-9`    | 75%        |
| `.col-{bp}-10`   | 83.3333%   |
| `.col-{bp}-11`   | 91.6667%   |
| `.col-{bp}-12`   | 100%       |

---

## Offsets

Offsets push a column to the right by a given number of columns using `margin-left`.

```html
<div class="row">
    <div class="col-6 offset-3">Centered content</div>
</div>
```

### Responsive offsets

```html
<div class="row">
    <div class="col-12 col-md-8 col-lg-4 offset-md-2 offset-lg-4">Content</div>
</div>
```

Use `.offset-{bp}-0` to reset an offset at a given breakpoint.

---

## Ordering

Change the visual order of columns without changing the HTML source order.

```html
<div class="row">
    <div class="col-6 order-2">Appears second</div>
    <div class="col-6 order-1">Appears first</div>
</div>
```

### Special values

| Class                  | Effect       |
|------------------------|--------------|
| `.order-{bp}-first`    | `order: -1`  |
| `.order-{bp}-last`     | `order: 13`  |
| `.order-{bp}-0` to `.order-{bp}-12` | `order: 0` to `order: 12` |

---

## Display / Visibility

| Class             | Effect              |
|-------------------|---------------------|
| `.d-{bp}-none`    | `display: none`     |
| `.d-{bp}-block`   | `display: block`    |
| `.d-{bp}-flex`    | `display: flex`     |

When showing a `.row` that was previously hidden, use `d-{bp}-flex` instead of `d-{bp}-block` to preserve the flex layout.

```html
<div class="row d-none d-md-flex">
    <div class="col-md-6">A</div>
    <div class="col-md-6">B</div>
</div>
```

---

## Bootstrap compatibility

µGrid uses the same class naming conventions as Bootstrap 5. Main differences:

- **Breakpoint values differ slightly** from Bootstrap: `lg` is 1024px (vs 992px), `xl` is 1280px (vs 1200px), `xxl` is 1536px (vs 1400px).
- **No auto-sizing columns**: `.col` (without a number) is not supported.
- **No `row-cols-*`**: automatic column count per row is not supported.
- **No flex alignment utilities**: `justify-content-*`, `align-items-*` are not included.

---

> See also : [µContainer](mu.container.md)

> [See example](../examples/grid.html)
