<?php
if (!defined('ABSPATH')) {
    exit;
}

function lf_email_styles($css) {
    $css .= '
        #template_container { border: 2px solid #0f172a !important; border-radius: 16px !important; box-shadow: 6px 6px 0 #0f172a !important; overflow: hidden; }
        #template_header { background-color: #79cfc2 !important; border-bottom: 2px solid #0f172a; }
        #header_wrapper { padding: 24px 32px !important; }
        #template_header h1 { color: #0f172a; font-weight: 700; text-transform: uppercase; }
        .lf-email-kicker { margin: 0 0 4px; color: #0f172a; font-size: 14px; font-weight: 700; }
        .lf-email-pickup { margin: 0 0 24px; padding: 16px; border: 2px solid #0f172a; border-radius: 12px; background-color: #fede85; color: #0f172a; }
        .lf-email-pickup h2 { margin: 0 0 8px; color: #0f172a; font-size: 18px; }
        .lf-email-pickup p { margin: 0 0 8px; }
    ';

    return $css;
}
add_filter('woocommerce_email_styles', 'lf_email_styles');

function lf_email_pickup($order, $sent_to_admin, $plain_text) {
    if ($sent_to_admin || !$order->has_shipping_method('local_pickup')) {
        return;
    }

    if ($plain_text) {
        echo "\nINSTRUCTIONS POUR LE RETRAIT\n" . wp_strip_all_tags(lf_pickup_text()) . "\n\n";
        return;
    }

    echo '<div class="lf-email-pickup">';
    echo '<h2>Instructions pour le retrait</h2>';
    echo wp_kses_post(wpautop(lf_pickup_text()));
    echo '</div>';
}
add_action('woocommerce_email_before_order_table', 'lf_email_pickup', 10, 3);
