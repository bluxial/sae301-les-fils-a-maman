<?php
if (!defined('ABSPATH')) {
    exit;
}

// Chaque fichier du dossier inc/ correspond à une partie du site.
require_once get_stylesheet_directory() . '/inc/setup.php';              // IT-1/2 : réglages du thème, CSS et JS
require_once get_stylesheet_directory() . '/inc/catalogue.php';          // IT-2 : catégories et cartes produits
require_once get_stylesheet_directory() . '/inc/produits-variables.php'; // IT-3 : produits variables
require_once get_stylesheet_directory() . '/inc/champs-produits.php';    // IT-4 : composition, allergènes
require_once get_stylesheet_directory() . '/inc/retrait.php';            // IT-6 : instructions pour le retrait
require_once get_stylesheet_directory() . '/inc/compte-client.php';      // IT-7 : menu du compte client
require_once get_stylesheet_directory() . '/inc/emails.php';             // IT-8 : e-mails
require_once get_stylesheet_directory() . '/inc/commandes.php';          // IT-9 : statut « Prête à retirer »
require_once get_stylesheet_directory() . '/inc/equipe.php';             // IT-11 : pages de l'équipe
require_once get_stylesheet_directory() . '/inc/envies.php';             // IT-12 : taxonomie Envies
require_once get_stylesheet_directory() . '/inc/ventes-croisees.php';    // IT-13 : ventes croisées
require_once get_stylesheet_directory() . '/inc/avis.php';               // IT-14 : avis clients
require_once get_stylesheet_directory() . '/inc/frais-preparation.php';  // IT-15 : frais de préparation
require_once get_stylesheet_directory() . '/inc/filtres.php';            // IT-18 : filtres de la boutique
require_once get_stylesheet_directory() . '/inc/livraison-poids.php';    // IT-19 : livraison selon le poids
require_once get_stylesheet_directory() . '/inc/creneaux.php';           // IT-20 : jour et créneau
