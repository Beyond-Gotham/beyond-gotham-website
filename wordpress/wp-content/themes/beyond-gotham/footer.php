<?php
/**
 * The template for displaying the footer.
 *
 * @package beyond_gotham
 */
?>
<footer id="colophon" class="site-footer">
    <nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Navigation', 'beyond_gotham' ); ?>">
        <?php
        if ( has_nav_menu( 'footer' ) ) {
            wp_nav_menu(
                array(
                    'theme_location' => 'footer',
                    'menu_id'        => 'footer-menu',
                    'menu_class'     => 'footer-menu',
                    'container'      => false,
                )
            );
        }
        ?>
    </nav>
    <?php
    $footer_social_links = function_exists( 'beyond_gotham_get_social_links' ) ? beyond_gotham_get_social_links() : array();
    $show_footer_social  = get_theme_mod( 'beyond_gotham_footer_show_social', true );

    if ( function_exists( 'beyond_gotham_get_social_icon_svgs' ) ) {
        $icon_map = beyond_gotham_get_social_icon_svgs();

        $footer_social_links = array_filter(
            $footer_social_links,
            static function ( $url, $network ) use ( $icon_map ) {
                return ! empty( $url ) && isset( $icon_map[ $network ] );
            },
            ARRAY_FILTER_USE_BOTH
        );
    }

    if ( ! empty( $footer_social_links ) ) :
        $wrapper_classes = array();
        $wrapper_attrs   = 'data-bg-footer-social';

        if ( ! $show_footer_social ) {
            $wrapper_classes[] = 'is-hidden';
            $wrapper_attrs     .= ' hidden aria-hidden="true"';
        }

        beyond_gotham_render_social_links(
            $footer_social_links,
            array(
                'context'            => 'footer-icons',
                'wrapper_classes'    => $wrapper_classes,
                'wrapper_attributes' => $wrapper_attrs,
            )
        );
    endif;
    ?>
    <p class="site-info">
        <?php
        if ( function_exists( 'beyond_gotham_get_footer_text' ) ) {
            echo beyond_gotham_get_footer_text(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        } else {
            echo '&copy; ' . esc_html( date_i18n( 'Y' ) ) . ' ' . esc_html( get_bloginfo( 'name' ) );
        }
        ?>
    </p>
</footer><!-- #colophon -->

<?php wp_footer(); ?>
</body>
</html>
