<?php defined( 'ABSPATH' ) || exit; ?>
</main>
<footer class="lf-footer lf-site-footer">
    <div class="lf-footer__brand"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( lf_asset( '935e4.svg' ) ); ?>" width="160" height="80" alt="Les Fils à Maman"></a><p>Les Fils à Maman, c’est la cuisine régressive de notre enfance, revisitée avec gourmandise et à emporter.</p></div>
    <nav aria-label="Click & Collect"><h2>CLICK & COLLECT</h2><ul><li><a href="<?php echo esc_url( home_url( '/#comment-ca-marche' ) ); ?>">Comment ça marche</a></li><li><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">Mon compte</a></li><li><a href="<?php echo esc_url( wc_get_cart_url() ); ?>">Mon panier</a></li></ul></nav>
    <div id="notre-restaurant"><h2>NOTRE RESTAURANT</h2><p>Paris 9e</p><address>7 bis rue Geoffroy-Marie<br>75009 Paris</address><p class="lf-small lf-footer-note">Projet pédagogique SAE 3.01.<br>Les commandes sont des tests.</p></div>
    <nav aria-label="Informations"><h2>INFOS</h2><ul><li><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Toute la carte</a></li><li><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">Suivre mes commandes</a></li><?php if ( get_privacy_policy_url() ) : ?><li><a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">Confidentialité</a></li><?php endif; ?></ul></nav>
</footer>
<?php if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_front_page() ) ) { lf_mobile_cartbar(); } ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
