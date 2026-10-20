<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-7 : menu du compte client. Pas de produits téléchargeables, on retire « Téléchargements ».
function lf_account_menu($items) {
    unset($items['downloads']);
    return $items;
}
add_filter('woocommerce_account_menu_items', 'lf_account_menu');
