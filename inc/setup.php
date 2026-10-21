<?php
if (!defined('ABSPATH')) {
    exit;
}

function lf_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce', ['product_grid' => ['default_columns' => 3]]);

    remove_action('woocommerce_before_main_content', 'storefront_before_content', 10);
    remove_action('woocommerce_after_main_content', 'storefront_after_content', 10);
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 25);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
    add_action('woocommerce_single_product_summary', 'lf_product_description', 20);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
    remove_action('woocommerce_after_single_product_summary', 'storefront_single_product_pagination', 30);
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

    remove_action('woocommerce_before_shop_loop', 'storefront_sorting_wrapper', 9);
    remove_action('woocommerce_before_shop_loop', 'storefront_sorting_wrapper_close', 31);
    remove_action('woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);
    add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

    remove_action('woocommerce_after_shop_loop', 'storefront_sorting_wrapper', 9);
    remove_action('woocommerce_after_shop_loop', 'storefront_sorting_wrapper_close', 31);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 20);
}
add_action('after_setup_theme', 'lf_setup', 30);

function lf_body_class($classes) {
    $classes[] = 'lf-system';
    return $classes;
}
add_filter('body_class', 'lf_body_class');

function lf_shop_columns() {
    return 3;
}
add_filter('loop_shop_columns', 'lf_shop_columns');

function lf_shop_per_page() {
    return 12;
}
add_filter('loop_shop_per_page', 'lf_shop_per_page');

function lf_asset($file) {
    return get_stylesheet_directory_uri() . '/assets/' . $file;
}

function lf_styles_and_scripts() {
    $folder = get_stylesheet_directory();
    $url = get_stylesheet_directory_uri();

    wp_dequeue_style('storefront-fonts');
    wp_dequeue_style('source-sans-pro');
    wp_dequeue_style('storefront-style');
    wp_dequeue_style('storefront-icons');
    wp_dequeue_style('storefront-gutenberg-blocks');
    wp_dequeue_style('storefront-woocommerce-style');
    wp_dequeue_style('storefront-woocommerce-brands-style');
    wp_enqueue_style('lf-system', $url . '/system.css', [], filemtime($folder . '/system.css'));
    wp_enqueue_style('lf-wordpress', lf_asset('css/wordpress.css'), ['lf-system'], filemtime($folder . '/assets/css/wordpress.css'));
    wp_enqueue_script('lf-interactions', lf_asset('js/theme.js'), [], filemtime($folder . '/assets/js/theme.js'), true);
}
add_action('wp_enqueue_scripts', 'lf_styles_and_scripts', 100);

function lf_mobile_cartbar() {
    $url = wc_get_cart_url();
    $count = WC()->cart->get_cart_contents_count();
    $total = WC()->cart->get_cart_subtotal();
    ?>
    <div class="lf-cartbar lf-live-cartbar">
        <a href="<?php echo esc_url($url); ?>"><span>Voir mon panier · <?php echo esc_html($count); ?> article(s)</span><strong><?php echo wp_kses_post($total); ?></strong></a>
    </div>
    <?php
}
