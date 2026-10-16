<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header('shop');
do_action('woocommerce_before_main_content');

$category = null;
$key = 'all';
$subtitle = 'qu’est-ce qui te ferait plaisir ?';

if (is_product_category()) {
    $category = get_queried_object();
    $key = lf_category_key($category);
    $subtitle = lf_category_script($key);
}
?>

<section class="lf-container lf-catalogue-page" data-category="<?php echo esc_attr($key); ?>">
    <?php lf_category_navigation(); ?>

    <header class="lf-catalogue-heading">
        <h1 class="lf-title lf-title--h1 lf-title--outlined"><?php woocommerce_page_title(); ?></h1>
        <p class="lf-script"><?php echo esc_html($subtitle); ?></p>
        <?php do_action('woocommerce_archive_description'); ?>
    </header>

    <?php if (woocommerce_product_loop()) : ?>
        <div class="lf-catalogue-toolbar">
            <?php do_action('woocommerce_before_shop_loop'); ?>
        </div>

        <?php
        woocommerce_product_loop_start();

        while (have_posts()) {
            the_post();
            do_action('woocommerce_shop_loop');
            wc_get_template_part('content', 'product');
        }

        woocommerce_product_loop_end();
        do_action('woocommerce_after_shop_loop');
        ?>
    <?php else : ?>
        <?php do_action('woocommerce_no_products_found'); ?>
    <?php endif; ?>
</section>

<?php
do_action('woocommerce_after_main_content');
get_footer('shop');
