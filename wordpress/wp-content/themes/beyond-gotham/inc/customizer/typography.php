<?php
/**
 * Typography Customizer Settings
 *
 * Font family, size, line height, and text styling options.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Typography Presets
// =============================================================================

/**
 * Retrieve the typography presets that are available in the customizer.
 *
 * @return array
 */
function beyond_gotham_get_typography_presets() {
	$presets = array(
		'inter'        => array(
			'label' => __( 'Inter (Standard)', 'beyond_gotham' ),
			'stack' => '"Inter", "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, "Helvetica Neue", Arial, sans-serif',
		),
		'merriweather' => array(
			'label' => __( 'Merriweather', 'beyond_gotham' ),
			'stack' => '"Merriweather", "Georgia", "Times New Roman", serif',
		),
		'system'       => array(
			'label' => __( 'Systemschrift', 'beyond_gotham' ),
			'stack' => 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif',
		),
		'mono'         => array(
			'label' => __( 'JetBrains Mono', 'beyond_gotham' ),
			'stack' => '"JetBrains Mono", "Fira Code", "SFMono-Regular", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
		),
		'georgia'      => array(
			'label' => __( 'Georgia', 'beyond_gotham' ),
			'stack' => 'Georgia, "Times New Roman", Times, serif',
		),
		'helvetica'    => array(
			'label' => __( 'Helvetica', 'beyond_gotham' ),
			'stack' => '"Helvetica Neue", Helvetica, Arial, sans-serif',
		),
		'arial'        => array(
			'label' => __( 'Arial', 'beyond_gotham' ),
			'stack' => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
		),
		'verdana'      => array(
			'label' => __( 'Verdana', 'beyond_gotham' ),
			'stack' => 'Verdana, Geneva, sans-serif',
		),
		'tahoma'       => array(
			'label' => __( 'Tahoma', 'beyond_gotham' ),
			'stack' => 'Tahoma, Geneva, sans-serif',
		),
		'trebuchet'    => array(
			'label' => __( 'Trebuchet MS', 'beyond_gotham' ),
			'stack' => '"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif',
		),
		'courier'      => array(
			'label' => __( 'Courier New', 'beyond_gotham' ),
			'stack' => '"Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace',
		),
	);

	/**
	 * Filter the typography presets exposed in the customizer.
	 *
	 * @param array $presets Typography presets.
	 */
	return apply_filters( 'beyond_gotham_typography_presets', $presets );
}

/**
 * Ensure the selected typography preset exists.
 *
 * @param string $value Selected preset key.
 * @return string
 */
function beyond_gotham_sanitize_typography_choice( $value ) {
	$presets = beyond_gotham_get_typography_presets();

	if ( isset( $presets[ $value ] ) ) {
		return $value;
	}

	return 'inter';
}

// =============================================================================
// Customizer Registration
// =============================================================================

add_action( 'customize_register', 'beyond_gotham_register_typography_customizer', 20 );

/**
 * Register typography settings in the customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function beyond_gotham_register_typography_customizer( $wp_customize ) {
	// Section: Typography
	$wp_customize->add_section(
		'beyond_gotham_typography',
		array(
			'title'    => __( 'Typografie', 'beyond_gotham' ),
			'priority' => 30,
		)
	);

	$presets = beyond_gotham_get_typography_presets();
	$choices = array();
	foreach ( $presets as $key => $preset ) {
		$choices[ $key ] = $preset['label'];
	}

	// Setting: Body Font Family
	$wp_customize->add_setting(
		'beyond_gotham_body_font_family',
		array(
			'default'           => 'inter',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_typography_choice',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_body_font_family_control',
		array(
			'label'       => __( 'Primäre Schriftfamilie', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_typography',
			'settings'    => 'beyond_gotham_body_font_family',
			'type'        => 'select',
			'choices'     => $choices,
			'description' => __( 'Steuert die Standardschrift des Themes.', 'beyond_gotham' ),
		)
	);

	// Setting: Heading Font Family
	$wp_customize->add_setting(
		'beyond_gotham_heading_font_family',
		array(
			'default'           => 'merriweather',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_typography_choice',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_heading_font_family_control',
		array(
			'label'       => __( 'Überschrift-Schriftfamilie', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_typography',
			'settings'    => 'beyond_gotham_heading_font_family',
			'type'        => 'select',
			'choices'     => $choices,
			'description' => __( 'Wähle eine kontrastierende Schrift für Headlines.', 'beyond_gotham' ),
		)
	);

	// Setting: Body Font Size
	$wp_customize->add_setting(
		'beyond_gotham_body_font_size',
		array(
			'default'           => 16,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_float',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_body_font_size_control',
		array(
			'label'       => __( 'Grundschriftgröße', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_typography',
			'settings'    => 'beyond_gotham_body_font_size',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 12,
				'max'  => 24,
				'step' => 0.5,
			),
			'description' => __( 'Passe die Basisgröße für Text an.', 'beyond_gotham' ),
		)
	);

	// Setting: Body Font Size Unit
	$wp_customize->add_setting(
		'beyond_gotham_body_font_size_unit',
		array(
			'default'           => 'px',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_font_unit',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_body_font_size_unit_control',
		array(
			'label'    => __( 'Einheit für Schriftgröße', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_typography',
			'settings' => 'beyond_gotham_body_font_size_unit',
			'type'     => 'select',
			'choices'  => array(
				'px'  => 'px',
				'rem' => 'rem',
				'em'  => 'em',
			),
		)
	);

	// Setting: Body Line Height
	$wp_customize->add_setting(
		'beyond_gotham_body_line_height',
		array(
			'default'           => 1.6,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_float',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_body_line_height_control',
		array(
			'label'       => __( 'Zeilenhöhe', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_typography',
			'settings'    => 'beyond_gotham_body_line_height',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 1.1,
				'max'  => 2.6,
				'step' => 0.1,
			),
			'description' => __( 'Abstand zwischen Textzeilen.', 'beyond_gotham' ),
		)
	);

	// Heading: Advanced Typography
	$wp_customize->add_control(
		new Beyond_Gotham_Customize_Heading_Control(
			$wp_customize,
			'beyond_gotham_typography_advanced_heading',
			array(
				'label'   => __( 'Erweiterte Einstellungen', 'beyond_gotham' ),
				'section' => 'beyond_gotham_typography',
			)
		)
	);

	// Setting: Letter Spacing
	$wp_customize->add_setting(
		'beyond_gotham_letter_spacing',
		array(
			'default'           => 0,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_float',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_letter_spacing_control',
		array(
			'label'       => __( 'Zeichenabstand', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_typography',
			'settings'    => 'beyond_gotham_letter_spacing',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => -0.1,
				'max'  => 0.3,
				'step' => 0.01,
			),
			'description' => __( 'Abstand zwischen Zeichen in em. Standard: 0', 'beyond_gotham' ),
		)
	);

	// Setting: Paragraph Spacing
	$wp_customize->add_setting(
		'beyond_gotham_paragraph_spacing',
		array(
			'default'           => 1.5,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_float',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_paragraph_spacing_control',
		array(
			'label'       => __( 'Absatzabstand', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_typography',
			'settings'    => 'beyond_gotham_paragraph_spacing',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 0.5,
				'max'  => 3,
				'step' => 0.1,
			),
			'description' => __( 'Abstand zwischen Absätzen in em.', 'beyond_gotham' ),
		)
	);
}

// =============================================================================
// Helper Functions
// =============================================================================

/**
 * Get the font stack for a given preset key.
 *
 * @param string $preset_key Preset key from typography settings.
 * @return string
 */
function beyond_gotham_get_font_stack( $preset_key ) {
	$presets = beyond_gotham_get_typography_presets();

	if ( isset( $presets[ $preset_key ]['stack'] ) ) {
		return $presets[ $preset_key ]['stack'];
	}

	// Fallback to Inter
	return $presets['inter']['stack'];
}

/**
 * Get all typography settings as an array.
 *
 * @return array
 */
function beyond_gotham_get_typography_settings() {
	return array(
		'body_font'       => get_theme_mod( 'beyond_gotham_body_font_family', 'inter' ),
		'heading_font'    => get_theme_mod( 'beyond_gotham_heading_font_family', 'merriweather' ),
		'font_size'       => (float) get_theme_mod( 'beyond_gotham_body_font_size', 16 ),
		'font_unit'       => get_theme_mod( 'beyond_gotham_body_font_size_unit', 'px' ),
		'line_height'     => (float) get_theme_mod( 'beyond_gotham_body_line_height', 1.6 ),
		'letter_spacing'  => (float) get_theme_mod( 'beyond_gotham_letter_spacing', 0 ),
		'paragraph_spacing' => (float) get_theme_mod( 'beyond_gotham_paragraph_spacing', 1.5 ),
	);
}
