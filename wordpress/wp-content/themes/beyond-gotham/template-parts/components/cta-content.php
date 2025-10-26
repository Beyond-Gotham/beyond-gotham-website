<?php
/**
 * Reusable CTA content component.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
        exit;
}

$args = isset( $args ) && is_array( $args ) ? $args : array();

$defaults = array(
        'variant'           => 'cta',
        'title'             => '',
        'title_tag'         => 'h2',
        'title_class'       => 'cta__title',
        'title_attributes'  => array(),
        'text'              => '',
        'text_class'        => 'cta__lead',
        'text_attributes'   => array(),
        'button_label'      => '',
        'button_url'        => '',
        'button_class'      => 'bg-button bg-button--primary',
        'button_attributes' => array(),
        'button_target'     => '',
        'button_rel'        => 'noopener',
        'render_social'     => false,
        'social_args'       => array(),
        'after_content'     => '',
);

$data = wp_parse_args( $args, $defaults );

$format_attributes = static function ( $attributes ) {
        if ( empty( $attributes ) || ! is_array( $attributes ) ) {
                return '';
        }

        $parts = array();

        foreach ( $attributes as $name => $value ) {
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
                        $parts[] = esc_attr( strtolower( $name ) );
                        continue;
                }

                if ( false === $value || null === $value || '' === $value ) {
                        continue;
                }

                $parts[] = sprintf( '%s="%s"', esc_attr( strtolower( $name ) ), esc_attr( $value ) );
        }

        return $parts ? ' ' . implode( ' ', $parts ) : '';
};

$variant = in_array( $data['variant'], array( 'cta', 'newsletter' ), true ) ? $data['variant'] : 'cta';
$title   = is_string( $data['title'] ) ? trim( $data['title'] ) : '';
$text    = is_string( $data['text'] ) ? $data['text'] : '';

$title_tag = is_string( $data['title_tag'] ) && preg_match( '/^h[1-6]$/', strtolower( $data['title_tag'] ) ) ? strtolower( $data['title_tag'] ) : 'h2';

$title_attributes = array_merge(
        array(
                'class' => $data['title_class'],
        ),
        is_array( $data['title_attributes'] ) ? $data['title_attributes'] : array()
);

$text_attributes = array_merge(
        array(
                'class' => $data['text_class'],
        ),
        is_array( $data['text_attributes'] ) ? $data['text_attributes'] : array()
);

$button_label = is_string( $data['button_label'] ) ? trim( $data['button_label'] ) : '';
$button_url   = is_string( $data['button_url'] ) ? trim( $data['button_url'] ) : '';

$button_attributes = array_merge(
        array(
                'class' => $data['button_class'],
        ),
        is_array( $data['button_attributes'] ) ? $data['button_attributes'] : array()
);

if ( $button_url ) {
        $button_attributes['href'] = esc_url( $button_url );

        $is_mail_link = 0 === strpos( $button_url, 'mailto:' );

        if ( $data['button_target'] ) {
                $button_attributes['target'] = $data['button_target'];
        } elseif ( ! $is_mail_link ) {
                $button_attributes['target'] = '_blank';
        }

        if ( ! $is_mail_link ) {
                if ( $data['button_rel'] ) {
                        $button_attributes['rel'] = $data['button_rel'];
                } else {
                        $button_attributes['rel'] = 'noopener';
                }
        } else {
                unset( $button_attributes['target'], $button_attributes['rel'] );
        }
} else {
        $button_attributes['aria-disabled'] = 'true';
        $button_attributes['role']          = 'link';
}

$render_title = ( 'newsletter' === $variant && '' !== $title ) || ( 'cta' === $variant && '' !== $title );
$render_text  = '' !== trim( wp_strip_all_tags( $text ) );
$render_button = '' !== $button_label;

if ( 'newsletter' === $variant ) {
        echo '<div class="newsletter__content">';

        if ( $render_title ) {
                printf( '<%1$s%2$s>%3$s</%1$s>', esc_html( $title_tag ), $format_attributes( $title_attributes ), esc_html( $title ) );
        }

        if ( $render_text ) {
                printf( '<p%1$s>%2$s</p>', $format_attributes( $text_attributes ), wp_kses_post( $text ) );
        }

        echo '</div>';
        echo '<div class="newsletter__form newsletter__actions">';

        if ( $render_button ) {
                printf( '<a%1$s>%2$s</a>', $format_attributes( $button_attributes ), esc_html( $button_label ) );
        }

        if ( ! empty( $data['after_content'] ) ) {
                echo $data['after_content']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }

        echo '</div>';

        return;
}

if ( $render_title ) {
        printf( '<%1$s%2$s>%3$s</%1$s>', esc_html( $title_tag ), $format_attributes( $title_attributes ), esc_html( $title ) );
}

if ( $render_text ) {
        printf( '<p%1$s>%2$s</p>', $format_attributes( $text_attributes ), wp_kses_post( $text ) );
}

if ( $render_button ) {
        printf( '<a%1$s>%2$s</a>', $format_attributes( $button_attributes ), esc_html( $button_label ) );
}

if ( $data['render_social'] ) {
        get_template_part( 'template-parts/social-icons', null, $data['social_args'] );
}

if ( ! empty( $data['after_content'] ) ) {
        echo $data['after_content']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
