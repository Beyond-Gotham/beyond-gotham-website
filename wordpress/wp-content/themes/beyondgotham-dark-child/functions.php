<?php
/**
 * BeyondGotham Dark – Child Theme for FreeNews
 */
add_action('wp_enqueue_scripts', function () {
    // Parent Styles
    wp_enqueue_style(
        'freenews-parent',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme('freenews')->get('Version') ?: null
    );
    // Child main
    wp_enqueue_style(
        'beyondgotham-child',
        get_stylesheet_uri(),
        ['freenews-parent'],
        wp_get_theme()->get('Version')
    );
    // Extra dark tune
    wp_enqueue_style(
        'beyondgotham-dark',
        get_stylesheet_directory_uri() . '/assets/css/dark.css',
        ['beyondgotham-child'],
        wp_get_theme()->get('Version')
    );
}, 20);

add_action('after_setup_theme', function(){
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
});

/**
 * (Optional) Einmal-Helfer: Legt Kern-Kategorien an (OSINT, Reportagen, Dossiers, Interviews, InfoTerminal).
 * Entferne das Kommentarzeichen // vor add_action(...) EINMAL, lade Frontend, dann wieder auskommentieren.
 */
// add_action('init', function(){
//     $cats = [
//       ['OSINT','osint'],
//       ['Reportagen','reportagen'],
//       ['Dossiers','dossiers'],
//       ['Interviews','interviews'],
//       ['InfoTerminal','infoterminal']
//     ];
//     foreach ($cats as [$name,$slug]) {
//         if (!term_exists($name, 'category')) {
//             wp_insert_term($name, 'category', ['slug'=>$slug]);
//         }
//     }
// });
