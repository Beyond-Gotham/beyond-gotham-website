<?php
/**
 * Navigation template part.
 *
 * @package beyond_gotham
 */

if ( ! has_nav_menu( 'primary' ) ) {
    return;
}

wp_nav_menu(
    array(
        'theme_location'  => 'primary',
        'menu_id'         => 'primary-menu',
        'container'       => 'nav',
        'container_class' => 'primary-navigation',
        'container_id'    => 'site-navigation',
    )
);
