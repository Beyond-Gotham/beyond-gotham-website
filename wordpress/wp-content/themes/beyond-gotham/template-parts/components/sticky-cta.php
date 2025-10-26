<?php
/**
 * Sticky CTA component using the shared CTA content partial.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$args = isset( $args ) && is_array( $args ) ? $args : array();

$defaults = array(
    'wrapper_attributes' => array(),
    'content'            => '',
    'button'             => array(),
    'close_label'        => __( 'CTA schließen', 'beyond_gotham' ),
);

$data = wp_parse_args( $args, $defaults );

$wrapper_attributes = is_array( $data['wrapper_attributes'] ) ? $data['wrapper_attributes'] : array();

if ( empty( $wrapper_attributes['class'] ) ) {
    $wrapper_attributes['class'] = 'sticky-cta';
}

$button = is_array( $data['button'] ) ? $data['button'] : array();
$button_label = isset( $button['label'] ) && is_string( $button['label'] ) ? $button['label'] : '';
$button_url   = isset( $button['url'] ) && is_string( $button['url'] ) ? $button['url'] : '';
$button_attributes = isset( $button['attributes'] ) && is_array( $button['attributes'] ) ? $button['attributes'] : array();
$button_attributes['data-bg-sticky-cta-button'] = true;

$close_label = is_string( $data['close_label'] ) && '' !== $data['close_label'] ? $data['close_label'] : __( 'CTA schließen', 'beyond_gotham' );
$content     = is_string( $data['content'] ) ? $data['content'] : '';

$button_component_args = array(
    'variant'           => 'cta',
    'title'             => '',
    'text'              => '',
    'button_label'      => $button_label,
    'button_url'        => $button_url,
    'button_class'      => 'sticky-cta__button',
    'button_attributes' => $button_attributes,
    'render_social'     => false,
);

if ( $button_url ) {
    $button_component_args['button_target'] = '_self';
    $button_component_args['button_rel']    = '';
}

?>
<?php $wrapper_attribute_string = function_exists( 'beyond_gotham_format_html_attributes' ) ? beyond_gotham_format_html_attributes( $wrapper_attributes ) : ''; ?>
<div<?php echo $wrapper_attribute_string; ?>>
    <div class="sticky-cta__inner">
        <div class="sticky-cta__content" data-bg-sticky-cta-content>
            <?php if ( '' !== trim( $content ) ) : ?>
                <?php echo wp_kses_post( $content ); ?>
            <?php endif; ?>
        </div>
        <?php
        if ( '' !== trim( $button_label ) || $button_url ) {
            get_template_part( 'template-parts/components/cta-content', null, $button_component_args );
        }
        ?>
        <button type="button" class="sticky-cta__close" data-bg-sticky-cta-close aria-label="<?php echo esc_attr( $close_label ); ?>">
            <span class="sticky-cta__close-icon" aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
