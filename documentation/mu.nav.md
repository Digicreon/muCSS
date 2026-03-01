# µNav

**µNav** provides the responsive navigation bar via the `<nav>` element in [µCSS](.). The navigation uses flexbox to distribute items, with automatic spacing and link styling.

---

## Usage

A basic navigation uses `<nav>` with `<ul>` lists:

```html
<nav>
    <ul><li><strong>Mon site</strong></li></ul>
    <ul>
        <li><a href="#">Accueil</a></li>
        <li><a href="#">A propos</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
</nav>
```

The first list is aligned to the left, the last to the right, with `justify-content: space-between`.

---

## Navigation in a header

Place `<nav>` inside a `<header>` with a `.container` for a full-width navigation bar:

```html
<header>
    <nav class="container">
        <ul><li><strong>µCSS</strong></li></ul>
        <ul>
            <li><a href="#">Docs</a></li>
            <li><a href="#">Exemples</a></li>
            <li><a href="#" role="button">Telecharger</a></li>
        </ul>
    </nav>
</header>
```

---

## Links and buttons in nav

Links inside `<nav>` lose their underline by default (except on hover) and receive a `border-radius` for focus. Buttons and form fields integrate automatically:

```html
<nav>
    <ul><li><strong>App</strong></li></ul>
    <ul>
        <li><a href="#">Lien</a></li>
        <li><a href="#" role="button">Bouton</a></li>
        <li><input type="search" placeholder="Rechercher..."></li>
    </ul>
</nav>
```

---

## Customization variables

| Variable | Default | Description |
|----------|---------|-------------|
| `--mu-nav-element-spacing-vertical` | `1rem` | Vertical padding of items |
| `--mu-nav-element-spacing-horizontal` | `0.5rem` | Horizontal padding of items |
| `--mu-nav-link-spacing-vertical` | `0.5rem` | Vertical padding of links |
| `--mu-nav-link-spacing-horizontal` | `0.5rem` | Horizontal padding of links |
| `--mu-nav-breadcrumb-divider` | `">"` | Breadcrumb separator |

---

## Dropdown in nav

A dropdown menu can be integrated into the navigation via `<details class="dropdown">`:

```html
<nav>
    <ul><li><strong>App</strong></li></ul>
    <ul>
        <li><a href="#">Accueil</a></li>
        <li>
            <details class="dropdown">
                <summary>Menu</summary>
                <ul>
                    <li><a href="#">Option 1</a></li>
                    <li><a href="#">Option 2</a></li>
                </ul>
            </details>
        </li>
    </ul>
</nav>
```

---

## Accessibility

- Use `<nav>` as a landmark element for the main navigation.
- Add `aria-label` to distinguish multiple `<nav>` elements on the same page (e.g., `aria-label="Navigation principale"`).
- Links in the nav are keyboard-accessible with visible focus (outline + border-radius).
- For breadcrumbs, use `aria-label="breadcrumb"` on the `<nav>` (see [µBreadcrumb](mu.breadcrumb.md)).

---

> See also : [µBreadcrumb](mu.breadcrumb.md) · [µDropdown](mu.dropdown.md) · [µContainer](mu.container.md)
