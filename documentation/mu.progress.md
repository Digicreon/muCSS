# µProgress

**µProgress** adds 8 color variants to the native `<progress>` element, part of the [µCSS](.) framework. It uses `accent-color` and vendor-specific pseudo-elements for cross-browser compatibility.

---

## Usage

Apply a color class directly on a `<progress>` element to change the bar color. Without a color class, the default PicoCSS progress styling applies.

```html
<progress class="progress-primary" value="75" max="100">75%</progress>
```

The text content inside `<progress>` serves as a fallback for browsers that do not support the element.

---

## Color variants

8 color classes are available, matching the µCSS color roles:

| Class                | Color variable       |
|----------------------|----------------------|
| `.progress-primary`  | `--pico-primary`     |
| `.progress-secondary`| `--pico-secondary`   |
| `.progress-tertiary` | `--pico-tertiary`    |
| `.progress-contrast` | `--pico-contrast`    |
| `.progress-success`  | `--pico-success`     |
| `.progress-info`     | `--pico-info`        |
| `.progress-warning`  | `--pico-warning`     |
| `.progress-error`    | `--pico-error`       |

### All 8 variants

```html
<label>Primary (75%)
	<progress class="progress-primary" value="75" max="100">75%</progress>
</label>
<label>Secondary (60%)
	<progress class="progress-secondary" value="60" max="100">60%</progress>
</label>
<label>Tertiary (45%)
	<progress class="progress-tertiary" value="45" max="100">45%</progress>
</label>
<label>Contrast (90%)
	<progress class="progress-contrast" value="90" max="100">90%</progress>
</label>
<label>Success (80%)
	<progress class="progress-success" value="80" max="100">80%</progress>
</label>
<label>Info (50%)
	<progress class="progress-info" value="50" max="100">50%</progress>
</label>
<label>Warning (35%)
	<progress class="progress-warning" value="35" max="100">35%</progress>
</label>
<label>Error (20%)
	<progress class="progress-error" value="20" max="100">20%</progress>
</label>
```

---

## Various values

The `value` attribute controls the fill level. Set `max` to define the scale (typically 100).

```html
<progress class="progress-primary" value="0" max="100">0%</progress>
<progress class="progress-success" value="25" max="100">25%</progress>
<progress class="progress-info" value="50" max="100">50%</progress>
<progress class="progress-primary" value="100" max="100">100%</progress>
```

---

## Indeterminate

Omit the `value` attribute to create an indeterminate progress bar (animated loading indicator):

```html
<progress class="progress-primary">Loading...</progress>
```

---

## Cross-browser implementation

Each color variant sets three properties for full browser support:

| Property                        | Target           |
|---------------------------------|------------------|
| `accent-color`                  | Modern browsers  |
| `::-webkit-progress-value`      | Chrome, Safari   |
| `::-moz-progress-bar`           | Firefox          |

---

## CSS classes reference

| Class                | Description                          |
|----------------------|--------------------------------------|
| `.progress-primary`  | Primary color progress bar           |
| `.progress-secondary`| Secondary color progress bar         |
| `.progress-tertiary` | Tertiary color progress bar          |
| `.progress-contrast` | Contrast color progress bar          |
| `.progress-success`  | Success (green) progress bar         |
| `.progress-info`     | Info (blue) progress bar             |
| `.progress-warning`  | Warning (orange/yellow) progress bar |
| `.progress-error`    | Error (red) progress bar             |

---

## Accessibility

- The `<progress>` element is natively accessible and announced by screen readers.
- Include fallback text content inside the element (e.g., `75%`) for older browsers.
- Wrap progress bars inside `<label>` elements to provide descriptive context.

---

→ [Voir l'exemple](../examples/progress.html)
