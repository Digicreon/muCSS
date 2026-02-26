# µTooltip

**µTooltip** fournit des infobulles CSS pures via l'attribut `data-tooltip`, styles par [PicoCSS](https://picocss.com) au sein du framework [µCSS](.). Aucun JavaScript n'est necessaire : les tooltips apparaissent au survol ou au focus.

---

## Utilisation de base

Ajoutez l'attribut `data-tooltip` sur n'importe quel element HTML pour afficher une infobulle au survol. Par defaut, le tooltip apparait au-dessus de l'element.

```html
<span data-tooltip="This is a tooltip">Hover me</span>
```

Pour un rendu visuel clair sur du texte inline, on peut ajouter un style de soulignement :

```html
<span data-tooltip="This is a tooltip"
      style="text-decoration: underline dotted; cursor: help;">this text</span>
```

---

## Placement

L'attribut `data-placement` controle la position du tooltip. Quatre positions sont disponibles :

| Valeur | Position |
|--------|----------|
| `top` | Au-dessus (par defaut) |
| `bottom` | En dessous |
| `left` | A gauche |
| `right` | A droite |

```html
<span data-tooltip="Top tooltip" data-placement="top">Top</span>
<span data-tooltip="Bottom tooltip" data-placement="bottom">Bottom</span>
<span data-tooltip="Left tooltip" data-placement="left">Left</span>
<span data-tooltip="Right tooltip" data-placement="right">Right</span>
```

---

## Sur des boutons

Les tooltips fonctionnent sur les boutons pour fournir un contexte supplementaire sur l'action.

```html
<button class="btn btn-primary" data-tooltip="Save your changes">Save</button>
<button class="btn btn-ghost btn-error"
        data-tooltip="This action cannot be undone"
        data-placement="bottom">Delete</button>
```

---

## Sur des liens

Ajoutez un tooltip sur un lien pour decrire la destination ou l'action.

```html
<p>Visit the <a href="#" data-tooltip="Go to the homepage">homepage</a>
or check the <a href="#" data-tooltip="Read the full documentation"
data-placement="bottom">documentation</a>.</p>
```

---

## Sur des champs de formulaire

Les tooltips peuvent etre places sur des elements de formulaire pour guider l'utilisateur.

```html
<label>Username
    <input type="text"
           data-tooltip="Must be 3-20 characters"
           placeholder="Enter username">
</label>
```

---

## Resume des attributs

| Attribut | Requis | Description |
|----------|--------|-------------|
| `data-tooltip` | Oui | Texte affiche dans l'infobulle |
| `data-placement` | Non | Position : `top` (defaut), `bottom`, `left`, `right` |

---

## Accessibilite

- Les tooltips sont accessibles au clavier via le focus (`:focus` en plus de `:hover`).
- Le contenu du `data-tooltip` est lu par les technologies d'assistance.
- Evitez de placer des informations essentielles uniquement dans un tooltip ; le contenu doit rester comprehensible sans interaction de survol.

→ [Voir l'exemple](../examples/tooltip.html)
