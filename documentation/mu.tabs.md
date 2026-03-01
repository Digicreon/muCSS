# µTabs

**µTabs** is a tab navigation component for the [µCSS](.) framework. It supports standard underlined tabs and pill-style tabs, with options for alignment and fullwidth layout. Tab switching behavior is left to the application's JavaScript.

---

## Usage

Create a `<ul>` with the `.tabs` class. Each tab is an `<a>` inside a `<li>`. Mark the active tab with `aria-selected="true"`.

```html
<ul class="tabs" role="tablist">
    <li><a href="#" role="tab" aria-selected="true">Dashboard</a></li>
    <li><a href="#" role="tab">Profile</a></li>
    <li><a href="#" role="tab">Settings</a></li>
</ul>
```

The active tab displays a colored bottom border and bold text. Inactive tabs show a subtle secondary color that changes on hover.

---

## Variants

### Standard tabs

The default style uses an underline indicator with a bottom border.

```html
<ul class="tabs" role="tablist">
    <li><a href="#" role="tab" aria-selected="true">Dashboard</a></li>
    <li><a href="#" role="tab">Profile</a></li>
    <li><a href="#" role="tab">Settings</a></li>
</ul>
```

### Pill tabs

Add `.tabs-pills` for a rounded pill style. The active tab gets a filled background instead of an underline.

```html
<ul class="tabs tabs-pills" role="tablist">
    <li><a href="#" role="tab" aria-selected="true">Overview</a></li>
    <li><a href="#" role="tab">Details</a></li>
    <li><a href="#" role="tab">Reviews</a></li>
</ul>
```

---

## Alignment

### Centered

```html
<ul class="tabs tabs-centered" role="tablist">
    <li><a href="#" role="tab" aria-selected="true">Home</a></li>
    <li><a href="#" role="tab">About</a></li>
    <li><a href="#" role="tab">Contact</a></li>
</ul>
```

### End-aligned (right)

```html
<ul class="tabs tabs-end" role="tablist">
    <li><a href="#" role="tab" aria-selected="true">Home</a></li>
    <li><a href="#" role="tab">About</a></li>
    <li><a href="#" role="tab">Contact</a></li>
</ul>
```

### Fullwidth

Each tab takes equal width, filling the entire container.

```html
<ul class="tabs tabs-fullwidth" role="tablist">
    <li><a href="#" role="tab" aria-selected="true">Tab A</a></li>
    <li><a href="#" role="tab">Tab B</a></li>
    <li><a href="#" role="tab">Tab C</a></li>
</ul>
```

---

## Combining modifiers

Modifiers can be combined freely. Common combinations:

```html
<!-- Centered pills -->
<ul class="tabs tabs-pills tabs-centered" role="tablist">
    <li><a href="#" role="tab" aria-selected="true">Overview</a></li>
    <li><a href="#" role="tab">Details</a></li>
    <li><a href="#" role="tab">Reviews</a></li>
</ul>

<!-- Fullwidth pills -->
<ul class="tabs tabs-pills tabs-fullwidth" role="tablist">
    <li><a href="#" role="tab" aria-selected="true">Day</a></li>
    <li><a href="#" role="tab">Week</a></li>
    <li><a href="#" role="tab">Month</a></li>
</ul>
```

---

## Tab panels

µTabs does not include JavaScript. Panel switching is the application's responsibility. A typical pattern uses `data-tab` and `data-tab-panel` attributes with the `hidden` attribute:

```html
<ul class="tabs" role="tablist">
    <li><a href="#" role="tab" aria-selected="true" data-tab="std-1">Dashboard</a></li>
    <li><a href="#" role="tab" data-tab="std-2">Profile</a></li>
    <li><a href="#" role="tab" data-tab="std-3">Settings</a></li>
</ul>
<div data-tab-panel="std-1">Dashboard content — overview of your account activity.</div>
<div data-tab-panel="std-2" hidden>Profile content — manage your personal information.</div>
<div data-tab-panel="std-3" hidden>Settings content — configure your preferences.</div>
```

---

## Class reference

| Class              | Effect                                                        |
|--------------------|---------------------------------------------------------------|
| `.tabs`            | Base flex container with bottom border, removes list-style    |
| `.tabs-pills`      | Pill variant: no bottom border, rounded backgrounds           |
| `.tabs-centered`   | Center-align tabs (`justify-content: center`)                 |
| `.tabs-end`        | Right-align tabs (`justify-content: flex-end`)                |
| `.tabs-fullwidth`  | Equal-width tabs filling the container (`flex: 1` on `<li>`)  |

---

## Active state

The active tab is indicated by the `aria-selected="true"` attribute on the `<a>` element:

| Style    | Active appearance                                                       |
|----------|-------------------------------------------------------------------------|
| Standard | Primary-colored bottom border, `font-weight: 600`, primary text color   |
| Pills    | Filled primary background, inverse text color, no border                |

---

## Accessibility

- Use `role="tablist"` on the `<ul>` container.
- Use `role="tab"` on each `<a>` element.
- Set `aria-selected="true"` on the active tab and `aria-selected="false"` (or omit) on inactive tabs.
- Associate panels with `role="tabpanel"` and `aria-labelledby` for full WAI-ARIA compliance.

---

## Implementation note

The base styles apply `list-style: square` to `ul li` elements. µTabs explicitly sets `list-style: none` on `.tabs` and `.tabs li` to neutralize this default and prevent bullet markers from appearing next to tab items.

---

> See also : [µNav](mu.nav.md) · [µAccordion](mu.accordion.md)

→ [See example](../examples/tabs.html)
