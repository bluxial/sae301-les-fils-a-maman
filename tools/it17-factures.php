<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

if (!function_exists('WPO_WCPDF')) {
    lf_tool_message('Attention : l’extension PDF Invoices & Packing Slips n’est pas activée.');
    return;
}

$logo_id = (int) get_option('lf_logo_facture_id');

if (!$logo_id || !get_post($logo_id)) {
    $dossier = wp_upload_dir();
    $fichier = $dossier['path'] . '/logo-les-fils-a-maman.png';
    copy(get_stylesheet_directory() . '/assets/email-logo.png', $fichier);

    $logo_id = wp_insert_attachment([
        'post_title' => 'Logo Les Fils à Maman',
        'post_mime_type' => 'image/png',
        'post_status' => 'inherit'
    ], $fichier);

    wp_update_attachment_metadata($logo_id, wp_generate_attachment_metadata($logo_id, $fichier));
    update_option('lf_logo_facture_id', $logo_id);
}

delete_option('wpo_wcpdf_installed_template_paths');

$general = get_option('wpo_wcpdf_settings_general', []);
$general['download_display'] = 'display';
$general['template_path'] = 'theme/lfam';
$general['paper_size'] = 'a4';
$general['header_logo'] = ['default' => $logo_id];
$general['shop_name'] = ['default' => 'Les Fils à Maman Paris 9e'];
$general['shop_address_line_1'] = ['default' => '7 bis rue Geoffroy-Marie'];
$general['shop_address_postcode'] = ['default' => '75009'];
$general['shop_address_city'] = ['default' => 'Paris'];
$general['shop_address_country'] = ['default' => 'FR'];
$general['footer'] = ['default' => 'Les Fils à Maman — projet pédagogique SAÉ 3.01 (BUT MMI, IUT du Limousin). Facture de démonstration, sans valeur commerciale.'];
update_option('wpo_wcpdf_settings_general', $general);

$facture = get_option('wpo_wcpdf_documents_settings_invoice', []);
$facture['enabled'] = 1;
$facture['attach_to_email_ids'] = ['customer_processing_order' => 1, 'customer_completed_order' => 1];
$facture['display_date'] = 'invoice_date';
$facture['display_number'] = 'invoice_number';
$facture['my_account_buttons'] = 'available';
update_option('wpo_wcpdf_documents_settings_invoice', $facture);

lf_tool_message('OK : factures PDF configurées (modèle lfam, logo, coordonnées, e-mails, Mon compte)');
