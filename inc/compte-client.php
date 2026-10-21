<?php
if (!defined('ABSPATH')) {
    exit;
}

function lf_account_menu($items) {
    unset($items['downloads']);
    return $items;
}
add_filter('woocommerce_account_menu_items', 'lf_account_menu');
