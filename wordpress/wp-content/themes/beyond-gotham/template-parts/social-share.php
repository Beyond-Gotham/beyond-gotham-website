<?php
/**
 * Wrapper template to render the social sharing component with visibility checks.
 *
 * @package beyond_gotham
 */

$global_enabled = get_theme_mod( 'enable_social_share', true );

if ( ! $global_enabled ) {
    return;
}

$context = '';

if ( isset( $args['context'] ) && is_string( $args['context'] ) ) {
    $context = sanitize_key( $args['context'] );
} elseif ( is_singular( 'post' ) ) {
    $context = 'post';
} elseif ( is_page() ) {
    $context = 'page';
} elseif ( is_category() ) {
    $context = 'category';
}

if ( '' !== $context && function_exists( 'beyond_gotham_is_social_sharing_enabled_for' ) ) {
    if ( ! beyond_gotham_is_social_sharing_enabled_for( $context ) ) {
        return;
    }
}

get_template_part( 'template-parts/share-buttons', null, isset( $args ) ? $args : array() );
