<?php
/**
 * Theme header
 *
 * @package BeyondGothamDarkChild
 */

defined('ABSPATH') || exit();
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e('Zum Inhalt springen', 'beyondgotham-dark-child'); ?></a>
<header class="site-header" role="banner">
    <div class="site-header__inner">
        <div class="site-branding">
            <?php if (has_custom_logo()) : ?>
                <div class="site-logo"><?php the_custom_logo(); ?></div>
            <?php else : ?>
                <a class="site-title" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php bloginfo('name'); ?>
                </a>
                <p class="site-description"><?php bloginfo('description'); ?></p>
            <?php endif; ?>
        </div>
        <button class="site-header__toggle" type="button" aria-expanded="false" aria-controls="primary-navigation" data-bg-nav-toggle>
            <span class="site-header__toggle-label"><?php esc_html_e('Menü', 'beyondgotham-dark-child'); ?></span>
            <span class="site-header__toggle-icon" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>
        <nav class="site-nav" id="primary-navigation" aria-label="<?php esc_attr_e('Hauptnavigation', 'beyondgotham-dark-child'); ?>" data-bg-nav>
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_class'     => 'site-nav__list',
                    'container'      => false,
                    'depth'          => 2,
                    'fallback_cb'    => false,
                    'link_before'    => '<span class="site-nav__link-text">',
                    'link_after'     => '</span>',
                ]);
            } else {
                echo '<ul class="site-nav__list"><li class="site-nav__item">' . esc_html__('Bitte ein Hauptmenü zuweisen.', 'beyondgotham-dark-child') . '</li></ul>';
            }

            if (has_nav_menu('menu-2')) {
                wp_nav_menu([
                    'theme_location' => 'menu-2',
                    'menu_class'     => 'site-nav__social',
                    'container'      => false,
                    'depth'          => 1,
                ]);
            }
            ?>
        </nav>
    </div>
</header>
<div class="site-nav__overlay" data-bg-nav-overlay aria-hidden="true"></div>
