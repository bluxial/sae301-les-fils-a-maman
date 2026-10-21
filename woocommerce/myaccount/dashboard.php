<?php
/**
 * Tableau de bord du compte client (remplace le modèle WooCommerce myaccount/dashboard.php 4.4.0).
 * Bonjour + dernière commande + raccourcis, avec les composants du design system.
 */
if (!defined('ABSPATH')) {
    exit;
}

$client = wp_get_current_user();
$prenom = $client->first_name;

if ($prenom === '') {
    $prenom = $client->display_name;
}

$commandes = wc_get_orders([
    'customer_id' => get_current_user_id(),
    'type' => 'shop_order',
    'limit' => -1,
    'return' => 'ids'
]);

$derniere = null;

if (!empty($commandes)) {
    $derniere = wc_get_order($commandes[0]);
}
?>

<section class="lf-account-hello">
    <p class="lf-script">content de te revoir</p>
    <h2 class="lf-account-hello__title">Bonjour <?php echo esc_html($prenom); ?> !</h2>
    <p>Retrouve tes commandes, ton créneau de retrait et tes informations.</p>
    <div class="lf-account-hello__actions">
        <a class="lf-btn" href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Commander</a>
        <a class="lf-link" href="<?php echo esc_url(wc_logout_url()); ?>">Se déconnecter</a>
    </div>
</section>

<?php if ($derniere) : ?>
    <section class="lf-account-last" aria-labelledby="lf-last-title">
        <div class="lf-account-last__head">
            <h2 id="lf-last-title">Ma dernière commande</h2>
            <span class="lf-status lf-status--<?php echo esc_attr($derniere->get_status()); ?>"><?php echo esc_html(wc_get_order_status_name($derniere->get_status())); ?></span>
        </div>

        <dl class="lf-facts">
            <div>
                <dt>Commande</dt>
                <dd>n° <?php echo esc_html($derniere->get_order_number()); ?> · <?php echo esc_html(wc_format_datetime($derniere->get_date_created())); ?></dd>
            </div>
            <div>
                <dt>Total</dt>
                <dd><?php echo wp_kses_post($derniere->get_formatted_order_total()); ?> · <?php echo esc_html($derniere->get_item_count()); ?> article(s)</dd>
            </div>
            <div>
                <dt>Retrait</dt>
                <dd><?php echo esc_html($derniere->get_shipping_method()); ?></dd>
            </div>
            <?php if (lf_order_slot_text($derniere) !== '') : ?>
                <div>
                    <dt>Créneau</dt>
                    <dd><?php echo esc_html(lf_order_slot_text($derniere)); ?></dd>
                </div>
            <?php endif; ?>
        </dl>

        <a class="lf-btn lf-btn--secondary" href="<?php echo esc_url($derniere->get_view_order_url()); ?>">Voir le détail</a>
    </section>
<?php endif; ?>

<ul class="lf-account-tiles">
    <li>
        <a class="lf-account-tile lf-account-tile--rose" href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>">
            <span class="lf-account-tile__icon" aria-hidden="true">🧾</span>
            <strong>Mes commandes</strong>
            <span><?php echo esc_html(count($commandes)); ?> commande(s), factures et suivi</span>
        </a>
    </li>
    <li>
        <a class="lf-account-tile lf-account-tile--turquoise" href="<?php echo esc_url(wc_get_endpoint_url('edit-address')); ?>">
            <span class="lf-account-tile__icon" aria-hidden="true">📍</span>
            <strong>Mes adresses</strong>
            <span>Facturation et livraison</span>
        </a>
    </li>
    <li>
        <a class="lf-account-tile lf-account-tile--jaune" href="<?php echo esc_url(wc_get_endpoint_url('edit-account')); ?>">
            <span class="lf-account-tile__icon" aria-hidden="true">👤</span>
            <strong>Mes informations</strong>
            <span>Nom, e-mail et mot de passe</span>
        </a>
    </li>
</ul>

<?php
do_action('woocommerce_account_dashboard');
do_action('woocommerce_before_my_account');
do_action('woocommerce_after_my_account');
