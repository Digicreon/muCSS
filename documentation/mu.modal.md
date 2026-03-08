# µModal

**µModal** provides size variants and a close button for native `<dialog>` modals, part of the [µCSS](.) framework. It provides dialog styling with small, large, and fullscreen options.

---

## Usage

Modals use the native HTML `<dialog>` element containing an `<article>`. Open with JavaScript's `.showModal()` method and close with `.close()`.

```html
<dialog id="my-modal">
	<article>
		<button class="modal-close" aria-label="Close"
			onclick="document.getElementById('my-modal').close()">&times;</button>
		<h3>Modal title</h3>
		<p>Modal content goes here.</p>
		<footer>
			<button class="btn btn-primary"
				onclick="document.getElementById('my-modal').close()">Close</button>
		</footer>
	</article>
</dialog>

<!-- Trigger button -->
<button onclick="document.getElementById('my-modal').showModal()">Open modal</button>
```

---

## Size variants

4 sizes are available. Without a size class, the default dialog width applies.

| Class               | Max-width    | Description                          |
|---------------------|--------------|--------------------------------------|
| `.modal-sm`         | 400px        | Confirmations and simple prompts     |
| *(default)*         | *(default)*  | Suitable for most content            |
| `.modal-lg`         | 900px        | Forms or detailed content            |
| `.modal-fullscreen` | 100vw        | Full viewport, no border-radius      |

Size classes are applied on the `<dialog>` element, not on the inner `<article>`.

### Small modal

```html
<dialog id="modal-sm" class="modal-sm">
	<article>
		<button class="modal-close" aria-label="Close"
			onclick="document.getElementById('modal-sm').close()">&times;</button>
		<h3>Small modal</h3>
		<p>This is a small modal (max-width: 400px). Ideal for confirmations and simple prompts.</p>
		<footer>
			<button class="btn btn-outline btn-secondary"
				onclick="document.getElementById('modal-sm').close()">Cancel</button>
			<button class="btn btn-primary"
				onclick="document.getElementById('modal-sm').close()">Confirm</button>
		</footer>
	</article>
</dialog>
```

### Large modal

```html
<dialog id="modal-lg" class="modal-lg">
	<article>
		<button class="modal-close" aria-label="Close"
			onclick="document.getElementById('modal-lg').close()">&times;</button>
		<h3>Large modal</h3>
		<p>This is a large modal (max-width: 900px). Useful for forms or detailed content.</p>
		<div class="row">
			<div class="col-6">
				<label>First name <input type="text" placeholder="First name"></label>
			</div>
			<div class="col-6">
				<label>Last name <input type="text" placeholder="Last name"></label>
			</div>
		</div>
		<label>Email <input type="email" placeholder="Email address"></label>
		<footer>
			<button class="btn btn-outline btn-secondary"
				onclick="document.getElementById('modal-lg').close()">Cancel</button>
			<button class="btn btn-success"
				onclick="document.getElementById('modal-lg').close()">Save</button>
		</footer>
	</article>
</dialog>
```

### Fullscreen modal

```html
<dialog id="modal-fullscreen" class="modal-fullscreen">
	<article>
		<button class="modal-close" aria-label="Close"
			onclick="document.getElementById('modal-fullscreen').close()">&times;</button>
		<h3>Fullscreen modal</h3>
		<p>This modal covers the entire viewport. Suitable for immersive experiences,
		image galleries, or complex workflows.</p>
		<footer>
			<button class="btn btn-error"
				onclick="document.getElementById('modal-fullscreen').close()">Close</button>
		</footer>
	</article>
</dialog>
```

The fullscreen variant sets `width: 100vw`, `min-height: 100vh`, `border-radius: 0`, and `margin: 0` on the inner `<article>`.

---

## Close button

The `.modal-close` class styles a close button positioned absolutely in the top-right corner of the `<article>`.

```html
<button class="modal-close" aria-label="Close"
	onclick="document.getElementById('my-modal').close()">&times;</button>
```

| Property          | Value                           |
|-------------------|---------------------------------|
| Position          | Absolute, top-right corner      |
| Size              | 3rem x 3rem                     |
| Background        | Transparent                     |
| Color             | `--mu-secondary`              |
| Opacity           | 0.6 (1 on hover)               |
| Focus indicator   | 2px solid outline, 0.25rem radius |

---

## CSS classes reference

| Class               | Applied to   | Description                               |
|---------------------|--------------|-------------------------------------------|
| `.modal-sm`         | `<dialog>`   | Small modal (max-width: 400px)            |
| `.modal-lg`         | `<dialog>`   | Large modal (max-width: 900px)            |
| `.modal-fullscreen` | `<dialog>`   | Full viewport modal                       |
| `.modal-close`      | `<button>`   | Positioned close button (top-right)       |

---

## Opening and closing

Modals rely on the native `<dialog>` API. No JavaScript is bundled with µCSS -- behavior is the application's responsibility.

- **Open**: `document.getElementById('modal-id').showModal()`
- **Close**: `document.getElementById('modal-id').close()`
- **Backdrop click**: handled natively by `<dialog>` when opened via `.showModal()`
- **Escape key**: closes the dialog natively

---

## Accessibility

- Always include `aria-label="Close"` on the `.modal-close` button.
- The `.modal-close` button has a `:focus-visible` outline for keyboard navigation.
- Use `.showModal()` (not `.show()`) to get the modal backdrop and trap focus inside the dialog.

---

> See also : [µButton](mu.button.md)

→ [See example](../examples/modal.html)
