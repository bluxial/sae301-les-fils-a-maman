# Les Fils à Maman — thème enfant

Thème enfant de [Storefront](https://wordpress.org/themes/storefront/) pour le site Click & Collect des Fils à Maman.

Projet pédagogique, SAÉ 3.01, BUT MMI, IUT du Limousin. Non affilié au restaurant Les Fils à Maman.

- Développement local : DDEV (`http://sae301.ddev.site`)
- Production : https://mmi.unilim.fr/~maree2/r3SAE01/
- Mise en production : voir [`docs/DEPLOY.md`](docs/DEPLOY.md)
- Journal des mises en production : [`docs/CHANGELOG-PROD.md`](docs/CHANGELOG-PROD.md)
- Itérations et user stories : [`docs/ITERATIONS.md`](docs/ITERATIONS.md), tests : [`docs/VALIDATION.md`](docs/VALIDATION.md)
- Commits préfixés par l’itération : `[IT-X] message`

## Organisation des fichiers

| Fichier ou dossier | Rôle |
| --- | --- |
| `style.css` | En-tête du thème et tout le CSS, en couches `@layer`, découpé en parties numérotées (sommaire en haut du fichier). |
| `functions.php` | Tout le PHP du thème, découpé en parties numérotées par itération (sommaire en haut du fichier). |
| `header.php`, `footer.php`, `front-page.php`, `page.php`, `index.php` | Gabarits des pages. |
| `archive-membre.php`, `single-membre.php` | Liste de l’équipe et page d’un membre (IT-11). |
| `template-parts/membre-carte.php` | Carte d’un membre, utilisée dans la liste de l’équipe. |
| `woocommerce/` | Gabarits WooCommerce surchargés : boutique, carte et fiche produit, panier, compte, e-mails, factures PDF. |
| `acf-json/` | Groupes de champs, type de publication et taxonomie de Secure Custom Fields, enregistrés en JSON. |
| `assets/img/` | Logos, photo de l’accueil, sticker. |
| `assets/fonts/` | Polices Damion, Luckiest Guy et Signika. |
| `assets/js/` | `menu.js` (menu mobile), `quantite.js` et `options-produit.js` (fiche produit). |
| `docs/` | Documentation et scripts des itérations (`equipe-it11.php`…), lancés avec `wp eval-file`. |

## Extensions

WooCommerce, Secure Custom Fields, Classic Editor, PDF Invoices & Packing Slips for WooCommerce (IT-17) et Yoast SEO (IT-21).

## Conventions CSS

- Couches dans cet ordre : `theme` (Storefront) → `lf-reset` → `lf-fonts` → `lf-tokens` → `lf-base` → `lf-components` → `lf-utilities` → `lf-overrides` ; la dernière couche gagne toujours.
- Noms de classes BEM : bloc `lf-card`, élément `lf-card__name`, modificateur `lf-card--horizontal` ; les états sont des modificateurs (`lf-chip--input`, `lf-header__nav--open`) ou viennent du HTML (`:has(input:checked)`).
- Déclarations dans le même ordre : display, position (avec dimensions, marges et bordures), font, color, puis le reste.
- Unités en rem (1rem = 16px). Exceptions : CSS des e-mails et des factures PDF, en px.

## Design system

Le design system est livré à part, dans le dossier `MAREE-Jules-design-system` (HTML et CSS uniquement). Son `system.css` reprend les parties 3 à 15 de `style.css` : après une modification de ces parties, recopier les mêmes règles dans le design system.
