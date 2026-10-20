<?php
/**
 * IT-10 : codes promotionnels (montant fixe et pourcentage) sur deux produits chacun.
 * À lancer depuis le dossier du site :
 * ddev wp eval-file wp-content/themes/les-fils-a-maman/tools/it10-promotions.php
 * Ou en local dans le navigateur : https://sae301.ddev.site/?lf_outil=it10-promotions
 * Le script peut être relancé : il met à jour les codes existants.
 */
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

// Pourcentage : -10 % sur deux plats.
lf_tool_coupon('FISTONS10', 'percent', '10', ['Cordon bleu', 'Tartare'], null, '-10 % sur le cordon bleu et le tartare.');

// Montant fixe : -2 € par dessert sur deux desserts.
lf_tool_coupon('MAMAN2', 'fixed_product', '2', ['Cookie', 'Millefeuille'], null, '-2 € sur le cookie et le millefeuille.');

// Code expiré, pour tester le message d'erreur.
lf_tool_coupon('ETE2025', 'percent', '20', ['Cordon bleu', 'Tartare'], '2025-09-01', 'Ancienne promotion de l’été 2025 (expirée).');
