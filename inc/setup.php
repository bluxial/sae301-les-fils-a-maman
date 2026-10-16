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
    wp_enqueue_style('lf-system', $url . '/system.css', [], filemtime($folder . '/system.css'));
    wp_enqueue_style('lf-wordpress', lf_asset('css/wordpress.css'), ['lf-system'], filemtime($folder . '/assets/css/wordpress.css'));
    wp_enqueue_script('lf-interactions', lf_asset('js/theme.js'), [], filemtime($folder . '/assets/js/theme.js'), true);
    wp_enqueue_script('wc-cart-fragments');
}
add_action('wp_enqueue_scripts', 'lf_styles_and_scripts', 100);

function lf_storefront_inline_styles() {
    $styles = wp_styles();

    foreach ($styles->registered as $name => $style) {
        if (strpos($name, 'storefront-') === 0) {
            $css = $styles->get_data($name, 'after');

            if (!empty($css)) {
                $css = '@layer theme {' . implode("\n", $css) . '}';
                wp_style_add_data($name, 'after', [$css]);
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'lf_storefront_inline_styles', 200);

function lf_layer_order() {
    echo '<style id="lf-layer-order">@layer theme, lf-reset, lf-fonts, lf-tokens, lf-base, lf-components, lf-utilities, lf-overrides;</style>' . "\n";
}
add_action('wp_head', 'lf_layer_order', 1);

function lf_external_style_layer($tag, $name, $url, $media) {
    $storefront = strpos($url, '/themes/storefront/');
    $woocommerce = strpos($url, '/plugins/woocommerce/');

    if ($storefront === false && $woocommerce === false) {
        return $tag;
    }

    $css = '@import url("' . esc_url_raw($url) . '") layer(theme)';

    if ($media !== '' && $media !== 'all') {
        $css .= ' ' . $media;
    }

    return '<style id="' . esc_attr($name) . '-layer-css">' . $css . ';</style>' . "\n";
}
add_filter('style_loader_tag', 'lf_external_style_layer', 20, 4);

function lf_cartbar_html() {
    if (!function_exists('WC') || !WC()->cart) {
        return '';
    }

    $url = esc_url(wc_get_cart_url());
    $count = esc_html(WC()->cart->get_cart_contents_count());
    $total = wp_kses_post(WC()->cart->get_cart_subtotal());

    return '<div class="lf-cartbar lf-live-cartbar"><a href="' . $url . '"><span>Voir mon panier · ' . $count . ' article(s)</span><strong>' . $total . '</strong></a></div>';
}

function lf_mobile_cartbar() {
    echo lf_cartbar_html();
}

function lf_cart_fragments($fragments) {
    $count = esc_html(WC()->cart->get_cart_contents_count());
    $fragments['.lf-cart-count'] = '<span class="lf-cart-count">' . $count . '</span>';
    $fragments['.lf-live-cartbar'] = lf_cartbar_html();
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'lf_cart_fragments');
