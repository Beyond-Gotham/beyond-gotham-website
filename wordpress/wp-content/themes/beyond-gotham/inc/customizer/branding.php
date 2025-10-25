<?php
/**
 * Branding Customizer Settings
 *
 * Handles custom logo variants, favicon fallbacks and brand specific sizing.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Defaults
// =============================================================================

/**
 * Retrieve default branding settings.
 *
 * @return array
 */
function beyond_gotham_get_branding_defaults() {
        return array(
                'primary_logo'        => 0,
                'invert_logo'         => 0,
                'favicon_id'          => 0,
                'favicon_url'         => '',
                'max_width'           => 192,
                'max_width_mobile'    => 148,
                'max_height'          => 72,
                'text_only'           => false,
        );
}

// =============================================================================
// Customizer Registration
// =============================================================================

/**
 * Register branding related controls with the customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 * @return void
 */
function beyond_gotham_register_branding_customizer( WP_Customize_Manager $wp_customize ) {
        $defaults = beyond_gotham_get_branding_defaults();

        $wp_customize->add_section(
                'beyond_gotham_branding',
                array(
                        'title'       => __( 'Branding & Logo', 'beyond_gotham' ),
                        'priority'    => 25,
                        'description' => __( 'Verwalte Logo-Varianten, Favicons und die Darstellung im Header.', 'beyond_gotham' ),
                )
        );

        // Heading: Logos.
        $wp_customize->add_control(
                new Beyond_Gotham_Customize_Heading_Control(
                        $wp_customize,
                        'beyond_gotham_branding_logo_heading',
                        array(
                                'label'       => __( 'Logo-Varianten', 'beyond_gotham' ),
                                'description' => __( 'Du kannst separate Logos für helle und dunkle Hintergründe hinterlegen.', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_branding',
                        )
                )
        );

        // Setting: Primary Logo.
        $wp_customize->add_setting(
                'beyond_gotham_brand_logo_primary',
                array(
                        'default'           => $defaults['primary_logo'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'absint',
                )
        );

        $wp_customize->add_control(
                new WP_Customize_Media_Control(
                        $wp_customize,
                        'beyond_gotham_brand_logo_primary_control',
                        array(
                                'label'    => __( 'Primäres Logo', 'beyond_gotham' ),
                                'section'  => 'beyond_gotham_branding',
                                'settings' => 'beyond_gotham_brand_logo_primary',
                                'mime_type'=> 'image',
                                'description' => __( 'Standardlogo für helle Hintergründe. Nutzt das WordPress Logo, falls leer.', 'beyond_gotham' ),
                        )
                )
        );

        // Setting: Inverted Logo.
        $wp_customize->add_setting(
                'beyond_gotham_brand_logo_invert',
                array(
                        'default'           => $defaults['invert_logo'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'absint',
                )
        );

        $wp_customize->add_control(
                new WP_Customize_Media_Control(
                        $wp_customize,
                        'beyond_gotham_brand_logo_invert_control',
                        array(
                                'label'       => __( 'Invertiertes Logo', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_branding',
                                'settings'    => 'beyond_gotham_brand_logo_invert',
                                'mime_type'   => 'image',
                                'description' => __( 'Optionales Logo für dunkle Hintergründe. Wird per CSS-Klasse automatisch umgeschaltet.', 'beyond_gotham' ),
                        )
                )
        );

        // Heading: Darstellung.
        $wp_customize->add_control(
                new Beyond_Gotham_Customize_Heading_Control(
                        $wp_customize,
                        'beyond_gotham_branding_display_heading',
                        array(
                                'label'       => __( 'Darstellung', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_branding',
                                'description' => __( 'Steuere Größe und Verhalten des Logos im Header.', 'beyond_gotham' ),
                        )
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_brand_logo_max_width',
                array(
                        'default'           => $defaults['max_width'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'absint',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_brand_logo_max_width_control',
                array(
                        'label'       => __( 'Maximale Breite (Desktop, px)', 'beyond_gotham' ),
                        'section'     => 'beyond_gotham_branding',
                        'settings'    => 'beyond_gotham_brand_logo_max_width',
                        'type'        => 'number',
                        'input_attrs' => array(
                                'min'  => 96,
                                'max'  => 320,
                                'step' => 4,
                        ),
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_brand_logo_max_width_mobile',
                array(
                        'default'           => $defaults['max_width_mobile'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'absint',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_brand_logo_max_width_mobile_control',
                array(
                        'label'       => __( 'Maximale Breite (Mobil, px)', 'beyond_gotham' ),
                        'section'     => 'beyond_gotham_branding',
                        'settings'    => 'beyond_gotham_brand_logo_max_width_mobile',
                        'type'        => 'number',
                        'input_attrs' => array(
                                'min'  => 72,
                                'max'  => 260,
                                'step' => 4,
                        ),
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_brand_logo_max_height',
                array(
                        'default'           => $defaults['max_height'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'absint',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_brand_logo_max_height_control',
                array(
                        'label'       => __( 'Maximale Höhe (px)', 'beyond_gotham' ),
                        'section'     => 'beyond_gotham_branding',
                        'settings'    => 'beyond_gotham_brand_logo_max_height',
                        'type'        => 'number',
                        'input_attrs' => array(
                                'min'  => 40,
                                'max'  => 140,
                                'step' => 2,
                        ),
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_brand_text_only',
                array(
                        'default'           => $defaults['text_only'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_brand_text_only_control',
                array(
                        'label'       => __( 'Nur Typografie-Logo verwenden', 'beyond_gotham' ),
                        'description' => __( 'Blendet Bild-Logos aus und nutzt stattdessen den Website-Titel.', 'beyond_gotham' ),
                        'section'     => 'beyond_gotham_branding',
                        'settings'    => 'beyond_gotham_brand_text_only',
                        'type'        => 'checkbox',
                )
        );

        // Heading: Favicon.
        $wp_customize->add_control(
                new Beyond_Gotham_Customize_Heading_Control(
                        $wp_customize,
                        'beyond_gotham_branding_favicon_heading',
                        array(
                                'label'       => __( 'Favicon & Site Icon', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_branding',
                                'description' => __( 'WordPress Site Icons werden priorisiert. Optional kannst du ein alternatives Favicon definieren.', 'beyond_gotham' ),
                        )
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_brand_favicon',
                array(
                        'default'           => $defaults['favicon_id'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'absint',
                )
        );

        $wp_customize->add_control(
                new WP_Customize_Media_Control(
                        $wp_customize,
                        'beyond_gotham_brand_favicon_control',
                        array(
                                'label'       => __( 'Alternatives Favicon', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_branding',
                                'settings'    => 'beyond_gotham_brand_favicon',
                                'mime_type'   => 'image',
                                'description' => __( 'Verwendet nur, wenn kein Site Icon gesetzt ist.', 'beyond_gotham' ),
                        )
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_brand_favicon_url',
                array(
                        'default'           => $defaults['favicon_url'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_optional_url',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_brand_favicon_url_control',
                array(
                        'label'       => __( 'Favicon-URL', 'beyond_gotham' ),
                        'description' => __( 'Optionaler direkter Link zu einem Favicon. Wird genutzt, falls kein Upload angegeben ist.', 'beyond_gotham' ),
                        'section'     => 'beyond_gotham_branding',
                        'settings'    => 'beyond_gotham_brand_favicon_url',
                        'type'        => 'url',
                )
        );

        $wp_customize->add_control(
                new Beyond_Gotham_Customize_Info_Control(
                        $wp_customize,
                        'beyond_gotham_branding_site_icon_notice',
                        array(
                                'label'       => __( 'Site Icon Hinweis', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_branding',
                                'notice_type' => 'info',
                                'description' => sprintf(
                                        /* translators: %s: Link to site identity section */
                                        __( 'Site Icons lassen sich unter %s pflegen. Lade dort bevorzugt dein Favicon hoch.', 'beyond_gotham' ),
                                        '<a href="javascript:wp.customize.section(\'title_tagline\').focus();">' . __( 'Website-Identität', 'beyond_gotham' ) . '</a>'
                                ),
                        )
                )
        );
}

// =============================================================================
// Helper functions
// =============================================================================

/**
 * Get all branding settings combined with defaults.
 *
 * @return array
 */
function beyond_gotham_get_branding_settings() {
        $defaults = beyond_gotham_get_branding_defaults();

        $settings = array(
                'primary_logo'      => (int) get_theme_mod( 'beyond_gotham_brand_logo_primary', $defaults['primary_logo'] ),
                'invert_logo'       => (int) get_theme_mod( 'beyond_gotham_brand_logo_invert', $defaults['invert_logo'] ),
                'favicon_id'        => (int) get_theme_mod( 'beyond_gotham_brand_favicon', $defaults['favicon_id'] ),
                'favicon_url'       => get_theme_mod( 'beyond_gotham_brand_favicon_url', $defaults['favicon_url'] ),
                'max_width'         => absint( get_theme_mod( 'beyond_gotham_brand_logo_max_width', $defaults['max_width'] ) ),
                'max_width_mobile'  => absint( get_theme_mod( 'beyond_gotham_brand_logo_max_width_mobile', $defaults['max_width_mobile'] ) ),
                'max_height'        => absint( get_theme_mod( 'beyond_gotham_brand_logo_max_height', $defaults['max_height'] ) ),
                'text_only'         => (bool) get_theme_mod( 'beyond_gotham_brand_text_only', $defaults['text_only'] ),
        );

        $settings['favicon_url'] = $settings['favicon_url'] ? esc_url_raw( $settings['favicon_url'] ) : '';

        return $settings;
}

/**
 * Determine whether the branding is configured to display text only.
 *
 * @return bool
 */
function beyond_gotham_is_branding_text_only() {
        $settings = beyond_gotham_get_branding_settings();
        return ! empty( $settings['text_only'] );
}

/**
 * Retrieve the attachment id for the requested logo variant.
 *
 * @param string $variant Variant slug (primary|invert).
 * @return int
 */
function beyond_gotham_get_brand_logo_id( $variant = 'primary' ) {
        $settings = beyond_gotham_get_branding_settings();

        if ( 'invert' === $variant && ! empty( $settings['invert_logo'] ) ) {
                return (int) $settings['invert_logo'];
        }

        if ( ! empty( $settings['primary_logo'] ) ) {
                return (int) $settings['primary_logo'];
        }

        return (int) get_theme_mod( 'custom_logo' );
}

/**
 * Return CSS ready dimension values for the logo.
 *
 * @return array
 */
function beyond_gotham_get_brand_logo_dimensions() {
        $settings = beyond_gotham_get_branding_settings();

        $dimensions = array(
                'max_width'        => $settings['max_width'],
                'max_width_mobile' => $settings['max_width_mobile'],
                'max_height'       => $settings['max_height'],
        );

        foreach ( $dimensions as $key => $value ) {
                if ( $value <= 0 ) {
                        $dimensions[ $key ] = null;
                }
        }

        return $dimensions;
}

/**
 * Attempt to render an alternative favicon when no site icon exists.
 *
 * @return void
 */
function beyond_gotham_render_brand_favicon() {
        if ( has_site_icon() ) {
                return;
        }

        $settings = beyond_gotham_get_branding_settings();

        $favicon_url = '';
        $favicon_id  = (int) $settings['favicon_id'];

        if ( $favicon_id ) {
                $icon = wp_get_attachment_image_src( $favicon_id, 'full' );

                if ( $icon ) {
                        $favicon_url = $icon[0];
                        $width       = (int) $icon[1];
                        $height      = (int) $icon[2];
                }
        }

        if ( ! $favicon_url && ! empty( $settings['favicon_url'] ) ) {
                $favicon_url = esc_url( $settings['favicon_url'] );
                $width       = 32;
                $height      = 32;
        }

        if ( empty( $favicon_url ) ) {
                return;
        }

        printf(
                '<link rel="icon" href="%1$s" sizes="%2$dx%3$d" />' . "\n",
                esc_url( $favicon_url ),
                isset( $width ) ? (int) $width : 32,
                isset( $height ) ? (int) $height : 32
        );
}

/**
 * Retrieve branding data for use in JavaScript previews.
 *
 * @return array
 */
function beyond_gotham_get_branding_preview_data() {
        $settings   = beyond_gotham_get_branding_settings();
        $dimensions = beyond_gotham_get_brand_logo_dimensions();

        return array(
                'textOnly'  => ! empty( $settings['text_only'] ),
                'maxWidth'  => $dimensions['max_width'],
                'maxWidthMobile' => $dimensions['max_width_mobile'],
                'maxHeight' => $dimensions['max_height'],
        );
}
