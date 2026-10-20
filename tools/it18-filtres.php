<?php
/**
 * IT-18 : attribut global « Taille » (Petite faim / Grosse faim) pour filtrer les produits.
 * À lancer depuis le dossier du site :
 * ddev wp eval-file wp-content/themes/les-fils-a-maman/tools/it18-filtres.php
 * Ou en local dans le navigateur : https://sae301.ddev.site/?lf_outil=it18-filtres
 */
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/outils.php';

// Les filtres sont mis à jour tout de suite quand un produit est enregistré.
update_option('woocommerce_attribute_lookup_enabled', 'yes');
update_option('woocommerce_attribute_lookup_direct_updates', 'yes');

// 1. L'attribut « Taille » (Produits → Attributs).
$attribute_id = wc_attribute_taxonomy_id_by_name('taille');

if (!$attribute_id) {
    $attribute_id = wc_create_attribute(['name' => 'Taille', 'slug' => 'taille', 'has_archives' => false]);
}

// La taxonomie pa_taille doit exister dans cette requête pour ajouter les termes.
register_taxonomy('pa_taille', 'product', ['hierarchical' => false]);

$tailles = [
    'Petite faim' => ['chorizo', 'courgettes', 'mimosa', 'Cookie', 'pêche', 'Millefeuille'],
    'Grosse faim' => ['Cordon bleu', 'Tartare', 'Bénédicte']
];

foreach ($tailles as $taille => $mots) {
    if (!term_exists($taille, 'pa_taille')) {
        wp_insert_term($taille, 'pa_taille');
    }

    $terme = get_term_by('name', $taille, 'pa_taille');

    foreach ($mots as $mot) {
        $product = wc_get_product(lf_tool_find_product($mot));

        if (!$product) {
            lf_tool_message('Attention : produit introuvable : ' . $mot);
            continue;
        }

        // 2. On ajoute « Taille » aux attributs déjà présents (ex. : Portion des croquettes).
        $attributs = $product->get_attributes();

        $attribut = new WC_Product_Attribute();
        $attribut->set_id($attribute_id);
        $attribut->set_name('pa_taille');
        $attribut->set_options([$terme->term_id]);
        $attribut->set_visible(true);
        $attribut->set_variation(false);

        $attributs['pa_taille'] = $attribut;
        $product->set_attributes($attributs);
        $product->save();

        wp_set_object_terms($product->get_id(), [$terme->term_id], 'pa_taille');
    }

    lf_tool_message('OK : ' . $taille . ' : ' . count($mots) . ' produits');
}
