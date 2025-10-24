<?php
/**
 * Customizer module binding for logo settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/logo.php';

/**
 * Registers logo settings within the customizer.
 */
class Beyond_Gotham_Customizer_Module_Logo extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'logo';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 10;
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        beyond_gotham_register_logo_customizer( $wp_customize );
    }

    /**
     * {@inheritdoc}
     */
    public function boot() {
        parent::boot();

        add_action( 'wp_head', 'beyond_gotham_render_brand_favicon', 1 );
    }
}
