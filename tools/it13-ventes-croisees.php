<?php
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
