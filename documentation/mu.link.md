# µLink

**µLink** describes the styling of hyperlinks (`<a>`) in [µCSS](.). Links use the theme's primary color with an animated underline, and support color variants.

---

## Usage

A standard link uses the `<a>` tag without any additional class:

```html
<a href="#">Lien standard</a>
```

The link is displayed in `--mu-primary` color with a semi-transparent underline. On hover, the color darkens and the underline intensifies.

---

## Color variants

Three variants are available via CSS classes:

```html
<a href="#">Lien primaire (defaut)</a>
<a href="#" class="secondary">Lien secondaire</a>
<a href="#" class="contrast">Lien contraste</a>
```

| Class | Color | Hover |
|-------|-------|-------|
| *(default)* | `--mu-primary` | `--mu-primary-hover` |
| `.secondary` | `--mu-secondary` | `--mu-secondary-hover` |
| `.contrast` | `--mu-contrast` | `--mu-contrast-hover` |

---

## States

Links support several visual states:

| State | Trigger | Effect |
|-------|---------|--------|
| Rest | — | Primary color, transparent underline |
| Hover | `:hover` | Darker color, solid underline |
| Active | `:active` | Same style as hover |
| Focus | `:focus` | Same style as hover |
| Focus visible | `:focus-visible` | Focus ring (`box-shadow`) |
| Current | `aria-current` | Same style as hover |

---

## Link as button

A link can be styled as a button with `role="button"`:

```html
<a href="#" role="button">Action</a>
```

The link then adopts the appearance of a button (see [µButton](mu.button.md)).

---

## `aria-current` attribute

Use `aria-current` to indicate the active page in a navigation:

```html
<nav>
    <ul>
        <li><a href="/" aria-current="page">Accueil</a></li>
        <li><a href="/about">A propos</a></li>
    </ul>
</nav>
```

The link with `aria-current` (except `aria-current="false"`) permanently receives the hover style.

---

## Underline

The underline is managed via `text-decoration-color` for a subtle rendering:

- **Rest**: underline with reduced opacity (`--mu-primary-underline`)
- **Hover**: solid underline (`--mu-primary-hover-underline`)
- **Offset**: `text-underline-offset: 0.125em`

To disable the underline globally:

```css
a {
    --mu-text-decoration: none;
}
```

---

## Accessibility

- Links must have descriptive text or an `aria-label` for screen readers.
- The focus ring (`:focus-visible`) is visible for keyboard navigation.
- The color transition uses `var(--mu-transition)` (0.2s) for smooth visual feedback.
- Avoid links without `href`; use `<button>` or `role="link"` with a keyboard handler.

---

> See also : [µButton](mu.button.md) · [µNav](mu.nav.md) · [µTypography](mu.typography.md)
