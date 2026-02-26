# µForms

**µForms** extends PicoCSS form controls with size variants and validation states, part of the [µCSS](.) framework. It applies to `<input>`, `<textarea>`, and `<select>` elements.

---

## Input sizes

Two size modifiers adjust padding and font size. Without a size class, the default PicoCSS styling applies.

```html
<label>Small input
	<input type="text" class="input-sm" placeholder="Small input">
</label>
<label>Default input
	<input type="text" placeholder="Default input">
</label>
<label>Large input
	<input type="text" class="input-lg" placeholder="Large input">
</label>
```

### Size reference

| Class       | Padding                  | Font size     | Applies to                       |
|-------------|--------------------------|---------------|----------------------------------|
| `.input-sm` | `0.375rem 0.625rem`      | `0.8125rem`   | `input`, `textarea`, `select`    |
| *(default)* | *(PicoCSS default)*      | *(default)*   | `input`, `textarea`, `select`    |
| `.input-lg` | `0.75rem 1rem`           | `1.125rem`    | `input`, `textarea`, `select`    |

### Textarea sizes

```html
<label>Small textarea
	<textarea class="input-sm" placeholder="Small textarea"></textarea>
</label>
<label>Large textarea
	<textarea class="input-lg" placeholder="Large textarea"></textarea>
</label>
```

### Select sizes

```html
<label>Small select
	<select class="input-sm">
		<option>Option 1</option>
		<option>Option 2</option>
	</select>
</label>
<label>Large select
	<select class="input-lg">
		<option>Option 1</option>
		<option>Option 2</option>
	</select>
</label>
```

---

## Validation states

µForms provides two validation classes that set border color and focus ring color. For error states, use the native `aria-invalid="true"` attribute (handled by PicoCSS).

```html
<label>Success
	<input type="text" class="input-success" value="Valid value">
</label>
<label>Warning
	<input type="text" class="input-warning" value="Needs attention">
</label>
<label>Error (native)
	<input type="text" aria-invalid="true" value="Invalid value">
</label>
```

### Validation reference

| Class / Attribute        | Border color          | Focus ring color          |
|--------------------------|-----------------------|---------------------------|
| `.input-success`         | `--pico-success`      | `--pico-success-focus`    |
| `.input-warning`         | `--pico-warning`      | `--pico-warning-focus`    |
| `aria-invalid="true"`    | *(PicoCSS built-in)*  | *(PicoCSS built-in)*     |

### Validation on textarea

```html
<label>Success textarea
	<textarea class="input-success">This content is valid.</textarea>
</label>
<label>Warning textarea
	<textarea class="input-warning">This content needs review.</textarea>
</label>
```

### Validation on select

```html
<label>Success select
	<select class="input-success">
		<option>Valid choice</option>
	</select>
</label>
<label>Warning select
	<select class="input-warning">
		<option>Needs review</option>
	</select>
</label>
```

---

## Combining size and validation

Size and validation classes can be used together on the same element:

```html
<label>Small + success
	<input type="text" class="input-sm input-success" value="Small valid">
</label>
<label>Large + warning
	<input type="text" class="input-lg input-warning" value="Large needs attention">
</label>
```

---

## CSS classes reference

| Class             | Type       | Description                                          |
|-------------------|------------|------------------------------------------------------|
| `.input-sm`       | Size       | Smaller padding and font size                        |
| `.input-lg`       | Size       | Larger padding and font size                         |
| `.input-success`  | Validation | Green border, green focus ring                       |
| `.input-warning`  | Validation | Orange/yellow border, orange/yellow focus ring       |

---

## Accessibility

- Use `aria-invalid="true"` for error states (PicoCSS native support).
- Always wrap form controls inside `<label>` elements for proper association.
- Validation colors supplement, but do not replace, text-based error messages.

---

→ [Voir l'exemple](../examples/forms.html)
