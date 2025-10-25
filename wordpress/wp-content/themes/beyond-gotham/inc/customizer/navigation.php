<?php
/**
 * Navigation Customizer Settings
 *
 * Provides menu position toggles, alignment and spacing controls.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Defaults
// =============================================================================

/**
 * Get default navigation settings.
 *
 * @return array
 */
function beyond_gotham_get_navigation_defaults() {
        return array(
                'primary_enabled'   => true,
                'secondary_enabled' => false,
                'footer_enabled'    => true,
                'alignment'         => 'space-between',
                'sticky'            => true,
                'item_spacing'      => 24,
                'padding_y'         => 16,
        );
}

// =============================================================================
// Customizer Registration
// =============================================================================

/**
 * Register navigation controls with the customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 * @return void
 */
function beyond_gotham_register_navigation_customizer( WP_Customize_Manager $wp_customize ) {
        $defaults = beyond_gotham_get_navigation_defaults();

        $wp_customize->add_section(
                'beyond_gotham_navigation',
                array(
                        'title'       => __( 'Navigation & Menüs', 'beyond_gotham' ),
                        'priority'    => 30,
                        'description' => __( 'Steuere welche Menüs sichtbar sind und wie sie ausgerichtet werden.', 'beyond_gotham' ),
                )
        );

        $wp_customize->add_control(
                new Beyond_Gotham_Customize_Heading_Control(
                        $wp_customize,
                        'beyond_gotham_navigation_locations_heading',
                        array(
                                'label'       => __( 'Menü-Positionen', 'beyond_gotham' ),
                                'description' => __( 'Aktiviere oder deaktiviere registrierte Menüpositionen.', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_navigation',
                        )
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_nav_show_primary',
                array(
                        'default'           => $defaults['primary_enabled'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_nav_show_primary_control',
                array(
                        'label'    => __( 'Hauptnavigation (Header)', 'beyond_gotham' ),
                        'section'  => 'beyond_gotham_navigation',
                        'settings' => 'beyond_gotham_nav_show_primary',
                        'type'     => 'checkbox',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_nav_show_secondary',
                array(
                        'default'           => $defaults['secondary_enabled'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_nav_show_secondary_control',
                array(
                        'label'       => __( 'Sekundäres Menü (Header-Sidebar/Social)', 'beyond_gotham' ),
                        'section'     => 'beyond_gotham_navigation',
                        'settings'    => 'beyond_gotham_nav_show_secondary',
                        'type'        => 'checkbox',
                        'description' => __( 'Nutze Menüposition „Secondary“, um ergänzende Links einzublenden.', 'beyond_gotham' ),
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_nav_show_footer',
                array(
                        'default'           => $defaults['footer_enabled'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_nav_show_footer_control',
                array(
                        'label'       => __( 'Footer-Navigation anzeigen', 'beyond_gotham' ),
                        'section'     => 'beyond_gotham_navigation',
                        'settings'    => 'beyond_gotham_nav_show_footer',
                        'type'        => 'checkbox',
                        'description' => __( 'Blendet das Footer-Menü komplett ein oder aus.', 'beyond_gotham' ),
                )
        );

        $wp_customize->add_control(
                new Beyond_Gotham_Customize_Heading_Control(
                        $wp_customize,
                        'beyond_gotham_navigation_alignment_heading',
                        array(
                                'label'       => __( 'Ausrichtung & Layout', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_navigation',
                                'description' => __( 'Passe die horizontale Ausrichtung und Abstände der Navigation an. Änderungen werden live angezeigt.', 'beyond_gotham' ),
                        )
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_nav_alignment',
                array(
                        'default'           => $defaults['alignment'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_choice',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_nav_alignment_control',
                array(
                        'label'    => __( 'Ausrichtung der Navigation', 'beyond_gotham' ),
                        'section'  => 'beyond_gotham_navigation',
                        'settings' => 'beyond_gotham_nav_alignment',
                        'type'     => 'radio',
                        'choices'  => array(
                                'left'           => __( 'Links', 'beyond_gotham' ),
                                'center'         => __( 'Zentriert', 'beyond_gotham' ),
                                'right'          => __( 'Rechts', 'beyond_gotham' ),
                                'space-between'  => __( 'Verteilt', 'beyond_gotham' ),
                        ),
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_nav_item_spacing',
                array(
                        'default'           => $defaults['item_spacing'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'absint',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_nav_item_spacing_control',
                array(
                        'label'       => __( 'Abstand zwischen Menüpunkten (px)', 'beyond_gotham' ),
                        'section'     => 'beyond_gotham_navigation',
                        'settings'    => 'beyond_gotham_nav_item_spacing',
                        'type'        => 'number',
                        'input_attrs' => array(
                                'min'  => 8,
                                'max'  => 64,
                                'step' => 2,
                        ),
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_nav_padding_y',
                array(
                        'default'           => $defaults['padding_y'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'absint',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_nav_padding_y_control',
                array(
                        'label'       => __( 'Vertikale Innenabstände (px)', 'beyond_gotham' ),
                        'section'     => 'beyond_gotham_navigation',
                        'settings'    => 'beyond_gotham_nav_padding_y',
                        'type'        => 'number',
                        'input_attrs' => array(
                                'min'  => 0,
                                'max'  => 48,
                                'step' => 1,
                        ),
                )
        );

        $wp_customize->add_control(
                new Beyond_Gotham_Customize_Heading_Control(
                        $wp_customize,
                        'beyond_gotham_navigation_behavior_heading',
                        array(
                                'label'   => __( 'Verhalten', 'beyond_gotham' ),
                                'section' => 'beyond_gotham_navigation',
                        )
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_nav_sticky',
                array(
                        'default'           => $defaults['sticky'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_nav_sticky_control',
                array(
                        'label'       => __( 'Sticky Header aktivieren', 'beyond_gotham' ),
                        'description' => __( 'Der Header bleibt beim Scrollen sichtbar.', 'beyond_gotham' ),
                        'section'     => 'beyond_gotham_navigation',
                        'settings'    => 'beyond_gotham_nav_sticky',
                        'type'        => 'checkbox',
                )
        );

        $wp_customize->add_control(
                new Beyond_Gotham_Customize_Info_Control(
                        $wp_customize,
                        'beyond_gotham_navigation_manage_info',
                        array(
                                'label'       => __( 'Menüs verwalten', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_navigation',
                                'notice_type' => 'info',
                                'description' => sprintf(
                                        /* translators: %s: Link to nav menus panel */
                                        __( 'Du kannst Inhalte der Menüs direkt im Bereich %s anpassen.', 'beyond_gotham' ),
                                        '<a href="javascript:wp.customize.panel(\'nav_menus\').focus();">' . __( 'Menüs', 'beyond_gotham' ) . '</a>'
                                ),
                        )
                )
        );
}

// =============================================================================
// Helper functions
// =============================================================================

/**
 * Retrieve navigation settings merged with defaults.
 *
 * @return array
 */
function beyond_gotham_get_navigation_settings() {
        $defaults = beyond_gotham_get_navigation_defaults();

        $settings = array(
                'primary_enabled'   => (bool) get_theme_mod( 'beyond_gotham_nav_show_primary', $defaults['primary_enabled'] ),
                'secondary_enabled' => (bool) get_theme_mod( 'beyond_gotham_nav_show_secondary', $defaults['secondary_enabled'] ),
                'footer_enabled'    => (bool) get_theme_mod( 'beyond_gotham_nav_show_footer', $defaults['footer_enabled'] ),
                'alignment'         => get_theme_mod( 'beyond_gotham_nav_alignment', $defaults['alignment'] ),
                'sticky'            => (bool) get_theme_mod( 'beyond_gotham_nav_sticky', $defaults['sticky'] ),
                'item_spacing'      => absint( get_theme_mod( 'beyond_gotham_nav_item_spacing', $defaults['item_spacing'] ) ),
                'padding_y'         => absint( get_theme_mod( 'beyond_gotham_nav_padding_y', $defaults['padding_y'] ) ),
        );

        $alignments = array( 'left', 'center', 'right', 'space-between' );
        if ( ! in_array( $settings['alignment'], $alignments, true ) ) {
                $settings['alignment'] = $defaults['alignment'];
        }

        return $settings;
}

/**
 * Check if a specific navigation location is enabled.
 *
 * @param string $location Location slug (primary|secondary|footer).
 * @return bool
 */
function beyond_gotham_nav_location_enabled( $location ) {
        $settings = beyond_gotham_get_navigation_settings();

        switch ( $location ) {
                case 'primary':
                        return ! empty( $settings['primary_enabled'] );
                case 'secondary':
                        return ! empty( $settings['secondary_enabled'] );
                case 'footer':
                        return ! empty( $settings['footer_enabled'] );
        }

        return true;
}

/**
 * Get the alignment class for body or wrapper elements.
 *
 * @return string
 */
function beyond_gotham_get_nav_alignment_class() {
        $settings = beyond_gotham_get_navigation_settings();
        return 'nav-align-' . sanitize_html_class( $settings['alignment'] );
}

/**
 * Retrieve navigation spacing values for CSS.
 *
 * @return array
 */
function beyond_gotham_get_nav_spacing_css_values() {
        $settings = beyond_gotham_get_navigation_settings();

        return array(
                'item_gap'  => max( 0, (int) $settings['item_spacing'] ),
                'padding_y' => max( 0, (int) $settings['padding_y'] ),
        );
}

/**
 * Helper for preview script localization.
 *
 * @return array
 */
function beyond_gotham_get_nav_preview_data() {
        $settings = beyond_gotham_get_navigation_settings();
        $spacing  = beyond_gotham_get_nav_spacing_css_values();

        return array(
                'alignment'   => $settings['alignment'],
                'sticky'      => ! empty( $settings['sticky'] ),
                'itemSpacing' => $spacing['item_gap'],
                'paddingY'    => $spacing['padding_y'],
        );
}

/**
 * Determine whether the sticky header is enabled.
 *
 * @return bool
 */
function beyond_gotham_is_sticky_header_enabled() {
        $settings = beyond_gotham_get_navigation_settings();
        return ! empty( $settings['sticky'] );
}
