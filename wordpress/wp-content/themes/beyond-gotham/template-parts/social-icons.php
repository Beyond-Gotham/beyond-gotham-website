<?php
/**
 * Template part for rendering reusable social media icons.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'beyond_gotham_format_html_attributes' ) ) {
    require_once get_template_directory() . '/inc/helpers-html.php';
}

$args = isset( $args ) && is_array( $args ) ? $args : array();

$defaults = array(
    'links'              => null,
    'context'            => 'default',
    'modifiers'          => array(),
    'wrapper_classes'    => array(),
    'wrapper_attributes' => array(),
    'hidden'             => false,
    'aria_label'         => __( 'Social media links', 'beyond_gotham' ),
    'tag'                => 'div',
    'include_empty'      => false,
);

$args = wp_parse_args( $args, $defaults );

$links          = $args['links'];
$include_empty  = ! empty( $args['include_empty'] );

if ( null === $links && function_exists( 'beyond_gotham_get_social_links' ) ) {
    $links = beyond_gotham_get_social_links();
}

if ( ! is_array( $links ) ) {
    $links = array();
}

if ( empty( $links ) && ! $include_empty ) {
    return;
}

$links = apply_filters( 'beyond_gotham_social_icons', $links, $args );

if ( ! is_array( $links ) ) {
    $links = array();
}

if ( empty( $links ) && ! $include_empty ) {
    return;
}

$order = array_keys( $links );
$items          = function_exists( 'beyond_gotham_prepare_social_icon_items' )
    ? beyond_gotham_prepare_social_icon_items(
        $links,
        array(
            'include_empty' => $include_empty,
            'order'         => $order,
        )
    )
    : array();

if ( empty( $items ) ) {
    return;
}

$wrapper_classes = array( 'social-icons' );

if ( ! empty( $args['context'] ) && 'default' !== $args['context'] ) {
    $wrapper_classes[] = 'social-icons--' . sanitize_html_class( $args['context'] );
}

$modifiers = is_array( $args['modifiers'] ) ? $args['modifiers'] : array( $args['modifiers'] );

foreach ( $modifiers as $modifier ) {
    if ( ! is_string( $modifier ) || '' === $modifier ) {
        continue;
    }

    $wrapper_classes[] = 'social-icons--' . sanitize_html_class( $modifier );
}

$additional_classes = is_array( $args['wrapper_classes'] ) ? $args['wrapper_classes'] : array( $args['wrapper_classes'] );

foreach ( $additional_classes as $class_name ) {
    if ( ! is_string( $class_name ) || '' === $class_name ) {
        continue;
    }

    $wrapper_classes[] = $class_name;
}

$wrapper_classes = array_unique(
    array_filter(
        array_map( 'sanitize_html_class', $wrapper_classes )
    )
);

$tag = is_string( $args['tag'] ) ? strtolower( $args['tag'] ) : 'div';
$tag = preg_match( '/^[a-z0-9:-]+$/', $tag ) ? $tag : 'div';

$attributes = array(
    'class' => implode( ' ', $wrapper_classes ),
    'role'  => 'navigation',
);

if ( ! empty( $args['aria_label'] ) ) {
    $attributes['aria-label'] = $args['aria_label'];
}

if ( ! empty( $args['hidden'] ) ) {
    $attributes['hidden']      = true;
    $attributes['aria-hidden'] = 'true';
}

if ( ! empty( $args['wrapper_attributes'] ) && is_array( $args['wrapper_attributes'] ) ) {
    foreach ( $args['wrapper_attributes'] as $attr => $value ) {
        if ( '' === $attr ) {
            continue;
        }

        if ( is_bool( $value ) ) {
            if ( ! $value ) {
                continue;
            }

            $attributes[ sanitize_key( $attr ) ] = true;
            continue;
        }

        if ( null === $value ) {
            continue;
        }

        $attributes[ sanitize_key( $attr ) ] = $value;
    }
}

$attribute_string = beyond_gotham_format_html_attributes( $attributes );

if ( ! empty( $args['wrapper_attributes'] ) && is_string( $args['wrapper_attributes'] ) ) {
    $attribute_string .= beyond_gotham_format_html_attributes( $args['wrapper_attributes'] );
}

printf( '<%1$s%2$s>', esc_html( $tag ), $attribute_string );

foreach ( $items as $item ) {
    if ( ! empty( $item['is_empty'] ) ) {
        continue;
    }

    if ( empty( $item['icon'] ) || empty( $item['url'] ) ) {
        continue;
    }

    $link_attrs = array(
        'class'        => 'social-icons__link',
        'aria-label'   => $item['label'],
        'data-network' => $item['network'],
    );

    if ( empty( $item['is_empty'] ) && ! empty( $item['url'] ) ) {
        $link_attrs['href'] = esc_url( $item['url'] );

        if ( empty( $item['is_mail'] ) ) {
            $link_attrs['target'] = '_blank';
            $link_attrs['rel']    = 'noopener';
        }
    } else {
        $link_attrs['href']        = '#';
        $link_attrs['aria-hidden'] = 'true';
        $link_attrs['tabindex']    = '-1';
        $link_attrs['hidden']      = 'hidden';
    }

    $link_attribute_string = beyond_gotham_format_html_attributes( $link_attrs );

    printf( '<a%1$s>', $link_attribute_string );
    echo '<span class="social-icons__icon" aria-hidden="true">';
    echo $item['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '</span>';
    echo '<span class="screen-reader-text">' . esc_html( $item['label'] ) . '</span>';
    echo '</a>';
}

printf( '</%s>', esc_html( $tag ) );
