<?php
/**
 * BeyondGotham Dark Child Theme
 */
add_action('wp_enqueue_scripts', function () {
    // Parent stylesheet
    wp_enqueue_style('freenews-style', get_template_directory_uri() . '/style.css');
    // Child overrides
    wp_enqueue_style('beyondgotham-style', get_stylesheet_uri(), ['freenews-style'], wp_get_theme()->get('Version'));
});
