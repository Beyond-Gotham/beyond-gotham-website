<?php
/**
 * Footer Customizer Settings
 *
 * Handles footer text, footer menu, and footer social icon display.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Footer Settings
// =============================================================================

/**
 * Provide a consistent accessor for the footer text theme mod.
 *
 * @return string
 */
function beyond_gotham_get_footer_text() {
	$text = get_theme_mod( 'beyond_gotham_footer_text', sprintf( '© Beyond Gotham %s', esc_html( date_i18n( 'Y' ) ) ) );

	return wp_kses_post( $text );
}

/**
 * Get footer social icon visibility setting.
 *
 * @return bool
 */
function beyond_gotham_get_footer_social_visibility() {
	return (bool) get_theme_mod( 'beyond_gotham_footer_show_social', true );
}

// =============================================================================
// Customizer Registration
// =============================================================================

/**
 * Register footer customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function beyond_gotham_register_footer_customizer( WP_Customize_Manager $wp_customize ) {
	// Footer Section
	$wp_customize->add_section(
		'beyond_gotham_footer',
		array(
			'title'       => __( 'Footer', 'beyond_gotham' ),
			'priority'    => 90,
			'description' => __( 'Gestalte Copyright- und Footer-Informationen.', 'beyond_gotham' ),
		)
	);

	// Footer Text
	$wp_customize->add_setting(
		'beyond_gotham_footer_text',
		array(
			'default'           => sprintf( '© Beyond Gotham %s', esc_html( date_i18n( 'Y' ) ) ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_footer_text_control',
		array(
			'label'       => __( 'Footer-Text', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_footer',
			'settings'    => 'beyond_gotham_footer_text',
			'type'        => 'textarea',
			'description' => __( 'Unterstützt einfachen Text sowie Links (HTML).', 'beyond_gotham' ),
		)
	);

	// Footer Social Icons Visibility
	$wp_customize->add_setting(
		'beyond_gotham_footer_show_social',
		array(
			'default'           => true,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_footer_show_social_control',
		array(
			'label'    => __( 'Social Icons im Footer anzeigen', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_footer',
			'settings' => 'beyond_gotham_footer_show_social',
			'type'     => 'checkbox',
		)
	);

	// Footer Menu Location Control
	if ( isset( $wp_customize->nav_menus ) && class_exists( 'WP_Customize_Nav_Menu_Location_Control' ) ) {
		$wp_customize->add_control(
			new WP_Customize_Nav_Menu_Location_Control(
				$wp_customize,
				'beyond_gotham_footer_menu_location',
				array(
					'label'         => __( 'Footer-Menü auswählen', 'beyond_gotham' ),
					'section'       => 'beyond_gotham_footer',
					'menu_location' => 'footer',
					'settings'      => 'nav_menu_locations[footer]',
					'description'   => __( 'Ordne ein bestehendes Menü dem Footer zu.', 'beyond_gotham' ),
				)
			)
		);
	}
}
