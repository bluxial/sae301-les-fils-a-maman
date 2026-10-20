# Journal des versions et mises en production

| Date | Version | Environnement | Travail / validation | Production |
| --- | --- | --- | --- | --- |
| 16/10/2026 | IT-1 | DDEV local | Audit de l’installation, sauvegardes, Classic Editor, thème enfant et préfixe dédié ; neuf produits et administrateur conservés. | Différée : transfert par Jules après validation locale. |
| 16/10/2026 | IT-2 | DDEV local | Intégration du design system, accueil, catalogue, catégories, fiches, images et navigation responsive. Tests décrits dans `VALIDATION.md`. | Non déployée. |
| 16/10/2026 | IT-2 / 0.2.1 | DDEV local et dépôt GitHub public | Réécriture avec du HTML/PHP simple, des fonctions nommées, des boucles et du JavaScript sans framework. CSS organisé avec `@layer`. Commentaires superflus et script d’import devenu inutile supprimés. Rendu et interactions vérifiés avant publication du code. | Non déployée. |
| 16/10/2026, 15 h 37 (Europe/Paris) | IT-1 + IT-2 / 0.2.1 | MMI, r3SAE01 | Sauvegarde du dossier distant ; transfert WordPress, trois extensions, parent/enfant et 63 médias ; import sérialisé de 52 tables avec URL MMI. 17 pages contrôlées, ajout AJAX et quantité jusqu’à trois portions, panier 24 €, suppression du test et menu mobile fonctionnels. Aucun outil de migration laissé dans le dossier web. Code : 30ca4fffc352a679f76c9c5b196cdacc57a8db3f. | Déployée : https://mmi.unilim.fr/~maree2/r3SAE01/ ; authentification « Devoir MMI ». |
| 20/10/2026 | IT-3 / 0.3.0 | DDEV local | Produits variables (3 produits, 8 déclinaisons, 3 niveaux de stock), pastilles d’options, prix et stock dynamiques. Script `tools/it3-produits-variables.php` à lancer avec `ddev wp eval-file`. | Non déployée. |

Pour chaque mise en production, ajouter une ligne avec date/heure, URL, hash du commit, export de base utilisé, fichiers transférés, tests effectués et éventuels problèmes. Ne pas consigner de mots de passe.
