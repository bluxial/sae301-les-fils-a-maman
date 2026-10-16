<?php defined( 'ABSPATH' ) || exit; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="lf-skip" href="#content">Aller au contenu</a>
<div id="page" class="lf-site">
<header class="lf-header lf-site-header">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Les Fils à Maman — accueil"><img src="<?php echo esc_url( lf_asset( '8594c.svg' ) ); ?>" width="112" height="56" alt="Les Fils à Maman"></a>
    <nav class="lf-header__nav" id="lf-primary-nav" aria-label="Navigation principale">
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">La carte</a>
        <a href="<?php echo esc_url( home_url( '/#comment-ca-marche' ) ); ?>">Comment ça marche</a>
        <a href="<?php echo esc_url( home_url( '/#notre-restaurant' ) ); ?>">Notre restaurant</a>
    </nav>
    <div class="lf-header__actions">
        <a class="lf-chip lf-location" href="<?php echo esc_url( home_url( '/#notre-restaurant' ) ); ?>">📍 Paris 9e</a>
        <a class="lf-btn lf-btn--ghost" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">Mon compte</a>
        <a class="lf-btn" href="<?php echo esc_url( wc_get_cart_url() ); ?>">Panier · <span class="lf-cart-count"><?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?></span></a>
        <button class="lf-menu" type="button" aria-label="Ouvrir le menu" aria-controls="lf-primary-nav" aria-expanded="false">☰</button>
    </div>
</header>
<main id="content" class="lf-site-main" tabindex="-1">
