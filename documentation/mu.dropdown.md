# µDropdown

**µDropdown** fournit des menus deroulants CSS purs via l'element `<details class="dropdown">`, styles par [PicoCSS](https://picocss.com) au sein du framework [µCSS](.). Aucun JavaScript n'est necessaire : l'ouverture et la fermeture sont gerees nativement par le navigateur.

---

## Utilisation de base

Un dropdown est construit avec `<details class="dropdown">`. Le `<summary>` sert de declencheur et la liste `<ul>` contient les options.

```html
<details class="dropdown">
    <summary>Select an option</summary>
    <ul>
        <li><a href="#">Option 1</a></li>
        <li><a href="#">Option 2</a></li>
        <li><a href="#">Option 3</a></li>
    </ul>
</details>
```

---

## Style bouton

Ajoutez `role="button"` sur le `<summary>` pour lui donner l'apparence d'un bouton.

```html
<details class="dropdown">
    <summary role="button">Actions</summary>
    <ul>
        <li><a href="#">Edit</a></li>
        <li><a href="#">Duplicate</a></li>
        <li><a href="#">Archive</a></li>
        <li><a href="#">Delete</a></li>
    </ul>
</details>
```

---

## Variantes natives PicoCSS

PicoCSS fournit des variantes de style via des classes sur le `<summary role="button">` :

| Classe | Apparence |
|--------|-----------|
| *(aucune)* | Primary (defaut) |
| `.secondary` | Secondary |
| `.contrast` | Contrast |
| `.outline` | Outline |

```html
<details class="dropdown">
    <summary role="button">Primary</summary>
    <ul>
        <li><a href="#">Item A</a></li>
        <li><a href="#">Item B</a></li>
    </ul>
</details>

<details class="dropdown">
    <summary role="button" class="secondary">Secondary</summary>
    <ul>
        <li><a href="#">Item A</a></li>
        <li><a href="#">Item B</a></li>
    </ul>
</details>

<details class="dropdown">
    <summary role="button" class="contrast">Contrast</summary>
    <ul>
        <li><a href="#">Item A</a></li>
        <li><a href="#">Item B</a></li>
    </ul>
</details>

<details class="dropdown">
    <summary role="button" class="outline">Outline</summary>
    <ul>
        <li><a href="#">Item A</a></li>
        <li><a href="#">Item B</a></li>
    </ul>
</details>
```

---

## Variantes de couleur µCSS

µCSS etend les dropdowns avec les classes `.btn-*` sur le `<summary>` pour les 8 roles de couleur :

| Classe | Couleur |
|--------|---------|
| `.btn-primary` | Primary |
| `.btn-secondary` | Secondary |
| `.btn-tertiary` | Tertiary |
| `.btn-contrast` | Contrast |
| `.btn-success` | Success |
| `.btn-info` | Info |
| `.btn-warning` | Warning |
| `.btn-error` | Error |

```html
<details class="dropdown">
    <summary role="button" class="btn-primary">Primary</summary>
    <ul>
        <li><a href="#">Item A</a></li>
        <li><a href="#">Item B</a></li>
    </ul>
</details>

<details class="dropdown">
    <summary role="button" class="btn-success">Success</summary>
    <ul>
        <li><a href="#">Item A</a></li>
        <li><a href="#">Item B</a></li>
    </ul>
</details>

<details class="dropdown">
    <summary role="button" class="btn-error">Error</summary>
    <ul>
        <li><a href="#">Item A</a></li>
        <li><a href="#">Item B</a></li>
    </ul>
</details>
```

---

## Remplacement de select

Un dropdown peut servir d'alternative stylee a un `<select>` natif en le placant dans un `<label>`.

```html
<label>Choose a fruit
    <details class="dropdown">
        <summary>Pick one...</summary>
        <ul>
            <li><a href="#">Apple</a></li>
            <li><a href="#">Banana</a></li>
            <li><a href="#">Cherry</a></li>
            <li><a href="#">Mango</a></li>
            <li><a href="#">Orange</a></li>
        </ul>
    </details>
</label>
```

**Note :** contrairement a un `<select>` natif, la valeur selectionnee n'est pas geree automatiquement. Un minimum de JavaScript applicatif est necessaire pour mettre a jour le texte du `<summary>` apres selection.

---

## Structure

```
<details class="dropdown">
    <summary [role="button"] [class="btn-*"]>Trigger text</summary>
    <ul>
        <li><a href="#">Menu item</a></li>
        ...
    </ul>
</details>
```

| Element | Role |
|---------|------|
| `<details class="dropdown">` | Conteneur du dropdown |
| `<summary>` | Declencheur (texte ou bouton) |
| `<summary role="button">` | Declencheur avec apparence bouton |
| `<ul>` | Liste des options |
| `<li><a>` | Element de menu cliquable |

---

## Accessibilite

- Le composant repose sur l'element natif `<details>`/`<summary>`, accessible par defaut au clavier (ouverture via `Enter` ou `Space`).
- L'attribut `role="button"` sur `<summary>` informe les technologies d'assistance que l'element agit comme un bouton.
- Le menu se ferme automatiquement lorsque l'utilisateur clique en dehors (comportement natif de `<details>`).

→ [Voir l'exemple](../examples/dropdown.html)
