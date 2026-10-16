<?php
/** À exécuter avec wp eval-file après sauvegarde : installation idempotente des contenus IT-2. */
defined( 'WP_CLI' ) && WP_CLI || exit;
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$specs = array(
    array( 'Croquettes de chorizo', 'croquettes-de-chorizo', '9b0f5.png', 'Salade', 0 ),
    array( 'Beignets de courgettes au parmesan', 'beignets-de-courgettes-au-parmesan', 'e2429.png', 'Fromage frais aux herbes', 1 ),
    array( 'Œufs mimosa', 'oeufs-mimosa', '5f33c.png', 'Mayonnaise au paprika, bacon', 2 ),
    array( 'Cordon bleu des Fistons', 'cordon-bleu-des-fistons', '3dd74.png', 'Pommes grenaille', 3 ),
    array( 'Tartare aux deux saumons', 'tartare-aux-deux-saumons', '6556c.png', 'Frites et salade', 4 ),
    array( 'Œufs bénédicte', 'oeufs-benedicte', '91651.png', 'Pommes grenaille et salade · le dimanche', 5 ),
    array( 'Millefeuille façon Palmito', 'millefeuille-facon-palmito', '6bd9c.png', 'Mascarpone et fraises fraîches', 6 ),
    array( 'Cookie de Maman', 'cookie-de-maman', 'ba98e.png', 'Cookie maison, crème fouettée', 7 ),
    array( "Une pêche d'enfer", 'une-peche-denfer', 'cbcf3.png', 'Mocktail pêche, citron vert et menthe', 8 ),
);
$products = wc_get_products( array( 'limit' => -1, 'status' => 'publish' ) );
$report = array();
foreach ( $specs as list( $name, $slug, $file, $short, $order ) ) {
    $matches = array_values( array_filter( $products, function ( $p ) use ( $name ) { return sanitize_title( $p->get_name() ) === sanitize_title( $name ); } ) );
    if ( count( $matches ) !== 1 ) { WP_CLI::error( 'Produit absent ou ambigu : ' . $name ); }
    $product = $matches[0];
    $existing = get_posts( array( 'post_type' => 'attachment', 'post_status' => 'inherit', 'meta_key' => '_lf_source_asset', 'meta_value' => $file, 'fields' => 'ids', 'numberposts' => 1 ) );
    if ( $product->get_image_id() ) { $image_id = $product->get_image_id(); }
    elseif ( $existing ) { $image_id = $existing[0]; }
    else {
        $tmp = wp_tempnam( $file );
        copy( dirname( __DIR__ ) . '/assets/' . $file, $tmp );
        $image_id = media_handle_sideload( array( 'name' => $slug . '.png', 'tmp_name' => $tmp ), $product->get_id(), $name );
        if ( is_wp_error( $image_id ) ) { @unlink( $tmp ); WP_CLI::error( $image_id->get_error_message() ); }
        update_post_meta( $image_id, '_lf_source_asset', $file );
        update_post_meta( $image_id, '_wp_attachment_image_alt', $name );
    }
    $product->set_image_id( $image_id );
    $product->set_slug( $slug );
    if ( ! $product->get_short_description() ) { $product->set_short_description( $short ); }
    $product->set_menu_order( $order );
    $product->save();
    $report[] = array( 'id' => $product->get_id(), 'slug' => $product->get_slug(), 'image' => $image_id, 'price' => $product->get_price() );
}
foreach ( array( 'a-partager' => 'Croquettes de chorizo', 'plats' => 'Cordon bleu des Fistons', 'desserts-et-boissons' => 'Millefeuille façon Palmito' ) as $slug => $name ) {
    $term = get_term_by( 'slug', $slug, 'product_cat' );
    if ( ! $term || get_term_meta( $term->term_id, 'thumbnail_id', true ) ) { continue; }
    foreach ( $products as $p ) { if ( $p->get_name() === $name ) { update_term_meta( $term->term_id, 'thumbnail_id', $p->get_image_id() ); } }
}
$page = get_page_by_path( 'click-collect' );
$front_id = $page ? $page->ID : wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Click & Collect', 'post_name' => 'click-collect', 'post_content' => '' ), true );
if ( is_wp_error( $front_id ) ) { WP_CLI::error( $front_id->get_error_message() ); }
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $front_id );
flush_rewrite_rules();
echo wp_json_encode( array( 'products' => $report, 'front_page_id' => $front_id, 'theme' => get_stylesheet() ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
