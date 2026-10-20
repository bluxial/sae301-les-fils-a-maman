<?php
/**
 * IT-8 : réglages des e-mails transactionnels (expéditeur, couleurs, pied de page).
 * À lancer depuis le dossier du site :
 * ddev wp eval-file wp-content/themes/les-fils-a-maman/tools/it8-emails.php
 * Ou en local dans le navigateur : https://sae301.ddev.site/?lf_outil=it8-emails
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

update_option('woocommerce_email_from_name', 'Les Fils à Maman');
update_option('woocommerce_email_header_image', get_stylesheet_directory_uri() . '/assets/email-logo.png');
update_option('woocommerce_email_base_color', '#79cfc2');
update_option('woocommerce_email_background_color', '#fef5ee');
update_option('woocommerce_email_body_background_color', '#fffaeb');
update_option('woocommerce_email_text_color', '#0f172a');
update_option('woocommerce_email_footer_text', 'Merci pour votre commande ! Une question ? Répondez simplement à cet e-mail.');

// E-mails envoyés au client : commande reçue (en attente / en cours), terminée, annulée, remboursée.
$emails = ['customer_on_hold_order', 'customer_processing_order', 'customer_completed_order', 'customer_refunded_order', 'customer_cancelled_order', 'customer_new_account'];

foreach ($emails as $id) {
    $reglages = get_option('woocommerce_' . $id . '_settings', []);
    $reglages['enabled'] = 'yes';
    $reglages['email_type'] = 'html';
    update_option('woocommerce_' . $id . '_settings', $reglages);
}

lf_tool_message('OK : e-mails configurés (expéditeur, couleurs, pied de page, e-mails client activés)');
