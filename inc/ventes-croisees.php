<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-13 : ventes croisées (« Ça va bien avec… ») sur la fiche produit et dans le panier.

// Affiche jusqu'à 3 produits en cartes horizontales « lf-recommendation », comme dans la maquette.
function lf_show_suggestions($ids, $titre) {
    if (empty($ids)) {
        return;
    }

    echo '<section class="lf-suggestions">';
    echo '<h2 class="lf-title lf-title--h3 lf-title--outlined">' . esc_html($titre) . '</h2>';
    echo '<div class="lf-recommendations">';

    // array_slice garde seulement les 3 premiers produits de la liste.
    foreach (array_slice($ids, 0, 3) as $id) {
        $product = wc_get_product($id);

        if (!$product || !$product->is_visible()) {
            continue;
        }

        $nom = $product->get_name();
        $lien = $product->get_permalink();
        ?>
        <article class="lf-recommendation">
            <a class="lf-photo <?php echo esc_attr(lf_crop_class($product)); ?>" href="<?php echo esc_url($lien); ?>" tabindex="-1" aria-hidden="true">
                <?php echo $product->get_image('thumbnail', ['alt' => '']); ?>
            </a>

            <p class="lf-recommendation__info">
                <a href="<?php echo esc_url($lien); ?>"><?php echo esc_html($nom); ?></a>
                <strong><?php echo wp_kses_post($product->get_price_html()); ?></strong>
            </p>

            <?php if ($product->is_type('simple') && $product->is_purchasable() && $product->is_in_stock()) : ?>
                <a class="lf-btn lf-btn--icon add_to_cart_button ajax_add_to_cart" href="<?php echo esc_url($product->add_to_cart_url()); ?>" data-quantity="1" data-product_id="<?php echo esc_attr($product->get_id()); ?>" aria-label="Ajouter <?php echo esc_attr($nom); ?> au panier" rel="nofollow">+</a>
            <?php else : ?>
                <a class="lf-btn lf-btn--icon" href="<?php echo esc_url($lien); ?>" aria-label="Choisir les options de <?php echo esc_attr($nom); ?>">→</a>
            <?php endif; ?>
        </article>
        <?php
    }

    echo '</div>';
    echo '</section>';
}

// 1. Fiche produit : les produits complémentaires choisis dans le back office.
function lf_product_suggestions() {
    global $product;
    lf_show_suggestions($product->get_cross_sell_ids(), 'Ça va bien avec…');
}
add_action('woocommerce_after_single_product_summary', 'lf_product_suggestions', 15);

// 2. Panier : les suggestions sous les articles, en pleine largeur.
function lf_cart_suggestions() {
    lf_show_suggestions(WC()->cart->get_cross_sells(), 'Pour compléter ta commande');
}
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_after_cart', 'lf_cart_suggestions');
