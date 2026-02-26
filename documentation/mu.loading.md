# µLoading

**µLoading** describes the loading indicator states available natively in [µCSS](.) via PicoCSS. Loading states are activated using the standard `aria-busy="true"` attribute on any element, which displays an animated spinner without requiring any additional CSS class or JavaScript library.

---

## Usage

Add `aria-busy="true"` to any HTML element to show a loading spinner. The spinner is rendered via CSS and adapts to the element's context (inline for buttons and paragraphs, block-level for containers).

```html
<button aria-busy="true">Please wait...</button>
```

Remove the loading state by setting `aria-busy="false"` or removing the attribute entirely.

---

## Button loading

Apply `aria-busy="true"` on `<button>` elements to show a spinner alongside the button text. This works with all button variants.

```html
<button aria-busy="true">Please wait...</button>
<button aria-busy="true" class="secondary">Loading</button>
<button aria-busy="true" class="contrast">Processing</button>
```

---

## Standalone spinner

Use an empty `<div>` with `aria-busy="true"` to display a standalone centered spinner. Set a `min-height` so the spinner has space to render.

```html
<div aria-busy="true" style="min-height: 3rem;"></div>
```

---

## Loading on a card

Apply `aria-busy="true"` on an `<article>` to indicate the entire card is in a loading state.

```html
<article aria-busy="true">
    <p>This card is loading...</p>
</article>
```

---

## Loading paragraph

Apply `aria-busy="true"` directly on a `<p>` element to show a spinner inline with text content.

```html
<p aria-busy="true">Loading content...</p>
```

---

## Toggle loading dynamically

Use JavaScript to toggle the `aria-busy` attribute on any element to control the loading state at runtime.

```html
<button onclick="var t = document.getElementById('target'); t.ariaBusy = t.ariaBusy === 'true' ? 'false' : 'true';">
    Toggle loading state
</button>
<article id="target" aria-busy="false">
    <p>Click the button above to toggle the loading state on this card.</p>
</article>
```

---

## Supported elements

| Element       | Behavior                                      |
|---------------|-----------------------------------------------|
| `<button>`    | Spinner displayed inline before the text      |
| `<div>`       | Centered block-level spinner                  |
| `<article>`   | Spinner overlays the card content             |
| `<p>`         | Spinner displayed inline with text            |

Any element that accepts `aria-busy` can display the loading indicator.

---

## Accessibility

- `aria-busy="true"` is a standard WAI-ARIA attribute. Screen readers will announce the element as busy/loading.
- Always provide descriptive text content (e.g., "Please wait...") alongside the spinner for assistive technologies.
- Set `aria-busy="false"` when loading completes to notify screen readers that content is ready.

---

→ [Voir l'exemple](../examples/loading.html)
