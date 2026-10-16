# Validation locale et production — 16 octobre 2026

Environnement local testé : `http://sae301.ddev.site/`, thème enfant actif, Chrome. Les contrôles de production sont décrits plus bas.

## Catalogue et présentation

- Accueil, boutique, trois catégories et fiche des croquettes accessibles en HTTP 200.
- Neuf cartes dans la boutique ; trois produits simples par catégorie ; images, prix et descriptions présents.
- Contrôle responsive automatisé sur ces six pages à 1440, 1024, 768, 390 et 320 px : **30 contrôles réussis**, aucun débordement horizontal ni image cassée ; polices chargées.
- Inspection visuelle de l’accueil, de la fiche et des vues mobiles : palette, typographies, cartes, navigation et barre de panier conformes au design system intégré.
- Menu mobile : ouverture fonctionnelle et fermeture avec la touche Échap.

## Parcours WooCommerce

Dans une session visiteur neuve, sans créer de commande :

1. Ajout d’une portion de croquettes depuis la boutique : mise à jour AJAX du compteur du panier à 1.
2. Ouverture de la fiche et augmentation de la quantité à 2 avec le bouton « + ».
3. Envoi du formulaire natif : compteur du panier à 3.
4. Ouverture du panier et attente de son chargement : produit visible ; API Store WooCommerce confirmant trois unités du produit 15.

Le parcours complet a réussi sans erreur JavaScript ni requête en échec relevée pendant ce contrôle. Le panier utilisé reste le bloc natif WooCommerce ; sa personnalisation, la livraison, le paiement et la commande de bout en bout restent à valider dans les itérations suivantes.

## Environnement et code

- Syntaxe des fichiers PHP du thème contrôlée avec `php -l` dans DDEV.
- Préfixe de base `sae301_` confirmé ; neuf produits conservés et rôle administrateur toujours opérationnel après migration.
- Sauvegardes conservées hors du dossier web ; aucun SQL, identifiant ou fichier de configuration privé ne fait partie du dépôt du thème.

## Réécriture du code — version 0.2.1

- Syntaxe des onze fichiers PHP contrôlée dans DDEV et des fichiers JavaScript contrôlée avec Node.
- Parcours WooCommerce et trente contrôles responsive ci-dessus rejoués avec succès après réécriture.
- Cinquante-quatre captures avant/après couvrent l’accueil, le catalogue, les catégories, les neuf fiches, le panier, le compte, la commande et le design system, sur ordinateur et mobile.
- Comparaison détaillée de dix-sept vues : éléments visibles, dimensions, polices, couleurs, espacements, bordures, ombres et attributs des images identiques. Les deux captures du design system sont identiques pixel par pixel. Certaines captures WordPress présentent de légères variations de rasterisation des photos ; les fichiers des visuels n’ont pas été modifiés.
- Design system testé depuis le fichier local et depuis le thème servi en HTTP : filtres, options, quantités, panier de démonstration, copie du CSS et des couleurs, exemples de code et menu mobile fonctionnels, sans erreur JavaScript relevée.
- Le code utilise des fonctions nommées, des conditions et des boucles. Les appels et protections nécessaires à WordPress et WooCommerce sont conservés. Les feuilles CSS gardent leurs couches `@layer`.

## Limites de cette validation

Il ne s’agit pas d’un audit d’accessibilité complet ni d’une validation multi-navigateurs. Les options de produits, champs SCF, stocks, emails et paiements seront contrôlés lorsqu’ils seront implémentés. Rejouer les vérifications après les mises à jour de WordPress/WooCommerce.

## Production MMI — 16 octobre 2026, 15 h 37

Adresse : https://mmi.unilim.fr/~maree2/r3SAE01/. PHP 8.4.26, thème 0.2.1, préfixe sae301_. La base importée comporte 52 tables, neuf produits et un compte administrateur. Les 63 fichiers des dix pièces jointes, avec leurs variantes, sont présents.

- Dix-sept routes contrôlées dans Chrome avec la session universitaire déjà ouverte : accueil, boutique, trois catégories, neuf fiches, panier, compte et commande.
- Neuf produits dans la boutique, trois par catégorie, images et prix attendus. Aucun visuel cassé, aucune erreur PHP affichée ou console relevée, aucune référence DDEV dans le HTML contrôlé. Les polices du thème sont chargées.
- Ajout AJAX d’une portion de croquettes : compteur à 1. Ajout de deux portions depuis la fiche : compteur à 3, panier natif affichant trois unités et 24 €. Retrait du produit de test : panier vide et compteur à 0. Aucune commande créée.
- À 390 px, menu mobile ouvert puis fermé par Échap ; aucun débordement horizontal ni image cassée sur l’accueil. L’affichage du navigateur a ensuite été rétabli.
- L’adresse wp-admin mène au formulaire WordPress de connexion. Le rôle administrateur est conservé ; aucune session administrative interactive n’a été ouverte pendant ce contrôle.
- Les outils temporaires de restauration ont été retirés. SQL et configuration privée restent hors du dépôt et les sauvegardes hors de la racine web.

Une requête anonyme reçoit HTTP 401 avec l’authentification universitaire « Devoir MMI ». Les vérifications ont utilisé la session Chrome existante, sans extraire ses cookies ni identifiants HTTP. Le transfert n’ajoute pas les options, les paiements ou la livraison des prochaines itérations.
