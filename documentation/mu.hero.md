# µHero

**µHero** is a full-width hero section component, part of the [µCSS](.) framework. It provides 8 color roles with gradient backgrounds, badges, call-to-action buttons, and responsive sizing.

---

## Basic usage

Apply `.hero` along with a color variant class to a `<section>`. Use an inner `.container` for content width:

```html
<section class="hero hero-primary">
    <div class="container">
        <h1>Title</h1>
        <p class="hero-tagline">Tagline text</p>
    </div>
</section>
```

The hero must be placed **outside** `<main class="container">` for full-width rendering.

---

## Color variants (8 colors)

All 8 color roles are available:

```html
<section class="hero hero-primary">...</section>
<section class="hero hero-secondary">...</section>
<section class="hero hero-tertiary">...</section>
<section class="hero hero-contrast">...</section>
<section class="hero hero-success">...</section>
<section class="hero hero-info">...</section>
<section class="hero hero-warning">...</section>
<section class="hero hero-error">...</section>
```

Each variant defines `--hero-color` and `--hero-text` using the corresponding `--pico-{role}` and `--pico-{role}-inverse` variables (bridge pattern).

| Class | Background | Text color |
|-------|-----------|------------|
| `.hero-primary` | `--pico-primary` | `--pico-primary-inverse` |
| `.hero-secondary` | `--pico-secondary` | `--pico-secondary-inverse` |
| `.hero-tertiary` | `--pico-tertiary` | `--pico-tertiary-inverse` |
| `.hero-contrast` | `--pico-contrast` | `--pico-contrast-inverse` |
| `.hero-success` | `--pico-success` | `--pico-success-inverse` |
| `.hero-info` | `--pico-info` | `--pico-info-inverse` |
| `.hero-warning` | `--pico-warning` | `--pico-warning-inverse` |
| `.hero-error` | `--pico-error` | `--pico-error-inverse` |

---

## Full hero

A complete hero with title, tagline, subtitle, badges and action buttons:

```html
<section class="hero hero-primary">
    <div class="container">
        <h1>My Project</h1>
        <p class="hero-tagline">A short description of the project</p>
        <p class="hero-subtitle">Additional details about the project</p>
        <div class="hero-badges">
            <span class="badge badge-pill">Feature 1</span>
            <span class="badge badge-pill">Feature 2</span>
            <span class="badge badge-pill">Feature 3</span>
        </div>
        <div class="hero-actions">
            <a class="btn btn-primary" href="#">Get Started</a>
            <a class="btn btn-secondary" href="#">GitHub</a>
        </div>
    </div>
</section>
```

---

## Tagline and subtitle

- `.hero-tagline` — Larger text (1.35rem), opacity 0.9
- `.hero-subtitle` — Smaller text (1.05rem), opacity 0.75

---

## Badges

Wrap `.badge` elements inside `.hero-badges` for a centered flex row with semi-transparent white background:

```html
<div class="hero-badges">
    <span class="badge badge-pill">Badge 1</span>
    <span class="badge badge-pill">Badge 2</span>
</div>
```

---

## Action buttons

Wrap `.btn` elements inside `.hero-actions`. Inside a hero, buttons are styled to contrast with the gradient background:

- `.btn-primary` — White background, hero color text (inverted)
- `.btn-secondary` — Semi-transparent white background, inherited text color

```html
<div class="hero-actions">
    <a class="btn btn-primary" href="#">Primary action</a>
    <a class="btn btn-secondary" href="#">Secondary action</a>
</div>
```

---

## Flat variant

Use `.hero-flat` for a solid background without gradient:

```html
<section class="hero hero-primary hero-flat">
    <div class="container">
        <h1>Flat Hero</h1>
        <p class="hero-tagline">Solid color background</p>
    </div>
</section>
```

---

## Left-aligned variant

Use `.hero-start` for left-aligned content:

```html
<section class="hero hero-primary hero-start">
    <div class="container">
        <h1>Left-Aligned</h1>
        <p class="hero-tagline">Content aligned to the start</p>
    </div>
</section>
```

---

## CSS classes reference

| Class | Description |
|-------|-------------|
| `.hero` | Base hero section (centered, padded, gradient background) |
| `.hero-{color}` | Color variant (`primary`, `secondary`, `tertiary`, `contrast`, `success`, `info`, `warning`, `error`) |
| `.hero-tagline` | Tagline text (1.35rem, opacity 0.9) |
| `.hero-subtitle` | Subtitle text (1.05rem, opacity 0.75) |
| `.hero-badges` | Flex container for badges |
| `.hero-actions` | Flex container for CTA buttons |
| `.hero-flat` | Solid background without gradient |
| `.hero-start` | Left-aligned content |

---

## Styling details

| Property | Value |
|----------|-------|
| Padding | `4rem 0 3rem` (default), `3rem 0 2rem` (mobile), `5rem 0 4rem` (desktop) |
| Gradient | `linear-gradient(135deg, --hero-color 0%, color-mix(...70%, #000) 100%)` |
| Title size | `3.5rem` (default), `2.5rem` (mobile), `4rem` (desktop) |
| Badge background | `rgba(255, 255, 255, 0.2)` with `backdrop-filter: blur(4px)` |

---

## Responsive

The hero adapts across three breakpoints:

| Breakpoint | Title | Tagline | Padding |
|------------|-------|---------|---------|
| < 640px | 2.5rem | 1.15rem | 3rem / 2rem |
| 640–960px | 3.5rem | 1.35rem | 4rem / 3rem |
| > 960px | 4rem | 1.5rem | 5rem / 4rem |

---

## Accessibility

- Use semantic `<section>` elements for heroes
- Use `<h1>` for the main title
- Action links use `.btn` classes which include `:focus-visible` outlines
- Color contrast is ensured via `--pico-{role}-inverse` text colors

---

→ [Voir l'exemple](../examples/hero.html)
