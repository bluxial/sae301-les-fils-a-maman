<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-13 : ventes croisées (« Ça va bien avec… ») sur la fiche produit et dans le panier.

// Affiche jusqu'à 3 produits avec les cartes de la boutique.
function lf_show_suggestions($ids, $titre) {
    if (empty($ids)) {
        return;
    }

    global $post;
    $ids = array_slice($ids, 0, 3);

    echo '<section class="lf-catalogue-page lf-suggestions">';
    echo '<h2 class="lf-title lf-title--h3">' . esc_html($titre) . '</h2>';

    woocommerce_product_loop_start();

    foreach ($ids as $id) {
        $post = get_post($id);
        setup_postdata($post);
        wc_get_template_part('content', 'product');
    }

    woocommerce_product_loop_end();
    wp_reset_postdata();

    echo '</section>';
}

// 1. Fiche produit : les produits complémentaires choisis dans le back office.
function lf_product_suggestions() {
    global $product;
    lf_show_suggestions($product->get_cross_sell_ids(), 'Ça va bien avec…');
}
add_action('woocommerce_after_single_product_summary', 'lf_product_suggestions', 15);

// 2. Panier : les suggestions sous les articles, en pleine largeur.
function lf_cart_suggestions() {
    lf_show_suggestions(WC()->cart->get_cross_sells(), 'Pour compléter ta commande');
}
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_after_cart', 'lf_cart_suggestions');
