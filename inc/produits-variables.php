<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-3 : affichage des produits variables (options, prix, stock).

// Sur les cartes, on affiche « À partir de 8 € » au lieu de « 8 € – 14 € ».
function lf_variable_price($price, $product) {
    $minimum = $product->get_variation_price('min', true);
    return 'À partir de ' . wc_price($minimum);
}
add_filter('woocommerce_variable_price_html', 'lf_variable_price', 10, 2);

// Texte du bouton des cartes pour un produit variable.
function lf_variable_button_text($text, $product) {
    if ($product->is_type('variable')) {
        return 'Choisir +';
    }

    return $text;
}
add_filter('woocommerce_product_add_to_cart_text', 'lf_variable_button_text', 20, 2);

// Trois niveaux de stock : « En stock », « Plus que 3 en stock » (classe low-stock) et « Rupture de stock ».
function lf_stock_class($class, $product) {
    if (!$product->managing_stock() || !$product->is_in_stock()) {
        return $class;
    }

    $stock = $product->get_stock_quantity();

    if ($stock <= wc_get_low_stock_amount($product)) {
        return $class . ' low-stock';
    }

    return $class;
}
add_filter('woocommerce_get_availability_class', 'lf_stock_class', 10, 2);
