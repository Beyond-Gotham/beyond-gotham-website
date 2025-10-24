<?php
/**
 * Interface for Beyond Gotham Customizer modules.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Defines the contract for customizer modules that can be loaded by the loader.
 */
interface Beyond_Gotham_Customizer_Module_Interface {
    /**
     * Unique identifier for the module.
     *
     * @return string
     */
    public function get_id();

    /**
     * Priority for registering the module within the customizer.
     *
     * @return int
     */
    public function get_priority();

    /**
     * Register settings, controls and sections with the customizer instance.
     *
     * @param WP_Customize_Manager $wp_customize Customizer manager instance.
     * @return void
     */
    public function register( WP_Customize_Manager $wp_customize );

    /**
     * Bootstraps additional hooks required by the module (preview scripts, etc.).
     *
     * @return void
     */
    public function boot();
}
