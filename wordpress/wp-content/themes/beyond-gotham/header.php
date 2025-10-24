<?php
/**
 * The header for our theme.
 *
 * @package beyond_gotham
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js theme-light" data-theme="light">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#primary"><?php esc_html_e( 'Zum Inhalt springen', 'beyond_gotham' ); ?></a>
<header class="site-header" role="banner">
    <div class="site-header__inner">
        <div class="site-branding">
            <?php
            $brand_logo_id = function_exists( 'beyond_gotham_get_brand_logo_id' ) ? beyond_gotham_get_brand_logo_id() : 0;

            if ( $brand_logo_id ) {
                $logo_markup = wp_get_attachment_image( $brand_logo_id, 'full', false, array( 'class' => 'custom-logo' ) );

                if ( $logo_markup ) {
                    echo '<div class="site-logo">';
                    echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="custom-logo-link" rel="home">' . $logo_markup . '</a>';
                    echo '</div>';
                }
            } elseif ( has_custom_logo() ) {
                echo '<div class="site-logo">';
                the_custom_logo();
                echo '</div>';
            } else {
                ?>
                <a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php bloginfo( 'name' ); ?>
                </a>
                <p class="site-description"><?php bloginfo( 'description' ); ?></p>
                <?php
            }
            ?>
        </div>

        <button class="site-header__toggle" type="button" aria-expanded="false" aria-controls="primary-navigation" data-bg-nav-toggle>
            <span class="site-header__toggle-label"><?php esc_html_e( 'Menü', 'beyond_gotham' ); ?></span>
            <span class="site-header__toggle-icon" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>

        <?php
        $custom_social_links = function_exists( 'beyond_gotham_get_social_links' ) ? beyond_gotham_get_social_links() : array();
        $socialbar_settings = function_exists( 'beyond_gotham_get_socialbar_settings' ) ? beyond_gotham_get_socialbar_settings() : array();
        $header_socialbar_active = ! empty( $socialbar_settings['show_header'] );
        ?>
        <nav class="site-nav" id="primary-navigation" aria-label="<?php esc_attr_e( 'Hauptnavigation', 'beyond_gotham' ); ?>" data-bg-nav>
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'site-nav__list',
                        'container'      => false,
                        'depth'          => 2,
                        'fallback_cb'    => false,
                        'link_before'    => '<span class="site-nav__link-text">',
                        'link_after'     => '</span>',
                    )
                );
            } else {
                echo '<ul class="site-nav__list"><li class="site-nav__item">' . esc_html__( 'Bitte ein Hauptmenü zuweisen.', 'beyond_gotham' ) . '</li></ul>';
            }

            if ( ! $header_socialbar_active ) {
                if ( has_nav_menu( 'menu-2' ) ) {
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-2',
                            'menu_class'     => 'site-nav__social',
                            'container'      => false,
                            'depth'          => 1,
                        )
                    );
                } elseif ( ! empty( $custom_social_links ) ) {
                    get_template_part(
                        'template-parts/social-icons',
                        null,
                        array(
                            'context'         => 'header',
                            'modifiers'       => array( 'compact' ),
                            'links'           => $custom_social_links,
                            'wrapper_classes' => array( 'site-nav__social', 'site-nav__social--theme' ),
                            'aria_label'      => __( 'Social-Media-Links', 'beyond_gotham' ),
                        )
                    );
                }
            }
            ?>
        </nav>
        <?php
        if ( $header_socialbar_active && function_exists( 'beyond_gotham_render_socialbar' ) ) {
            beyond_gotham_render_socialbar( 'header' );
        }
        ?>
    </div>
</header>
<div class="site-nav__overlay" data-bg-nav-overlay aria-hidden="true"></div>
