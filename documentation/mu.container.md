# µContainer

**µContainer** provides the `.container` and `.container-fluid` layout classes in [µCSS](.). The container centers content horizontally and applies a responsive maximum width adapted to each breakpoint.

---

## Usage

Wrap the main content in an element with the `.container` class:

```html
<main class="container">
    <h1>Mon contenu</h1>
    <p>Centre et contraint en largeur.</p>
</main>
```

---

## `.container` — Constrained width

The container is fluid (100%) on mobile, then constrained to a maximum width at each breakpoint:

| Breakpoint | Minimum width | `max-width` |
|------------|---------------|-------------|
| XS | < 576px | 100% (fluid) |
| SM | ≥ 576px | 510px |
| MD | ≥ 768px | 700px |
| LG | ≥ 1024px | 950px |
| XL | ≥ 1280px | 1200px |
| XXL | ≥ 1536px | 1450px |

In fluid mode (< 576px), a horizontal padding of `var(--mu-spacing)` (1rem) is applied. From 576px onward, the padding is removed and the maximum width takes over.

---

## `.container-fluid` — Full width

The fluid container always occupies 100% of the width, with constant horizontal padding:

```html
<section class="container-fluid">
    <p>Contenu pleine largeur avec marges laterales.</p>
</section>
```

---

## Typical page structure

µCSS recommends the `<body> > <header> + <main> + <footer>` structure, each containing a `.container`:

```html
<body>
    <header>
        <nav class="container">
            <ul><li><strong>Mon site</strong></li></ul>
            <ul><li><a href="#">Lien</a></li></ul>
        </nav>
    </header>
    <main class="container">
        <h1>Titre</h1>
        <p>Contenu principal.</p>
    </main>
    <footer class="container">
        <p>Pied de page</p>
    </footer>
</body>
```

The `<body> > header`, `<body> > main`, and `<body> > footer` elements receive a vertical padding of `var(--mu-block-spacing-vertical)`.

---

## Customization

The `--mu-spacing` variable (default: `1rem`) controls the horizontal padding of the container in fluid mode:

```css
:root {
    --mu-spacing: 1.5rem;
}
```

---

> See also : [µGrid](mu.grid.md)
