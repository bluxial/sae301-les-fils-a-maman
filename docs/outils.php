<?php
/**
 * Fonctions communes aux scripts de ce dossier.
 */
if (!defined('ABSPATH')) {
    exit;
}

function lf_tool_message($texte) {
    if (defined('WP_CLI') && WP_CLI) {
        WP_CLI::log($texte);
    } else {
        echo esc_html($texte) . "<br>\n";
    }
}

function lf_tool_find_product($mot) {
    $produits = get_posts([
        'post_type' => 'product',
        'post_status' => 'any',
        'numberposts' => -1
    ]);

    foreach ($produits as $produit) {
        if (mb_stripos($produit->post_title, $mot) !== false) {
            return $produit->ID;
        }
    }

    return 0;
}
