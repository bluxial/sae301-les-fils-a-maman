<?php
if (!defined('ABSPATH')) {
    exit;
}

function lf_product_reviews() {
    if (comments_open()) {
        echo '<section class="lf-reviews">';
        comments_template();
        echo '</section>';
    }
}
add_action('woocommerce_after_single_product_summary', 'lf_product_reviews', 12);
