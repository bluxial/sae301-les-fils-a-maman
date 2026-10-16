<?php defined( 'ABSPATH' ) || exit; get_header(); ?>
<section class="lf-container lf-page">
<?php while ( have_posts() ) : the_post(); ?>
    <h1 class="lf-title lf-title--h1 lf-title--outlined lf-page-title"><?php the_title(); ?></h1>
    <div class="lf-page-content"><?php the_content(); ?></div>
<?php endwhile; ?>
</section>
<?php get_footer(); ?>
