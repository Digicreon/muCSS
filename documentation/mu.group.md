# µGroup

**µGroup** permet de regrouper visuellement des champs de formulaire et des boutons en une seule ligne, grace a l'attribut `role="group"` style par [PicoCSS](https://picocss.com) au sein du framework [µCSS](.). Les elements groupes partagent des bordures communes et s'alignent horizontalement.

---

## Groupe de boutons

L'attribut `role="group"` sur un conteneur regroupe les boutons en une barre horizontale avec des bordures fusionnees.

```html
<div role="group">
    <button>Left</button>
    <button>Center</button>
    <button>Right</button>
</div>
```

---

## Input + bouton

Combinez un champ de saisie et un bouton dans un meme groupe pour creer un formulaire inline compact.

```html
<div role="group">
    <input type="email" placeholder="Enter your email">
    <button>Subscribe</button>
</div>
```

---

## Groupe de recherche

Utilisez `role="search"` pour un groupe semantiquement identifie comme zone de recherche. Le rendu visuel est identique a `role="group"`.

```html
<div role="search">
    <input type="search" placeholder="Search...">
    <button>Search</button>
</div>
```

---

## Input + select + bouton

Un groupe peut contenir plus de deux elements, par exemple un `<select>`, un `<input>` et un `<button>`.

```html
<div role="group">
    <select>
        <option>USD</option>
        <option>EUR</option>
        <option>GBP</option>
    </select>
    <input type="number" placeholder="Amount">
    <button>Convert</button>
</div>
```

---

## Boutons outline

Les boutons `.outline` fonctionnent egalement dans un groupe, offrant un style de barre de selection (toggle bar).

```html
<div role="group">
    <button class="outline">Day</button>
    <button class="outline">Week</button>
    <button class="outline">Month</button>
</div>
```

---

## Resume des roles

| Attribut | Usage |
|----------|-------|
| `role="group"` | Groupe generique (boutons, inputs, selects) |
| `role="search"` | Groupe de recherche (semantique) |

## Elements supportes dans un groupe

| Element | Comportement |
|---------|-------------|
| `<button>` | Bouton d'action |
| `<input>` | Champ de saisie (text, email, search, number, etc.) |
| `<select>` | Liste de selection |

---

## Accessibilite

- `role="group"` informe les technologies d'assistance que les elements sont lies et forment un ensemble logique.
- `role="search"` identifie semantiquement la zone comme fonctionnalite de recherche, ce qui aide la navigation au lecteur d'ecran.
- Les elements du groupe restent accessibles individuellement au clavier (navigation par `Tab`).

→ [Voir l'exemple](../examples/group.html)
