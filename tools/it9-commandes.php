<?php
/**
 * IT-9 : textes des e-mails de suivi de commande et gestion du stock.
 * À lancer depuis le dossier du site :
 * ddev wp eval-file wp-content/themes/les-fils-a-maman/tools/it9-commandes.php
 * Ou en local dans le navigateur : https://sae301.ddev.site/?lf_outil=it9-commandes
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

// Le stock baisse à chaque commande et remonte si elle est annulée.
update_option('woocommerce_manage_stock', 'yes');
update_option('woocommerce_hold_stock_minutes', '60');

// Textes adaptés au Click & Collect.
$textes = [
    'customer_processing_order' => ['Commande n° {order_number} reçue : on s’en occupe !', 'Merci pour votre commande'],
    'customer_on_hold_order' => ['Commande n° {order_number} en attente de votre virement', 'Merci pour votre commande'],
    'customer_completed_order' => ['Commande n° {order_number} terminée, merci !', 'Bon appétit !'],
    'customer_cancelled_order' => ['Commande n° {order_number} annulée', 'Votre commande est annulée'],
    'customer_refunded_order' => ['Commande n° {order_number} remboursée', 'Votre remboursement est en route']
];

foreach ($textes as $id => $texte) {
    $reglages = get_option('woocommerce_' . $id . '_settings', []);
    $reglages['subject'] = $texte[0];
    $reglages['heading'] = $texte[1];

    if ($id === 'customer_refunded_order') {
        $reglages['subject_full'] = $texte[0];
        $reglages['heading_full'] = $texte[1];
    }

    update_option('woocommerce_' . $id . '_settings', $reglages);
}

lf_tool_message('OK : textes des e-mails de suivi et gestion du stock configurés');
