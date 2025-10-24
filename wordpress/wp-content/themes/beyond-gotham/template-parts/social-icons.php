<?php
/**
 * Template part for rendering reusable social media icons.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
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
);

$args = wp_parse_args( $args, $defaults );

$links = $args['links'];

if ( null === $links && function_exists( 'beyond_gotham_get_social_links' ) ) {
    $links = beyond_gotham_get_social_links();
}

if ( empty( $links ) || ! is_array( $links ) ) {
    return;
}

$links = apply_filters( 'beyond_gotham_social_icons', $links, $args );

if ( empty( $links ) || ! is_array( $links ) ) {
    return;
}

$icons = function_exists( 'beyond_gotham_get_social_icon_svgs' ) ? beyond_gotham_get_social_icon_svgs() : array();

if ( empty( $icons ) || ! is_array( $icons ) ) {
    return;
}

$labels = array(
    'github'   => __( 'GitHub', 'beyond_gotham' ),
    'linkedin' => __( 'LinkedIn', 'beyond_gotham' ),
    'mastodon' => __( 'Mastodon', 'beyond_gotham' ),
    'twitter'  => __( 'X (Twitter)', 'beyond_gotham' ),
    'facebook' => __( 'Facebook', 'beyond_gotham' ),
    'instagram' => __( 'Instagram', 'beyond_gotham' ),
    'tiktok'    => __( 'TikTok', 'beyond_gotham' ),
    'youtube'   => __( 'YouTube', 'beyond_gotham' ),
    'telegram'  => __( 'Telegram', 'beyond_gotham' ),
    'email'    => __( 'E-Mail', 'beyond_gotham' ),
);

$items = array();

foreach ( $links as $network => $url ) {
    if ( empty( $url ) ) {
        continue;
    }

    $slug = $network;

    if ( function_exists( 'beyond_gotham_detect_social_network' ) ) {
        $detected = beyond_gotham_detect_social_network( $url );
        if ( $detected ) {
            $slug = $detected;
        }
    }

    if ( ! isset( $icons[ $slug ] ) ) {
        continue;
    }

    $label_key = isset( $labels[ $slug ] ) ? $slug : $network;
    $label     = isset( $labels[ $label_key ] ) ? $labels[ $label_key ] : ucfirst( $label_key );
    $is_mail   = 0 === strpos( $url, 'mailto:' );

    $items[] = array(
        'url'    => $url,
        'slug'   => $slug,
        'label'  => $label,
        'is_mail'=> $is_mail,
    );
}

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

$extra_attribute_string = '';

if ( ! empty( $args['wrapper_attributes'] ) ) {
    if ( is_string( $args['wrapper_attributes'] ) ) {
        $extra_attribute_string = ' ' . trim( $args['wrapper_attributes'] );
    } elseif ( is_array( $args['wrapper_attributes'] ) ) {
        foreach ( $args['wrapper_attributes'] as $attr => $value ) {
            if ( '' === $attr ) {
                continue;
            }

            $attr = sanitize_key( $attr );

            if ( is_bool( $value ) ) {
                if ( ! $value ) {
                    continue;
                }

                $attributes[ $attr ] = true;
                continue;
            }

            if ( null === $value ) {
                continue;
            }

            $attributes[ $attr ] = $value;
        }
    }
}

$attribute_chunks = array();

foreach ( $attributes as $attr => $value ) {
    if ( true === $value ) {
        $attribute_chunks[] = esc_attr( $attr );
        continue;
    }

    if ( '' === $value ) {
        continue;
    }

    $attribute_chunks[] = sprintf( '%s="%s"', esc_attr( $attr ), esc_attr( $value ) );
}

$attribute_string = '';

if ( ! empty( $attribute_chunks ) ) {
    $attribute_string = ' ' . implode( ' ', $attribute_chunks );
}

if ( $extra_attribute_string ) {
    $attribute_string .= $extra_attribute_string;
}

printf( '<%1$s%2$s>', esc_html( $tag ), $attribute_string );

foreach ( $items as $item ) {
    $link_attrs = array(
        'href'         => $item['url'],
        'class'        => 'social-icons__link',
        'aria-label'   => $item['label'],
        'data-network' => $item['slug'],
    );

    if ( ! $item['is_mail'] ) {
        $link_attrs['target'] = '_blank';
        $link_attrs['rel']    = 'noopener';
    }

    $link_attribute_parts = array();

    foreach ( $link_attrs as $attr => $value ) {
        if ( '' === $value ) {
            continue;
        }

        if ( 'href' === $attr ) {
            $value = esc_url( $value );
        }

        $link_attribute_parts[] = sprintf( '%s="%s"', esc_attr( $attr ), esc_attr( $value ) );
    }

    printf( '<a %s>', implode( ' ', $link_attribute_parts ) );
    echo '<span class="social-icons__icon" aria-hidden="true">';
    echo $icons[ $item['slug'] ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '</span>';
    echo '<span class="screen-reader-text">' . esc_html( $item['label'] ) . '</span>';
    echo '</a>';
}

printf( '</%s>', esc_html( $tag ) );
