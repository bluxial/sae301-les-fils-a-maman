<?php
/**
 * IT-5 : adresse du restaurant, paiements, zones d’expédition, pages panier et commande.
 * Relançable.
 * Local : ddev wp eval-file wp-content/themes/les-fils-a-maman/docs/paiement-livraison-it5.php
 * Prod  : wp eval-file wp-content/themes/les-fils-a-maman/docs/paiement-livraison-it5.php
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

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

wp_update_post(['ID' => wc_get_page_id('cart'), 'post_content' => '[woocommerce_cart]']);
wp_update_post(['ID' => wc_get_page_id('checkout'), 'post_content' => '[woocommerce_checkout]']);

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

$paris = new WC_Shipping_Zone();
$paris->set_zone_name('Paris');
$paris->set_zone_order(1);
$paris->add_location('FR', 'country');
$paris->add_location('75*', 'postcode');
$paris->save();

lf_tool_add_method($paris, 'local_pickup', 'Retrait au restaurant (Click & Collect)', '0');
lf_tool_add_method($paris, 'flat_rate', 'Livraison à vélo', '4.90');
lf_tool_add_method($paris, 'flat_rate', 'Livraison express (30 min)', '8.90');

$ailleurs = new WC_Shipping_Zone(0);

foreach ($ailleurs->get_shipping_methods() as $methode) {
    $ailleurs->delete_shipping_method($methode->get_instance_id());
}

lf_tool_add_method($ailleurs, 'local_pickup', 'Retrait au restaurant (Click & Collect)', '0');

lf_tool_message('OK : paiements, zones d’expédition et pages panier / commande configurés');
