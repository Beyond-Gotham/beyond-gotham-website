<?php
/**
 * Customizer module binding for post meta visibility settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Load the shared helper definitions if the theme bootstrap did not do it already.
if ( ! defined( 'BEYOND_GOTHAM_POST_META_LOADED' ) ) {
    require_once dirname( __DIR__ ) . '/post-meta.php';
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
