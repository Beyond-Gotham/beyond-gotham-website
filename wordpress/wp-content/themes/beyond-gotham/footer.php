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
            $is_preview_footer = function_exists( 'is_customize_preview' ) && is_customize_preview();
            $footer_has_menu   = has_nav_menu( 'footer' );
            $footer_nav_markup = '';

            if ( $footer_nav_enabled || $is_preview_footer ) {
                $footer_nav_markup = beyond_gotham_render_menu(
                    'footer',
                    array(
                        'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'render_when_empty' => $is_preview_footer,
                    )
                );

                if ( '' === trim( $footer_nav_markup ) && ( $footer_nav_enabled || $is_preview_footer ) ) {
                    $footer_nav_markup  = '<ul id="footer-menu" class="footer-menu footer-menu--empty" data-empty="true">';
                    $footer_nav_markup .= '<li class="footer-menu__item footer-menu__item--empty">' . esc_html__( 'Bitte ein Footer-Menü zuweisen.', 'beyond_gotham' ) . '</li>';
                    $footer_nav_markup .= '</ul>';
                }
            }

            $footer_nav_classes = array( 'footer-navigation', 'is-' . $footer_menu_alignment );
            $footer_nav_classes = array_map( 'sanitize_html_class', array_unique( $footer_nav_classes ) );
            $footer_nav_class   = implode( ' ', $footer_nav_classes );

            $footer_nav_attributes = array(
                'class'                 => $footer_nav_class,
                'data-footer-alignment' => $footer_menu_alignment,
                'data-footer-navigation'=> 'true',
                'data-nav-enabled'      => $footer_nav_enabled ? 'true' : 'false',
                'data-nav-empty'        => $footer_has_menu ? 'false' : 'true',
                'aria-label'            => __( 'Footer Navigation', 'beyond_gotham' ),
            );

            if ( ! $footer_nav_enabled && ! $is_preview_footer ) {
                $footer_nav_attributes['hidden']      = true;
                $footer_nav_attributes['aria-hidden'] = 'true';
            }

            if ( $footer_nav_markup ) :
                ?>
                <nav<?php echo beyond_gotham_format_html_attributes( $footer_nav_attributes ); ?>>
                    <?php echo $footer_nav_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </nav>
            <?php elseif ( $footer_nav_enabled && ! $footer_has_menu ) : ?>
                <nav<?php echo beyond_gotham_format_html_attributes( $footer_nav_attributes ); ?>></nav>
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
