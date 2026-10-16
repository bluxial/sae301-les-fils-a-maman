<?php defined( 'ABSPATH' ) || exit; get_header(); ?>
<section class="lf-container lf-page">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article><h1 class="lf-title lf-title--h1 lf-title--outlined"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1><?php the_content(); ?></article>
<?php endwhile; else : ?><h1 class="lf-title lf-title--h1">Rien par ici…</h1><a class="lf-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">Retour à la carte</a><?php endif; ?>
</section>
<?php get_footer(); ?>
