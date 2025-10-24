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

    $wp_customize->add_section(
        'beyond_gotham_colors',
        array(
            'title'       => __( 'Farben & Design', 'beyond_gotham' ),
            'priority'    => 31,
            'description' => __( 'Steuere Primär-, Hintergrund- und Textfarben sowie CTA-Akzente.', 'beyond_gotham' ),
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
    $wp_customize->add_setting(
        'beyond_gotham_primary_color',
        array(
            'default'           => '#33d1ff',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'beyond_gotham_primary_color_control',
            array(
                'label'       => __( 'Primärfarbe', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_colors',
                'settings'    => 'beyond_gotham_primary_color',
                'description' => __( 'Bestimmt u. a. Akzente, Buttons und Links.', 'beyond_gotham' ),
            )
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_secondary_color',
        array(
            'default'           => '#1aa5d1',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'beyond_gotham_secondary_color_control',
            array(
                'label'       => __( 'Sekundärfarbe', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_colors',
                'settings'    => 'beyond_gotham_secondary_color',
                'description' => __( 'Verwendung für Hover-Zustände und Highlights.', 'beyond_gotham' ),
            )
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_background_color',
        array(
            'default'           => '#0f1115',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'beyond_gotham_background_color_control',
            array(
                'label'       => __( 'Hintergrundfarbe', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_colors',
                'settings'    => 'beyond_gotham_background_color',
                'description' => __( 'Legt den Seitenhintergrund und dunkle Flächen fest.', 'beyond_gotham' ),
            )
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_text_color',
        array(
            'default'           => '#e7eaee',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'beyond_gotham_text_color_control',
            array(
                'label'       => __( 'Textfarbe', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_colors',
                'settings'    => 'beyond_gotham_text_color',
                'description' => __( 'Bestimmt die Primärfarbe für Fließtext.', 'beyond_gotham' ),
            )
        )
    );

    $wp_customize->add_setting(
        'beyond_gotham_cta_accent_color',
        array(
            'default'           => '#33d1ff',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'beyond_gotham_cta_accent_color_control',
            array(
                'label'       => __( 'CTA-Akzentfarbe', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_colors',
                'settings'    => 'beyond_gotham_cta_accent_color',
                'description' => __( 'Wird für Highlight-Boxen und Newsletter-CTAs verwendet.', 'beyond_gotham' ),
            )
        )
    );

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
function beyond_gotham_get_customizer_css() {
    $primary        = sanitize_hex_color( get_theme_mod( 'beyond_gotham_primary_color', '#33d1ff' ) );
    $secondary      = sanitize_hex_color( get_theme_mod( 'beyond_gotham_secondary_color', '#1aa5d1' ) );
    $background     = sanitize_hex_color( get_theme_mod( 'beyond_gotham_background_color', '#0f1115' ) );
    $text_color     = sanitize_hex_color( get_theme_mod( 'beyond_gotham_text_color', '#e7eaee' ) );
    $cta_accent     = sanitize_hex_color( get_theme_mod( 'beyond_gotham_cta_accent_color', '#33d1ff' ) );
    $body_font_key  = beyond_gotham_sanitize_typography_choice( get_theme_mod( 'beyond_gotham_body_font_family', 'inter' ) );
    $heading_key    = beyond_gotham_sanitize_typography_choice( get_theme_mod( 'beyond_gotham_heading_font_family', 'merriweather' ) );
    $font_size      = (float) get_theme_mod( 'beyond_gotham_body_font_size', 16 );
    $font_unit      = beyond_gotham_sanitize_font_unit( get_theme_mod( 'beyond_gotham_body_font_size_unit', 'px' ) );
    $line_height    = (float) get_theme_mod( 'beyond_gotham_body_line_height', 1.6 );
    $presets        = beyond_gotham_get_typography_presets();

    if ( 'rem' === $font_unit ) {
        $font_size = max( 0.5, min( 3, $font_size ) );
        $font_size_value = rtrim( rtrim( sprintf( '%.2f', $font_size ), '0' ), '.' );
    } else {
        $font_size = max( 12, min( 26, $font_size ) );
        $font_size_value = (string) round( $font_size );
    }

    if ( $line_height <= 0 ) {
        $line_height = 1.6;
    }

    $line_height = max( 1.1, min( 2.6, $line_height ) );
    $line_height_value = rtrim( rtrim( sprintf( '%.2f', $line_height ), '0' ), '.' );

    $css = ':root {';

    if ( $primary ) {
        $css .= '--accent: ' . $primary . ';';
    }

    if ( $secondary ) {
        $css .= '--accent-alt: ' . $secondary . ';';
    }

    if ( $background ) {
        $css .= '--bg: ' . $background . ';';
    }

    if ( $text_color ) {
        $css .= '--fg: ' . $text_color . ';';
    }

    if ( $cta_accent ) {
        $css .= '--cta-accent: ' . $cta_accent . ';';
    }

    $css .= '}' . PHP_EOL;

    $body_rules = array();

    if ( isset( $presets[ $body_font_key ] ) ) {
        $body_rules[] = 'font-family: ' . $presets[ $body_font_key ]['stack'] . ';';
    }

    $body_rules[] = 'font-size: ' . $font_size_value . $font_unit . ';';
    $body_rules[] = 'line-height: ' . $line_height_value . ';';

    if ( $background ) {
        $body_rules[] = 'background-color: ' . $background . ';';
    }

    if ( $text_color ) {
        $body_rules[] = 'color: ' . $text_color . ';';
    }

    if ( ! empty( $body_rules ) ) {
        $css .= 'body {' . implode( ' ', $body_rules ) . '}';
    }

    if ( isset( $presets[ $heading_key ] ) ) {
        $css .= 'h1, h2, h3, h4, h5, h6 {font-family: ' . $presets[ $heading_key ]['stack'] . ';}';
    }

    if ( $cta_accent ) {
        $cta_light = beyond_gotham_hex_to_rgba( $cta_accent, 0.15 );
        $cta_soft  = beyond_gotham_hex_to_rgba( $cta_accent, 0.1 );
        $cta_line  = beyond_gotham_hex_to_rgba( $cta_accent, 0.3 );

        if ( $cta_light && $cta_soft ) {
            $css .= '[data-bg-cta] {background: linear-gradient(135deg, ' . $cta_light . ', ' . $cta_soft . ');';

            if ( $cta_line ) {
                $css .= 'border-color: ' . $cta_line . ';';
            }

            $css .= '}';
        }

        $css .= '[data-bg-cta] .bg-button--primary {background-color: ' . $cta_accent . '; border-color: ' . $cta_accent . ';}';
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
        )
    );
}
add_action( 'customize_preview_init', 'beyond_gotham_customize_preview_js' );
