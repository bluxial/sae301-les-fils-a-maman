<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header();

while (have_posts()) :
    the_post();
    ?>
    <section class="lf-container lf-page">
        <h1 class="lf-title lf-title--h1 lf-title--outlined lf-page-title"><?php the_title(); ?></h1>
        <div class="lf-page-content">
            <?php the_content(); ?>
        </div>
    </section>
<?php
endwhile;

get_footer();
