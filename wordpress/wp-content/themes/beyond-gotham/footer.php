<?php
/**
 * The template for displaying the footer.
 *
 * @package beyond_gotham
 */
?>
<footer id="colophon" class="site-footer">
    <?php
    $footer_cta_settings = function_exists( 'beyond_gotham_get_cta_settings' ) ? beyond_gotham_get_cta_settings() : array();
    $footer_cta_text     = isset( $footer_cta_settings['text'] ) ? $footer_cta_settings['text'] : '';
    $footer_cta_label    = isset( $footer_cta_settings['label'] ) ? $footer_cta_settings['label'] : '';
    $footer_cta_url      = isset( $footer_cta_settings['url'] ) ? $footer_cta_settings['url'] : '';
    $footer_text_clean   = trim( wp_strip_all_tags( $footer_cta_text ) );
    $footer_label_clean  = trim( $footer_cta_label );
    $footer_cta_empty    = ( '' === $footer_text_clean ) && ( '' === $footer_label_clean );
    $footer_cta_classes  = 'cta site-footer__cta';
    $footer_cta_attrs    = '';

    if ( $footer_cta_empty ) {
        $footer_cta_classes .= ' site-footer__cta--empty';
        $footer_cta_attrs    = ' hidden aria-hidden="true"';
    }
    ?>
    <div class="<?php echo esc_attr( $footer_cta_classes ); ?>" data-bg-cta<?php echo $footer_cta_attrs; ?>>
        <?php if ( $footer_cta_text ) : ?>
            <p class="cta__lead" data-bg-cta-text><?php echo $footer_cta_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
        <?php endif; ?>
        <a class="bg-button bg-button--primary" data-bg-cta-button<?php echo $footer_cta_url ? ' href="' . esc_url( $footer_cta_url ) . '"' : ' aria-disabled="true"'; ?>>
            <?php echo esc_html( $footer_cta_label ); ?>
        </a>
    </div>
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
    $show_footer_social  = get_theme_mod( 'beyond_gotham_footer_show_social', true );

    if ( ! empty( $footer_social_links ) ) :
        $social_classes = 'site-footer__social';
        $social_attrs   = '';

        if ( ! $show_footer_social ) {
            $social_classes .= ' is-hidden';
            $social_attrs    = ' hidden aria-hidden="true"';
        }
        ?>
        <div class="<?php echo esc_attr( $social_classes ); ?>" data-bg-footer-social<?php echo $social_attrs; ?>>
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
