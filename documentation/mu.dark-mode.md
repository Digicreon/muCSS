# µDark Mode

**µDark Mode** manages the toggle between light and dark themes in [µCSS](.). Dark mode is activated either automatically via the user's system preference (`prefers-color-scheme`), or manually via the `data-theme` attribute on the root element.

---

## Usage

No configuration is required for automatic mode. µCSS detects the system preference and adapts colors accordingly.

To force a theme, add `data-theme` on `<html>`:

```html
<html data-theme="dark">
```

---

## Available modes

| Mode | Trigger | CSS Selector |
|------|---------|--------------|
| Light (default) | System preference or `data-theme="light"` | `:root:not([data-theme="dark"])` |
| Auto dark | `prefers-color-scheme: dark` without `data-theme` | `@media (prefers-color-scheme: dark) { :root:not([data-theme]) }` |
| Forced dark | `data-theme="dark"` | `[data-theme="dark"]` |

---

## Manual toggle

A JavaScript button allows the user to toggle between themes:

```html
<button id="theme-toggle">Toggle theme</button>

<script>
const btn = document.getElementById('theme-toggle');
btn.addEventListener('click', () => {
    const html = document.documentElement;
    const current = html.getAttribute('data-theme');
    html.setAttribute('data-theme', current === 'dark' ? 'light' : 'dark');
});
</script>
```

---

## Affected color variables

All µCSS color variables adapt to the theme. The main ones:

| Variable | Light theme | Dark theme |
|----------|-------------|------------|
| `--mu-background-color` | `#fff` | `rgb(19, 22.5, 30.5)` |
| `--mu-color` | `#373c44` | `#c2c7d0` |
| `--mu-primary` | `#0172ad` | `#01aaff` |
| `--mu-muted-color` | `#646b79` | `#8891a4` |
| `--mu-card-background-color` | `#fff` | `rgb(24, 28.5, 38)` |

The full list is available in [mu.variables.md](mu.variables.md).

---

## `color-scheme` property

µCSS sets `color-scheme: light` or `color-scheme: dark` depending on the active theme. This native CSS property informs the browser of the color scheme, which affects scrollbars, native form fields, and other browser UI elements.

---

## Color customization

To override the colors of a theme, target the corresponding selector:

```css
/* Override the background in dark mode */
[data-theme="dark"] {
    --mu-background-color: #1a1a2e;
}

/* Override in light mode */
:root:not([data-theme="dark"]) {
    --mu-primary: #e63946;
}
```

---

## Accessibility

- Theme toggling must not modify the content or structure of the page.
- Color contrasts comply with WCAG AA recommendations in both themes.
- Using `prefers-color-scheme` as the default mode respects user preferences.

---

> See also : [µVariables](mu.variables.md)
