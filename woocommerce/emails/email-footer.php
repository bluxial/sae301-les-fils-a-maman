<?php
/**
 * Pied des e-mails (copie simplifiée du modèle WooCommerce emails/email-footer.php 10.4.0).
 * Adresse du restaurant et texte de pied réglable dans WooCommerce → Réglages → E-mails.
 */
if (!defined('ABSPATH')) {
    exit;
}

$email = $email ?? null;
$footer_text = apply_filters('woocommerce_email_footer_text', get_option('woocommerce_email_footer_text'), $email);
?>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="10" cellspacing="0" width="100%" id="template_footer" role="presentation">
                                        <tr>
                                            <td valign="top">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%" role="presentation">
                                                    <tr>
                                                        <td colspan="2" valign="middle" id="credit">
                                                            <p><strong>Les Fils à Maman Paris 9e</strong><br>7 bis rue Geoffroy-Marie, 75009 Paris</p>
                                                            <?php echo wp_kses_post(wpautop(wptexturize($footer_text))); ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td></td>
            </tr>
        </table>
    </body>
</html>
