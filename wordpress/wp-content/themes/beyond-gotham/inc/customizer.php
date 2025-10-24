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
        'system' => array(
            'label' => __( 'Systemschrift', 'beyond_gotham' ),
            'stack' => 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif',
        ),
        'mono'   => array(
            'label' => __( 'JetBrains Mono', 'beyond_gotham' ),
            'stack' => '"JetBrains Mono", "Fira Code", "SFMono-Regular", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
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
            'title'       => __( 'Farben', 'beyond_gotham' ),
            'priority'    => 31,
            'description' => __( 'Definiere Primär- und Sekundärfarben des Auftritts.', 'beyond_gotham' ),
        )
    );

    $wp_customize->add_section(
        'beyond_gotham_typography',
        array(
            'title'       => __( 'Typografie', 'beyond_gotham' ),
            'priority'    => 32,
            'description' => __( 'Passe die grundlegende Typografie an.', 'beyond_gotham' ),
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
        'beyond_gotham_body_font_size',
        array(
            'default'           => 16,
            'type'              => 'theme_mod',
            'sanitize_callback' => 'absint',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'beyond_gotham_body_font_size_control',
        array(
            'label'       => __( 'Grundschriftgröße (px)', 'beyond_gotham' ),
            'section'     => 'beyond_gotham_typography',
            'settings'    => 'beyond_gotham_body_font_size',
            'type'        => 'number',
            'input_attrs' => array(
                'min'  => 14,
                'max'  => 22,
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
    );

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

        echo '<li class="site-nav__social-item">';
        echo '<a class="bg-social-link" href="' . esc_url( $url ) . '" target="_blank" rel="noopener" data-network="' . esc_attr( $network_slug ) . '">';
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
    $primary   = sanitize_hex_color( get_theme_mod( 'beyond_gotham_primary_color', '#33d1ff' ) );
    $secondary = sanitize_hex_color( get_theme_mod( 'beyond_gotham_secondary_color', '#1aa5d1' ) );
    $font_key  = beyond_gotham_sanitize_typography_choice( get_theme_mod( 'beyond_gotham_body_font_family', 'inter' ) );
    $font_size = (int) get_theme_mod( 'beyond_gotham_body_font_size', 16 );
    $presets   = beyond_gotham_get_typography_presets();

    $font_size = max( 12, min( 26, $font_size ) );

    $css = ':root {';

    if ( $primary ) {
        $css .= '--accent: ' . $primary . ';';
    }

    if ( $secondary ) {
        $css .= '--accent-alt: ' . $secondary . ';';
    }

    $css .= '}' . PHP_EOL;

    if ( isset( $presets[ $font_key ] ) ) {
        $css .= 'body {font-family: ' . $presets[ $font_key ]['stack'] . '; font-size: ' . $font_size . 'px;}';
    } else {
        $css .= 'body {font-size: ' . $font_size . 'px;}';
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
            'fontStacks'   => $stacks,
            'footerTarget' => '.site-info',
        )
    );
}
add_action( 'customize_preview_init', 'beyond_gotham_customize_preview_js' );
