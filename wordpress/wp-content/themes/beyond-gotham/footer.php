<?php
/**
 * The template for displaying the footer.
 *
 * @package beyond_gotham
 */
?>
<footer id="colophon" class="site-footer">
    <?php
    $footer_menu_alignment = function_exists( 'beyond_gotham_get_footer_menu_alignment' ) ? beyond_gotham_get_footer_menu_alignment() : 'center';
    $footer_mobile_layout  = function_exists( 'beyond_gotham_get_footer_mobile_layout' ) ? beyond_gotham_get_footer_mobile_layout() : 'stack';
    ?>
    <div class="footer-inner" data-footer-alignment="<?php echo esc_attr( $footer_menu_alignment ); ?>" data-footer-mobile-layout="<?php echo esc_attr( $footer_mobile_layout ); ?>">
        <div class="footer-left">
            <?php do_action( 'beyond_gotham/footer/left' ); ?>
        </div>
        <div class="footer-center">
            <?php
            $footer_nav_enabled = function_exists( 'beyond_gotham_nav_location_enabled' ) ? beyond_gotham_nav_location_enabled( 'footer' ) : true;
            if ( $footer_nav_enabled && has_nav_menu( 'footer' ) ) :
                $footer_nav_classes    = array( 'footer-navigation', 'is-' . $footer_menu_alignment );
                $footer_nav_classes    = array_map( 'sanitize_html_class', array_unique( $footer_nav_classes ) );
                $footer_nav_class      = implode( ' ', $footer_nav_classes );
            ?>
                <nav class="<?php echo esc_attr( $footer_nav_class ); ?>" data-footer-alignment="<?php echo esc_attr( $footer_menu_alignment ); ?>" aria-label="<?php esc_attr_e( 'Footer Navigation', 'beyond_gotham' ); ?>">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer',
                            'menu_id'        => 'footer-menu',
                            'menu_class'     => 'footer-menu',
                            'container'      => false,
                        )
                    );
                    ?>
                </nav>
            <?php endif; ?>

            <div class="footer-darkmode-toggle">
                <?php get_template_part( 'template-parts/darkmode-toggle' ); ?>
            </div>
        </div>
        <div class="footer-right">
            <?php
            $footer_text = '';

            if ( function_exists( 'beyond_gotham_get_footer_text' ) ) {
                $footer_text = beyond_gotham_get_footer_text(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            } else {
                $footer_text = '&copy; ' . esc_html( date_i18n( 'Y' ) ) . ' ' . esc_html( get_bloginfo( 'name' ) );
            }
            ?>
            <small class="site-info"><?php echo $footer_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></small>
        </div>
    </div>
</footer><!-- #colophon -->

<?php wp_footer(); ?>
</body>
</html>
