# Les Fils à Maman — SAE 3.01

Thème enfant **Storefront**, réalisé à partir du Figma de Jules Marée et du design system HTML/CSS. Les produits, leurs prix, leurs descriptions et leurs catégories proviennent de WooCommerce.

## Installation

Installer WordPress, WooCommerce, Storefront, Secure Custom Field et Classic Editor, puis copier ce dossier dans `wp-content/themes/les-fils-a-maman/` et activer **Les Fils à Maman — SAE301**. Conserver le thème parent Storefront installé.

Dans le projet local DDEV existant :

```sh
ddev wp theme activate les-fils-a-maman
```

Le script `tools/setup-local.php` associe les neuf visuels aux produits déjà saisis, corrige leurs slugs, ajoute les descriptions courtes manquantes et crée l’accueil Click & Collect. Il ne recrée pas les produits et ne modifie pas leurs prix ou leurs descriptions longues. Il est réexécutable sans duplication des médias. Sauvegarder la base avant de l’utiliser :

```sh
ddev wp eval-file wp-content/themes/les-fils-a-maman/tools/setup-local.php
```

## Architecture

```text
functions.php             Chargement des modules du thème
inc/setup.php             Hooks WordPress/Storefront, CSS, fragments du panier
inc/catalogue.php         Présentation et lecture des données WooCommerce
header.php / footer.php   Navigation, identité et pied de page
front-page.php            Accueil et catégories dynamiques
page.php                  Pages natives WordPress/WooCommerce
woocommerce/              Surcharges ciblées du catalogue et de la fiche produit
system.css                Design system portable avec @layer
assets/css/wordpress.css  Adaptation des composants aux interfaces natives
assets/js/theme.js        Menu mobile et quantité du formulaire WooCommerce
assets/                   Polices et visuels originaux
docs/                     Audit, validation, déploiement et journal
```

Ordre de cascade : `theme`, `lf-reset`, `lf-fonts`, `lf-tokens`, `lf-base`, `lf-components`, `lf-utilities`, `lf-overrides`. Le périmètre est `.lf-system`, ajouté au `body`. Les feuilles et styles inline Storefront sont rangés dans `theme`, y compris le CSS ajouté tardivement par son Customizer. Les adaptations propres à WordPress sont séparées du design system.

Les fichiers sous `woocommerce/` indiquent la version de leur modèle de référence ; les vérifier lors des mises à jour de WooCommerce. Les hooks des formulaires et les données structurées sont conservés. Le prix et le panier sont calculés par WooCommerce : aucun tarif n’est recopié en JavaScript.

## Périmètre livré

- IT-1 : DDEV fonctionnel ; thème enfant ; Classic Editor ; préfixe `sae301_` ; sauvegardes ; suivi Git local et procédure de déploiement. La publication mmi.unilim.fr sera réalisée après validation locale.
- IT-2 : accueil, boutique, catégories, neuf produits simples avec images, navigation, fiches produits, responsive et ajout au panier natif.
- Les options variables, champs SCF, retrait/livraison/paiement, compte personnalisé, emails et avis seront traités dans les itérations correspondantes. Les onglets/éléments Storefront absents de la maquette sont retirés de la fiche pour cette version.

## Sources

- [Figma — MAREE Jules, Les Fils à Maman](https://www.figma.com/design/e8BqdgVoRoGSz7QAoYilwo?node-id=19-488)
- [Thèmes enfants WordPress](https://developer.wordpress.org/themes/advanced-topics/child-themes/)
- [Surcharges de templates WooCommerce](https://developer.woocommerce.com/docs/theming/theme-development/template-structure/)

Les logos et photographies de l’enseigne sont utilisés pour ce projet pédagogique. Les bases de données, configurations privées et mots de passe sont exclus du dépôt.
