<?php
/**
 * Customizer module binding for SEO settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/seo.php';

/**
 * Registers SEO configuration within the customizer and hooks output.
 */
class Beyond_Gotham_Customizer_Module_Seo extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'seo';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 80;
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        beyond_gotham_register_seo_customizer( $wp_customize );
    }

    /**
     * {@inheritdoc}
     */
    public function boot() {
        parent::boot();

        beyond_gotham_bootstrap_seo_features();
    }
}
