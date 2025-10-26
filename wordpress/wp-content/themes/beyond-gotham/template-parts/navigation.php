<?php
/**
 * Navigation template part.
 *
 * @package beyond_gotham
 */

if ( ! function_exists( 'beyond_gotham_render_menu' ) ) {
    require_once get_template_directory() . '/inc/helpers-navigation.php';
}

$menu_markup = beyond_gotham_render_menu(
    'primary',
    array(
        'container'       => 'nav',
        'container_class' => 'primary-navigation',
        'container_id'    => 'site-navigation',
        'echo'            => false,
    )
);

if ( '' !== trim( $menu_markup ) ) {
    echo $menu_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
