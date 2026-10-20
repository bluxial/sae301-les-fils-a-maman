# Les Fils à Maman — SAE 3.01

Thème enfant Storefront réalisé à partir du Figma et du design system. Le site utilise les produits, les prix, les descriptions et le panier de WooCommerce.

[Dépôt GitHub](https://github.com/bluxial/sae301-les-fils-a-maman)

[Site sur MMI](https://mmi.unilim.fr/~maree2/r3SAE01/) · [Administration WordPress](https://mmi.unilim.fr/~maree2/r3SAE01/wp-admin/)

## Installation

1. Installer WordPress, WooCommerce, Storefront, Secure Custom Field et Classic Editor.
2. Copier ce dossier dans wp-content/themes/les-fils-a-maman/.
3. Activer le thème enfant dans **Apparence → Thèmes**. Garder Storefront installé.
4. Choisir la page Click & Collect comme page d’accueil dans les réglages WordPress.
5. Vérifier les pages boutique, panier, commande et compte dans les réglages WooCommerce.
6. Ajouter les produits et leurs images depuis l’administration.

Le site DDEV possède déjà ses neuf produits, leurs images et ses trois catégories. Le script utilisé une fois pour préparer ces contenus a été retiré.

## Fichiers

| Fichier | Rôle |
| --- | --- |
| functions.php | Charge les deux fichiers PHP du dossier inc. |
| inc/setup.php | Charge les styles et les scripts ; adapte Storefront ; actualise le compteur du panier. |
| inc/catalogue.php | Lit les catégories et prépare les textes et les boutons des produits. |
| inc/produits-variables.php | IT-3 : prix « À partir de », bouton « Choisir + » et classe de stock faible. |
| inc/champs-produits.php | IT-4 : champs SCF des produits et leur affichage avant le prix. |
| inc/retrait.php | IT-6 : texte « Instructions pour le retrait » (réglage WooCommerce et affichage au checkout). |
| woocommerce/cart/cart.php | IT-5 : page panier (articles et récapitulatif). |
| tools/ | Scripts lancés une fois pour préparer les contenus : `ddev wp eval-file wp-content/themes/les-fils-a-maman/tools/<script>.php` ou, en local, `http://sae301.ddev.site/?lf_outil=<script>` (extension locale `mu-plugins/lf-outils-locaux.php`, hors dépôt). |
| header.php, footer.php | Navigation et pied de page. |
| front-page.php | Accueil et cartes des catégories. |
| page.php, index.php | Pages WordPress et affichage de secours. |
| woocommerce/ | Boutique, cartes et fiches produits. |
| system.css | Couleurs, polices et composants partagés. |
| assets/css/wordpress.css | Mise en page propre au site WordPress. |
| assets/js/theme.js | Menu mobile et boutons de quantité. |
| design-system/ | Catalogue HTML et ses démonstrations JavaScript. |
| docs/ | Itérations, vérifications, journal et transfert en production. |

## Écriture du code

Le PHP utilise des fonctions nommées, des tableaux, des boucles et des conditions. Le JavaScript utilise le DOM et les événements du navigateur, sans bibliothèque ajoutée. Le CSS utilise des classes, des variables, Flexbox, Grid et des media queries.

Les fonctions add_action et add_filter relient nos fonctions à WordPress. La fonction remove_action retire les éléments Storefront remplacés par notre mise en page. Les fonctions esc_html, esc_attr, esc_url et wp_kses_post préparent les données avant leur affichage.

Les styles restent organisés avec @layer :

    @layer theme, lf-reset, lf-fonts, lf-tokens, lf-base,
           lf-components, lf-utilities, lf-overrides;

La couche theme contient les styles Storefront et WooCommerce. Les autres couches contiennent nos styles. La classe lf-system porte les variables et les règles de base ; les composants utilisent des classes commençant par lf-.

## Design system

Ouvrir design-system/system.html dans un navigateur. Le catalogue utilise les images et les polices du dossier assets. Son panier et ses options sont des démonstrations locales. Le panier du site WordPress reste celui de WooCommerce.

## Périmètre

IT-1 et IT-2 en local : environnement DDEV, thème enfant, accueil, boutique, catégories, neuf produits simples, fiches et navigation responsive.

Le site est déployé dans r3SAE01 sur mmi.unilim.fr depuis le 16 octobre 2026. L’accès utilise l’authentification universitaire « Devoir MMI ». Le transfert et ses contrôles sont décrits dans docs/DEPLOIEMENT.md et docs/VALIDATION.md. IT-3 (produits variables), IT-4 (champs SCF) IT-5 (paiements, expédition, panier) et IT-6 (checkout, instructions de retrait) sont faites en local.

Les logos et les photographies de l’enseigne sont utilisés pour ce projet pédagogique. Les configurations privées, les mots de passe et les exports SQL sont exclus du dépôt.

## Références

- [Figma — Les Fils à Maman](https://www.figma.com/design/e8BqdgVoRoGSz7QAoYilwo?node-id=19-488)
- [Thèmes enfants WordPress](https://developer.wordpress.org/themes/advanced-topics/child-themes/)
- [Modèles WooCommerce](https://developer.woocommerce.com/docs/theming/theme-development/template-structure/)
