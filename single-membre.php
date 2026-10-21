<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header();

while (have_posts()) :
    the_post();
    ?>
    <article class="lf-container lf-page lf-member-page">
        <a class="lf-link" href="<?php echo esc_url(get_post_type_archive_link('membre')); ?>">← Toute l’équipe</a>

        <div class="lf-member-page__grid lf-member--<?php echo esc_attr(get_field('couleur')); ?>">
            <div class="lf-member-page__visual">
                <?php lf_member_avatar(); ?>
            </div>

            <div>
                <p class="lf-member__role"><?php echo esc_html(get_field('poste')); ?></p>
                <h1 class="lf-title lf-title--h1 lf-title--outlined lf-page-title"><?php the_title(); ?></h1>

                <div class="lf-page-content">
                    <?php the_content(); ?>
                </div>

                <?php if (get_field('plat_prefere')) : ?>
                    <dl class="lf-facts">
                        <div>
                            <dt>Plat préféré</dt>
                            <dd><?php echo esc_html(get_field('plat_prefere')); ?></dd>
                        </div>
                    </dl>
                <?php endif; ?>
            </div>
        </div>
    </article>
    <?php
endwhile;

get_footer();
