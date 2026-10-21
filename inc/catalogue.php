<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-2 : catégories de la carte et cartes produits.

// Liste des catégories qui contiennent au moins un produit, dans l'ordre de création.
function lf_categories() {
    $categories = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'orderby' => 'term_id',
        'order' => 'ASC'
    ]);

    if (is_wp_error($categories)) {
        return [];
    }

    return $categories;
}

// Clé de couleur d'une catégorie : « partager » (turquoise), « plats » (jaune) ou « desserts » (rose).
// strpos(...) !== false veut dire « le texte contient ce mot ».
function lf_category_key($category) {
    if (!$category) {
        return 'partager';
    }

    if ($category->slug === 'plats') {
        return 'plats';
    }

    if (strpos($category->slug, 'dessert') !== false) {
        return 'desserts';
    }

    return 'partager';
}

// Première catégorie d'un produit (ou null s'il n'en a pas).
function lf_product_category($product) {
    $categories = get_the_terms($product->get_id(), 'product_cat');

    if (is_wp_error($categories) || empty($categories)) {
        return null;
    }

    return $categories[0];
}

// Petite phrase manuscrite affichée sur les cartes de chaque catégorie.
function lf_category_script($key) {
    if ($key === 'partager') {
        return 'pour picorer';
    }

    if ($key === 'plats') {
        return 'comme chez maman';
    }

    if ($key === 'desserts') {
        return 'la petite douceur';
    }

    return 'à ta façon';
}

// Classe CSS qui recadre la photo de certains produits (mot du slug => classe).
function lf_crop_class($product) {
    $slug = $product->get_slug();
    $crops = [
        'beignets' => 'beignets',
        'mimosa' => 'oeufs',
        'cordon' => 'cordon',
        'tartare' => 'tartare',
        'millefeuille' => 'millefeuille',
        'peche' => 'peche'
    ];

    foreach ($crops as $word => $crop) {
        if (strpos($slug, $word) !== false) {
            return 'lf-crop-' . $crop;
        }
    }

    return '';
}

// Pastilles de navigation entre les catégories (la catégorie affichée a aria-current="page").
function lf_category_navigation() {
    $current = 0;

    if (is_product_category()) {
        $current = get_queried_object_id();
    }
    ?>
    <nav class="lf-chips lf-category-nav" aria-label="Catégories de la carte">
        <a class="lf-chip" href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" <?php if (is_shop()) { echo 'aria-current="page"'; } ?>>Toute la carte</a>

        <?php foreach (lf_categories() as $category) : ?>
            <a class="lf-chip" href="<?php echo esc_url(get_term_link($category)); ?>" <?php if ($current === $category->term_id) { echo 'aria-current="page"'; } ?>><?php echo esc_html($category->name); ?></a>
        <?php endforeach; ?>
    </nav>
    <?php
}

// Description de la fiche produit (la courte si la longue est vide).
function lf_product_description() {
    global $product;
    $description = $product->get_description();

    if ($description === '') {
        $description = $product->get_short_description();
    }

    if ($description !== '') {
        echo '<div class="lf-product-description">' . wp_kses_post(wpautop($description)) . '</div>';
    }
}

// Boutons « Ajouter » des cartes : on ajoute notre classe lf-btn.
function lf_cart_button_class($args) {
    $args['class'] .= ' lf-btn';
    return $args;
}
add_filter('woocommerce_loop_add_to_cart_args', 'lf_cart_button_class');

// Texte du bouton pour un produit simple disponible.
function lf_cart_button_text($text, $product) {
    if ($product->is_type('simple') && $product->is_purchasable() && $product->is_in_stock()) {
        return 'Ajouter +';
    }

    return $text;
}
add_filter('woocommerce_product_add_to_cart_text', 'lf_cart_button_text', 10, 2);
