<?php
if (!defined('ABSPATH')) {
    exit;
}

function lf_team_order($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive('membre')) {
        $query->set('orderby', 'menu_order');
        $query->set('order', 'ASC');
    }
}
add_action('pre_get_posts', 'lf_team_order');

function lf_member_initials($nom) {
    $nom = remove_accents($nom);
    $mots = explode(' ', $nom);
    $initiales = substr($mots[0], 0, 1);

    if (isset($mots[1])) {
        $initiales = $initiales . substr($mots[1], 0, 1);
    }

    return strtoupper($initiales);
}

function lf_member_avatar() {
    if (has_post_thumbnail()) {
        the_post_thumbnail('medium', ['class' => 'lf-member__photo', 'alt' => '']);
    } else {
        echo '<span class="lf-member__avatar" aria-hidden="true">' . esc_html(lf_member_initials(get_the_title())) . '</span>';
    }
}
