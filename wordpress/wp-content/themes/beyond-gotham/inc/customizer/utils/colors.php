<?php
/**
 * Shared color helper utilities for the customizer.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get default color values for light and dark modes.
 *
 * @return array
 */
function beyond_gotham_get_color_defaults() {
    return array(
        'light' => array(
            'background'          => '#f4f6fb',
            'text_color'          => '#0f172a',
            'primary'             => '#33d1ff',
            'secondary'           => '#1aa5d1',
            'cta_accent'          => '#33d1ff',
            'header_background'   => '#ffffff',
            'footer_background'   => '#f4f6fb',
            'link'                => '#0f172a',
            'link_hover'          => '#1aa5d1',
            'button_background'   => '#33d1ff',
            'button_text'         => '#050608',
            'quote_background'    => '#e6edf7',
            'accent'              => '#33d1ff',
        ),
        'dark'  => array(
            'background'          => '#0f1115',
            'text_color'          => '#e7eaee',
            'primary'             => '#33d1ff',
            'secondary'           => '#1aa5d1',
            'cta_accent'          => '#33d1ff',
            'header_background'   => '#0b0d12',
            'footer_background'   => '#050608',
            'link'                => '#33d1ff',
            'link_hover'          => '#1aa5d1',
            'button_background'   => '#33d1ff',
            'button_text'         => '#050608',
            'quote_background'    => '#161b2a',
            'accent'              => '#33d1ff',
        ),
    );
}

/**
 * Retrieve a normalized palette for a given mode.
 *
 * @param string $mode Color mode slug (light/dark).
 * @return array
 */
function beyond_gotham_get_color_palette( $mode = 'light' ) {
    $mode     = in_array( $mode, array( 'light', 'dark' ), true ) ? $mode : 'light';
    $defaults = beyond_gotham_get_color_defaults();

    $settings_map = array(
        'background'        => array( 'id' => 'background_color' ),
        'text_color'        => array( 'id' => 'text_color' ),
        'primary'           => array( 'id' => 'primary_color', 'legacy' => 'accent' ),
        'secondary'         => array( 'id' => 'secondary_color' ),
        'cta_accent'        => array( 'id' => 'cta_accent_color', 'legacy' => 'accent' ),
        'header_background' => array( 'id' => 'header_background_color' ),
        'footer_background' => array( 'id' => 'footer_background_color' ),
        'link'              => array( 'id' => 'link_color' ),
        'link_hover'        => array( 'id' => 'link_hover_color' ),
        'button_background' => array( 'id' => 'button_background_color' ),
        'button_text'       => array( 'id' => 'button_text_color' ),
        'quote_background'  => array( 'id' => 'quote_background_color' ),
    );

    $palette = array();

    foreach ( $settings_map as $key => $config ) {
        $default = isset( $defaults[ $mode ][ $key ] ) ? $defaults[ $mode ][ $key ] : '';
        $setting_id = 'beyond_gotham_' . $config['id'] . '_' . $mode;

        $value = sanitize_hex_color( get_theme_mod( $setting_id ) );

        if ( ! $value && ! empty( $config['legacy'] ) ) {
            $legacy_id = 'beyond_gotham_' . $config['legacy'] . '_' . $mode;
            $legacy    = sanitize_hex_color( get_theme_mod( $legacy_id ) );

            if ( $legacy ) {
                $value = $legacy;
            }
        }

        if ( ! $value ) {
            $value = sanitize_hex_color( $default );
        }

        $palette[ $key ] = $value ? $value : $default;
    }

    // Backwards compatibility aliases.
    $palette['accent'] = isset( $palette['primary'] ) ? $palette['primary'] : ( isset( $defaults[ $mode ]['accent'] ) ? $defaults[ $mode ]['accent'] : '' );
    $palette['text']   = isset( $palette['text_color'] ) ? $palette['text_color'] : ( isset( $defaults[ $mode ]['text_color'] ) ? $defaults[ $mode ]['text_color'] : '' );

    return $palette;
}

/**
 * Retrieve all registered color settings grouped by mode.
 *
 * @return array
 */
function beyond_gotham_get_all_color_settings() {
    $defaults = beyond_gotham_get_color_defaults();
    $settings = array();

    foreach ( $defaults as $mode => $values ) {
        $settings[ $mode ] = beyond_gotham_get_color_palette( $mode );
    }

    return $settings;
}

/**
 * Provide selector prefixes for color modes.
 *
 * @param string $mode Mode slug.
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
 * Build a comma-separated selector list for a given mode.
 *
 * @param string $mode      Mode slug.
 * @param array  $selectors Additional selectors.
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
