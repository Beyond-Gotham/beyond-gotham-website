<?php
/**
 * Logo Customizer Settings
 *
 * Logo upload, sizing, and positioning options.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Logo Defaults
// =============================================================================

/**
 * Get default logo size settings.
 *
 * @return array
 */
function beyond_gotham_get_logo_defaults() {
	return array(
		'desktop_height' => 40,
		'mobile_height'  => 32,
		'max_width'      => 200,
	);
}

// =============================================================================
// Customizer Registration
// =============================================================================

add_action( 'customize_register', 'beyond_gotham_register_logo_customizer', 10 );

/**
 * Register logo settings in the customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function beyond_gotham_register_logo_customizer( $wp_customize ) {
	$defaults = beyond_gotham_get_logo_defaults();

	// Add section for logo settings
	$wp_customize->add_section(
		'beyond_gotham_logo',
		array(
			'title'       => __( 'Logo-Einstellungen', 'beyond_gotham' ),
			'priority'    => 25,
			'description' => __( 'Konfiguriere Logo-Größe und -Darstellung.', 'beyond_gotham' ),
		)
	);

	// Note: WordPress has built-in logo upload in site_identity section
	// We add additional settings for sizing and positioning

	// Heading: Size Settings
	$wp_customize->add_control(
		new Beyond_Gotham_Customize_Heading_Control(
			$wp_customize,
			'beyond_gotham_logo_size_heading',
			array(
				'label'       => __( 'Logo-Größe', 'beyond_gotham' ),
				'description' => __( 'Passe die Höhe des Logos für verschiedene Bildschirmgrößen an.', 'beyond_gotham' ),
				'section'     => 'beyond_gotham_logo',
			)
		)
	);

	// Setting: Desktop Logo Height
	$wp_customize->add_setting(
		'beyond_gotham_logo_height_desktop',
		array(
			'default'           => $defaults['desktop_height'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_logo_height_desktop_control',
		array(
			'label'       => __( 'Desktop Logo-Höhe (px)', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_logo',
			'settings'    => 'beyond_gotham_logo_height_desktop',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 20,
				'max'  => 100,
				'step' => 1,
			),
			'description' => __( 'Höhe des Logos auf Desktop-Geräten.', 'beyond_gotham' ),
		)
	);

	// Setting: Mobile Logo Height
	$wp_customize->add_setting(
		'beyond_gotham_logo_height_mobile',
		array(
			'default'           => $defaults['mobile_height'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_logo_height_mobile_control',
		array(
			'label'       => __( 'Mobile Logo-Höhe (px)', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_logo',
			'settings'    => 'beyond_gotham_logo_height_mobile',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 16,
				'max'  => 60,
				'step' => 1,
			),
			'description' => __( 'Höhe des Logos auf mobilen Geräten.', 'beyond_gotham' ),
		)
	);

	// Setting: Logo Max Width
	$wp_customize->add_setting(
		'beyond_gotham_logo_max_width',
		array(
			'default'           => $defaults['max_width'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_logo_max_width_control',
		array(
			'label'       => __( 'Maximale Breite (px)', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_logo',
			'settings'    => 'beyond_gotham_logo_max_width',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 100,
				'max'  => 400,
				'step' => 10,
			),
			'description' => __( 'Maximale Breite des Logos, um Overflow zu vermeiden.', 'beyond_gotham' ),
		)
	);

	// Separator
	$wp_customize->add_control(
		new Beyond_Gotham_Customize_Separator_Control(
			$wp_customize,
			'beyond_gotham_logo_separator',
			array(
				'section' => 'beyond_gotham_logo',
			)
		)
	);

	// Info: Link to Site Identity
	$wp_customize->add_control(
		new Beyond_Gotham_Customize_Info_Control(
			$wp_customize,
			'beyond_gotham_logo_info',
			array(
				'label'       => __( 'Logo hochladen', 'beyond_gotham' ),
				'description' => sprintf(
					/* translators: %s: Link to Site Identity section */
					__( 'Um dein Logo hochzuladen, besuche die %s Sektion.', 'beyond_gotham' ),
					'<a href="javascript:wp.customize.section(\'title_tagline\').focus();">' . __( 'Website-Identität', 'beyond_gotham' ) . '</a>'
				),
				'section'     => 'beyond_gotham_logo',
				'notice_type' => 'info',
			)
		)
	);
}

// =============================================================================
// Helper Functions
// =============================================================================

/**
 * Get logo size settings.
 *
 * @return array
 */
function beyond_gotham_get_logo_size_settings() {
	$defaults = beyond_gotham_get_logo_defaults();

	return array(
		'desktop_height' => absint( get_theme_mod( 'beyond_gotham_logo_height_desktop', $defaults['desktop_height'] ) ),
		'mobile_height'  => absint( get_theme_mod( 'beyond_gotham_logo_height_mobile', $defaults['mobile_height'] ) ),
		'max_width'      => absint( get_theme_mod( 'beyond_gotham_logo_max_width', $defaults['max_width'] ) ),
	);
}

/**
 * Get logo URL.
 *
 * @return string
 */
function beyond_gotham_get_logo_url() {
	$custom_logo_id = get_theme_mod( 'custom_logo' );

	if ( $custom_logo_id ) {
		$logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
		return $logo_url ? $logo_url : '';
	}

	return '';
}

/**
 * Check if a custom logo is set.
 *
 * @return bool
 */
function beyond_gotham_has_custom_logo() {
	return has_custom_logo();
}

/**
 * Display the custom logo with proper sizing.
 *
 * @param array $args Additional arguments for the logo.
 */
function beyond_gotham_display_logo( $args = array() ) {
	if ( ! beyond_gotham_has_custom_logo() ) {
		return;
	}

	$defaults = array(
		'class' => 'custom-logo',
	);

	$args = wp_parse_args( $args, $defaults );

	the_custom_logo();
}
