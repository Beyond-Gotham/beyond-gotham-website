<?php
/**
 * Customizer module binding for social bar settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/social.php';

/**
 * Registers social bar controls with the customizer.
 */
class Beyond_Gotham_Customizer_Module_Social extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'social';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 45;
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        beyond_gotham_register_social_customizer( $wp_customize );
    }
}
