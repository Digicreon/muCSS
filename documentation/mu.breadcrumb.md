# µBreadcrumb

**µBreadcrumb** is a navigation trail component, part of the [µCSS](.) framework. It provides multiple separator styles, a boxed variant, and proper ARIA semantics for accessible navigation.

---

## Basic usage

Use a `<nav>` with `aria-label="Breadcrumb"` wrapping a `<ul class="breadcrumb">`. The last item represents the current page:

```html
<nav aria-label="Breadcrumb">
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Products</a></li>
        <li><a href="#">Category</a></li>
        <li aria-current="page">Current Page</li>
    </ul>
</nav>
```

The default separator between items is `/`.

---

## Separator styles

Three alternative separator styles are available by adding a modifier class to the `<ul>`:

### Arrow separator

```html
<nav aria-label="Breadcrumb">
    <ul class="breadcrumb breadcrumb-arrow">
        <li><a href="#">Home</a></li>
        <li><a href="#">Library</a></li>
        <li aria-current="page">Article</li>
    </ul>
</nav>
```

### Dot separator

```html
<nav aria-label="Breadcrumb">
    <ul class="breadcrumb breadcrumb-dot">
        <li><a href="#">Home</a></li>
        <li><a href="#">Settings</a></li>
        <li aria-current="page">Profile</li>
    </ul>
</nav>
```

### Chevron separator

```html
<nav aria-label="Breadcrumb">
    <ul class="breadcrumb breadcrumb-chevron">
        <li><a href="#">Home</a></li>
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Reports</a></li>
        <li aria-current="page">Monthly</li>
    </ul>
</nav>
```

| Class | Separator character |
|-------|-------------------|
| *(default)* | `/` |
| `.breadcrumb-arrow` | `>` (single right-pointing angle) |
| `.breadcrumb-dot` | `*` (middle dot) |
| `.breadcrumb-chevron` | `>>` (double right-pointing angle) |

---

## Boxed variant

Add `.breadcrumb-boxed` for a background container with padding and rounded corners:

```html
<nav aria-label="Breadcrumb">
    <ul class="breadcrumb breadcrumb-boxed">
        <li><a href="#">Home</a></li>
        <li><a href="#">Account</a></li>
        <li aria-current="page">Settings</li>
    </ul>
</nav>
```

The boxed variant can be combined with any separator style:

```html
<nav aria-label="Breadcrumb">
    <ul class="breadcrumb breadcrumb-boxed breadcrumb-arrow">
        <li><a href="#">Home</a></li>
        <li><a href="#">Projects</a></li>
        <li aria-current="page">µCSS</li>
    </ul>
</nav>
```

---

## CSS classes reference

| Class | Description |
|-------|-------------|
| `.breadcrumb` | Base breadcrumb list (flex, no list-style, font-size 0.875rem) |
| `.breadcrumb-arrow` | Uses `>` as separator |
| `.breadcrumb-dot` | Uses `*` as separator |
| `.breadcrumb-chevron` | Uses `>>` as separator |
| `.breadcrumb-boxed` | Adds background, padding, and border-radius |

---

## Styling details

| Property | Value |
|----------|-------|
| Font size | `0.875rem` |
| Separator margin | `0 0.5rem` |
| Separator color | `var(--pico-secondary)` at 60% opacity |
| Link color | `var(--pico-primary)` |
| Link hover | `var(--pico-primary-hover)` with underline |
| Current page color | `var(--pico-secondary)` |
| Boxed padding | `0.5rem 1rem` |
| Boxed background | `var(--pico-secondary-background)` |
| Boxed border radius | `0.375rem` |

---

## Accessibility

- Wrap the breadcrumb in a `<nav>` element with `aria-label="Breadcrumb"`.
- Mark the current page item with `aria-current="page"` (no `<a>` tag needed).
- The last item and items with `aria-current` are automatically styled in the secondary color to indicate the active page.

---

→ [Voir l'exemple](../examples/breadcrumb.html)
