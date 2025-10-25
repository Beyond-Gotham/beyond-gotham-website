<?php
/**
 * Performance Customizer Settings
 *
 * Lazy loading, caching toggles and script strategies.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Defaults & detection
// =============================================================================

/**
 * Default performance settings.
 *
 * @return array
 */
function beyond_gotham_get_performance_defaults() {
        return array(
                'lazy_images'      => true,
                'lazy_iframes'     => true,
                'lqip'             => false,
                'script_strategy'  => 'default',
                'heartbeat'        => 'normal',
                'disable_emoji'    => true,
        );
}

/**
 * Detect conflicting optimization plugins.
 *
 * @return array
 */
function beyond_gotham_performance_detect_conflicts() {
        $conflicts = array();

        if ( defined( 'WP_ROCKET_VERSION' ) ) {
                $conflicts[] = 'WP Rocket';
        }

        if ( defined( 'W3TC' ) || class_exists( '\\W3TC\\Dispatcher' ) ) {
                $conflicts[] = 'W3 Total Cache';
        }

        if ( class_exists( 'autoptimizeCache' ) ) {
                $conflicts[] = 'Autoptimize';
        }

        if ( defined( 'LSCACHE_ADV_CACHE' ) ) {
                $conflicts[] = 'LiteSpeed Cache';
        }

        if ( class_exists( 'SG_CachePress_Supercacher' ) ) {
                $conflicts[] = 'SiteGround Optimizer';
        }

        return $conflicts;
}

/**
 * Whether performance features should stay disabled due to conflicts.
 *
 * @return bool
 */
function beyond_gotham_performance_has_conflicts() {
        return ! empty( beyond_gotham_performance_detect_conflicts() );
}

/**
 * Helper for use in customizer controls.
 *
 * @return bool
 */
function beyond_gotham_performance_controls_available() {
        return ! beyond_gotham_performance_has_conflicts();
}

// =============================================================================
// Customizer Registration
// =============================================================================

/**
 * Register performance settings within the customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 * @return void
 */
function beyond_gotham_register_performance_customizer( WP_Customize_Manager $wp_customize ) {
        $defaults  = beyond_gotham_get_performance_defaults();
        $conflicts = beyond_gotham_performance_detect_conflicts();

        $wp_customize->add_section(
                'beyond_gotham_performance',
                array(
                        'title'       => __( 'Performance & Optimierung', 'beyond_gotham' ),
                        'priority'    => 70,
                        'description' => __( 'Steuere Lazy Loading und Skript-Strategien. Bei aktiven Performance-Plugins werden konfliktträchtige Optionen deaktiviert.', 'beyond_gotham' ),
                )
        );

        if ( ! empty( $conflicts ) ) {
                $wp_customize->add_control(
                        new Beyond_Gotham_Customize_Info_Control(
                                $wp_customize,
                                'beyond_gotham_performance_conflict_notice',
                                array(
                                        'label'       => __( 'Externe Optimierung erkannt', 'beyond_gotham' ),
                                        'section'     => 'beyond_gotham_performance',
                                        'notice_type' => 'warning',
                                        'description' => sprintf(
                                                /* translators: %s plugin list */
                                                __( 'Die folgenden Plugins verwalten bereits Performance-Optimierungen: %s. Theme-interne Optionen werden automatisch konservativ gehalten.', 'beyond_gotham' ),
                                                esc_html( implode( ', ', $conflicts ) )
                                        ),
                                )
                        )
                );
        }

        $wp_customize->add_setting(
                'beyond_gotham_performance_lazy_images',
                array(
                        'default'           => $defaults['lazy_images'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_performance_lazy_images_control',
                array(
                        'label'           => __( 'Lazy Loading für Bilder', 'beyond_gotham' ),
                        'section'         => 'beyond_gotham_performance',
                        'settings'        => 'beyond_gotham_performance_lazy_images',
                        'type'            => 'checkbox',
                        'active_callback' => 'beyond_gotham_performance_controls_available',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_performance_lazy_iframes',
                array(
                        'default'           => $defaults['lazy_iframes'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_performance_lazy_iframes_control',
                array(
                        'label'           => __( 'Lazy Loading für iFrames', 'beyond_gotham' ),
                        'section'         => 'beyond_gotham_performance',
                        'settings'        => 'beyond_gotham_performance_lazy_iframes',
                        'type'            => 'checkbox',
                        'active_callback' => 'beyond_gotham_performance_controls_available',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_performance_lqip',
                array(
                        'default'           => $defaults['lqip'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_performance_lqip_control',
                array(
                        'label'           => __( 'Blur-Platzhalter für Bilder', 'beyond_gotham' ),
                        'description'     => __( 'Fügt Bildern CSS-basierte Blur-Platzhalter hinzu, bis der Inhalt geladen ist.', 'beyond_gotham' ),
                        'section'         => 'beyond_gotham_performance',
                        'settings'        => 'beyond_gotham_performance_lqip',
                        'type'            => 'checkbox',
                        'active_callback' => 'beyond_gotham_performance_controls_available',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_performance_script_strategy',
                array(
                        'default'           => $defaults['script_strategy'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_choice',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_performance_script_strategy_control',
                array(
                        'label'           => __( 'Script-Ladestrategie', 'beyond_gotham' ),
                        'section'         => 'beyond_gotham_performance',
                        'settings'        => 'beyond_gotham_performance_script_strategy',
                        'type'            => 'select',
                        'choices'         => array(
                                'default' => __( 'WordPress-Standard', 'beyond_gotham' ),
                                'defer'   => __( 'Defer (nach HTML)', 'beyond_gotham' ),
                                'async'   => __( 'Async (parallel, schnell)', 'beyond_gotham' ),
                        ),
                        'active_callback' => 'beyond_gotham_performance_controls_available',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_performance_heartbeat',
                array(
                        'default'           => $defaults['heartbeat'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_choice',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_performance_heartbeat_control',
                array(
                        'label'           => __( 'Heartbeat-Frequenz', 'beyond_gotham' ),
                        'description'     => __( 'Reduziert AJAX-Heartbeat-Anfragen. „Deaktivieren“ stoppt den Frontend-Heartbeat komplett.', 'beyond_gotham' ),
                        'section'         => 'beyond_gotham_performance',
                        'settings'        => 'beyond_gotham_performance_heartbeat',
                        'type'            => 'select',
                        'choices'         => array(
                                'normal'  => __( 'Standard (WordPress)', 'beyond_gotham' ),
                                'reduce'  => __( 'Reduziert (60 Sekunden)', 'beyond_gotham' ),
                                'minimal' => __( 'Minimal (120 Sekunden)', 'beyond_gotham' ),
                                'disable' => __( 'Deaktivieren (Frontend)', 'beyond_gotham' ),
                        ),
                        'active_callback' => 'beyond_gotham_performance_controls_available',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_performance_disable_emoji',
                array(
                        'default'           => $defaults['disable_emoji'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_performance_disable_emoji_control',
                array(
                        'label'       => __( 'WordPress-Emojis deaktivieren', 'beyond_gotham' ),
                        'section'     => 'beyond_gotham_performance',
                        'settings'    => 'beyond_gotham_performance_disable_emoji',
                        'type'        => 'checkbox',
                )
        );
}

// =============================================================================
// Helpers & runtime
// =============================================================================

/**
 * Retrieve performance settings merged with defaults.
 *
 * @return array
 */
function beyond_gotham_get_performance_settings() {
        $defaults = beyond_gotham_get_performance_defaults();

        $settings = array(
                'lazy_images'     => (bool) get_theme_mod( 'beyond_gotham_performance_lazy_images', $defaults['lazy_images'] ),
                'lazy_iframes'    => (bool) get_theme_mod( 'beyond_gotham_performance_lazy_iframes', $defaults['lazy_iframes'] ),
                'lqip'            => (bool) get_theme_mod( 'beyond_gotham_performance_lqip', $defaults['lqip'] ),
                'script_strategy' => get_theme_mod( 'beyond_gotham_performance_script_strategy', $defaults['script_strategy'] ),
                'heartbeat'       => get_theme_mod( 'beyond_gotham_performance_heartbeat', $defaults['heartbeat'] ),
                'disable_emoji'   => (bool) get_theme_mod( 'beyond_gotham_performance_disable_emoji', $defaults['disable_emoji'] ),
        );

        $strategies = array( 'default', 'defer', 'async' );
        if ( ! in_array( $settings['script_strategy'], $strategies, true ) ) {
                $settings['script_strategy'] = 'default';
        }

        $heartbeat_options = array( 'normal', 'reduce', 'minimal', 'disable' );
        if ( ! in_array( $settings['heartbeat'], $heartbeat_options, true ) ) {
                $settings['heartbeat'] = 'normal';
        }

        return $settings;
}

/**
 * Bootstrap runtime performance adjustments.
 *
 * @return void
 */
function beyond_gotham_bootstrap_performance_features() {
        $settings = beyond_gotham_get_performance_settings();

        if ( ! empty( $settings['disable_emoji'] ) ) {
                beyond_gotham_performance_disable_emojis();
        }

        if ( beyond_gotham_performance_has_conflicts() ) {
                return;
        }

        add_filter( 'wp_lazy_loading_enabled', 'beyond_gotham_performance_filter_lazy_loading', 20, 3 );
        add_filter( 'wp_get_attachment_image_attributes', 'beyond_gotham_performance_filter_image_attributes', 20, 3 );

        add_filter( 'script_loader_tag', 'beyond_gotham_performance_filter_script_loader', 20, 3 );

        if ( 'disable' === $settings['heartbeat'] ) {
                add_filter( 'heartbeat_enabled', '__return_false' );
        } else {
                add_filter( 'heartbeat_settings', 'beyond_gotham_performance_filter_heartbeat_settings', 10, 2 );
        }

        if ( ! empty( $settings['lqip'] ) ) {
                add_action( 'wp_enqueue_scripts', 'beyond_gotham_performance_enqueue_lqip_script', 120 );
        }
}

/**
 * Lazy loading decision callback.
 *
 * @param bool   $default Whether lazy-loading is enabled.
 * @param string $tag_name Tag name.
 * @param string $context Context identifier.
 * @return bool
 */
function beyond_gotham_performance_filter_lazy_loading( $default, $tag_name, $context ) {
        $settings = beyond_gotham_get_performance_settings();

        if ( 'img' === $tag_name && ! $settings['lazy_images'] ) {
                return false;
        }

        if ( 'iframe' === $tag_name && ! $settings['lazy_iframes'] ) {
                return false;
        }

        return $default;
}

/**
 * Add blur placeholders for LQIP option.
 *
 * @param array        $attr      Image attributes.
 * @param WP_Post|null $attachment Attachment instance.
 * @param string|array $size       Requested size.
 * @return array
 */
function beyond_gotham_performance_filter_image_attributes( $attr, $attachment, $size ) {
        $settings = beyond_gotham_get_performance_settings();

        if ( empty( $settings['lqip'] ) ) {
                return $attr;
        }

        if ( ! isset( $attr['class'] ) ) {
                $attr['class'] = '';
        }

        $attr['class'] .= ' bg-has-lqip';
        $attr['data-bg-lqip'] = '1';

        return $attr;
}

/**
 * Modify script loading attributes for theme assets.
 *
 * @param string $tag    Script tag HTML.
 * @param string $handle Handle name.
 * @param string $src    Script source.
 * @return string
 */
function beyond_gotham_performance_filter_script_loader( $tag, $handle, $src ) {
        $settings = beyond_gotham_get_performance_settings();
        $strategy = $settings['script_strategy'];

        if ( 'default' === $strategy ) {
                return $tag;
        }

        $eligible_handles = array( 'beyond-gotham-theme', 'beyond-gotham-customize-preview' );

        if ( ! in_array( $handle, $eligible_handles, true ) ) {
                return $tag;
        }

        if ( false !== strpos( $tag, ' defer' ) || false !== strpos( $tag, ' async' ) ) {
                return $tag;
        }

        if ( 'defer' === $strategy ) {
                $tag = str_replace( '<script ', '<script defer ', $tag );
        } elseif ( 'async' === $strategy ) {
                $tag = str_replace( '<script ', '<script async ', $tag );
        }

        return $tag;
}

/**
 * Adjust heartbeat interval based on theme setting.
 *
 * @param array      $settings Heartbeat settings.
 * @param array|null $screen   Screen data.
 * @return array
 */
function beyond_gotham_performance_filter_heartbeat_settings( $settings, $screen = null ) {
        $choice = beyond_gotham_get_performance_settings()['heartbeat'];

        if ( 'reduce' === $choice ) {
                $settings['interval'] = max( 60, (int) $settings['interval'] );
        } elseif ( 'minimal' === $choice ) {
                $settings['interval'] = max( 120, (int) $settings['interval'] );
        }

        return $settings;
}

/**
 * Remove emoji scripts and styles.
 *
 * @return void
 */
function beyond_gotham_performance_disable_emojis() {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}

/**
 * Add a minimal script to clear blur placeholders when images finish loading.
 */
function beyond_gotham_performance_enqueue_lqip_script() {
        $script = 'document.addEventListener("DOMContentLoaded",function(){var imgs=document.querySelectorAll("img.bg-has-lqip");imgs.forEach(function(img){var markLoaded=function(){img.classList.add("bg-lqip-loaded");};if(img.complete){markLoaded();}else{img.addEventListener("load",markLoaded,{once:true});}});});';

        wp_add_inline_script( 'beyond-gotham-theme', $script );
}

/**
 * Data for preview scripts.
 *
 * @return array
 */
function beyond_gotham_get_performance_preview_data() {
        $settings = beyond_gotham_get_performance_settings();

        return array(
                'lazyImages'   => $settings['lazy_images'],
                'lazyIframes'  => $settings['lazy_iframes'],
                'lqip'         => $settings['lqip'],
                'script'       => $settings['script_strategy'],
                'heartbeat'    => $settings['heartbeat'],
                'disableEmoji' => $settings['disable_emoji'],
                'hasConflicts' => beyond_gotham_performance_has_conflicts(),
        );
}
