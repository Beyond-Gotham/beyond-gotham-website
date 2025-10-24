<?php
/**
 * Navigation Customizer Settings
 *
 * Menu positioning, sticky header, and navigation behavior.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Navigation Defaults
// =============================================================================

/**
 * Get default navigation settings.
 *
 * @return array
 */
function beyond_gotham_get_navigation_defaults() {
	return array(
		'sticky_header'      => true,
		'sticky_offset'      => 0,
		'mobile_breakpoint'  => 960,
		'show_search'        => true,
		'show_social_icons'  => false,
		'menu_style'         => 'horizontal', // horizontal, centered, split
		'submenu_indicator'  => true,
	);
}

// =============================================================================
// Customizer Registration
// =============================================================================

/**
 * Register navigation settings in the customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function beyond_gotham_register_navigation_customizer( $wp_customize ) {
	$defaults = beyond_gotham_get_navigation_defaults();

	// Section: Navigation
	$wp_customize->add_section(
		'beyond_gotham_navigation',
		array(
			'title'       => __( 'Navigation & Menü', 'beyond_gotham' ),
			'priority'    => 35,
			'description' => __( 'Konfiguriere das Hauptmenü und die Navigation.', 'beyond_gotham' ),
		)
	);

	// Heading: Header Behavior
	$wp_customize->add_control(
		new Beyond_Gotham_Customize_Heading_Control(
			$wp_customize,
			'beyond_gotham_nav_header_heading',
			array(
				'label'       => __( 'Header-Verhalten', 'beyond_gotham' ),
				'description' => __( 'Steuere wie sich der Header beim Scrollen verhält.', 'beyond_gotham' ),
				'section'     => 'beyond_gotham_navigation',
			)
		)
	);

	// Setting: Sticky Header
	$wp_customize->add_setting(
		'beyond_gotham_sticky_header',
		array(
			'default'           => $defaults['sticky_header'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_sticky_header_control',
		array(
			'label'       => __( 'Sticky Header aktivieren', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_navigation',
			'settings'    => 'beyond_gotham_sticky_header',
			'type'        => 'checkbox',
			'description' => __( 'Header bleibt beim Scrollen oben fixiert.', 'beyond_gotham' ),
		)
	);

	// Setting: Sticky Offset
	$wp_customize->add_setting(
		'beyond_gotham_sticky_offset',
		array(
			'default'           => $defaults['sticky_offset'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_sticky_offset_control',
		array(
			'label'       => __( 'Sticky Header Offset (px)', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_navigation',
			'settings'    => 'beyond_gotham_sticky_offset',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 10,
			),
			'description' => __( 'Abstand von oben, bevor der Header sticky wird.', 'beyond_gotham' ),
		)
	);

	// Heading: Menu Style
	$wp_customize->add_control(
		new Beyond_Gotham_Customize_Heading_Control(
			$wp_customize,
			'beyond_gotham_nav_menu_heading',
			array(
				'label'   => __( 'Menü-Layout', 'beyond_gotham' ),
				'section' => 'beyond_gotham_navigation',
			)
		)
	);

	// Setting: Menu Style
	$wp_customize->add_setting(
		'beyond_gotham_menu_style',
		array(
			'default'           => $defaults['menu_style'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_menu_style_control',
		array(
			'label'    => __( 'Menü-Stil', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_navigation',
			'settings' => 'beyond_gotham_menu_style',
			'type'     => 'select',
			'choices'  => array(
				'horizontal' => __( 'Horizontal (Standard)', 'beyond_gotham' ),
				'centered'   => __( 'Zentriert', 'beyond_gotham' ),
				'split'      => __( 'Split (Logo mittig)', 'beyond_gotham' ),
			),
		)
	);

	// Setting: Mobile Breakpoint
	$wp_customize->add_setting(
		'beyond_gotham_mobile_breakpoint',
		array(
			'default'           => $defaults['mobile_breakpoint'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_mobile_breakpoint_control',
		array(
			'label'       => __( 'Mobile Breakpoint (px)', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_navigation',
			'settings'    => 'beyond_gotham_mobile_breakpoint',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 600,
				'max'  => 1200,
				'step' => 10,
			),
			'description' => __( 'Bildschirmbreite, ab der das mobile Menü angezeigt wird.', 'beyond_gotham' ),
		)
	);

	// Heading: Menu Features
	$wp_customize->add_control(
		new Beyond_Gotham_Customize_Heading_Control(
			$wp_customize,
			'beyond_gotham_nav_features_heading',
			array(
				'label'   => __( 'Menü-Funktionen', 'beyond_gotham' ),
				'section' => 'beyond_gotham_navigation',
			)
		)
	);

	// Setting: Show Search
	$wp_customize->add_setting(
		'beyond_gotham_nav_show_search',
		array(
			'default'           => $defaults['show_search'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_nav_show_search_control',
		array(
			'label'       => __( 'Suchfeld im Header anzeigen', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_navigation',
			'settings'    => 'beyond_gotham_nav_show_search',
			'type'        => 'checkbox',
			'description' => __( 'Zeigt ein Suchfeld in der Hauptnavigation.', 'beyond_gotham' ),
		)
	);

	// Setting: Show Social Icons
	$wp_customize->add_setting(
		'beyond_gotham_nav_show_social_icons',
		array(
			'default'           => $defaults['show_social_icons'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_nav_show_social_icons_control',
		array(
			'label'       => __( 'Social Icons im Header anzeigen', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_navigation',
			'settings'    => 'beyond_gotham_nav_show_social_icons',
			'type'        => 'checkbox',
			'description' => __( 'Zeigt Social Media Icons in der Hauptnavigation.', 'beyond_gotham' ),
		)
	);

	// Setting: Submenu Indicator
	$wp_customize->add_setting(
		'beyond_gotham_submenu_indicator',
		array(
			'default'           => $defaults['submenu_indicator'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_submenu_indicator_control',
		array(
			'label'       => __( 'Submenü-Indikator anzeigen', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_navigation',
			'settings'    => 'beyond_gotham_submenu_indicator',
			'type'        => 'checkbox',
			'description' => __( 'Zeigt ein Pfeil-Icon bei Menüpunkten mit Untermenüs.', 'beyond_gotham' ),
		)
	);

	// Info: Menu Location
	$wp_customize->add_control(
		new Beyond_Gotham_Customize_Info_Control(
			$wp_customize,
			'beyond_gotham_nav_menu_location_info',
			array(
				'label'       => __( 'Menü verwalten', 'beyond_gotham' ),
				'description' => sprintf(
					/* translators: %s: Link to Menus section */
					__( 'Um Menüeinträge zu verwalten, besuche die %s Sektion.', 'beyond_gotham' ),
					'<a href="javascript:wp.customize.panel(\'nav_menus\').focus();">' . __( 'Menüs', 'beyond_gotham' ) . '</a>'
				),
				'section'     => 'beyond_gotham_navigation',
				'notice_type' => 'info',
			)
		)
	);
}

// =============================================================================
// Helper Functions
// =============================================================================

/**
 * Get navigation layout settings.
 *
 * @return array
 */
function beyond_gotham_get_nav_layout_settings() {
	$defaults = beyond_gotham_get_navigation_defaults();

	return array(
		'sticky'            => (bool) get_theme_mod( 'beyond_gotham_sticky_header', $defaults['sticky_header'] ),
		'sticky_offset'     => absint( get_theme_mod( 'beyond_gotham_sticky_offset', $defaults['sticky_offset'] ) ),
		'mobile_breakpoint' => absint( get_theme_mod( 'beyond_gotham_mobile_breakpoint', $defaults['mobile_breakpoint'] ) ),
		'show_search'       => (bool) get_theme_mod( 'beyond_gotham_nav_show_search', $defaults['show_search'] ),
		'show_social_icons' => (bool) get_theme_mod( 'beyond_gotham_nav_show_social_icons', $defaults['show_social_icons'] ),
		'menu_style'        => get_theme_mod( 'beyond_gotham_menu_style', $defaults['menu_style'] ),
		'submenu_indicator' => (bool) get_theme_mod( 'beyond_gotham_submenu_indicator', $defaults['submenu_indicator'] ),
	);
}

/**
 * Check if sticky header is enabled.
 *
 * @return bool
 */
function beyond_gotham_is_sticky_header_enabled() {
	$settings = beyond_gotham_get_nav_layout_settings();
	return $settings['sticky'];
}

/**
 * Get menu style class.
 *
 * @return string
 */
function beyond_gotham_get_menu_style_class() {
	$settings = beyond_gotham_get_nav_layout_settings();
	return 'menu-style-' . sanitize_html_class( $settings['menu_style'] );
}
