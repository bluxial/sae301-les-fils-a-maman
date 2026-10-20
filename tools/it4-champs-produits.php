<?php
/**
 * IT-4 : remplit les champs Composition, Allergènes et Énergie des produits.
 * À lancer depuis le dossier du site :
 * ddev wp eval-file wp-content/themes/les-fils-a-maman/tools/it4-champs-produits.php
 * Compositions reprises de la carte du restaurant. Allergènes et calories : valeurs indicatives.
 */
if (!defined('WP_CLI')) {
    exit;
}

require_once __DIR__ . '/outils.php';

$infos = [
    'chorizo' => ['Chorizo, béchamel, chapelure, salade', ['Gluten', 'Lait', 'Œufs'], 420],
    'courgettes' => ['Courgettes, Parmesan, pâte à beignet, fromage frais aux herbes', ['Gluten', 'Lait', 'Œufs'], 380],
    'mimosa' => ['Œufs, mayonnaise au paprika, bacon', ['Œufs', 'Moutarde'], 310],
    'Cordon bleu' => ['Filet de poulet français, Saint-Nectaire, poitrine fumée, crème de Saint-Nectaire, pommes grenaille, salade', ['Gluten', 'Lait', 'Œufs'], 890],
    'Tartare' => ['Saumon frais, saumon gravlax, avocat, oignons rouges, citron vert, herbes fraîches, frites, salade', ['Poisson'], 720],
    'Bénédicte' => ['Muffin anglais, œufs pochés, sauce hollandaise, salade', ['Gluten', 'Œufs', 'Lait'], 640],
    'Millefeuille' => ['Biscuit feuilleté, crème Mascarpone, fraises', ['Gluten', 'Lait', 'Œufs'], 450],
    'Cookie' => ['Cookie au chocolat, crème fouettée', ['Gluten', 'Lait', 'Œufs', 'Soja'], 520],
    'pêche' => ['Purée de pêche, sirop de pêche, jus de citron vert, Perrier, menthe fraîche', [], 140]
];

foreach ($infos as $mot => $valeurs) {
    $id = lf_tool_find_product($mot);

    if ($id === 0) {
        WP_CLI::warning('Produit introuvable : ' . $mot);
        continue;
    }

    update_field('field_lf_composition', $valeurs[0], $id);
    update_field('field_lf_allergenes', $valeurs[1], $id);
    update_field('field_lf_calories', $valeurs[2], $id);

    WP_CLI::success(get_the_title($id) . ' : champs remplis');
}
