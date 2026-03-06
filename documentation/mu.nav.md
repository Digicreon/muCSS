# µNav

**µNav** provides the responsive navigation bar via the `<nav>` element in [µCSS](.). The navigation uses flexbox to distribute items, with automatic spacing and link styling. On mobile (< 640px), links collapse into a ☰ burger menu via a CSS-only checkbox hack.

---

## Usage

A basic responsive navigation uses `<nav>` with a brand `<ul>`, a hidden checkbox, a burger label, and a `<ul class="navbar-menu">` for the links:

```html
<nav>
    <ul><li><strong>Mon site</strong></li></ul>
    <input type="checkbox" id="my-nav" class="navbar-toggle" hidden>
    <label for="my-nav" class="navbar-burger">☰</label>
    <ul class="navbar-menu">
        <li><a href="#">Accueil</a></li>
        <li><a href="#">A propos</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
</nav>
```

On desktop, the burger is hidden and links display inline (flex row). On mobile, the burger appears and links are hidden until the user clicks ☰. Each burger needs a unique `id`/`for` pair.

---

## Navigation in a header

Place `<nav>` inside a `<header>` with a `.container` for a full-width navigation bar:

```html
<header>
    <nav class="container">
        <ul><li><strong>µCSS</strong></li></ul>
        <input type="checkbox" id="header-nav" class="navbar-toggle" hidden>
        <label for="header-nav" class="navbar-burger">☰</label>
        <ul class="navbar-menu">
            <li><a href="#">Docs</a></li>
            <li><a href="#">Exemples</a></li>
            <li><a href="#" role="button">Telecharger</a></li>
        </ul>
    </nav>
</header>
```

---

## Links and buttons in nav

All links inside `<nav>` have no underline (including on hover), whether in the brand area or in `.navbar-menu`. Buttons integrate automatically:

```html
<nav>
    <ul><li><strong>App</strong></li></ul>
    <input type="checkbox" id="nav-app" class="navbar-toggle" hidden>
    <label for="nav-app" class="navbar-burger">☰</label>
    <ul class="navbar-menu">
        <li><a href="#">Lien</a></li>
        <li><a href="#" role="button">Bouton</a></li>
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

A dropdown menu can be integrated inside the `.navbar-menu` via `<details class="dropdown">`:

```html
<nav>
    <ul><li><strong>App</strong></li></ul>
    <input type="checkbox" id="nav-dd" class="navbar-toggle" hidden>
    <label for="nav-dd" class="navbar-burger">☰</label>
    <ul class="navbar-menu">
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

## Colored navbars

Use `.bg-{role}` on the `<nav>` or on a parent element (e.g. `<header>`) — a gradient (same as [µHero](mu.hero.md)) is applied automatically, and text/links switch to inverse (light) color.

Directly on `<nav>`:

```html
<nav class="bg-primary">
    <ul><li><strong>Brand</strong></li></ul>
    <input type="checkbox" id="nav-color" class="navbar-toggle" hidden>
    <label for="nav-color" class="navbar-burger">☰</label>
    <ul class="navbar-menu">
        <li><a href="#">Accueil</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
</nav>
```

For a full-width colored bar with a contained nav, place `.bg-{role}` on the parent `<header>`:

```html
<header class="bg-primary">
    <nav class="container">
        <ul><li><strong>Brand</strong></li></ul>
        <input type="checkbox" id="nav-full" class="navbar-toggle" hidden>
        <label for="nav-full" class="navbar-burger">☰</label>
        <ul class="navbar-menu">
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>
</header>
```

The gradient uses `color-mix(in oklch)` to darken the role color, ensuring good contrast with white text. On mobile, the dropdown uses standard dropdown colors (not the navbar background), so links remain readable.

---

## Active link

Add `.active` to a link to bold it, indicating the current page:

```html
<ul class="navbar-menu">
    <li><a href="#" class="active">Accueil</a></li>
    <li><a href="#">A propos</a></li>
    <li><a href="#">Contact</a></li>
</ul>
```

---

## Sticky and fixed navbars

Use the utility classes `.sticky-top`, `.fixed-top`, or `.fixed-bottom` on a `<nav>`. When used on a nav, a `z-index` and `box-shadow` are added automatically:

```html
<nav class="sticky-top">
    <ul><li><strong>Brand</strong></li></ul>
    <input type="checkbox" id="nav-s" class="navbar-toggle" hidden>
    <label for="nav-s" class="navbar-burger">☰</label>
    <ul class="navbar-menu">
        <li><a href="#" class="active">Accueil</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
</nav>
```

- `.sticky-top` — stays in flow, sticks to the top on scroll (recommended for navbars)
- `.fixed-top` — always fixed to the viewport top (content flows behind, add `padding-top` on body)
- `.fixed-bottom` — fixed to the viewport bottom (useful for mobile action bars)

These classes are generic utilities defined in `mu.utilities.css` and work on any element (e.g., sticky `<thead>`, sticky sidebar). See [µUtilities](mu.utilities.md).

---

## Accessibility

- Use `<nav>` as a landmark element for the main navigation.
- Add `aria-label` to distinguish multiple `<nav>` elements on the same page (e.g., `aria-label="Navigation principale"`).
- Links in the nav are keyboard-accessible with visible focus (outline + border-radius).
- For production use, add `aria-label="Menu"` to the burger label and manage `aria-expanded` via JavaScript.
- For breadcrumbs, use `aria-label="breadcrumb"` on the `<nav>` (see [µBreadcrumb](mu.breadcrumb.md)).

---

> See also : [µBreadcrumb](mu.breadcrumb.md) · [µDropdown](mu.dropdown.md) · [µContainer](mu.container.md)
