# µTypography

**µTypography** regroupe les elements typographiques natifs HTML styles par [PicoCSS](https://picocss.com) au sein du framework [µCSS](.). Aucun fichier CSS supplementaire n'est necessaire : les titres, paragraphes, listes, citations, code et elements semantiques inline sont styles automatiquement.

---

## Titres

Les six niveaux de titres HTML sont styles avec des tailles et graisses progressives.

```html
<h1>Heading 1</h1>
<h2>Heading 2</h2>
<h3>Heading 3</h3>
<h4>Heading 4</h4>
<h5>Heading 5</h5>
<h6>Heading 6</h6>
```

### Heading group

L'element `<hgroup>` permet d'associer un titre principal a un sous-titre ou une accroche.

```html
<hgroup>
    <h2>Main heading</h2>
    <p>Subtitle or tagline below the heading.</p>
</hgroup>
```

Le paragraphe a l'interieur de `<hgroup>` est affiche dans un style attenue (couleur secondaire, taille reduite).

---

## Paragraphes

Les paragraphes utilisent le style par defaut de PicoCSS avec un espacement vertical harmonieux.

```html
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua.</p>
<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
dolore eu fugiat nulla pariatur.</p>
```

---

## Citations

L'element `<blockquote>` affiche une citation avec un style visuel distinct (bordure laterale, retrait). Un `<footer>` avec `<cite>` permet d'attribuer la source.

```html
<blockquote>
    "Design is not just what it looks like and feels like. Design is how it works."
    <footer><cite>Steve Jobs</cite></footer>
</blockquote>
```

---

## Listes

### Liste non ordonnee

```html
<ul>
    <li>First item</li>
    <li>Second item
        <ul>
            <li>Nested item A</li>
            <li>Nested item B</li>
        </ul>
    </li>
    <li>Third item</li>
</ul>
```

### Liste ordonnee

```html
<ol>
    <li>Step one</li>
    <li>Step two</li>
    <li>Step three</li>
</ol>
```

### Liste de definitions

```html
<dl>
    <dt>Term</dt>
    <dd>Definition of the term.</dd>
    <dt>Another term</dt>
    <dd>Another definition.</dd>
</dl>
```

---

## Texte inline semantique

PicoCSS style automatiquement les elements semantiques inline :

| Element | Rendu | Usage |
|---------|-------|-------|
| `<strong>` | **Gras** | Importance forte |
| `<em>` | *Italique* | Emphase |
| `<u>` | Souligne | Annotation |
| `<small>` | Petit texte | Mentions legales, notes |
| `<del>` | ~~Barre~~ | Texte supprime |
| `<ins>` | Souligne | Texte insere |
| `<abbr>` | Pointille | Abreviation (avec `title`) |
| `<mark>` | Surligne | Texte mis en evidence |
| `<sub>` | Indice | Formules, notes |
| `<sup>` | Exposant | References, puissances |

```html
<p><strong>Bold text</strong> and <em>italic text</em> and <u>underlined text</u>.</p>
<p><small>Small text</small> and <del>deleted text</del> and <ins>inserted text</ins>.</p>
<p><abbr title="Cascading Style Sheets">CSS</abbr> is an abbreviation.</p>
<p><mark>Highlighted text</mark> using the mark element.</p>
<p>Text with <sub>subscript</sub> and <sup>superscript</sup>.</p>
```

---

## Code

### Code inline

L'element `<code>` affiche du code dans une police monospace avec un fond legerement colore.

```html
<p>Inline <code>code element</code> within text.</p>
```

### Bloc de code

Le couple `<pre><code>` affiche un bloc de code preformate avec fond distinct et defilement horizontal si necessaire.

```html
<pre><code>&lt;div class="container"&gt;
  &lt;h1&gt;Hello World&lt;/h1&gt;
  &lt;p&gt;This is a code block.&lt;/p&gt;
&lt;/div&gt;</code></pre>
```

---

## Clavier

L'element `<kbd>` represente une touche ou combinaison de touches avec un style de touche physique.

```html
<p>Press <kbd>Ctrl</kbd> + <kbd>C</kbd> to copy, <kbd>Ctrl</kbd> + <kbd>V</kbd> to paste.</p>
```

---

## Separateur horizontal

L'element `<hr>` affiche un trait fin separant deux blocs de contenu.

```html
<p>Content above the separator.</p>
<hr>
<p>Content below the separator.</p>
```

---

## Figure

L'element `<figure>` encadre un contenu (tableau, image, etc.) avec une legende via `<figcaption>`.

```html
<figure>
    <table>
        <thead><tr><th>Name</th><th>Value</th></tr></thead>
        <tbody><tr><td>Alpha</td><td>100</td></tr></tbody>
    </table>
    <figcaption>Figure 1 — A table inside a figure element.</figcaption>
</figure>
```

---

## Accessibilite

- Utiliser les niveaux de titres dans l'ordre hierarchique (`h1` > `h2` > `h3`...) pour la navigation au lecteur d'ecran.
- L'attribut `title` sur `<abbr>` fournit la forme complete de l'abreviation aux technologies d'assistance.
- `<blockquote>` avec `<cite>` permet aux lecteurs d'ecran d'identifier la source d'une citation.
- L'element `<mark>` est annonce comme "surbrillance" par les lecteurs d'ecran.

→ [Voir l'exemple](../examples/typography.html)
