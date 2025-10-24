<?php
/**
 * Customizer module binding for color settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/colors.php';

/**
 * Registers the color settings with the WordPress customizer.
 */
class Beyond_Gotham_Customizer_Module_Colors extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'colors';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 15;
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        beyond_gotham_register_colors_customizer( $wp_customize );
    }
}
