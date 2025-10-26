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
        $is_preview            = function_exists( 'is_customize_preview' ) && is_customize_preview();

        $nav_state = array(
            'primary'   => $nav_enabled_primary,
            'secondary' => $nav_enabled_secondary,
        );

        $nav_any_enabled    = $nav_state['primary'] || $nav_state['secondary'];
        $has_primary_menu   = has_nav_menu( 'primary' );
        $has_secondary_menu = has_nav_menu( 'menu-2' );

        $toggle_attributes = array(
            'class'             => 'site-header__toggle',
            'type'              => 'button',
            'aria-expanded'     => 'false',
            'aria-controls'     => 'primary-navigation',
            'data-bg-nav-toggle'=> true,
        );

        if ( ! $nav_any_enabled && ! $is_preview ) {
            $toggle_attributes['hidden']      = true;
            $toggle_attributes['aria-hidden'] = 'true';
        }

        ?>
        <button<?php echo beyond_gotham_format_html_attributes( $toggle_attributes ); ?>>
            <span class="site-header__toggle-label"><?php esc_html_e( 'Menü', 'beyond_gotham' ); ?></span>
            <span class="site-header__toggle-icon" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>

        <?php
        $custom_social_links      = function_exists( 'beyond_gotham_get_social_links' ) ? beyond_gotham_get_social_links() : array();
        $socialbar_settings       = function_exists( 'beyond_gotham_get_socialbar_settings' ) ? beyond_gotham_get_socialbar_settings() : array();
        $header_socialbar_active  = ! empty( $socialbar_settings['show_header'] );
        $should_render_socialbar  = $header_socialbar_active || $is_preview;

        $primary_menu_markup = '';
        if ( $nav_state['primary'] || $is_preview ) {
            $primary_menu_markup = beyond_gotham_render_menu(
                'primary',
                array(
                    'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'render_when_empty' => $is_preview,
                )
            );

            if ( '' === trim( $primary_menu_markup ) ) {
                $primary_menu_markup  = '<ul id="primary-menu" class="site-nav__list site-nav__list--empty" data-empty="true">';
                $primary_menu_markup .= '<li class="site-nav__item site-nav__item--empty">' . esc_html__( 'Bitte ein Hauptmenü zuweisen.', 'beyond_gotham' ) . '</li>';
                $primary_menu_markup .= '</ul>';
            }
        }

        $secondary_menu_markup    = '';
        $secondary_should_render  = ( $nav_state['secondary'] && ! $header_socialbar_active ) || $is_preview;

        if ( $secondary_should_render ) {
            $secondary_menu_markup = beyond_gotham_render_menu(
                'secondary',
                array(
                    'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'render_when_empty' => $is_preview,
                )
            );

            if ( '' === trim( $secondary_menu_markup ) && $nav_state['secondary'] && ! $header_socialbar_active && ! empty( $custom_social_links ) ) {
                ob_start();
                get_template_part(
                    'template-parts/social-icons',
                    null,
                    array(
                        'context'         => 'header',
                        'modifiers'       => array( 'compact' ),
                        'links'           => $custom_social_links,
                        'wrapper_classes' => array( 'site-nav__social', 'site-nav__social--theme' ),
                        'aria_label'      => __( 'Social-Media-Links', 'beyond_gotham' ),
                        'include_empty'   => $is_preview,
                    )
                );
                $secondary_menu_markup = ob_get_clean();
            }

            if ( '' === trim( $secondary_menu_markup ) && ( $nav_state['secondary'] || $is_preview ) && ! $header_socialbar_active ) {
                $secondary_menu_markup  = '<ul id="secondary-menu" class="site-nav__social site-nav__social--empty" data-empty="true">';
                $secondary_menu_markup .= '<li class="site-nav__item site-nav__item--empty">' . esc_html__( 'Bitte ein Sekundärmenü zuweisen.', 'beyond_gotham' ) . '</li>';
                $secondary_menu_markup .= '</ul>';
            }
        }

        $nav_attributes = array(
            'class'                     => 'site-nav',
            'id'                        => 'primary-navigation',
            'aria-label'                => __( 'Hauptnavigation', 'beyond_gotham' ),
            'data-bg-nav'               => true,
            'data-nav-primary-active'   => $nav_state['primary'] ? 'true' : 'false',
            'data-nav-secondary-active' => $nav_state['secondary'] ? 'true' : 'false',
        );

        if ( ! $nav_any_enabled && ! $is_preview ) {
            $nav_attributes['hidden']      = true;
            $nav_attributes['aria-hidden'] = 'true';
        }
        ?>
        <nav<?php echo beyond_gotham_format_html_attributes( $nav_attributes ); ?>>
            <?php if ( $nav_state['primary'] || $is_preview ) : ?>
                <?php
                $primary_wrapper_attributes = array(
                    'class'             => 'site-nav__menu site-nav__menu--primary',
                    'data-bg-nav-menu'  => 'primary',
                    'data-nav-enabled'  => $nav_state['primary'] ? 'true' : 'false',
                    'data-nav-empty'    => $has_primary_menu ? 'false' : 'true',
                );

                if ( ! $nav_state['primary'] && ! $is_preview ) {
                    $primary_wrapper_attributes['hidden']      = true;
                    $primary_wrapper_attributes['aria-hidden'] = 'true';
                }
                ?>
                <div<?php echo beyond_gotham_format_html_attributes( $primary_wrapper_attributes ); ?>>
                    <?php echo $primary_menu_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            <?php endif; ?>

            <?php if ( $nav_state['secondary'] || $is_preview ) : ?>
                <?php
                $secondary_wrapper_attributes = array(
                    'class'              => 'site-nav__menu site-nav__menu--secondary',
                    'data-bg-nav-menu'   => 'secondary',
                    'data-nav-enabled'   => $nav_state['secondary'] ? 'true' : 'false',
                    'data-nav-empty'     => $has_secondary_menu ? 'false' : 'true',
                    'data-nav-socialbar' => $header_socialbar_active ? 'true' : 'false',
                );

                if ( ( ! $nav_state['secondary'] || $header_socialbar_active ) && ! $is_preview ) {
                    $secondary_wrapper_attributes['hidden']      = true;
                    $secondary_wrapper_attributes['aria-hidden'] = 'true';
                }
                ?>
                <div<?php echo beyond_gotham_format_html_attributes( $secondary_wrapper_attributes ); ?>>
                    <?php echo $secondary_menu_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            <?php endif; ?>
        </nav>
        <?php
        if ( $should_render_socialbar && function_exists( 'beyond_gotham_render_socialbar' ) ) {
            beyond_gotham_render_socialbar( 'header' );
        }
        ?>
    </div>
</header>
<?php
$should_render_overlay = $nav_any_enabled || $is_preview;

if ( $should_render_overlay ) {
    $overlay_attributes = array(
        'class'              => 'site-nav__overlay',
        'data-bg-nav-overlay'=> true,
        'aria-hidden'        => 'true',
    );

    if ( ! $nav_any_enabled && ! $is_preview ) {
        $overlay_attributes['hidden'] = true;
    }

    echo '<div' . beyond_gotham_format_html_attributes( $overlay_attributes ) . '></div>';
}
?>
