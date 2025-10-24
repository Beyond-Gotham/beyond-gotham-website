<?php
/**
 * Wrapper template to handle CTA visibility rules.
 *
 * @package beyond_gotham
 */

$visibility         = get_theme_mod( 'cta_visibility', 'all' );
$visibility         = is_string( $visibility ) ? strtolower( trim( $visibility ) ) : 'all';
$allowed_visibility = array( 'all', 'home', 'posts', 'none' );

if ( ! in_array( $visibility, $allowed_visibility, true ) ) {
    $visibility = 'all';
}

$should_render = (
    'all' === $visibility ||
    ( 'home' === $visibility && is_front_page() ) ||
    ( 'posts' === $visibility && is_single() )
);

if ( ! $should_render ) {
    return;
}

get_template_part( 'template-parts/cta-box' );
