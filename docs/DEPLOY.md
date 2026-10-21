# Processus de mise en production

Environnements :

| | Local (développement) | Production |
| --- | --- | --- |
| URL | http://sae301.ddev.site | https://mmi.unilim.fr/~maree2/r3SAE01 |
| Outil | DDEV (macOS) | SSH `maree2@mmi.unilim.fr`, WP-CLI |
| Dossier | `~/Desktop/SAE301` | `~/public_html/r3SAE01` |
| Base | conteneur DDEV | préfixe `sae301_` |

Le code du thème enfant est versionné sur GitHub :
https://github.com/bluxial/sae301-les-fils-a-maman

Aucun mot de passe n’est écrit dans ce dépôt ni dans les commandes : SSH le demande au moment de la connexion.

## 1. Mise en production courante (code du thème)

Chaque itération qui modifie le thème :

```bash
# Mac, dossier du thème
git add -A
git commit -m "[IT-X] Description"
git push

# Serveur
ssh maree2@mmi.unilim.fr
cd ~/public_html/r3SAE01/wp-content/themes/les-fils-a-maman
git pull
```

Le script `~/Desktop/SAE301-backups/mettre-a-jour.sh` fait ces deux étapes et les contrôles. Puis ajouter une ligne dans `docs/CHANGELOG-PROD.md` (date, itération, commit, notes), committer et pousser.

Depuis le 21/10/2026, le thème en production est un clone du dépôt GitHub. Avant, il était envoyé en archive : le premier passage au clone remplace le dossier après l’avoir sauvegardé dans `~/sauvegardes-r3SAE01`.

## 2. Réglages et contenus (base de données)

Les réglages WooCommerce, les produits, les pages et les groupes SCF sont en base. Deux possibilités :

- refaire le réglage en production avec un script du dossier `docs/` :

  ```bash
  cd ~/public_html/r3SAE01
  wp eval-file wp-content/themes/les-fils-a-maman/docs/seo-it21.php
  ```

- ou renvoyer toute la base locale avec `~/Desktop/SAE301-backups/deployer.sh`, tant qu’aucune commande réelle n’existe en production. Le script sauvegarde la base de production, importe la base locale, remplace les adresses (`http://sae301.ddev.site` → adresse MMI) et supprime les commandes, comptes et avis de test (`nettoyage-prod.php`).

Les groupes de champs, le type de publication « Équipe » et la taxonomie « Envies » sont aussi enregistrés dans `acf-json/` : SCF propose de les synchroniser (SCF → Groupes de champs → « Synchronisation disponible ») s’ils manquent en base.

## 3. Extensions

```bash
# Serveur, après installation et validation en local
cd ~/public_html/r3SAE01
wp plugin install <slug> --activate
```

Le dossier `docs/` est fermé aux visiteurs par `docs/.htaccess` (scripts lancés uniquement avec WP-CLI).

Le dossier `wp-content/uploads` appartient au serveur web : les fichiers ne peuvent pas y être copiés directement en SSH.

## 4. Vérifications

- Thème actif `les-fils-a-maman` (`wp theme list`) et extensions actives (`wp plugin list`).
- Accueil, boutique, une catégorie, une fiche produit, panier, commande, compte, en ordinateur et en mobile.
- Aucune adresse `sae301.ddev.site` restante.
- Titres et balises Open Graph présents (Yoast SEO).

## 5. Retour arrière

- Thème : `git checkout <commit>` dans le dossier du thème sur le serveur, ou `git revert` puis `git pull`.
- Base : `wp db import ~/sauvegardes-r3SAE01/base-avant-<date>.sql`.

## E-mails en production

En local, DDEV capture tous les e-mails dans Mailpit (`http://sae301.ddev.site:8025`) : rien n’est envoyé. Sur mmi.unilim.fr, les e-mails partent réellement. Consigne de la DSI (20/10/2026) : utiliser uniquement des adresses e-mail réelles pour les comptes et commandes de test en production, jamais d’adresses inventées (ex. : `test@example.com`, `moi@gmail.com`), pour ne pas faire blacklister le serveur. Les commandes de test locales ne sont pas recopiées en production.
