# État des itérations — 16 octobre 2026

## IT-1 : environnement

| User story | État constaté |
| --- | --- |
| US-1.1 | DDEV actif, PHP 8.4, MariaDB 11.8, WordPress 7.1.3. Préfixe initial `wp_` migré en `sae301_` après sauvegarde ; 52 tables, neuf produits et droits administrateur conservés. Le mot de passe existant n’a pas été modifié ni audité. |
| US-1.2 | WooCommerce 11.2.1, Storefront 4.6.2, SCF déjà présents ; Classic Editor 1.7.0 installé et activé. |
| US-1.3 | Thème enfant créé et activé ; historique Git avec préfixes d’itérations. |
| US-1.4 | Site déployé le 16/10/2026 dans r3SAE01 sur mmi.unilim.fr après sauvegarde, transfert des fichiers et import de la base adaptée. |
| US-1.5 | Frontend, écran de connexion WordPress et rôle administrateur vérifiés ; journal et procédure actualisés. |

Le dépôt public est disponible à l’adresse https://github.com/bluxial/sae301-les-fils-a-maman. La production est accessible sur https://mmi.unilim.fr/~maree2/r3SAE01/ avec l’authentification MMI. Les parcours vérifiés sont détaillés dans VALIDATION.md.

## IT-2 : catalogue et produits simples

| User story | Mise en œuvre |
| --- | --- |
| US-2.1 | Palette, polices locales, contours, ombres, header et footer issus d’Analyse DA ; couches CSS explicites. |
| US-2.2 | Trois catégories avec trois produits chacune ; neuf images importées et associées sans recréer les produits ; prix et descriptions longues conservés. Des descriptions courtes ont été ajoutées pour les cartes. |
| US-2.3 | Grilles de la boutique et des catégories, recadrages des images, liens et boutons natifs d’ajout au panier ; affichage horizontal sur mobile. |
| US-2.4 | Fiches des produits simples avec photo, catégorie, description, prix, quantité et formulaire WooCommerce. |
| US-2.5 | Navigation réelle accueil → catégorie → produit ; liens vers le panier et le compte. |

Adresses corrigées pour les croquettes, les beignets et les œufs mimosa, qui portaient auparavant des slugs de catégories. Le mode WooCommerce « bientôt disponible » a été désactivé sur DDEV pour permettre les tests des pages publiques.

La version 0.2.1 conserve cette présentation et ces fonctionnalités avec les techniques retenues pour le projet : HTML/PHP simple, CSS avec `@layer` et JavaScript sans framework. Le catalogue de composants est livré dans `design-system/system.html`, avec des fichiers CSS et JavaScript séparés. Ses démonstrations d’options et de panier restent des exemples ; elles ne remplacent pas les prochaines itérations WooCommerce.

## IT-3 : produits variables

| User story | Mise en œuvre |
| --- | --- |
| US-3.1 | Trois produits simples deviennent variables avec le script `tools/it3-produits-variables.php` (WP-CLI) : croquettes de chorizo (Portion 4 ou 8 pièces, 8 € / 14 €), cordon bleu des Fistons (Accompagnement), œufs Bénédicte (Garniture, 17,50 € / 19 €). Stock géré par déclinaison : disponible, faible (5 portions ou moins) et épuisé. Modifiable ensuite dans **Produits → Modifier → Variations**. |
| US-3.2 | Le modèle `woocommerce/single-product/add-to-cart/variable.php` remplace les listes déroulantes par les pastilles `lf-options` / `lf-chip` du design system. Les listes restent cachées dans la page car le script de WooCommerce s’en sert ; `theme.js` les met à jour quand on clique sur une pastille. |
| US-3.3 | Sur la fiche, le prix, le stock et le bouton changent selon l’option choisie. Sur les cartes : « À partir de … » et bouton « Choisir + ». Badge jaune « Plus que X en stock » quand le stock est faible, « Rupture de stock » et bouton désactivé quand il est épuisé. |

## IT-4 : enrichissement du contenu

| User story | Mise en œuvre |
| --- | --- |
| US-4.1 | Groupe de champs Secure Custom Fields « Informations du produit » déclaré en PHP dans `inc/champs-produits.php` : Composition (texte), Allergènes (cases à cocher), Valeur énergétique (nombre). Il apparaît sous l’éditeur de chaque produit dans le back office. |
| US-4.2 | Les neuf produits sont remplis avec `tools/it4-champs-produits.php` (WP-CLI). Compositions reprises de la carte du restaurant ; allergènes et calories indicatifs, modifiables dans chaque fiche. |
| US-4.3 | Fonction `lf_product_facts()` accrochée à `woocommerce_single_product_summary` (priorité 22) : après la description (20) et avant le prix (25). Affichage avec le composant `lf-facts` de la maquette. |
| US-4.4 | Le visiteur voit composition, allergènes et énergie sur la fiche du produit. Rien ne s’affiche si les champs sont vides. |

## IT-5 : panier et expédition

| User story | Mise en œuvre |
| --- | --- |
| US-5.1 | Script `tools/it5-paiement-livraison.php` : « Virement bancaire » et « Paiement au retrait » (paiement à la livraison de WooCommerce renommé, réservé au retrait au restaurant). Réglages dans **WooCommerce → Réglages → Paiements**. |
| US-5.2 | Zone « Paris » (France, codes postaux 75*) : Retrait au restaurant gratuit, Livraison à vélo 4,90 €, Livraison express 8,90 €. Ailleurs : retrait au restaurant seulement. Adresse du restaurant : 7 bis rue Geoffroy-Marie, 75009 Paris. |
| US-5.3 | Pages panier et commande passées en version classique (shortcodes) pour pouvoir les personnaliser. Modèle `woocommerce/cart/cart.php` simplifié : articles en cartes `lf-cart-item`, récapitulatif `lf-summary` comme dans la maquette. |
| US-5.4 | Testé en local : ajout de 8 croquettes (14 €), panier, choix du mode d’expédition. Avec le code postal 75009 : trois modes ; la livraison à vélo ajoute 4,90 € (total 18,90 €) et retire le paiement au retrait. |

## À traiter ensuite

IT-6 : instructions de retrait et validation de commande. Aucun créneau ou mode de paiement fictif n’est présenté comme opérationnel dans cette version.

## Sauvegardes locales

Les sauvegardes sont conservées hors du dossier web, dans `~/Desktop/SAE301-backups/`. Elles ne doivent pas être publiées sur GitHub :

- `before-it1-it2.sql.gz` et `wp-config-before-it1-it2.php` : état initial ;
- `before-prefix.sql.gz` : état avant migration du préfixe ;
- export final après validation : point de départ du transfert en production.
