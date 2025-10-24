<?php
/**
 * Customizer Module Loader
 *
 * Central index file that loads all customizer modules.
 * Include this file from functions.php or the main customizer.php.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// Define the customizer modules directory
$customizer_dir = get_template_directory() . '/inc/customizer/';

/**
 * Core modules - Must be loaded first as they provide base functionality
 */
require_once $customizer_dir . 'helpers.php';      // Helper functions & sanitization
require_once $customizer_dir . 'controls.php';     // Custom control classes

/**
 * Configuration modules - Define colors, typography, and branding
 */
require_once $customizer_dir . 'colors.php';       // Color scheme settings
require_once $customizer_dir . 'typography.php';   // Font family, size, line-height
require_once $customizer_dir . 'logo.php';         // Logo upload and sizing

/**
 * Layout modules - Header, navigation, and content structure
 */
require_once $customizer_dir . 'navigation.php';   // Menu and navigation settings
require_once $customizer_dir . 'layout.php';       // General layout options

/**
 * Component modules - Specific UI elements
 */
require_once $customizer_dir . 'cta.php';              // Call-to-Action & Sticky CTA
require_once $customizer_dir . 'footer.php';           // Footer configuration
require_once $customizer_dir . 'social.php';           // Social media links
require_once $customizer_dir . 'social-sharing.php';   // Social sharing buttons
require_once $customizer_dir . 'post-meta.php';        // Post metadata display

/**
 * Output modules - Generate CSS and inline styles
 */
require_once $customizer_dir . 'styles.php';       // CSS generation and output

/**
 * Hook into WordPress Customizer
 */
add_action( 'customize_register', 'beyond_gotham_register_customizer_modules' );

/**
 * Register all customizer sections, settings, and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function beyond_gotham_register_customizer_modules( $wp_customize ) {
	// Core modules are auto-registered via their own hooks
	// This function can be used for additional cross-module logic if needed
	
	/**
	 * Fire action after all customizer modules are registered.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer instance.
	 */
	do_action( 'beyond_gotham_customizer_modules_registered', $wp_customize );
}
