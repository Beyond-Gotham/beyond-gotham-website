<?php
/**
 * Call-to-Action (CTA) Customizer Settings
 *
 * Handles both standard CTA and sticky CTA bar functionality.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// CTA Defaults & Settings
// =============================================================================

/**
 * Retrieve default CTA values for reuse.
 *
 * @return array
 */
function beyond_gotham_get_cta_defaults() {
	return array(
		'text'             => __( 'Bleibe informiert über neue Kurse, Einsatztrainings und OSINT-Ressourcen.', 'beyond_gotham' ),
		'label'            => __( 'Jetzt abonnieren', 'beyond_gotham' ),
		'url'              => home_url( '/newsletter/' ),
		'visibility_scope' => array( 'all' ),
		'exclude_pages'    => array(),
	);
}

/**
 * Default CTA layout configuration.
 *
 * @return array
 */
function beyond_gotham_get_cta_layout_defaults() {
	return array(
		'width'          => 300,
		'height'         => 100,
		'position'       => 'bottom',
		'alignment'      => 'center',
		'mobile_width'   => 0,
		'mobile_height'  => 0,
		'mobile_padding' => 0,
		'show_mobile'    => true,
	);
}

/**
 * Retrieve the configured CTA content.
 *
 * @return array
 */
function beyond_gotham_get_cta_settings() {
	$defaults = beyond_gotham_get_cta_defaults();

	$text          = get_theme_mod( 'beyond_gotham_cta_text', $defaults['text'] );
	$label         = get_theme_mod( 'beyond_gotham_cta_button_label', $defaults['label'] );
	$url           = get_theme_mod( 'beyond_gotham_cta_button_url', $defaults['url'] );
	$scope         = get_theme_mod( 'beyond_gotham_cta_visibility_scope', $defaults['visibility_scope'] );
	$exclude_pages = get_theme_mod( 'beyond_gotham_cta_exclude_pages', $defaults['exclude_pages'] );

	$scope         = beyond_gotham_sanitize_cta_visibility_scope( $scope );
	$exclude_pages = beyond_gotham_sanitize_post_id_list( $exclude_pages );

	return array(
		'text'             => wp_kses_post( $text ),
		'label'            => sanitize_text_field( $label ),
		'url'              => beyond_gotham_sanitize_optional_url( $url ),
		'visibility_scope' => $scope,
		'exclude_pages'    => $exclude_pages,
	);
}

/**
 * Retrieve CTA layout settings merged with defaults.
 *
 * @return array
 */
function beyond_gotham_get_cta_layout_settings() {
	$defaults = beyond_gotham_get_cta_layout_defaults();

	$width          = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_width', $defaults['width'] ) );
	$height         = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_height', $defaults['height'] ) );
	$position       = beyond_gotham_sanitize_cta_position( get_theme_mod( 'beyond_gotham_cta_position', $defaults['position'] ) );
	$alignment      = beyond_gotham_sanitize_cta_alignment( get_theme_mod( 'beyond_gotham_cta_alignment', $defaults['alignment'] ) );
	$show_mobile    = beyond_gotham_sanitize_checkbox( get_theme_mod( 'beyond_gotham_cta_mobile_visible', $defaults['show_mobile'] ) );
	$mobile_width   = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_mobile_width', $defaults['mobile_width'] ) );
	$mobile_height  = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_mobile_height', $defaults['mobile_height'] ) );
	$mobile_padding = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_mobile_padding', $defaults['mobile_padding'] ) );

	$width_css          = $width > 0 ? beyond_gotham_format_css_size( $width, 'px' ) : '';
	$height_css         = $height > 0 ? beyond_gotham_format_css_size( $height, 'px' ) : '';
	$mobile_width_css   = $mobile_width > 0 ? beyond_gotham_format_css_size( $mobile_width, 'px' ) : '';
	$mobile_height_css  = $mobile_height > 0 ? beyond_gotham_format_css_size( $mobile_height, 'px' ) : '';
	$mobile_padding_css = beyond_gotham_format_px_value( $mobile_padding, true );

	$classes = array(
		'cta-' . $position,
		'cta-align-' . $alignment,
	);

	$style_map = array();

	if ( $width_css ) {
		$style_map['--cta-width'] = $width_css;
	}

	if ( $height_css ) {
		$style_map['--cta-height'] = $height_css;
	}

	if ( $mobile_width_css ) {
		$style_map['--cta-width-mobile'] = $mobile_width_css;
	}

	if ( $mobile_height_css ) {
		$style_map['--cta-height-mobile'] = $mobile_height_css;
	}

	if ( '' !== $mobile_padding_css ) {
		$style_map['--cta-padding-mobile'] = $mobile_padding_css;
	}

	return array(
		'width'              => $width,
		'height'             => $height,
		'width_css'          => $width_css,
		'height_css'         => $height_css,
		'position'           => $position,
		'alignment'          => $alignment,
		'show_mobile'        => $show_mobile,
		'mobile_width'       => $mobile_width,
		'mobile_height'      => $mobile_height,
		'mobile_padding'     => $mobile_padding,
		'mobile_width_css'   => $mobile_width_css,
		'mobile_height_css'  => $mobile_height_css,
		'mobile_padding_css' => $mobile_padding_css,
		'class_list'         => array_values( array_unique( array_filter( array_map( 'sanitize_html_class', $classes ) ) ) ),
		'style_map'          => $style_map,
	);
}

// =============================================================================
// Sticky CTA Defaults & Settings
// =============================================================================

/**
 * Retrieve default settings for the sticky CTA bar.
 *
 * @return array
 */
function beyond_gotham_get_sticky_cta_defaults() {
	return array(
		'active'           => false,
		'content'          => '',
		'link'             => '',
		'delay'            => 5,
		'trigger'          => 'delay',
		'scroll_depth'     => 50,
		'trigger_selector' => '',
		'background'       => '#0b1d2a',
		'text_color'       => '#ffffff',
		'button_color'     => '#33d1ff',
		'show_desktop'     => true,
		'show_mobile'      => true,
	);
}

/**
 * Retrieve the configured sticky CTA settings.
 *
 * @return array
 */
function beyond_gotham_get_sticky_cta_settings() {
	$defaults = beyond_gotham_get_sticky_cta_defaults();

	$active       = beyond_gotham_sanitize_checkbox( get_theme_mod( 'beyond_gotham_sticky_cta_active', $defaults['active'] ) );
	$content      = get_theme_mod( 'beyond_gotham_sticky_cta_content', $defaults['content'] );
	$link         = beyond_gotham_sanitize_optional_url( get_theme_mod( 'beyond_gotham_sticky_cta_link', $defaults['link'] ) );
	$delay        = absint( get_theme_mod( 'beyond_gotham_sticky_cta_delay', $defaults['delay'] ) );
	$trigger      = beyond_gotham_sanitize_sticky_cta_trigger( get_theme_mod( 'beyond_gotham_sticky_cta_trigger', $defaults['trigger'] ) );
	$scroll_depth = beyond_gotham_sanitize_sticky_cta_scroll_depth( get_theme_mod( 'beyond_gotham_sticky_cta_scroll_depth', $defaults['scroll_depth'] ) );
	$selector     = beyond_gotham_sanitize_css_selector( get_theme_mod( 'beyond_gotham_sticky_cta_trigger_selector', $defaults['trigger_selector'] ) );
	$background   = sanitize_hex_color( get_theme_mod( 'beyond_gotham_sticky_cta_background_color', $defaults['background'] ) );
	$text_color   = sanitize_hex_color( get_theme_mod( 'beyond_gotham_sticky_cta_text_color', $defaults['text_color'] ) );
	$button_color = sanitize_hex_color( get_theme_mod( 'beyond_gotham_sticky_cta_button_color', $defaults['button_color'] ) );
	$show_desktop = beyond_gotham_sanitize_checkbox( get_theme_mod( 'beyond_gotham_sticky_cta_show_desktop', $defaults['show_desktop'] ) );
	$show_mobile  = beyond_gotham_sanitize_checkbox( get_theme_mod( 'beyond_gotham_sticky_cta_show_mobile', $defaults['show_mobile'] ) );

	$background   = $background ? $background : $defaults['background'];
	$text_color   = $text_color ? $text_color : $defaults['text_color'];
	$button_color = $button_color ? $button_color : $defaults['button_color'];

	$content_clean = is_string( $content ) ? trim( wp_kses_post( $content ) ) : '';
	$has_content   = '' !== $content_clean;
	$has_link      = '' !== $link;
	$is_empty      = ! $has_content && ! $has_link;
	$enabled       = $active && ! $is_empty;

	$delay_ms = max( 0, $delay ) * 1000;

	return array(
		'active'           => $active,
		'content'          => $content_clean,
		'link'             => $link,
		'delay'            => $delay,
		'delay_ms'         => $delay_ms,
		'trigger'          => $trigger,
		'scroll_depth'     => $scroll_depth,
		'trigger_selector' => $selector,
		'background'       => $background,
		'text_color'       => $text_color,
		'button_color'     => $button_color,
		'show_desktop'     => $show_desktop,
		'show_mobile'      => $show_mobile,
		'has_content'      => $has_content,
		'has_link'         => $has_link,
		'is_empty'         => $is_empty,
		'enabled'          => $enabled,
	);
}

// =============================================================================
// Sanitization Functions
// =============================================================================

/**
 * Sanitize CTA position value.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_cta_position( $value ) {
	$value   = is_string( $value ) ? strtolower( $value ) : '';
	$allowed = array( 'top', 'bottom', 'sidebar' );

	if ( in_array( $value, $allowed, true ) ) {
		return $value;
	}

	return 'bottom';
}

/**
 * Sanitize CTA alignment value.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_cta_alignment( $value ) {
	$value   = is_string( $value ) ? strtolower( $value ) : '';
	$allowed = array( 'left', 'center', 'right' );

	if ( in_array( $value, $allowed, true ) ) {
		return $value;
	}

	return 'center';
}

/**
 * Sanitize CTA visibility scope.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function beyond_gotham_sanitize_cta_visibility_scope( $value ) {
	if ( ! is_array( $value ) ) {
		$value = array( 'all' );
	}

	$allowed = array( 'all', 'posts', 'pages', 'home', 'archive' );
	$cleaned = array();

	foreach ( $value as $item ) {
		$item = is_string( $item ) ? strtolower( $item ) : '';
		if ( in_array( $item, $allowed, true ) ) {
			$cleaned[] = $item;
		}
	}

	return empty( $cleaned ) ? array( 'all' ) : $cleaned;
}

/**
 * Sanitize sticky CTA trigger type.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_sticky_cta_trigger( $value ) {
	$value   = is_string( $value ) ? strtolower( $value ) : '';
	$allowed = array( 'delay', 'scroll', 'element' );

	if ( in_array( $value, $allowed, true ) ) {
		return $value;
	}

	return 'delay';
}

/**
 * Sanitize sticky CTA scroll depth percentage.
 *
 * @param int $value Raw value.
 * @return int
 */
function beyond_gotham_sanitize_sticky_cta_scroll_depth( $value ) {
	$value = (int) $value;
	return max( 10, min( 90, $value ) );
}

// =============================================================================
// Customizer Controls - Active Callbacks
// =============================================================================

/**
 * Retrieve the configured sticky CTA trigger type inside the customizer.
 *
 * @param WP_Customize_Control $control Customizer control instance.
 * @return string
 */
function beyond_gotham_customize_get_sticky_cta_trigger_value( $control ) {
	if ( ! $control instanceof WP_Customize_Control ) {
		return 'delay';
	}

	$setting = $control->manager->get_setting( 'beyond_gotham_sticky_cta_trigger' );

	if ( ! $setting ) {
		return 'delay';
	}

	return beyond_gotham_sanitize_sticky_cta_trigger( $setting->value() );
}

/**
 * Determine whether the sticky CTA trigger is set to delay.
 *
 * @param WP_Customize_Control $control Customizer control instance.
 * @return bool
 */
function beyond_gotham_customize_is_sticky_cta_trigger_delay( $control ) {
	return 'delay' === beyond_gotham_customize_get_sticky_cta_trigger_value( $control );
}

/**
 * Determine whether the sticky CTA trigger is set to scroll depth.
 *
 * @param WP_Customize_Control $control Customizer control instance.
 * @return bool
 */
function beyond_gotham_customize_is_sticky_cta_trigger_scroll( $control ) {
	return 'scroll' === beyond_gotham_customize_get_sticky_cta_trigger_value( $control );
}

/**
 * Determine whether the sticky CTA trigger is set to a target element.
 *
 * @param WP_Customize_Control $control Customizer control instance.
 * @return bool
 */
function beyond_gotham_customize_is_sticky_cta_trigger_element( $control ) {
	return 'element' === beyond_gotham_customize_get_sticky_cta_trigger_value( $control );
}

// =============================================================================
// Customizer Registration
// =============================================================================

/**
 * Register CTA customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function beyond_gotham_register_cta_customizer( WP_Customize_Manager $wp_customize ) {
	$cta_defaults    = beyond_gotham_get_cta_defaults();
	$layout_defaults = beyond_gotham_get_cta_layout_defaults();
	$sticky_defaults = beyond_gotham_get_sticky_cta_defaults();

	// CTA Section
	$wp_customize->add_section(
		'beyond_gotham_cta',
		array(
			'title'       => __( 'Call-to-Action', 'beyond_gotham' ),
			'priority'    => 40,
			'description' => __( 'Konfiguriere den Call-to-Action Bereich.', 'beyond_gotham' ),
		)
	);

	// CTA Text
	$wp_customize->add_setting(
		'beyond_gotham_cta_text',
		array(
			'default'           => $cta_defaults['text'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_cta_text_control',
		array(
			'label'    => __( 'CTA-Text', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_cta',
			'settings' => 'beyond_gotham_cta_text',
			'type'     => 'textarea',
		)
	);

	// CTA Button Label
	$wp_customize->add_setting(
		'beyond_gotham_cta_button_label',
		array(
			'default'           => $cta_defaults['label'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_cta_button_label_control',
		array(
			'label'    => __( 'Button-Text', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_cta',
			'settings' => 'beyond_gotham_cta_button_label',
			'type'     => 'text',
		)
	);

	// CTA Button URL
	$wp_customize->add_setting(
		'beyond_gotham_cta_button_url',
		array(
			'default'           => $cta_defaults['url'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_optional_url',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_cta_button_url_control',
		array(
			'label'    => __( 'Button-URL', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_cta',
			'settings' => 'beyond_gotham_cta_button_url',
			'type'     => 'url',
		)
	);

	// CTA Layout Settings
	$wp_customize->add_setting(
		'beyond_gotham_cta_position',
		array(
			'default'           => $layout_defaults['position'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_cta_position',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_cta_position_control',
		array(
			'label'    => __( 'Position', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_cta',
			'settings' => 'beyond_gotham_cta_position',
			'type'     => 'select',
			'choices'  => array(
				'top'     => __( 'Oben', 'beyond_gotham' ),
				'bottom'  => __( 'Unten', 'beyond_gotham' ),
				'sidebar' => __( 'Sidebar', 'beyond_gotham' ),
			),
		)
	);

	$wp_customize->add_setting(
		'beyond_gotham_cta_alignment',
		array(
			'default'           => $layout_defaults['alignment'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_cta_alignment',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_cta_alignment_control',
		array(
			'label'    => __( 'Ausrichtung', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_cta',
			'settings' => 'beyond_gotham_cta_alignment',
			'type'     => 'select',
			'choices'  => array(
				'left'   => __( 'Links', 'beyond_gotham' ),
				'center' => __( 'Zentriert', 'beyond_gotham' ),
				'right'  => __( 'Rechts', 'beyond_gotham' ),
			),
		)
	);

	// Sticky CTA Section
	$wp_customize->add_section(
		'beyond_gotham_cta_sticky',
		array(
			'title'       => __( 'Sticky CTA Bar', 'beyond_gotham' ),
			'priority'    => 41,
			'description' => __( 'Konfiguriere die fixierte CTA-Leiste am Bildschirmrand.', 'beyond_gotham' ),
		)
	);

	// Sticky CTA Active
	$wp_customize->add_setting(
		'beyond_gotham_sticky_cta_active',
		array(
			'default'           => $sticky_defaults['active'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_sticky_cta_active_control',
		array(
			'label'    => __( 'Sticky CTA aktivieren', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_cta_sticky',
			'settings' => 'beyond_gotham_sticky_cta_active',
			'type'     => 'checkbox',
		)
	);

	// Sticky CTA Content
	$wp_customize->add_setting(
		'beyond_gotham_sticky_cta_content',
		array(
			'default'           => $sticky_defaults['content'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_sticky_cta_content_control',
		array(
			'label'       => __( 'Inhalt', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_cta_sticky',
			'settings'    => 'beyond_gotham_sticky_cta_content',
			'type'        => 'textarea',
			'description' => __( 'HTML erlaubt.', 'beyond_gotham' ),
		)
	);

	// Sticky CTA Link
	$wp_customize->add_setting(
		'beyond_gotham_sticky_cta_link',
		array(
			'default'           => $sticky_defaults['link'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_optional_url',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_sticky_cta_link_control',
		array(
			'label'    => __( 'Button-URL', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_cta_sticky',
			'settings' => 'beyond_gotham_sticky_cta_link',
			'type'     => 'url',
		)
	);

	// Trigger Type
	$wp_customize->add_setting(
		'beyond_gotham_sticky_cta_trigger',
		array(
			'default'           => $sticky_defaults['trigger'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_sticky_cta_trigger',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_sticky_cta_trigger_control',
		array(
			'label'    => __( 'Einblendung auslösen durch', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_cta_sticky',
			'settings' => 'beyond_gotham_sticky_cta_trigger',
			'type'     => 'radio',
			'choices'  => array(
				'delay'   => __( 'Zeitverzögerung', 'beyond_gotham' ),
				'scroll'  => __( 'Scrolltiefe (in %)', 'beyond_gotham' ),
				'element' => __( 'Element im Viewport', 'beyond_gotham' ),
			),
		)
	);

	// Delay Setting
	$wp_customize->add_setting(
		'beyond_gotham_sticky_cta_delay',
		array(
			'default'           => $sticky_defaults['delay'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_sticky_cta_delay_control',
		array(
			'label'           => __( 'Verzögerung (Sekunden)', 'beyond_gotham' ),
			'section'         => 'beyond_gotham_cta_sticky',
			'settings'        => 'beyond_gotham_sticky_cta_delay',
			'type'            => 'number',
			'input_attrs'     => array(
				'min'  => 0,
				'max'  => 60,
				'step' => 1,
			),
			'active_callback' => 'beyond_gotham_customize_is_sticky_cta_trigger_delay',
		)
	);

	// Scroll Depth
	$wp_customize->add_setting(
		'beyond_gotham_sticky_cta_scroll_depth',
		array(
			'default'           => $sticky_defaults['scroll_depth'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_sticky_cta_scroll_depth',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_sticky_cta_scroll_depth_control',
		array(
			'label'           => __( 'Scrolltiefe für Einblendung (%)', 'beyond_gotham' ),
			'section'         => 'beyond_gotham_cta_sticky',
			'settings'        => 'beyond_gotham_sticky_cta_scroll_depth',
			'type'            => 'range',
			'input_attrs'     => array(
				'min'  => 10,
				'max'  => 90,
				'step' => 5,
			),
			'active_callback' => 'beyond_gotham_customize_is_sticky_cta_trigger_scroll',
		)
	);

	// Trigger Selector
	$wp_customize->add_setting(
		'beyond_gotham_sticky_cta_trigger_selector',
		array(
			'default'           => $sticky_defaults['trigger_selector'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_css_selector',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_sticky_cta_trigger_selector_control',
		array(
			'label'           => __( 'CSS-Selektor für Auslöser', 'beyond_gotham' ),
			'section'         => 'beyond_gotham_cta_sticky',
			'settings'        => 'beyond_gotham_sticky_cta_trigger_selector',
			'type'            => 'text',
			'description'     => __( 'Beispiel: .article-footer – sobald das Element sichtbar wird, erscheint die Sticky-Leiste.', 'beyond_gotham' ),
			'active_callback' => 'beyond_gotham_customize_is_sticky_cta_trigger_element',
		)
	);

	// Colors
	$wp_customize->add_setting(
		'beyond_gotham_sticky_cta_background_color',
		array(
			'default'           => $sticky_defaults['background'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'beyond_gotham_sticky_cta_background_color_control',
			array(
				'label'    => __( 'Hintergrundfarbe', 'beyond_gotham' ),
				'section'  => 'beyond_gotham_cta_sticky',
				'settings' => 'beyond_gotham_sticky_cta_background_color',
			)
		)
	);

	$wp_customize->add_setting(
		'beyond_gotham_sticky_cta_text_color',
		array(
			'default'           => $sticky_defaults['text_color'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'beyond_gotham_sticky_cta_text_color_control',
			array(
				'label'    => __( 'Textfarbe', 'beyond_gotham' ),
				'section'  => 'beyond_gotham_cta_sticky',
				'settings' => 'beyond_gotham_sticky_cta_text_color',
			)
		)
	);

	$wp_customize->add_setting(
		'beyond_gotham_sticky_cta_button_color',
		array(
			'default'           => $sticky_defaults['button_color'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'beyond_gotham_sticky_cta_button_color_control',
			array(
				'label'    => __( 'Button-Farbe', 'beyond_gotham' ),
				'section'  => 'beyond_gotham_cta_sticky',
				'settings' => 'beyond_gotham_sticky_cta_button_color',
			)
		)
	);

	// Device Visibility
	$wp_customize->add_setting(
		'beyond_gotham_sticky_cta_show_desktop',
		array(
			'default'           => $sticky_defaults['show_desktop'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_sticky_cta_show_desktop_control',
		array(
			'label'    => __( 'Auf Desktop anzeigen', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_cta_sticky',
			'settings' => 'beyond_gotham_sticky_cta_show_desktop',
			'type'     => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'beyond_gotham_sticky_cta_show_mobile',
		array(
			'default'           => $sticky_defaults['show_mobile'],
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_sticky_cta_show_mobile_control',
		array(
			'label'    => __( 'Auf Mobil anzeigen', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_cta_sticky',
			'settings' => 'beyond_gotham_sticky_cta_show_mobile',
			'type'     => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'beyond_gotham_register_cta_customizer' );
