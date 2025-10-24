<?php
/**
 * Customizer Helper Functions
 *
 * Sanitization callbacks, utility functions, and shared helpers.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Sanitization Functions
// =============================================================================

/**
 * Sanitize an optional URL for the customizer.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_optional_url( $value ) {
	$value = trim( (string) $value );

	if ( '' === $value ) {
		return '';
	}

	return esc_url_raw( $value );
}

/**
 * Sanitize an optional email address for the customizer.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_optional_email( $value ) {
	$value = trim( (string) $value );

	if ( '' === $value ) {
		return '';
	}

	return sanitize_email( $value );
}

/**
 * Sanitize HTML content while allowing safe markup.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_allow_html( $value ) {
	return wp_kses_post( $value );
}

/**
 * Sanitize checkbox values.
 *
 * @param mixed $value Raw value.
 * @return bool
 */
function beyond_gotham_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Sanitize float values.
 *
 * @param mixed $value Raw value.
 * @return float
 */
function beyond_gotham_sanitize_float( $value ) {
	return (float) $value;
}

/**
 * Sanitize integer values with optional min/max.
 *
 * @param mixed $value Raw value.
 * @param int   $min   Minimum value.
 * @param int   $max   Maximum value.
 * @return int
 */
function beyond_gotham_sanitize_int( $value, $min = null, $max = null ) {
	$value = (int) $value;

	if ( null !== $min && $value < $min ) {
		return $min;
	}

	if ( null !== $max && $value > $max ) {
		return $max;
	}

	return $value;
}

/**
 * Sanitize font size unit selection.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_font_unit( $value ) {
	$allowed = array( 'px', 'rem', 'em' );
	return in_array( $value, $allowed, true ) ? $value : 'px';
}

/**
 * Sanitize a list of post or page IDs.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function beyond_gotham_sanitize_id_list( $value ) {
	if ( is_string( $value ) ) {
		$value = explode( ',', $value );
	}

	if ( ! is_array( $value ) ) {
		return array();
	}

	return array_values( array_filter( array_map( 'absint', $value ) ) );
}

// =============================================================================
// Color Functions
// =============================================================================

/**
 * Convert hex color to RGBA with optional opacity.
 *
 * @param string $hex     Hex color code.
 * @param float  $opacity Opacity (0-1).
 * @return string
 */
function beyond_gotham_hex_to_rgba( $hex, $opacity = 1 ) {
	$hex = ltrim( $hex, '#' );

	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}

	if ( 6 !== strlen( $hex ) ) {
		return 'rgba(0, 0, 0, ' . $opacity . ')';
	}

	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );

	return 'rgba(' . $r . ', ' . $g . ', ' . $b . ', ' . $opacity . ')';
}

/**
 * Calculate relative luminance of a color.
 *
 * @param string $hex Hex color code.
 * @return float
 */
function beyond_gotham_get_luminance( $hex ) {
	$hex = ltrim( $hex, '#' );

	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}

	$r = hexdec( substr( $hex, 0, 2 ) ) / 255;
	$g = hexdec( substr( $hex, 2, 2 ) ) / 255;
	$b = hexdec( substr( $hex, 4, 2 ) ) / 255;

	$r = ( $r <= 0.03928 ) ? $r / 12.92 : pow( ( $r + 0.055 ) / 1.055, 2.4 );
	$g = ( $g <= 0.03928 ) ? $g / 12.92 : pow( ( $g + 0.055 ) / 1.055, 2.4 );
	$b = ( $b <= 0.03928 ) ? $b / 12.92 : pow( ( $b + 0.055 ) / 1.055, 2.4 );

	return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
}

/**
 * Calculate contrast ratio between two colors.
 *
 * @param string $color1 First hex color.
 * @param string $color2 Second hex color.
 * @return float
 */
function beyond_gotham_get_contrast_ratio( $color1, $color2 ) {
	$l1 = beyond_gotham_get_luminance( $color1 );
	$l2 = beyond_gotham_get_luminance( $color2 );

	$lighter = max( $l1, $l2 );
	$darker  = min( $l1, $l2 );

	return ( $lighter + 0.05 ) / ( $darker + 0.05 );
}

/**
 * Ensure sufficient contrast between two colors.
 *
 * @param string $foreground Foreground color (text).
 * @param string $background Background color.
 * @param array  $fallbacks  Array of fallback colors to try.
 * @param float  $min_ratio  Minimum contrast ratio (default: 4.5 for AA).
 * @return string
 */
function beyond_gotham_ensure_contrast( $foreground, $background, $fallbacks = array(), $min_ratio = 4.5 ) {
	$ratio = beyond_gotham_get_contrast_ratio( $foreground, $background );

	if ( $ratio >= $min_ratio ) {
		return $foreground;
	}

	foreach ( $fallbacks as $fallback ) {
		$ratio = beyond_gotham_get_contrast_ratio( $fallback, $background );

		if ( $ratio >= $min_ratio ) {
			return $fallback;
		}
	}

	// Last resort: return white or black based on background luminance
	$luminance = beyond_gotham_get_luminance( $background );
	return $luminance > 0.5 ? '#000000' : '#ffffff';
}

// =============================================================================
// Utility Functions
// =============================================================================

/**
 * Get the current color mode (light or dark).
 *
 * @return string
 */
function beyond_gotham_get_current_color_mode() {
	// Check for user preference in cookie/session
	if ( isset( $_COOKIE['theme_mode'] ) ) {
		$mode = sanitize_text_field( $_COOKIE['theme_mode'] );
		if ( in_array( $mode, array( 'light', 'dark' ), true ) ) {
			return $mode;
		}
	}

	// Default to light mode
	return 'light';
}

/**
 * Check if a feature is enabled in customizer.
 *
 * @param string $feature_key Setting key to check.
 * @param mixed  $default     Default value if not set.
 * @return mixed
 */
function beyond_gotham_is_feature_enabled( $feature_key, $default = false ) {
	return get_theme_mod( $feature_key, $default );
}

/**
 * Get a theme mod with type casting.
 *
 * @param string $key     Setting key.
 * @param mixed  $default Default value.
 * @param string $type    Type to cast to (string, int, float, bool, array).
 * @return mixed
 */
function beyond_gotham_get_theme_mod_typed( $key, $default, $type = 'string' ) {
	$value = get_theme_mod( $key, $default );

	switch ( $type ) {
		case 'int':
			return (int) $value;
		case 'float':
			return (float) $value;
		case 'bool':
			return (bool) $value;
		case 'array':
			return is_array( $value ) ? $value : array();
		default:
			return (string) $value;
	}
}

/**
 * Build CSS custom property declaration.
 *
 * @param string $property CSS property name (without --).
 * @param mixed  $value    Property value.
 * @return string
 */
function beyond_gotham_css_var( $property, $value ) {
	if ( empty( $value ) ) {
		return '';
	}

	return '--' . $property . ': ' . esc_attr( $value ) . ';';
}

/**
 * Generate inline style block.
 *
 * @param array $vars Array of CSS custom properties (property => value).
 * @return string
 */
function beyond_gotham_generate_css_vars( $vars ) {
	if ( empty( $vars ) || ! is_array( $vars ) ) {
		return '';
	}

	$output = ':root {' . "\n";

	foreach ( $vars as $property => $value ) {
		if ( ! empty( $value ) ) {
			$output .= '  ' . beyond_gotham_css_var( $property, $value ) . "\n";
		}
	}

	$output .= '}' . "\n";

	return $output;
}
