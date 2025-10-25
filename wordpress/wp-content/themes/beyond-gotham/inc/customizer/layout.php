<?php
/**
 * Layout Customizer Settings
 *
 * Configures container widths, spacing scale and responsive breakpoints.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Defaults
// =============================================================================

/**
 * Get default layout configuration.
 *
 * @return array
 */
function beyond_gotham_get_layout_defaults() {
        return array(
                'containers'        => array(
                        'xs' => 520,
                        'sm' => 640,
                        'md' => 840,
                        'lg' => 1080,
                        'xl' => 1280,
                ),
                'spacing_scale'     => array(
                        'xs' => 8,
                        'sm' => 12,
                        'md' => 20,
                        'lg' => 32,
                        'xl' => 48,
                ),
                'grid_gap'          => 24,
                'active_breakpoints'=> array( 'sm', 'md', 'lg', 'xl' ),
        );
}

/**
 * Helper returning ordered breakpoint keys.
 *
 * @return array
 */
function beyond_gotham_get_layout_breakpoints() {
        return array( 'xs', 'sm', 'md', 'lg', 'xl' );
}

// =============================================================================
// Customizer Registration
// =============================================================================

/**
 * Register layout settings with the customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 * @return void
 */
function beyond_gotham_register_layout_customizer( WP_Customize_Manager $wp_customize ) {
        $defaults    = beyond_gotham_get_layout_defaults();
        $breakpoints = beyond_gotham_get_layout_breakpoints();

        $wp_customize->add_section(
                'beyond_gotham_layout',
                array(
                        'title'       => __( 'Layout & Grid', 'beyond_gotham' ),
                        'priority'    => 40,
                        'description' => __( 'Passe Containerbreiten, Abstände und Breakpoints an. Änderungen wirken sich unmittelbar auf das Frontend aus.', 'beyond_gotham' ),
                )
        );

        $wp_customize->add_control(
                new Beyond_Gotham_Customize_Heading_Control(
                        $wp_customize,
                        'beyond_gotham_layout_container_heading',
                        array(
                                'label'       => __( 'Container-Breiten', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_layout',
                                'description' => __( 'Definiere maximale Breiten für unterschiedliche Viewports. Diese Werte steuern `max-width` und CSS-Variablen.', 'beyond_gotham' ),
                        )
                )
        );

        foreach ( $breakpoints as $key ) {
                $setting_id = "beyond_gotham_container_width_{$key}";
                $label      = sprintf( __( 'Maximale Breite %s (px)', 'beyond_gotham' ), strtoupper( $key ) );
                $default    = isset( $defaults['containers'][ $key ] ) ? $defaults['containers'][ $key ] : 0;

                $wp_customize->add_setting(
                        $setting_id,
                        array(
                                'default'           => $default,
                                'type'              => 'theme_mod',
                                'sanitize_callback' => 'absint',
                                'transport'         => 'postMessage',
                        )
                );

                $wp_customize->add_control(
                        $setting_id . '_control',
                        array(
                                'label'       => $label,
                                'section'     => 'beyond_gotham_layout',
                                'settings'    => $setting_id,
                                'type'        => 'number',
                                'input_attrs' => array(
                                        'min'  => 360,
                                        'max'  => 1920,
                                        'step' => 10,
                                ),
                        )
                );
        }

        $wp_customize->add_control(
                new Beyond_Gotham_Customize_Heading_Control(
                        $wp_customize,
                        'beyond_gotham_layout_spacing_heading',
                        array(
                                'label'       => __( 'Spacing & Grid', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_layout',
                                'description' => __( 'Definiere eine globale Abstands-Skala und den Grid-Gap. Werte werden als CSS-Variablen ausgegeben.', 'beyond_gotham' ),
                        )
                )
        );

        foreach ( $breakpoints as $key ) {
                $setting_id = "beyond_gotham_spacing_{$key}";
                $label      = sprintf( __( 'Spacing %s (px)', 'beyond_gotham' ), strtoupper( $key ) );
                $default    = isset( $defaults['spacing_scale'][ $key ] ) ? $defaults['spacing_scale'][ $key ] : 0;

                $wp_customize->add_setting(
                        $setting_id,
                        array(
                                'default'           => $default,
                                'type'              => 'theme_mod',
                                'sanitize_callback' => 'absint',
                                'transport'         => 'postMessage',
                        )
                );

                $wp_customize->add_control(
                        $setting_id . '_control',
                        array(
                                'label'       => $label,
                                'section'     => 'beyond_gotham_layout',
                                'settings'    => $setting_id,
                                'type'        => 'number',
                                'input_attrs' => array(
                                        'min'  => 0,
                                        'max'  => 120,
                                        'step' => 2,
                                ),
                        )
                );
        }

        $wp_customize->add_setting(
                'beyond_gotham_grid_gap',
                array(
                        'default'           => $defaults['grid_gap'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'absint',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_grid_gap_control',
                array(
                        'label'       => __( 'Grid Gap (px)', 'beyond_gotham' ),
                        'section'     => 'beyond_gotham_layout',
                        'settings'    => 'beyond_gotham_grid_gap',
                        'type'        => 'number',
                        'input_attrs' => array(
                                'min'  => 0,
                                'max'  => 96,
                                'step' => 2,
                        ),
                )
        );

        $wp_customize->add_control(
                new Beyond_Gotham_Customize_Heading_Control(
                        $wp_customize,
                        'beyond_gotham_layout_breakpoints_heading',
                        array(
                                'label'       => __( 'Aktive Breakpoints', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_layout',
                                'description' => __( 'Deaktiviere Breakpoints, wenn z. B. ein mobiles Einspaltenlayout gewünscht ist.', 'beyond_gotham' ),
                        )
                )
        );

        foreach ( array_diff( $breakpoints, array( 'xs' ) ) as $key ) {
                $setting_id = "beyond_gotham_breakpoint_{$key}";
                $default    = in_array( $key, $defaults['active_breakpoints'], true );

                $wp_customize->add_setting(
                        $setting_id,
                        array(
                                'default'           => $default,
                                'type'              => 'theme_mod',
                                'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                                'transport'         => 'postMessage',
                        )
                );

                $wp_customize->add_control(
                        $setting_id . '_control',
                        array(
                                'label'    => sprintf( __( 'Breakpoint %s aktivieren', 'beyond_gotham' ), strtoupper( $key ) ),
                                'section'  => 'beyond_gotham_layout',
                                'settings' => $setting_id,
                                'type'     => 'checkbox',
                        )
                );
        }
}

// =============================================================================
// Helper functions
// =============================================================================

/**
 * Gather layout settings and normalize values.
 *
 * @return array
 */
function beyond_gotham_get_layout_settings() {
        $defaults    = beyond_gotham_get_layout_defaults();
        $breakpoints = beyond_gotham_get_layout_breakpoints();

        $containers = array();
        foreach ( $breakpoints as $key ) {
                $default            = isset( $defaults['containers'][ $key ] ) ? $defaults['containers'][ $key ] : 0;
                $containers[ $key ] = absint( get_theme_mod( "beyond_gotham_container_width_{$key}", $default ) );
        }

        $spacings = array();
        foreach ( $breakpoints as $key ) {
                $default          = isset( $defaults['spacing_scale'][ $key ] ) ? $defaults['spacing_scale'][ $key ] : 0;
                $spacings[ $key ] = absint( get_theme_mod( "beyond_gotham_spacing_{$key}", $default ) );
        }

        $active = array( 'xs' );
        foreach ( array_diff( $breakpoints, array( 'xs' ) ) as $key ) {
                $enabled = (bool) get_theme_mod( "beyond_gotham_breakpoint_{$key}", in_array( $key, $defaults['active_breakpoints'], true ) );

                if ( $enabled ) {
                        $active[] = $key;
                }
        }

        return array(
                'containers'         => $containers,
                'spacing_scale'      => $spacings,
                'grid_gap'           => absint( get_theme_mod( 'beyond_gotham_grid_gap', $defaults['grid_gap'] ) ),
                'active_breakpoints' => $active,
        );
}

/**
 * Legacy compatibility wrapper.
 *
 * @return array
 */
function beyond_gotham_get_ui_layout_settings() {
        $settings = beyond_gotham_get_layout_settings();

        return array(
                'containers'         => $settings['containers'],
                'spacing_scale'      => $settings['spacing_scale'],
                'grid_gap'           => $settings['grid_gap'],
                'active_breakpoints' => $settings['active_breakpoints'],
        );
}

/**
 * Provide layout data for preview scripts.
 *
 * @return array
 */
function beyond_gotham_get_layout_preview_data() {
        $settings = beyond_gotham_get_layout_settings();

        return array(
                'containers'         => $settings['containers'],
                'spacing'            => $settings['spacing_scale'],
                'gridGap'            => $settings['grid_gap'],
                'activeBreakpoints'  => $settings['active_breakpoints'],
        );
}
