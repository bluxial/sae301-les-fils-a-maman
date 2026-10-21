<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header();
?>

<section class="lf-container lf-page">
    <h1 class="lf-title lf-title--h1 lf-title--outlined lf-page-title">L’équipe</h1>
    <p class="lf-team-intro">Ceux qui cuisinent, préparent et vous accueillent au comptoir du Click &amp; Collect.</p>

    <?php if (have_posts()) : ?>
        <ul class="lf-team">
            <?php while (have_posts()) : ?>
                <?php the_post(); ?>
                <?php get_template_part('template-parts/membre', 'carte'); ?>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p>L’équipe arrive bientôt.</p>
    <?php endif; ?>
</section>

<?php
get_footer();
