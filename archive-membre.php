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
                <li class="lf-member lf-member--<?php echo esc_attr(lf_member_field('couleur')); ?>">
                    <a href="<?php the_permalink(); ?>">
                        <?php lf_member_avatar(); ?>
                        <h2 class="lf-member__name"><?php the_title(); ?></h2>
                        <p class="lf-member__role"><?php echo esc_html(lf_member_field('poste')); ?></p>
                        <span class="lf-link">Voir le profil</span>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p>L’équipe arrive bientôt.</p>
    <?php endif; ?>
</section>

<?php
get_footer();
