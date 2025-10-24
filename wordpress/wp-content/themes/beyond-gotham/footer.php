<?php
/**
 * The template for displaying the footer.
 *
 * @package beyond_gotham
 */
?>
<footer id="colophon" class="site-footer">
    <nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'beyond_gotham' ); ?>">
        <?php
        if ( has_nav_menu( 'footer' ) ) {
            wp_nav_menu(
                array(
                    'theme_location' => 'footer',
                    'menu_id'        => 'footer-menu',
                    'container'      => false,
                )
            );
        }
        ?>
    </nav>
    <?php
    $footer_social_links = function_exists( 'beyond_gotham_get_social_links' ) ? beyond_gotham_get_social_links() : array();
    if ( ! empty( $footer_social_links ) ) :
        ?>
        <div class="site-footer__social">
            <?php beyond_gotham_render_social_links( $footer_social_links ); ?>
        </div>
    <?php endif; ?>
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
