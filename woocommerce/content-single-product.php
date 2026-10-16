<?php
/** Fiche produit, actions WooCommerce natives. @version 3.6.0 */
defined( 'ABSPATH' ) || exit;
global $product;
do_action( 'woocommerce_before_single_product' );
if ( post_password_required() ) { echo get_the_password_form(); return; }
$term = lf_product_category( $product );
?>
<section class="lf-container lf-product-page">
    <?php woocommerce_breadcrumb( array( 'wrap_before' => '<nav class="lf-breadcrumb" aria-label="Fil d’Ariane">', 'wrap_after' => '</nav>', 'delimiter' => '<span aria-hidden="true">›</span>', 'home' => 'Accueil' ) ); ?>
    <article id="product-<?php the_ID(); ?>" <?php wc_product_class( 'lf-product-detail', $product ); ?>>
        <div class="lf-product-image lf-photo <?php echo esc_attr( lf_crop_class( $product ) ); ?>"><?php echo $product->get_image( 'full', array( 'alt' => $product->get_name(), 'fetchpriority' => 'high' ) ); ?></div>
        <div class="summary lf-product-summary"><?php if ( $term ) : ?><a class="lf-badge lf-badge--<?php echo esc_attr( lf_category_key( $term ) ); ?>" href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a><?php endif; ?><?php do_action( 'woocommerce_single_product_summary' ); ?></div>
    </article>
    <?php do_action( 'woocommerce_after_single_product_summary' ); ?>
</section>
<?php do_action( 'woocommerce_after_single_product' ); ?>
