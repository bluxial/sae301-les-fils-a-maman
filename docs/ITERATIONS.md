# État des itérations — 16 octobre 2026

## IT-1 : environnement

| User story | État constaté |
| --- | --- |
| US-1.1 | DDEV actif, PHP 8.4, MariaDB 11.8, WordPress 7.1.3. Préfixe initial `wp_` migré en `sae301_` après sauvegarde ; 52 tables, neuf produits et droits administrateur conservés. Le mot de passe existant n’a pas été modifié ni audité. |
| US-1.2 | WooCommerce 11.2.1, Storefront 4.6.2, SCF déjà présents ; Classic Editor 1.7.0 installé et activé. |
| US-1.3 | Thème enfant créé et activé ; historique Git avec préfixes d’itérations. |
| US-1.4 | Production différée à la demande de Jules : transfert prévu avec FileZilla et phpMyAdmin après validation locale. |
| US-1.5 | Procédure et journal préparés ; accès frontend/backend de production à vérifier après transfert. |

Le dépôt public est disponible à l’adresse https://github.com/bluxial/sae301-les-fils-a-maman. IT-1 ne sera entièrement validée qu’une fois la production vérifiée.

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

## À traiter ensuite

IT-3 : variantes, suppléments, choix d’options et états de stock. IT-4 : champs personnalisés sur au moins trois produits, affichés avant le prix. IT-5/6 : panier personnalisé, livraison/retrait, paiements et validation. Aucun créneau ou mode de paiement fictif n’est présenté comme opérationnel dans cette version.

## Sauvegardes locales

Les sauvegardes sont conservées hors du dossier web, dans `~/Desktop/SAE301-backups/`. Elles ne doivent pas être publiées sur GitHub :

- `before-it1-it2.sql.gz` et `wp-config-before-it1-it2.php` : état initial ;
- `before-prefix.sql.gz` : état avant migration du préfixe ;
- export final après validation : point de départ du transfert en production.
