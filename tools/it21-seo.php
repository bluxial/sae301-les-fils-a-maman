<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

if (!class_exists('WPSEO_Options')) {
    lf_tool_message('Activez d’abord l’extension Yoast SEO.');
    return;
}

$produits = [
    'chorizo' => [
        'Croquettes de chorizo à emporter | Les Fils à Maman',
        'Croquettes de chorizo maison servies avec salade, à partager dès 8 €. Commandez en Click & Collect et retirez-les au restaurant, Paris 9e.'
    ],
    'courgettes' => [
        'Beignets de courgettes au parmesan | Les Fils à Maman',
        'Beignets de courgettes au parmesan et fromage frais aux herbes, à partager pour 7,50 €. À commander en ligne et à retirer à Paris 9e.'
    ],
    'mimosa' => [
        'Œufs mimosa au paprika et bacon | Les Fils à Maman',
        'Les œufs mimosa de notre enfance, mayonnaise au paprika et bacon, pour 7 €. À commander en Click & Collect chez Les Fils à Maman, Paris 9e.'
    ],
    'Cordon bleu' => [
        'Cordon bleu des Fistons à emporter | Les Fils à Maman',
        'Le cordon bleu maison des Fistons et ses pommes grenaille, dès 19 €. Le plat réconfort de l’enfance, à commander en ligne, Paris 9e.'
    ],
    'Tartare' => [
        'Tartare aux deux saumons et frites | Les Fils à Maman',
        'Tartare aux deux saumons, frites et salade pour 21 €. Commandez en Click & Collect et récupérez votre plat au restaurant, Paris 9e.'
    ],
    'Bénédicte' => [
        'Œufs bénédicte du dimanche | Les Fils à Maman',
        'Œufs bénédicte, pommes grenaille et salade, servis le dimanche dès 17,50 €. Votre brunch à emporter en Click & Collect, Paris 9e.'
    ],
    'Millefeuille' => [
        'Millefeuille façon Palmito | Les Fils à Maman',
        'Millefeuille façon Palmito, mascarpone et fraises fraîches, pour 8 €. Le dessert gourmand de l’enfance, à retirer au restaurant, Paris 9e.'
    ],
    'Cookie' => [
        'Cookie de Maman et crème fouettée | Les Fils à Maman',
        'Le Cookie de Maman, fait maison et servi avec sa crème fouettée, pour 6 €. Une douceur à ajouter à votre commande Click & Collect, Paris 9e.'
    ],
    'pêche' => [
        'Une pêche d’enfer, mocktail maison | Les Fils à Maman',
        'Une pêche d’enfer : mocktail pêche, citron vert et menthe, sans alcool, pour 8 €. À ajouter à votre commande à emporter, Paris 9e.'
    ]
];

$categories = [
    'a-partager' => [
        'À partager : entrées à emporter | Les Fils à Maman',
        'Croquettes de chorizo, beignets de courgettes, œufs mimosa : nos entrées à partager, à commander en Click & Collect, Paris 9e.'
    ],
    'plats' => [
        'Plats réconfort à emporter | Les Fils à Maman',
        'Cordon bleu, tartare aux deux saumons, œufs bénédicte : les plats de notre enfance, à commander en ligne et à retirer à Paris 9e.'
    ],
    'desserts-et-boissons' => [
        'Desserts et boissons maison | Les Fils à Maman',
        'Millefeuille façon Palmito, Cookie de Maman, mocktail pêche : les douceurs maison à ajouter à votre commande Click & Collect, Paris 9e.'
    ]
];

$pages = [
    get_option('page_on_front') => [
        'Les Fils à Maman | Cuisine régressive à emporter, Paris 9e',
        'La cuisine de notre enfance revisitée, à emporter : commandez en ligne, choisissez votre créneau et retirez votre repas au restaurant, Paris 9e.'
    ],
    wc_get_page_id('shop') => [
        'La carte à emporter | Les Fils à Maman',
        'Toute la carte des Fils à Maman : entrées à partager, plats, desserts et boissons maison, en Click & Collect ou en livraison à Paris 9e.'
    ]
];

function lf_tool_check_lengths($titre, $description) {
    if (mb_strlen($titre) > 60 || mb_strlen($description) > 155) {
        lf_tool_message('Attention, texte trop long : ' . $titre);
    }
}

foreach ($produits as $mot => $textes) {
    $id = lf_tool_find_product($mot);

    if (!$id) {
        lf_tool_message('Attention : produit introuvable : ' . $mot);
        continue;
    }

    lf_tool_check_lengths($textes[0], $textes[1]);
    update_post_meta($id, '_yoast_wpseo_title', $textes[0]);
    update_post_meta($id, '_yoast_wpseo_metadesc', $textes[1]);
    wp_update_post(['ID' => $id]);
    lf_tool_message('Produit : ' . get_the_title($id));
}

foreach ($categories as $slug => $textes) {
    $categorie = get_term_by('slug', $slug, 'product_cat');

    if (!$categorie) {
        lf_tool_message('Attention : catégorie introuvable : ' . $slug);
        continue;
    }

    lf_tool_check_lengths($textes[0], $textes[1]);
    WPSEO_Taxonomy_Meta::set_values($categorie->term_id, 'product_cat', [
        'wpseo_title' => $textes[0],
        'wpseo_desc' => $textes[1]
    ]);
    wp_update_term($categorie->term_id, 'product_cat');
    lf_tool_message('Catégorie : ' . $categorie->name);
}

foreach ($pages as $id => $textes) {
    lf_tool_check_lengths($textes[0], $textes[1]);
    update_post_meta($id, '_yoast_wpseo_title', $textes[0]);
    update_post_meta($id, '_yoast_wpseo_metadesc', $textes[1]);
    wp_update_post(['ID' => $id]);
    lf_tool_message('Page : ' . get_the_title($id));
}

$logo = 0;

foreach (get_posts(['post_type' => 'attachment', 'numberposts' => -1]) as $media) {
    if (basename(get_attached_file($media->ID)) === 'logo-les-fils-a-maman.png') {
        $logo = $media->ID;
    }
}

WPSEO_Options::set('company_or_person', 'company');
WPSEO_Options::set('company_name', 'Les Fils à Maman');
WPSEO_Options::set('opengraph', true);

if ($logo) {
    WPSEO_Options::set('company_logo', wp_get_attachment_url($logo));
    WPSEO_Options::set('company_logo_id', $logo);
    WPSEO_Options::set('og_default_image', wp_get_attachment_url($logo));
    WPSEO_Options::set('og_default_image_id', $logo);
}

lf_tool_message('SEO configuré');
