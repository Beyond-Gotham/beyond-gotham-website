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
 * Sanitize the CTA visibility scope selections.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function beyond_gotham_sanitize_cta_visibility_scope( $value ) {
    $allowed = array( 'front_page', 'posts', 'courses', 'products', 'all' );

    if ( is_string( $value ) ) {
        $value = array( sanitize_text_field( $value ) );
    } elseif ( is_array( $value ) ) {
        $value = array_map( 'sanitize_text_field', $value );
    } else {
        $value = array();
    }

    $value = array_values( array_intersect( array_unique( $value ), $allowed ) );

    if ( in_array( 'all', $value, true ) ) {
        return array( 'all' );
    }

    return $value;
}

/**
 * Sanitize a list of post or page IDs.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function beyond_gotham_sanitize_post_id_list( $value ) {
    if ( is_string( $value ) ) {
        $value = wp_parse_id_list( $value );
    } elseif ( is_array( $value ) ) {
        $value = array_map( 'absint', $value );
    } else {
        $value = array();
    }

    return array_values( array_filter( array_unique( $value ) ) );
}

/**
 * Sanitize the social bar mobile position option.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_socialbar_position( $value ) {
    $value   = is_string( $value ) ? strtolower( trim( $value ) ) : '';
    $choices = array( 'top', 'bottom' );

    if ( in_array( $value, $choices, true ) ) {
        return $value;
    }

    return 'bottom';
}

/**
 * Sanitize the social bar icon style option.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_socialbar_icon_style( $value ) {
    $value   = is_string( $value ) ? strtolower( trim( $value ) ) : '';
    $choices = array( 'monochrom', 'farbig', 'invertiert' );

    if ( in_array( $value, $choices, true ) ) {
        return $value;
    }

    return 'monochrom';
}

/**
 * Sanitize the social bar style variant option.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_socialbar_style_variant( $value ) {
    $value    = is_string( $value ) ? strtolower( trim( $value ) ) : '';
    $variants = array_keys( beyond_gotham_get_socialbar_style_variants() );

    if ( in_array( $value, $variants, true ) ) {
        return $value;
    }

    return 'minimal';
}

/**
 * Retrieve supported Social Bar style variants.
 *
 * @return array<string, array<string, mixed>>
 */
function beyond_gotham_get_socialbar_style_variants() {
    return array(
        'minimal'  => array(
            'label'    => __( 'Minimal', 'beyond_gotham' ),
            'defaults' => array(
                'background' => '',
                'hover'      => '',
                'icon'       => '#ffffff',
            ),
        ),
        'boxed'    => array(
            'label'    => __( 'Boxed', 'beyond_gotham' ),
            'defaults' => array(
                'background' => '#111111',
                'hover'      => '#1f2937',
                'icon'       => '#ffffff',
            ),
        ),
        'pill'     => array(
            'label'    => __( 'Pill', 'beyond_gotham' ),
            'defaults' => array(
                'background' => '#1aa5d1',
                'hover'      => '#1480a6',
                'icon'       => '#ffffff',
            ),
        ),
        'labelled' => array(
            'label'    => __( 'Labelled', 'beyond_gotham' ),
            'defaults' => array(
                'background' => '#111111',
                'hover'      => '#1f2937',
                'icon'       => '#ffffff',
            ),
        ),
    );
}

/**
 * Retrieve the default configuration for the social sharing options.
 *
 * @return array<string, array<string, bool>>
 */
function beyond_gotham_get_social_share_defaults() {
    $defaults = array(
        'display'  => array(
            'post'     => true,
            'category' => false,
            'page'     => false,
        ),
        'networks' => array(
            'linkedin' => true,
            'twitter'  => true,
            'mastodon' => true,
            'facebook' => true,
            'whatsapp' => true,
            'github'   => false,
        ),
    );

    /**
     * Filter the default configuration for social sharing options.
     *
     * @param array $defaults Default settings for social sharing.
     */
    return apply_filters( 'beyond_gotham_social_share_default_settings', $defaults );
}

/**
 * Active callback helper for Social Bar variant specific controls.
 *
 * @param WP_Customize_Control $control Control instance.
 * @return bool
 */
function beyond_gotham_customize_is_socialbar_variant( $control ) {
    if ( ! $control instanceof WP_Customize_Control ) {
        return false;
    }

    $target_variant = isset( $control->input_attrs['data-variant'] ) ? $control->input_attrs['data-variant'] : '';
    if ( '' === $target_variant ) {
        return false;
    }

    $setting = $control->manager->get_setting( 'beyond_gotham_socialbar_style_variant' );
    if ( ! $setting ) {
        return false;
    }

    $current = $setting->post_value();
    if ( null === $current ) {
        $current = $setting->value();
    }

    $current = beyond_gotham_sanitize_socialbar_style_variant( $current );

    return $target_variant === $current;
}

/**
 * Sanitize the sticky CTA trigger type.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_sticky_cta_trigger( $value ) {
    $value   = is_string( $value ) ? strtolower( trim( $value ) ) : '';
    $choices = array( 'delay', 'scroll', 'element' );

    if ( in_array( $value, $choices, true ) ) {
        return $value;
    }

    return 'delay';
}

/**
 * Sanitize the sticky CTA scroll depth percentage.
 *
 * @param mixed $value Raw value.
 * @return int
 */
function beyond_gotham_sanitize_sticky_cta_scroll_depth( $value ) {
    $value = is_numeric( $value ) ? (int) $value : 0;

    if ( $value < 0 ) {
        return 0;
    }

    if ( $value > 100 ) {
        return 100;
    }

    return $value;
}

/**
 * Sanitize a CSS selector string.
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
        'header_height'             => 100,
        'header_padding_top'        => 24,
        'header_padding_bottom'     => 24,
        'footer_min_height'         => 250,
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

    $footer_height   = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_footer_min_height', $defaults['footer_min_height'] ) );
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
            'height'         => $footer_height,
            'height_css'     => beyond_gotham_format_px_value( $footer_height ),
            'min_height'     => $footer_height,
            'min_height_css' => beyond_gotham_format_px_value( $footer_height ),
            'max_height_css' => beyond_gotham_format_px_value( $footer_height ),
            'margin_top'     => $footer_margin_top,
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
        'visibility_scope' => array( 'all' ),
        'exclude_pages'    => array(),
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
        'width'         => 300,
        'height'        => 100,
        'position'      => 'bottom',
        'alignment'     => 'center',
        'mobile_width'  => 0,
        'mobile_height' => 0,
        'mobile_padding' => 0,
        'show_mobile'   => true,
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

    $width          = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_width', $defaults['width'] ) );
    $height         = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_height', $defaults['height'] ) );
    $position       = beyond_gotham_sanitize_cta_position( get_theme_mod( 'beyond_gotham_cta_position', $defaults['position'] ) );
    $alignment      = beyond_gotham_sanitize_cta_alignment( get_theme_mod( 'beyond_gotham_cta_alignment', $defaults['alignment'] ) );
    $show_mobile    = beyond_gotham_sanitize_checkbox( get_theme_mod( 'beyond_gotham_cta_mobile_visible', $defaults['show_mobile'] ) );
    $mobile_width   = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_mobile_width', $defaults['mobile_width'] ) );
    $mobile_height  = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_mobile_height', $defaults['mobile_height'] ) );
    $mobile_padding = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_mobile_padding', $defaults['mobile_padding'] ) );

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

    $width_css         = $width > 0 ? beyond_gotham_format_css_size( $width, 'px' ) : '';
    $height_css        = $height > 0 ? beyond_gotham_format_css_size( $height, 'px' ) : '';
    $mobile_width_css  = $mobile_width > 0 ? beyond_gotham_format_css_size( $mobile_width, 'px' ) : '';
    $mobile_height_css = $mobile_height > 0 ? beyond_gotham_format_css_size( $mobile_height, 'px' ) : '';
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
        'width'             => $width,
        'height'            => $height,
        'width_css'         => $width_css,
        'height_css'        => $height_css,
        'position'          => $position,
        'alignment'         => $alignment,
        'show_mobile'       => $show_mobile,
        'mobile_width'      => $mobile_width,
        'mobile_height'     => $mobile_height,
        'mobile_padding'    => $mobile_padding,
        'mobile_width_css'  => $mobile_width_css,
        'mobile_height_css' => $mobile_height_css,
        'mobile_padding_css' => $mobile_padding_css,
        'class_list'        => array_values( array_unique( array_filter( array_map( 'sanitize_html_class', $classes ) ) ) ),
        'style_map'         => $style_map,
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
    $scope = get_theme_mod( 'beyond_gotham_cta_visibility_scope', $defaults['visibility_scope'] );
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
 * Retrieve default settings for the sticky CTA bar.
 *
 * @return array
 */
function beyond_gotham_get_sticky_cta_defaults() {
    return array(
        'active'       => false,
        'content'      => '',
        'link'         => '',
        'delay'        => 5,
        'trigger'      => 'delay',
        'scroll_depth' => 50,
        'trigger_selector' => '',
        'background'   => '#0b1d2a',
        'text_color'   => '#ffffff',
        'button_color' => '#33d1ff',
        'show_desktop' => true,
        'show_mobile'  => true,
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

    $content_clean = is_string( $content ) ? trim( $content ) : '';
    $content_text  = trim( wp_strip_all_tags( $content_clean ) );
    $has_content   = '' !== $content_text;
    $has_link      = '' !== $link;
    $has_device    = $show_desktop || $show_mobile;

    $button_text_color = beyond_gotham_ensure_contrast(
        $text_color,
        $button_color,
        array( '#050608', '#ffffff', '#000000' ),
        4.5
    );

    $enabled    = $active && ( $has_content || $has_link ) && $has_device;
    $delay_safe = max( 0, $delay );
    $delay_ms   = ( 'delay' === $trigger ? $delay_safe : 0 ) * 1000;

    $settings = array(
        'active'            => $active,
        'content'           => wp_kses_post( $content_clean ),
        'link'              => $link,
        'delay'             => $delay,
        'delay_ms'          => $delay_ms,
        'trigger'           => $trigger,
        'scroll_depth'      => $scroll_depth,
        'trigger_selector'  => $selector,
        'background'        => $background,
        'text_color'        => $text_color,
        'button_color'      => $button_color,
        'button_text_color' => $button_text_color,
        'show_desktop'      => $show_desktop,
        'show_mobile'       => $show_mobile,
        'has_content'       => $has_content,
        'has_link'          => $has_link,
        'enabled'           => $enabled,
        'is_empty'          => ! $has_content && ! $has_link,
    );

    /**
     * Filter the sticky CTA settings prior to rendering.
     *
     * @param array $settings Sticky CTA settings array.
     * @param array $defaults Default sticky CTA values.
     */
    return apply_filters( 'beyond_gotham_sticky_cta_settings', $settings, $defaults );
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

    $wp_customize->add_panel(
        'beyond_gotham_cta_panel',
        array(
            'title'       => __( 'Call-to-Action', 'beyond_gotham' ),
            'priority'    => 40,
            'description' => __( 'Pflege Text, Button-Beschriftung und Ziel-Link für den Newsletter-Call-to-Action.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_section(
        'beyond_gotham_cta',
        array(
            'title'       => __( 'Call-to-Action', 'beyond_gotham' ),
            'priority'    => 10,
            'panel'       => 'beyond_gotham_cta_panel',
            'description' => __( 'Pflege Text, Button-Beschriftung und Ziel-Link für den Newsletter-Call-to-Action.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_section(
        'beyond_gotham_ui_layout',
        array(
            'title'       => __( 'UI Layout & Abstände', 'beyond_gotham' ),
            'priority'    => 20,
            'panel'       => 'beyond_gotham_cta_panel',
            'description' => __( 'Passe Position, Größe und Abstände zentral an.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_section(
        'beyond_gotham_cta_mobile',
        array(
            'title'       => __( 'CTA – Mobilgeräte', 'beyond_gotham' ),
            'priority'    => 30,
            'panel'       => 'beyond_gotham_cta_panel',
            'description' => __( 'Steuere Sichtbarkeit und Darstellung der CTA-Box auf Smartphones.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_section(
        'beyond_gotham_cta_sticky',
        array(
            'title'       => __( 'Sticky-Leiste', 'beyond_gotham' ),
            'priority'    => 40,
            'panel'       => 'beyond_gotham_cta_panel',
            'description' => __( 'Konfiguriere die fixierte CTA-Leiste am unteren Bildschirmrand.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_section(
        'visibility_controls',
        array(
            'title'    => __( 'Sichtbarkeit', 'beyond_gotham' ),
            'priority' => 160,
        )
    );

    $wp_customize->add_setting(
        'cta_visibility',
        array(
            'default'           => 'all',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'cta_visibility',
        array(
            'label'   => __( 'CTA-Box anzeigen auf:', 'beyond_gotham' ),
            'section' => 'visibility_controls',
            'type'    => 'select',
            'choices' => array(
                'all'   => __( 'Alle Seiten', 'beyond_gotham' ),
                'home'  => __( 'Nur Startseite', 'beyond_gotham' ),
                'posts' => __( 'Nur Beiträge', 'beyond_gotham' ),
                'none'  => __( 'Nie', 'beyond_gotham' ),
            ),
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
            'description' => __( 'Links zu Social-Media-Profilen pflegen. Die Vorschau zeigt Desktop & Mobile-Varianten.', 'beyond_gotham' ),
        )
    );

    $share_defaults = beyond_gotham_get_social_share_defaults();

    $wp_customize->add_section(
        'beyond_gotham_social_sharing',
        array(
            'title'       => __( 'Social Sharing', 'beyond_gotham' ),
            'priority'    => 92,
            'description' => __( 'Steuere, wo die Social-Share-Leiste angezeigt wird und welche Netzwerke aktiv sind.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'enable_social_share',
        array(
            'default'           => true,
            'type'              => 'theme_mod',
            'sanitize_callback' => 'wp_validate_boolean',
        )
    );

    $wp_customize->add_control(
        'enable_social_share',
        array(
            'type'        => 'checkbox',
            'section'     => 'beyond_gotham_social_sharing',
            'label'       => __( 'Social-Share-Buttons unter Beiträgen anzeigen', 'beyond_gotham' ),
            'description' => __( 'Steuert die globale Sichtbarkeit der Social-Share-Leiste.', 'beyond_gotham' ),
            'priority'    => 5,
        )
    );

    $wp_customize->add_control(
        new Beyond_Gotham_Customize_Heading_Control(
            $wp_customize,
            'beyond_gotham_social_share_display_heading',
            array(
                'label'       => __( 'Social-Share-Leiste anzeigen bei …', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_social_sharing',
                'priority'    => 10,
                'description' => __( 'Wähle die Inhaltstypen aus, für die die Sharing-Leiste eingeblendet wird.', 'beyond_gotham' ),
            )
        )
    );

    $share_display_choices = array(
        'post'     => __( 'Blog-Artikeln', 'beyond_gotham' ),
        'category' => __( 'Dossiers, Reportagen & Interviews (Kategorien)', 'beyond_gotham' ),
        'page'     => __( 'Seiten', 'beyond_gotham' ),
    );

    $display_priority = 11;
    foreach ( $share_display_choices as $context => $label ) {
        $setting_id = 'beyond_gotham_share_display_' . $context;

        $wp_customize->add_setting(
            $setting_id,
            array(
                'default'           => isset( $share_defaults['display'][ $context ] ) ? $share_defaults['display'][ $context ] : false,
                'type'              => 'theme_mod',
                'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
            )
        );

        $wp_customize->add_control(
            $setting_id,
            array(
                'label'    => $label,
                'section'  => 'beyond_gotham_social_sharing',
                'type'     => 'checkbox',
                'priority' => $display_priority,
            )
        );

        $display_priority++;
    }

    $wp_customize->add_control(
        new Beyond_Gotham_Customize_Heading_Control(
            $wp_customize,
            'beyond_gotham_social_share_networks_heading',
            array(
                'label'       => __( 'Aktive Netzwerke', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_social_sharing',
                'priority'    => 30,
                'description' => __( 'Schalte einzelne Netzwerke für die Sharing-Leiste ein oder aus.', 'beyond_gotham' ),
            )
        )
    );

    $share_network_labels = array(
        'linkedin' => __( 'LinkedIn', 'beyond_gotham' ),
        'twitter'  => __( 'X (Twitter)', 'beyond_gotham' ),
        'mastodon' => __( 'Mastodon', 'beyond_gotham' ),
        'facebook' => __( 'Facebook', 'beyond_gotham' ),
        'whatsapp' => __( 'WhatsApp', 'beyond_gotham' ),
        'github'   => __( 'GitHub', 'beyond_gotham' ),
    );

    $network_priority = 31;
    foreach ( $share_network_labels as $network => $label ) {
        $setting_id = 'beyond_gotham_share_network_' . $network;

        $wp_customize->add_setting(
            $setting_id,
            array(
                'default'           => isset( $share_defaults['networks'][ $network ] ) ? $share_defaults['networks'][ $network ] : false,
                'type'              => 'theme_mod',
                'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
            )
        );

        $wp_customize->add_control(
            $setting_id,
            array(
                'label'    => $label,
                'section'  => 'beyond_gotham_social_sharing',
                'type'     => 'checkbox',
                'priority' => $network_priority,
            )
        );

        $network_priority++;
    }

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

    $cta_defaults    = beyond_gotham_get_cta_defaults();
    $sticky_defaults = beyond_gotham_get_sticky_cta_defaults();

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

    $wp_customize->add_setting(
        'beyond_gotham_cta_visibility_scope',
        array(
            'default'           => $cta_defaults['visibility_scope'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_cta_visibility_scope',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_cta_visibility_scope_control',
        array(
            'label'       => __( 'Sichtbarkeit der CTA-Box', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta',
            'settings'    => 'beyond_gotham_cta_visibility_scope',
            'type'        => 'select',
            'choices'     => array(
                'front_page' => __( 'Startseite anzeigen', 'beyond_gotham' ),
                'posts'      => __( 'Nur bei Blog-Artikeln anzeigen', 'beyond_gotham' ),
                'courses'    => __( 'Nur bei Kursseiten (bg_course)', 'beyond_gotham' ),
                'products'   => __( 'Nur auf Produktseiten', 'beyond_gotham' ),
                'all'        => __( 'Auf allen Seiten anzeigen', 'beyond_gotham' ),
            ),
            'input_attrs' => array(
                'multiple' => 'multiple',
                'size'     => 5,
            ),
            'description' => __( 'Halte Strg (Windows) oder Cmd (Mac), um mehrere Optionen auszuwählen.', 'beyond_gotham' ),
        )
    );

    $page_choices = array();
    $pages        = get_pages(
        array(
            'sort_column' => 'post_title',
            'sort_order'  => 'ASC',
            'post_type'   => 'page',
            'post_status' => array( 'publish', 'private' ),
        )
    );

    foreach ( $pages as $page ) {
        $title = $page->post_title ? $page->post_title : sprintf( __( '(Ohne Titel) #%d', 'beyond_gotham' ), $page->ID );
        /* translators: 1: Page title, 2: Page ID. */
        $page_choices[ $page->ID ] = sprintf( __( '%1$s (ID: %2$d)', 'beyond_gotham' ), $title, $page->ID );
    }

    $page_select_size = max( 3, min( 10, count( $page_choices ) ) );

    $wp_customize->add_setting(
        'beyond_gotham_cta_exclude_pages',
        array(
            'default'           => $cta_defaults['exclude_pages'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_post_id_list',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_cta_exclude_pages_control',
        array(
            'label'       => __( 'CTA auf bestimmten Seiten ausblenden', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta',
            'settings'    => 'beyond_gotham_cta_exclude_pages',
            'type'        => 'select',
            'choices'     => $page_choices,
            'input_attrs' => array(
                'multiple' => 'multiple',
                'size'     => (string) $page_select_size,
            ),
            'description' => __( 'Verstecke die CTA-Box auf ausgewählten Seiten. Halte Strg (Windows) oder Cmd (Mac), um mehrere Seiten zu markieren.', 'beyond_gotham' ),
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
            'label'       => __( 'Header-Höhe (px)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_header_height',
            'type'        => 'range',
            'priority'    => $layout_priority,
            'input_attrs' => array(
                'min'  => 50,
                'max'  => 300,
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
            'label'       => __( 'Footer-Höhe (px)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_ui_layout',
            'settings'    => 'beyond_gotham_footer_min_height',
            'type'        => 'range',
            'priority'    => $layout_priority,
            'input_attrs' => array(
                'min'  => 100,
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

    $wp_customize->add_setting(
        'beyond_gotham_cta_mobile_visible',
        array(
            'default'           => $cta_layout_defaults['show_mobile'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_cta_mobile_visible_control',
        array(
            'label'       => __( 'CTA auf Mobilgeräten anzeigen?', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta_mobile',
            'settings'    => 'beyond_gotham_cta_mobile_visible',
            'type'        => 'checkbox',
            'description' => __( 'Blende die Newsletter-CTA auf Displays unter 768px aus.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_cta_mobile_width',
        array(
            'default'           => $cta_layout_defaults['mobile_width'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_cta_mobile_width_control',
        array(
            'label'       => __( 'CTA-Breite – Mobil', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta_mobile',
            'settings'    => 'beyond_gotham_cta_mobile_width',
            'type'        => 'range',
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 600,
                'step' => 10,
            ),
            'description' => __( 'Lege eine feste Breite zwischen 200px und 600px fest. 0 entspricht voller Breite (100%).', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_cta_mobile_height',
        array(
            'default'           => $cta_layout_defaults['mobile_height'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_cta_mobile_height_control',
        array(
            'label'       => __( 'CTA-Höhe – Mobil', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta_mobile',
            'settings'    => 'beyond_gotham_cta_mobile_height',
            'type'        => 'range',
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 300,
                'step' => 5,
            ),
            'description' => __( 'Definiert die Höhe der CTA-Box für Smartphones. 0 übernimmt die automatische Höhe.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_cta_mobile_padding',
        array(
            'default'           => $cta_layout_defaults['mobile_padding'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_cta_mobile_padding_control',
        array(
            'label'       => __( 'Innenabstand – Mobil', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta_mobile',
            'settings'    => 'beyond_gotham_cta_mobile_padding',
            'type'        => 'range',
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 80,
                'step' => 2,
            ),
            'description' => __( 'Feinjustiere das Padding innerhalb der CTA-Box. 0 verwendet den Standardwert.', 'beyond_gotham' ),
        )
    );

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
            'label'       => __( 'Sticky-CTA-Leiste aktivieren', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta_sticky',
            'settings'    => 'beyond_gotham_sticky_cta_active',
            'type'        => 'checkbox',
            'description' => __( 'Blende eine fixierte CTA-Leiste am unteren Bildschirmrand ein.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_sticky_cta_content',
        array(
            'default'           => $sticky_defaults['content'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_allow_html',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_sticky_cta_content_control',
        array(
            'label'       => __( 'CTA-Inhalt', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta_sticky',
            'settings'    => 'beyond_gotham_sticky_cta_content',
            'type'        => 'textarea',
            'description' => __( 'Füge Text oder HTML hinzu, der in der Sticky-Leiste angezeigt werden soll.', 'beyond_gotham' ),
        )
    );

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
            'label'       => __( 'CTA-Link', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta_sticky',
            'settings'    => 'beyond_gotham_sticky_cta_link',
            'type'        => 'url',
            'description' => __( 'Ziel-URL für den Button innerhalb der Sticky-Leiste.', 'beyond_gotham' ),
        )
    );

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
            'label'       => __( 'Einblendungsverzögerung (Sekunden)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta_sticky',
            'settings'    => 'beyond_gotham_sticky_cta_delay',
            'type'        => 'range',
            'input_attrs' => array(
                'min'  => 0,
                'max'  => 20,
                'step' => 1,
            ),
            'active_callback' => 'beyond_gotham_customize_is_sticky_cta_trigger_delay',
        )
    );

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
                'label'    => __( 'Buttonfarbe', 'beyond_gotham' ),
                'section'  => 'beyond_gotham_cta_sticky',
                'settings' => 'beyond_gotham_sticky_cta_button_color',
            )
        )
    );

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
            'label'       => __( 'Auf Desktop anzeigen', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta_sticky',
            'settings'    => 'beyond_gotham_sticky_cta_show_desktop',
            'type'        => 'checkbox',
            'description' => __( 'Deaktiviere die Sticky-Leiste auf großen Displays, falls nicht benötigt.', 'beyond_gotham' ),
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
            'label'       => __( 'Auf Mobilgeräten anzeigen', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta_sticky',
            'settings'    => 'beyond_gotham_sticky_cta_show_mobile',
            'type'        => 'checkbox',
            'description' => __( 'Steuert, ob die Sticky-Leiste auf kleineren Displays sichtbar ist.', 'beyond_gotham' ),
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
        'beyond_gotham_show_socialbar_header',
        array(
            'default'           => false,
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_show_socialbar_header_control',
        array(
            'label'       => __( 'Social-Bar im Header anzeigen?', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_show_socialbar_header',
            'type'        => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_show_socialbar_mobile',
        array(
            'default'           => true,
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_show_socialbar_mobile_control',
        array(
            'label'       => __( 'Sticky-Social-Bar auf Mobilgeräten anzeigen?', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_show_socialbar_mobile',
            'type'        => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_socialbar_position',
        array(
            'default'           => 'bottom',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_socialbar_position',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_socialbar_position_control',
        array(
            'label'       => __( 'Position der Sticky-Leiste auf Mobilgeräten', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_socialbar_position',
            'type'        => 'radio',
            'choices'     => array(
                'top'    => __( 'Oben', 'beyond_gotham' ),
                'bottom' => __( 'Unten', 'beyond_gotham' ),
            ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_socialbar_style_variant',
        array(
            'default'           => 'minimal',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_socialbar_style_variant',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_socialbar_style_variant_control',
        array(
            'label'       => __( 'Design-Variante der Social-Bar', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_socialbar_style_variant',
            'type'        => 'select',
            'choices'     => wp_list_pluck( beyond_gotham_get_socialbar_style_variants(), 'label' ),
        )
    );

    foreach ( beyond_gotham_get_socialbar_style_variants() as $variant_key => $variant_config ) {
        $defaults = isset( $variant_config['defaults'] ) && is_array( $variant_config['defaults'] )
            ? $variant_config['defaults']
            : array();

        $background_default = isset( $defaults['background'] ) ? $defaults['background'] : '';
        $hover_default      = isset( $defaults['hover'] ) ? $defaults['hover'] : '';
        $icon_default       = isset( $defaults['icon'] ) ? $defaults['icon'] : '';

        $wp_customize->add_setting(
            "beyond_gotham_socialbar_{$variant_key}_background_color",
            array(
                'default'           => $background_default,
                'type'              => 'theme_mod',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport'         => 'postMessage',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                "beyond_gotham_socialbar_{$variant_key}_background_color_control",
                array(
                    'label'           => sprintf( __( '%s: Hintergrundfarbe', 'beyond_gotham' ), $variant_config['label'] ),
                    'section'         => 'beyond_gotham_social_media',
                    'settings'        => "beyond_gotham_socialbar_{$variant_key}_background_color",
                    'active_callback' => 'beyond_gotham_customize_is_socialbar_variant',
                    'input_attrs'     => array(
                        'data-variant' => $variant_key,
                    ),
                )
            )
        );

        $wp_customize->add_setting(
            "beyond_gotham_socialbar_{$variant_key}_hover_color",
            array(
                'default'           => $hover_default,
                'type'              => 'theme_mod',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport'         => 'postMessage',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                "beyond_gotham_socialbar_{$variant_key}_hover_color_control",
                array(
                    'label'           => sprintf( __( '%s: Hover-Farbe', 'beyond_gotham' ), $variant_config['label'] ),
                    'section'         => 'beyond_gotham_social_media',
                    'settings'        => "beyond_gotham_socialbar_{$variant_key}_hover_color",
                    'active_callback' => 'beyond_gotham_customize_is_socialbar_variant',
                    'input_attrs'     => array(
                        'data-variant' => $variant_key,
                    ),
                )
            )
        );

        $wp_customize->add_setting(
            "beyond_gotham_socialbar_{$variant_key}_icon_color",
            array(
                'default'           => $icon_default,
                'type'              => 'theme_mod',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport'         => 'postMessage',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                "beyond_gotham_socialbar_{$variant_key}_icon_color_control",
                array(
                    'label'           => sprintf( __( '%s: Icon-Farbe', 'beyond_gotham' ), $variant_config['label'] ),
                    'section'         => 'beyond_gotham_social_media',
                    'settings'        => "beyond_gotham_socialbar_{$variant_key}_icon_color",
                    'active_callback' => 'beyond_gotham_customize_is_socialbar_variant',
                    'input_attrs'     => array(
                        'data-variant' => $variant_key,
                    ),
                )
            )
        );
    }

    $wp_customize->add_setting(
        'beyond_gotham_socialbar_icon_style',
        array(
            'default'           => 'monochrom',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_socialbar_icon_style',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_socialbar_icon_style_control',
        array(
            'label'       => __( 'Icon-Stil', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_socialbar_icon_style',
            'type'        => 'select',
            'choices'     => array(
                'monochrom'  => __( 'Monochrom', 'beyond_gotham' ),
                'farbig'     => __( 'Farbig', 'beyond_gotham' ),
                'invertiert' => __( 'Invertiert', 'beyond_gotham' ),
            ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_socialbar_background_color',
        array(
            'default'           => '#111111',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'beyond_gotham_socialbar_background_color_control',
            array(
                'label'    => __( 'Hintergrundfarbe der Social-Bar', 'beyond_gotham' ),
                'section'  => 'beyond_gotham_social_media',
                'settings' => 'beyond_gotham_socialbar_background_color',
            )
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_socialbar_icon_color',
        array(
            'default'           => '#ffffff',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'beyond_gotham_socialbar_icon_color_control',
            array(
                'label'    => __( 'Icon-Farbe der Social-Bar', 'beyond_gotham' ),
                'section'  => 'beyond_gotham_social_media',
                'settings' => 'beyond_gotham_socialbar_icon_color',
            )
        )
    );

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
        'beyond_gotham_social_facebook',
        array(
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_optional_url',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_social_facebook_control',
        array(
            'label'       => __( 'Facebook URL', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_social_facebook',
            'type'        => 'url',
            'description' => __( 'Beispiel: https://www.facebook.com/beyondgotham', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_social_instagram',
        array(
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_optional_url',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_social_instagram_control',
        array(
            'label'       => __( 'Instagram URL', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_social_instagram',
            'type'        => 'url',
            'description' => __( 'Beispiel: https://www.instagram.com/beyondgotham', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_social_tiktok',
        array(
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_optional_url',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_social_tiktok_control',
        array(
            'label'       => __( 'TikTok URL', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_social_tiktok',
            'type'        => 'url',
            'description' => __( 'Beispiel: https://www.tiktok.com/@beyondgotham', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_social_youtube',
        array(
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_optional_url',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_social_youtube_control',
        array(
            'label'       => __( 'YouTube URL', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_social_youtube',
            'type'        => 'url',
            'description' => __( 'Beispiel: https://www.youtube.com/@beyondgotham', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_social_telegram',
        array(
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_optional_url',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_social_telegram_control',
        array(
            'label'       => __( 'Telegram URL', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_social_media',
            'settings'    => 'beyond_gotham_social_telegram',
            'type'        => 'url',
            'description' => __( 'Beispiel: https://t.me/beyondgotham', 'beyond_gotham' ),
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
        'github'   => beyond_gotham_sanitize_optional_url( get_theme_mod( 'beyond_gotham_social_github', '' ) ),
        'linkedin' => beyond_gotham_sanitize_optional_url( get_theme_mod( 'beyond_gotham_social_linkedin', '' ) ),
        'mastodon' => beyond_gotham_sanitize_optional_url( get_theme_mod( 'beyond_gotham_social_mastodon', '' ) ),
        'twitter'  => beyond_gotham_sanitize_optional_url( get_theme_mod( 'beyond_gotham_social_twitter', '' ) ),
        'facebook' => beyond_gotham_sanitize_optional_url( get_theme_mod( 'beyond_gotham_social_facebook', '' ) ),
        'instagram' => beyond_gotham_sanitize_optional_url( get_theme_mod( 'beyond_gotham_social_instagram', '' ) ),
        'tiktok'    => beyond_gotham_sanitize_optional_url( get_theme_mod( 'beyond_gotham_social_tiktok', '' ) ),
        'youtube'   => beyond_gotham_sanitize_optional_url( get_theme_mod( 'beyond_gotham_social_youtube', '' ) ),
        'telegram' => beyond_gotham_sanitize_optional_url( get_theme_mod( 'beyond_gotham_social_telegram', '' ) ),
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
 * Retrieve configuration for the social bar module.
 *
 * @return array{
 *     show_header: bool,
 *     show_mobile: bool,
 *     position: string,
 *     icon_style: string,
 *     background_color: string,
 *     icon_color: string,
 * }
 */
function beyond_gotham_get_socialbar_settings() {
    $surface_background = sanitize_hex_color( get_theme_mod( 'beyond_gotham_socialbar_background_color', '#111111' ) );
    $surface_icon       = sanitize_hex_color( get_theme_mod( 'beyond_gotham_socialbar_icon_color', '#ffffff' ) );

    $style_variant = beyond_gotham_sanitize_socialbar_style_variant( get_theme_mod( 'beyond_gotham_socialbar_style_variant', 'minimal' ) );
    $variants      = beyond_gotham_get_socialbar_style_variants();
    $style_colors  = array();

    foreach ( $variants as $variant_key => $variant_config ) {
        $defaults = isset( $variant_config['defaults'] ) && is_array( $variant_config['defaults'] )
            ? $variant_config['defaults']
            : array();

        $background_default = isset( $defaults['background'] ) ? $defaults['background'] : '';
        $hover_default      = isset( $defaults['hover'] ) ? $defaults['hover'] : '';
        $icon_default       = isset( $defaults['icon'] ) ? $defaults['icon'] : '';

        $background_value = get_theme_mod( "beyond_gotham_socialbar_{$variant_key}_background_color", $background_default );
        $hover_value      = get_theme_mod( "beyond_gotham_socialbar_{$variant_key}_hover_color", $hover_default );
        $icon_value       = get_theme_mod( "beyond_gotham_socialbar_{$variant_key}_icon_color", $icon_default );

        $background_color = sanitize_hex_color( $background_value );
        $hover_color      = sanitize_hex_color( $hover_value );
        $icon_color       = sanitize_hex_color( $icon_value );

        if ( ! $background_color && '' !== $background_default ) {
            $background_color = sanitize_hex_color( $background_default );
        }

        if ( ! $hover_color && '' !== $hover_default ) {
            $hover_color = sanitize_hex_color( $hover_default );
        }

        if ( ! $icon_color && '' !== $icon_default ) {
            $icon_color = sanitize_hex_color( $icon_default );
        }

        $style_colors[ $variant_key ] = array(
            'background' => $background_color ? $background_color : '',
            'hover'      => $hover_color ? $hover_color : '',
            'icon'       => $icon_color ? $icon_color : '',
        );
    }

    return array(
        'show_header'      => (bool) get_theme_mod( 'beyond_gotham_show_socialbar_header', false ),
        'show_mobile'      => (bool) get_theme_mod( 'beyond_gotham_show_socialbar_mobile', true ),
        'position'         => beyond_gotham_sanitize_socialbar_position( get_theme_mod( 'beyond_gotham_socialbar_position', 'bottom' ) ),
        'icon_style'       => beyond_gotham_sanitize_socialbar_icon_style( get_theme_mod( 'beyond_gotham_socialbar_icon_style', 'monochrom' ) ),
        'surface_color'    => $surface_background ? $surface_background : '#111111',
        'surface_icon'     => $surface_icon ? $surface_icon : '#ffffff',
        'style_variant'    => $style_variant,
        'style_colors'     => $style_colors,
    );
}

/**
 * Output social navigation markup based on the theme options.
 *
 * Retrieve the inline SVG markup for supported social networks.
 *
 * @return array<string, string>
 */
function beyond_gotham_get_social_icon_svgs() {
    return array(
        'github'   => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.387.6.113.82-.258.82-.577 0-.285-.011-1.04-.017-2.04-3.338.726-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.757-1.333-1.757-1.089-.744.083-.73.083-.73 1.205.085 1.84 1.237 1.84 1.237 1.07 1.834 2.807 1.304 3.492.997.108-.776.418-1.304.762-1.604-2.665-.303-5.466-1.332-5.466-5.93 0-1.31.469-2.381 1.236-3.221-.124-.303-.536-1.523.117-3.176 0 0 1.008-.322 3.3 1.23a11.51 11.51 0 0 1 3-.404c1.02.005 2.047.138 3 .404 2.29-1.552 3.297-1.23 3.297-1.23.655 1.653.243 2.873.12 3.176.77.84 1.235 1.911 1.235 3.221 0 4.61-2.804 5.624-5.476 5.921.43.371.823 1.102.823 2.222 0 1.604-.015 2.896-.015 3.286 0 .321.216.694.825.576C20.565 22.092 24 17.592 24 12.297 24 5.373 18.627.297 12 .297z"/></svg>',
        'linkedin' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M20.451 20.451h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.354V9h3.414v1.561h.047c.476-.9 1.637-1.852 3.37-1.852 3.602 0 4.266 2.37 4.266 5.455v6.287zM5.337 7.433a2.062 2.062 0 1 1 0-4.124 2.062 2.062 0 0 1 0 4.124zM7.119 20.451H3.554V9h3.565v11.451zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0z"/></svg>',
        'mastodon' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M23.147 7.144c0-5.213-3.43-6.756-3.43-6.756-1.73-.793-4.707-1.123-7.804-1.153h-.073c-3.098.03-6.073.36-7.804 1.153 0 0-3.43 1.543-3.43 6.756-.045.985-.086 2.16.014 3.411.321 3.663 2.426 7.079 4.854 8.425 1.875 1.041 3.497.999 3.497.999l.079-.094v-1.86s-1.6.511-3.333-.706c-.819-.567-1.341-1.377-1.684-2.188.411.316.959.594 1.645.743 2.851.61 5.363.267 7.996-.175 2.525-.426 4.924-1.46 4.924-1.46s-1.395 2.024-5.076 3.039l.111 2.137s1.624.043 3.5-1c2.428-1.347 4.533-4.763 4.854-8.425.1-1.251.059-2.426.014-3.411zm-4.165 5.163h-2.054V8.29c0-1.053-.446-1.59-1.337-1.59-.987 0-1.48.639-1.48 1.907v2.773h-2.043V8.607c0-1.268-.494-1.907-1.48-1.907-.891 0-1.337.538-1.337 1.59v4.017H7.197V8.211c0-1.053.267-1.907.801-2.462.552-.555 1.276-.835 2.173-.835 1.038 0 1.823.399 2.333 1.197l.5.843.5-.843c.51-.798 1.295-1.197 2.333-1.197.897 0 1.621.28 2.173.835.535.555.801 1.409.801 2.462v4.096z"/></svg>',
        'twitter'  => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M23.954 2.573c-.885.389-1.83.654-2.825.775 1.014-.608 1.794-1.571 2.163-2.724-.949.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-2.723 0-4.932 2.206-4.932 4.927 0 .39.045.765.127 1.124-4.094-.205-7.725-2.165-10.161-5.144-.424.722-.666 1.561-.666 2.475 0 1.709.87 3.215 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.6 3.419-1.68 1.319-3.809 2.107-6.102 2.107-.395 0-.779-.023-1.17-.067 2.179 1.394 4.768 2.209 7.557 2.209 9.054 0 14.001-7.496 14.001-13.986 0-.21 0-.423-.016-.637.961-.695 1.8-1.562 2.46-2.549z"/></svg>',
        'facebook' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z"/></svg>',
        'instagram' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M7.03.084c-1.277.06-2.149.264-2.911.563-.789.308-1.458.72-2.123 1.388-.665.668-1.075 1.337-1.38 2.127-.295.764-.496 1.637-.552 2.914-.056 1.278-.069 1.689-.063 4.947.006 3.259.021 3.667.083 4.947.061 1.277.264 2.149.564 2.912.308.789.72 1.457 1.388 2.123.668.665 1.337 1.074 2.129 1.38.763.295 1.636.496 2.913.552 1.277.056 1.688.069 4.946.063 3.258-.006 3.668-.021 4.948-.082 1.28-.061 2.147-.265 2.91-.563.789-.309 1.458-.72 2.123-1.388.665-.668 1.075-1.338 1.38-2.128.296-.763.497-1.636.552-2.912.056-1.281.069-1.69.063-4.948-.006-3.258-.021-3.667-.082-4.946-.061-1.28-.265-2.149-.563-2.912-.308-.789-.72-1.457-1.388-2.123C21.298 1.33 20.628.921 19.838.617c-.764-.296-1.636-.497-2.914-.552C15.647.009 15.236-.005 11.977.001 8.718.008 8.31.021 7.03.084Zm.14 21.693c-1.17-.051-1.805-.245-2.229-.408-.561-.216-.96-.477-1.382-.895-.422-.418-.681-.819-.9-1.378-.165-.424-.362-1.058-.417-2.228-.059-1.265-.072-1.645-.071-4.848-.007-3.204.005-3.583.06-4.848.05-1.169.246-1.805.408-2.228.216-.561.476-.96.895-1.382.419-.422.818-.681 1.378-.9.423-.165 1.058-.361 2.227-.417 1.266-.06 1.645-.072 4.848-.079 3.203-.007 3.584.005 4.85.061 1.169.051 1.805.245 2.228.408.561.216.96.476 1.382.895.422.419.682.818.901 1.379.165.422.361 1.056.417 2.226.06 1.266.074 1.645.08 4.848.006 3.203-.006 3.583-.061 4.848-.051 1.17-.245 1.806-.408 2.229-.216.56-.476.96-.896 1.381-.419.422-.818.681-1.378.9-.422.165-1.058.362-2.226.417-1.266.06-1.645.072-4.85.079-3.204.007-3.582-.006-4.848-.061ZM16.953 5.586a1.44 1.44 0 1 0 1.437-1.442 1.44 1.44 0 0 0-1.437 1.442ZM5.839 12.012c.007 3.403 2.77 6.156 6.173 6.15 3.403-.007 6.157-2.77 6.15-6.173-.006-3.403-2.771-6.157-6.174-6.15-3.403.007-6.156 2.771-6.15 6.173ZM8 12.008a4 4 0 1 1 4.008 3.992A4 4 0 0 1 8 12.008Z"/></svg>',
        'tiktok'    => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>',
        'youtube'   => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
        'telegram'  => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',
        'email'    => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M20 4H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h16a2 2 0 0 0 2-2V6c0-1.1-.9-2-2-2Zm0 2v.01L12 13 4 6.01V6Zm-16 12V8l8 6 8-6v10Z"/></svg>',
    );
}

/**
 * Output social navigation markup based on the theme options.
 *
 * @param array|null $links Optional link data to render.
 * @param array      $args  Optional rendering arguments.
 */
function beyond_gotham_render_social_links( $links = null, $args = array() ) {
    if ( null === $links ) {
        $links = beyond_gotham_get_social_links();
    }

    if ( empty( $links ) ) {
        return;
    }

    $labels = array(
        'github'   => __( 'GitHub', 'beyond_gotham' ),
        'linkedin' => __( 'LinkedIn', 'beyond_gotham' ),
        'mastodon' => __( 'Mastodon', 'beyond_gotham' ),
        'twitter'  => __( 'X (Twitter)', 'beyond_gotham' ),
        'facebook' => __( 'Facebook', 'beyond_gotham' ),
        'instagram' => __( 'Instagram', 'beyond_gotham' ),
        'tiktok'   => __( 'TikTok', 'beyond_gotham' ),
        'youtube'  => __( 'YouTube', 'beyond_gotham' ),
        'telegram' => __( 'Telegram', 'beyond_gotham' ),
        'email'    => __( 'E-Mail', 'beyond_gotham' ),
    );

    $args = wp_parse_args(
        $args,
        array(
            'context' => 'nav',
        )
    );

    if ( 'footer-icons' === $args['context'] ) {
        $wrapper_classes = array();
        $wrapper_attributes = array();
        $hidden = false;

        if ( ! empty( $args['wrapper_classes'] ) ) {
            $wrapper_classes = is_array( $args['wrapper_classes'] ) ? $args['wrapper_classes'] : array( $args['wrapper_classes'] );
        }

        if ( ! empty( $args['wrapper_attributes'] ) ) {
            if ( is_string( $args['wrapper_attributes'] ) ) {
                $wrapper_attributes = $args['wrapper_attributes'];
                if ( false !== strpos( $args['wrapper_attributes'], 'hidden' ) ) {
                    $hidden = true;
                }
            } else {
                $wrapper_attributes = $args['wrapper_attributes'];
            }
        }

        get_template_part(
            'template-parts/social-icons',
            null,
            array(
                'context'            => 'footer',
                'links'              => $links,
                'wrapper_classes'    => $wrapper_classes,
                'wrapper_attributes' => $wrapper_attributes,
                'hidden'             => $hidden,
                'aria_label'         => __( 'Footer Social Media', 'beyond_gotham' ),
            )
        );

        return;
    }

    echo '<ul class="site-nav__social site-nav__social--theme">';

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
 * Render the social bar markup for the requested location.
 *
 * @param string $location Social bar location. Accepts 'header' or 'mobile'.
 */
function beyond_gotham_render_socialbar( $location = 'header' ) {
    $location = 'mobile' === $location ? 'mobile' : 'header';

    $links    = beyond_gotham_get_social_links();
    $settings = beyond_gotham_get_socialbar_settings();

    if ( empty( $links ) ) {
        return;
    }

    if ( ( 'mobile' === $location && empty( $settings['show_mobile'] ) ) || ( 'header' === $location && empty( $settings['show_header'] ) ) ) {
        return;
    }

    $labels = array(
        'github'   => __( 'GitHub', 'beyond_gotham' ),
        'linkedin' => __( 'LinkedIn', 'beyond_gotham' ),
        'mastodon' => __( 'Mastodon', 'beyond_gotham' ),
        'twitter'  => __( 'X (Twitter)', 'beyond_gotham' ),
        'facebook' => __( 'Facebook', 'beyond_gotham' ),
        'instagram' => __( 'Instagram', 'beyond_gotham' ),
        'tiktok'   => __( 'TikTok', 'beyond_gotham' ),
        'youtube'  => __( 'YouTube', 'beyond_gotham' ),
        'telegram' => __( 'Telegram', 'beyond_gotham' ),
        'email'    => __( 'E-Mail', 'beyond_gotham' ),
    );

    $icons = beyond_gotham_get_social_icon_svgs();

    $wrapper_classes = array( 'socialbar', 'socialbar--' . $location );

    if ( ! empty( $settings['icon_style'] ) ) {
        $wrapper_classes[] = 'socialbar--icon-' . $settings['icon_style'];
    }

    if ( ! empty( $settings['style_variant'] ) ) {
        $wrapper_classes[] = 'socialbar--' . $settings['style_variant'];
    }

    $wrapper_classes = array_map( 'sanitize_html_class', array_filter( $wrapper_classes ) );

    $wrapper_label = 'mobile' === $location
        ? __( 'Social-Media-Leiste (mobil)', 'beyond_gotham' )
        : __( 'Social-Media-Leiste im Header', 'beyond_gotham' );

    $attributes = array(
        'class'         => implode( ' ', $wrapper_classes ),
        'data-location' => $location,
        'role'          => 'navigation',
        'aria-label'    => $wrapper_label,
    );

    if ( ! empty( $settings['style_variant'] ) ) {
        $attributes['data-variant'] = $settings['style_variant'];
    }

    if ( 'mobile' === $location && ! empty( $settings['position'] ) ) {
        $attributes['data-position'] = $settings['position'];
    }

    $style_attributes = array();

    if ( ! empty( $settings['surface_color'] ) ) {
        $style_attributes['--socialbar-surface'] = $settings['surface_color'];
    }

    if ( ! empty( $settings['surface_icon'] ) ) {
        $style_attributes['--socialbar-icon'] = $settings['surface_icon'];
    }

    if ( ! empty( $settings['style_variant'] ) && ! empty( $settings['style_colors'][ $settings['style_variant'] ] ) ) {
        $active_colors = $settings['style_colors'][ $settings['style_variant'] ];

        if ( ! empty( $active_colors['background'] ) ) {
            $style_attributes['--socialbar-bg'] = $active_colors['background'];
        }

        if ( ! empty( $active_colors['hover'] ) ) {
            $style_attributes['--socialbar-hover'] = $active_colors['hover'];
        }

        if ( ! empty( $active_colors['icon'] ) ) {
            $style_attributes['--socialbar-icon'] = $active_colors['icon'];
        }
    }

    if ( ! empty( $style_attributes ) ) {
        $style_pairs = array();

        foreach ( $style_attributes as $var => $value ) {
            if ( '' === $value ) {
                continue;
            }

            $style_pairs[] = sprintf( '%s:%s', $var, $value );
        }

        if ( ! empty( $style_pairs ) ) {
            $attributes['style'] = implode( ';', $style_pairs );
        }
    }

    $items = array();

    foreach ( $links as $network => $url ) {
        if ( empty( $url ) ) {
            continue;
        }

        $slug = $network;

        if ( function_exists( 'beyond_gotham_detect_social_network' ) ) {
            $detected = beyond_gotham_detect_social_network( $url );
            if ( $detected ) {
                $slug = $detected;
            }
        }

        $label_key = isset( $labels[ $slug ] ) ? $slug : $network;
        $label     = isset( $labels[ $label_key ] ) ? $labels[ $label_key ] : ucfirst( $label_key );

        if ( ! isset( $icons[ $slug ] ) ) {
            continue;
        }

        $items[] = array(
            'url'   => $url,
            'slug'  => $slug,
            'label' => $label,
        );
    }

    if ( empty( $items ) ) {
        return;
    }

    $attribute_string = '';

    foreach ( $attributes as $attr => $value ) {
        if ( '' === $value ) {
            continue;
        }

        $attribute_string .= sprintf( ' %s="%s"', esc_attr( $attr ), esc_attr( $value ) );
    }

    echo '<div' . $attribute_string . '>';

    foreach ( $items as $item ) {
        $is_mail = 0 === strpos( $item['url'], 'mailto:' );

        $link_attrs = array(
            'href'         => $item['url'],
            'aria-label'   => $item['label'],
            'data-network' => $item['slug'],
            'class'        => 'socialbar__link',
        );

        if ( ! $is_mail ) {
            $link_attrs['target'] = '_blank';
            $link_attrs['rel']    = 'noopener';
        }

        $link_attribute_string = '';

        foreach ( $link_attrs as $attr => $value ) {
            if ( '' === $value ) {
                continue;
            }

            $sanitized_attr = esc_attr( $attr );
            $escaped_value  = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
            $link_attribute_string .= sprintf( ' %s="%s"', $sanitized_attr, $escaped_value );
        }

        echo '<a' . $link_attribute_string . '>';
        echo '<span class="socialbar__icon" aria-hidden="true">';
        echo $icons[ $item['slug'] ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo '</span>';
        echo '<span class="socialbar__label">' . esc_html( $item['label'] ) . '</span>';
        echo '</a>';
    }

    echo '</div>';
}

/**
 * Output the mobile social bar in the footer when enabled.
 */
function beyond_gotham_output_mobile_socialbar() {
    beyond_gotham_render_socialbar( 'mobile' );
}
add_action( 'wp_footer', 'beyond_gotham_output_mobile_socialbar', 15 );

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

    $socialbar_settings = beyond_gotham_get_socialbar_settings();

    if ( ! empty( $socialbar_settings['surface_color'] ) ) {
        $layout_root_vars['--socialbar-surface'] = $socialbar_settings['surface_color'];
    }

    if ( ! empty( $socialbar_settings['surface_icon'] ) ) {
        $layout_root_vars['--socialbar-icon'] = $socialbar_settings['surface_icon'];
    }

    if ( ! empty( $socialbar_settings['style_variant'] ) && ! empty( $socialbar_settings['style_colors'][ $socialbar_settings['style_variant'] ] ) ) {
        $variant_colors = $socialbar_settings['style_colors'][ $socialbar_settings['style_variant'] ];

        if ( ! empty( $variant_colors['background'] ) ) {
            $layout_root_vars['--socialbar-bg'] = $variant_colors['background'];
        }

        if ( ! empty( $variant_colors['hover'] ) ) {
            $layout_root_vars['--socialbar-hover'] = $variant_colors['hover'];
        }

        if ( ! empty( $variant_colors['icon'] ) ) {
            $layout_root_vars['--socialbar-icon'] = $variant_colors['icon'];
        }
    }

    if ( ! empty( $header_layout['height_css'] ) ) {
        $layout_root_vars['--site-header-height'] = $header_layout['height_css'];
    }

    if ( isset( $header_layout['padding_top_css'] ) && '' !== $header_layout['padding_top_css'] ) {
        $layout_root_vars['--site-header-padding-top'] = $header_layout['padding_top_css'];
    }

    if ( isset( $header_layout['padding_bottom_css'] ) && '' !== $header_layout['padding_bottom_css'] ) {
        $layout_root_vars['--site-header-padding-bottom'] = $header_layout['padding_bottom_css'];
    }

    if ( ! empty( $footer_layout['height_css'] ) ) {
        $layout_root_vars['--site-footer-height'] = $footer_layout['height_css'];
    }

    if ( ! empty( $footer_layout['max_height_css'] ) ) {
        $layout_root_vars['--site-footer-max-height'] = $footer_layout['max_height_css'];
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
        $header_rules[] = 'height: var(--site-header-height, ' . $header_layout['height_css'] . ');';
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

    if ( ! empty( $footer_layout['height_css'] ) ) {
        $footer_rules[] = 'height: var(--site-footer-height, ' . $footer_layout['height_css'] . ');';
    }

    if ( ! empty( $footer_layout['min_height_css'] ) ) {
        $footer_rules[] = 'min-height: var(--site-footer-min-height, ' . $footer_layout['min_height_css'] . ');';
    }

    if ( ! empty( $footer_layout['max_height_css'] ) ) {
        $footer_rules[] = 'max-height: var(--site-footer-max-height, ' . $footer_layout['max_height_css'] . ');';
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
 * Retrieve the current social sharing settings.
 *
 * @return array<string, array<string, bool>>
 */
function beyond_gotham_get_social_share_settings() {
    $defaults = beyond_gotham_get_social_share_defaults();

    $settings = array(
        'display'  => array(),
        'networks' => array(),
    );

    foreach ( $defaults['display'] as $context => $default ) {
        $settings['display'][ $context ] = (bool) get_theme_mod( 'beyond_gotham_share_display_' . $context, $default );
    }

    foreach ( $defaults['networks'] as $network => $default ) {
        $settings['networks'][ $network ] = (bool) get_theme_mod( 'beyond_gotham_share_network_' . $network, $default );
    }

    /**
     * Filter the resolved social sharing settings.
     *
     * @param array $settings Current social sharing settings.
     * @param array $defaults Default social sharing settings.
     */
    return apply_filters( 'beyond_gotham_social_share_settings', $settings, $defaults );
}

/**
 * Determine whether social sharing is enabled for a given context.
 *
 * @param string $context Content context (post, page, category, ...).
 * @return bool
 */
function beyond_gotham_is_social_sharing_enabled_for( $context ) {
    $context = is_string( $context ) ? strtolower( trim( $context ) ) : '';

    if ( '' === $context ) {
        return false;
    }

    if ( ! get_theme_mod( 'enable_social_share', true ) ) {
        return false;
    }

    $settings = beyond_gotham_get_social_share_settings();

    $enabled = ! empty( $settings['display'][ $context ] );

    /**
     * Filter whether social sharing should be shown for a given context.
     *
     * @param bool   $enabled Whether sharing is enabled.
     * @param string $context The evaluated context.
     * @param array  $settings The resolved sharing settings.
     */
    return (bool) apply_filters( 'beyond_gotham_social_share_enabled', $enabled, $context, $settings );
}

/**
 * Build share links for the enabled social networks.
 *
 * @param string $share_url   URL that should be shared.
 * @param string $share_title Title that accompanies the share.
 * @return array<int, array<string, string>>
 */
function beyond_gotham_build_social_share_links( $share_url, $share_title ) {
    $share_url = esc_url_raw( $share_url );

    if ( '' === $share_url ) {
        return array();
    }

    $share_title = wp_strip_all_tags( (string) $share_title );

    if ( '' === $share_title ) {
        $share_title = wp_strip_all_tags( get_bloginfo( 'name' ) );
    }

    $settings = beyond_gotham_get_social_share_settings();

    $encoded_url   = rawurlencode( $share_url );
    $encoded_title = rawurlencode( $share_title );
    $encoded_text  = rawurlencode( trim( $share_title . ' ' . $share_url ) );

    $available_networks = array(
        'linkedin' => array(
            'label' => __( 'LinkedIn', 'beyond_gotham' ),
            'icon'  => 'in',
        ),
        'twitter'  => array(
            'label' => __( 'X (Twitter)', 'beyond_gotham' ),
            'icon'  => 'x',
        ),
        'mastodon' => array(
            'label' => __( 'Mastodon', 'beyond_gotham' ),
            'icon'  => 'M',
        ),
        'facebook' => array(
            'label' => __( 'Facebook', 'beyond_gotham' ),
            'icon'  => 'f',
        ),
        'whatsapp' => array(
            'label' => __( 'WhatsApp', 'beyond_gotham' ),
            'icon'  => 'WA',
        ),
        'github'   => array(
            'label' => __( 'GitHub', 'beyond_gotham' ),
            'icon'  => 'GH',
        ),
    );

    $links = array();

    foreach ( $available_networks as $network_key => $network ) {
        if ( empty( $settings['networks'][ $network_key ] ) ) {
            continue;
        }

        $url = '';

        switch ( $network_key ) {
            case 'linkedin':
                $url = sprintf( 'https://www.linkedin.com/shareArticle?mini=1&url=%1$s&title=%2$s', $encoded_url, $encoded_title );
                break;
            case 'twitter':
                $url = sprintf( 'https://twitter.com/intent/tweet?url=%1$s&text=%2$s', $encoded_url, $encoded_title );
                break;
            case 'mastodon':
                $url = sprintf( 'https://mastodonshare.com/?text=%s', $encoded_text );
                break;
            case 'facebook':
                $url = sprintf( 'https://www.facebook.com/sharer/sharer.php?u=%s', $encoded_url );
                break;
            case 'whatsapp':
                $url = sprintf( 'https://api.whatsapp.com/send?text=%s', $encoded_text );
                break;
            case 'github':
                $url = sprintf( 'https://github.com/search?q=%s&type=discussions', $encoded_url );
                break;
        }

        if ( '' === $url ) {
            continue;
        }

        $network['key']        = $network_key;
        $network['url']        = $url;
        $network['aria_label'] = sprintf( __( 'Auf %s teilen', 'beyond_gotham' ), $network['label'] );

        $links[] = $network;
    }

    /**
     * Filter the generated social share links.
     *
     * @param array  $links       Share links prepared for output.
     * @param string $share_url   The URL that should be shared.
     * @param string $share_title The title associated with the share.
     * @param array  $settings    The resolved sharing settings.
     */
    return apply_filters( 'beyond_gotham_social_share_links', $links, $share_url, $share_title, $settings );
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
            'footerSocialSelector' => '[data-bg-footer-social]',
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
add_action( 'customize_preview_init', 'beyond_gotham_customize_preview_js' );
