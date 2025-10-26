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
            'background'          => '#ffffff',
            'text_color'          => '#1a1a1a',
            'accent'              => '#2563eb',
            'link'                => '#2563eb',
            'link_hover'          => '#1e40af',
            'button_background'   => '#2563eb',
            'button_text'         => '#ffffff',
            'quote_background'    => '#e6edf7',
        ),
        'dark'  => array(
            'background'          => '#050608',
            'text_color'          => '#e5e7eb',
            'accent'              => '#3b82f6',
            'link'                => '#60a5fa',
            'link_hover'          => '#93c5fd',
            'button_background'   => '#3b82f6',
            'button_text'         => '#ffffff',
            'quote_background'    => '#161b2a',
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

    $palette = array(
        'background'        => get_theme_mod( 'beyond_gotham_background_' . $mode, $defaults[ $mode ]['background'] ),
        'text_color'        => get_theme_mod( 'beyond_gotham_text_color_' . $mode, $defaults[ $mode ]['text_color'] ),
        'accent'            => get_theme_mod( 'beyond_gotham_accent_' . $mode, $defaults[ $mode ]['accent'] ),
        'link'              => get_theme_mod( 'beyond_gotham_link_' . $mode, $defaults[ $mode ]['link'] ),
        'link_hover'        => get_theme_mod( 'beyond_gotham_link_hover_' . $mode, $defaults[ $mode ]['link_hover'] ),
        'button_background' => get_theme_mod( 'beyond_gotham_button_background_' . $mode, $defaults[ $mode ]['button_background'] ),
        'button_text'       => get_theme_mod( 'beyond_gotham_button_text_' . $mode, $defaults[ $mode ]['button_text'] ),
        'quote_background'  => get_theme_mod( 'beyond_gotham_quote_background_' . $mode, $defaults[ $mode ]['quote_background'] ),
    );

    $palette = array_map( 'sanitize_hex_color', $palette );

    foreach ( $palette as $key => $value ) {
        if ( ! $value && isset( $defaults[ $mode ][ $key ] ) ) {
            $palette[ $key ] = $defaults[ $mode ][ $key ];
        }
    }

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
