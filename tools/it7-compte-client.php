<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

update_option('woocommerce_enable_myaccount_registration', 'yes');
update_option('woocommerce_enable_signup_and_login_from_checkout', 'yes');
update_option('woocommerce_enable_checkout_login_reminder', 'yes');
update_option('woocommerce_enable_guest_checkout', 'yes');

update_option('woocommerce_registration_generate_username', 'yes');
update_option('woocommerce_registration_generate_password', 'no');

wp_update_post(['ID' => wc_get_page_id('myaccount'), 'post_content' => '[woocommerce_my_account]']);

lf_tool_message('OK : création de compte et connexion configurées');
