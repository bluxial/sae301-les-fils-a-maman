<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-4 : champs personnalisés des produits (Secure Custom Fields).

// Les champs (composition, allergènes, calories) sont créés dans SCF → Groupes de champs → « Informations du produit ».

// Affichage dans la fiche produit, entre la description (20) et le prix (25).
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
