<?php
/**
 * IT-5 : paiements, zones d'expédition et pages panier / commande.
 * À lancer depuis le dossier du site :
 * ddev wp eval-file wp-content/themes/les-fils-a-maman/tools/it5-paiement-livraison.php
 * Ou en local dans le navigateur : https://sae301.ddev.site/?lf_outil=it5-paiement-livraison
 * Le script peut être relancé : il recrée les zones.
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

// 1. Adresse du restaurant et pays de vente.
update_option('woocommerce_store_address', '7 bis rue Geoffroy-Marie');
update_option('woocommerce_store_city', 'Paris');
update_option('woocommerce_store_postcode', '75009');
update_option('woocommerce_default_country', 'FR');
update_option('woocommerce_currency', 'EUR');
update_option('woocommerce_allowed_countries', 'specific');
update_option('woocommerce_specific_allowed_countries', ['FR']);
update_option('woocommerce_ship_to_countries', '');
update_option('woocommerce_enable_shipping_calc', 'yes');
update_option('woocommerce_shipping_cost_requires_address', 'no');

// 2. Moyens de paiement : virement et paiement au retrait.
update_option('woocommerce_bacs_settings', [
    'enabled' => 'yes',
    'title' => 'Virement bancaire',
    'description' => 'Faites votre virement en indiquant le numéro de commande. La commande est préparée dès réception.',
    'instructions' => 'Indiquez votre numéro de commande dans le libellé du virement.'
]);

update_option('woocommerce_cod_settings', [
    'enabled' => 'yes',
    'title' => 'Paiement au retrait',
    'description' => 'Réglez par carte ou en espèces au comptoir, au moment du retrait.',
    'instructions' => 'Vous réglerez votre commande au comptoir, au moment du retrait.',
    'enable_for_methods' => ['local_pickup'],
    'enable_for_virtual' => 'no'
]);

// 3. Panier et commande en version classique (shortcodes) pour pouvoir les personnaliser.
wp_update_post(['ID' => wc_get_page_id('cart'), 'post_content' => '[woocommerce_cart]']);
wp_update_post(['ID' => wc_get_page_id('checkout'), 'post_content' => '[woocommerce_checkout]']);

// 4. Zones d'expédition.
function lf_tool_add_method($zone, $type, $titre, $prix) {
    $instance_id = $zone->add_shipping_method($type);

    update_option('woocommerce_' . $type . '_' . $instance_id . '_settings', [
        'title' => $titre,
        'tax_status' => 'none',
        'cost' => wc_format_localized_price($prix)
    ]);
}

foreach (WC_Shipping_Zones::get_zones() as $ancienne_zone) {
    if ($ancienne_zone['zone_name'] === 'Paris') {
        WC_Shipping_Zones::delete_zone($ancienne_zone['id']);
    }
}

// Paris : retrait gratuit et deux livraisons payantes.
$paris = new WC_Shipping_Zone();
$paris->set_zone_name('Paris');
$paris->set_zone_order(1);
$paris->add_location('FR', 'country');
$paris->add_location('75*', 'postcode');
$paris->save();

lf_tool_add_method($paris, 'local_pickup', 'Retrait au restaurant (Click & Collect)', '0');
lf_tool_add_method($paris, 'flat_rate', 'Livraison à vélo', '4.90');
lf_tool_add_method($paris, 'flat_rate', 'Livraison express (30 min)', '8.90');

// Ailleurs : seulement le retrait au restaurant.
$ailleurs = new WC_Shipping_Zone(0);

foreach ($ailleurs->get_shipping_methods() as $methode) {
    $ailleurs->delete_shipping_method($methode->get_instance_id());
}

lf_tool_add_method($ailleurs, 'local_pickup', 'Retrait au restaurant (Click & Collect)', '0');

lf_tool_message('OK : paiements, zones d’expédition et pages panier / commande configurés');
