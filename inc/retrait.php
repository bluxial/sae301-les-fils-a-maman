<?php
if (!defined('ABSPATH')) {
    exit;
}

function lf_pickup_default_text() {
    return "Votre commande vous attend au comptoir des Fils à Maman, 7 bis rue Geoffroy-Marie, 75009 Paris.\nDonnez votre nom et votre numéro de commande. Le paiement au retrait se fait par carte ou en espèces.";
}

function lf_pickup_text() {
    $texte = get_option('lf_instructions_retrait', '');

    if (trim($texte) === '') {
        $texte = lf_pickup_default_text();
    }

    return $texte;
}

function lf_pickup_setting($settings) {
    $settings[] = [
        'title' => 'Instructions pour le retrait',
        'type' => 'title',
        'desc' => 'Texte affiché aux clients pendant la validation de la commande.',
        'id' => 'lf_retrait'
    ];

    $settings[] = [
        'title' => 'Texte',
        'id' => 'lf_instructions_retrait',
        'type' => 'textarea',
        'default' => lf_pickup_default_text(),
        'css' => 'width: 100%; max-width: 600px; min-height: 120px;'
    ];

    $settings[] = [
        'type' => 'sectionend',
        'id' => 'lf_retrait'
    ];

    return $settings;
}
add_filter('woocommerce_shipping_settings', 'lf_pickup_setting');

function lf_pickup_instructions() {
    echo '<div class="lf-pickup">';
    echo '<h3>Instructions pour le retrait</h3>';
    echo wp_kses_post(wpautop(lf_pickup_text()));
    echo '</div>';
}
add_action('woocommerce_review_order_before_payment', 'lf_pickup_instructions');
