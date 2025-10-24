<?php
/**
 * The template for displaying the footer.
 *
 * @package beyond_gotham
 */
?>
<footer id="colophon" class="site-footer">
    <div class="footer-inner">
        <div class="footer-left">
            <?php
            $footer_text = '';

            if ( function_exists( 'beyond_gotham_get_footer_text' ) ) {
                $footer_text = beyond_gotham_get_footer_text(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            } else {
                $footer_text = '&copy; ' . esc_html( date_i18n( 'Y' ) ) . ' ' . esc_html( get_bloginfo( 'name' ) );
            }

            if ( ! empty( $footer_text ) ) :
                ?>
                <small class="site-info"><?php echo $footer_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></small>
                <?php
            endif;
            ?>
        </div>
        <div class="footer-center">
            <?php if ( has_nav_menu( 'footer' ) ) : ?>
                <nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Navigation', 'beyond_gotham' ); ?>">
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
        </div>
        <div class="footer-right">
            <?php
            $footer_social_links = function_exists( 'beyond_gotham_get_social_links' ) ? beyond_gotham_get_social_links() : array();
            $show_footer_social  = get_theme_mod( 'beyond_gotham_footer_show_social', true );

            if ( ! empty( $footer_social_links ) ) :
                $wrapper_classes = array();

                if ( ! $show_footer_social ) {
                    $wrapper_classes[] = 'is-hidden';
                }

                get_template_part(
                    'template-parts/social-icons',
                    null,
                    array(
                        'context'            => 'footer',
                        'links'              => $footer_social_links,
                        'wrapper_classes'    => $wrapper_classes,
                        'wrapper_attributes' => array( 'data-bg-footer-social' => true ),
                        'hidden'             => ! $show_footer_social,
                        'aria_label'         => __( 'Footer Social Media', 'beyond_gotham' ),
                    )
                );
            endif;
            ?>
        </div>
    </div>
</footer><!-- #colophon -->

<?php wp_footer(); ?>
</body>
</html>
