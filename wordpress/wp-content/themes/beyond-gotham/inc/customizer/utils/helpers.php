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
 * Sanitize a select/radio choice based on the associated control choices.
 *
 * @param string                $value   Raw value.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string
 */
function beyond_gotham_sanitize_choice( $value, $setting ) {
        $value = is_string( $value ) ? sanitize_key( $value ) : '';

        if ( ! $setting instanceof WP_Customize_Setting ) {
                return is_object( $setting ) && isset( $setting->default ) ? $setting->default : $value;
        }

        $control = $setting->manager->get_control( $setting->id );

        if ( ! $control || empty( $control->choices ) || ! is_array( $control->choices ) ) {
                return $setting->default;
        }

        return array_key_exists( $value, $control->choices ) ? $value : $setting->default;
}

/**
 * Sanitize an array of choice keys from a multiple select/checkbox control.
 *
 * @param mixed                 $value   Raw value.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return array
 */
function beyond_gotham_sanitize_multiple_choice( $value, $setting ) {
        if ( ! $setting instanceof WP_Customize_Setting ) {
                return array();
        }

        $control = $setting->manager->get_control( $setting->id );

        if ( ! $control || empty( $control->choices ) || ! is_array( $control->choices ) ) {
                return array();
        }

        if ( is_string( $value ) ) {
                $value = explode( ',', $value );
        }

        if ( ! is_array( $value ) ) {
                return array();
        }

        $sanitized = array();

        foreach ( $value as $key ) {
                $normalized = sanitize_key( $key );

                if ( array_key_exists( $normalized, $control->choices ) ) {
                        $sanitized[] = $normalized;
                }
        }

        return array_values( array_unique( $sanitized ) );
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
 * Sanitize numeric values ensuring they are non-negative floats.
 *
 * @param mixed $value Raw value.
 * @return float
 */
function beyond_gotham_sanitize_positive_float( $value ) {
        $value = is_numeric( $value ) ? (float) $value : 0.0;

        return $value < 0 ? 0.0 : $value;
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
// Customizer Control Helpers
// =============================================================================

if ( ! function_exists( 'beyond_gotham_customize_add_control' ) ) {
        /**
         * Safely add a custom control instance if the class is available.
         *
         * @param WP_Customize_Manager $wp_customize Customizer instance.
         * @param string               $control_class Fully qualified control class name.
         * @param string               $control_id    Control identifier.
         * @param array                $args          Optional control arguments.
         * @return void
         */
        function beyond_gotham_customize_add_control( WP_Customize_Manager $wp_customize, $control_class, $control_id, array $args = array() ) {
                if ( ! class_exists( $control_class ) ) {
                        return;
                }

                $wp_customize->add_control(
                        new $control_class(
                                $wp_customize,
                                $control_id,
                                $args
                        )
                );
        }
}

/**
 * Sanitize a list of post IDs ensuring numeric uniqueness.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function beyond_gotham_sanitize_post_id_list( $value ) {
        return beyond_gotham_sanitize_id_list( $value );
}

/**
 * Sanitize raw CSS selector strings.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_css_selector( $value ) {
        $value = is_string( $value ) ? trim( $value ) : '';

        if ( '' === $value ) {
                return '';
        }

        return sanitize_text_field( $value );
}

/**
 * Format numeric values as pixel CSS strings.
 *
 * @param float $value      Numeric value to format.
 * @param bool  $allow_zero Whether zero values are allowed.
 * @return string
 */
function beyond_gotham_format_px_value( $value, $allow_zero = false ) {
        $value = beyond_gotham_sanitize_positive_float( $value );

        if ( $value <= 0 && ! $allow_zero ) {
                return '';
        }

        $precision = ( $value < 10 ) ? 1 : 0;
        $rounded   = round( $value, $precision );

        if ( $rounded <= 0 && ! $allow_zero ) {
                return '';
        }

        return $rounded . 'px';
}

/**
 * Format numeric values as CSS sizes using the supplied unit.
 *
 * @param float  $value Numeric value.
 * @param string $unit  CSS unit (px, rem, etc.).
 * @return string
 */
function beyond_gotham_format_css_size( $value, $unit = 'px' ) {
        $value = beyond_gotham_sanitize_positive_float( $value );
        $unit  = in_array( $unit, array( 'px', 'rem', 'em', '%' ), true ) ? $unit : 'px';

        if ( $value <= 0 ) {
                return '';
        }

        $precision = ( '%' === $unit ) ? 0 : 1;
        $rounded   = round( $value, $precision );

        if ( abs( $rounded - round( $rounded ) ) < pow( 10, -$precision ) ) {
                $rounded = round( $rounded );
        }

        return $rounded . $unit;
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
