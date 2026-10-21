<?php
if (!defined('ABSPATH')) {
    exit;
}

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
