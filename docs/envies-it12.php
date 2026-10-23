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

$descriptions = [
    'Végétarien' => 'Sans viande ni poisson : des recettes de maman pour tous les appétits.',
    'Gourmand' => 'Les plats qui font plaisir : généreux, fondants, comme à la maison.',
    'Léger' => 'Pour une faim tranquille : des assiettes fraîches, sans renoncer au goût.'
];

foreach ($envies as $nom => $mots) {
    if (!term_exists($nom, 'envie')) {
        wp_insert_term($nom, 'envie');
    }

    $terme = get_term_by('name', $nom, 'envie');
    wp_update_term($terme->term_id, 'envie', ['description' => $descriptions[$nom]]);

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
