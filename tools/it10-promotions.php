<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

update_option('woocommerce_enable_coupons', 'yes');
update_option('woocommerce_calc_discounts_sequentially', 'no');

function lf_tool_coupon($code, $type, $montant, $mots, $expiration, $description) {
    $produits = [];

    foreach ($mots as $mot) {
        $produits[] = lf_tool_find_product($mot);
    }

    $coupon = new WC_Coupon(wc_get_coupon_id_by_code($code));
    $coupon->set_code($code);
    $coupon->set_description($description);
    $coupon->set_discount_type($type);
    $coupon->set_amount($montant);
    $coupon->set_product_ids($produits);
    $coupon->set_date_expires($expiration);
    $coupon->save();

    lf_tool_message('OK : code ' . $code . ' enregistré');
}

lf_tool_coupon('FISTONS10', 'percent', '10', ['Cordon bleu', 'Tartare'], null, '-10 % sur le cordon bleu et le tartare.');

lf_tool_coupon('MAMAN2', 'fixed_product', '2', ['Cookie', 'Millefeuille'], null, '-2 € sur le cookie et le millefeuille.');

lf_tool_coupon('ETE2025', 'percent', '20', ['Cordon bleu', 'Tartare'], '2025-09-01', 'Ancienne promotion de l’été 2025 (expirée).');
