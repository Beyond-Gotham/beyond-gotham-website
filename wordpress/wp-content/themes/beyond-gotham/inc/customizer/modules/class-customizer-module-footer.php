<?php
/**
 * Customizer module binding for footer settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/footer.php';

/**
 * Registers footer controls with the customizer.
 */
class Beyond_Gotham_Customizer_Module_Footer extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'footer';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 40;
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        beyond_gotham_register_footer_customizer( $wp_customize );
    }
}
