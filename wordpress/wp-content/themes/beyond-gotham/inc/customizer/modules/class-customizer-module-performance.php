<?php
/**
 * Customizer module binding for performance settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/performance.php';

/**
 * Registers performance toggles within the customizer and runtime.
 */
class Beyond_Gotham_Customizer_Module_Performance extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'performance';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 60;
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        beyond_gotham_register_performance_customizer( $wp_customize );
    }

    /**
     * {@inheritdoc}
     */
    public function boot() {
        parent::boot();

        beyond_gotham_bootstrap_performance_features();
    }
}
