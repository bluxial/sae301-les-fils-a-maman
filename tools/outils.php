<?php
// Fonctions communes aux scripts du dossier tools.
// On les lance avec WP-CLI (ddev wp eval-file ...) ou, en local, avec ?lf_outil=nom-du-script.
if (!defined('ABSPATH')) {
    exit;
}

// Affiche un message dans le terminal (WP-CLI) ou dans la page (navigateur).
function lf_tool_message($texte) {
    if (defined('WP_CLI') && WP_CLI) {
        WP_CLI::log($texte);
    } else {
        echo esc_html($texte) . "<br>\n";
    }
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
