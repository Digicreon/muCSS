# µCard

**µCard** provides colored card variants for the `<article>` element, part of the [µCSS](.) framework. It extends PicoCSS's default card styling with 8 color accents, automatic header/footer shading, and a left border indicator.

---

## Usage

Cards use the standard HTML `<article>` element. Add a color class to apply a colored variant with a left border accent and tinted background.

```html
<article class="card-primary">
	<header>Card title</header>
	Card body content.
	<footer>Card footer</footer>
</article>
```

A card can contain any combination of `<header>`, body content, and `<footer>`. All three sections are optional.

### Body only

```html
<article class="card-info">
	<p>A simple card with content only, no header or footer.</p>
</article>
```

### Default card (no color)

Without a color class, `<article>` renders with the standard PicoCSS card styling:

```html
<article>
	<header>Standard card</header>
	This card uses the default styling without any color class.
	<footer>Footer</footer>
</article>
```

---

## Color variants

8 color classes are available, matching the µCSS color roles:

| Class             | Color role | Left border          | Background                 |
|-------------------|------------|----------------------|----------------------------|
| `.card-primary`   | Primary    | `--pico-primary`     | `--pico-primary-background`   |
| `.card-secondary` | Secondary  | `--pico-secondary`   | `--pico-secondary-background` |
| `.card-tertiary`  | Tertiary   | `--pico-tertiary`    | `--pico-tertiary-background`  |
| `.card-contrast`  | Contrast   | `--pico-contrast`    | `--pico-contrast-background`  |
| `.card-success`   | Success    | `--pico-success`     | `--pico-success-background`   |
| `.card-info`      | Info       | `--pico-info`        | `--pico-info-background`      |
| `.card-warning`   | Warning    | `--pico-warning`     | `--pico-warning-background`   |
| `.card-error`     | Error      | `--pico-error`       | `--pico-error-background`     |

### All 8 variants example

```html
<div class="row">
	<div class="col-12 col-md-6">
		<article class="card-primary">
			<header>Primary</header>
			Card body with primary accent.
			<footer>Card footer</footer>
		</article>
	</div>
	<div class="col-12 col-md-6">
		<article class="card-secondary">
			<header>Secondary</header>
			Card body with secondary accent.
			<footer>Card footer</footer>
		</article>
	</div>
	<div class="col-12 col-md-6">
		<article class="card-success">
			<header>Success</header>
			Card body with success accent.
			<footer>Card footer</footer>
		</article>
	</div>
	<div class="col-12 col-md-6">
		<article class="card-error">
			<header>Error</header>
			Card body with error accent.
			<footer>Card footer</footer>
		</article>
	</div>
</div>
```

---

## Visual structure

Colored cards (`article[class*="card-"]`) apply the following styles:

- **Left border**: 4px solid in the card's color role.
- **Background**: the card's light background tint.
- **Header/footer background**: a `color-mix()` blend of 12% card color into the card background, creating a subtle shading difference.
- **Header border-bottom / footer border-top**: `color-mix()` blend of 20% card color, providing a gentle separator.

---

## PicoCSS override

µCard includes one global fix:

```css
article > *:last-child:not(header):not(footer) {
	margin-bottom: 0;
}
```

This removes the bottom margin on the last content element inside a card (e.g., a `<p>` tag), preventing unwanted spacing before the card's bottom edge or footer. This is necessary because PicoCSS applies default margins to `<p>` elements.

---

## CSS classes reference

| Class             | Description                                      |
|-------------------|--------------------------------------------------|
| `.card-primary`   | Primary color variant                            |
| `.card-secondary` | Secondary color variant                          |
| `.card-tertiary`  | Tertiary color variant                           |
| `.card-contrast`  | Contrast color variant                           |
| `.card-success`   | Success color variant                            |
| `.card-info`      | Info color variant                               |
| `.card-warning`   | Warning color variant                            |
| `.card-error`     | Error color variant                              |

---

→ [Voir l'exemple](../examples/card.html)
