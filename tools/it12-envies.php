<?php
/**
 * IT-12 : crée les trois envies et y range les produits (au moins 2 par envie).
 * À lancer depuis le dossier du site :
 * ddev wp eval-file wp-content/themes/les-fils-a-maman/tools/it12-envies.php
 * Ou en local dans le navigateur : https://sae301.ddev.site/?lf_outil=it12-envies
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
