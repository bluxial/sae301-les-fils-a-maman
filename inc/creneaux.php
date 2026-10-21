<?php
if (!defined('ABSPATH')) {
    exit;
}

function lf_slot_days() {
    $jours = [];

    for ($i = 0; $i < 6; $i++) {
        $date = strtotime('+' . $i . ' day', current_time('timestamp'));
        $jours[wp_date('Y-m-d', $date)] = ucfirst(wp_date('l j F', $date));
    }

    return $jours;
}

function lf_slot_hours() {
    return [
        '12:00' => '12h00 – 12h30',
        '12:30' => '12h30 – 13h00',
        '13:00' => '13h00 – 13h30',
        '19:00' => '19h00 – 19h30',
        '19:30' => '19h30 – 20h00',
        '20:00' => '20h00 – 20h30'
    ];
}

function lf_posted_value($nom) {
    if (isset($_POST[$nom])) {
        return sanitize_text_field(wp_unslash($_POST[$nom]));
    }

    return '';
}

function lf_order_slot_text($order) {
    $jour = $order->get_meta('_lf_jour');
    $heure = $order->get_meta('_lf_creneau');

    if ($jour === '' || $heure === '') {
        return '';
    }

    $heures = lf_slot_hours();
    $texte_heure = $heure;

    if (isset($heures[$heure])) {
        $texte_heure = $heures[$heure];
    }

    $texte_jour = ucfirst(wp_date('l j F', strtotime($jour)));

    return $texte_jour . ', ' . $texte_heure;
}

function lf_slot_fields() {
    $jour_choisi = lf_posted_value('lf_jour');
    $heure_choisie = lf_posted_value('lf_creneau');
    ?>
    <div class="lf-slots">
        <h3>Jour et créneau</h3>
        <p class="lf-small">Pour le retrait au restaurant comme pour la livraison.</p>

        <p class="form-row validate-required">
            <label for="lf_jour">Jour <abbr class="required" title="obligatoire">*</abbr></label>
            <select name="lf_jour" id="lf_jour" required>
                <option value="">Choisir un jour</option>
                <?php foreach (lf_slot_days() as $valeur => $libelle) : ?>
                    <option value="<?php echo esc_attr($valeur); ?>" <?php selected($jour_choisi, $valeur); ?>><?php echo esc_html($libelle); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <fieldset class="lf-options">
            <legend>Créneau horaire <abbr class="required" title="obligatoire">*</abbr></legend>
            <div class="lf-chips">
                <?php foreach (lf_slot_hours() as $valeur => $libelle) : ?>
                    <label class="lf-chip has-input">
                        <input type="radio" name="lf_creneau" value="<?php echo esc_attr($valeur); ?>" <?php checked($heure_choisie, $valeur); ?>>
                        <?php echo esc_html($libelle); ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </fieldset>
    </div>
    <?php
}
add_action('woocommerce_after_order_notes', 'lf_slot_fields');

function lf_slot_validation() {
    $jours = lf_slot_days();
    $heures = lf_slot_hours();

    if (!isset($jours[lf_posted_value('lf_jour')])) {
        wc_add_notice('Choisissez le jour du retrait ou de la livraison.', 'error');
    }

    if (!isset($heures[lf_posted_value('lf_creneau')])) {
        wc_add_notice('Choisissez un créneau horaire.', 'error');
    }
}
add_action('woocommerce_checkout_process', 'lf_slot_validation');

function lf_slot_save($order) {
    $order->update_meta_data('_lf_jour', lf_posted_value('lf_jour'));
    $order->update_meta_data('_lf_creneau', lf_posted_value('lf_creneau'));
}
add_action('woocommerce_checkout_create_order', 'lf_slot_save');

function lf_slot_display($order) {
    $texte = lf_order_slot_text($order);

    if ($texte !== '') {
        echo '<p class="lf-slot-summary"><strong>Jour et créneau :</strong> ' . esc_html($texte) . '</p>';
    }
}
add_action('woocommerce_order_details_after_order_table', 'lf_slot_display');
add_action('woocommerce_admin_order_data_after_shipping_address', 'lf_slot_display');

function lf_slot_email($order, $sent_to_admin, $plain_text) {
    $texte = lf_order_slot_text($order);

    if ($texte === '') {
        return;
    }

    if ($plain_text) {
        echo "\nJour et créneau : " . $texte . "\n";
    } else {
        echo '<p><strong>Jour et créneau :</strong> ' . esc_html($texte) . '</p>';
    }
}
add_action('woocommerce_email_before_order_table', 'lf_slot_email', 20, 3);
