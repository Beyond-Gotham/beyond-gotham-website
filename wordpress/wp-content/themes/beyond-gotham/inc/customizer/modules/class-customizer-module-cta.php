<?php
/**
 * Customizer module binding for CTA settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/cta.php';

/**
 * Registers CTA controls with the customizer.
 */
class Beyond_Gotham_Customizer_Module_Cta extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'cta';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 35;
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        beyond_gotham_register_cta_customizer( $wp_customize );
    }
}
