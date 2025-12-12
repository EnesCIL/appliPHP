📘 **README — Application PHP : Gestion de produits en session**
🛒 **Présentation du projet**

Cette application PHP permet d’ajouter des produits dans un panier temporaire grâce à des sessions PHP.

**L’utilisateur peut :**

- Ajouter un produit avec nom, prix et quantité

- Voir un récapitulatif de tous les produits ajoutés

- Modifier la quantité (augmenter / diminuer)

- Supprimer un produit

- Vider complètement la session

Aucune base de données n’est utilisée : tout est stocké dans $_SESSION.

📂 **Structure des fichiers**

/ (racine)

│── index.php          # Formulaire d'ajout de produit

│── recap.php          # Tableau récapitulatif des produits

│── traitement.php      # Gestion des actions (add / delete / clear / up-qtt / down-qtt)

│── style.css           # Styles de la page

│── README.md           # Documentation

⚙️ **Fonctionnement général**

1️⃣ **index.php — Ajouter un produit**

**Cette page contient un formulaire demandant :**

- Nom du produit

- Prix (float, positif)

- Quantité (entier ≥ 1)

À la validation, les données sont envoyées vers :

- traitement.php?action=add

✔️ Les champs sont sécurisés avec filter_input()

✔️ Un message de confirmation ou d’erreur est affiché via $_SESSION['message']

2️⃣ **traitement.php — Traitement des actions**

**Ce fichier gère toutes les actions :**

🟩 **Ajouter un produit**

- ?action=add

→ Vérifie les inputs
→ Calcule le total (prix × quantité)
→ Ajoute à $_SESSION['products'][]

🟥 **Supprimer un produit**

- ?action=delete&id=X

→ Supprime l’index correspondant

🟨 **Vider toute la session**

- ?action=clear

→ Supprime entièrement $_SESSION['products']

🔼 **Augmenter la quantité**

- ?action=up-qtt&id=X

→ qtt++
→ Recalcule total

🔽 **Diminuer la quantité**

- ?action=down-qtt&id=X


→ qtt-- si qtt > 0
→ Recalcule total

Toutes les actions (sauf add) redirigent vers recap.php.

3️⃣ **recap.php — Tableau des produits**

**Affiche :**

| # | Nom | Prix | Quantité | Total | Actions |

**Les actions disponibles :**

- Delete

- Up qtt

- Down qtt

- Un total général est affiché en bas du tableau.

🎨 **Styles CSS**

**Le style met en forme :**

- Un header + footer fixes

- Un formulaire clair et espacé

- Un tableau responsive et propre

- Un bouton de suppression visuellement marqué

- Une icône panier avec FontAwesome

🔐 **Sécurité mise en place**

✔︎ Protection contre XSS

**Utilisation de :**

- filter_input()

**Validation des données :**

- Prix → FILTER_VALIDATE_FLOAT

- Quantité → FILTER_VALIDATE_INT

- Nom → FILTER_SANITIZE_STRING

- **Sessions sécurisées :**

Chaque page commence par session_start().
