# µSpinner

**µSpinner** is a lightweight CSS loading indicator, part of the [µCSS](.) framework. It provides an animated circular spinner available in 11 color variants and 3 sizes, with no JavaScript required.

---

## Usage

Add the `.spinner` class to an inline element (typically a `<span>`) to create a loading indicator.

```html
<span class="spinner"></span>
```

The default spinner uses the primary color and a standard size of 1.5rem.

---

## Color variants

µSpinner supports the 11 standard µCSS color roles. Add a color modifier class alongside `.spinner`:

```html
<span class="spinner spinner-primary"></span>
<span class="spinner spinner-secondary"></span>
<span class="spinner spinner-tertiary"></span>
<span class="spinner spinner-contrast"></span>
<span class="spinner spinner-accent"></span>
<span class="spinner spinner-success"></span>
<span class="spinner spinner-info"></span>
<span class="spinner spinner-warning"></span>
<span class="spinner spinner-error"></span>
<span class="spinner spinner-pop"></span>
<span class="spinner spinner-spark"></span>
```

### Color class reference

| Class               | Color variable          |
|---------------------|-------------------------|
| `.spinner-primary`  | `--mu-primary`        |
| `.spinner-secondary`| `--mu-secondary`      |
| `.spinner-tertiary` | `--mu-tertiary`       |
| `.spinner-contrast` | `--mu-contrast`       |
| `.spinner-accent`   | `--mu-accent`         |
| `.spinner-success`  | `--mu-success`        |
| `.spinner-info`     | `--mu-info`           |
| `.spinner-warning`  | `--mu-warning`        |
| `.spinner-error`    | `--mu-error`          |
| `.spinner-pop`      | `--mu-pop`            |
| `.spinner-spark`    | `--mu-spark`          |

---

## Sizes

Three sizes are available: small, default, and large.

```html
<!-- Small (1rem) -->
<span class="spinner spinner-sm spinner-primary"></span>

<!-- Default (1.5rem) -->
<span class="spinner spinner-primary"></span>

<!-- Large (2.5rem) -->
<span class="spinner spinner-lg spinner-primary"></span>
```

### Size class reference

| Class         | Width / Height | Border width |
|---------------|----------------|--------------|
| `.spinner-sm` | 1rem           | 0.15em       |
| *(default)*   | 1.5rem         | 0.2em        |
| `.spinner-lg` | 2.5rem         | 0.25em       |

---

## In-context usage

A common pattern is placing a small spinner inside a disabled button to indicate a loading state:

```html
<button class="btn btn-primary" disabled>
    <span class="spinner spinner-sm"></span>&nbsp; Loading...
</button>
```

---

## How it works

The spinner is a bordered `inline-block` element with a colored top border and a transparent-ish track (using `--mu-secondary-background`). It rotates continuously via the `mu-spin` keyframe animation (0.6s linear infinite).

---

## Accessibility

The spinner is purely visual. For screen readers, pair it with appropriate text content (e.g. "Loading...") or use an `aria-label` attribute:

```html
<span class="spinner spinner-primary" role="status" aria-label="Loading"></span>
```

---

> See also : [µLoading](mu.loading.md) · [µSkeleton](mu.skeleton.md)

→ [See example](../examples/spinner.html)
