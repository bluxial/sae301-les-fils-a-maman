<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-15 : frais de préparation ajoutés quand le panier est inférieur à un seuil.
// Montant et seuil réglables dans WooCommerce → Réglages → Expédition → Options d'expédition.

// Montant et seuil enregistrés dans le back office (valeur par défaut si rien n'est enregistré).
function lf_fee_amount() {
    return (float) get_option('lf_frais_montant', 1.5);
}

function lf_fee_threshold() {
    return (float) get_option('lf_frais_seuil', 15);
}

// 1. Les deux champs dans le back office.
function lf_fee_settings($settings) {
    $settings[] = [
        'title' => 'Frais de préparation',
        'type' => 'title',
        'desc' => 'Frais ajoutés automatiquement quand le sous-total du panier est inférieur au seuil.',
        'id' => 'lf_frais'
    ];

    $settings[] = [
        'title' => 'Montant des frais (€)',
        'id' => 'lf_frais_montant',
        'type' => 'number',
        'default' => '1.5',
        'custom_attributes' => ['min' => '0', 'step' => '0.1']
    ];

    $settings[] = [
        'title' => 'Seuil (€)',
        'id' => 'lf_frais_seuil',
        'type' => 'number',
        'default' => '15',
        'custom_attributes' => ['min' => '0', 'step' => '1']
    ];

    $settings[] = [
        'type' => 'sectionend',
        'id' => 'lf_frais'
    ];

    return $settings;
}
add_filter('woocommerce_shipping_settings', 'lf_fee_settings');

// 2. La règle : calculée à chaque mise à jour du panier.
function lf_add_preparation_fee($cart) {
    // Dans le back office (sauf pendant une mise à jour du panier en AJAX), on ne fait rien.
    if (is_admin() && !wp_doing_ajax()) {
        return;
    }

    if ($cart->get_subtotal() > 0 && $cart->get_subtotal() < lf_fee_threshold()) {
        $cart->add_fee('Frais de préparation', lf_fee_amount());
    }
}
add_action('woocommerce_cart_calculate_fees', 'lf_add_preparation_fee');

// 3. Message dans le récapitulatif : combien il manque pour ne plus payer les frais.
function lf_fee_hint() {
    $reste = lf_fee_threshold() - WC()->cart->get_subtotal();

    if ($reste > 0) {
        echo '<p class="lf-fee-hint">Plus que ' . wp_kses_post(wc_price($reste)) . ' pour ne pas payer les frais de préparation (' . wp_kses_post(wc_price(lf_fee_amount())) . ').</p>';
    }
}
add_action('woocommerce_before_cart_totals', 'lf_fee_hint');
