# Journal des mises en production

| Date | Itération | Commit | Notes |
|---|---|---|---|
| 16/10/2026 | IT-1 + IT-2 | 30ca4ff | Première mise en ligne dans `~/public_html/r3SAE01` : WordPress, WooCommerce, SCF, Classic Editor, Storefront, thème enfant, 63 médias, base locale importée (préfixe `sae301_`, adresses remplacées). Sauvegarde du dossier existant avant. |
| 21/10/2026 | IT-3 à IT-20 | 4ca724a | Thème et extension PDF Invoices envoyés, base locale importée, adresses remplacées ; commandes, compte et avis de test supprimés (consigne DSI). Sauvegarde de la base et des dossiers avant (`~/sauvegardes-r3SAE01`). |
| 21/10/2026 | Correctif IT-7 | ab5573d | Thème mis à jour (espace avant le pied de page, bouton « voir le mot de passe »), logo de la médiathèque recopié. Base non modifiée. |
| 21/10/2026 | IT-21 + IT-22 | 4214a6b | Yoast SEO installé, base locale importée (titres et descriptions SEO, pages Mentions légales et CGV, case CGV), données de test supprimées. Sauvegarde avant. |
| 21/10/2026 | IT-2 + IT-6 | 7951639 | Thème mis à jour : design system sorti du thème, « Votre commande » à côté du formulaire au checkout. Base non modifiée. |
| 21/10/2026 | Réorganisation | 935df50 | Thème réorganisé comme chartier-child (style.css, functions.php, assets/img|js|fonts, acf-json, template-parts, docs/). Le thème en production devient un clone Git du dépôt (ancien dossier sauvegardé dans `~/sauvegardes-r3SAE01`), mises à jour par `git pull`. Logo des e-mails mis à jour. Base non modifiée. |
| 23/10/2026 | Correctif IT-6 | c74d02e | Thème mis à jour par `git pull` : espacement régulier entre les champs du formulaire de commande. Base non modifiée. |
| 23/10/2026 | IT-Y (audit Lighthouse) | 6e52ac8 | Site ouvert aux moteurs de recherche, icône du site, polices en WOFF2, galerie WooCommerce et police d’icônes retirées de la fiche produit. Lighthouse fiche produit : mobile 85-90 / 100 / 100 / 100, ordinateur 99 / 100 / 100 / 100. Base : option `blog_public` uniquement. |
| 23/10/2026 | IT-Y (mobile) + IT-11 (photos) | 08f74d6 | Boutique, catégories et envies en une colonne sur mobile (393 px), page 404 à la charte, photos de substitution pour l’équipe (affichées depuis `assets/img/equipe/`, la médiathèque n’étant pas modifiable en ligne de commande : `uploads` appartient à www-data). |
| 23/10/2026 | IT-12 (reprise) | 7b9afc4 | Envies : cases à cocher dans la fiche produit, texte de présentation sur chaque page d’envie, titres et descriptions Yoast. Base : descriptions des 3 envies (`wp eval-file docs/envies-it12.php`). |
