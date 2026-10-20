<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-12 : taxonomie « Envies » (indépendante des catégories) pour classer les produits.

// 1. La taxonomie, administrable dans Produits → Envies.
function lf_register_envies() {
    register_taxonomy('envie', 'product', [
        'labels' => [
            'name' => 'Envies',
            'singular_name' => 'Envie',
            'add_new_item' => 'Ajouter une envie',
            'edit_item' => 'Modifier l’envie',
            'all_items' => 'Toutes les envies',
            'menu_name' => 'Envies'
        ],
        'public' => true,
        'hierarchical' => false,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'envie']
    ]);
}
add_action('init', 'lf_register_envies');

// 2. Les pastilles « Envies » affichées dans la boutique.
function lf_envie_navigation() {
    $envies = get_terms(['taxonomy' => 'envie', 'hide_empty' => true]);

    if (is_wp_error($envies) || empty($envies)) {
        return;
    }

    $current = 0;

    if (is_tax('envie')) {
        $current = get_queried_object_id();
    }
    ?>
    <nav class="lf-chips lf-envie-nav" aria-label="Envies">
        <span class="lf-envie-nav__label">Envie de :</span>
        <?php foreach ($envies as $envie) : ?>
            <a class="lf-chip" href="<?php echo esc_url(get_term_link($envie)); ?>" <?php if ($current === $envie->term_id) { echo 'aria-current="page"'; } ?>><?php echo esc_html($envie->name); ?></a>
        <?php endforeach; ?>
    </nav>
    <?php
}
