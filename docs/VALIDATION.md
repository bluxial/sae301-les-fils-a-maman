# Validation locale — 16 octobre 2026

Environnement testé : `http://sae301.ddev.site/`, thème enfant actif, Chrome. Ces résultats concernent DDEV ; la production n’a pas été déployée.

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

Il ne s’agit pas d’un audit d’accessibilité complet ni d’une validation multi-navigateurs. Les options de produits, champs SCF, stocks, emails et paiements seront contrôlés lorsqu’ils seront implémentés. Rejouer les vérifications après le transfert vers mmi.unilim.fr et après les mises à jour de WordPress/WooCommerce.
