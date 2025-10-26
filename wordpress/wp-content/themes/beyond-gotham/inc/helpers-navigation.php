<?php
/**
 * Navigation helpers.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'beyond_gotham_get_nav_menu_defaults' ) ) {
    /**
     * Retrieve default menu arguments for a registered theme location.
     *
     * @param string $location Menu location identifier.
     * @return array
     */
    function beyond_gotham_get_nav_menu_defaults( $location ) {
        $base_defaults = array(
            'container'    => false,
            'fallback_cb'  => '__return_empty_string',
            'echo'         => false,
        );

        switch ( $location ) {
            case 'primary':
                $defaults = array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'site-nav__list',
                    'depth'          => 2,
                    'link_before'    => '<span class="site-nav__link-text">',
                    'link_after'     => '</span>',
                );
                break;
            case 'secondary':
                $defaults = array(
                    'theme_location' => 'menu-2',
                    'menu_id'        => 'secondary-menu',
                    'menu_class'     => 'site-nav__social',
                    'depth'          => 1,
                );
                break;
            case 'footer':
                $defaults = array(
                    'theme_location' => 'footer',
                    'menu_id'        => 'footer-menu',
                    'menu_class'     => 'footer-menu',
                    'depth'          => 1,
                );
                break;
            default:
                $defaults = array(
                    'theme_location' => $location,
                );
                break;
        }

        return wp_parse_args( $defaults, $base_defaults );
    }
}

if ( ! function_exists( 'beyond_gotham_render_menu' ) ) {
    /**
     * Render a navigation menu with consistent defaults.
     *
     * @param string $location Menu location identifier.
     * @param array  $args     Optional overrides for wp_nav_menu().
     * @return string Rendered menu markup or empty string when unavailable.
     */
    function beyond_gotham_render_menu( $location, $args = array() ) {
        $defaults = beyond_gotham_get_nav_menu_defaults( $location );
        $resolved = wp_parse_args( $args, $defaults );

        if ( empty( $resolved['theme_location'] ) ) {
            return '';
        }

        $force_render = ! empty( $resolved['render_when_empty'] );
        unset( $resolved['render_when_empty'] );

        if ( ! $force_render && ! has_nav_menu( $resolved['theme_location'] ) ) {
            return '';
        }

        return (string) wp_nav_menu( $resolved );
    }
}

