<?php
/**
 * Template part for rendering the CTA box above the footer.
 *
 * @package beyond_gotham
 */

if ( ! should_display_cta() ) {
    return;
}

$cta_settings = function_exists( 'beyond_gotham_get_cta_settings' ) ? beyond_gotham_get_cta_settings() : array();
$cta_text     = isset( $cta_settings['text'] ) ? $cta_settings['text'] : '';
$cta_label    = isset( $cta_settings['label'] ) ? $cta_settings['label'] : '';
$cta_url      = isset( $cta_settings['url'] ) ? $cta_settings['url'] : '';

$cta_text_clean  = trim( wp_strip_all_tags( $cta_text ) );
$cta_label_clean = trim( $cta_label );
$cta_is_empty    = ( '' === $cta_text_clean ) && ( '' === $cta_label_clean );

$layout_settings = function_exists( 'beyond_gotham_get_cta_layout_settings' ) ? beyond_gotham_get_cta_layout_settings() : array();
$wrapper_attrs   = beyond_gotham_build_cta_wrapper_attributes(
    array(
        'layout_settings' => $layout_settings,
        'base_classes'    => array( 'cta-box', 'cta' ),
        'extra_classes'   => $cta_is_empty ? array( 'cta-box--empty' ) : array(),
        'is_empty'        => $cta_is_empty,
    )
);

$attributes = array(
    'class'      => $wrapper_attrs['class'],
    'data-bg-cta'=> true,
);

if ( $cta_is_empty ) {
    $attributes['hidden']      = true;
    $attributes['aria-hidden'] = 'true';
}

if ( ! empty( $wrapper_attrs['style'] ) ) {
    $attributes['style'] = $wrapper_attrs['style'];
}

$format_attributes = static function ( $attrs ) {
    if ( empty( $attrs ) || ! is_array( $attrs ) ) {
        return '';
    }

    $chunks = array();

    foreach ( $attrs as $name => $value ) {
        if ( is_int( $name ) ) {
            $name  = $value;
            $value = true;
        }

        if ( ! is_string( $name ) ) {
            continue;
        }

        $name = trim( $name );

        if ( '' === $name || ! preg_match( '/^[a-zA-Z0-9_:-]+$/', $name ) ) {
            continue;
        }

        if ( true === $value ) {
            $chunks[] = esc_attr( strtolower( $name ) );
            continue;
        }

        if ( false === $value || null === $value || '' === $value ) {
            continue;
        }

        $chunks[] = sprintf( '%s="%s"', esc_attr( strtolower( $name ) ), esc_attr( $value ) );
    }

    return $chunks ? ' ' . implode( ' ', $chunks ) : '';
};

?>
<section<?php echo $format_attributes( $attributes ); ?>>
    <?php
    get_template_part(
        'template-parts/components/cta-content',
        null,
        array(
            'variant'           => 'cta',
            'text'              => $cta_text,
            'text_attributes'   => array( 'data-bg-cta-text' => true ),
            'button_label'      => $cta_label,
            'button_url'        => $cta_url,
            'button_attributes' => array( 'data-bg-cta-button' => true ),
            'render_social'     => true,
            'social_args'       => array(
                'context'         => 'cta',
                'modifiers'       => array( 'compact' ),
                'wrapper_classes' => array( 'cta__social-icons' ),
                'aria_label'      => __( 'Social Media Call to Action', 'beyond_gotham' ),
            ),
        )
    );
    ?>
</section>
