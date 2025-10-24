<?php
/**
 * Customizer module binding for layout options.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/layout.php';

/**
 * Registers layout controls with the customizer.
 */
class Beyond_Gotham_Customizer_Module_Layout extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'layout';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 30;
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        beyond_gotham_register_layout_customizer( $wp_customize );
    }
}
