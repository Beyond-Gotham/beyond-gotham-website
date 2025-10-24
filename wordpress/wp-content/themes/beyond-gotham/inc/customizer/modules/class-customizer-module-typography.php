<?php
/**
 * Customizer module binding for typography settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/typography.php';

/**
 * Registers typography settings with the customizer.
 */
class Beyond_Gotham_Customizer_Module_Typography extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'typography';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 20;
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        beyond_gotham_register_typography_customizer( $wp_customize );
    }
}
