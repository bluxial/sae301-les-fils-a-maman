<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-11 : pages de l'équipe.
// Le type de publication « Équipe » (membre) est créé dans SCF → Types de publication.
// Les champs (poste, plat préféré, couleur) sont créés dans SCF → Groupes de champs → « Profil du membre ».

// 1. La liste de l'équipe est triée avec l'ordre choisi dans le back office.
function lf_team_order($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive('membre')) {
        $query->set('orderby', 'menu_order');
        $query->set('order', 'ASC');
    }
}
add_action('pre_get_posts', 'lf_team_order');

// Initiales affichées quand le membre n'a pas de photo (ex. : « Camille Roux » → « CR »).
function lf_member_initials($nom) {
    $nom = remove_accents($nom);       // « Élodie » devient « Elodie »
    $mots = explode(' ', $nom);        // « Camille Roux » devient ['Camille', 'Roux']
    $initiales = substr($mots[0], 0, 1);

    if (isset($mots[1])) {
        $initiales = $initiales . substr($mots[1], 0, 1);
    }

    return strtoupper($initiales);
}

// Photo du membre, ou ses initiales dans un rond.
function lf_member_avatar() {
    if (has_post_thumbnail()) {
        the_post_thumbnail('medium', ['class' => 'lf-member__photo', 'alt' => '']);
    } else {
        echo '<span class="lf-member__avatar" aria-hidden="true">' . esc_html(lf_member_initials(get_the_title())) . '</span>';
    }
}
