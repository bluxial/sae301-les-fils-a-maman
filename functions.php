<?php
/**
 * Sommaire
 * 1. Réglages du thème, styles et scripts
 * 2. Catalogue : catégories et cartes produits (IT-2)
 * 3. Produits à options (IT-3)
 * 4. Composition et allergènes : champs SCF (IT-4)
 * 5. Instructions pour le retrait (IT-6)
 * 6. Compte client (IT-7)
 * 7. E-mails (IT-8)
 * 8. Statut « Prête à retirer » (IT-9)
 * 9. Équipe (IT-11)
 * 10. Envies (IT-12)
 * 11. Ventes croisées (IT-13)
 * 12. Avis clients (IT-14)
 * 13. Frais de préparation (IT-15)
 * 14. Filtres de la boutique (IT-18)
 * 15. Livraison selon le poids (IT-19)
 * 16. Jour et créneau (IT-20)
 */

if (!defined('ABSPATH')) {
    exit;
}

/* =========================================================
 * 1. Réglages du thème, styles et scripts
 * ========================================================= */

function lf_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce', ['product_grid' => ['default_columns' => 3]]);

    remove_theme_support('wc-product-gallery-zoom');
    remove_theme_support('wc-product-gallery-lightbox');
    remove_theme_support('wc-product-gallery-slider');

    remove_action('woocommerce_before_main_content', 'storefront_before_content', 10);
    remove_action('woocommerce_after_main_content', 'storefront_after_content', 10);
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 25);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
    add_action('woocommerce_single_product_summary', 'lf_product_description', 20);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
    remove_action('woocommerce_after_single_product_summary', 'storefront_single_product_pagination', 30);
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

    remove_action('woocommerce_before_shop_loop', 'storefront_sorting_wrapper', 9);
    remove_action('woocommerce_before_shop_loop', 'storefront_sorting_wrapper_close', 31);
    remove_action('woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);
    add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

    remove_action('woocommerce_after_shop_loop', 'storefront_sorting_wrapper', 9);
    remove_action('woocommerce_after_shop_loop', 'storefront_sorting_wrapper_close', 31);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10);
    remove_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 20);
}
add_action('after_setup_theme', 'lf_setup', 30);

function lf_body_class($classes) {
    $classes[] = 'lf-system';
    return $classes;
}
add_filter('body_class', 'lf_body_class');

function lf_icone() {
    echo '<link rel="icon" type="image/svg+xml" href="' . esc_url(get_stylesheet_directory_uri() . '/assets/img/sticker-tamagotchi.svg') . '">' . "\n";
}
add_action('wp_head', 'lf_icone');

function lf_shop_columns() {
    return 3;
}
add_filter('loop_shop_columns', 'lf_shop_columns');

function lf_shop_per_page() {
    return 12;
}
add_filter('loop_shop_per_page', 'lf_shop_per_page');

function lf_asset($file) {
    return get_stylesheet_directory_uri() . '/assets/' . $file;
}

function lf_styles_and_scripts() {
    $folder = get_stylesheet_directory();
    $url = get_stylesheet_directory_uri();

    wp_dequeue_style('storefront-fonts');
    wp_dequeue_style('source-sans-pro');
    wp_dequeue_style('storefront-style');
    wp_dequeue_style('storefront-icons');
    wp_dequeue_style('storefront-gutenberg-blocks');
    wp_dequeue_style('storefront-woocommerce-style');
    wp_dequeue_style('storefront-woocommerce-brands-style');
    wp_dequeue_style('storefront-child-style');
    wp_enqueue_style('lf-style', $url . '/style.css', [], filemtime($folder . '/style.css'));
    wp_enqueue_script('lf-menu', lf_asset('js/menu.js'), [], filemtime($folder . '/assets/js/menu.js'), true);

    if (is_product()) {
        wp_enqueue_script('lf-quantite', lf_asset('js/quantite.js'), [], filemtime($folder . '/assets/js/quantite.js'), true);
        wp_enqueue_script('lf-options-produit', lf_asset('js/options-produit.js'), [], filemtime($folder . '/assets/js/options-produit.js'), true);
    }
}
add_action('wp_enqueue_scripts', 'lf_styles_and_scripts', 100);

function lf_mobile_cartbar() {
    $url = wc_get_cart_url();
    $count = WC()->cart->get_cart_contents_count();
    $total = WC()->cart->get_cart_subtotal();
    ?>
    <div class="lf-cartbar lf-live-cartbar">
        <a href="<?php echo esc_url($url); ?>"><span>Voir mon panier · <?php echo esc_html($count); ?> article(s)</span><strong><?php echo wp_kses_post($total); ?></strong></a>
    </div>
    <?php
}

/* =========================================================
 * 2. Catalogue : catégories et cartes produits (IT-2)
 * ========================================================= */

function lf_categories() {
    $categories = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'orderby' => 'term_id',
        'order' => 'ASC'
    ]);

    if (is_wp_error($categories)) {
        return [];
    }

    return $categories;
}

function lf_category_key($category) {
    if (!$category) {
        return 'partager';
    }

    if ($category->slug === 'plats') {
        return 'plats';
    }

    if (str_contains($category->slug, 'dessert')) {
        return 'desserts';
    }

    return 'partager';
}

function lf_product_category($product) {
    $categories = get_the_terms($product->get_id(), 'product_cat');

    if (is_wp_error($categories) || empty($categories)) {
        return null;
    }

    return $categories[0];
}

function lf_category_script($key) {
    if ($key === 'partager') {
        return 'pour picorer';
    }

    if ($key === 'plats') {
        return 'comme chez maman';
    }

    if ($key === 'desserts') {
        return 'la petite douceur';
    }

    return 'à ta façon';
}

function lf_crop_class($product) {
    $slug = $product->get_slug();
    $crops = [
        'beignets' => 'beignets',
        'mimosa' => 'oeufs',
        'cordon' => 'cordon',
        'tartare' => 'tartare',
        'millefeuille' => 'millefeuille',
        'peche' => 'peche'
    ];

    foreach ($crops as $word => $crop) {
        if (str_contains($slug, $word)) {
            return 'lf-crop-' . $crop;
        }
    }

    return '';
}

function lf_category_navigation() {
    $current = 0;

    if (is_product_category()) {
        $current = get_queried_object_id();
    }
    ?>
    <nav class="lf-chips lf-category-nav" aria-label="Catégories de la carte">
        <a class="lf-chip" href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" <?php if (is_shop()) { echo 'aria-current="page"'; } ?>>Toute la carte</a>

        <?php foreach (lf_categories() as $category) : ?>
            <a class="lf-chip" href="<?php echo esc_url(get_term_link($category)); ?>" <?php if ($current === $category->term_id) { echo 'aria-current="page"'; } ?>><?php echo esc_html($category->name); ?></a>
        <?php endforeach; ?>
    </nav>
    <?php
}

function lf_product_description() {
    global $product;
    $description = $product->get_description();

    if ($description === '') {
        $description = $product->get_short_description();
    }

    if ($description !== '') {
        echo '<div class="lf-product-description">' . wp_kses_post(wpautop($description)) . '</div>';
    }
}

function lf_cart_button_class($args) {
    $args['class'] .= ' lf-btn';
    return $args;
}
add_filter('woocommerce_loop_add_to_cart_args', 'lf_cart_button_class');

function lf_cart_button_text($text, $product) {
    if ($product->is_type('simple') && $product->is_purchasable() && $product->is_in_stock()) {
        return 'Ajouter +';
    }

    return $text;
}
add_filter('woocommerce_product_add_to_cart_text', 'lf_cart_button_text', 10, 2);

/* =========================================================
 * 3. Produits à options (IT-3)
 * ========================================================= */

function lf_variable_price($price, $product) {
    $minimum = $product->get_variation_price('min', true);
    return 'À partir de ' . wc_price($minimum);
}
add_filter('woocommerce_variable_price_html', 'lf_variable_price', 10, 2);

function lf_variable_button_text($text, $product) {
    if ($product->is_type('variable')) {
        return 'Choisir +';
    }

    return $text;
}
add_filter('woocommerce_product_add_to_cart_text', 'lf_variable_button_text', 20, 2);

function lf_stock_class($class, $product) {
    if (!$product->managing_stock() || !$product->is_in_stock()) {
        return $class;
    }

    $stock = $product->get_stock_quantity();

    if ($stock <= wc_get_low_stock_amount($product)) {
        return $class . ' low-stock';
    }

    return $class;
}
add_filter('woocommerce_get_availability_class', 'lf_stock_class', 10, 2);

/* =========================================================
 * 4. Composition et allergènes : champs SCF (IT-4)
 * ========================================================= */

function lf_product_facts() {
    $composition = get_field('composition');
    $allergenes = get_field('allergenes');
    $calories = get_field('calories');

    if (!$composition && !$allergenes && !$calories) {
        return;
    }

    echo '<dl class="lf-facts lf-product-facts">';

    if ($composition) {
        echo '<div><dt>Composition</dt><dd>' . esc_html($composition) . '</dd></div>';
    }

    if ($allergenes) {
        echo '<div><dt>Allergènes</dt><dd>' . esc_html(implode(', ', $allergenes)) . '</dd></div>';
    }

    if ($calories) {
        echo '<div><dt>Énergie</dt><dd>' . esc_html($calories) . ' kcal par portion</dd></div>';
    }

    echo '</dl>';
}
add_action('woocommerce_single_product_summary', 'lf_product_facts', 22);

/* =========================================================
 * 5. Instructions pour le retrait (IT-6)
 * ========================================================= */

function lf_pickup_default_text() {
    return "Votre commande vous attend au comptoir des Fils à Maman, 7 bis rue Geoffroy-Marie, 75009 Paris.\nDonnez votre nom et votre numéro de commande. Le paiement au retrait se fait par carte ou en espèces.";
}

function lf_pickup_text() {
    $texte = get_option('lf_instructions_retrait', '');

    if (trim($texte) === '') {
        $texte = lf_pickup_default_text();
    }

    return $texte;
}

function lf_pickup_setting($settings) {
    $settings[] = [
        'title' => 'Instructions pour le retrait',
        'type' => 'title',
        'desc' => 'Texte affiché aux clients pendant la validation de la commande.',
        'id' => 'lf_retrait'
    ];

    $settings[] = [
        'title' => 'Texte',
        'id' => 'lf_instructions_retrait',
        'type' => 'textarea',
        'default' => lf_pickup_default_text(),
        'css' => 'width: 100%; max-width: 600px; min-height: 120px;'
    ];

    $settings[] = [
        'type' => 'sectionend',
        'id' => 'lf_retrait'
    ];

    return $settings;
}
add_filter('woocommerce_shipping_settings', 'lf_pickup_setting');

function lf_pickup_instructions() {
    echo '<div class="lf-pickup">';
    echo '<h3>Instructions pour le retrait</h3>';
    echo wp_kses_post(wpautop(lf_pickup_text()));
    echo '</div>';
}
add_action('woocommerce_review_order_before_payment', 'lf_pickup_instructions');

/* =========================================================
 * 6. Compte client (IT-7)
 * ========================================================= */

function lf_account_menu($items) {
    unset($items['downloads']);
    return $items;
}
add_filter('woocommerce_account_menu_items', 'lf_account_menu');

/* =========================================================
 * 7. E-mails (IT-8)
 * ========================================================= */

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

/* =========================================================
 * 8. Statut « Prête à retirer » (IT-9)
 * ========================================================= */

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

function lf_order_bulk_action($actions) {
    $actions['mark_pret-retrait'] = 'Passer en « Prête à retirer »';
    return $actions;
}
add_filter('bulk_actions-edit-shop_order', 'lf_order_bulk_action');
add_filter('bulk_actions-woocommerce_page_wc-orders', 'lf_order_bulk_action');

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

/* =========================================================
 * 9. Équipe (IT-11)
 * ========================================================= */

function lf_team_order($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive('membre')) {
        $query->set('orderby', 'menu_order');
        $query->set('order', 'ASC');
    }
}
add_action('pre_get_posts', 'lf_team_order');

function lf_member_initials($nom) {
    $nom = remove_accents($nom);
    $mots = explode(' ', $nom);
    $initiales = substr($mots[0], 0, 1);

    if (isset($mots[1])) {
        $initiales = $initiales . substr($mots[1], 0, 1);
    }

    return strtoupper($initiales);
}

function lf_member_avatar() {
    $slug = get_post_field('post_name', get_the_ID());
    $fichier = '/assets/img/equipe/' . $slug . '.jpg';

    if (has_post_thumbnail()) {
        the_post_thumbnail('medium', ['class' => 'lf-member__photo', 'alt' => '']);
    } elseif (file_exists(get_stylesheet_directory() . $fichier)) {
        echo '<img class="lf-member__photo" src="' . esc_url(get_stylesheet_directory_uri() . $fichier) . '" width="600" height="600" alt="" loading="lazy" decoding="async">';
    } else {
        echo '<span class="lf-member__avatar" aria-hidden="true">' . esc_html(lf_member_initials(get_the_title())) . '</span>';
    }
}

/* =========================================================
 * 10. Envies (IT-12)
 * ========================================================= */

function lf_envie_navigation() {
    $envies = get_terms(['taxonomy' => 'envie', 'hide_empty' => true]);

    if (is_wp_error($envies) || empty($envies)) {
        return;
    }

    $current = 0;

    if (is_tax('envie')) {
        $current = get_queried_object_id();
    }
    ?>
    <nav class="lf-chips lf-envie-nav" aria-label="Envies">
        <span class="lf-envie-nav__label">Envie de :</span>
        <?php foreach ($envies as $envie) : ?>
            <a class="lf-chip" href="<?php echo esc_url(get_term_link($envie)); ?>" <?php if ($current === $envie->term_id) { echo 'aria-current="page"'; } ?>><?php echo esc_html($envie->name); ?></a>
        <?php endforeach; ?>
    </nav>
    <?php
}

/* =========================================================
 * 11. Ventes croisées (IT-13)
 * ========================================================= */

function lf_show_suggestions($ids, $titre) {
    if (empty($ids)) {
        return;
    }

    echo '<section class="lf-suggestions">';
    echo '<h2 class="lf-title lf-title--h3 lf-title--outlined">' . esc_html($titre) . '</h2>';
    echo '<div class="lf-recommendations">';

    $nombre = 0;

    foreach ($ids as $id) {
        if ($nombre === 3) {
            break;
        }

        $product = wc_get_product($id);

        if (!$product || !$product->is_visible()) {
            continue;
        }

        $nombre = $nombre + 1;

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
                <a class="lf-btn lf-btn--icon" href="<?php echo esc_url($product->add_to_cart_url()); ?>" aria-label="Ajouter <?php echo esc_attr($nom); ?> au panier" rel="nofollow">+</a>
            <?php else : ?>
                <a class="lf-btn lf-btn--icon" href="<?php echo esc_url($lien); ?>" aria-label="Choisir les options de <?php echo esc_attr($nom); ?>">→</a>
            <?php endif; ?>
        </article>
        <?php
    }

    echo '</div>';
    echo '</section>';
}

function lf_product_suggestions() {
    global $product;
    lf_show_suggestions($product->get_cross_sell_ids(), 'Ça va bien avec…');
}
add_action('woocommerce_after_single_product_summary', 'lf_product_suggestions', 15);

function lf_cart_suggestions() {
    lf_show_suggestions(WC()->cart->get_cross_sells(), 'Pour compléter ta commande');
}
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_after_cart', 'lf_cart_suggestions');

/* =========================================================
 * 12. Avis clients (IT-14)
 * ========================================================= */

function lf_product_reviews() {
    if (comments_open()) {
        echo '<section class="lf-reviews">';
        comments_template();
        echo '</section>';
    }
}
add_action('woocommerce_after_single_product_summary', 'lf_product_reviews', 12);

/* =========================================================
 * 13. Frais de préparation (IT-15)
 * ========================================================= */

function lf_fee_amount() {
    return (float) get_option('lf_frais_montant', 1.5);
}

function lf_fee_threshold() {
    return (float) get_option('lf_frais_seuil', 15);
}

function lf_fee_settings($settings) {
    $settings[] = [
        'title' => 'Frais de préparation',
        'type' => 'title',
        'desc' => 'Frais ajoutés automatiquement quand le sous-total du panier est inférieur au seuil.',
        'id' => 'lf_frais'
    ];

    $settings[] = [
        'title' => 'Montant des frais (€)',
        'id' => 'lf_frais_montant',
        'type' => 'number',
        'default' => '1.5',
        'custom_attributes' => ['min' => '0', 'step' => '0.1']
    ];

    $settings[] = [
        'title' => 'Seuil (€)',
        'id' => 'lf_frais_seuil',
        'type' => 'number',
        'default' => '15',
        'custom_attributes' => ['min' => '0', 'step' => '1']
    ];

    $settings[] = [
        'type' => 'sectionend',
        'id' => 'lf_frais'
    ];

    return $settings;
}
add_filter('woocommerce_shipping_settings', 'lf_fee_settings');

function lf_add_preparation_fee($cart) {
    if ($cart->get_subtotal() > 0 && $cart->get_subtotal() < lf_fee_threshold()) {
        $cart->add_fee('Frais de préparation', lf_fee_amount());
    }
}
add_action('woocommerce_cart_calculate_fees', 'lf_add_preparation_fee');

function lf_fee_hint() {
    $reste = lf_fee_threshold() - WC()->cart->get_subtotal();

    if ($reste > 0) {
        echo '<p class="lf-fee-hint">Plus que ' . wp_kses_post(wc_price($reste)) . ' pour ne pas payer les frais de préparation (' . wp_kses_post(wc_price(lf_fee_amount())) . ').</p>';
    }
}
add_action('woocommerce_before_cart_totals', 'lf_fee_hint');

/* =========================================================
 * 14. Filtres de la boutique (IT-18)
 * ========================================================= */

function lf_filter_value($nom) {
    if (isset($_GET[$nom])) {
        return sanitize_text_field(wp_unslash($_GET[$nom]));
    }

    return '';
}

function lf_shop_filters() {
    $tailles = get_terms(['taxonomy' => 'pa_taille', 'hide_empty' => true]);
    $choix = lf_filter_value('filter_taille');
    $action = wc_get_page_permalink('shop');

    if (is_product_taxonomy()) {
        $action = get_term_link(get_queried_object());
    }
    ?>
    <aside class="lf-filters" aria-labelledby="lf-filters-title">
        <h2 class="lf-filters__title" id="lf-filters-title">Filtrer</h2>

        <form action="<?php echo esc_url($action); ?>" method="get">
            <p class="lf-filters__field">
                <label for="lf-search">Rechercher</label>
                <input type="search" id="lf-search" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="Ex. : cookie">
                <input type="hidden" name="post_type" value="product">
            </p>

            <fieldset class="lf-filters__field">
                <legend>Prix (€)</legend>
                <div class="lf-filters__prices">
                    <label for="lf-min-price" class="lf-visually-hidden">Prix minimum</label>
                    <input type="number" id="lf-min-price" name="min_price" min="0" step="1" placeholder="min" value="<?php echo esc_attr(lf_filter_value('min_price')); ?>">
                    <span aria-hidden="true">–</span>
                    <label for="lf-max-price" class="lf-visually-hidden">Prix maximum</label>
                    <input type="number" id="lf-max-price" name="max_price" min="0" step="1" placeholder="max" value="<?php echo esc_attr(lf_filter_value('max_price')); ?>">
                </div>
            </fieldset>

            <?php if (!is_wp_error($tailles) && !empty($tailles)) : ?>
                <fieldset class="lf-options lf-filters__field">
                    <legend>Taille</legend>
                    <div class="lf-chips">
                        <label class="lf-chip lf-chip--input"><input type="radio" name="filter_taille" value="" <?php checked($choix, ''); ?>> Toutes</label>
                        <?php foreach ($tailles as $taille) : ?>
                            <label class="lf-chip lf-chip--input"><input type="radio" name="filter_taille" value="<?php echo esc_attr($taille->slug); ?>" <?php checked($choix, $taille->slug); ?>> <?php echo esc_html($taille->name); ?></label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>
            <?php endif; ?>

            <button type="submit" class="lf-btn lf-btn--block">Voir les produits</button>
            <a class="lf-link lf-small" href="<?php echo esc_url($action); ?>">Effacer les filtres</a>
        </form>
    </aside>
    <?php
}

/* =========================================================
 * 15. Livraison selon le poids (IT-19)
 * ========================================================= */

function lf_weight_price($poids) {
    if ($poids <= (float) get_option('lf_poids_seuil_1', 1)) {
        return (float) get_option('lf_poids_prix_1', 3.9);
    }

    if ($poids <= (float) get_option('lf_poids_seuil_2', 3)) {
        return (float) get_option('lf_poids_prix_2', 5.9);
    }

    return (float) get_option('lf_poids_prix_3', 8.9);
}

function lf_weight_settings($settings) {
    $settings[] = [
        'title' => 'Livraison selon le poids',
        'type' => 'title',
        'desc' => 'Prix des modes de livraison « forfait » (ex. : Livraison à vélo) selon le poids total du panier, en kg.',
        'id' => 'lf_poids'
    ];

    $champs = [
        ['id' => 'lf_poids_seuil_1', 'libelle' => 'Tranche 1 : jusqu’à (kg)', 'defaut' => '1'],
        ['id' => 'lf_poids_prix_1', 'libelle' => 'Tranche 1 : prix (€)', 'defaut' => '3.9'],
        ['id' => 'lf_poids_seuil_2', 'libelle' => 'Tranche 2 : jusqu’à (kg)', 'defaut' => '3'],
        ['id' => 'lf_poids_prix_2', 'libelle' => 'Tranche 2 : prix (€)', 'defaut' => '5.9'],
        ['id' => 'lf_poids_prix_3', 'libelle' => 'Tranche 3 : au-delà, prix (€)', 'defaut' => '8.9']
    ];

    foreach ($champs as $champ) {
        $settings[] = [
            'title' => $champ['libelle'],
            'id' => $champ['id'],
            'type' => 'number',
            'default' => $champ['defaut'],
            'custom_attributes' => ['min' => '0', 'step' => '0.1']
        ];
    }

    $settings[] = [
        'type' => 'sectionend',
        'id' => 'lf_poids'
    ];

    return $settings;
}
add_filter('woocommerce_shipping_settings', 'lf_weight_settings');

function lf_weight_rates($rates, $package) {
    $poids = WC()->cart->get_cart_contents_weight();

    foreach ($rates as $rate) {
        if ($rate->get_method_id() === 'flat_rate') {
            $rate->set_cost(lf_weight_price($poids));
            $rate->set_label($rate->get_label() . ' · ' . wc_format_weight($poids));
        }
    }

    return $rates;
}
add_filter('woocommerce_package_rates', 'lf_weight_rates', 10, 2);

/* =========================================================
 * 16. Jour et créneau (IT-20)
 * ========================================================= */

function lf_slot_days() {
    $jours = [];

    for ($i = 0; $i < 6; $i++) {
        $date = strtotime('+' . $i . ' day', current_time('timestamp'));
        $jours[wp_date('Y-m-d', $date)] = ucfirst(wp_date('l j F', $date));
    }

    return $jours;
}

function lf_slot_hours() {
    return [
        '12:00' => '12h00 – 12h30',
        '12:30' => '12h30 – 13h00',
        '13:00' => '13h00 – 13h30',
        '19:00' => '19h00 – 19h30',
        '19:30' => '19h30 – 20h00',
        '20:00' => '20h00 – 20h30'
    ];
}

function lf_posted_value($nom) {
    if (isset($_POST[$nom])) {
        return sanitize_text_field(wp_unslash($_POST[$nom]));
    }

    return '';
}

function lf_order_slot_text($order) {
    $jour = $order->get_meta('_lf_jour');
    $heure = $order->get_meta('_lf_creneau');

    if ($jour === '' || $heure === '') {
        return '';
    }

    $heures = lf_slot_hours();
    $texte_heure = $heure;

    if (isset($heures[$heure])) {
        $texte_heure = $heures[$heure];
    }

    $texte_jour = ucfirst(wp_date('l j F', strtotime($jour)));

    return $texte_jour . ', ' . $texte_heure;
}

function lf_slot_fields() {
    $jour_choisi = lf_posted_value('lf_jour');
    $heure_choisie = lf_posted_value('lf_creneau');
    ?>
    <div class="lf-slots">
        <h3>Jour et créneau</h3>
        <p class="lf-small">Pour le retrait au restaurant comme pour la livraison.</p>

        <p class="form-row validate-required">
            <label for="lf_jour">Jour <abbr class="required" title="obligatoire">*</abbr></label>
            <select name="lf_jour" id="lf_jour" required>
                <option value="">Choisir un jour</option>
                <?php foreach (lf_slot_days() as $valeur => $libelle) : ?>
                    <option value="<?php echo esc_attr($valeur); ?>" <?php selected($jour_choisi, $valeur); ?>><?php echo esc_html($libelle); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <fieldset class="lf-options">
            <legend>Créneau horaire <abbr class="required" title="obligatoire">*</abbr></legend>
            <div class="lf-chips">
                <?php foreach (lf_slot_hours() as $valeur => $libelle) : ?>
                    <label class="lf-chip lf-chip--input">
                        <input type="radio" name="lf_creneau" value="<?php echo esc_attr($valeur); ?>" <?php checked($heure_choisie, $valeur); ?>>
                        <?php echo esc_html($libelle); ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </fieldset>
    </div>
    <?php
}
add_action('woocommerce_after_order_notes', 'lf_slot_fields');

function lf_slot_validation() {
    $jours = lf_slot_days();
    $heures = lf_slot_hours();

    if (!isset($jours[lf_posted_value('lf_jour')])) {
        wc_add_notice('Choisissez le jour du retrait ou de la livraison.', 'error');
    }

    if (!isset($heures[lf_posted_value('lf_creneau')])) {
        wc_add_notice('Choisissez un créneau horaire.', 'error');
    }
}
add_action('woocommerce_checkout_process', 'lf_slot_validation');

function lf_slot_save($order) {
    $order->update_meta_data('_lf_jour', lf_posted_value('lf_jour'));
    $order->update_meta_data('_lf_creneau', lf_posted_value('lf_creneau'));
}
add_action('woocommerce_checkout_create_order', 'lf_slot_save');

function lf_slot_display($order) {
    $texte = lf_order_slot_text($order);

    if ($texte !== '') {
        echo '<p class="lf-slot-summary"><strong>Jour et créneau :</strong> ' . esc_html($texte) . '</p>';
    }
}
add_action('woocommerce_order_details_after_order_table', 'lf_slot_display');
add_action('woocommerce_admin_order_data_after_shipping_address', 'lf_slot_display');

function lf_slot_email($order, $sent_to_admin, $plain_text) {
    $texte = lf_order_slot_text($order);

    if ($texte === '') {
        return;
    }

    if ($plain_text) {
        echo "\nJour et créneau : " . $texte . "\n";
    } else {
        echo '<p><strong>Jour et créneau :</strong> ' . esc_html($texte) . '</p>';
    }
}
add_action('woocommerce_email_before_order_table', 'lf_slot_email', 20, 3);
