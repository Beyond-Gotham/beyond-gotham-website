<?php
/**
 * Customizer module binding for style generation.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/styles.php';

/**
 * Ensures dynamic styles generated from customizer settings are output.
 */
class Beyond_Gotham_Customizer_Module_Styles extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'styles';
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
        // No controls to register; styles are generated from other modules.
    }

    /**
     * {@inheritdoc}
     */
    public function boot() {
        parent::boot();

        add_action( 'wp_enqueue_scripts', 'beyond_gotham_print_customizer_styles', 20 );
        add_action( 'customize_preview_init', 'beyond_gotham_customize_preview_js' );
    }
}
