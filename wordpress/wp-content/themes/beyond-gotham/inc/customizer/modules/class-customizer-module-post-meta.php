<?php
/**
 * Customizer module binding for post meta visibility settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/post-meta.php';

if ( ! function_exists( 'beyond_gotham_register_post_meta_customizer' ) ) {
    if ( function_exists( '_doing_it_wrong' ) ) {
        _doing_it_wrong(
            'Beyond_Gotham_Customizer_Module_Post_Meta',
            __( 'Post meta customizer module requires the registration callback to be available.', 'beyond_gotham' ),
            defined( 'BEYOND_GOTHAM_VERSION' ) ? BEYOND_GOTHAM_VERSION : '0.1.0'
        );
    }

    return;
}

/**
 * Registers post meta controls with the customizer.
 */
class Beyond_Gotham_Customizer_Module_Post_Meta extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'post-meta';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 55;
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        beyond_gotham_register_post_meta_customizer( $wp_customize );
    }
}
