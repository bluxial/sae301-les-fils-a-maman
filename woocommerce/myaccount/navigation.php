<?php
/**
 * Menu du compte client (copie simplifiée du modèle WooCommerce myaccount/navigation.php 9.3.0).
 * Les liens prennent la forme des pastilles lf-chip du design system.
 */
if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_account_navigation');
?>

<nav class="woocommerce-MyAccount-navigation lf-account-nav" aria-label="Mon compte">
    <ul class="lf-chips">
        <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
            <li>
                <a class="lf-chip" href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" <?php if (wc_is_current_account_menu_item($endpoint)) { echo 'aria-current="page"'; } ?>>
                    <?php echo esc_html($label); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>
