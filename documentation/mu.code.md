# µCode

**µCode** describes the styling of source code elements in [µCSS](.): inline code (`<code>`), code blocks (`<pre>`), keyboard shortcuts (`<kbd>`), and sample output (`<samp>`).

---

## Usage

An inline code fragment uses the `<code>` tag:

```html
<p>Utilisez <code>var(--mu-primary)</code> pour la couleur primaire.</p>
```

---

## Inline code

The `<code>`, `<kbd>`, and `<samp>` elements are displayed as `inline-block` with a colored background and border-radius:

```html
<p>La commande <code>npm install</code> installe les dependances.</p>
<p>Appuyez sur <kbd>Ctrl</kbd> + <kbd>C</kbd> pour copier.</p>
<p>Le programme affiche <samp>Hello World</samp>.</p>
```

| Element | Background | Text color |
|---------|------------|------------|
| `<code>` | `--mu-code-background-color` | `--mu-code-color` |
| `<samp>` | `--mu-code-background-color` | `--mu-code-color` |
| `<kbd>` | `--mu-code-kbd-background-color` | `--mu-code-kbd-color` |

The `<kbd>` element uses a dark background and light text to visually stand out as a keyboard shortcut.

---

## Code block

Wrap `<code>` inside `<pre>` for a code block with horizontal scrolling:

```html
<pre><code>function hello() {
    console.log("Hello, World!");
    return true;
}</code></pre>
```

The block receives a padding of `var(--mu-spacing)` and `overflow-x: auto` to handle long lines.

---

## Typographic properties

All code elements use the theme's monospace font:

| Property | Value |
|----------|-------|
| Font | `--mu-font-family` (monospace) |
| Size | `0.875em` (relative to parent) |
| Weight | `--mu-font-weight` |
| Border-radius | `--mu-border-radius` |
| Padding (inline) | `0.375rem` |
| Padding (block) | `var(--mu-spacing)` |

---

## Customization

```css
:root {
    /* Changer le fond du code inline */
    --mu-code-background-color: #f0f0f0;

    /* Changer la couleur du texte de code */
    --mu-code-color: #333;

    /* Personnaliser les touches clavier */
    --mu-code-kbd-background-color: #333;
    --mu-code-kbd-color: #fff;
}
```

---

> See also : [µTypography](mu.typography.md) · [µVariables](mu.variables.md)
