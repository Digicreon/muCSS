# µTooltip

**µTooltip** provides pure CSS tooltips via the `data-tooltip` attribute, styled by [µCSS](.). No JavaScript is required: tooltips appear on hover or focus.

---

## Basic usage

Add the `data-tooltip` attribute to any HTML element to display a tooltip on hover. By default, the tooltip appears above the element.

```html
<span data-tooltip="This is a tooltip">Hover me</span>
```

For a clear visual rendering on inline text, you can add an underline style:

```html
<span data-tooltip="This is a tooltip"
      style="text-decoration: underline dotted; cursor: help;">this text</span>
```

---

## Placement

The `data-placement` attribute controls the tooltip position. Four positions are available:

| Value | Position |
|-------|----------|
| `top` | Above (default) |
| `bottom` | Below |
| `left` | To the left |
| `right` | To the right |

```html
<span data-tooltip="Top tooltip" data-placement="top">Top</span>
<span data-tooltip="Bottom tooltip" data-placement="bottom">Bottom</span>
<span data-tooltip="Left tooltip" data-placement="left">Left</span>
<span data-tooltip="Right tooltip" data-placement="right">Right</span>
```

---

## On buttons

Tooltips work on buttons to provide additional context about the action.

```html
<button class="btn btn-primary" data-tooltip="Save your changes">Save</button>
<button class="btn btn-ghost btn-error"
        data-tooltip="This action cannot be undone"
        data-placement="bottom">Delete</button>
```

---

## On links

Add a tooltip to a link to describe the destination or action.

```html
<p>Visit the <a href="#" data-tooltip="Go to the homepage">homepage</a>
or check the <a href="#" data-tooltip="Read the full documentation"
data-placement="bottom">documentation</a>.</p>
```

---

## On form fields

Tooltips can be placed on form elements to guide the user.

```html
<label>Username
    <input type="text"
           data-tooltip="Must be 3-20 characters"
           placeholder="Enter username">
</label>
```

---

## Attribute summary

| Attribute | Required | Description |
|-----------|----------|-------------|
| `data-tooltip` | Yes | Text displayed in the tooltip |
| `data-placement` | No | Position: `top` (default), `bottom`, `left`, `right` |

---

## Accessibility

- Tooltips are keyboard accessible via focus (`:focus` in addition to `:hover`).
- The `data-tooltip` content is read by assistive technologies.
- Avoid placing essential information only in a tooltip; the content should remain understandable without hover interaction.

> See also : [µLink](mu.link.md)

> [See example](../examples/tooltip.html)
