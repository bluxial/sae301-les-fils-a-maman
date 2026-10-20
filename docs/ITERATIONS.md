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

## IT-6 : checkout

| User story | Mise en œuvre |
| --- | --- |
| US-6.1 | Bloc « Instructions pour le retrait » affiché dans la validation de commande, juste avant le choix du paiement (`inc/retrait.php`). Le texte se modifie dans **WooCommerce → Réglages → Expédition → Options d’expédition**, champ « Instructions pour le retrait ». Un texte par défaut est utilisé si le champ est vide. |
| US-6.2 | Testé en local : panier → validation de commande → retrait au restaurant → paiement au retrait → « Commander ». Commande n° 46 reçue (14 €), page de confirmation affichée. |

## IT-7 : compte client

| User story | Mise en œuvre |
| --- | --- |
| US-7.1 | Script `tools/it7-compte-client.php` : inscription depuis « Mon compte » et pendant la commande, rappel de connexion au checkout, le client choisit son mot de passe, identifiant créé à partir de l’e-mail. Réglages dans **WooCommerce → Réglages → Comptes et confidentialité**. |
| US-7.2 | Connexion et inscription dans deux cartes crème côte à côte (une colonne sur mobile). Menu du compte en pastilles `lf-chip` (`woocommerce/myaccount/navigation.php`), page active en encre. « Téléchargements » retiré du menu (`inc/compte-client.php`) : la boutique ne vend pas de fichiers. |
| US-7.3 | Testé en local : inscription d’un client test, tableau de bord, commandes, adresses, détails du compte, déconnexion. Identifiants de test rangés hors du dépôt dans `SAE301-backups/comptes-test.md`. |

## IT-8 : e-mails transactionnels

| User story | Mise en œuvre |
| --- | --- |
| US-8.1 | Script `tools/it8-emails.php` : expéditeur « Les Fils à Maman », couleurs de la charte (turquoise, pêche, crème, encre), pied de page, e-mails client activés en HTML (commande reçue, en cours, terminée, annulée, remboursée, nouveau compte). Réglages dans **WooCommerce → Réglages → E-mails**. |
| US-8.2 | Modèles `woocommerce/emails/email-header.php` et `email-footer.php` simplifiés : logo PNG (`assets/email-logo.png`), accroche « Click & Collect », adresse du restaurant. Bordure encre, coins arrondis et ombre portée ajoutés avec le filtre `woocommerce_email_styles` (`inc/emails.php`). |
| US-8.3 | Bloc jaune « Instructions pour le retrait » ajouté aux e-mails envoyés au client quand la commande est en retrait au restaurant (même texte que le checkout, version texte brut prévue). |
| US-8.4 | Testé en local avec Mailpit (`http://sae301.ddev.site:8025`) : e-mail « Merci pour votre commande » de la commande n° 48 avec logo, couleurs et instructions de retrait. |

## IT-9 : commandes

| User story | Mise en œuvre |
| --- | --- |
| US-9.1 | Commandes visibles dans **WooCommerce → Commandes**. Nouveau statut « Prête à retirer » entre « En cours » et « Terminée » (`inc/commandes.php`), disponible dans la fiche commande et en action groupée. Stock géré par déclinaison : la commande de 8 croquettes fait passer le stock de 3 à 2 ; une annulation remet le stock. Script `tools/it9-commandes.php` : textes des e-mails de suivi. |
| US-9.2 | Testé en local : panier de deux produits (beignets + œufs mimosa, 14,50 €), retrait au restaurant, paiement au retrait → commande n° 49 « En cours » (e-mail « reçue ») → « Prête à retirer » (e-mail « Votre commande est prête ! » avec les instructions de retrait) → « Terminée » (e-mail « Bon appétit ! »). Le client suit aussi le statut dans **Mon compte → Commandes**. |
| US-9.3 | Testé en local avec le client connecté : cookie de Maman, livraison à vélo, virement (10,90 €) → n° 50 « En attente » (e-mail « en attente de votre virement ») → « En cours » (paiement reçu, préparation) → « Annulée » (e-mail d’annulation) → remboursement total → « Remboursée » (e-mail de remboursement). Tous les e-mails vérifiés dans Mailpit. |

## IT-10 : promotions

| User story | Mise en œuvre |
| --- | --- |
| US-10.1 | Script `tools/it10-promotions.php` : FISTONS10 (pourcentage, -10 % sur le cordon bleu et le tartare), MAMAN2 (montant fixe, -2 € sur le cookie et le millefeuille), ETE2025 (expiré, pour les tests). Codes modifiables dans **Marketing → Codes promo**. |
| US-10.2 | Champ « Code promo » ajouté au modèle panier, sous les articles ; ligne de réduction en orange dans le récapitulatif avec le lien « Enlever ». |
| US-10.3 | Testé en local avec un tartare (21 €) : FAUX → « n’existe pas » ; ETE2025 → « a expiré » ; MAMAN2 → « n’est pas applicable aux produits sélectionnés » ; FISTONS10 → -2,10 €, total 18,90 € ; « Enlever » → retour à 21 €. |

## IT-11 : équipe

| User story | Mise en œuvre |
| --- | --- |
| US-11.1 | Type de contenu « Équipe » (`membre`) avec son menu dans le back office (`inc/equipe.php`) : un membre = une page. Champs SCF « Profil du membre » : poste, plat préféré, couleur de la carte. La photo se met en « Image mise en avant » ; sans photo, les initiales s’affichent. |
| US-11.2 | Script `tools/it11-equipe.php` : trois profils fictifs (cheffe de cuisine, pâtissier, responsable du Click & Collect). |
| US-11.3 | Modèles `archive-membre.php` (liste, adresse `/equipe/`) et `single-membre.php` (profil). Ordre d’affichage réglable avec le champ « Ordre » du membre. |
| US-11.4 | Pas d’écran « Équipe » dans la maquette Figma : les pages reprennent les composants du design system (cartes colorées, bordures et ombres, titres Luckiest Guy, bloc `lf-facts`). Écran à ajouter dans Figma pour la cohérence du rendu. |
| US-11.5 | Lien « L’équipe » ajouté au menu principal et au pied de page. Testé en local : liste des trois membres et page de profil. |

## IT-12 : taxonomies

| User story | Mise en œuvre |
| --- | --- |
| US-12.1 | Taxonomie « Envies » (`envie`) indépendante des catégories, rattachée aux produits (`inc/envies.php`). Administration dans **Produits → Envies**, case à cocher dans chaque fiche produit et colonne dans la liste des produits. |
| US-12.2 | Script `tools/it12-envies.php` : Végétarien (4 produits), Gourmand (3), Léger (3). |
| US-12.3 | Page dédiée par envie (`/envie/vegetarien/`, `/envie/gourmand/`, `/envie/leger/`) avec la grille de la boutique ; pastilles « Envie de : » sous les catégories. Correctif : « Toute la carte » n’est active que sur la boutique. |

## IT-13 : ventes croisées

| User story | Mise en œuvre |
| --- | --- |
| US-13.1 | Script `tools/it13-ventes-croisees.php` : six produits reçoivent 2 ou 3 produits complémentaires (ex. : cordon bleu → pêche d’enfer, cookie, beignets). Modifiable dans **Produits → Modifier → Données produit → Produits liés → Ventes croisées**. |
| US-13.2 | `inc/ventes-croisees.php` : bloc « Ça va bien avec… » sous la fiche produit et « Pour compléter ta commande » sous le panier (pleine largeur au lieu de la colonne du récapitulatif), avec les cartes produits de la boutique. |
| US-13.3 | Testé en local : fiche du cordon bleu (3 suggestions) et panier avec un tartare (pêche d’enfer et millefeuille), boutons « Ajouter + » fonctionnels. |

## IT-14 : avis clients

| User story | Mise en œuvre |
| --- | --- |
| US-14.1 | Les onglets WooCommerce étant retirés, les avis sont affichés sous la fiche produit (`inc/avis.php`, `comments_template()`), dans des cartes crème avec bordure, étoiles orange, formulaire dans un cadre aux couleurs du site. |
| US-14.2 | Script `tools/it14-avis.php` : avis activés sur les 9 produits, note obligatoire, avis réservés aux clients connectés qui ont acheté le produit, badge « propriétaire vérifié ». Les avis sont validés dans **Produits → Avis**. Testé en local : un visiteur non acheteur voit le message « Seuls les clients connectés ayant acheté ce produit… » ; le client test commande un cookie (commande terminée), laisse une note 5/5 et un commentaire, l’avis passe en attente puis s’affiche une fois validé, avec le badge vérifié. |

## IT-15 : règles de tarification avancées

| User story | Mise en œuvre |
| --- | --- |
| US-15.1 | Deux réglages ajoutés dans **WooCommerce → Réglages → Expédition → Options d’expédition** : « Montant des frais » (1,50 € par défaut) et « Seuil » (15 € par défaut). |
| US-15.2 | `inc/frais-preparation.php` : la fonction accrochée à `woocommerce_cart_calculate_fees` ajoute « Frais de préparation » quand le sous-total est inférieur au seuil ; le calcul est refait à chaque mise à jour du panier et au checkout. |
| US-15.3 | Testé en local : une pêche d’enfer (8 €) → frais de 1,50 €, total 9,50 €, message « Plus que 7,00 € pour ne pas payer les frais de préparation » ; quantité 2 (16 €) → frais et message disparaissent, total 16 €. |

## IT-16 : landing page

| User story | Mise en œuvre |
| --- | --- |
| US-16.1 | Aucun réglage à faire : dès qu’un produit est publié dans **Produits → Ajouter**, il remplace le plus ancien des trois. |
| US-16.2 | `front-page.php` : section « Les nouveautés » sous les étapes « Comment ça marche », alimentée par `wc_get_products()` (3 produits publiés, du plus récent au plus ancien) et affichée avec les cartes produits de la boutique. |
| US-16.3 | Testé en local : la page d’accueil affiche les trois derniers produits du catalogue (pêche d’enfer, cookie de Maman, millefeuille), avec prix et bouton d’ajout au panier. |

## À traiter ensuite



## Sauvegardes locales

Les sauvegardes sont conservées hors du dossier web, dans `~/Desktop/SAE301-backups/`. Elles ne doivent pas être publiées sur GitHub :

- `before-it1-it2.sql.gz` et `wp-config-before-it1-it2.php` : état initial ;
- `before-prefix.sql.gz` : état avant migration du préfixe ;
- export final après validation : point de départ du transfert en production.
