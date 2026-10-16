<?php
if (!defined('ABSPATH')) {
    exit;
}
global $product;

if (!$product || !$product->is_visible()) {
    return;
}

$category = lf_product_category($product);
$description = $product->get_short_description();

if ($description === '') {
    $description = $product->get_description();
}

$description = wp_trim_words(wp_strip_all_tags($description), 15, '…');
?>

<li <?php wc_product_class('lf-card', $product); ?> data-category="<?php echo esc_attr(lf_category_key($category)); ?>">
    <a class="lf-photo <?php echo esc_attr(lf_crop_class($product)); ?>" href="<?php echo esc_url($product->get_permalink()); ?>" aria-label="Voir <?php echo esc_attr($product->get_name()); ?>">
        <?php echo $product->get_image('large', ['alt' => $product->get_name()]); ?>
    </a>

    <div class="lf-card__body">
        <h2 class="lf-card__name">
            <a href="<?php echo esc_url($product->get_permalink()); ?>"><?php echo esc_html($product->get_name()); ?></a>
        </h2>
        <p class="lf-card__description"><?php echo esc_html($description); ?></p>

        <div class="lf-card__bottom">
            <span class="lf-price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
            <?php woocommerce_template_loop_add_to_cart(); ?>
        </div>
    </div>
</li>
