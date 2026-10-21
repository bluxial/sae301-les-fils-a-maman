<?php
/**
 * IT-22 : pages Mentions légales et CGV, case à cocher au checkout.
 * Relançable.
 * Local : ddev wp eval-file wp-content/themes/les-fils-a-maman/docs/pages-legales-it22.php
 * Prod  : wp eval-file wp-content/themes/les-fils-a-maman/docs/pages-legales-it22.php
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

$mentions = <<<HTML
<p>Ce site est un <strong>projet pédagogique</strong> réalisé dans le cadre de la SAÉ 3.01 du BUT Métiers du Multimédia et de l’Internet (IUT du Limousin, Université de Limoges). Aucune vente réelle n’y est effectuée : les commandes sont des tests et aucun paiement n’est encaissé.</p>

<h2>Éditeur du site</h2>
<p>Jules Marée, étudiant en BUT MMI 2<sup>e</sup> année<br>
IUT du Limousin, Université de Limoges<br>
Contact : <a href="mailto:jules.maree@etu.unilim.fr">jules.maree@etu.unilim.fr</a></p>

<h2>Directeur de la publication</h2>
<p>Jules Marée</p>

<h2>Hébergeur</h2>
<p>Université de Limoges<br>
33 rue François Mitterrand, BP 23204<br>
87032 Limoges Cedex 01<br>
Téléphone : 05 55 14 91 00</p>

<h2>Propriété intellectuelle</h2>
<p>La marque Les Fils à Maman, ses logos et ses photographies appartiennent à leurs propriétaires respectifs. Ils sont utilisés ici uniquement dans le cadre d’un exercice pédagogique, sans but commercial.</p>

<h2>Données personnelles</h2>
<p>Les informations saisies lors de la création d’un compte ou d’une commande (nom, adresse e-mail, téléphone, adresse) servent uniquement à faire fonctionner le site pendant le projet. Elles ne sont ni vendues ni transmises à des tiers. Conformément au RGPD, vous pouvez demander l’accès, la modification ou la suppression de vos données en écrivant à l’adresse de contact ci-dessus.</p>

<h2>Cookies</h2>
<p>Le site utilise uniquement les cookies techniques de WordPress et WooCommerce, nécessaires à la connexion, au panier et à la commande. Aucun cookie publicitaire ou de mesure d’audience n’est déposé.</p>
HTML;

$lien_mentions = home_url('/mentions-legales/');

$cgv = <<<HTML
<p>Les présentes conditions générales de vente (CGV) s’appliquent aux commandes passées sur ce site. Il s’agit d’un <strong>projet pédagogique</strong> : les commandes sont des tests et ne sont ni préparées, ni livrées, ni facturées.</p>

<h2>1. Objet</h2>
<p>Les Fils à Maman, 7 bis rue Geoffroy-Marie, 75009 Paris, propose ses plats, desserts et boissons à emporter (Click &amp; Collect) ou en livraison dans Paris.</p>

<h2>2. Produits</h2>
<p>Les produits sont décrits sur leur fiche : composition, allergènes, valeur énergétique et options (taille de la portion, accompagnement…). Les photographies ne sont pas contractuelles. Les produits sont proposés dans la limite des stocks disponibles.</p>

<h2>3. Prix</h2>
<p>Les prix sont indiqués en euros, toutes taxes comprises. Des frais de préparation s’ajoutent aux paniers d’un petit montant ; leur montant et le seuil sont affichés dans le panier. Les frais de livraison dépendent du poids de la commande. Le total exact est affiché avant la validation de la commande.</p>

<h2>4. Commande</h2>
<p>Pour commander, le client ajoute les produits à son panier, choisit le retrait au restaurant ou la livraison, puis un jour et un créneau horaire. Il doit ensuite accepter les présentes CGV avant de valider. Un e-mail de confirmation récapitule la commande.</p>

<h2>5. Paiement</h2>
<p>Le paiement se fait au retrait, par carte ou en espèces, ou par virement bancaire. Les codes promo sont valables selon les conditions indiquées et ne sont pas cumulables, sauf mention contraire.</p>

<h2>6. Retrait et livraison</h2>
<p>Les commandes sont proposées sur les six prochains jours, aux créneaux du midi (12 h – 13 h 30) et du soir (19 h – 20 h 30). Le client reçoit un e-mail quand sa commande est prête à être retirée. Il présente son nom et son numéro de commande au comptoir.</p>

<h2>7. Annulation</h2>
<p>Les plats préparés étant des denrées qui se détériorent rapidement, le droit de rétractation ne s’applique pas (article L221-28 du Code de la consommation). Une commande peut être annulée en contactant le restaurant avant le début de sa préparation.</p>

<h2>8. Réclamations</h2>
<p>Toute réclamation peut être adressée au restaurant, de préférence le jour du retrait ou de la livraison.</p>

<h2>9. Données personnelles</h2>
<p>Les données nécessaires à la commande sont traitées comme indiqué dans les <a href="{$lien_mentions}">mentions légales</a>.</p>

<h2>10. Droit applicable</h2>
<p>Les présentes CGV sont soumises au droit français.</p>
HTML;

function lf_tool_save_page($slug, $titre, $contenu) {
    $page = get_page_by_path($slug);
    $donnees = [
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_name' => $slug,
        'post_title' => $titre,
        'post_content' => $contenu
    ];

    if ($page) {
        $donnees['ID'] = $page->ID;
    }

    $id = wp_insert_post($donnees);
    lf_tool_message('Page : ' . $titre . ' (' . $id . ')');
    return $id;
}

$mentions_id = lf_tool_save_page('mentions-legales', 'Mentions légales', $mentions);
$cgv_id = lf_tool_save_page('cgv', 'Conditions générales de vente', $cgv);

update_option('woocommerce_terms_page_id', $cgv_id);
update_option('wp_page_for_privacy_policy', $mentions_id);
update_option('woocommerce_checkout_terms_and_conditions_checkbox_text', 'J’ai lu et j’accepte les [terms]');

lf_tool_message('Page CGV choisie dans WooCommerce : case à cocher ajoutée au formulaire de commande');
