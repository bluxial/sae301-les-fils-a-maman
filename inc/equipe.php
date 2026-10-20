<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-11 : pages de l'équipe (un type de contenu « Membre de l'équipe » + champs SCF).

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

// 2. Les champs du membre (poste, plat préféré, couleur de la carte).
function lf_team_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_lf_membre',
        'title' => 'Profil du membre',
        'fields' => [
            [
                'key' => 'field_lf_poste',
                'label' => 'Poste',
                'name' => 'poste',
                'type' => 'text',
                'required' => 1
            ],
            [
                'key' => 'field_lf_plat_prefere',
                'label' => 'Plat préféré de la carte',
                'name' => 'plat_prefere',
                'type' => 'text'
            ],
            [
                'key' => 'field_lf_couleur',
                'label' => 'Couleur de la carte',
                'name' => 'couleur',
                'type' => 'select',
                'choices' => [
                    'jaune' => 'Jaune',
                    'turquoise' => 'Turquoise',
                    'rose' => 'Rose'
                ],
                'default_value' => 'jaune'
            ]
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'membre'
                ]
            ]
        ],
        'position' => 'acf_after_title'
    ]);
}
add_action('acf/init', 'lf_team_fields');

// 3. La liste de l'équipe est triée avec l'ordre choisi dans le back office.
function lf_team_order($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive('membre')) {
        $query->set('orderby', 'menu_order');
        $query->set('order', 'ASC');
    }
}
add_action('pre_get_posts', 'lf_team_order');

// Initiales affichées quand le membre n'a pas de photo (ex. : « Léa Martin » → « LM »).
function lf_member_initials($nom) {
    $initiales = '';

    foreach (explode(' ', $nom) as $mot) {
        if ($mot !== '') {
            $initiales .= mb_strtoupper(mb_substr($mot, 0, 1));
        }
    }

    return mb_substr($initiales, 0, 2);
}

// Photo du membre, ou ses initiales dans un rond.
function lf_member_avatar() {
    if (has_post_thumbnail()) {
        the_post_thumbnail('medium', ['class' => 'lf-member__photo', 'alt' => '']);
    } else {
        echo '<span class="lf-member__avatar" aria-hidden="true">' . esc_html(lf_member_initials(get_the_title())) . '</span>';
    }
}

function lf_member_field($nom) {
    if (!function_exists('get_field')) {
        return '';
    }

    return (string) get_field($nom);
}
