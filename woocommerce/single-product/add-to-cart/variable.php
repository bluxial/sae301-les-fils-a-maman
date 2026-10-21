<?php
if (!defined('ABSPATH')) {
    exit;
}

global $product;

$variations_json = wp_json_encode($available_variations);

do_action('woocommerce_before_add_to_cart_form');
?>

<form class="variations_form cart lf-variations-form" action="<?php echo esc_url($product->get_permalink()); ?>" method="post" enctype="multipart/form-data" data-product_id="<?php echo absint($product->get_id()); ?>" data-product_variations="<?php echo wc_esc_json($variations_json); ?>">
    <?php do_action('woocommerce_before_variations_form'); ?>

    <?php if (empty($available_variations) && $available_variations !== false) : ?>
        <p class="stock out-of-stock">Ce produit est épuisé pour le moment.</p>
    <?php else : ?>
        <div class="variations">
            <?php foreach ($attributes as $attribute_name => $options) : ?>
                <?php
                $select_name = 'attribute_' . sanitize_title($attribute_name);
                $selected = $product->get_variation_default_attribute($attribute_name);
                ?>
                <fieldset class="lf-options">
                    <legend><?php echo esc_html(wc_attribute_label($attribute_name)); ?></legend>

                    <div class="lf-chips">
                        <?php foreach ($options as $option) : ?>
                            <label class="lf-chip has-input">
                                <input type="radio" name="lf-<?php echo esc_attr($select_name); ?>" value="<?php echo esc_attr($option); ?>" data-select="<?php echo esc_attr($select_name); ?>" <?php checked($selected, $option); ?>>
                                <?php echo esc_html($option); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <?php
                    wc_dropdown_variation_attribute_options([
                        'options' => $options,
                        'attribute' => $attribute_name,
                        'product' => $product,
                        'selected' => $selected,
                        'class' => 'lf-visually-hidden'
                    ]);
                    ?>
                </fieldset>
            <?php endforeach; ?>
        </div>

        <div class="single_variation_wrap">
            <?php
            do_action('woocommerce_before_single_variation');
            do_action('woocommerce_single_variation');
            do_action('woocommerce_after_single_variation');
            ?>
        </div>
    <?php endif; ?>

    <?php do_action('woocommerce_after_variations_form'); ?>
</form>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>
