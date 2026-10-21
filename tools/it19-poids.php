<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

update_option('woocommerce_weight_unit', 'kg');

$poids = [
    'chorizo' => '0.3',
    'courgettes' => '0.3',
    'mimosa' => '0.25',
    'Cordon bleu' => '0.6',
    'Tartare' => '0.5',
    'Bénédicte' => '0.45',
    'Millefeuille' => '0.2',
    'Cookie' => '0.15',
    'pêche' => '0.4'
];

foreach ($poids as $mot => $kg) {
    $product = wc_get_product(lf_tool_find_product($mot));

    if (!$product) {
        lf_tool_message('Attention : produit introuvable : ' . $mot);
        continue;
    }

    $product->set_weight($kg);
    $product->save();

    foreach ($product->get_children() as $variation_id) {
        $variation = wc_get_product($variation_id);

        if (strpos($variation->get_attribute('portion'), '8') !== false) {
            $variation->set_weight('0.6');
            $variation->save();
        }
    }

    lf_tool_message('OK : ' . $product->get_name() . ' : ' . $kg . ' kg');
}

foreach (WC_Shipping_Zones::get_zones() as $zone_data) {
    if ($zone_data['zone_name'] === 'Paris') {
        $zone = new WC_Shipping_Zone($zone_data['id']);

        foreach ($zone->get_shipping_methods() as $methode) {
            if (strpos($methode->get_title(), 'express') !== false) {
                $zone->delete_shipping_method($methode->get_instance_id());
                lf_tool_message('OK : livraison express retirée');
            }
        }
    }
}

update_option('lf_poids_seuil_1', '1');
update_option('lf_poids_prix_1', '3.9');
update_option('lf_poids_seuil_2', '3');
update_option('lf_poids_prix_2', '5.9');
update_option('lf_poids_prix_3', '8.9');

lf_tool_message('OK : tranches 0–1 kg 3,90 € · 1–3 kg 5,90 € · plus de 3 kg 8,90 €');
