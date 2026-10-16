# Transfert DDEV → mmi.unilim.fr

Cette procédure est préparée pour le transfert que Jules réalisera avec FileZilla et phpMyAdmin. Aucune mise en production n’a encore été exécutée.

## Préparation locale

1. Vérifier la boutique, les catégories, les neuf fiches et le panier sur `http://sae301.ddev.site/`.
2. Committer l’itération dans Git, avec un message commençant par `[IT-X]`.
3. Exporter la base hors du dossier web :

   ```sh
   ddev export-db --gzip=false --file=../SAE301-backups/sae301-it2.sql
   ```

4. Relever l’URL de production, le nom de la base, son utilisateur et son préfixe. La base exportée utilise `sae301_`.

## Fichiers avec FileZilla

Transférer l’installation WordPress dans le répertoire prévu sur l’hébergement. Inclure le thème parent `wp-content/themes/storefront/`, le thème enfant `wp-content/themes/les-fils-a-maman/`, les extensions nécessaires dans `wp-content/plugins/` et les médias dans `wp-content/uploads/`.

Ne pas transférer `.ddev/`, les sauvegardes, `.git/` ou la configuration locale DDEV comme configuration de production. Les images des produits sont dans `uploads/`, pas uniquement dans le thème ; le ZIP du thème ne suffit donc pas à transférer tout le site.

## Base avec phpMyAdmin

1. Sauvegarder la base de production si elle contient déjà des données.
2. Importer l’export SQL dans la base dédiée, en vérifiant la limite de taille d’import.
3. Configurer un `wp-config.php` propre à l’hébergement : `DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_HOST`, charset/collation appropriés et `$table_prefix = 'sae301_';`. Utiliser des clés et sels d’authentification propres à la production. Ne pas placer les identifiants dans Git.
4. Remplacer les URL locales en respectant les données PHP sérialisées. Un remplacement SQL brut avec `REPLACE()` peut les casser.

Si l’hébergement propose SSH/WP-CLI, exécuter depuis le dossier WordPress, avec l’URL de production réelle :

```sh
wp search-replace 'http://sae301.ddev.site' 'https://URL-PRODUCTION' --all-tables-with-prefix --skip-columns=guid --dry-run
# Après vérification du résultat :
wp search-replace 'http://sae301.ddev.site' 'https://URL-PRODUCTION' --all-tables-with-prefix --skip-columns=guid
wp rewrite flush
```

Sans SSH, préparer un export adapté à la production avec un outil de migration qui gère les données sérialisées, sur une copie de la base locale. Les URL `home` et `siteurl` seules ne couvrent pas tous les liens et réglages. Prévoir ce traitement avant l’import définitif.

## Vérifications avant validation

- Administration et frontend accessibles à l’URL de production.
- Thème enfant actif et parent Storefront disponible.
- Extensions actives, catégories correctes, neuf produits avec images et prix.
- Aucun lien, script ou visuel ne pointe encore vers `sae301.ddev.site`.
- Boutique, fiche, panier, connexion et navigation mobile vérifiés.
- Permaliens actualisés, HTTPS et envoi d’emails vérifiés selon l’hébergement.

Compléter `JOURNAL.md` avec l’URL, la date, le commit et les tests réellement exécutés. Ne pas annoncer l’itération comme déployée avant ces contrôles.
