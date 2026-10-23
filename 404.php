<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header();
?>
<section class="lf-container lf-page lf-page--404">
    <h1 class="lf-title lf-title--h1 lf-title--outlined lf-page-title">Oups&nbsp;!</h1>
    <div class="lf-page-content lf-page-content--texte">
        <h2>Cette page est introuvable.</h2>
        <p>La recette que tu cherches n’est plus au menu. Retourne à la carte ou reviens à l’accueil.</p>
        <p class="lf-page__actions">
            <a class="lf-btn" href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Voir la carte</a>
            <a class="lf-btn lf-btn--secondary" href="<?php echo esc_url(home_url('/')); ?>">Accueil</a>
        </p>
    </div>
</section>
<?php
get_footer();
