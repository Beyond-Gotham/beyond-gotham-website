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
            $text_only_branding = function_exists( 'beyond_gotham_is_branding_text_only' ) ? beyond_gotham_is_branding_text_only() : false;
            $brand_logo_id     = ( ! $text_only_branding && function_exists( 'beyond_gotham_get_brand_logo_id' ) ) ? beyond_gotham_get_brand_logo_id() : 0;

            if ( ! $text_only_branding && $brand_logo_id ) {
                $logo_markup = wp_get_attachment_image( $brand_logo_id, 'full', false, array( 'class' => 'custom-logo' ) );

                if ( $logo_markup ) {
                    echo '<div class="site-logo">';
                    echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="custom-logo-link" rel="home">' . $logo_markup . '</a>';
                    echo '</div>';
                }
            } elseif ( ! $text_only_branding && has_custom_logo() ) {
                echo '<div class="site-logo">';
                the_custom_logo();
                echo '</div>';
            }

            if ( $text_only_branding || ( ! $brand_logo_id && ! has_custom_logo() ) ) {
                ?>
                <a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php bloginfo( 'name' ); ?>
                </a>
                <p class="site-description"><?php bloginfo( 'description' ); ?></p>
                <?php
            }
            ?>
        </div>

        <?php
        $nav_enabled_primary   = function_exists( 'beyond_gotham_nav_location_enabled' ) ? beyond_gotham_nav_location_enabled( 'primary' ) : true;
        $nav_enabled_secondary = function_exists( 'beyond_gotham_nav_location_enabled' ) ? beyond_gotham_nav_location_enabled( 'secondary' ) : true;

        $has_primary_menu   = $nav_enabled_primary && has_nav_menu( 'primary' );
        $has_secondary_menu = $nav_enabled_secondary && has_nav_menu( 'menu-2' );

        if ( $nav_enabled_primary || $nav_enabled_secondary ) :
            ?>
        <button class="site-header__toggle" type="button" aria-expanded="false" aria-controls="primary-navigation" data-bg-nav-toggle>
            <span class="site-header__toggle-label"><?php esc_html_e( 'Menü', 'beyond_gotham' ); ?></span>
            <span class="site-header__toggle-icon" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>
        <?php endif; ?>

        <?php
        $custom_social_links = function_exists( 'beyond_gotham_get_social_links' ) ? beyond_gotham_get_social_links() : array();
        $socialbar_settings = function_exists( 'beyond_gotham_get_socialbar_settings' ) ? beyond_gotham_get_socialbar_settings() : array();
        $header_socialbar_active = ! empty( $socialbar_settings['show_header'] );
        ?>
        <?php if ( $nav_enabled_primary || $nav_enabled_secondary ) : ?>
        <nav class="site-nav" id="primary-navigation" aria-label="<?php esc_attr_e( 'Hauptnavigation', 'beyond_gotham' ); ?>" data-bg-nav>
            <?php
            if ( $nav_enabled_primary ) {
                if ( $has_primary_menu ) {
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
            }

            if ( $nav_enabled_secondary && ! $header_socialbar_active ) {
                if ( $has_secondary_menu ) {
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
        <?php endif; ?>
        <?php
        if ( $header_socialbar_active && function_exists( 'beyond_gotham_render_socialbar' ) ) {
            beyond_gotham_render_socialbar( 'header' );
        }
        ?>
    </div>
</header>
<?php if ( $nav_enabled_primary || $nav_enabled_secondary ) : ?>
<div class="site-nav__overlay" data-bg-nav-overlay aria-hidden="true"></div>
<?php endif; ?>
