<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-9 : statut « Prête à retirer » pour suivre une commande Click & Collect
// en cours → prête à retirer (e-mail au client) → terminée (payée et récupérée).

// 1. Création du statut.
function lf_register_ready_status() {
    register_post_status('wc-pret-retrait', [
        'label' => 'Prête à retirer',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true
    ]);
}
add_action('init', 'lf_register_ready_status');

// 2. Ajout du statut dans la liste, juste après « En cours ».
function lf_order_statuses($statuses) {
    $liste = [];

    foreach ($statuses as $cle => $libelle) {
        $liste[$cle] = $libelle;

        if ($cle === 'wc-processing') {
            $liste['wc-pret-retrait'] = 'Prête à retirer';
        }
    }

    return $liste;
}
add_filter('wc_order_statuses', 'lf_order_statuses');

// 3. Action groupée dans la liste des commandes du back office.
function lf_order_bulk_action($actions) {
    $actions['mark_pret-retrait'] = 'Passer en « Prête à retirer »';
    return $actions;
}
add_filter('bulk_actions-edit-shop_order', 'lf_order_bulk_action');
add_filter('bulk_actions-woocommerce_page_wc-orders', 'lf_order_bulk_action');

// 4. E-mail au client quand la commande passe en « Prête à retirer ».
function lf_ready_email($order_id, $order) {
    $mailer = WC()->mailer();
    $numero = $order->get_order_number();

    $contenu = '<p>Bonjour ' . esc_html($order->get_billing_first_name()) . ',</p>';
    $contenu .= '<p>Bonne nouvelle : votre commande n° ' . esc_html($numero) . ' est prête. Vous pouvez venir la chercher au restaurant.</p>';
    $contenu .= '<div class="lf-email-pickup"><h2>Instructions pour le retrait</h2>' . wpautop(esc_html(lf_pickup_text())) . '</div>';

    $message = $mailer->wrap_message('Votre commande est prête !', $contenu);
    $mailer->send($order->get_billing_email(), '[Les Fils à Maman] Commande n° ' . $numero . ' prête à retirer', $message);
}
add_action('woocommerce_order_status_pret-retrait', 'lf_ready_email', 10, 2);
