<?php
/**
 * Page panier (copie simplifiée du modèle WooCommerce cart/cart.php 11.2.0).
 * Articles à gauche (lf-cart-item) et récapitulatif à droite (lf-summary), comme dans la maquette.
 */
if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_cart');
?>

<div class="lf-cart">
    <form class="woocommerce-cart-form lf-cart__items" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
            <?php
            $product = $cart_item['data'];

            if (!$product || !$product->exists() || $cart_item['quantity'] <= 0) {
                continue;
            }
            ?>
            <article class="lf-cart-item woocommerce-cart-form__cart-item">
                <div class="lf-photo">
                    <?php echo $product->get_image('thumbnail', ['alt' => '']); ?>
                </div>

                <div class="lf-cart-item__info">
                    <h2 class="lf-cart-item__name">
                        <a href="<?php echo esc_url($product->get_permalink($cart_item)); ?>"><?php echo esc_html($product->get_name()); ?></a>
                    </h2>
                    <?php echo wc_get_formatted_cart_item_data($cart_item); ?>
                    <a class="lf-link lf-small" href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" aria-label="Retirer <?php echo esc_attr($product->get_name()); ?> du panier">Retirer</a>
                </div>

                <?php
                woocommerce_quantity_input([
                    'input_name' => 'cart[' . $cart_item_key . '][qty]',
                    'input_value' => $cart_item['quantity'],
                    'min_value' => 0,
                    'max_value' => $product->get_max_purchase_quantity(),
                    'product_name' => $product->get_name()
                ], $product);
                ?>

                <strong class="lf-price"><?php echo wp_kses_post(WC()->cart->get_product_subtotal($product, $cart_item['quantity'])); ?></strong>
            </article>
        <?php endforeach; ?>

        <div class="lf-cart__actions">
            <?php if (wc_coupons_enabled()) : ?>
                <div class="lf-coupon">
                    <label for="coupon_code">Code promo</label>
                    <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="Ex. : FISTONS10">
                    <button type="submit" class="lf-btn lf-btn--small" name="apply_coupon" value="Appliquer">Appliquer</button>
                </div>
            <?php endif; ?>

            <button type="submit" class="lf-btn lf-btn--ghost" name="update_cart" value="Mettre à jour le panier">Mettre à jour le panier</button>
            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
        </div>
    </form>

    <aside class="lf-summary cart-collaterals" aria-label="Récapitulatif du panier">
        <?php do_action('woocommerce_cart_collaterals'); ?>
    </aside>
</div>

<?php do_action('woocommerce_after_cart'); ?>
