<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-4 : champs personnalisés des produits (Secure Custom Fields).

// 1. Création des champs dans la fiche produit du back office.
function lf_product_fields() {
    acf_add_local_field_group([
        'key' => 'group_lf_infos_produit',
        'title' => 'Informations du produit',
        'fields' => [
            [
                'key' => 'field_lf_composition',
                'label' => 'Composition',
                'name' => 'composition',
                'type' => 'textarea',
                'rows' => 3,
                'instructions' => 'Ingrédients principaux, séparés par des virgules.'
            ],
            [
                'key' => 'field_lf_allergenes',
                'label' => 'Allergènes',
                'name' => 'allergenes',
                'type' => 'checkbox',
                'layout' => 'horizontal',
                'choices' => [
                    'Gluten' => 'Gluten',
                    'Œufs' => 'Œufs',
                    'Lait' => 'Lait',
                    'Poisson' => 'Poisson',
                    'Fruits à coque' => 'Fruits à coque',
                    'Moutarde' => 'Moutarde',
                    'Soja' => 'Soja',
                    'Sulfites' => 'Sulfites'
                ]
            ],
            [
                'key' => 'field_lf_calories',
                'label' => 'Valeur énergétique (kcal par portion)',
                'name' => 'calories',
                'type' => 'number',
                'min' => 0
            ]
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product'
                ]
            ]
        ],
        'position' => 'normal'
    ]);
}
add_action('acf/init', 'lf_product_fields');

// 2. Affichage dans la fiche produit, entre la description (20) et le prix (25).
function lf_product_facts() {
    $composition = get_field('composition');
    $allergenes = get_field('allergenes');
    $calories = get_field('calories');

    if (!$composition && !$allergenes && !$calories) {
        return;
    }

    echo '<dl class="lf-facts lf-product-facts">';

    if ($composition) {
        echo '<div><dt>Composition</dt><dd>' . esc_html($composition) . '</dd></div>';
    }

    if ($allergenes) {
        echo '<div><dt>Allergènes</dt><dd>' . esc_html(implode(', ', $allergenes)) . '</dd></div>';
    }

    if ($calories) {
        echo '<div><dt>Énergie</dt><dd>' . esc_html($calories) . ' kcal par portion</dd></div>';
    }

    echo '</dl>';
}
add_action('woocommerce_single_product_summary', 'lf_product_facts', 22);
