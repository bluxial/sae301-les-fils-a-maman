<?php
/**
 * IT-7 : création de compte et connexion des clients.
 * À lancer depuis le dossier du site :
 * ddev wp eval-file wp-content/themes/les-fils-a-maman/tools/it7-compte-client.php
 * Ou en local dans le navigateur : https://sae301.ddev.site/?lf_outil=it7-compte-client
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

// Inscription possible depuis « Mon compte » et pendant la commande.
update_option('woocommerce_enable_myaccount_registration', 'yes');
update_option('woocommerce_enable_signup_and_login_from_checkout', 'yes');
update_option('woocommerce_enable_checkout_login_reminder', 'yes');
update_option('woocommerce_enable_guest_checkout', 'yes');

// Le client choisit son mot de passe ; l'identifiant est créé à partir de l'e-mail.
update_option('woocommerce_registration_generate_username', 'yes');
update_option('woocommerce_registration_generate_password', 'no');

// La page « Mon compte » utilise le shortcode classique.
wp_update_post(['ID' => wc_get_page_id('myaccount'), 'post_content' => '[woocommerce_my_account]']);

lf_tool_message('OK : création de compte et connexion configurées');
