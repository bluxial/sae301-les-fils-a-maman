<?php
/**
 * IT-12 : envies (Gourmand, Léger, Végétarien) et produits associés.
 * Relançable.
 * Local : ddev wp eval-file wp-content/themes/les-fils-a-maman/docs/envies-it12.php
 * Prod  : wp eval-file wp-content/themes/les-fils-a-maman/docs/envies-it12.php
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

$envies = [
    'Végétarien' => ['courgettes', 'Millefeuille', 'Cookie', 'pêche'],
    'Gourmand' => ['Cordon bleu', 'chorizo', 'Cookie'],
    'Léger' => ['Tartare', 'mimosa', 'pêche']
];

foreach ($envies as $nom => $mots) {
    if (!term_exists($nom, 'envie')) {
        wp_insert_term($nom, 'envie');
    }

    foreach ($mots as $mot) {
        $id = lf_tool_find_product($mot);

        if ($id === 0) {
            lf_tool_message('Attention : produit introuvable : ' . $mot);
            continue;
        }

        wp_add_object_terms($id, $nom, 'envie');
    }

    lf_tool_message('OK : envie « ' . $nom . ' » : ' . count($mots) . ' produits');
}

flush_rewrite_rules();
