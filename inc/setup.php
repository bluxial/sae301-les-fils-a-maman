<?php
/** Configuration, ressources et intégration avec Storefront. */
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce', array( 'product_grid' => array( 'default_columns' => 3 ) ) );
    register_nav_menus( array( 'lf-primary' => 'Navigation principale Les Fils à Maman' ) );
    remove_action( 'woocommerce_before_main_content', 'storefront_before_content', 10 );
    remove_action( 'woocommerce_after_main_content', 'storefront_after_content', 10 );
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
    add_action( 'woocommerce_single_product_summary', 'lf_product_description', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
    remove_action( 'woocommerce_after_single_product_summary', 'storefront_single_product_pagination', 30 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
    remove_action( 'woocommerce_before_shop_loop', 'storefront_sorting_wrapper', 9 );
    remove_action( 'woocommerce_before_shop_loop', 'storefront_sorting_wrapper_close', 31 );
    remove_action( 'woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
    add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
    remove_action( 'woocommerce_after_shop_loop', 'storefront_sorting_wrapper', 9 );
    remove_action( 'woocommerce_after_shop_loop', 'storefront_sorting_wrapper_close', 31 );
    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
    add_filter( 'woocommerce_product_tabs', function ( $tabs ) { unset( $tabs['description'] ); return $tabs; } );
}, 30 );

add_filter( 'body_class', function ( $classes ) { $classes[] = 'lf-system'; return $classes; } );
add_filter( 'loop_shop_columns', function () { return 3; } );
add_filter( 'loop_shop_per_page', function () { return 12; } );

function lf_asset( $file ) {
    return get_stylesheet_directory_uri() . '/assets/' . ltrim( $file, '/' );
}

add_action( 'wp_enqueue_scripts', function () {
    $root = get_stylesheet_directory();
    wp_dequeue_style( 'storefront-fonts' );
    wp_dequeue_style( 'source-sans-pro' );
    wp_enqueue_style( 'lf-system', get_stylesheet_directory_uri() . '/system.css', array(), filemtime( $root . '/system.css' ) );
    wp_enqueue_style( 'lf-wordpress', lf_asset( 'css/wordpress.css' ), array( 'lf-system' ), filemtime( $root . '/assets/css/wordpress.css' ) );
    wp_enqueue_script( 'lf-interactions', lf_asset( 'js/theme.js' ), array( 'jquery' ), filemtime( $root . '/assets/js/theme.js' ), true );
    wp_enqueue_script( 'wc-cart-fragments' );
}, 100 );

// Le Customizer ajoute son CSS à la priorité 130 : le placer dans sa couche après cet ajout.
add_action( 'wp_enqueue_scripts', function () {
    foreach ( wp_styles()->registered as $handle => $style ) {
        if ( strpos( $handle, 'storefront-' ) !== 0 ) { continue; }
        $inline = wp_styles()->get_data( $handle, 'after' );
        if ( $inline ) {
            wp_style_add_data( $handle, 'after', array( '@layer theme {' . implode( "\n", $inline ) . '}' ) );
        }
    }
}, 200 );

add_action( 'wp_head', function () {
    echo '<style id="lf-layer-order">@layer theme, lf-reset, lf-fonts, lf-tokens, lf-base, lf-components, lf-utilities, lf-overrides;</style>' . "\n";
}, 1 );

// Conserver les feuilles des logiciels tiers dans une couche de priorité connue.
add_filter( 'style_loader_tag', function ( $tag, $handle, $href, $media ) {
    if ( strpos( $href, '/themes/storefront/' ) === false && strpos( $href, '/plugins/woocommerce/' ) === false ) { return $tag; }
    $query = ( $media && $media !== 'all' ) ? ' ' . preg_replace( '/[^a-zA-Z0-9():.\s-]/', '', $media ) : '';
    return '<style id="' . esc_attr( $handle ) . '-layer-css">@import url(' . wp_json_encode( esc_url_raw( $href ) ) . ') layer(theme)' . $query . ';</style>' . "\n";
}, 20, 4 );

add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
    $fragments['.lf-cart-count'] = '<span class="lf-cart-count">' . esc_html( WC()->cart->get_cart_contents_count() ) . '</span>';
    ob_start(); lf_mobile_cartbar(); $fragments['.lf-live-cartbar'] = ob_get_clean();
    return $fragments;
} );

function lf_mobile_cartbar() {
    if ( ! function_exists( 'WC' ) || ! WC()->cart ) { return; }
    ?>
    <div class="lf-cartbar lf-live-cartbar"><a href="<?php echo esc_url( wc_get_cart_url() ); ?>"><span>Voir mon panier · <?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?> article(s)</span><strong><?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?></strong></a></div>
    <?php
}
