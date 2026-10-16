<?php
/** Fonctions de présentation : les contenus et les prix viennent de WooCommerce. */
defined( 'ABSPATH' ) || exit;

function lf_categories() {
    $categories = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'orderby' => 'term_id', 'order' => 'ASC' ) );
    return is_wp_error( $categories ) ? array() : $categories;
}

function lf_category_key( $term ) {
    if ( ! $term ) { return 'partager'; }
    if ( $term->slug === 'plats' ) { return 'plats'; }
    if ( strpos( $term->slug, 'dessert' ) !== false ) { return 'desserts'; }
    return 'partager';
}

function lf_product_category( $product ) {
    $terms = get_the_terms( $product->get_id(), 'product_cat' );
    return ( ! is_wp_error( $terms ) && ! empty( $terms ) ) ? reset( $terms ) : null;
}

function lf_category_script( $key ) {
    return array( 'partager' => 'pour picorer', 'plats' => 'comme chez maman', 'desserts' => 'la petite douceur' )[ $key ] ?? 'à ta façon';
}

function lf_crop_class( $product ) {
    $slug = $product->get_slug();
    foreach ( array( 'beignets' => 'beignets', 'mimosa' => 'oeufs', 'cordon' => 'cordon', 'tartare' => 'tartare', 'millefeuille' => 'millefeuille', 'peche' => 'peche' ) as $match => $crop ) {
        if ( strpos( $slug, $match ) !== false ) { return 'lf-crop-' . $crop; }
    }
    return '';
}

function lf_category_navigation() {
    $current = is_product_category() ? get_queried_object_id() : 0;
    ?>
    <nav class="lf-chips lf-category-nav" aria-label="Catégories de la carte">
        <a class="lf-chip" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" <?php if ( ! $current ) { echo 'aria-current="page"'; } ?>>Toute la carte</a>
        <?php foreach ( lf_categories() as $term ) : ?>
            <a class="lf-chip" href="<?php echo esc_url( get_term_link( $term ) ); ?>" <?php if ( $current === $term->term_id ) { echo 'aria-current="page"'; } ?>><?php echo esc_html( $term->name ); ?></a>
        <?php endforeach; ?>
    </nav>
    <?php
}

function lf_product_description() {
    global $product;
    $description = $product->get_description() ?: $product->get_short_description();
    if ( $description ) { echo '<div class="lf-product-description">' . wp_kses_post( wpautop( $description ) ) . '</div>'; }
}

add_filter( 'woocommerce_loop_add_to_cart_args', function ( $args, $product ) {
    $args['class'] .= ' lf-btn';
    return $args;
}, 10, 2 );

add_filter( 'woocommerce_product_add_to_cart_text', function ( $text, $product ) {
    return $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() ? 'Ajouter +' : $text;
}, 10, 2 );
