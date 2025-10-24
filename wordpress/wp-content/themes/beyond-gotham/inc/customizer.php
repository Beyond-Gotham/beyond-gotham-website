<?php
/**
 * Theme Customizer enhancements for Beyond Gotham.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

/**
 * Retrieve the typography presets that are available in the customizer.
 *
 * @return array
 */
function beyond_gotham_get_typography_presets() {
    $presets = array(
        'inter'  => array(
            'label' => __( 'Inter (Standard)', 'beyond_gotham' ),
            'stack' => '"Inter", "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, "Helvetica Neue", Arial, sans-serif',
        ),
        'merriweather' => array(
            'label' => __( 'Merriweather', 'beyond_gotham' ),
            'stack' => '"Merriweather", "Georgia", "Times New Roman", serif',
        ),
        'system' => array(
            'label' => __( 'Systemschrift', 'beyond_gotham' ),
            'stack' => 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif',
        ),
        'mono'   => array(
            'label' => __( 'JetBrains Mono', 'beyond_gotham' ),
            'stack' => '"JetBrains Mono", "Fira Code", "SFMono-Regular", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
        ),
        'georgia' => array(
            'label' => __( 'Georgia', 'beyond_gotham' ),
            'stack' => 'Georgia, "Times New Roman", Times, serif',
        ),
        'helvetica' => array(
            'label' => __( 'Helvetica', 'beyond_gotham' ),
            'stack' => '"Helvetica Neue", Helvetica, Arial, sans-serif',
        ),
        'arial' => array(
            'label' => __( 'Arial', 'beyond_gotham' ),
            'stack' => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
        ),
        'verdana' => array(
            'label' => __( 'Verdana', 'beyond_gotham' ),
            'stack' => 'Verdana, Geneva, sans-serif',
        ),
        'tahoma' => array(
            'label' => __( 'Tahoma', 'beyond_gotham' ),
            'stack' => 'Tahoma, Geneva, sans-serif',
        ),
        'trebuchet' => array(
            'label' => __( 'Trebuchet MS', 'beyond_gotham' ),
            'stack' => '"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif',
        ),
        'courier' => array(
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
 * Sanitize checkbox values.
 *
 * @param mixed $value Raw value.
 * @return bool
 */
function beyond_gotham_sanitize_checkbox( $value ) {
    return (bool) $value;
}

/**
 * Sanitize numeric values that may include decimals.
 *
 * @param mixed $value Raw value.
 * @return float
 */
function beyond_gotham_sanitize_float( $value ) {
    $value = is_numeric( $value ) ? (float) $value : 0.0;

    return $value;
}

/**
 * Sanitize numeric values and ensure they are not negative.
 *
 * @param mixed $value Raw value.
 * @return float
 */
function beyond_gotham_sanitize_positive_float( $value ) {
    $value = is_numeric( $value ) ? (float) $value : 0.0;

    return ( $value < 0 ) ? 0.0 : $value;
}

/**
 * Ensure font size units are limited to known values.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_font_unit( $value ) {
    $value = is_string( $value ) ? strtolower( $value ) : '';

    if ( in_array( $value, array( 'px', 'rem' ), true ) ) {
        return $value;
    }

    return 'px';
}

/**
 * Limit CTA position values.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_cta_position( $value ) {
    $value   = is_string( $value ) ? strtolower( trim( $value ) ) : '';
    $choices = array( 'top', 'bottom', 'fixed' );

    if ( in_array( $value, $choices, true ) ) {
        return $value;
    }

    return 'bottom';
}

/**
 * Limit CTA alignment values.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_cta_alignment( $value ) {
    $value   = is_string( $value ) ? strtolower( trim( $value ) ) : '';
    $choices = array( 'left', 'center', 'right' );

    if ( in_array( $value, $choices, true ) ) {
        return $value;
    }

    return 'center';
}

/**
 * Format a numeric value as a pixel-based CSS value.
 *
 * @param float $value      Numeric value to format.
 * @param bool  $allow_zero Whether zero is allowed.
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
 * Restrict max width units for layout controls.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_dimension_unit( $value ) {
    $value   = is_string( $value ) ? strtolower( trim( $value ) ) : '';
    $choices = array( 'px', '%' );

    if ( in_array( $value, $choices, true ) ) {
        return $value;
    }

    return 'px';
}

/**
 * Sanitize aspect ratio choices for thumbnails.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_aspect_ratio_choice( $value ) {
    $value   = is_string( $value ) ? strtolower( trim( $value ) ) : '';
    $choices = array( '16-9', '4-3', '1-1' );

    if ( in_array( $value, $choices, true ) ) {
        return $value;
    }

    return '16-9';
}

/**
 * Default layout values for global UI controls.
 *
 * @return array
 */
function beyond_gotham_get_ui_layout_defaults() {
    return array(
        'header_height'             => 96,
        'header_padding_top'        => 24,
        'header_padding_bottom'     => 24,
        'footer_min_height'         => 240,
        'footer_margin_top'         => 64,
        'button_padding_vertical'   => 14,
        'button_padding_horizontal' => 28,
        'button_border_radius'      => 999,
        'thumbnail_aspect_ratio'    => '16-9',
        'thumbnail_max_width_value' => 100,
        'thumbnail_max_width_unit'  => '%',
        'content_max_width'         => 1200,
        'content_section_spacing'   => 48,
    );
}

/**
 * Retrieve layout values merged with defaults.
 *
 * @return array
 */
function beyond_gotham_get_ui_layout_settings() {
    $defaults = beyond_gotham_get_ui_layout_defaults();

    $header_height         = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_header_height', $defaults['header_height'] ) );
    $header_padding_top    = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_header_padding_top', $defaults['header_padding_top'] ) );
    $header_padding_bottom = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_header_padding_bottom', $defaults['header_padding_bottom'] ) );

    $footer_min_height = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_footer_min_height', $defaults['footer_min_height'] ) );
    $footer_margin_top = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_footer_margin_top', $defaults['footer_margin_top'] ) );

    $button_padding_vertical   = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_button_padding_vertical', $defaults['button_padding_vertical'] ) );
    $button_padding_horizontal = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_button_padding_horizontal', $defaults['button_padding_horizontal'] ) );
    $button_border_radius      = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_button_border_radius', $defaults['button_border_radius'] ) );

    $thumbnail_ratio      = beyond_gotham_sanitize_aspect_ratio_choice( get_theme_mod( 'beyond_gotham_thumbnail_aspect_ratio', $defaults['thumbnail_aspect_ratio'] ) );
    $thumb_width_value    = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_thumbnail_max_width_value', $defaults['thumbnail_max_width_value'] ) );
    $thumb_width_unit     = beyond_gotham_sanitize_dimension_unit( get_theme_mod( 'beyond_gotham_thumbnail_max_width_unit', $defaults['thumbnail_max_width_unit'] ) );
    $thumbnail_max_width  = $thumb_width_value > 0 ? beyond_gotham_format_css_size( $thumb_width_value, $thumb_width_unit ) : '';

    $content_max_width       = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_content_max_width', $defaults['content_max_width'] ) );
    $content_section_spacing = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_content_section_spacing', $defaults['content_section_spacing'] ) );

    $ratio_map = array(
        '16-9' => '16 / 9',
        '4-3'  => '4 / 3',
        '1-1'  => '1 / 1',
    );

    return array(
        'header'    => array(
            'height'         => $header_height,
            'height_css'     => beyond_gotham_format_px_value( $header_height ),
            'padding_top'    => $header_padding_top,
            'padding_top_css'    => beyond_gotham_format_px_value( $header_padding_top, true ),
            'padding_bottom' => $header_padding_bottom,
            'padding_bottom_css' => beyond_gotham_format_px_value( $header_padding_bottom, true ),
        ),
        'footer'    => array(
            'min_height'    => $footer_min_height,
            'min_height_css' => beyond_gotham_format_px_value( $footer_min_height ),
            'margin_top'    => $footer_margin_top,
            'margin_top_css' => beyond_gotham_format_px_value( $footer_margin_top, true ),
        ),
        'buttons'   => array(
            'padding_vertical'   => $button_padding_vertical,
            'padding_vertical_css'   => beyond_gotham_format_px_value( $button_padding_vertical, true ),
            'padding_horizontal' => $button_padding_horizontal,
            'padding_horizontal_css' => beyond_gotham_format_px_value( $button_padding_horizontal, true ),
            'border_radius'      => $button_border_radius,
            'border_radius_css'  => beyond_gotham_format_px_value( $button_border_radius, true ),
        ),
        'thumbnails' => array(
            'aspect_ratio'     => $thumbnail_ratio,
            'aspect_ratio_css' => isset( $ratio_map[ $thumbnail_ratio ] ) ? $ratio_map[ $thumbnail_ratio ] : $ratio_map['16-9'],
            'max_width_value'  => $thumb_width_value,
            'max_width_unit'   => $thumb_width_unit,
            'max_width_css'    => $thumbnail_max_width,
        ),
        'content'   => array(
            'max_width'       => $content_max_width,
            'max_width_css'   => beyond_gotham_format_px_value( $content_max_width ),
            'section_spacing' => $content_section_spacing,
            'section_spacing_css' => beyond_gotham_format_px_value( $content_section_spacing, true ),
        ),
    );
}

/**
 * Convert a hex color to an rgba string.
 *
 * @param string $color Hex color.
 * @param float  $alpha Alpha channel value.
 * @return string
 */
function beyond_gotham_hex_to_rgba( $color, $alpha = 1.0 ) {
    $hex = sanitize_hex_color( $color );

    if ( empty( $hex ) ) {
        return '';
    }

    $hex   = ltrim( $hex, '#' );
    $alpha = max( 0, min( 1, (float) $alpha ) );

    if ( strlen( $hex ) === 3 ) {
        $hex = sprintf(
            '%1$s%1$s%2$s%2$s%3$s%3$s',
            $hex[0],
            $hex[1],
            $hex[2]
        );
    }

    $red   = hexdec( substr( $hex, 0, 2 ) );
    $green = hexdec( substr( $hex, 2, 2 ) );
    $blue  = hexdec( substr( $hex, 4, 2 ) );

    return sprintf( 'rgba(%1$d, %2$d, %3$d, %4$s)', $red, $green, $blue, $alpha );
}

/**
 * Convert a sanitized hex color into an RGB triplet.
 *
 * @param string $color Hex color value.
 * @return array|null
 */
function beyond_gotham_hex_to_rgb( $color ) {
    $hex = sanitize_hex_color( $color );

    if ( empty( $hex ) ) {
        return null;
    }

    $hex = ltrim( $hex, '#' );

    if ( 3 === strlen( $hex ) ) {
        $hex = sprintf(
            '%1$s%1$s%2$s%2$s%3$s%3$s',
            $hex[0],
            $hex[1],
            $hex[2]
        );
    }

    if ( 6 !== strlen( $hex ) ) {
        return null;
    }

    return array(
        hexdec( substr( $hex, 0, 2 ) ),
        hexdec( substr( $hex, 2, 2 ) ),
        hexdec( substr( $hex, 4, 2 ) ),
    );
}

/**
 * Calculate the relative luminance for a hex color value.
 *
 * @param string $color Hex color value.
 * @return float|null
 */
function beyond_gotham_get_relative_luminance( $color ) {
    $rgb = beyond_gotham_hex_to_rgb( $color );

    if ( null === $rgb ) {
        return null;
    }

    $channels = array_map(
        static function ( $channel ) {
            $channel = $channel / 255;

            if ( $channel <= 0.03928 ) {
                return $channel / 12.92;
            }

            return pow( ( $channel + 0.055 ) / 1.055, 2.4 );
        },
        $rgb
    );

    return ( 0.2126 * $channels[0] ) + ( 0.7152 * $channels[1] ) + ( 0.0722 * $channels[2] );
}

/**
 * Determine the contrast ratio between two colors.
 *
 * @param string $color_a First color.
 * @param string $color_b Second color.
 * @return float
 */
function beyond_gotham_get_contrast_ratio( $color_a, $color_b ) {
    $lum_a = beyond_gotham_get_relative_luminance( $color_a );
    $lum_b = beyond_gotham_get_relative_luminance( $color_b );

    if ( null === $lum_a || null === $lum_b ) {
        return 0.0;
    }

    $lighter = max( $lum_a, $lum_b );
    $darker  = min( $lum_a, $lum_b );

    return ( $lighter + 0.05 ) / ( $darker + 0.05 );
}

/**
 * Ensure the provided color offers sufficient contrast with the background.
 *
 * Attempts the preferred color first and gracefully falls back to provided
 * defaults, finally checking pure black and white.
 *
 * @param string $preferred  Preferred color.
 * @param string $background Background color for contrast testing.
 * @param array  $fallbacks  List of fallback colors to try.
 * @param float  $threshold  Minimum contrast ratio required.
 * @return string|null
 */
function beyond_gotham_ensure_contrast( $preferred, $background, $fallbacks = array(), $threshold = 4.5 ) {
    $background = sanitize_hex_color( $background );
    $candidates = array_merge( array( sanitize_hex_color( $preferred ) ), $fallbacks );
    $candidates = array_filter(
        array_map( 'sanitize_hex_color', $candidates )
    );

    // Always ensure black and white are tested as final fallbacks.
    $candidates[] = '#000000';
    $candidates[] = '#ffffff';

    foreach ( $candidates as $candidate ) {
        if ( ! $candidate ) {
            continue;
        }

        if ( ! $background ) {
            return $candidate;
        }

        if ( beyond_gotham_get_contrast_ratio( $candidate, $background ) >= $threshold ) {
            return $candidate;
        }
    }

    return $preferred ? sanitize_hex_color( $preferred ) : null;
}

/**
 * Retrieve default navigation layout options.
 *
 * @return array
 */
function beyond_gotham_get_nav_layout_defaults() {
    return array(
        'orientation'   => 'horizontal',
        'position'      => 'right',
        'dropdown'      => 'down',
        'sticky'        => true,
        'sticky_offset' => 0,
    );
}

/**
 * Sanitize the navigation orientation choice.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_nav_orientation( $value ) {
    $value = is_string( $value ) ? strtolower( $value ) : '';

    if ( in_array( $value, array( 'horizontal', 'vertical' ), true ) ) {
        return $value;
    }

    return 'horizontal';
}

/**
 * Sanitize the navigation position choice.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_nav_position( $value ) {
    $value = is_string( $value ) ? strtolower( $value ) : '';
    $allowed = array( 'left', 'center', 'right', 'below' );

    if ( in_array( $value, $allowed, true ) ) {
        return $value;
    }

    return 'right';
}

/**
 * Sanitize the dropdown direction choice.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_nav_dropdown_direction( $value ) {
    $value = is_string( $value ) ? strtolower( $value ) : '';

    if ( in_array( $value, array( 'down', 'right' ), true ) ) {
        return $value;
    }

    return 'down';
}

/**
 * Retrieve sanitized navigation layout settings.
 *
 * @return array
 */
function beyond_gotham_get_nav_layout_settings() {
    $defaults = beyond_gotham_get_nav_layout_defaults();

    return array(
        'orientation'   => beyond_gotham_sanitize_nav_orientation( get_theme_mod( 'beyond_gotham_nav_orientation', $defaults['orientation'] ) ),
        'position'      => beyond_gotham_sanitize_nav_position( get_theme_mod( 'beyond_gotham_nav_position', $defaults['position'] ) ),
        'dropdown'      => beyond_gotham_sanitize_nav_dropdown_direction( get_theme_mod( 'beyond_gotham_nav_dropdown_direction', $defaults['dropdown'] ) ),
        'sticky'        => beyond_gotham_sanitize_checkbox( get_theme_mod( 'beyond_gotham_nav_sticky', $defaults['sticky'] ) ),
        'sticky_offset' => absint( get_theme_mod( 'beyond_gotham_nav_sticky_offset', $defaults['sticky_offset'] ) ),
    );
}

/**
 * Determine if sticky navigation is enabled in the Customizer preview.
 *
 * @param WP_Customize_Control $control Customizer control instance.
 * @return bool
 */
function beyond_gotham_customize_is_nav_sticky_active( $control ) {
    if ( ! $control instanceof WP_Customize_Control ) {
        return true;
    }

    $setting = $control->manager->get_setting( 'beyond_gotham_nav_sticky' );

    if ( ! $setting ) {
        return true;
    }

    return beyond_gotham_sanitize_checkbox( $setting->value() );
}

/**
 * Retrieve default CTA values for reuse.
 *
 * @return array
 */
function beyond_gotham_get_cta_defaults() {
    return array(
        'text'   => __( 'Bleibe informiert über neue Kurse, Einsatztrainings und OSINT-Ressourcen.', 'beyond_gotham' ),
        'label'  => __( 'Jetzt abonnieren', 'beyond_gotham' ),
        'url'    => home_url( '/newsletter/' ),
    );
}

/**
 * Provide dimension presets for the CTA layout.
 *
 * @return array
 */
/**
 * Default CTA layout configuration.
 *
 * @return array
 */
function beyond_gotham_get_cta_layout_defaults() {
    return array(
        'width'     => 200,
        'height'    => 60,
        'position'  => 'bottom',
        'alignment' => 'center',
    );
}

/**
 * Format CSS size values with units.
 *
 * @param float  $value Numeric value.
 * @param string $unit  CSS unit.
 * @return string
 */
function beyond_gotham_format_css_size( $value, $unit = 'px' ) {
    $value = beyond_gotham_sanitize_positive_float( $value );
    $unit  = beyond_gotham_sanitize_dimension_unit( $unit );

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

/**
 * Retrieve CTA layout settings merged with defaults and presets.
 *
 * @return array
 */
function beyond_gotham_get_cta_layout_settings() {
    $defaults = beyond_gotham_get_cta_layout_defaults();

    $width     = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_width', $defaults['width'] ) );
    $height    = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_height', $defaults['height'] ) );
    $position  = beyond_gotham_sanitize_cta_position( get_theme_mod( 'beyond_gotham_cta_position', $defaults['position'] ) );
    $alignment = beyond_gotham_sanitize_cta_alignment( get_theme_mod( 'beyond_gotham_cta_alignment', $defaults['alignment'] ) );

    if ( $width <= 0 ) {
        $legacy_width_unit  = get_theme_mod( 'beyond_gotham_cta_max_width_unit', 'px' );
        $legacy_width_value = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_max_width_value', 0 ) );

        if ( $legacy_width_value > 0 && 'px' === beyond_gotham_sanitize_dimension_unit( $legacy_width_unit ) ) {
            $width = $legacy_width_value;
        }
    }

    if ( $height <= 0 ) {
        $legacy_height = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_min_height', 0 ) );

        if ( $legacy_height > 0 ) {
            $height = $legacy_height;
        }
    }

    $width_css  = $width > 0 ? beyond_gotham_format_css_size( $width, 'px' ) : '';
    $height_css = $height > 0 ? beyond_gotham_format_css_size( $height, 'px' ) : '';

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

    return array(
        'width'       => $width,
        'height'      => $height,
        'width_css'   => $width_css,
        'height_css'  => $height_css,
        'position'    => $position,
        'alignment'   => $alignment,
        'class_list'  => array_values( array_unique( array_filter( array_map( 'sanitize_html_class', $classes ) ) ) ),
        'style_map'   => $style_map,
    );
}

/**
 * Retrieve the configured CTA content.
 *
 * @return array
 */
function beyond_gotham_get_cta_settings() {
    $defaults = beyond_gotham_get_cta_defaults();

    $text  = get_theme_mod( 'beyond_gotham_cta_text', $defaults['text'] );
    $label = get_theme_mod( 'beyond_gotham_cta_button_label', $defaults['label'] );
    $url   = get_theme_mod( 'beyond_gotham_cta_button_url', $defaults['url'] );

    return array(
        'text'  => wp_kses_post( $text ),
        'label' => sanitize_text_field( $label ),
        'url'   => beyond_gotham_sanitize_optional_url( $url ),
    );
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Beyond_Gotham_Customize_Heading_Control' ) ) {
    /**
     * Simple heading control for grouping customizer fields.
     */
    class Beyond_Gotham_Customize_Heading_Control extends WP_Customize_Control {
        /**
         * Control type.
         *
         * @var string
         */
        public $type = 'beyond-gotham-heading';

        /**
         * Render the control content.
         */
        public function render_content() {
            if ( ! empty( $this->label ) ) {
                echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
            }

            if ( ! empty( $this->description ) ) {
                echo '<p class="description customize-control-description">' . esc_html( $this->description ) . '</p>';
            }
        }
    }
}

/**
 * Register Customizer settings, sections and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function beyond_gotham_customize_register( WP_Customize_Manager $wp_customize ) {
    // Sections.
    $wp_customize->add_section(
        'beyond_gotham_theme_options',
        array(
            'title'       => __( 'Theme-Optionen', 'beyond_gotham' ),
            'priority'    => 30,
            'description' => __( 'Allgemeine Einstellungen für Branding-Elemente.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_panel(
        'beyond_gotham_color_modes',
        array(
            'title'       => __( 'Farben & Design (Light/Dark)', 'beyond_gotham' ),
            'priority'    => 31,
            'description' => __( 'Pflege getrennte Farbpaletten für helle und dunkle Darstellungen des Themes.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_section(
        'beyond_gotham_colors_light',
        array(
            'title'       => __( 'Light Mode Farben', 'beyond_gotham' ),
            'priority'    => 10,
            'panel'       => 'beyond_gotham_color_modes',
            'description' => __( 'Passe alle Farben für die helle Darstellung an.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_section(
        'beyond_gotham_colors_dark',
        array(
            'title'       => __( 'Dark Mode Farben', 'beyond_gotham' ),
            'priority'    => 20,
            'panel'       => 'beyond_gotham_color_modes',
            'description' => __( 'Definiere Farben speziell für den Dark Mode.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_section(
        'beyond_gotham_typography',
        array(
            'title'       => __( 'Typografie', 'beyond_gotham' ),
            'priority'    => 32,
            'description' => __( 'Passe Body- und Überschriften-Schriften an. Tipp: Wir empfehlen Inter für Fließtext und Merriweather für Headlines.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_section(
        'beyond_gotham_cta',
        array(
            'title'       => __( 'Call-to-Action', 'beyond_gotham' ),
            'priority'    => 40,
            'description' => __( 'Pflege Text, Button-Beschriftung und Ziel-Link für den Newsletter-Call-to-Action.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_section(
        'beyond_gotham_ui_layout',
        array(
            'title'       => __( 'UI Layout & Abstände', 'beyond_gotham' ),
            'priority'    => 41,
            'description' => __( 'Passe Position, Größe und Abstände zentral an.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_section(
        'beyond_gotham_footer',
        array(
            'title'       => __( 'Footer', 'beyond_gotham' ),
            'priority'    => 90,
            'description' => __( 'Gestalte Copyright- und Footer-Informationen.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_section(
        'beyond_gotham_social_media',
        array(
            'title'       => __( 'Social Media', 'beyond_gotham' ),
            'priority'    => 91,
            'description' => __( 'Links zu Social-Media-Profilen pflegen.', 'beyond_gotham' ),
        )
    );

    $nav_defaults = beyond_gotham_get_nav_layout_defaults();

    $wp_customize->add_section(
        'beyond_gotham_navigation_layout',
        array(
            'title'       => __( 'Navigation & Menü-Layout', 'beyond_gotham' ),
            'priority'    => 33,
            'description' => __( 'Hier kannst du Position und Ausrichtung des Hauptmenüs konfigurieren.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_nav_orientation',
        array(
            'default'           => $nav_defaults['orientation'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_nav_orientation',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_nav_orientation_control',
        array(
            'label'       => __( 'Menü-Ausrichtung', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_navigation_layout',
            'settings'    => 'beyond_gotham_nav_orientation',
            'type'        => 'radio',
            'choices'     => array(
                'horizontal' => __( 'Horizontal', 'beyond_gotham' ),
                'vertical'   => __( 'Vertikal', 'beyond_gotham' ),
            ),
            'description' => __( 'Steuert, ob die Hauptnavigation horizontal oder vertikal dargestellt wird.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_nav_position',
        array(
            'default'           => $nav_defaults['position'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_nav_position',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_nav_position_control',
        array(
            'label'       => __( 'Menü-Position im Header', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_navigation_layout',
            'settings'    => 'beyond_gotham_nav_position',
            'type'        => 'radio',
            'choices'     => array(
                'left'  => __( 'Links', 'beyond_gotham' ),
                'center' => __( 'Mitte', 'beyond_gotham' ),
                'right' => __( 'Rechts', 'beyond_gotham' ),
                'below' => __( 'Unter dem Logo (Full-Width Below Branding)', 'beyond_gotham' ),
            ),
            'description' => __( 'Wähle die Ausrichtung des Menüs innerhalb des Headers.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_nav_dropdown_direction',
        array(
            'default'           => $nav_defaults['dropdown'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_nav_dropdown_direction',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_nav_dropdown_direction_control',
        array(
            'label'       => __( 'Dropdown-Richtung', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_navigation_layout',
            'settings'    => 'beyond_gotham_nav_dropdown_direction',
            'type'        => 'radio',
            'choices'     => array(
                'down'  => __( 'Nach unten', 'beyond_gotham' ),
                'right' => __( 'Seitlich rechts', 'beyond_gotham' ),
            ),
            'description' => __( 'Bestimme, in welche Richtung Untermenüs aufklappen sollen.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_nav_sticky',
        array(
            'default'           => $nav_defaults['sticky'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_nav_sticky_control',
        array(
            'label'       => __( 'Sticky Header aktivieren', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_navigation_layout',
            'settings'    => 'beyond_gotham_nav_sticky',
            'type'        => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_nav_sticky_offset',
        array(
            'default'           => $nav_defaults['sticky_offset'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'absint',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_nav_sticky_offset_control',
        array(
            'label'           => __( 'Sticky-Offset (px)', 'beyond_gotham' ),
            'section'         => 'beyond_gotham_navigation_layout',
            'settings'        => 'beyond_gotham_nav_sticky_offset',
            'type'            => 'number',
            'input_attrs'     => array(
                'min'  => 0,
                'max'  => 300,
                'step' => 1,
            ),
            'description'     => __( 'Optionaler Versatz vom oberen Bildschirmrand für den Sticky-Header.', 'beyond_gotham' ),
            'active_callback' => 'beyond_gotham_customize_is_nav_sticky_active',
        )
    );

    // Branding images.
    $wp_customize->add_setting(
        'beyond_gotham_brand_logo',
        array(
            'type'              => 'theme_mod',
            'sanitize_callback' => 'absint',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'beyond_gotham_brand_logo_control',
            array(
                'label'       => __( 'Alternatives Markenlogo', 'beyond_gotham' ),
                'description' => __( 'Überschreibt das globale Logo aus der Website-Identität. Ideal für abgewandelte Varianten.', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_theme_options',
                'settings'    => 'beyond_gotham_brand_logo',
            )
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_brand_favicon',
        array(
            'type'              => 'theme_mod',
            'sanitize_callback' => 'absint',
            'capability'        => 'edit_theme_options',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'beyond_gotham_brand_favicon_control',
            array(
                'label'       => __( 'Favicon (Brand Icon)', 'beyond_gotham' ),
                'description' => __( 'Optionales Favicon, falls kein globales Website-Icon gesetzt ist.', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_theme_options',
                'settings'    => 'beyond_gotham_brand_favicon',
            )
        )
    );

    // Colors.
    $color_modes = array(
        'light' => array(
            'section' => 'beyond_gotham_colors_light',
            'label'   => __( 'Light Mode', 'beyond_gotham' ),
        ),
        'dark'  => array(
            'section' => 'beyond_gotham_colors_dark',
            'label'   => __( 'Dark Mode', 'beyond_gotham' ),
        ),
    );

    $color_controls = array(
        'primary_color' => array(
            'label'       => __( 'Primärfarbe', 'beyond_gotham' ),
            'description' => __( 'Haupt-Akzentfarbe für Buttons, Links und Highlights.', 'beyond_gotham' ),
            'defaults'    => array(
                'light' => '#33d1ff',
                'dark'  => '#33d1ff',
            ),
        ),
        'secondary_color' => array(
            'label'       => __( 'Sekundärfarbe', 'beyond_gotham' ),
            'description' => __( 'Alternative Akzentfarbe für Hover-Effekte und Highlights.', 'beyond_gotham' ),
            'defaults'    => array(
                'light' => '#1aa5d1',
                'dark'  => '#1aa5d1',
            ),
        ),
        'background_color' => array(
            'label'       => __( 'Seitenhintergrund', 'beyond_gotham' ),
            'description' => __( 'Hintergrundfarbe für Body, Panels und Flächen.', 'beyond_gotham' ),
            'defaults'    => array(
                'light' => '#f4f6fb',
                'dark'  => '#0f1115',
            ),
        ),
        'text_color' => array(
            'label'       => __( 'Textfarbe', 'beyond_gotham' ),
            'description' => __( 'Primäre Textfarbe für Fließtext und Überschriften.', 'beyond_gotham' ),
            'defaults'    => array(
                'light' => '#0f172a',
                'dark'  => '#e7eaee',
            ),
        ),
        'cta_accent_color' => array(
            'label'       => __( 'CTA-Akzentfarbe', 'beyond_gotham' ),
            'description' => __( 'Steuert den Farbverlauf sowie Buttons in der Newsletter-CTA-Box.', 'beyond_gotham' ),
            'defaults'    => array(
                'light' => '#33d1ff',
                'dark'  => '#33d1ff',
            ),
        ),
        'header_background_color' => array(
            'label'       => __( 'Header-Hintergrund', 'beyond_gotham' ),
            'description' => __( 'Farbe für den Hintergrund der Hauptnavigation inklusive Transparenzeffekte.', 'beyond_gotham' ),
            'defaults'    => array(
                'light' => '#ffffff',
                'dark'  => '#0b0d12',
            ),
        ),
        'footer_background_color' => array(
            'label'       => __( 'Footer-Hintergrund', 'beyond_gotham' ),
            'description' => __( 'Farbe des Seitenfußes inklusive CTA-Bereich.', 'beyond_gotham' ),
            'defaults'    => array(
                'light' => '#f4f6fb',
                'dark'  => '#050608',
            ),
        ),
        'link_color' => array(
            'label'       => __( 'Linkfarbe', 'beyond_gotham' ),
            'description' => __( 'Standardfarbe für Textlinks im gesamten Theme.', 'beyond_gotham' ),
            'defaults'    => array(
                'light' => '#0f172a',
                'dark'  => '#33d1ff',
            ),
        ),
        'link_hover_color' => array(
            'label'       => __( 'Link-Hover-Farbe', 'beyond_gotham' ),
            'description' => __( 'Farbe für Hover-, Fokus- und aktive Zustände von Links.', 'beyond_gotham' ),
            'defaults'    => array(
                'light' => '#1aa5d1',
                'dark'  => '#1aa5d1',
            ),
        ),
        'button_background_color' => array(
            'label'       => __( 'Button-Hintergrundfarbe', 'beyond_gotham' ),
            'description' => __( 'Hintergrund- und Rahmenfarbe für Buttons und Formularaktionen.', 'beyond_gotham' ),
            'defaults'    => array(
                'light' => '#33d1ff',
                'dark'  => '#33d1ff',
            ),
        ),
        'button_text_color' => array(
            'label'       => __( 'Button-Textfarbe', 'beyond_gotham' ),
            'description' => __( 'Textfarbe für Buttons, damit Beschriftungen immer gut lesbar bleiben.', 'beyond_gotham' ),
            'defaults'    => array(
                'light' => '#050608',
                'dark'  => '#050608',
            ),
        ),
        'quote_background_color' => array(
            'label'       => __( 'Zitat- & Highlight-Hintergrund', 'beyond_gotham' ),
            'description' => __( 'Steuert Hintergründe von Blockquotes, Pullquotes und Highlight-Boxen.', 'beyond_gotham' ),
            'defaults'    => array(
                'light' => '#e6edf7',
                'dark'  => '#161b2a',
            ),
        ),
    );

    foreach ( $color_controls as $setting_key => $control_args ) {
        $legacy_setting = 'beyond_gotham_' . $setting_key;

        foreach ( $color_modes as $mode_key => $mode_args ) {
            $setting_id   = 'beyond_gotham_' . $setting_key . '_' . $mode_key;
            $control_id   = $setting_id . '_control';
            $mode_default = isset( $control_args['defaults'][ $mode_key ] ) ? $control_args['defaults'][ $mode_key ] : '';
            $legacy_value = sanitize_hex_color( get_theme_mod( $legacy_setting ) );

            if ( $legacy_value ) {
                $mode_default = $legacy_value;
            }

            $wp_customize->add_setting(
                $setting_id,
                array(
                    'default'           => $mode_default,
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

    // Typography.
    $wp_customize->add_setting(
        'beyond_gotham_body_font_family',
        array(
            'default'           => 'inter',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_typography_choice',
            'transport'         => 'postMessage',
        )
    );

    $presets = beyond_gotham_get_typography_presets();
    $choices = array();
    foreach ( $presets as $key => $preset ) {
        $choices[ $key ] = $preset['label'];
    }

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
                'min'  => 0.8,
                'max'  => 24,
                'step' => 0.1,
            ),
            'description' => __( 'Passe die Basisgröße für Text an. Die Einheit bestimmst du unten.', 'beyond_gotham' ),
        )
    );

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
            'label'    => __( 'Einheit der Grundschriftgröße', 'beyond_gotham' ),
            'section'  => 'beyond_gotham_typography',
            'settings' => 'beyond_gotham_body_font_size_unit',
            'type'     => 'radio',
            'choices'  => array(
                'px'  => __( 'Pixel (px)', 'beyond_gotham' ),
                'rem' => __( 'Relative Einheit (rem)', 'beyond_gotham' ),
            ),
        )
    );

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
                'min'  => 1.2,
                'max'  => 2.2,
                'step' => 0.1,
            ),
        )
    );

    $cta_defaults = beyond_gotham_get_cta_defaults();

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
            'label'       => __( 'CTA-Text', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta',
            'settings'    => 'beyond_gotham_cta_text',
            'type'        => 'textarea',
            'description' => __( 'Formuliere den Newsletter-Call-to-Action.', 'beyond_gotham' ),
        )
    );

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
            'label'       => __( 'CTA-Button-Label', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta',
            'settings'    => 'beyond_gotham_cta_button_label',
            'type'        => 'text',
        )
    );

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
            'label'       => __( 'CTA-Link (URL)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta',
            'settings'    => 'beyond_gotham_cta_button_url',
            'type'        => 'url',
            'description' => __( 'Verlinke zu deinem Newsletter- oder Landingpage-Tool.', 'beyond_gotham' ),
        )
    );

    $layout_defaults     = beyond_gotham_get_ui_layout_defaults();
    $cta_layout_defaults = beyond_gotham_get_cta_layout_defaults();

    $layout_priority = 5;

    $stored_cta_width   = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_width', 0 ) );
    $legacy_width_unit  = beyond_gotham_sanitize_dimension_unit( get_theme_mod( 'beyond_gotham_cta_max_width_unit', 'px' ) );
    $legacy_width_value = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_max_width_value', 0 ) );
    $cta_width_default  = $stored_cta_width > 0 ? $stored_cta_width : ( ( $legacy_width_value > 0 && 'px' === $legacy_width_unit ) ? $legacy_width_value : $cta_layout_defaults['width'] );

    $stored_cta_height  = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_height', 0 ) );
    $legacy_height      = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_min_height', 0 ) );
    $cta_height_default = $stored_cta_height > 0 ? $stored_cta_height : ( $legacy_height > 0 ? $legacy_height : $cta_layout_defaults['height'] );

    if ( class_exists( 'Beyond_Gotham_Customize_Heading_Control' ) ) {
        $wp_customize->add_control(
            new Beyond_Gotham_Customize_Heading_Control(
                $wp_customize,
                'beyond_gotham_ui_layout_header_heading',
                array(
                    'section'     => 'beyond_gotham_ui_layout',
                    'label'       => __( 'Header', 'beyond_gotham' ),
                    'description' => __( 'Steuerung von Höhe und vertikalen Abständen der Kopfzeile.', 'beyond_gotham' ),
                    'priority'    => $layout_priority,
                )
            )
        );
    }

    $layout_priority += 5;

    $wp_customize->add_setting(
        'beyond_gotham_header_height',
        array(
            'default'           => $layout_defaults['header_height'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_header_height_control',
        array(
            'label'       => __( 'Höhe (px)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_header_height',
            'type'        => 'number',
            'priority'    => $layout_priority,
            'input_attrs' => array(
                'min'  => 48,
                'max'  => 320,
                'step' => 1,
            ),
        )
    );

    $layout_priority += 5;

    $wp_customize->add_setting(
        'beyond_gotham_header_padding_top',
        array(
            'default'           => $layout_defaults['header_padding_top'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_header_padding_top_control',
        array(
            'label'       => __( 'Padding oben (px)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_header_padding_top',
            'type'        => 'number',
            'priority'    => $layout_priority,
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 160,
                'step' => 1,
            ),
        )
    );

    $layout_priority += 5;

    $wp_customize->add_setting(
        'beyond_gotham_header_padding_bottom',
        array(
            'default'           => $layout_defaults['header_padding_bottom'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_header_padding_bottom_control',
        array(
            'label'       => __( 'Padding unten (px)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_header_padding_bottom',
            'type'        => 'number',
            'priority'    => $layout_priority,
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 160,
                'step' => 1,
            ),
        )
    );

    $layout_priority += 5;

    if ( class_exists( 'Beyond_Gotham_Customize_Heading_Control' ) ) {
        $wp_customize->add_control(
            new Beyond_Gotham_Customize_Heading_Control(
                $wp_customize,
                'beyond_gotham_ui_layout_footer_heading',
                array(
                    'section'     => 'beyond_gotham_ui_layout',
                    'label'       => __( 'Footer', 'beyond_gotham' ),
                    'description' => __( 'Höhe und Abstand der Fußzeile zum Inhalt.', 'beyond_gotham' ),
                    'priority'    => $layout_priority,
                )
            )
        );
    }

    $layout_priority += 5;

    $wp_customize->add_setting(
        'beyond_gotham_footer_min_height',
        array(
            'default'           => $layout_defaults['footer_min_height'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_footer_min_height_control',
        array(
            'label'       => __( 'Mindesthöhe (px)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_footer_min_height',
            'type'        => 'number',
            'priority'    => $layout_priority,
            'input_attrs' => array(
                'min'  => 80,
                'max'  => 600,
                'step' => 1,
            ),
        )
    );

    $layout_priority += 5;

    $wp_customize->add_setting(
        'beyond_gotham_footer_margin_top',
        array(
            'default'           => $layout_defaults['footer_margin_top'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_footer_margin_top_control',
        array(
            'label'       => __( 'Abstand zum Content (px)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_footer_margin_top',
            'type'        => 'number',
            'priority'    => $layout_priority,
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 240,
                'step' => 1,
            ),
        )
    );

    $layout_priority += 5;

    if ( class_exists( 'Beyond_Gotham_Customize_Heading_Control' ) ) {
        $wp_customize->add_control(
            new Beyond_Gotham_Customize_Heading_Control(
                $wp_customize,
                'beyond_gotham_ui_layout_cta_heading',
                array(
                    'section'     => 'beyond_gotham_ui_layout',
                    'label'       => __( 'CTA-Box', 'beyond_gotham' ),
                    'description' => __( 'Steuere Breite, Höhe und Ausrichtung der Call-to-Action.', 'beyond_gotham' ),
                    'priority'    => $layout_priority,
                )
            )
        );
    }

    $layout_priority += 5;

    $wp_customize->add_setting(
        'beyond_gotham_cta_width',
        array(
            'default'           => $cta_width_default,
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_cta_width_control',
        array(
            'label'       => __( 'CTA-Breite', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_cta_width',
            'type'        => 'range',
            'input_attrs' => array(
                'min'  => 200,
                'max'  => 1000,
                'step' => 10,
            ),
            'description' => __( 'Definiert die Breite der CTA-Box in Pixeln.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_cta_height',
        array(
            'default'           => $cta_height_default,
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_cta_height_control',
        array(
            'label'       => __( 'CTA-Höhe', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_cta_height',
            'type'        => 'range',
            'input_attrs' => array(
                'min'  => 100,
                'max'  => 500,
                'step' => 10,
            ),
            'description' => __( 'Stellt die Höhe der CTA-Box in Pixeln ein.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_cta_position',
        array(
            'default'           => $cta_layout_defaults['position'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_cta_position',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_cta_position_control',
        array(
            'label'    => __( 'Position der CTA-Box', 'beyond_gotham' ),
            'section'  => 'beyond_gotham_ui_layout',
            'settings' => 'beyond_gotham_cta_position',
            'type'     => 'select',
            'choices'  => array(
                'top'    => __( 'Oben (unter dem Hero-Bereich)', 'beyond_gotham' ),
                'bottom' => __( 'Unterhalb des Contents', 'beyond_gotham' ),
                'fixed'  => __( 'Fixiert am unteren Bildschirmrand', 'beyond_gotham' ),
            ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_cta_alignment',
        array(
            'default'           => $cta_layout_defaults['alignment'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_cta_alignment',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_cta_alignment_control',
        array(
            'label'    => __( 'Ausrichtung innerhalb des Containers', 'beyond_gotham' ),
            'section'  => 'beyond_gotham_ui_layout',
            'settings' => 'beyond_gotham_cta_alignment',
            'type'     => 'radio',
            'choices'  => array(
                'left'   => __( 'Links', 'beyond_gotham' ),
                'center' => __( 'Zentriert', 'beyond_gotham' ),
                'right'  => __( 'Rechts', 'beyond_gotham' ),
            ),
        )
    );

    $layout_priority += 5;

    if ( class_exists( 'Beyond_Gotham_Customize_Heading_Control' ) ) {
        $wp_customize->add_control(
            new Beyond_Gotham_Customize_Heading_Control(
                $wp_customize,
                'beyond_gotham_ui_layout_buttons_heading',
                array(
                    'section'     => 'beyond_gotham_ui_layout',
                    'label'       => __( 'Buttons', 'beyond_gotham' ),
                    'description' => __( 'Globale Steuerung für Button-Größen und Rundungen.', 'beyond_gotham' ),
                    'priority'    => $layout_priority,
                )
            )
        );
    }

    $layout_priority += 5;

    $wp_customize->add_setting(
        'beyond_gotham_button_padding_vertical',
        array(
            'default'           => $layout_defaults['button_padding_vertical'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_button_padding_vertical_control',
        array(
            'label'       => __( 'Padding vertikal (px)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_button_padding_vertical',
            'type'        => 'number',
            'priority'    => $layout_priority,
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 120,
                'step' => 1,
            ),
        )
    );

    $layout_priority += 5;

    $wp_customize->add_setting(
        'beyond_gotham_button_padding_horizontal',
        array(
            'default'           => $layout_defaults['button_padding_horizontal'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_button_padding_horizontal_control',
        array(
            'label'       => __( 'Padding horizontal (px)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_button_padding_horizontal',
            'type'        => 'number',
            'priority'    => $layout_priority,
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 200,
                'step' => 1,
            ),
        )
    );

    $layout_priority += 5;

    $wp_customize->add_setting(
        'beyond_gotham_button_border_radius',
        array(
            'default'           => $layout_defaults['button_border_radius'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_button_border_radius_control',
        array(
            'label'       => __( 'Border Radius (px)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_button_border_radius',
            'type'        => 'number',
            'priority'    => $layout_priority,
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 999,
                'step' => 1,
            ),
        )
    );

    $layout_priority += 5;

    if ( class_exists( 'Beyond_Gotham_Customize_Heading_Control' ) ) {
        $wp_customize->add_control(
            new Beyond_Gotham_Customize_Heading_Control(
                $wp_customize,
                'beyond_gotham_ui_layout_thumbnails_heading',
                array(
                    'section'     => 'beyond_gotham_ui_layout',
                    'label'       => __( 'Artikelbilder', 'beyond_gotham' ),
                    'description' => __( 'Bestimme Seitenverhältnis und maximale Breite für Thumbnails.', 'beyond_gotham' ),
                    'priority'    => $layout_priority,
                )
            )
        );
    }

    $layout_priority += 5;

    $wp_customize->add_setting(
        'beyond_gotham_thumbnail_aspect_ratio',
        array(
            'default'           => $layout_defaults['thumbnail_aspect_ratio'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_aspect_ratio_choice',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_thumbnail_aspect_ratio_control',
        array(
            'label'    => __( 'Seitenverhältnis', 'beyond_gotham' ),
            'section'  => 'beyond_gotham_ui_layout',
            'settings' => 'beyond_gotham_thumbnail_aspect_ratio',
            'type'     => 'select',
            'choices'  => array(
                '16-9' => '16:9',
                '4-3'  => '4:3',
                '1-1'  => '1:1',
            ),
            'priority' => $layout_priority,
        )
    );

    $layout_priority += 5;

    $wp_customize->add_setting(
        'beyond_gotham_thumbnail_max_width_value',
        array(
            'default'           => $layout_defaults['thumbnail_max_width_value'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_thumbnail_max_width_value_control',
        array(
            'label'       => __( 'Maximale Breite', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_thumbnail_max_width_value',
            'type'        => 'number',
            'priority'    => $layout_priority,
            'input_attrs' => array(
                'min'  => 40,
                'max'  => 2400,
                'step' => 1,
            ),
            'description' => __( 'Wert ohne Einheit. Unten auswählen, ob in Pixel oder Prozent.', 'beyond_gotham' ),
        )
    );

    $layout_priority += 5;

    $wp_customize->add_setting(
        'beyond_gotham_thumbnail_max_width_unit',
        array(
            'default'           => $layout_defaults['thumbnail_max_width_unit'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_dimension_unit',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_thumbnail_max_width_unit_control',
        array(
            'label'    => __( 'Einheit der Maximalbreite', 'beyond_gotham' ),
            'section'  => 'beyond_gotham_ui_layout',
            'settings' => 'beyond_gotham_thumbnail_max_width_unit',
            'type'     => 'radio',
            'choices'  => array(
                'px' => __( 'Pixel (px)', 'beyond_gotham' ),
                '%'  => __( 'Prozent (%)', 'beyond_gotham' ),
            ),
            'priority' => $layout_priority,
        )
    );

    $layout_priority += 5;

    if ( class_exists( 'Beyond_Gotham_Customize_Heading_Control' ) ) {
        $wp_customize->add_control(
            new Beyond_Gotham_Customize_Heading_Control(
                $wp_customize,
                'beyond_gotham_ui_layout_content_heading',
                array(
                    'section'     => 'beyond_gotham_ui_layout',
                    'label'       => __( 'Content-Margins', 'beyond_gotham' ),
                    'description' => __( 'Definiere maximale Breite und vertikalen Abstand für Inhalte.', 'beyond_gotham' ),
                    'priority'    => $layout_priority,
                )
            )
        );
    }

    $layout_priority += 5;

    $wp_customize->add_setting(
        'beyond_gotham_content_max_width',
        array(
            'default'           => $layout_defaults['content_max_width'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_content_max_width_control',
        array(
            'label'       => __( 'Maximale Inhaltsbreite (px)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_content_max_width',
            'type'        => 'number',
            'priority'    => $layout_priority,
            'input_attrs' => array(
                'min'  => 640,
                'max'  => 2400,
                'step' => 10,
            ),
        )
    );

    $layout_priority += 5;

    $wp_customize->add_setting(
        'beyond_gotham_content_section_spacing',
        array(
            'default'           => $layout_defaults['content_section_spacing'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_content_section_spacing_control',
        array(
            'label'       => __( 'Abstand zwischen Sections (px)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_content_section_spacing',
            'type'        => 'number',
            'priority'    => $layout_priority,
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 240,
                'step' => 1,
            ),
        )
    );

    // Footer text.
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
            'label'       => __( 'Social Icons im Footer anzeigen', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_footer',
            'settings'    => 'beyond_gotham_footer_show_social',
            'type'        => 'checkbox',
        )
    );

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

    // Social links.
    $wp_customize->add_setting(
        'beyond_gotham_social_twitter',
        array(
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_optional_url',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_social_twitter_control',
        array(
            'label'       => __( 'Twitter / X URL', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_social_twitter',
            'type'        => 'url',
            'description' => __( 'Beispiel: https://twitter.com/beyondgotham', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_social_mastodon',
        array(
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_optional_url',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_social_mastodon_control',
        array(
            'label'       => __( 'Mastodon URL', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_social_mastodon',
            'type'        => 'url',
            'description' => __( 'Beispiel: https://chaos.social/@beyondgotham', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_social_github',
        array(
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_optional_url',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_social_github_control',
        array(
            'label'       => __( 'GitHub URL', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_social_github',
            'type'        => 'url',
            'description' => __( 'Beispiel: https://github.com/beyondgotham', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_social_linkedin',
        array(
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_optional_url',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_social_linkedin_control',
        array(
            'label'       => __( 'LinkedIn URL', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_social_linkedin',
            'type'        => 'url',
            'description' => __( 'Beispiel: https://www.linkedin.com/company/beyondgotham', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_social_email',
        array(
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_optional_email',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_social_email_control',
        array(
            'label'       => __( 'E-Mail-Adresse', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_social_email',
            'type'        => 'text',
            'description' => __( 'Beispiel: redaktion@beyondgotham.org', 'beyond_gotham' ),
        )
    );
}
add_action( 'customize_register', 'beyond_gotham_customize_register' );

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
 * Retrieve the brand logo attachment ID (custom override takes precedence).
 *
 * @return int
 */
function beyond_gotham_get_brand_logo_id() {
    $custom_logo = (int) get_theme_mod( 'beyond_gotham_brand_logo' );

    if ( $custom_logo ) {
        return $custom_logo;
    }

    return (int) get_theme_mod( 'custom_logo' );
}

/**
 * Retrieve configured social links as a keyed array.
 *
 * @return array
 */
function beyond_gotham_get_social_links() {
    $links = array(
        'twitter'  => beyond_gotham_sanitize_optional_url( get_theme_mod( 'beyond_gotham_social_twitter', '' ) ),
        'mastodon' => beyond_gotham_sanitize_optional_url( get_theme_mod( 'beyond_gotham_social_mastodon', '' ) ),
        'github'   => beyond_gotham_sanitize_optional_url( get_theme_mod( 'beyond_gotham_social_github', '' ) ),
        'linkedin' => beyond_gotham_sanitize_optional_url( get_theme_mod( 'beyond_gotham_social_linkedin', '' ) ),
    );

    $email = beyond_gotham_sanitize_optional_email( get_theme_mod( 'beyond_gotham_social_email', '' ) );

    if ( $email ) {
        $links['email'] = 'mailto:' . $email;
    }

    return array_filter(
        $links,
        static function ( $value ) {
            return ! empty( $value );
        }
    );
}

/**
 * Output social navigation markup based on the theme options.
 *
 * @param array|null $links Optional link data to render.
 */
function beyond_gotham_render_social_links( $links = null ) {
    if ( null === $links ) {
        $links = beyond_gotham_get_social_links();
    }

    if ( empty( $links ) ) {
        return;
    }

    echo '<ul class="site-nav__social site-nav__social--theme">';

    $labels = array(
        'twitter'  => __( 'Twitter', 'beyond_gotham' ),
        'mastodon' => __( 'Mastodon', 'beyond_gotham' ),
        'github'   => __( 'GitHub', 'beyond_gotham' ),
        'linkedin' => __( 'LinkedIn', 'beyond_gotham' ),
        'email'    => __( 'E-Mail', 'beyond_gotham' ),
    );

    foreach ( $links as $network => $url ) {
        $label        = isset( $labels[ $network ] ) ? $labels[ $network ] : ucfirst( $network );
        $network_slug = $network;

        if ( function_exists( 'beyond_gotham_detect_social_network' ) ) {
            $network_slug = beyond_gotham_detect_social_network( $url ) ?: $network;
        }

        $initial = function_exists( 'mb_substr' )
            ? mb_strtoupper( mb_substr( $label, 0, 2 ) )
            : strtoupper( substr( $label, 0, 2 ) );

        $is_mail = 0 === strpos( $url, 'mailto:' );

        echo '<li class="site-nav__social-item">';
        echo '<a class="bg-social-link" href="' . esc_url( $url ) . '"' . ( $is_mail ? '' : ' target="_blank" rel="noopener"' ) . ' data-network="' . esc_attr( $network_slug ) . '">';
        echo '<span class="bg-social-link__icon" aria-hidden="true" data-initial="' . esc_attr( $initial ) . '"></span>';
        echo '<span class="bg-social-link__text">' . esc_html( $label ) . '</span>';
        echo '</a>';
        echo '</li>';
    }

    echo '</ul>';
}

/**
 * Build CSS variables and typography from Customizer values.
 *
 * @return string
 */
/**
 * Retrieve selectors that scope styles to a specific color mode.
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

        $background = $palette['background'];
        $primary    = $palette['primary'];
        $secondary  = $palette['secondary'];
        $cta_accent = $palette['cta_accent'];
        $text_raw   = $palette['text'];

        $text_color = beyond_gotham_ensure_contrast(
            $text_raw,
            $background,
            array( $defaults['text'], $defaults['text_dark'] )
        );
        if ( ! $text_color ) {
            $text_color = $defaults['text'];
        }
        $palette['text'] = $text_color;

        $palette['header_background'] = beyond_gotham_ensure_contrast(
            $palette['header_background'],
            $text_color,
            array( $defaults['header_background'], $background )
        ) ?: $defaults['header_background'];

        $palette['footer_background'] = beyond_gotham_ensure_contrast(
            $palette['footer_background'],
            $text_color,
            array( $defaults['footer_background'], $background )
        ) ?: $defaults['footer_background'];

        $palette['link'] = beyond_gotham_ensure_contrast(
            $palette['link'],
            $background,
            array( $defaults['link'], $primary, $secondary, $defaults['text_dark'], $text_color )
        ) ?: $defaults['link'];

        $palette['link_hover'] = beyond_gotham_ensure_contrast(
            $palette['link_hover'],
            $background,
            array( $palette['link'], $defaults['link_hover'], $secondary, $primary, $defaults['text_dark'], $text_color )
        ) ?: $defaults['link_hover'];

        $palette['button_text'] = beyond_gotham_ensure_contrast(
            $palette['button_text'],
            $palette['button_background'],
            array( $defaults['button_text'], $text_color, $defaults['text_dark'], '#ffffff' )
        ) ?: $defaults['button_text'];

        $palette['quote_background'] = beyond_gotham_ensure_contrast(
            $palette['quote_background'],
            $text_color,
            array( $defaults['quote_background'], $background )
        ) ?: $defaults['quote_background'];

        $palette['quote_border'] = beyond_gotham_hex_to_rgba( $palette['quote_background'], 0.35 );
        $palette['cta_accent']   = $cta_accent;

        $palettes[ $mode ] = $palette;
    }

    $body_font_key = beyond_gotham_sanitize_typography_choice( get_theme_mod( 'beyond_gotham_body_font_family', 'inter' ) );
    $heading_key   = beyond_gotham_sanitize_typography_choice( get_theme_mod( 'beyond_gotham_heading_font_family', 'merriweather' ) );
    $font_size     = (float) get_theme_mod( 'beyond_gotham_body_font_size', 16 );
    $font_unit     = beyond_gotham_sanitize_font_unit( get_theme_mod( 'beyond_gotham_body_font_size_unit', 'px' ) );
    $line_height   = (float) get_theme_mod( 'beyond_gotham_body_line_height', 1.6 );
    $presets        = beyond_gotham_get_typography_presets();
    $nav_layout     = beyond_gotham_get_nav_layout_settings();
    $ui_layout      = beyond_gotham_get_ui_layout_settings();
    $header_layout  = isset( $ui_layout['header'] ) ? $ui_layout['header'] : array();
    $footer_layout  = isset( $ui_layout['footer'] ) ? $ui_layout['footer'] : array();
    $buttons_layout = isset( $ui_layout['buttons'] ) ? $ui_layout['buttons'] : array();
    $thumbnail_layout = isset( $ui_layout['thumbnails'] ) ? $ui_layout['thumbnails'] : array();
    $content_layout = isset( $ui_layout['content'] ) ? $ui_layout['content'] : array();
    $sticky_offset  = isset( $nav_layout['sticky_offset'] ) ? absint( $nav_layout['sticky_offset'] ) : 0;

    if ( empty( $nav_layout['sticky'] ) ) {
        $sticky_offset = 0;
    }

    if ( 'rem' === $font_unit ) {
        $font_size       = max( 0.5, min( 3, $font_size ) );
        $font_size_value = rtrim( rtrim( sprintf( '%.2f', $font_size ), '0' ), '.' );
    } else {
        $font_size       = max( 12, min( 26, $font_size ) );
        $font_size_value = (string) round( $font_size );
    }

    if ( $line_height <= 0 ) {
        $line_height = 1.6;
    }

    $line_height       = max( 1.1, min( 2.6, $line_height ) );
    $line_height_value = rtrim( rtrim( sprintf( '%.2f', $line_height ), '0' ), '.' );

    $layout_root_vars = array();

    if ( ! empty( $header_layout['height_css'] ) ) {
        $layout_root_vars['--site-header-height'] = $header_layout['height_css'];
    }

    if ( isset( $header_layout['padding_top_css'] ) && '' !== $header_layout['padding_top_css'] ) {
        $layout_root_vars['--site-header-padding-top'] = $header_layout['padding_top_css'];
    }

    if ( isset( $header_layout['padding_bottom_css'] ) && '' !== $header_layout['padding_bottom_css'] ) {
        $layout_root_vars['--site-header-padding-bottom'] = $header_layout['padding_bottom_css'];
    }

    if ( ! empty( $footer_layout['min_height_css'] ) ) {
        $layout_root_vars['--site-footer-min-height'] = $footer_layout['min_height_css'];
    }

    if ( isset( $footer_layout['margin_top_css'] ) && '' !== $footer_layout['margin_top_css'] ) {
        $layout_root_vars['--site-footer-margin-top'] = $footer_layout['margin_top_css'];
    }

    if ( isset( $buttons_layout['padding_vertical_css'] ) && '' !== $buttons_layout['padding_vertical_css'] ) {
        $layout_root_vars['--ui-button-padding-y'] = $buttons_layout['padding_vertical_css'];
    }

    if ( isset( $buttons_layout['padding_horizontal_css'] ) && '' !== $buttons_layout['padding_horizontal_css'] ) {
        $layout_root_vars['--ui-button-padding-x'] = $buttons_layout['padding_horizontal_css'];
    }

    if ( isset( $buttons_layout['border_radius_css'] ) && '' !== $buttons_layout['border_radius_css'] ) {
        $layout_root_vars['--ui-button-radius'] = $buttons_layout['border_radius_css'];
    }

    if ( isset( $thumbnail_layout['aspect_ratio_css'] ) && '' !== $thumbnail_layout['aspect_ratio_css'] ) {
        $layout_root_vars['--post-thumbnail-aspect-ratio'] = $thumbnail_layout['aspect_ratio_css'];
    }

    if ( isset( $thumbnail_layout['max_width_css'] ) && '' !== $thumbnail_layout['max_width_css'] ) {
        $layout_root_vars['--post-thumbnail-max-width'] = $thumbnail_layout['max_width_css'];
    }

    if ( ! empty( $content_layout['max_width_css'] ) ) {
        $layout_root_vars['--content-max-width'] = $content_layout['max_width_css'];
    }

    if ( isset( $content_layout['section_spacing_css'] ) && '' !== $content_layout['section_spacing_css'] ) {
        $layout_root_vars['--content-section-gap'] = $content_layout['section_spacing_css'];
    }

    $css = ':root {';
    $css .= '--bg-sticky-offset: ' . $sticky_offset . 'px;';

    foreach ( $layout_root_vars as $var_name => $value ) {
        if ( '' === $value ) {
            continue;
        }

        $css .= $var_name . ': ' . $value . ';';
    }

    $css .= '}' . PHP_EOL;

    foreach ( $palettes as $mode => $palette ) {
        $prefixes     = beyond_gotham_get_color_mode_prefixes( $mode );
        $root_selector = implode( ', ', $prefixes );

        $root_rules = array();

        if ( ! empty( $palette['primary'] ) ) {
            $root_rules[] = '--accent: ' . $palette['primary'] . ';';
        }

        if ( ! empty( $palette['secondary'] ) ) {
            $root_rules[] = '--accent-alt: ' . $palette['secondary'] . ';';
        }

        if ( ! empty( $palette['background'] ) ) {
            $root_rules[] = '--bg: ' . $palette['background'] . ';';
        }

        if ( ! empty( $palette['text'] ) ) {
            $root_rules[] = '--fg: ' . $palette['text'] . ';';
        }

        if ( ! empty( $palette['cta_accent'] ) ) {
            $root_rules[] = '--cta-accent: ' . $palette['cta_accent'] . ';';
        }

        if ( ! empty( $palette['header_background'] ) ) {
            $root_rules[] = '--bg-header: ' . $palette['header_background'] . ';';
        }

        if ( ! empty( $palette['footer_background'] ) ) {
            $root_rules[] = '--bg-footer: ' . $palette['footer_background'] . ';';
        }

        if ( ! empty( $palette['link'] ) ) {
            $root_rules[] = '--link-color: ' . $palette['link'] . ';';
        }

        if ( ! empty( $palette['link_hover'] ) ) {
            $root_rules[] = '--link-hover-color: ' . $palette['link_hover'] . ';';
        }

        if ( ! empty( $palette['button_background'] ) ) {
            $root_rules[] = '--button-bg: ' . $palette['button_background'] . ';';
        }

        if ( ! empty( $palette['button_text'] ) ) {
            $root_rules[] = '--button-fg: ' . $palette['button_text'] . ';';
        }

        if ( ! empty( $palette['quote_background'] ) ) {
            $root_rules[] = '--callout-bg: ' . $palette['quote_background'] . ';';
        }

        if ( ! empty( $palette['quote_border'] ) ) {
            $root_rules[] = '--callout-border: ' . $palette['quote_border'] . ';';
        }

        if ( ! empty( $root_rules ) ) {
            $css .= $root_selector . ' {' . implode( ' ', $root_rules ) . '}';
        }

        $body_selectors = array(
            'body.theme-' . $mode,
            'html.theme-' . $mode . ' body',
            'html[data-theme="' . $mode . '"] body',
        );

        $body_rules = array();

        if ( ! empty( $palette['background'] ) ) {
            $body_rules[] = 'background-color: ' . $palette['background'] . ';';
        }

        if ( ! empty( $palette['text'] ) ) {
            $body_rules[] = 'color: ' . $palette['text'] . ';';
        }

        if ( ! empty( $body_rules ) ) {
            $css .= implode( ', ', array_unique( $body_selectors ) ) . ' {' . implode( ' ', $body_rules ) . '}';
        }

        if ( ! empty( $palette['header_background'] ) ) {
            $css .= beyond_gotham_build_mode_selector_list( $mode, array( '.site-header' ) ) . '{background-color: var(--bg-header, ' . $palette['header_background'] . ');}';
        }

        if ( ! empty( $palette['footer_background'] ) ) {
            $css .= beyond_gotham_build_mode_selector_list( $mode, array( '.site-footer' ) ) . '{background-color: var(--bg-footer, ' . $palette['footer_background'] . ');}';
        }

        if ( ! empty( $palette['link'] ) ) {
            $css .= beyond_gotham_build_mode_selector_list( $mode, array( 'a', 'a:visited', '.entry-content a', '.widget a', '.site-footer a', '.site-header a' ) ) . '{color: var(--link-color, ' . $palette['link'] . ');}';
        }

        if ( ! empty( $palette['link_hover'] ) ) {
            $css .= beyond_gotham_build_mode_selector_list( $mode, array(
                'a:hover',
                'a:focus',
                'a:active',
                '.entry-content a:hover',
                '.entry-content a:focus',
                '.widget a:hover',
                '.widget a:focus',
                '.site-footer a:hover',
                '.site-footer a:focus',
                '.site-header a:hover',
                '.site-header a:focus'
            ) ) . '{color: var(--link-hover-color, ' . $palette['link_hover'] . ');}';
        }

        $button_selectors       = array_map( 'trim', explode( ',', '.bg-button, .wp-block-button__link, .wp-element-button, button, input[type="submit"], input[type="button"], input[type="reset"], .button' ) );
        $button_hover_selectors = array_map( 'trim', explode( ',', '.bg-button:hover, .bg-button:focus, .wp-block-button__link:hover, .wp-block-button__link:focus, .wp-element-button:hover, .wp-element-button:focus, button:hover, button:focus, input[type="submit"]:hover, input[type="submit"]:focus, input[type="button"]:hover, input[type="button"]:focus, input[type="reset"]:hover, input[type="reset"]:focus, .button:hover, .button:focus' ) );

        if ( ! empty( $palette['button_background'] ) || ! empty( $palette['button_text'] ) ) {
            $button_rules = array();

            if ( ! empty( $palette['button_background'] ) ) {
                $button_rules[] = 'background-color: var(--button-bg, ' . $palette['button_background'] . ');';
                $button_rules[] = 'border-color: var(--button-bg, ' . $palette['button_background'] . ');';
            }

            if ( ! empty( $palette['button_text'] ) ) {
                $button_rules[] = 'color: var(--button-fg, ' . $palette['button_text'] . ');';
            }

            if ( ! empty( $button_rules ) ) {
                $css .= beyond_gotham_build_mode_selector_list( $mode, $button_selectors ) . ' {' . implode( ' ', $button_rules ) . '}';
                $css .= beyond_gotham_build_mode_selector_list( $mode, $button_hover_selectors ) . ' {' . implode( ' ', $button_rules ) . '}';
            }
        }

        if ( ! empty( $palette['quote_background'] ) ) {
            $highlight_selectors = array(
                '.wp-block-beyond-gotham-highlight-box',
                '.bg-highlight-box',
            );

            $css .= beyond_gotham_build_mode_selector_list( $mode, $highlight_selectors ) . '{background: var(--callout-bg, ' . $palette['quote_background'] . ');';

            if ( ! empty( $palette['quote_border'] ) ) {
                $css .= 'border-color: var(--callout-border, ' . $palette['quote_border'] . ');';
            }

            $css .= '}';

            $quote_selectors = array(
                'blockquote',
                '.wp-block-quote',
                '.wp-block-quote.is-style-large',
                '.wp-block-pullquote',
            );

            $css .= beyond_gotham_build_mode_selector_list( $mode, $quote_selectors ) . '{background-color: var(--callout-bg, ' . $palette['quote_background'] . ');';

            if ( ! empty( $palette['quote_border'] ) ) {
                $css .= 'border-color: var(--callout-border, ' . $palette['quote_border'] . '); border-left-color: var(--callout-border, ' . $palette['quote_border'] . ');';
            }

            $css .= '}';
        }

        if ( ! empty( $palette['cta_accent'] ) ) {
            $cta_light = beyond_gotham_hex_to_rgba( $palette['cta_accent'], 0.15 );
            $cta_soft  = beyond_gotham_hex_to_rgba( $palette['cta_accent'], 0.1 );
            $cta_line  = beyond_gotham_hex_to_rgba( $palette['cta_accent'], 0.3 );

            if ( $cta_light && $cta_soft ) {
                $css .= beyond_gotham_build_mode_selector_list( $mode, array( '[data-bg-cta]' ) ) . '{background: linear-gradient(135deg, ' . $cta_light . ', ' . $cta_soft . ');';

                if ( $cta_line ) {
                    $css .= 'border-color: ' . $cta_line . ';';
                }

                $css .= '}';
            }

            $css .= beyond_gotham_build_mode_selector_list( $mode, array( '[data-bg-cta] .bg-button--primary' ) ) . '{background-color: ' . $palette['cta_accent'] . '; border-color: ' . $palette['cta_accent'] . ';}';
        }
    }

    $layout_css = '';

    $header_rules = array();

    if ( ! empty( $header_layout['height_css'] ) ) {
        $header_rules[] = 'min-height: var(--site-header-height, ' . $header_layout['height_css'] . ');';
    }

    if ( isset( $header_layout['padding_top_css'] ) && '' !== $header_layout['padding_top_css'] ) {
        $header_rules[] = 'padding-top: var(--site-header-padding-top, ' . $header_layout['padding_top_css'] . ');';
    }

    if ( isset( $header_layout['padding_bottom_css'] ) && '' !== $header_layout['padding_bottom_css'] ) {
        $header_rules[] = 'padding-bottom: var(--site-header-padding-bottom, ' . $header_layout['padding_bottom_css'] . ');';
    }

    if ( ! empty( $header_rules ) ) {
        $layout_css .= '.site-header {' . implode( ' ', $header_rules ) . '}';
    }

    $footer_rules = array();

    if ( ! empty( $footer_layout['min_height_css'] ) ) {
        $footer_rules[] = 'min-height: var(--site-footer-min-height, ' . $footer_layout['min_height_css'] . ');';
    }

    if ( isset( $footer_layout['margin_top_css'] ) && '' !== $footer_layout['margin_top_css'] ) {
        $footer_rules[] = 'margin-top: var(--site-footer-margin-top, ' . $footer_layout['margin_top_css'] . ');';
    }

    if ( ! empty( $footer_rules ) ) {
        $layout_css .= '.site-footer {' . implode( ' ', $footer_rules ) . '}';
    }

    $button_rules = array();

    if ( isset( $buttons_layout['padding_vertical_css'], $buttons_layout['padding_horizontal_css'] ) && ( '' !== $buttons_layout['padding_vertical_css'] || '' !== $buttons_layout['padding_horizontal_css'] ) ) {
        $vertical_fallback   = '' !== $buttons_layout['padding_vertical_css'] ? $buttons_layout['padding_vertical_css'] : '0px';
        $horizontal_fallback = '' !== $buttons_layout['padding_horizontal_css'] ? $buttons_layout['padding_horizontal_css'] : '0px';
        $button_rules[] = 'padding: var(--ui-button-padding-y, ' . $vertical_fallback . ') var(--ui-button-padding-x, ' . $horizontal_fallback . ');';
    }

    if ( isset( $buttons_layout['border_radius_css'] ) && '' !== $buttons_layout['border_radius_css'] ) {
        $button_rules[] = 'border-radius: var(--ui-button-radius, ' . $buttons_layout['border_radius_css'] . ');';
    }

    if ( ! empty( $button_rules ) ) {
        $button_selectors = array(
            '.bg-button',
            '.wp-block-button__link',
            '.wp-block-button .wp-block-button__link',
            '.wp-element-button',
            'button',
            'input[type="submit"]',
            'input[type="button"]',
            'input[type="reset"]',
        );

        $layout_css .= implode( ', ', array_unique( $button_selectors ) ) . ' {' . implode( ' ', $button_rules ) . '}';
    }

    $thumbnail_container_rules = array();

    if ( isset( $thumbnail_layout['max_width_css'] ) && '' !== $thumbnail_layout['max_width_css'] ) {
        $thumbnail_container_rules[] = 'max-width: var(--post-thumbnail-max-width, ' . $thumbnail_layout['max_width_css'] . ');';
        $thumbnail_container_rules[] = 'margin-left: auto;';
        $thumbnail_container_rules[] = 'margin-right: auto;';
    }

    if ( ! empty( $thumbnail_container_rules ) ) {
        $layout_css .= '.post-thumbnail, .article-hero, .entry-thumbnail {' . implode( ' ', $thumbnail_container_rules ) . '}';
    }

    $thumbnail_image_rules = array( 'width: 100%;', 'height: auto;', 'object-fit: cover;' );

    if ( isset( $thumbnail_layout['aspect_ratio_css'] ) && '' !== $thumbnail_layout['aspect_ratio_css'] ) {
        $thumbnail_image_rules[] = 'aspect-ratio: var(--post-thumbnail-aspect-ratio, ' . $thumbnail_layout['aspect_ratio_css'] . ');';
    }

    if ( isset( $thumbnail_layout['max_width_css'] ) && '' !== $thumbnail_layout['max_width_css'] ) {
        $thumbnail_image_rules[] = 'max-width: var(--post-thumbnail-max-width, ' . $thumbnail_layout['max_width_css'] . ');';
    }

    $layout_css .= '.post-thumbnail img, .post-thumbnail picture, .article-hero img, .post-hero {' . implode( ' ', $thumbnail_image_rules ) . '}';

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

    if ( isset( $presets[ $heading_key ] ) ) {
        $css .= 'h1, h2, h3, h4, h5, h6 {font-family: ' . $presets[ $heading_key ]['stack'] . ';}';
    }

    return $css;
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
add_action( 'wp_enqueue_scripts', 'beyond_gotham_print_customizer_styles', 20 );

/**
 * Output a favicon tag when a custom brand icon is provided.
 */
function beyond_gotham_render_brand_favicon() {
    if ( has_site_icon() ) {
        return;
    }

    $favicon_id = (int) get_theme_mod( 'beyond_gotham_brand_favicon' );

    if ( ! $favicon_id ) {
        return;
    }

    $icon = wp_get_attachment_image_src( $favicon_id, 'full' );

    if ( ! $icon ) {
        return;
    }

    printf(
        '<link rel="icon" href="%1$s" sizes="%2$dx%3$d" />' . "\n",
        esc_url( $icon[0] ),
        (int) $icon[1],
        (int) $icon[2]
    );
}
add_action( 'wp_head', 'beyond_gotham_render_brand_favicon', 1 );

/**
 * Enqueue the live preview script for Customizer postMessage updates.
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

    $cta_layout = function_exists( 'beyond_gotham_get_cta_layout_settings' ) ? beyond_gotham_get_cta_layout_settings() : array();
    $ui_layout  = function_exists( 'beyond_gotham_get_ui_layout_settings' ) ? beyond_gotham_get_ui_layout_settings() : array();

    wp_localize_script(
        $handle,
        'BGCustomizerPreview',
        array(
            'fontStacks'           => $stacks,
            'footerTarget'         => '.site-info',
            'headingSelector'      => 'h1, h2, h3, h4, h5, h6',
            'footerSocialSelector' => '[data-bg-footer-social]',
            'ctaSelectors'         => array(
                'wrapper' => '[data-bg-cta]',
                'text'    => '[data-bg-cta-text]',
                'button'  => '[data-bg-cta-button]',
            ),
            'ctaLayout'           => $cta_layout,
            'uiLayout'            => $ui_layout,
            'defaults'             => $color_defaults,
            'colorDefaults'        => $color_defaults,
            'contrastThreshold'    => 4.5,
        )
    );
}
add_action( 'customize_preview_init', 'beyond_gotham_customize_preview_js' );
