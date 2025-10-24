<?php
/**
 * Template part for rendering the CTA box above the footer.
 *
 * @package beyond_gotham
 */

$cta_settings = function_exists( 'beyond_gotham_get_cta_settings' ) ? beyond_gotham_get_cta_settings() : array();
$cta_text     = isset( $cta_settings['text'] ) ? $cta_settings['text'] : '';
$cta_label    = isset( $cta_settings['label'] ) ? $cta_settings['label'] : '';
$cta_url      = isset( $cta_settings['url'] ) ? $cta_settings['url'] : '';

$cta_text_clean  = trim( wp_strip_all_tags( $cta_text ) );
$cta_label_clean = trim( $cta_label );
$cta_is_empty    = ( '' === $cta_text_clean ) && ( '' === $cta_label_clean );

$layout_settings = function_exists( 'beyond_gotham_get_cta_layout_settings' ) ? beyond_gotham_get_cta_layout_settings() : array();
$layout_classes  = isset( $layout_settings['class_list'] ) ? (array) $layout_settings['class_list'] : array();
$layout_styles   = isset( $layout_settings['style_map'] ) && is_array( $layout_settings['style_map'] ) ? $layout_settings['style_map'] : array();

$cta_classes = array_merge(
    array( 'cta-box', 'cta' ),
    array_map( 'sanitize_html_class', $layout_classes )
);

if ( $cta_is_empty ) {
    $cta_classes[] = 'cta-box--empty';
}

$cta_attrs = $cta_is_empty ? ' hidden aria-hidden="true"' : '';
$cta_style = '';

if ( ! empty( $layout_styles ) ) {
    $style_chunks = array();

    foreach ( $layout_styles as $property => $value ) {
        $property = is_string( $property ) ? trim( $property ) : '';
        $value    = is_string( $value ) ? trim( $value ) : '';

        if ( '' === $property || '' === $value ) {
            continue;
        }

        $style_chunks[] = $property . ': ' . $value . ';';
    }

    if ( ! empty( $style_chunks ) ) {
        $cta_style = ' style="' . esc_attr( implode( ' ', $style_chunks ) ) . '"';
    }
}

$cta_class_attribute = implode( ' ', array_unique( array_filter( $cta_classes ) ) );
?>
<section class="<?php echo esc_attr( $cta_class_attribute ); ?>" data-bg-cta<?php echo $cta_attrs; ?><?php echo $cta_style; ?>>
    <?php if ( $cta_text ) : ?>
        <p class="cta__lead" data-bg-cta-text><?php echo $cta_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
    <?php endif; ?>
    <a class="bg-button bg-button--primary" data-bg-cta-button<?php echo $cta_url ? ' href="' . esc_url( $cta_url ) . '"' : ' aria-disabled="true"'; ?>>
        <?php echo esc_html( $cta_label ); ?>
    </a>
</section>
