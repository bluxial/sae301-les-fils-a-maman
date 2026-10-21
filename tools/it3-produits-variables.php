<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

update_option('woocommerce_manage_stock', 'yes');
update_option('woocommerce_notify_low_stock_amount', 5);
update_option('woocommerce_notify_no_stock_amount', 0);
update_option('woocommerce_stock_format', 'low_amount');
update_option('woocommerce_hide_out_of_stock_items', 'no');

function lf_tool_make_variable($mot, $libelle, $choix) {
    $id = lf_tool_find_product($mot);

    if ($id === 0) {
        lf_tool_message('Attention : produit introuvable : ' . $mot);
        return;
    }

    wp_set_object_terms($id, 'variable', 'product_type');
    $product = new WC_Product_Variable($id);

    foreach ($product->get_children() as $variation_id) {
        wp_delete_post($variation_id, true);
    }

    $noms = [];
    foreach ($choix as $option) {
        $noms[] = $option['nom'];
    }

    $attribut = new WC_Product_Attribute();
    $attribut->set_name($libelle);
    $attribut->set_options($noms);
    $attribut->set_visible(true);
    $attribut->set_variation(true);

    $cle = sanitize_title($libelle);

    $product->set_attributes([$attribut]);
    $product->set_manage_stock(false);
    $product->set_default_attributes([$cle => $noms[0]]);
    $product->save();

    foreach ($choix as $option) {
        $variation = new WC_Product_Variation();
        $variation->set_parent_id($id);
        $variation->set_attributes([$cle => $option['nom']]);
        $variation->set_regular_price($option['prix']);
        $variation->set_manage_stock(true);
        $variation->set_stock_quantity($option['stock']);
        $variation->save();
    }

    WC_Product_Variable::sync($id);
    wc_delete_product_transients($id);

    lf_tool_message('OK : ' . get_the_title($id) . ' : ' . count($choix) . ' déclinaisons');
}

lf_tool_make_variable('chorizo', 'Portion', [
    ['nom' => '4 pièces', 'prix' => '8', 'stock' => 20],
    ['nom' => '8 pièces', 'prix' => '14', 'stock' => 3]
]);

lf_tool_make_variable('Cordon bleu', 'Accompagnement', [
    ['nom' => 'Pommes grenaille', 'prix' => '19', 'stock' => 15],
    ['nom' => 'Frites maison', 'prix' => '19', 'stock' => 4],
    ['nom' => 'Salade verte', 'prix' => '19', 'stock' => 0]
]);

lf_tool_make_variable('Bénédicte', 'Garniture', [
    ['nom' => 'Jambon', 'prix' => '17.50', 'stock' => 12],
    ['nom' => 'Saumon fumé', 'prix' => '19', 'stock' => 0],
    ['nom' => 'Avocat', 'prix' => '17.50', 'stock' => 8]
]);
