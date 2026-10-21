<?php
/**
 * IT-11 : les 3 membres de l’équipe.
 * Relançable.
 * Local : ddev wp eval-file wp-content/themes/les-fils-a-maman/docs/equipe-it11.php
 * Prod  : wp eval-file wp-content/themes/les-fils-a-maman/docs/equipe-it11.php
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

$membres = [
    [
        'nom' => 'Camille Roux',
        'poste' => 'Cheffe de cuisine',
        'plat' => 'Cordon bleu des Fistons',
        'couleur' => 'turquoise',
        'texte' => 'Camille compose la carte et veille à ce que chaque plat garde le goût des dimanches en famille. Elle prépare les commandes Click & Collect avec la même attention qu’en salle.'
    ],
    [
        'nom' => 'Hugo Benali',
        'poste' => 'Pâtissier',
        'plat' => 'Cookie de Maman',
        'couleur' => 'rose',
        'texte' => 'Hugo s’occupe des desserts : millefeuille façon palmito, cookies tièdes et douceurs du moment. Il goûte tout, deux fois.'
    ],
    [
        'nom' => 'Inès Morel',
        'poste' => 'Responsable du Click & Collect',
        'plat' => 'Croquettes de chorizo',
        'couleur' => 'jaune',
        'texte' => 'Inès suit les commandes en ligne, prévient les clients quand tout est prêt et les accueille au comptoir du retrait.'
    ]
];

foreach ($membres as $ordre => $membre) {
    $existant = get_posts(['post_type' => 'membre', 'title' => $membre['nom'], 'post_status' => 'any', 'numberposts' => 1]);
    $id = 0;

    if (!empty($existant)) {
        $id = $existant[0]->ID;
    }

    $id = wp_insert_post([
        'ID' => $id,
        'post_type' => 'membre',
        'post_status' => 'publish',
        'post_title' => $membre['nom'],
        'post_content' => $membre['texte'],
        'menu_order' => $ordre
    ]);

    update_field('field_lf_poste', $membre['poste'], $id);
    update_field('field_lf_plat_prefere', $membre['plat'], $id);
    update_field('field_lf_couleur', $membre['couleur'], $id);

    lf_tool_message('OK : ' . $membre['nom'] . ' (' . $membre['poste'] . ')');
}

flush_rewrite_rules();
lf_tool_message('OK : adresses /equipe/ actualisées');
