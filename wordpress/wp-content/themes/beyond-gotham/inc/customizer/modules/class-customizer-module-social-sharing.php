<?php
/**
 * Customizer module binding for social sharing settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/social-sharing.php';

/**
 * Registers social sharing controls with the customizer.
 */
class Beyond_Gotham_Customizer_Module_Social_Sharing extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'social-sharing';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 50;
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        beyond_gotham_register_social_sharing_customizer( $wp_customize );
    }
}
