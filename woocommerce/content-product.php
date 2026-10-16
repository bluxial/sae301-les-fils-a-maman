<?php
/** Carte produit WooCommerce. @version 9.4.0 */
defined( 'ABSPATH' ) || exit;
global $product;
if ( ! $product || ! $product->is_visible() ) { return; }
$term = lf_product_category( $product );
?>
<li <?php wc_product_class( 'lf-card', $product ); ?> data-category="<?php echo esc_attr( lf_category_key( $term ) ); ?>">
    <a class="lf-photo <?php echo esc_attr( lf_crop_class( $product ) ); ?>" href="<?php echo esc_url( $product->get_permalink() ); ?>" aria-label="Voir <?php echo esc_attr( $product->get_name() ); ?>"><?php echo $product->get_image( 'large', array( 'alt' => $product->get_name() ) ); // WooCommerce generates image markup. ?></a>
    <div class="lf-card__body"><h2 class="lf-card__name"><a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h2><p class="lf-card__description"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() ), 15, '…' ) ); ?></p><div class="lf-card__bottom"><span class="lf-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span><?php woocommerce_template_loop_add_to_cart(); ?></div></div>
</li>
