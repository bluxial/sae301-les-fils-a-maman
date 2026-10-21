<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header();

while (have_posts()) :
    the_post();
    $classe = 'lf-page-content';

    if (!is_cart() && !is_checkout() && !is_account_page()) {
        $classe = 'lf-page-content lf-page-content--texte';
    }
    ?>
    <section class="lf-container lf-page">
        <h1 class="lf-title lf-title--h1 lf-title--outlined lf-page-title"><?php the_title(); ?></h1>
        <div class="<?php echo esc_attr($classe); ?>">
            <?php the_content(); ?>
        </div>
    </section>
<?php
endwhile;

get_footer();
