<?php
/**
 * Theme functions and definitions for Beyond Gotham.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'BEYOND_GOTHAM_VERSION' ) ) {
    define( 'BEYOND_GOTHAM_VERSION', '0.1.0' );
}

if ( ! function_exists( 'beyond_gotham_theme_setup' ) ) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function beyond_gotham_theme_setup() {
        load_theme_textdomain( 'beyond_gotham', get_template_directory() . '/languages' );

        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'custom-logo', array(
            'height'      => 120,
            'width'       => 120,
            'flex-height' => true,
            'flex-width'  => true,
        ) );
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
        add_theme_support( 'editor-styles' );
        add_editor_style( 'dist/style.css' );

        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'beyond_gotham' ),
            'footer'  => __( 'Footer Menu', 'beyond_gotham' ),
        ) );
    }
}
add_action( 'after_setup_theme', 'beyond_gotham_theme_setup' );

/**
 * Enqueue scripts and styles.
 */
function beyond_gotham_enqueue_assets() {
    $theme_version = defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : BEYOND_GOTHAM_VERSION;

    wp_enqueue_style(
        'beyond-gotham-style',
        get_template_directory_uri() . '/dist/style.css',
        array(),
        $theme_version
    );

    wp_enqueue_script(
        'beyond-gotham-theme',
        get_template_directory_uri() . '/dist/theme.js',
        array(),
        $theme_version,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'beyond_gotham_enqueue_assets' );
