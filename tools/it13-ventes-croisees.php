<?php
/**
 * IT-13 : associe des produits complémentaires (ventes croisées).
 * À lancer depuis le dossier du site :
 * ddev wp eval-file wp-content/themes/les-fils-a-maman/tools/it13-ventes-croisees.php
 * Ou en local dans le navigateur : https://sae301.ddev.site/?lf_outil=it13-ventes-croisees
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

$associations = [
    'Cordon bleu' => ['pêche', 'Cookie', 'courgettes'],
    'chorizo' => ['courgettes', 'mimosa', 'pêche'],
    'Tartare' => ['pêche', 'Millefeuille'],
    'Bénédicte' => ['Cookie', 'pêche'],
    'courgettes' => ['chorizo', 'pêche'],
    'Cookie' => ['pêche', 'Millefeuille']
];

foreach ($associations as $mot => $complements) {
    $product = wc_get_product(lf_tool_find_product($mot));

    if (!$product) {
        lf_tool_message('Attention : produit introuvable : ' . $mot);
        continue;
    }

    $ids = [];
    foreach ($complements as $complement) {
        $ids[] = lf_tool_find_product($complement);
    }

    $product->set_cross_sell_ids($ids);
    $product->save();

    lf_tool_message('OK : ' . $product->get_name() . ' → ' . count($ids) . ' suggestions');
}
