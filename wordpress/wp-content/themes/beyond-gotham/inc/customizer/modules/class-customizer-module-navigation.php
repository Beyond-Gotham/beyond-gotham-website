<?php
/**
 * Customizer module binding for navigation layout settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/navigation.php';

/**
 * Registers navigation layout controls with the customizer.
 */
class Beyond_Gotham_Customizer_Module_Navigation extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'navigation';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 25;
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        beyond_gotham_register_navigation_customizer( $wp_customize );
    }
}
