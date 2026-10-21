<?php
/**
 * IT-14 : avis ouverts sur les produits.
 * Relançable.
 * Local : ddev wp eval-file wp-content/themes/les-fils-a-maman/docs/avis-it14.php
 * Prod  : wp eval-file wp-content/themes/les-fils-a-maman/docs/avis-it14.php
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

update_option('woocommerce_enable_reviews', 'yes');
update_option('woocommerce_review_rating_verification_label', 'yes');
update_option('woocommerce_review_rating_verification_required', 'yes');
update_option('woocommerce_enable_review_rating', 'yes');
update_option('woocommerce_review_rating_required', 'yes');

$produits = get_posts(['post_type' => 'product', 'post_status' => 'any', 'numberposts' => -1]);

foreach ($produits as $produit) {
    wp_update_post(['ID' => $produit->ID, 'comment_status' => 'open']);
}

lf_tool_message('OK : avis activés (achat vérifié obligatoire, note obligatoire) sur ' . count($produits) . ' produits');
