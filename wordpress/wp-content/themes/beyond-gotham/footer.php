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
    <p class="site-info">&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
</footer><!-- #colophon -->

<?php wp_footer(); ?>
</body>
</html>
