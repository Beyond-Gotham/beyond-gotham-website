<?php
/**
 * Shared typography helpers for the customizer.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Retrieve the typography presets that are available in the customizer.
 *
 * @return array
 */
function beyond_gotham_get_typography_presets() {
    $presets = array(
        'inter'        => array(
            'label' => __( 'Inter (Standard)', 'beyond_gotham' ),
            'stack' => '"Inter", "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, "Helvetica Neue", Arial, sans-serif',
        ),
        'merriweather' => array(
            'label' => __( 'Merriweather', 'beyond_gotham' ),
            'stack' => '"Merriweather", "Georgia", "Times New Roman", serif',
        ),
        'system'       => array(
            'label' => __( 'Systemschrift', 'beyond_gotham' ),
            'stack' => 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif',
        ),
        'mono'         => array(
            'label' => __( 'JetBrains Mono', 'beyond_gotham' ),
            'stack' => '"JetBrains Mono", "Fira Code", "SFMono-Regular", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
        ),
        'georgia'      => array(
            'label' => __( 'Georgia', 'beyond_gotham' ),
            'stack' => 'Georgia, "Times New Roman", Times, serif',
        ),
        'helvetica'    => array(
            'label' => __( 'Helvetica', 'beyond_gotham' ),
            'stack' => '"Helvetica Neue", Helvetica, Arial, sans-serif',
        ),
        'arial'        => array(
            'label' => __( 'Arial', 'beyond_gotham' ),
            'stack' => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
        ),
        'verdana'      => array(
            'label' => __( 'Verdana', 'beyond_gotham' ),
            'stack' => 'Verdana, Geneva, sans-serif',
        ),
        'tahoma'       => array(
            'label' => __( 'Tahoma', 'beyond_gotham' ),
            'stack' => 'Tahoma, Geneva, sans-serif',
        ),
        'trebuchet'    => array(
            'label' => __( 'Trebuchet MS', 'beyond_gotham' ),
            'stack' => '"Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif',
        ),
        'courier'      => array(
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
 * Get the font stack for a given preset key.
 *
 * @param string $preset_key Preset key from typography settings.
 * @return string
 */
function beyond_gotham_get_font_stack( $preset_key ) {
    $presets = beyond_gotham_get_typography_presets();

    if ( isset( $presets[ $preset_key ]['stack'] ) ) {
        return $presets[ $preset_key ]['stack'];
    }

    return isset( $presets['inter']['stack'] ) ? $presets['inter']['stack'] : '"Inter", sans-serif';
}

/**
 * Get all typography settings as an array.
 *
 * @return array
 */
function beyond_gotham_get_typography_settings() {
    return array(
        'body_font'         => get_theme_mod( 'beyond_gotham_body_font_family', 'inter' ),
        'heading_font'      => get_theme_mod( 'beyond_gotham_heading_font_family', 'merriweather' ),
        'font_size'         => (float) get_theme_mod( 'beyond_gotham_body_font_size', 16 ),
        'font_unit'         => get_theme_mod( 'beyond_gotham_body_font_size_unit', 'px' ),
        'line_height'       => (float) get_theme_mod( 'beyond_gotham_body_line_height', 1.6 ),
        'letter_spacing'    => (float) get_theme_mod( 'beyond_gotham_letter_spacing', 0 ),
        'paragraph_spacing' => (float) get_theme_mod( 'beyond_gotham_paragraph_spacing', 1.5 ),
    );
}
