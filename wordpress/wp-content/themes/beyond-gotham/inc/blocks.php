<?php
/**
 * Gutenberg block extensions for Beyond Gotham.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register custom blocks that ship with the theme.
 */
function beyond_gotham_register_blocks() {
    $blocks = array( 'highlight-box', 'course-teaser' );

    foreach ( $blocks as $block ) {
        $block_dir = get_template_directory() . '/blocks/' . $block;

        if ( file_exists( $block_dir . '/block.json' ) ) {
            register_block_type( $block_dir );
        }
    }
}
add_action( 'init', 'beyond_gotham_register_blocks' );

/**
 * Register custom block style variations for core blocks.
 */
function beyond_gotham_register_block_styles() {
    register_block_style(
        'core/quote',
        array(
            'name'  => 'bg-quote',
            'label' => __( 'Beyond Gotham Zitat', 'beyond_gotham' ),
        )
    );

    register_block_style(
        'core/button',
        array(
            'name'  => 'bg-button-ghost',
            'label' => __( 'Ghost-Button', 'beyond_gotham' ),
        )
    );

    register_block_style(
        'core/button',
        array(
            'name'  => 'bg-button-outline',
            'label' => __( 'Outline-Button', 'beyond_gotham' ),
        )
    );

    register_block_style(
        'core/group',
        array(
            'name'  => 'bg-callout',
            'label' => __( 'Callout', 'beyond_gotham' ),
        )
    );

    register_block_style(
        'core/paragraph',
        array(
            'name'  => 'bg-intro',
            'label' => __( 'Intro-Text', 'beyond_gotham' ),
        )
    );
}
add_action( 'init', 'beyond_gotham_register_block_styles' );
