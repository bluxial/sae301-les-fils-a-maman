<?php
// Fonctions communes aux scripts du dossier tools (lancés avec WP-CLI uniquement).
if (!defined('WP_CLI')) {
    exit;
}

// Renvoie l'identifiant du produit dont le nom contient $mot (0 si aucun).
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
