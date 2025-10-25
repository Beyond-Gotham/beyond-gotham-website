<?php
/**
 * Styles Customizer Module
 *
 * Handles CSS generation from customizer values for colors, typography, and layout.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/colors.php';

// =============================================================================
// CSS Generation Functions
// =============================================================================

// Note: beyond_gotham_get_color_mode_prefixes() and beyond_gotham_build_mode_selector_list()
// are defined in colors.php which is loaded before this file.

/**
 * Build CSS variables and typography from Customizer values.
 *
 * @return string
 */
function beyond_gotham_get_customizer_css() {
	$defaults_by_mode = array(
		'light' => array(
			'primary'           => '#33d1ff',
			'secondary'         => '#1aa5d1',
			'background'        => '#f4f6fb',
			'text'              => '#0f172a',
			'text_dark'         => '#050608',
			'cta_accent'        => '#33d1ff',
			'header_background' => '#ffffff',
			'footer_background' => '#f4f6fb',
			'link'              => '#0f172a',
			'link_hover'        => '#1aa5d1',
			'button_background' => '#33d1ff',
			'button_text'       => '#050608',
			'quote_background'  => '#e6edf7',
		),
		'dark'  => array(
			'primary'           => '#33d1ff',
			'secondary'         => '#1aa5d1',
			'background'        => '#0f1115',
			'text'              => '#e7eaee',
			'text_dark'         => '#050608',
			'cta_accent'        => '#33d1ff',
			'header_background' => '#0b0d12',
			'footer_background' => '#050608',
			'link'              => '#33d1ff',
			'link_hover'        => '#1aa5d1',
			'button_background' => '#33d1ff',
			'button_text'       => '#050608',
			'quote_background'  => '#161b2a',
		),
	);

	$mod_map = array(
		'primary'           => 'primary_color',
		'secondary'         => 'secondary_color',
		'background'        => 'background_color',
		'text'              => 'text_color',
		'cta_accent'        => 'cta_accent_color',
		'header_background' => 'header_background_color',
		'footer_background' => 'footer_background_color',
		'link'              => 'link_color',
		'link_hover'        => 'link_hover_color',
		'button_background' => 'button_background_color',
		'button_text'       => 'button_text_color',
		'quote_background'  => 'quote_background_color',
	);

	$palettes = array();

	foreach ( $defaults_by_mode as $mode => $defaults ) {
		$palette = array();

		foreach ( $mod_map as $palette_key => $slug ) {
			$legacy_setting = 'beyond_gotham_' . $slug;
			$setting_id     = 'beyond_gotham_' . $slug . '_' . $mode;

			$fallback     = isset( $defaults[ $palette_key ] ) ? $defaults[ $palette_key ] : '';
			$legacy_value = sanitize_hex_color( get_theme_mod( $legacy_setting ) );

			if ( $legacy_value ) {
				$fallback = $legacy_value;
			}

			$value = sanitize_hex_color( get_theme_mod( $setting_id, $fallback ) );

			if ( ! $value ) {
				$value = $fallback;
			}

			$palette[ $palette_key ] = $value;
		}

		$palettes[ $mode ] = $palette;
	}

	$css = '';

	// Generate color mode CSS
	foreach ( $palettes as $mode => $palette ) {
		$root_selector = beyond_gotham_build_mode_selector_list( $mode, array( '' ) );

		$css .= $root_selector . '{';
		$css .= '--color-primary:' . $palette['primary'] . ';';
		$css .= '--color-secondary:' . $palette['secondary'] . ';';
		$css .= '--color-background:' . $palette['background'] . ';';
		$css .= '--color-text:' . $palette['text'] . ';';
		$css .= '--color-text-dark:' . $palette['text_dark'] . ';';
		$css .= '--color-cta-accent:' . $palette['cta_accent'] . ';';
		$css .= '--color-header-bg:' . $palette['header_background'] . ';';
		$css .= '--color-footer-bg:' . $palette['footer_background'] . ';';
		$css .= '--color-link:' . $palette['link'] . ';';
		$css .= '--color-link-hover:' . $palette['link_hover'] . ';';
		$css .= '--color-button-bg:' . $palette['button_background'] . ';';
		$css .= '--color-button-text:' . $palette['button_text'] . ';';
		$css .= '--color-quote-bg:' . $palette['quote_background'] . ';';
		$css .= '}';
	}

	// Typography
	$presets = function_exists( 'beyond_gotham_get_typography_presets' ) ? beyond_gotham_get_typography_presets() : array();

	$body_font_key = get_theme_mod( 'beyond_gotham_body_font', 'inter' );
	$heading_key   = get_theme_mod( 'beyond_gotham_heading_font', 'inter' );

	$font_size_value  = (float) get_theme_mod( 'beyond_gotham_body_font_size', 16 );
	$font_unit        = get_theme_mod( 'beyond_gotham_body_font_unit', 'px' );
	$line_height_value = (float) get_theme_mod( 'beyond_gotham_body_line_height', 1.6 );

	// Content Layout
	$content_layout = function_exists( 'beyond_gotham_get_ui_layout_settings' ) ? beyond_gotham_get_ui_layout_settings() : array();

	$layout_css = '';

	if ( ! empty( $content_layout['header_height_css'] ) ) {
		$layout_css .= ':root{--header-height:' . $content_layout['header_height_css'] . ';}';
	}

	$content_rules = array();

	if ( ! empty( $content_layout['max_width_css'] ) ) {
		$content_rules[] = 'max-width: var(--content-max-width, ' . $content_layout['max_width_css'] . ');';
		$content_rules[] = 'margin-left: auto;';
		$content_rules[] = 'margin-right: auto;';
		$content_rules[] = 'width: min(100%, var(--content-max-width, ' . $content_layout['max_width_css'] . '));';
	}

	if ( ! empty( $content_rules ) ) {
		$layout_css .= '.site-container, .site-main, .site-content {' . implode( ' ', $content_rules ) . '}';
	}

	if ( isset( $content_layout['section_spacing_css'] ) && '' !== $content_layout['section_spacing_css'] ) {
		$layout_css .= '.site-container > * + *, .site-main > * + *, .site-content > * + * {margin-top: var(--content-section-gap, ' . $content_layout['section_spacing_css'] . ');}';
	}

	// Body Typography
	$body_rules = array();

	if ( isset( $presets[ $body_font_key ] ) ) {
		$body_rules[] = 'font-family: ' . $presets[ $body_font_key ]['stack'] . ';';
	}

	$body_rules[] = 'font-size: ' . $font_size_value . $font_unit . ';';
	$body_rules[] = 'line-height: ' . $line_height_value . ';';

	if ( ! empty( $body_rules ) ) {
		$css .= 'body {' . implode( ' ', $body_rules ) . '}';
	}

	$css .= $layout_css;

	// Heading Typography
	if ( isset( $presets[ $heading_key ] ) ) {
		$css .= 'h1, h2, h3, h4, h5, h6 {font-family: ' . $presets[ $heading_key ]['stack'] . ';}';
	}

	/**
	 * Filter the generated customizer CSS.
	 *
	 * @param string $css Generated CSS.
	 */
	return apply_filters( 'beyond_gotham_customizer_css', $css );
}

/**
 * Print inline styles driven by the customizer.
 */
function beyond_gotham_print_customizer_styles() {
	$css = beyond_gotham_get_customizer_css();

	if ( empty( $css ) ) {
		return;
	}

	wp_add_inline_style( 'beyond-gotham-style', $css );
}

/**
 * Enqueue the Customizer preview script with contextual data.
 */
function beyond_gotham_customize_preview_js() {
	$handle  = 'beyond-gotham-customize-preview';
	$src     = get_template_directory_uri() . '/assets/js/customize-preview.js';
	$version = function_exists( 'beyond_gotham_asset_version' ) ? beyond_gotham_asset_version( 'assets/js/customize-preview.js' ) : BEYOND_GOTHAM_VERSION;

	wp_enqueue_script( $handle, $src, array( 'customize-preview' ), $version, true );

	$presets = beyond_gotham_get_typography_presets();
	$stacks  = array();

	foreach ( $presets as $key => $preset ) {
		$stacks[ $key ] = $preset['stack'];
	}

	$color_defaults = array(
		'light' => array(
			'primary'           => '#33d1ff',
			'secondary'         => '#1aa5d1',
			'background'        => '#f4f6fb',
			'text'              => '#0f172a',
			'darkText'          => '#050608',
			'ctaAccent'         => '#33d1ff',
			'headerBackground'  => '#ffffff',
			'footerBackground'  => '#f4f6fb',
			'link'              => '#0f172a',
			'linkHover'         => '#1aa5d1',
			'buttonBackground'  => '#33d1ff',
			'buttonText'        => '#050608',
			'quoteBackground'   => '#e6edf7',
		),
		'dark'  => array(
			'primary'           => '#33d1ff',
			'secondary'         => '#1aa5d1',
			'background'        => '#0f1115',
			'text'              => '#e7eaee',
			'darkText'          => '#050608',
			'ctaAccent'         => '#33d1ff',
			'headerBackground'  => '#0b0d12',
			'footerBackground'  => '#050608',
			'link'              => '#33d1ff',
			'linkHover'         => '#1aa5d1',
			'buttonBackground'  => '#33d1ff',
			'buttonText'        => '#050608',
			'quoteBackground'   => '#161b2a',
		),
	);

	$cta_layout    = function_exists( 'beyond_gotham_get_cta_layout_settings' ) ? beyond_gotham_get_cta_layout_settings() : array();
	$ui_layout     = function_exists( 'beyond_gotham_get_ui_layout_settings' ) ? beyond_gotham_get_ui_layout_settings() : array();
	$sticky_layout = function_exists( 'beyond_gotham_get_sticky_cta_settings' ) ? beyond_gotham_get_sticky_cta_settings() : array();

	wp_localize_script(
		$handle,
		'BGCustomizerPreview',
		array(
			'fontStacks'           => $stacks,
                        'footerTarget'         => '.site-info',
                        'headingSelector'      => 'h1, h2, h3, h4, h5, h6',
			'ctaSelectors'         => array(
				'wrapper' => '[data-bg-cta]',
				'text'    => '[data-bg-cta-text]',
				'button'  => '[data-bg-cta-button]',
			),
			'stickyCtaSelectors'   => array(
				'wrapper' => '[data-bg-sticky-cta]',
				'content' => '[data-bg-sticky-cta-content]',
				'button'  => '[data-bg-sticky-cta-button]',
			),
			'ctaLayout'           => $cta_layout,
			'stickyCta'           => $sticky_layout,
			'uiLayout'            => $ui_layout,
			'defaults'             => $color_defaults,
			'colorDefaults'        => $color_defaults,
			'contrastThreshold'    => 4.5,
		)
	);
}

