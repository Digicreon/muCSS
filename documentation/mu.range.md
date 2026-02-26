# µRange

**µRange** describes the native range slider styling provided by [µCSS](.) via PicoCSS. Range sliders use the standard `<input type="range">` element, which PicoCSS styles with a custom track and thumb without any additional classes.

---

## Usage

Wrap an `<input type="range">` inside a `<label>` for proper styling and accessibility. Use `min`, `max`, and `value` attributes to configure the range.

```html
<label>Volume
    <input type="range" min="0" max="100" value="50">
</label>
```

---

## With live output

Pair the range input with an `<output>` element and a small `oninput` handler to display the current value in real time.

```html
<label>Brightness: <output id="brightness-val">75</output>%
    <input type="range" min="0" max="100" value="75"
           oninput="document.getElementById('brightness-val').textContent = this.value">
</label>
```

---

## With steps

Use the `step` attribute to constrain the slider to discrete values.

```html
<label>Rating (1-5): <output id="rating-val">3</output>
    <input type="range" min="1" max="5" step="1" value="3"
           oninput="document.getElementById('rating-val').textContent = this.value">
</label>
```

---

## Disabled state

Add the `disabled` attribute to prevent interaction. The slider renders in a muted style.

```html
<label>Locked value
    <input type="range" min="0" max="100" value="60" disabled>
</label>
```

---

## In a form context

Range sliders work well inside cards (`<article>`) for settings panels.

```html
<article>
    <header>Audio settings</header>
    <label>Master volume: <output id="master-val">80</output>%
        <input type="range" min="0" max="100" value="80"
               oninput="document.getElementById('master-val').textContent = this.value">
    </label>
    <label>Bass: <output id="bass-val">50</output>%
        <input type="range" min="0" max="100" value="50"
               oninput="document.getElementById('bass-val').textContent = this.value">
    </label>
    <label>Treble: <output id="treble-val">65</output>%
        <input type="range" min="0" max="100" value="65"
               oninput="document.getElementById('treble-val').textContent = this.value">
    </label>
</article>
```

---

## Attributes reference

| Attribute  | Description                                      | Default |
|------------|--------------------------------------------------|---------|
| `min`      | Minimum value of the range                       | `0`     |
| `max`      | Maximum value of the range                       | `100`   |
| `value`    | Initial value of the slider                      | midpoint|
| `step`     | Increment between allowed values                 | `1`     |
| `disabled` | Prevents interaction, muted visual style         | -       |

---

## Accessibility

- Always wrap the range input in a `<label>` to provide an accessible name.
- The `<output>` element is semantically linked to form controls and can be associated using the `for` attribute for screen readers.
- Screen readers announce the current value, minimum, and maximum of the range slider.
- The `disabled` attribute is natively communicated to assistive technologies.
- Keyboard users can adjust the slider using arrow keys.

---

→ [Voir l'exemple](../examples/range.html)
