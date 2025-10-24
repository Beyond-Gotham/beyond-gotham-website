<?php
/**
 * The header for our theme.
 *
 * @package beyond_gotham
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header id="masthead" class="site-header">
    <div class="site-branding">
        <?php
        if ( has_custom_logo() ) {
            the_custom_logo();
        } else {
            ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title">
                <?php bloginfo( 'name' ); ?>
            </a>
            <p class="site-description"><?php bloginfo( 'description' ); ?></p>
            <?php
        }
        ?>
    </div>
    <nav id="site-navigation" class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'beyond_gotham' ); ?>">
        <?php
        if ( has_nav_menu( 'primary' ) ) {
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                )
            );
        }
        ?>
    </nav>
</header>
