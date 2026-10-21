<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-11 : pages de l'équipe (un type de contenu « Membre de l'équipe »).
// Les champs (poste, plat préféré, couleur) sont créés dans SCF → Groupes de champs → « Profil du membre ».

// 1. Le type de contenu, avec son menu « Équipe » dans le back office.
function lf_register_team() {
    register_post_type('membre', [
        'labels' => [
            'name' => 'Équipe',
            'singular_name' => 'Membre de l’équipe',
            'add_new' => 'Ajouter un membre',
            'add_new_item' => 'Ajouter un membre de l’équipe',
            'edit_item' => 'Modifier le membre',
            'all_items' => 'Toute l’équipe',
            'menu_name' => 'Équipe'
        ],
        'public' => true,
        'has_archive' => 'equipe',
        'rewrite' => ['slug' => 'equipe'],
        'menu_icon' => 'dashicons-groups',
        'menu_position' => 25,
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes'],
        'show_in_rest' => true
    ]);
}
add_action('init', 'lf_register_team');

// 2. La liste de l'équipe est triée avec l'ordre choisi dans le back office.
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
