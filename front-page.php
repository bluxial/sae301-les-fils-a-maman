<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header();
?>

<section class="lf-hero" aria-labelledby="lf-hero-title">
    <img src="<?php echo esc_url(lf_asset('bf199.png')); ?>" alt="La salle du restaurant, ses jouets et ses souvenirs rétro" fetchpriority="high" width="1440" height="560">

    <div class="lf-hero__content">
        <p class="lf-script">Tu commandes, on cuisine,</p>
        <h1 class="lf-title lf-title--hero" id="lf-hero-title">CLICK & COLLECT</h1>
        <p class="lf-large">Ta cuisine d’enfance à emporter : découvre la carte et compose ton panier avec tes plats préférés.</p>

        <div class="lf-hero__buttons">
            <a class="lf-btn" href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Voir la carte</a>
            <a class="lf-btn lf-btn--secondary" href="#notre-restaurant">Notre restaurant</a>
        </div>
    </div>

    <div class="lf-stamp" aria-hidden="true">100 %<br>FAIT<br>MAISON</div>
</section>

<section class="lf-steps" id="comment-ca-marche" aria-label="Comment ça marche">
    <div class="lf-step">
        <span class="lf-step__number">1</span>
        <div>
            <h2>Je découvre la carte</h2>
            <p>mes recettes d’enfance préférées</p>
        </div>
    </div>

    <div class="lf-step">
        <span class="lf-step__number">2</span>
        <div>
            <h2>Je compose mon panier</h2>
            <p>plats, douceurs et boissons</p>
        </div>
    </div>

    <div class="lf-step">
        <span class="lf-step__number">3</span>
        <div>
            <h2>Je prépare mon retrait</h2>
            <p>au restaurant Paris 9e</p>
        </div>
    </div>
</section>

<?php
// IT-16 : les 3 derniers produits ajoutés au catalogue.
global $post;
$nouveautes = wc_get_products([
    'status' => 'publish',
    'limit' => 3,
    'orderby' => 'date',
    'order' => 'DESC',
    'return' => 'ids'
]);
?>

<?php if (!empty($nouveautes)) : ?>
    <section class="lf-container lf-catalogue-page lf-home-latest" aria-labelledby="lf-latest-title">
        <div class="lf-section-heading">
            <div>
                <p class="lf-script">tout juste arrivés</p>
                <h2 class="lf-title lf-title--h1 lf-title--outlined" id="lf-latest-title">LES NOUVEAUTÉS</h2>
            </div>
        </div>

        <?php
        woocommerce_product_loop_start();

        foreach ($nouveautes as $id) {
            $post = get_post($id);
            setup_postdata($post);
            wc_get_template_part('content', 'product');
        }

        woocommerce_product_loop_end();
        wp_reset_postdata();
        ?>
    </section>
<?php endif; ?>

<section class="lf-container lf-home-categories" aria-labelledby="lf-menu-title">
    <div class="lf-section-heading">
        <div>
            <p class="lf-script">qu’est-ce qui te ferait plaisir ?</p>
            <h2 class="lf-title lf-title--h1 lf-title--outlined" id="lf-menu-title">LA CARTE À EMPORTER</h2>
        </div>
        <img src="<?php echo esc_url(lf_asset('21df4.svg')); ?>" width="107.777" height="140.001" alt="" aria-hidden="true">
    </div>

    <div class="lf-category-grid">
        <?php
        foreach (lf_categories() as $category) :
            $key = lf_category_key($category);
            $products = wc_get_products([
                'category' => [$category->slug],
                'status' => 'publish',
                'limit' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ]);
            $image = get_term_meta($category->term_id, 'thumbnail_id', true);
            $crop = '';
            $minimum = 0;

            if (!empty($products)) {
                $first = $products[0];
                $crop = lf_crop_class($first);
                $minimum = wc_get_price_to_display($first);

                if (!$image) {
                    $image = $first->get_image_id();
                }

                foreach ($products as $product) {
                    $price = wc_get_price_to_display($product);

                    if ($price < $minimum) {
                        $minimum = $price;
                    }
                }
            }
            ?>
            <article class="lf-category lf-category--<?php echo esc_attr($key); ?>">
                <a class="lf-photo <?php echo esc_attr($crop); ?>" href="<?php echo esc_url(get_term_link($category)); ?>" aria-label="Voir <?php echo esc_attr($category->name); ?>">
                    <?php echo wp_get_attachment_image($image, 'large', false, ['alt' => $category->name]); ?>
                </a>

                <div class="lf-category__body">
                    <p class="lf-script"><?php echo esc_html(lf_category_script($key)); ?></p>
                    <h3 class="lf-title"><?php echo esc_html($category->name); ?></h3>

                    <div class="lf-card__bottom">
                        <span><?php echo esc_html($category->count); ?> produits · dès <?php echo wp_kses_post(wc_price($minimum)); ?></span>
                        <a class="lf-btn lf-btn--secondary" href="<?php echo esc_url(get_term_link($category)); ?>" aria-label="Voir <?php echo esc_attr($category->name); ?>">Voir →</a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<?php get_footer(); ?>
