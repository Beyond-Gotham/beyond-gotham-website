<?php
/**
 * Template part for rendering the social sharing buttons.
 *
 * @package beyond_gotham
 */

if ( ! function_exists( 'beyond_gotham_build_social_share_links' ) ) {
    return;
}

$share_args = array();

if ( isset( $args ) && is_array( $args ) ) {
    $share_args = $args;
}

$share_url   = isset( $share_args['share_url'] ) ? (string) $share_args['share_url'] : '';
$share_title = isset( $share_args['share_title'] ) ? (string) $share_args['share_title'] : '';

if ( '' === $share_url ) {
    if ( is_singular() ) {
        $share_url = get_permalink();

        if ( '' === $share_title ) {
            $share_title = get_the_title();
        }
    } elseif ( is_category() ) {
        $term = get_queried_object();

        if ( $term instanceof WP_Term ) {
            $term_link = get_term_link( $term );

            if ( ! is_wp_error( $term_link ) ) {
                $share_url = $term_link;

                if ( '' === $share_title ) {
                    $share_title = $term->name;
                }
            }
        }
    }
}

if ( '' === $share_url ) {
    return;
}

$links = beyond_gotham_build_social_share_links( $share_url, $share_title );

if ( empty( $links ) ) {
    return;
}
?>
<div class="social-share" role="group" aria-label="<?php esc_attr_e( 'Diesen Inhalt teilen', 'beyond_gotham' ); ?>">
    <?php foreach ( $links as $link ) :
        $aria_label = isset( $link['aria_label'] ) ? $link['aria_label'] : sprintf( __( 'Auf %s teilen', 'beyond_gotham' ), $link['label'] );
        ?>
        <a class="social-share__link social-share__link--<?php echo esc_attr( $link['key'] ); ?>" href="<?php echo esc_url( $link['url'] ); ?>" aria-label="<?php echo esc_attr( $aria_label ); ?>" target="_blank" rel="noopener">
            <?php if ( ! empty( $link['icon'] ) ) : ?>
                <span class="social-share__icon" aria-hidden="true"><?php echo esc_html( $link['icon'] ); ?></span>
            <?php endif; ?>
            <span class="social-share__text"><?php echo esc_html( $link['label'] ); ?></span>
        </a>
    <?php endforeach; ?>
</div>

