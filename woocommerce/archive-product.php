<?php
/** Catalogue WooCommerce. @version 8.6.0 */
defined( 'ABSPATH' ) || exit;
get_header( 'shop' );
do_action( 'woocommerce_before_main_content' );
$term = is_product_category() ? get_queried_object() : null;
$key = lf_category_key( $term );
?>
<section class="lf-container lf-catalogue-page" data-category="<?php echo esc_attr( $term ? $key : 'all' ); ?>">
    <?php lf_category_navigation(); ?>
    <header class="lf-catalogue-heading"><h1 class="lf-title lf-title--h1 lf-title--outlined"><?php woocommerce_page_title(); ?></h1><p class="lf-script"><?php echo esc_html( $term ? lf_category_script( $key ) : 'qu’est-ce qui te ferait plaisir ?' ); ?></p><?php do_action( 'woocommerce_archive_description' ); ?></header>
    <?php if ( woocommerce_product_loop() ) : ?>
        <div class="lf-catalogue-toolbar"><?php do_action( 'woocommerce_before_shop_loop' ); ?></div>
        <?php woocommerce_product_loop_start(); ?>
        <?php while ( have_posts() ) : the_post(); do_action( 'woocommerce_shop_loop' ); wc_get_template_part( 'content', 'product' ); endwhile; ?>
        <?php woocommerce_product_loop_end(); do_action( 'woocommerce_after_shop_loop' ); ?>
    <?php else : do_action( 'woocommerce_no_products_found' ); endif; ?>
</section>
<?php do_action( 'woocommerce_after_main_content' ); get_footer( 'shop' ); ?>
