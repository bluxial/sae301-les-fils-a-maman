<?php
if (!defined('ABSPATH')) {
    exit;
}

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

function lf_product_category($product) {
    $categories = get_the_terms($product->get_id(), 'product_cat');

    if (is_wp_error($categories) || empty($categories)) {
        return null;
    }

    return $categories[0];
}

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

function lf_category_navigation() {
    $current = 0;

    if (is_product_category()) {
        $current = get_queried_object_id();
    }
    ?>
    <nav class="lf-chips lf-category-nav" aria-label="Catégories de la carte">
        <a class="lf-chip" href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" <?php if ($current === 0) { echo 'aria-current="page"'; } ?>>Toute la carte</a>

        <?php foreach (lf_categories() as $category) : ?>
            <a class="lf-chip" href="<?php echo esc_url(get_term_link($category)); ?>" <?php if ($current === $category->term_id) { echo 'aria-current="page"'; } ?>><?php echo esc_html($category->name); ?></a>
        <?php endforeach; ?>
    </nav>
    <?php
}

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

function lf_cart_button_class($args) {
    $args['class'] .= ' lf-btn';
    return $args;
}
add_filter('woocommerce_loop_add_to_cart_args', 'lf_cart_button_class');

function lf_cart_button_text($text, $product) {
    if ($product->is_type('simple') && $product->is_purchasable() && $product->is_in_stock()) {
        return 'Ajouter +';
    }

    return $text;
}
add_filter('woocommerce_product_add_to_cart_text', 'lf_cart_button_text', 10, 2);
