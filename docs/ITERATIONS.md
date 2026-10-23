# Itérations

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
| US-3.1 | Trois produits simples deviennent variables avec le script `docs/produits-variables-it3.php` (WP-CLI) : croquettes de chorizo (Portion 4 ou 8 pièces, 8 € / 14 €), cordon bleu des Fistons (Accompagnement), œufs Bénédicte (Garniture, 17,50 € / 19 €). Stock géré par déclinaison : disponible, faible (5 portions ou moins) et épuisé. Modifiable ensuite dans **Produits → Modifier → Variations**. |
| US-3.2 | Le modèle `woocommerce/single-product/add-to-cart/variable.php` remplace les listes déroulantes par les pastilles `lf-options` / `lf-chip` du design system. Les listes restent cachées dans la page car le script de WooCommerce s’en sert ; `theme.js` les met à jour quand on clique sur une pastille. |
| US-3.3 | Sur la fiche, le prix, le stock et le bouton changent selon l’option choisie. Sur les cartes : « À partir de … » et bouton « Choisir + ». Badge jaune « Plus que X en stock » quand le stock est faible, « Rupture de stock » et bouton désactivé quand il est épuisé. |

## IT-4 : enrichissement du contenu

| User story | Mise en œuvre |
| --- | --- |
| US-4.1 | Groupe de champs Secure Custom Fields « Informations du produit » créé dans SCF → Groupes de champs (affichage dans `functions.php`) : Composition (texte), Allergènes (cases à cocher), Valeur énergétique (nombre). Il apparaît sous l’éditeur de chaque produit dans le back office. |
| US-4.2 | Les neuf produits sont remplis avec `docs/champs-produits-it4.php` (WP-CLI). Compositions reprises de la carte du restaurant ; allergènes et calories indicatifs, modifiables dans chaque fiche. |
| US-4.3 | Fonction `lf_product_facts()` accrochée à `woocommerce_single_product_summary` (priorité 22) : après la description (20) et avant le prix (25). Affichage avec le composant `lf-facts` de la maquette. |
| US-4.4 | Le visiteur voit composition, allergènes et énergie sur la fiche du produit. Rien ne s’affiche si les champs sont vides. |

## IT-5 : panier et expédition

| User story | Mise en œuvre |
| --- | --- |
| US-5.1 | Script `docs/paiement-livraison-it5.php` : « Virement bancaire » et « Paiement au retrait » (paiement à la livraison de WooCommerce renommé, réservé au retrait au restaurant). Réglages dans **WooCommerce → Réglages → Paiements**. |
| US-5.2 | Zone « Paris » (France, codes postaux 75*) : Retrait au restaurant gratuit, Livraison à vélo 4,90 €, Livraison express 8,90 € (depuis IT-19 : livraison à vélo au poids, express retirée). Ailleurs : retrait au restaurant seulement. Adresse du restaurant : 7 bis rue Geoffroy-Marie, 75009 Paris. |
| US-5.3 | Pages panier et commande passées en version classique (shortcodes) pour pouvoir les personnaliser. Modèle `woocommerce/cart/cart.php` simplifié : articles en cartes `lf-cart-item`, récapitulatif `lf-summary` comme dans la maquette. |
| US-5.4 | Testé en local : ajout de 8 croquettes (14 €), panier, choix du mode d’expédition. Avec le code postal 75009 : trois modes ; la livraison à vélo ajoute 4,90 € (total 18,90 €) et retire le paiement au retrait. |

## IT-6 : checkout

| User story | Mise en œuvre |
| --- | --- |
| US-6.1 | Bloc « Instructions pour le retrait » affiché dans la validation de commande, juste avant le choix du paiement (`functions.php`). Le texte se modifie dans **WooCommerce → Réglages → Expédition → Options d’expédition**, champ « Instructions pour le retrait ». Un texte par défaut est utilisé si le champ est vide. |
| US-6.2 | Testé en local : panier → validation de commande → retrait au restaurant → paiement au retrait → « Commander ». Commande n° 46 reçue (14 €), page de confirmation affichée. |

## IT-7 : compte client

| User story | Mise en œuvre |
| --- | --- |
| US-7.1 | Script `docs/compte-client-it7.php` : inscription depuis « Mon compte » et pendant la commande, rappel de connexion au checkout, le client choisit son mot de passe, identifiant créé à partir de l’e-mail. Réglages dans **WooCommerce → Réglages → Comptes et confidentialité**. |
| US-7.2 | Connexion et inscription dans deux cartes crème côte à côte (une colonne sur mobile). Menu du compte en pastilles `lf-chip` (`woocommerce/myaccount/navigation.php`), page active en encre. « Téléchargements » retiré du menu (`functions.php`) : la boutique ne vend pas de fichiers. |
| US-7.2 (v2, 21/10) | Espace client refait : menu en colonne à gauche (pastilles sur mobile), tableau de bord `woocommerce/myaccount/dashboard.php` avec bandeau « Bonjour … ! », carte « Ma dernière commande » (numéro, total, mode de retrait, créneau, badge de statut coloré) et trois raccourcis colorés (commandes, adresses, informations). Tableaux, adresses et formulaires du compte en cartes crème. |
| US-7.3 | Testé en local : inscription d’un client test, tableau de bord, commandes, adresses, détails du compte, déconnexion. Identifiants de test rangés hors du dépôt dans `SAE301-backups/comptes-test.md`. |

## IT-8 : e-mails transactionnels

| User story | Mise en œuvre |
| --- | --- |
| US-8.1 | Script `docs/emails-it8.php` : expéditeur « Les Fils à Maman », couleurs de la charte (turquoise, pêche, crème, encre), pied de page, e-mails client activés en HTML (commande reçue, en cours, terminée, annulée, remboursée, nouveau compte). Réglages dans **WooCommerce → Réglages → E-mails**. |
| US-8.2 | Modèles `woocommerce/emails/email-header.php` et `email-footer.php` simplifiés : logo PNG (`assets/img/logo-email.png`), accroche « Click & Collect », adresse du restaurant. Bordure encre, coins arrondis et ombre portée ajoutés avec le filtre `woocommerce_email_styles` (`functions.php`). |
| US-8.3 | Bloc jaune « Instructions pour le retrait » ajouté aux e-mails envoyés au client quand la commande est en retrait au restaurant (même texte que le checkout, version texte brut prévue). |
| US-8.4 | Testé en local avec Mailpit (`http://sae301.ddev.site:8025`) : e-mail « Merci pour votre commande » de la commande n° 48 avec logo, couleurs et instructions de retrait. |

## IT-9 : commandes

| User story | Mise en œuvre |
| --- | --- |
| US-9.1 | Commandes visibles dans **WooCommerce → Commandes**. Nouveau statut « Prête à retirer » entre « En cours » et « Terminée » (`functions.php`), disponible dans la fiche commande et en action groupée. Stock géré par déclinaison : la commande de 8 croquettes fait passer le stock de 3 à 2 ; une annulation remet le stock. Script `docs/commandes-it9.php` : textes des e-mails de suivi. |
| US-9.2 | Testé en local : panier de deux produits (beignets + œufs mimosa, 14,50 €), retrait au restaurant, paiement au retrait → commande n° 49 « En cours » (e-mail « reçue ») → « Prête à retirer » (e-mail « Votre commande est prête ! » avec les instructions de retrait) → « Terminée » (e-mail « Bon appétit ! »). Le client suit aussi le statut dans **Mon compte → Commandes**. |
| US-9.3 | Testé en local avec le client connecté : cookie de Maman, livraison à vélo, virement (10,90 €) → n° 50 « En attente » (e-mail « en attente de votre virement ») → « En cours » (paiement reçu, préparation) → « Annulée » (e-mail d’annulation) → remboursement total → « Remboursée » (e-mail de remboursement). Tous les e-mails vérifiés dans Mailpit. |

## IT-10 : promotions

| User story | Mise en œuvre |
| --- | --- |
| US-10.1 | Script `docs/promotions-it10.php` : FISTONS10 (pourcentage, -10 % sur le cordon bleu et le tartare), MAMAN2 (montant fixe, -2 € sur le cookie et le millefeuille), ETE2025 (expiré, pour les tests). Codes modifiables dans **Marketing → Codes promo**. |
| US-10.2 | Champ « Code promo » ajouté au modèle panier, sous les articles ; ligne de réduction en orange dans le récapitulatif avec le lien « Enlever ». |
| US-10.3 | Testé en local avec un tartare (21 €) : FAUX → « n’existe pas » ; ETE2025 → « a expiré » ; MAMAN2 → « n’est pas applicable aux produits sélectionnés » ; FISTONS10 → -2,10 €, total 18,90 € ; « Enlever » → retour à 21 €. |

## IT-11 : équipe

| User story | Mise en œuvre |
| --- | --- |
| US-11.1 | Type de contenu « Équipe » (`membre`) créé dans SCF → Types de publication, avec son menu dans le back office : un membre = une page. Groupe de champs SCF « Profil du membre » (créé dans SCF → Groupes de champs) : poste, plat préféré, couleur de la carte. La photo se met en « Image mise en avant » ; sans photo, les initiales s’affichent. |
| US-11.2 | Script `docs/equipe-it11.php` : trois profils fictifs (cheffe de cuisine, pâtissier, responsable du Click & Collect). |
| US-11.3 | Modèles `archive-membre.php` (liste, adresse `/equipe/`) et `single-membre.php` (profil). Ordre d’affichage réglable avec le champ « Ordre » du membre. |
| US-11.4 | Pas d’écran « Équipe » dans la maquette Figma : les pages reprennent les composants du design system (cartes colorées, bordures et ombres, titres Luckiest Guy, bloc `lf-facts`). Écran à ajouter dans Figma pour la cohérence du rendu. |
| US-11.5 | Lien « L’équipe » ajouté au menu principal et au pied de page. Testé en local : liste des trois membres et page de profil. |

## IT-12 : taxonomies

| User story | Mise en œuvre |
| --- | --- |
| US-12.1 | Taxonomie « Envies » (`envie`) indépendante des catégories, rattachée aux produits, créée dans SCF → Taxonomies. Administration dans **Produits → Envies** (nom, description), colonne dans la liste des produits. Le filtre `register_taxonomy_args` la déclare hiérarchique pour que la fiche produit affiche des **cases à cocher** (et non un champ d’étiquettes) ; les adresses ne changent pas. |
| US-12.2 | Script `docs/envies-it12.php`, relançable : Végétarien (4 produits), Gourmand (3), Léger (3), chacune avec une description courte. |
| US-12.3 | Page dédiée par envie (`/envie/vegetarien/`, `/envie/gourmand/`, `/envie/leger/`) : titre, texte de présentation (description de l’envie), grille de la boutique avec filtres ; pastilles « Envie de : » sous les catégories. Titre de l’onglet et meta description Yoast propres à l’envie (« Gourmand : la carte selon ton envie - Les Fils à Maman ») au lieu de « Archives des Gourmand ». Affichage mobile corrigé (une colonne). |

## IT-13 : ventes croisées

| User story | Mise en œuvre |
| --- | --- |
| US-13.1 | Script `docs/ventes-croisees-it13.php` : six produits reçoivent 2 ou 3 produits complémentaires (ex. : cordon bleu → pêche d’enfer, cookie, beignets). Modifiable dans **Produits → Modifier → Données produit → Produits liés → Ventes croisées**. |
| US-13.2 | `functions.php` : bloc « Ça va bien avec… » sous la fiche produit et « Pour compléter ta commande » sous le panier, en cartes horizontales `lf-recommendation` comme dans la maquette (photo, nom, prix, bouton « + » turquoise qui ajoute au panier sans recharger la page). Correctif du 21/10 : couleurs de bouton identiques et lien noir « Voir le panier » supprimé. |
| US-13.3 | Testé en local : fiche du cordon bleu (3 suggestions) et panier avec un tartare (pêche d’enfer et millefeuille), boutons « Ajouter + » fonctionnels. |

## IT-14 : avis clients

| User story | Mise en œuvre |
| --- | --- |
| US-14.1 | Les onglets WooCommerce étant retirés, les avis sont affichés sous la fiche produit (`functions.php`, `comments_template()`), dans des cartes crème avec bordure, étoiles orange, formulaire dans un cadre aux couleurs du site. |
| US-14.2 | Script `docs/avis-it14.php` : avis activés sur les 9 produits, note obligatoire, avis réservés aux clients connectés qui ont acheté le produit, badge « propriétaire vérifié ». Les avis sont validés dans **Produits → Avis**. Testé en local : un visiteur non acheteur voit le message « Seuls les clients connectés ayant acheté ce produit… » ; le client test commande un cookie (commande terminée), laisse une note 5/5 et un commentaire, l’avis passe en attente puis s’affiche une fois validé, avec le badge vérifié. |

## IT-15 : règles de tarification avancées

| User story | Mise en œuvre |
| --- | --- |
| US-15.1 | Deux réglages ajoutés dans **WooCommerce → Réglages → Expédition → Options d’expédition** : « Montant des frais » (1,50 € par défaut) et « Seuil » (15 € par défaut). |
| US-15.2 | `functions.php` : la fonction accrochée à `woocommerce_cart_calculate_fees` ajoute « Frais de préparation » quand le sous-total est inférieur au seuil ; le calcul est refait à chaque mise à jour du panier et au checkout. |
| US-15.3 | Testé en local : une pêche d’enfer (8 €) → frais de 1,50 €, total 9,50 €, message « Plus que 7,00 € pour ne pas payer les frais de préparation » ; quantité 2 (16 €) → frais et message disparaissent, total 16 €. |

## IT-16 : landing page

| User story | Mise en œuvre |
| --- | --- |
| US-16.1 | Aucun réglage à faire : dès qu’un produit est publié dans **Produits → Ajouter**, il remplace le plus ancien des trois. |
| US-16.2 | `front-page.php` : section « Les nouveautés » sous les étapes « Comment ça marche », alimentée par `wc_get_products()` (3 produits publiés, du plus récent au plus ancien) et affichée avec les cartes produits de la boutique. |
| US-16.3 | Testé en local : la page d’accueil affiche les trois derniers produits du catalogue (pêche d’enfer, cookie de Maman, millefeuille), avec prix et bouton d’ajout au panier. |

## IT-17 : génération de factures

| User story | Mise en œuvre |
| --- | --- |
| US-17.1 | Extension « PDF Invoices & Packing Slips for WooCommerce » (WP Overnight, 5.16.5) installée depuis wordpress.org. Script `docs/factures-it17.php` : facture créée et jointe aux e-mails « commande en cours » et « commande terminée », numérotée, datée. |
| US-17.2 | Modèle du thème `woocommerce/pdf/lfam/` (copie du modèle Simple) : logo, nom et adresse du restaurant, titre « Facture » orange, en-tête du tableau turquoise, ligne Total jaune, filets encre. Réglages dans **WooCommerce → Documents PDF**. Mentions légales à compléter (SIRET, TVA) : l’enseigne est fictive pour ce projet, le pied de page l’indique. |
| US-17.3 | Téléchargement depuis **Mon compte → Commandes** dès que la facture existe (réglage « Uniquement quand une facture est déjà créée/envoyée »). Testé en local : facture n° 1 de la commande n° 58 générée depuis le back office et affichée en PDF. Facture jointe automatiquement à l’e-mail « commande reçue » (commande n° 60, `facture-2.pdf`). Bouton côté client à revérifier avec le compte client test. |

## IT-18 : recherche et filtrage

| User story | Mise en œuvre |
| --- | --- |
| US-18.1 | Script `docs/filtres-it18.php` : attribut global « Taille » (**Produits → Attributs**) avec deux valeurs, Petite faim (6 produits) et Grosse faim (3 produits), ajouté sans toucher aux options des produits variables. Le prix est filtré directement par WooCommerce. |
| US-18.2 | `functions.php` : barre latérale « Filtrer » à gauche de la grille (au-dessus sur mobile) : recherche, prix minimum et maximum, pastilles de taille. Le formulaire envoie les paramètres reconnus par WooCommerce (`s`, `min_price`, `max_price`, `filter_taille`) ; il reste sur la catégorie ou l’envie en cours. |
| US-18.3 | Testé en local : Grosse faim → cordon bleu, tartare, œufs Bénédicte ; prix 10–20 € → croquettes, cordon bleu, œufs Bénédicte ; Petite faim ≤ 7 € → œufs mimosa, cookie ; recherche « cookie » → fiche du cookie ; Plats + Grosse faim → 3 plats. |

## IT-19 : tarifs selon le poids

| User story | Mise en œuvre |
| --- | --- |
| US-19.1 | `functions.php` : le prix des livraisons « forfait » (Livraison à vélo) est remplacé par celui de la tranche correspondant au poids total du panier (`woocommerce_package_rates`). Script `docs/poids-it19.php` : poids d’une portion sur les 9 produits (0,15 à 0,6 kg, 0,6 kg pour 8 croquettes), unité kg. La livraison express (prix fixe) est retirée de la zone Paris pour garder un seul mode de livraison au poids. |
| US-19.2 | Trois tranches réglables dans **WooCommerce → Réglages → Expédition → Options d’expédition** : jusqu’à 1 kg 3,90 €, jusqu’à 3 kg 5,90 €, au-delà 8,90 €. |
| US-19.3 | Le poids et le prix s’affichent dans le panier et au checkout (« Livraison à vélo · 2,1 kg : 5,90 € »). Testé en local avec le calculateur du panier (75009) : 0,9 kg → 3,90 € ; 2,1 kg → 5,90 € ; 3,7 kg → 8,90 €. |

## IT-20 : créneaux de livraison et de retrait

| User story | Mise en œuvre |
| --- | --- |
| US-20.1 | `functions.php` : liste « Jour » dans le formulaire de commande, avec les 6 prochains jours (aujourd’hui compris). |
| US-20.2 | Pastilles « Créneau horaire » (midi : 12h00 à 13h30, soir : 19h00 à 20h30, par demi-heure), même composant que les options produit. |
| US-20.3 | Les mêmes champs servent au retrait au restaurant. Jour et créneau obligatoires et vérifiés côté serveur, enregistrés dans la commande, affichés sur la page de confirmation, dans Mon compte, dans la fiche commande du back office et dans les e-mails. Testé en local : sans choix → deux messages d’erreur ; avec mercredi 21 octobre, 12h30 – 13h00 → commande n° 60, créneau visible sur la confirmation, dans le back office et dans les e-mails client et administrateur (facture PDF jointe à l’e-mail client, IT-17). |

## IT-21 : optimisation SEO

| User story | Mise en œuvre |
| --- | --- |
| US-21.1 | Extension Yoast SEO : encadré « Titre SEO » et « Meta description » sous chaque produit et chaque catégorie du back office. Titres (moins de 60 caractères) et descriptions (moins de 155) rédigés pour les 9 produits, les 3 catégories, l’accueil et la boutique avec `docs/seo-it21.php`. |
| US-21.2 | Yoast SEO 28.7 installé et activé ; organisation « Les Fils à Maman » et logo déclarés pour les partages. Le thème appelle `wp_head()` et déclare `title-tag`, donc Yoast gère seul `<title>` et les balises. |
| US-21.3 | Vérifié en local sur les 14 pages : une seule balise `<title>`, `meta description`, `og:title`, `og:description`, `og:url`, `og:image` (photo du produit, logo pour l’accueil et les catégories) et `twitter:card`. |

## IT-22 : mentions légales et CGV

| User story | Mise en œuvre |
| --- | --- |
| US-22.1 | Page « Mentions légales » (`/mentions-legales/`) : projet pédagogique, éditeur et directeur de la publication, hébergeur (Université de Limoges), propriété intellectuelle, données personnelles, cookies. Elle sert aussi de page « Politique de confidentialité » de WordPress. Lien dans le pied de page. |
| US-22.2 | Page « Conditions générales de vente » (`/cgv/`) en 10 articles : produits, prix, commande, paiement, retrait et livraison, annulation, réclamations, données, droit applicable. Lien dans le pied de page. Pages créées avec `docs/pages-legales-it22.php`. |
| US-22.3 | WooCommerce → Réglages → Avancé : la page CGV est la « page des conditions générales ». WooCommerce ajoute la case obligatoire « J’ai lu et j’accepte les conditions générales » avant le bouton « Commander ». Testé en local : sans la case, la commande est refusée avec le message « Veuillez lire et accepter les conditions générales pour poursuivre votre commande ». |

## À traiter ensuite



## Sauvegardes locales

Les sauvegardes sont conservées hors du dossier web, dans `~/Desktop/SAE301-backups/`. Elles ne doivent pas être publiées sur GitHub :

- `before-it1-it2.sql.gz` et `wp-config-before-it1-it2.php` : état initial ;
- `before-prefix.sql.gz` : état avant migration du préfixe ;
- export final après validation : point de départ du transfert en production.

## Journal de travail

Historique des versions locales ; les chemins sont ceux de l’époque (avant la réorganisation du 21/10/2026, le CSS était dans system.css et assets/css/, le PHP dans inc/).

| Date | Version | Environnement | Travail / validation | Production |
| --- | --- | --- | --- | --- |
| 16/10/2026 | IT-1 | DDEV local | Audit de l’installation, sauvegardes, Classic Editor, thème enfant et préfixe dédié ; neuf produits et administrateur conservés. | Différée : transfert par Jules après validation locale. |
| 16/10/2026 | IT-2 | DDEV local | Intégration du design system, accueil, catalogue, catégories, fiches, images et navigation responsive. Tests décrits dans `VALIDATION.md`. | Non déployée. |
| 16/10/2026 | IT-2 / 0.2.1 | DDEV local et dépôt GitHub public | Réécriture avec du HTML/PHP simple, des fonctions nommées, des boucles et du JavaScript sans framework. CSS organisé avec `@layer`. Commentaires superflus et script d’import devenu inutile supprimés. Rendu et interactions vérifiés avant publication du code. | Non déployée. |
| 16/10/2026, 15 h 37 (Europe/Paris) | IT-1 + IT-2 / 0.2.1 | MMI, r3SAE01 | Sauvegarde du dossier distant ; transfert WordPress, trois extensions, parent/enfant et 63 médias ; import sérialisé de 52 tables avec URL MMI. 17 pages contrôlées, ajout AJAX et quantité jusqu’à trois portions, panier 24 €, suppression du test et menu mobile fonctionnels. Aucun outil de migration laissé dans le dossier web. Code : 30ca4fffc352a679f76c9c5b196cdacc57a8db3f. | Déployée : https://mmi.unilim.fr/~maree2/r3SAE01/ ; authentification « Devoir MMI ». |
| 20/10/2026 | IT-3 / 0.3.0 | DDEV local | Produits variables (3 produits, 8 déclinaisons, 3 niveaux de stock), pastilles d’options, prix et stock dynamiques. Script `docs/produits-variables-it3.php` à lancer avec `ddev wp eval-file`. | Non déployée. |
| 20/10/2026 | IT-4 / 0.4.0 | DDEV local | Champs SCF Composition, Allergènes et Énergie sur les produits, remplis pour les neuf produits et affichés avant le prix. Script `docs/champs-produits-it4.php`. | Non déployée. |
| 20/10/2026 | Local | DDEV local | Après `ddev start`, le conteneur a été recréé et le dossier `wp-content/uploads` local était vide (photos des produits en 404). Les 9 photos ont été remises depuis `assets/` du thème et les miniatures régénérées. Les médias de la production ne sont pas concernés. | — |
| 20/10/2026 | IT-5 / 0.5.0 | DDEV local | Virement et paiement au retrait, zone Paris (retrait gratuit, livraison vélo 4,90 €, express 8,90 €), panier classique aux couleurs de la maquette. Script `docs/paiement-livraison-it5.php`. | Non déployée. |
| 20/10/2026 | IT-6 / 0.6.0 | DDEV local | Instructions pour le retrait réglables dans WooCommerce et affichées dans le checkout. Commande test n° 46 (retrait, paiement au retrait) validée jusqu’à la confirmation. | Non déployée. |
| 20/10/2026 | IT-7 / 0.7.0 | DDEV local | Création de compte et connexion configurées, espace client aux couleurs du design system, client test créé. Script `docs/compte-client-it7.php`. | Non déployée. |
| 20/10/2026 | IT-8 / 0.8.0 | DDEV local | E-mails WooCommerce aux couleurs de l’enseigne (logo, bandeau, bordures), instructions de retrait dans les e-mails client. Vérifié dans Mailpit. Script `docs/emails-it8.php`. | Non déployée. |
| 20/10/2026 | IT-9 / 0.9.0 | DDEV local | Statut « Prête à retirer » avec e-mail, textes des e-mails de suivi, parcours retrait (n° 49) et livraison + virement + annulation + remboursement (n° 50) testés. Script `docs/commandes-it9.php`. | Non déployée. |
| 20/10/2026 | IT-10 / 0.10.0 | DDEV local | Codes promo pourcentage et montant fixe sur deux produits chacun, code expiré de test, champ code promo dans le panier. Script `docs/promotions-it10.php`. | Non déployée. |
| 20/10/2026 | IT-11 / 0.11.0 | DDEV local | Type de contenu Équipe, champs SCF, pages liste et profil, lien dans le menu. Trois profils fictifs créés avec `docs/equipe-it11.php`. | Non déployée. |
| 20/10/2026 | IT-12 / 0.12.0 | DDEV local | Taxonomie Envies (Végétarien, Gourmand, Léger), pages dédiées et pastilles dans la boutique. Script `docs/envies-it12.php`. | Non déployée. |
| 20/10/2026 | IT-13 / 0.13.0 | DDEV local | Ventes croisées sur six produits, affichées sur la fiche produit et sous le panier. Script `docs/ventes-croisees-it13.php`. | Non déployée. |
| 20/10/2026 | IT-14 / 0.14.0 | DDEV local | Avis clients sous la fiche produit, réservés aux acheteurs vérifiés, note obligatoire, modération. Script `docs/avis-it14.php`. | Non déployée. |
| 20/10/2026 | IT-15 / 0.15.0 | DDEV local | Frais de préparation automatiques sous un seuil, montant et seuil réglables dans WooCommerce, message dans le panier. | Non déployée. |
| 20/10/2026 | IT-16 / 0.16.0 | DDEV local | Section « Les nouveautés » (3 derniers produits, dynamique) sur la page d’accueil. | Non déployée. |
| 20/10/2026 | IT-18 / 0.18.0 | DDEV local | Barre latérale de filtres (recherche, prix, taille), attribut global Taille. Script `docs/filtres-it18.php`. IT-17 (factures PDF) en attente de l’installation de l’extension. | Non déployée. |
| 20/10/2026 | IT-17 / 0.18.0 | DDEV local | Factures PDF (extension PDF Invoices & Packing Slips) avec modèle aux couleurs de l’enseigne dans le thème, jointes aux e-mails et téléchargeables dans Mon compte. Script `docs/factures-it17.php`. | Non déployée. |
| 20/10/2026 | IT-19 / 0.19.0 | DDEV local | Poids des produits, livraison à vélo selon 3 tranches de poids réglables, express retirée. Script `docs/poids-it19.php`. | Non déployée. |
| 20/10/2026 | IT-20 / 0.20.0 | DDEV local | Jour et créneau horaire obligatoires au checkout (retrait et livraison), enregistrés et affichés partout (confirmation, compte, back office, e-mails). | Non déployée. |
| 21/10/2026 | Correctifs IT-13 / IT-14 | DDEV local | Suggestions en cartes horizontales conformes à la maquette (bouton « + » turquoise), lien « Voir le panier » lisible dans les cartes, message « pas encore d’avis » aux couleurs du site. | Non déployée. |
| 21/10/2026 | Correctif IT-7 | DDEV local | Nouvelle interface du compte client (menu latéral, tableau de bord, dernière commande, raccourcis). Profil administrateur remis à « Jules Marée » après des commandes de test. | Non déployée. |
| 21/10/2026 | Relecture du code | DDEV local | Code simplifié pour être lisible en 1re année : plus de fonctions PHP qui réécrivent le CSS (remplacées par `@import ... layer(theme)`), plus d’opérateur `??`, tableaux avec des clés nommées, commentaires simples dans chaque fichier `inc/`, `functions.php` et `theme.js`. Rendu identique vérifié page par page (desktop et mobile), checkout, créneaux, e-mails et options produit retestés. | Non déployée. |
| 21/10/2026 | Simplification du code | DDEV local | Code ramené aux notions vues en 1re année : ajout au panier sans AJAX (réglage WooCommerce décoché, la page se recharge et le compteur se met à jour), plus de « fragments », plus de `_n_noop`, initiales de l’équipe sans fonctions `mb_`, `get_field()` utilisé directement dans les modèles, boucle avec compteur au lieu de `array_slice`, JavaScript sans `closest`, `dataset` ni `stepUp`. Rendu identique vérifié page par page. | Non déployée. |
| 21/10/2026 | SCF dans le back office | DDEV local | Les groupes de champs « Informations du produit » et « Profil du membre » ne sont plus déclarés en PHP : ils sont enregistrés dans SCF → Groupes de champs, avec les mêmes clés (les valeurs déjà saisies sont conservées). Le PHP ne fait plus que l’affichage avec `get_field()`. | Non déployée. |
| 21/10/2026 | SCF dans le back office (suite) | DDEV local | Le type de publication « Équipe » (`membre`) et la taxonomie « Envies » (`envie`) sont créés dans SCF → Types de publication / Taxonomies au lieu de `register_post_type` et `register_taxonomy` en PHP. Mêmes réglages et mêmes adresses (/equipe/, /envie/…) ; membres, envies et liens avec les produits conservés. | Non déployée. |
| 21/10/2026, 10 h 37 (Europe/Paris) | IT-3 à IT-20 / 0.20.0 | https://mmi.unilim.fr/~maree2/r3SAE01/ | Commit 4ca724a. Sauvegarde de la prod (base + thèmes et extensions) dans `~/sauvegardes-r3SAE01`, envoi du thème et de PDF Invoices, import de la base locale, remplacement des adresses, suppression des 6 commandes de test, du compte de test et de son avis (consigne DSI). Contrôles : 0 commande, 1 compte administrateur, 0 adresse ddev, pages en ligne en 200. | Déployée. |
| 21/10/2026, 13 h 10 (Europe/Paris) | Correctif IT-7 | https://mmi.unilim.fr/~maree2/r3SAE01/ | Commit ab5573d poussé sur GitHub et thème mis à jour (espace avant le pied de page, bouton « voir le mot de passe ») ; logo de la médiathèque recopié. Base non modifiée. | Déployée. |
| 21/10/2026 | Design system W3C | DDEV local | system.css indépendant de WordPress, 0 erreur au Nu HTML Checker et au validateur CSS du W3C ; déclarations ordonnées (display, position, font, color) et px convertis en rem. Rendu identique vérifié sur 15 pages et sur la page du design system. | Non déployée. |
| 21/10/2026 | IT-21 / 0.21.0 | DDEV local | Yoast SEO : titres et meta descriptions des 9 produits, 3 catégories, accueil et boutique ; balises Open Graph vérifiées. | Non déployée. |
| 21/10/2026 | IT-22 / 0.22.0 | DDEV local | Pages Mentions légales et CGV, liens dans le pied de page, case CGV obligatoire au checkout (commande refusée sans elle). | Non déployée. |
| 21/10/2026 | Design system sans JavaScript | DDEV local | system.js supprimé : filtre des produits et menu mobile en HTML/CSS natif, fiche produit et panier montrés en états fixes, blocs de code et boutons « Copier » retirés. États en modificateurs BEM (`lf-chip--input`, `lf-btn--hover`, `lf-header__nav--open`) ou en `:has()`. Valeurs de la documentation en rem. 0 erreur aux validateurs W3C. | Non déployée. |
| 21/10/2026 | Design system à part | DDEV local | Dossier `design-system/` retiré du thème à la demande de Jules : le design system est livré dans le dossier séparé `MAREE-Jules-design-system`. | Non déployée. |
| 23/10/2026 | IT-12 (reprise) | https://mmi.unilim.fr/~maree2/r3SAE01/envie/gourmand/ | Cases à cocher dans la fiche produit, présentation de chaque envie, titres et descriptions Yoast, grille en une colonne sur mobile. | Voir le journal des mises en production. |
