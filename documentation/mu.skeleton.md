# µSkeleton

**µSkeleton** is a loading placeholder component, part of the [µCSS](.) framework. It displays animated shimmer shapes that mimic the layout of content while it loads, reducing perceived loading time.

---

## Basic usage

Apply `.skeleton` along with a shape variant class to a `<div>`:

```html
<div class="skeleton skeleton-text"></div>
```

---

## Shapes

### Text lines

```html
<div class="skeleton skeleton-text"></div>
<div class="skeleton skeleton-text"></div>
<div class="skeleton skeleton-text"></div>
<div class="skeleton skeleton-text"></div>
```

The last `.skeleton-text` automatically shrinks to 75% width for a natural paragraph look.

### Title

```html
<div class="skeleton skeleton-title"></div>
```

### Avatar

```html
<div class="skeleton skeleton-avatar"></div>
```

### Image

```html
<div class="skeleton skeleton-image"></div>
```

---

## Composition

Combine shapes to build skeleton layouts that mirror real content:

```html
<article>
    <header>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div class="skeleton skeleton-avatar"></div>
            <div style="flex: 1;">
                <div class="skeleton skeleton-title"></div>
                <div class="skeleton skeleton-text" style="width: 40%;"></div>
            </div>
        </div>
    </header>
    <div class="skeleton skeleton-image"></div>
    <div class="skeleton skeleton-text"></div>
    <div class="skeleton skeleton-text"></div>
    <div class="skeleton skeleton-text"></div>
</article>
```

---

## CSS classes reference

| Class | Description |
|-------|-------------|
| `.skeleton` | Base class (background, shimmer animation, transparent text) |
| `.skeleton-text` | Text line — `height: 1em`, last child at 75% width |
| `.skeleton-title` | Title block — `height: 1.5rem`, `width: 50%` |
| `.skeleton-avatar` | Circle — `3rem × 3rem`, `border-radius: 50%` |
| `.skeleton-image` | Image rectangle — `height: 12rem`, `border-radius: 0.5rem` |

---

## Styling details

| Property | Value |
|----------|-------|
| Background | `var(--mu-secondary-background)` |
| Animation | `mu-shimmer` — 1.5s ease-in-out infinite |
| Border radius (base) | `0.25rem` |
| Text line height | `1em` |
| Text line spacing | `0.5rem` |
| Title height | `1.5rem` |
| Avatar size | `3rem` |
| Image height | `12rem` |

---

## Accessibility

- Skeleton elements use `pointer-events: none` and `user-select: none` to prevent interaction.
- Text content inside `.skeleton` is hidden via `color: transparent` — screen readers will still read it if present, which can serve as a loading message.
- The transition from skeleton to real content is the application's JS responsibility — µCSS provides only the CSS styling and animation.

---

> See also : [µLoading](mu.loading.md) · [µSpinner](mu.spinner.md)

→ [See example](../examples/skeleton.html)
