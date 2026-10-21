<?php
if (!defined('ABSPATH')) {
    exit;
}

// IT-18 : barre latérale de filtres de la boutique (recherche, prix, taille).
// Le formulaire utilise les paramètres reconnus par WooCommerce :
// s (recherche), min_price / max_price (prix) et filter_taille (attribut Taille).

// Valeur d'un filtre dans l'adresse de la page (texte vide si le filtre n'est pas utilisé).
function lf_filter_value($nom) {
    if (isset($_GET[$nom])) {
        return sanitize_text_field(wp_unslash($_GET[$nom]));
    }

    return '';
}

// Le formulaire de filtres (appelé dans archive-product.php).
// Il renvoie vers la page affichée (boutique ou catégorie) avec les filtres dans l'adresse.
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
                        <label class="lf-chip has-input"><input type="radio" name="filter_taille" value="" <?php checked($choix, ''); ?>> Toutes</label>
                        <?php foreach ($tailles as $taille) : ?>
                            <label class="lf-chip has-input"><input type="radio" name="filter_taille" value="<?php echo esc_attr($taille->slug); ?>" <?php checked($choix, $taille->slug); ?>> <?php echo esc_html($taille->name); ?></label>
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
