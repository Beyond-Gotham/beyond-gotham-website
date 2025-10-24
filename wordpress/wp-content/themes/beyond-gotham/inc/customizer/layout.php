<?php
/**
 * Layout Customizer Settings
 *
 * General layout options, container widths, spacing, and structural settings.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Layout Defaults
// =============================================================================

/**
 * Get default layout settings.
 *
 * @return array
 */
function beyond_gotham_get_layout_defaults() {
	return array(
		'container_width'    => 1280,
		'content_width'      => 720,
		'sidebar_width'      => 300,
		'grid_gap'           => 24,
		'section_spacing'    => 60,
		'enable_sidebar'     => true,
		'sidebar_position'   => 'right', // right, left
		'thumbnail_aspect'   => '16-9', // 16-9, 4-3, 1-1, original
		'card_style'         => 'elevated', // flat, bordered, elevated
	);
}

// =============================================================================
// Customizer Registration
// =============================================================================

/**
 * Register layout settings in the customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function beyond_gotham_register_layout_customizer( $wp_customize ) {
	$defaults = beyond_gotham_get_layout_defaults();

	// Section: Layout
	$wp_customize->add_section(
		'beyond_gotham_layout',
		array(
			'title'       => __( 'Layout & Struktur', 'beyond_gotham' ),
			'priority'    => 40,
			'description' => __( 'Konfiguriere Breiten, Abstände und Layout-Optionen.', 'beyond_gotham' ),
		)
	);

	// Heading: Container Widths
	$wp_customize->add_control(
		new Beyond_Gotham_Customize_Heading_Control(
			$wp_customize,
			'beyond_gotham_layout_widths_heading',
			array(
				'label'       => __( 'Container-Breiten', 'beyond_gotham' ),
				'description' => __( 'Definiere die maximalen Breiten für verschiedene Container.', 'beyond_gotham' ),
				'section'     => 'beyond_gotham_layout',
			)
		)
	);

	// Setting: Container Width
	$wp_customize->add_setting(
		'beyond_gotham_container_width',
		array(
			'default'           => $defaults['container_width'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_container_width_control',
		array(
			'label'       => __( 'Hauptcontainer-Breite (px)', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_layout',
			'settings'    => 'beyond_gotham_container_width',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 960,
				'max'  => 1920,
				'step' => 20,
			),
			'description' => __( 'Maximale Breite des Hauptcontainers.', 'beyond_gotham' ),
		)
	);

	// Setting: Content Width
	$wp_customize->add_setting(
		'beyond_gotham_content_width',
		array(
			'default'           => $defaults['content_width'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_content_width_control',
		array(
			'label'       => __( 'Content-Breite (px)', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_layout',
			'settings'    => 'beyond_gotham_content_width',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 600,
				'max'  => 1000,
				'step' => 10,
			),
			'description' => __( 'Maximale Breite für Artikel-Content (optimal für Lesbarkeit).', 'beyond_gotham' ),
		)
	);

	// Heading: Spacing
	$wp_customize->add_control(
		new Beyond_Gotham_Customize_Heading_Control(
			$wp_customize,
			'beyond_gotham_layout_spacing_heading',
			array(
				'label'       => __( 'Abstände', 'beyond_gotham' ),
				'description' => __( 'Passe Abstände zwischen Elementen an.', 'beyond_gotham' ),
				'section'     => 'beyond_gotham_layout',
			)
		)
	);

	// Setting: Grid Gap
	$wp_customize->add_setting(
		'beyond_gotham_grid_gap',
		array(
			'default'           => $defaults['grid_gap'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_grid_gap_control',
		array(
			'label'       => __( 'Grid-Abstand (px)', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_layout',
			'settings'    => 'beyond_gotham_grid_gap',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 10,
				'max'  => 60,
				'step' => 2,
			),
			'description' => __( 'Abstand zwischen Grid-Elementen (z.B. Karten).', 'beyond_gotham' ),
		)
	);

	// Setting: Section Spacing
	$wp_customize->add_setting(
		'beyond_gotham_section_spacing',
		array(
			'default'           => $defaults['section_spacing'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_section_spacing_control',
		array(
			'label'       => __( 'Abschnitts-Abstand (px)', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_layout',
			'settings'    => 'beyond_gotham_section_spacing',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 30,
				'max'  => 120,
				'step' => 10,
			),
			'description' => __( 'Vertikaler Abstand zwischen Sektionen.', 'beyond_gotham' ),
		)
	);

	// Heading: Sidebar
	$wp_customize->add_control(
		new Beyond_Gotham_Customize_Heading_Control(
			$wp_customize,
			'beyond_gotham_layout_sidebar_heading',
			array(
				'label'       => __( 'Sidebar-Einstellungen', 'beyond_gotham' ),
				'description' => __( 'Konfiguriere die Sidebar-Darstellung.', 'beyond_gotham' ),
				'section'     => 'beyond_gotham_layout',
			)
		)
	);

	// Setting: Enable Sidebar
	$wp_customize->add_setting(
		'beyond_gotham_enable_sidebar',
		array(
			'default'           => $defaults['enable_sidebar'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_enable_sidebar_control',
		array(
			'label'       => __( 'Sidebar aktivieren', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_layout',
			'settings'    => 'beyond_gotham_enable_sidebar',
			'type'        => 'checkbox',
			'description' => __( 'Zeigt eine Sidebar auf Beitrags- und Archivseiten.', 'beyond_gotham' ),
		)
	);

	// Setting: Sidebar Position
	$wp_customize->add_setting(
		'beyond_gotham_sidebar_position',
		array(
			'default'           => $defaults['sidebar_position'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_sidebar_position_control',
		array(
			'label'    => __( 'Sidebar-Position', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_layout',
			'settings' => 'beyond_gotham_sidebar_position',
			'type'     => 'select',
			'choices'  => array(
				'right' => __( 'Rechts', 'beyond_gotham' ),
				'left'  => __( 'Links', 'beyond_gotham' ),
			),
		)
	);

	// Setting: Sidebar Width
	$wp_customize->add_setting(
		'beyond_gotham_sidebar_width',
		array(
			'default'           => $defaults['sidebar_width'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_sidebar_width_control',
		array(
			'label'       => __( 'Sidebar-Breite (px)', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_layout',
			'settings'    => 'beyond_gotham_sidebar_width',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 200,
				'max'  => 400,
				'step' => 10,
			),
			'description' => __( 'Breite der Sidebar.', 'beyond_gotham' ),
		)
	);

	// Heading: Visual Style
	$wp_customize->add_control(
		new Beyond_Gotham_Customize_Heading_Control(
			$wp_customize,
			'beyond_gotham_layout_visual_heading',
			array(
				'label'       => __( 'Visuelle Optionen', 'beyond_gotham' ),
				'description' => __( 'Steuere das Erscheinungsbild von Karten und Thumbnails.', 'beyond_gotham' ),
				'section'     => 'beyond_gotham_layout',
			)
		)
	);

	// Setting: Thumbnail Aspect Ratio
	$wp_customize->add_setting(
		'beyond_gotham_thumbnail_aspect',
		array(
			'default'           => $defaults['thumbnail_aspect'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_thumbnail_aspect_control',
		array(
			'label'    => __( 'Thumbnail-Seitenverhältnis', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_layout',
			'settings' => 'beyond_gotham_thumbnail_aspect',
			'type'     => 'select',
			'choices'  => array(
				'16-9'     => __( '16:9 (Widescreen)', 'beyond_gotham' ),
				'4-3'      => __( '4:3 (Standard)', 'beyond_gotham' ),
				'1-1'      => __( '1:1 (Quadrat)', 'beyond_gotham' ),
				'original' => __( 'Original (keine Beschneidung)', 'beyond_gotham' ),
			),
		)
	);

	// Setting: Card Style
	$wp_customize->add_setting(
		'beyond_gotham_card_style',
		array(
			'default'           => $defaults['card_style'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_card_style_control',
		array(
			'label'       => __( 'Karten-Stil', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_layout',
			'settings'    => 'beyond_gotham_card_style',
			'type'        => 'select',
			'choices'     => array(
				'flat'     => __( 'Flach (kein Schatten)', 'beyond_gotham' ),
				'bordered' => __( 'Mit Rahmen', 'beyond_gotham' ),
				'elevated' => __( 'Erhöht (mit Schatten)', 'beyond_gotham' ),
			),
			'description' => __( 'Visueller Stil für Artikel-Karten.', 'beyond_gotham' ),
		)
	);
}

// =============================================================================
// Helper Functions
// =============================================================================

/**
 * Get all layout settings.
 *
 * @return array
 */
function beyond_gotham_get_ui_layout_settings() {
	$defaults = beyond_gotham_get_layout_defaults();

	$settings = array(
		'container_width'  => absint( get_theme_mod( 'beyond_gotham_container_width', $defaults['container_width'] ) ),
		'content_width'    => absint( get_theme_mod( 'beyond_gotham_content_width', $defaults['content_width'] ) ),
		'sidebar_width'    => absint( get_theme_mod( 'beyond_gotham_sidebar_width', $defaults['sidebar_width'] ) ),
		'grid_gap'         => absint( get_theme_mod( 'beyond_gotham_grid_gap', $defaults['grid_gap'] ) ),
		'section_spacing'  => absint( get_theme_mod( 'beyond_gotham_section_spacing', $defaults['section_spacing'] ) ),
		'enable_sidebar'   => (bool) get_theme_mod( 'beyond_gotham_enable_sidebar', $defaults['enable_sidebar'] ),
		'sidebar_position' => get_theme_mod( 'beyond_gotham_sidebar_position', $defaults['sidebar_position'] ),
		'thumbnail_aspect' => get_theme_mod( 'beyond_gotham_thumbnail_aspect', $defaults['thumbnail_aspect'] ),
		'card_style'       => get_theme_mod( 'beyond_gotham_card_style', $defaults['card_style'] ),
	);

	// Organize into groups
	return array(
		'header'     => array(),
		'footer'     => array(),
		'buttons'    => array(),
		'thumbnails' => array(
			'aspect_ratio' => $settings['thumbnail_aspect'],
		),
		'content'    => array(
			'container_width' => $settings['container_width'],
			'content_width'   => $settings['content_width'],
			'grid_gap'        => $settings['grid_gap'],
			'section_spacing' => $settings['section_spacing'],
		),
		'sidebar'    => array(
			'enabled'  => $settings['enable_sidebar'],
			'position' => $settings['sidebar_position'],
			'width'    => $settings['sidebar_width'],
		),
		'cards'      => array(
			'style' => $settings['card_style'],
		),
	);
}

/**
 * Check if sidebar is enabled.
 *
 * @return bool
 */
function beyond_gotham_is_sidebar_enabled() {
	$settings = beyond_gotham_get_ui_layout_settings();
	return isset( $settings['sidebar']['enabled'] ) && $settings['sidebar']['enabled'];
}

/**
 * Get card style class.
 *
 * @return string
 */
function beyond_gotham_get_card_style_class() {
	$settings = beyond_gotham_get_ui_layout_settings();
	$style    = isset( $settings['cards']['style'] ) ? $settings['cards']['style'] : 'elevated';
	return 'card-style-' . sanitize_html_class( $style );
}

/**
 * Get thumbnail aspect ratio class.
 *
 * @return string
 */
function beyond_gotham_get_thumbnail_aspect_class() {
	$settings = beyond_gotham_get_ui_layout_settings();
	$aspect   = isset( $settings['thumbnails']['aspect_ratio'] ) ? $settings['thumbnails']['aspect_ratio'] : '16-9';
	return 'thumbnail-' . sanitize_html_class( $aspect );
}
