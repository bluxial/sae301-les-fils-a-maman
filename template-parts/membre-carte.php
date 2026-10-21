<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<li class="lf-member lf-member--<?php echo esc_attr(get_field('couleur')); ?>">
    <a href="<?php the_permalink(); ?>">
        <?php lf_member_avatar(); ?>
        <h2 class="lf-member__name"><?php the_title(); ?></h2>
        <p class="lf-member__role"><?php echo esc_html(get_field('poste')); ?></p>
        <span class="lf-link">Voir le profil</span>
    </a>
</li>
