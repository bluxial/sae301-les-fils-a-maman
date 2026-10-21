<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-19 : prix de la livraison calculé selon le poids total du panier (3 tranches).
// Tranches réglables dans WooCommerce → Réglages → Expédition → Options d'expédition.

// Prix de la livraison pour un poids donné (en kg).
function lf_weight_price($poids) {
    if ($poids <= (float) get_option('lf_poids_seuil_1', 1)) {
        return (float) get_option('lf_poids_prix_1', 3.9);
    }

    if ($poids <= (float) get_option('lf_poids_seuil_2', 3)) {
        return (float) get_option('lf_poids_prix_2', 5.9);
    }

    return (float) get_option('lf_poids_prix_3', 8.9);
}

// 1. Les tranches dans le back office.
function lf_weight_settings($settings) {
    $settings[] = [
        'title' => 'Livraison selon le poids',
        'type' => 'title',
        'desc' => 'Prix des modes de livraison « forfait » (ex. : Livraison à vélo) selon le poids total du panier, en kg.',
        'id' => 'lf_poids'
    ];

    // Un champ par ligne : identifiant du réglage, libellé affiché et valeur par défaut.
    $champs = [
        ['id' => 'lf_poids_seuil_1', 'libelle' => 'Tranche 1 : jusqu’à (kg)', 'defaut' => '1'],
        ['id' => 'lf_poids_prix_1', 'libelle' => 'Tranche 1 : prix (€)', 'defaut' => '3.9'],
        ['id' => 'lf_poids_seuil_2', 'libelle' => 'Tranche 2 : jusqu’à (kg)', 'defaut' => '3'],
        ['id' => 'lf_poids_prix_2', 'libelle' => 'Tranche 2 : prix (€)', 'defaut' => '5.9'],
        ['id' => 'lf_poids_prix_3', 'libelle' => 'Tranche 3 : au-delà, prix (€)', 'defaut' => '8.9']
    ];

    foreach ($champs as $champ) {
        $settings[] = [
            'title' => $champ['libelle'],
            'id' => $champ['id'],
            'type' => 'number',
            'default' => $champ['defaut'],
            'custom_attributes' => ['min' => '0', 'step' => '0.1']
        ];
    }

    $settings[] = [
        'type' => 'sectionend',
        'id' => 'lf_poids'
    ];

    return $settings;
}
add_filter('woocommerce_shipping_settings', 'lf_weight_settings');

// 2. Le prix des livraisons « forfait » est remplacé par celui de la tranche de poids.
function lf_weight_rates($rates, $package) {
    $poids = WC()->cart->get_cart_contents_weight();

    foreach ($rates as $rate) {
        if ($rate->get_method_id() === 'flat_rate') {
            $rate->set_cost(lf_weight_price($poids));
            $rate->set_label($rate->get_label() . ' · ' . wc_format_weight($poids));
        }
    }

    return $rates;
}
add_filter('woocommerce_package_rates', 'lf_weight_rates', 10, 2);
