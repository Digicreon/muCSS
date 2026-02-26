# µPagination

**µPagination** is a flexible page navigation component, part of the [µCSS](.) framework. It supports alignment variants, sizes, responsive behavior, and borderless styling.

---

## Usage

Pagination uses a `<nav>` containing a `<ul>` with the `.pagination` class. Each page is a `<li>` with an `<a>` or `<span>` inside.

```html
<nav aria-label="Pagination">
	<ul class="pagination">
		<li class="pagination-prev"><a href="#">&laquo; Prev</a></li>
		<li><a href="#">1</a></li>
		<li class="active"><a href="#" aria-current="page">2</a></li>
		<li><a href="#">3</a></li>
		<li><a href="#">4</a></li>
		<li><a href="#">5</a></li>
		<li class="pagination-next"><a href="#">Next &raquo;</a></li>
	</ul>
</nav>
```

---

## Item states

### Active page

Add `.active` to the `<li>` to indicate the current page. The active item gets the primary color as background and disables pointer events.

```html
<li class="active"><a href="#" aria-current="page">2</a></li>
```

### Disabled

Add `.disabled` to the `<li>` to disable an item (e.g., the "Prev" button on the first page). The item is faded and non-interactive.

```html
<li class="pagination-prev disabled"><a href="#">&laquo; Prev</a></li>
```

### Ellipsis

Use `.pagination-ellipsis` with a `<span>` to indicate skipped page numbers:

```html
<li class="pagination-ellipsis"><span>&hellip;</span></li>
```

### With ellipsis and disabled

```html
<nav aria-label="Pagination">
	<ul class="pagination">
		<li class="pagination-prev disabled"><a href="#">&laquo; Prev</a></li>
		<li class="active"><a href="#" aria-current="page">1</a></li>
		<li><a href="#">2</a></li>
		<li><a href="#">3</a></li>
		<li class="pagination-ellipsis"><span>&hellip;</span></li>
		<li><a href="#">20</a></li>
		<li class="pagination-next"><a href="#">Next &raquo;</a></li>
	</ul>
</nav>
```

---

## Alignment

By default, pagination is left-aligned. Two modifier classes change the alignment:

| Class                  | Effect                    |
|------------------------|---------------------------|
| `.pagination-centered` | `justify-content: center` |
| `.pagination-end`      | `justify-content: flex-end` |

### Centered

```html
<nav aria-label="Pagination">
	<ul class="pagination pagination-centered">
		<li class="pagination-prev"><a href="#">&laquo;</a></li>
		<li><a href="#">1</a></li>
		<li class="active"><a href="#" aria-current="page">2</a></li>
		<li><a href="#">3</a></li>
		<li class="pagination-next"><a href="#">&raquo;</a></li>
	</ul>
</nav>
```

### End-aligned

```html
<nav aria-label="Pagination">
	<ul class="pagination pagination-end">
		<li class="pagination-prev"><a href="#">&laquo;</a></li>
		<li><a href="#">1</a></li>
		<li class="active"><a href="#" aria-current="page">2</a></li>
		<li><a href="#">3</a></li>
		<li class="pagination-next"><a href="#">&raquo;</a></li>
	</ul>
</nav>
```

---

## Sizes

Two size variants adjust the dimensions, padding, and font size of pagination items:

| Class             | Min-width | Height   | Padding              | Font size  |
|-------------------|-----------|----------|----------------------|------------|
| `.pagination-sm`  | 1.75rem   | 1.75rem  | `0.15rem 0.45rem`    | `0.75rem`  |
| *(default)*       | 2.25rem   | 2.25rem  | `0.25rem 0.625rem`   | `0.875rem` |
| `.pagination-lg`  | 2.75rem   | 2.75rem  | `0.375rem 0.8rem`    | `1rem`     |

```html
<ul class="pagination pagination-sm">...</ul>
<ul class="pagination pagination-lg">...</ul>
```

---

## Borderless

Remove borders from all pagination items:

```html
<nav aria-label="Pagination">
	<ul class="pagination pagination-borderless">
		<li class="pagination-prev"><a href="#">&laquo;</a></li>
		<li><a href="#">1</a></li>
		<li class="active"><a href="#" aria-current="page">2</a></li>
		<li><a href="#">3</a></li>
		<li><a href="#">4</a></li>
		<li class="pagination-next"><a href="#">&raquo;</a></li>
	</ul>
</nav>
```

---

## Responsive

Add `.pagination-responsive` to hide page numbers (except the active page and prev/next controls) on screens narrower than 640px:

```html
<nav aria-label="Pagination">
	<ul class="pagination pagination-responsive">
		<li class="pagination-prev"><a href="#">&laquo; Prev</a></li>
		<li><a href="#">1</a></li>
		<li><a href="#">2</a></li>
		<li class="active"><a href="#" aria-current="page">3</a></li>
		<li><a href="#">4</a></li>
		<li><a href="#">5</a></li>
		<li class="pagination-next"><a href="#">Next &raquo;</a></li>
	</ul>
</nav>
```

On mobile (<640px), only `.pagination-prev`, `.pagination-next`, and `.active` items are visible. The pagination stretches full width with `justify-content: space-between`.

---

## CSS classes reference

| Class                  | Applied to | Description                                      |
|------------------------|------------|--------------------------------------------------|
| `.pagination`          | `<ul>`     | Base pagination container (flex, list-style none) |
| `.pagination-prev`     | `<li>`     | Previous page item (bold text)                   |
| `.pagination-next`     | `<li>`     | Next page item (bold text)                       |
| `.active`              | `<li>`     | Current page (primary bg, non-interactive)       |
| `.disabled`            | `<li>`     | Disabled item (faded, non-interactive)           |
| `.pagination-ellipsis` | `<li>`     | Ellipsis separator (no border)                   |
| `.pagination-centered` | `<ul>`     | Center-aligned pagination                        |
| `.pagination-end`      | `<ul>`     | Right-aligned pagination                         |
| `.pagination-sm`       | `<ul>`     | Small size variant                               |
| `.pagination-lg`       | `<ul>`     | Large size variant                               |
| `.pagination-borderless` | `<ul>`   | Remove borders from items                        |
| `.pagination-responsive` | `<ul>`   | Hide non-essential items on mobile               |

---

## Accessibility

- Wrap pagination in a `<nav>` element with `aria-label="Pagination"`.
- Add `aria-current="page"` to the active page link.
- The active page and disabled items have `pointer-events: none` to prevent interaction.
- Focus-visible outlines (`2px solid`) are applied for keyboard navigation.

---

→ [Voir l'exemple](../examples/pagination.html)
