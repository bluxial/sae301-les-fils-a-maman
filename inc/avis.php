<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-14 : avis clients sous la fiche produit.
// Les onglets WooCommerce sont retirés dans setup.php : on affiche donc les avis nous-mêmes.
// WooCommerce fournit la liste, la note en étoiles et le formulaire (single-product-reviews.php).
function lf_product_reviews() {
    if (comments_open()) {
        echo '<section class="lf-reviews">';
        comments_template();
        echo '</section>';
    }
}
add_action('woocommerce_after_single_product_summary', 'lf_product_reviews', 12);
