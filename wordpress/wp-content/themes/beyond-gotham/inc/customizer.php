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
 * Restrict CTA width units to supported values.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_cta_width_unit( $value ) {
    $value = is_string( $value ) ? strtolower( trim( $value ) ) : '';

    if ( in_array( $value, array( 'px', '%', 'rem' ), true ) ) {
        return $value;
    }

    return 'px';
}

/**
 * Limit CTA size presets to known choices.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_cta_size_preset( $value ) {
    $value   = is_string( $value ) ? strtolower( trim( $value ) ) : '';
    $choices = array( 'small', 'medium', 'large', 'custom' );

    if ( in_array( $value, $choices, true ) ) {
        return $value;
    }

    return 'medium';
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
 * Determine if the CTA layout controls for custom sizing should be visible.
 *
 * @param WP_Customize_Control $control Control instance.
 * @return bool
 */
function beyond_gotham_customize_is_cta_custom_size( $control ) {
    if ( ! $control instanceof WP_Customize_Control ) {
        return true;
    }

    $setting = $control->manager->get_setting( 'beyond_gotham_cta_size_preset' );

    if ( ! $setting ) {
        return true;
    }

    return 'custom' === beyond_gotham_sanitize_cta_size_preset( $setting->value() );
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
function beyond_gotham_get_cta_size_presets() {
    return array(
        'small'  => array(
            'label'            => __( 'Klein', 'beyond_gotham' ),
            'max_width_value'  => 560,
            'max_width_unit'   => 'px',
            'min_height_value' => 240,
        ),
        'medium' => array(
            'label'            => __( 'Mittel (Standard)', 'beyond_gotham' ),
            'max_width_value'  => 800,
            'max_width_unit'   => 'px',
            'min_height_value' => 320,
        ),
        'large'  => array(
            'label'            => __( 'Groß', 'beyond_gotham' ),
            'max_width_value'  => 100,
            'max_width_unit'   => '%',
            'min_height_value' => 380,
        ),
    );
}

/**
 * Default CTA layout configuration.
 *
 * @return array
 */
function beyond_gotham_get_cta_layout_defaults() {
    $presets = beyond_gotham_get_cta_size_presets();
    $medium  = isset( $presets['medium'] ) ? $presets['medium'] : array();

    return array(
        'size_preset'      => 'medium',
        'max_width_value'  => isset( $medium['max_width_value'] ) ? $medium['max_width_value'] : 800,
        'max_width_unit'   => isset( $medium['max_width_unit'] ) ? $medium['max_width_unit'] : 'px',
        'min_height_value' => isset( $medium['min_height_value'] ) ? $medium['min_height_value'] : 320,
        'position'         => 'bottom',
        'alignment'        => 'center',
    );
}

/**
 * Format CSS size values with units.
 *
 * @param float  $value Numeric value.
 * @param string $unit  CSS unit.
 * @return string
 */
function beyond_gotham_format_css_size( $value, $unit ) {
    $value = beyond_gotham_sanitize_positive_float( $value );
    $unit  = beyond_gotham_sanitize_cta_width_unit( $unit );

    if ( $value <= 0 ) {
        return '';
    }

    $precision = ( 'rem' === $unit ) ? 2 : 1;
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
    $defaults         = beyond_gotham_get_cta_layout_defaults();
    $size_preset      = beyond_gotham_sanitize_cta_size_preset( get_theme_mod( 'beyond_gotham_cta_size_preset', $defaults['size_preset'] ) );
    $max_width_value  = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_max_width_value', $defaults['max_width_value'] ) );
    $max_width_unit   = beyond_gotham_sanitize_cta_width_unit( get_theme_mod( 'beyond_gotham_cta_max_width_unit', $defaults['max_width_unit'] ) );
    $min_height_value = beyond_gotham_sanitize_positive_float( get_theme_mod( 'beyond_gotham_cta_min_height', $defaults['min_height_value'] ) );
    $position         = beyond_gotham_sanitize_cta_position( get_theme_mod( 'beyond_gotham_cta_position', $defaults['position'] ) );
    $alignment        = beyond_gotham_sanitize_cta_alignment( get_theme_mod( 'beyond_gotham_cta_alignment', $defaults['alignment'] ) );
    $presets          = beyond_gotham_get_cta_size_presets();

    if ( 'custom' !== $size_preset && isset( $presets[ $size_preset ] ) ) {
        $preset = $presets[ $size_preset ];

        if ( isset( $preset['max_width_value'] ) ) {
            $max_width_value = beyond_gotham_sanitize_positive_float( $preset['max_width_value'] );
        }

        if ( isset( $preset['max_width_unit'] ) ) {
            $max_width_unit = beyond_gotham_sanitize_cta_width_unit( $preset['max_width_unit'] );
        }

        if ( isset( $preset['min_height_value'] ) ) {
            $min_height_value = beyond_gotham_sanitize_positive_float( $preset['min_height_value'] );
        }
    }

    $max_width = beyond_gotham_format_css_size( $max_width_value, $max_width_unit );
    $min_height = $min_height_value > 0 ? beyond_gotham_format_css_size( $min_height_value, 'px' ) : '';

    $classes = array(
        'cta-' . $position,
        'cta-align-' . $alignment,
        'cta-size-' . $size_preset,
    );

    $style_map = array();

    if ( $max_width ) {
        $style_map['--cta-max-width'] = $max_width;
    }

    if ( $min_height ) {
        $style_map['--cta-min-height'] = $min_height;
    }

    return array(
        'size_preset'      => $size_preset,
        'max_width_value'  => $max_width_value,
        'max_width_unit'   => $max_width_unit,
        'max_width'        => $max_width,
        'min_height_value' => $min_height_value,
        'min_height'       => $min_height,
        'position'         => $position,
        'alignment'        => $alignment,
        'class_list'       => array_values( array_unique( array_filter( array_map( 'sanitize_html_class', $classes ) ) ) ),
        'style_map'        => $style_map,
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
        'beyond_gotham_cta_layout',
        array(
            'title'       => __( 'Call-to-Action Layout', 'beyond_gotham' ),
            'priority'    => 41,
            'description' => __( 'Steuere Position und Größe der CTA-Box auf Landingpages und Beitragsseiten.', 'beyond_gotham' ),
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

    $cta_layout_defaults = beyond_gotham_get_cta_layout_defaults();
    $cta_size_presets    = beyond_gotham_get_cta_size_presets();
    $cta_preset_choices  = array();

    foreach ( $cta_size_presets as $key => $preset ) {
        $cta_preset_choices[ $key ] = isset( $preset['label'] ) ? $preset['label'] : ucfirst( $key );
    }

    $cta_preset_choices['custom'] = __( 'Individuell', 'beyond_gotham' );

    $wp_customize->add_setting(
        'beyond_gotham_cta_size_preset',
        array(
            'default'           => $cta_layout_defaults['size_preset'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_cta_size_preset',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_cta_size_preset_control',
        array(
            'label'       => __( 'Größen-Preset', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_cta_layout',
            'settings'    => 'beyond_gotham_cta_size_preset',
            'type'        => 'select',
            'choices'     => $cta_preset_choices,
            'description' => __( 'Wähle eine Vorlage oder passe Breite und Höhe individuell an.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_cta_max_width_value',
        array(
            'default'           => $cta_layout_defaults['max_width_value'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_cta_max_width_value_control',
        array(
            'label'           => __( 'Maximale Breite', 'beyond_gotham' ),
            'section'         => 'beyond_gotham_cta_layout',
            'settings'        => 'beyond_gotham_cta_max_width_value',
            'type'            => 'number',
            'active_callback' => 'beyond_gotham_customize_is_cta_custom_size',
            'input_attrs'     => array(
                'min'  => 40,
                'max'  => 1600,
                'step' => 1,
            ),
            'description'     => __( 'Gib den Zahlenwert der Breite an. Einheit unten auswählen.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_cta_max_width_unit',
        array(
            'default'           => $cta_layout_defaults['max_width_unit'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_cta_width_unit',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_cta_max_width_unit_control',
        array(
            'label'           => __( 'Einheit der Breite', 'beyond_gotham' ),
            'section'         => 'beyond_gotham_cta_layout',
            'settings'        => 'beyond_gotham_cta_max_width_unit',
            'type'            => 'radio',
            'active_callback' => 'beyond_gotham_customize_is_cta_custom_size',
            'choices'         => array(
                'px'  => __( 'Pixel (px)', 'beyond_gotham' ),
                '%'   => __( 'Prozent (%)', 'beyond_gotham' ),
                'rem' => __( 'Rem (rem)', 'beyond_gotham' ),
            ),
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_cta_min_height',
        array(
            'default'           => $cta_layout_defaults['min_height_value'],
            'type'              => 'theme_mod',
            'sanitize_callback' => 'beyond_gotham_sanitize_positive_float',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_cta_min_height_control',
        array(
            'label'           => __( 'Innenhöhe (min-height)', 'beyond_gotham' ),
            'section'         => 'beyond_gotham_cta_layout',
            'settings'        => 'beyond_gotham_cta_min_height',
            'type'            => 'range',
            'active_callback' => 'beyond_gotham_customize_is_cta_custom_size',
            'input_attrs'     => array(
                'min'  => 200,
                'max'  => 600,
                'step' => 10,
            ),
            'description'     => __( 'Höhe in Pixeln, die innerhalb der CTA mindestens beibehalten wird.', 'beyond_gotham' ),
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
            'section'  => 'beyond_gotham_cta_layout',
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
            'section'  => 'beyond_gotham_cta_layout',
            'settings' => 'beyond_gotham_cta_alignment',
            'type'     => 'radio',
            'choices'  => array(
                'left'   => __( 'Links', 'beyond_gotham' ),
                'center' => __( 'Zentriert', 'beyond_gotham' ),
                'right'  => __( 'Rechts', 'beyond_gotham' ),
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
    $presets       = beyond_gotham_get_typography_presets();
    $nav_layout    = beyond_gotham_get_nav_layout_settings();
    $sticky_offset = isset( $nav_layout['sticky_offset'] ) ? absint( $nav_layout['sticky_offset'] ) : 0;

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

    $css = ':root {';
    $css .= '--bg-sticky-offset: ' . $sticky_offset . 'px;';
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

    $body_rules = array();

    if ( isset( $presets[ $body_font_key ] ) ) {
        $body_rules[] = 'font-family: ' . $presets[ $body_font_key ]['stack'] . ';';
    }

    $body_rules[] = 'font-size: ' . $font_size_value . $font_unit . ';';
    $body_rules[] = 'line-height: ' . $line_height_value . ';';

    if ( ! empty( $body_rules ) ) {
        $css .= 'body {' . implode( ' ', $body_rules ) . '}';
    }

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

    $cta_layout  = function_exists( 'beyond_gotham_get_cta_layout_settings' ) ? beyond_gotham_get_cta_layout_settings() : array();
    $cta_presets = function_exists( 'beyond_gotham_get_cta_size_presets' ) ? beyond_gotham_get_cta_size_presets() : array();

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
            'ctaSizePresets'      => $cta_presets,
            'defaults'             => $color_defaults,
            'colorDefaults'        => $color_defaults,
            'contrastThreshold'    => 4.5,
        )
    );
}
add_action( 'customize_preview_init', 'beyond_gotham_customize_preview_js' );
