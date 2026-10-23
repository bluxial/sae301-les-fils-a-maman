<?php
/**
 * IT-11 (suite) : photos de substitution pour les 3 membres de l’équipe.
 * Les portraits viennent de pravatar.cc (photos de personnes réelles servant d’illustrations) ; l’équipe est fictive.
 * Relançable : une photo déjà en place n’est pas importée une seconde fois.
 * Local : ddev wp eval-file wp-content/themes/les-fils-a-maman/docs/photos-equipe.php
 * Prod  : wp eval-file wp-content/themes/les-fils-a-maman/docs/photos-equipe.php
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$photos = [
    'Camille Roux' => 'camille-roux.jpg',
    'Hugo Benali' => 'hugo-benali.jpg',
    'Inès Morel' => 'ines-morel.jpg'
];

foreach ($photos as $nom => $fichier) {
    $membre = get_posts(['post_type' => 'membre', 'title' => $nom, 'post_status' => 'any', 'numberposts' => 1]);

    if (empty($membre)) {
        lf_tool_message('ABSENT : ' . $nom . ' (lancer d’abord docs/equipe-it11.php)');
        continue;
    }

    $id = $membre[0]->ID;

    if (has_post_thumbnail($id)) {
        lf_tool_message('DÉJÀ FAIT : ' . $nom);
        continue;
    }

    $source = get_stylesheet_directory() . '/assets/img/equipe/' . $fichier;
    $copie = wp_tempnam($fichier);
    copy($source, $copie);

    $image = media_handle_sideload(['name' => $fichier, 'tmp_name' => $copie], $id, $nom);

    if (is_wp_error($image)) {
        lf_tool_message('ERREUR : ' . $nom . ' : ' . $image->get_error_message());
        continue;
    }

    update_post_meta($image, '_wp_attachment_image_alt', 'Portrait de ' . $nom);
    set_post_thumbnail($id, $image);
    lf_tool_message('OK : photo de ' . $nom);
}
