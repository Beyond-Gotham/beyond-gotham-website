<?php
/**
 * Color Scheme Customizer Settings
 *
 * Light and dark mode color configuration with WCAG-compliant defaults.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Color Defaults
// =============================================================================

/**
 * Get default color values for light and dark modes.
 *
 * @return array
 */
function beyond_gotham_get_color_defaults() {
	return array(
		'light' => array(
			'background'          => '#ffffff',
			'text_color'          => '#1a1a1a',
			'accent'              => '#2563eb',
			'link'                => '#2563eb',
			'link_hover'          => '#1e40af',
			'button_background'   => '#2563eb',
			'button_text'         => '#ffffff',
			'quote_background'    => '#e6edf7',
		),
		'dark'  => array(
			'background'          => '#050608',
			'text_color'          => '#e5e7eb',
			'accent'              => '#3b82f6',
			'link'                => '#60a5fa',
			'link_hover'          => '#93c5fd',
			'button_background'   => '#3b82f6',
			'button_text'         => '#ffffff',
			'quote_background'    => '#161b2a',
		),
	);
}

// =============================================================================
// Customizer Registration
// =============================================================================

add_action( 'customize_register', 'beyond_gotham_register_colors_customizer', 15 );

/**
 * Register color settings in the customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function beyond_gotham_register_colors_customizer( $wp_customize ) {
	$defaults = beyond_gotham_get_color_defaults();

	// Main Colors Section (for backward compatibility)
	$wp_customize->add_section(
		'beyond_gotham_colors',
		array(
			'title'       => __( 'Farben & Design', 'beyond_gotham' ),
			'priority'    => 20,
			'description' => __( 'Konfiguriere das Farbschema für Light- und Dark-Mode.', 'beyond_gotham' ),
		)
	);

	// Light Mode Section
	$wp_customize->add_section(
		'beyond_gotham_colors_light',
		array(
			'title'    => __( 'Light Mode Farben', 'beyond_gotham' ),
			'priority' => 21,
		)
	);

	// Dark Mode Section
	$wp_customize->add_section(
		'beyond_gotham_colors_dark',
		array(
			'title'    => __( 'Dark Mode Farben', 'beyond_gotham' ),
			'priority' => 22,
		)
	);

	// Color mode sections
	$color_modes = array(
		'light' => array(
			'label'   => __( 'Light', 'beyond_gotham' ),
			'section' => 'beyond_gotham_colors_light',
		),
		'dark'  => array(
			'label'   => __( 'Dark', 'beyond_gotham' ),
			'section' => 'beyond_gotham_colors_dark',
		),
	);

	// Define color controls with descriptions
	$color_controls = array(
		'background'        => array(
			'label'       => __( 'Hintergrundfarbe', 'beyond_gotham' ),
			'description' => __( 'Haupthintergrundfarbe der Seite.', 'beyond_gotham' ),
			'defaults'    => array(
				'light' => '#ffffff',
				'dark'  => '#050608',
			),
		),
		'text_color'        => array(
			'label'       => __( 'Textfarbe', 'beyond_gotham' ),
			'description' => __( 'Standard-Textfarbe für Fließtext.', 'beyond_gotham' ),
			'defaults'    => array(
				'light' => '#1a1a1a',
				'dark'  => '#e5e7eb',
			),
		),
		'accent'            => array(
			'label'       => __( 'Akzentfarbe', 'beyond_gotham' ),
			'description' => __( 'Primäre Akzentfarbe für CTAs und Highlights.', 'beyond_gotham' ),
			'defaults'    => array(
				'light' => '#2563eb',
				'dark'  => '#3b82f6',
			),
		),
		'link'              => array(
			'label'       => __( 'Link-Farbe', 'beyond_gotham' ),
			'description' => __( 'Farbe für Textlinks.', 'beyond_gotham' ),
			'defaults'    => array(
				'light' => '#2563eb',
				'dark'  => '#60a5fa',
			),
		),
		'link_hover'        => array(
			'label'       => __( 'Link-Hover-Farbe', 'beyond_gotham' ),
			'description' => __( 'Link-Farbe beim Hover-Zustand.', 'beyond_gotham' ),
			'defaults'    => array(
				'light' => '#1e40af',
				'dark'  => '#93c5fd',
			),
		),
		'button_background' => array(
			'label'       => __( 'Button-Hintergrund', 'beyond_gotham' ),
			'description' => __( 'Hintergrundfarbe für primäre Buttons.', 'beyond_gotham' ),
			'defaults'    => array(
				'light' => '#2563eb',
				'dark'  => '#3b82f6',
			),
		),
		'button_text'       => array(
			'label'       => __( 'Button-Textfarbe', 'beyond_gotham' ),
			'description' => __( 'Textfarbe in Buttons.', 'beyond_gotham' ),
			'defaults'    => array(
				'light' => '#ffffff',
				'dark'  => '#ffffff',
			),
		),
		'quote_background'  => array(
			'label'       => __( 'Zitat-Hintergrund', 'beyond_gotham' ),
			'description' => __( 'Hintergrundfarbe für Zitate und Highlight-Boxen.', 'beyond_gotham' ),
			'defaults'    => array(
				'light' => '#e6edf7',
				'dark'  => '#161b2a',
			),
		),
	);

	// Register settings and controls for each color in each mode
	foreach ( $color_controls as $setting_key => $control_args ) {
		foreach ( $color_modes as $mode_key => $mode_args ) {
			$setting_id = 'beyond_gotham_' . $setting_key . '_' . $mode_key;
			$control_id = $setting_id . '_control';
			$default    = isset( $control_args['defaults'][ $mode_key ] ) ? $control_args['defaults'][ $mode_key ] : '';

			$wp_customize->add_setting(
				$setting_id,
				array(
					'default'           => $default,
					'type'              => 'theme_mod',
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
				)
			);

			$label = sprintf(
				/* translators: %1$s: Base label. %2$s: Color mode label. */
				__( '%1$s (%2$s)', 'beyond_gotham' ),
				$control_args['label'],
				$mode_args['label']
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$control_id,
					array(
						'label'       => $label,
						'section'     => $mode_args['section'],
						'settings'    => $setting_id,
						'description' => $control_args['description'],
					)
				)
			);
		}
	}

	// Info Control in main colors section
	$wp_customize->add_control(
		new Beyond_Gotham_Customize_Info_Control(
			$wp_customize,
			'beyond_gotham_colors_info',
			array(
				'label'       => __( 'Farbmodus-Hinweis', 'beyond_gotham' ),
				'description' => __( 'Konfiguriere separate Farben für Light Mode und Dark Mode in den jeweiligen Sektionen.', 'beyond_gotham' ),
				'section'     => 'beyond_gotham_colors',
				'notice_type' => 'info',
			)
		)
	);
}

// =============================================================================
// Helper Functions
// =============================================================================

/**
 * Get color palette for a specific mode.
 *
 * @param string $mode Color mode (light or dark).
 * @return array
 */
function beyond_gotham_get_color_palette( $mode = 'light' ) {
	$mode     = in_array( $mode, array( 'light', 'dark' ), true ) ? $mode : 'light';
	$defaults = beyond_gotham_get_color_defaults();

	$palette = array(
		'background'        => get_theme_mod( 'beyond_gotham_background_' . $mode, $defaults[ $mode ]['background'] ),
		'text_color'        => get_theme_mod( 'beyond_gotham_text_color_' . $mode, $defaults[ $mode ]['text_color'] ),
		'accent'            => get_theme_mod( 'beyond_gotham_accent_' . $mode, $defaults[ $mode ]['accent'] ),
		'link'              => get_theme_mod( 'beyond_gotham_link_' . $mode, $defaults[ $mode ]['link'] ),
		'link_hover'        => get_theme_mod( 'beyond_gotham_link_hover_' . $mode, $defaults[ $mode ]['link_hover'] ),
		'button_background' => get_theme_mod( 'beyond_gotham_button_background_' . $mode, $defaults[ $mode ]['button_background'] ),
		'button_text'       => get_theme_mod( 'beyond_gotham_button_text_' . $mode, $defaults[ $mode ]['button_text'] ),
		'quote_background'  => get_theme_mod( 'beyond_gotham_quote_background_' . $mode, $defaults[ $mode ]['quote_background'] ),
	);

	return $palette;
}

/**
 * Get all color settings for both modes.
 *
 * @return array
 */
function beyond_gotham_get_all_color_settings() {
	return array(
		'light' => beyond_gotham_get_color_palette( 'light' ),
		'dark'  => beyond_gotham_get_color_palette( 'dark' ),
	);
}

/**
 * Get color mode selector prefixes.
 *
 * @param string $mode Color mode key.
 * @return array
 */
function beyond_gotham_get_color_mode_prefixes( $mode ) {
	$mode = 'dark' === $mode ? 'dark' : 'light';

	return array(
		'html.theme-' . $mode,
		'html[data-theme="' . $mode . '"]',
		'body.theme-' . $mode,
	);
}

/**
 * Build a comma-separated selector list scoped to the requested color mode.
 *
 * @param string $mode      Color mode key (light or dark).
 * @param array  $selectors Base selectors relative to the root.
 * @return string
 */
function beyond_gotham_build_mode_selector_list( $mode, array $selectors ) {
	$prefixes = beyond_gotham_get_color_mode_prefixes( $mode );
	$scoped   = array();

	foreach ( $prefixes as $prefix ) {
		foreach ( $selectors as $selector ) {
			$selector = trim( (string) $selector );

			if ( '' === $selector ) {
				$scoped[] = $prefix;
				continue;
			}

			if ( 0 === strpos( $selector, '&' ) ) {
				$scoped[] = str_replace( '&', $prefix, $selector );
				continue;
			}

			$scoped[] = trim( $prefix . ' ' . $selector );
		}
	}

	return implode( ', ', array_unique( $scoped ) );
}
