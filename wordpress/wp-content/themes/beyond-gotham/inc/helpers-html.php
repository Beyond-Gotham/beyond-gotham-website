<?php
/**
 * HTML attribute helpers.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'beyond_gotham_format_html_attributes' ) ) {
    /**
     * Convert an associative array of attributes into an HTML attribute string.
     *
     * Boolean attributes (true) are rendered as the attribute name only. Falsey values
     * are omitted. Numeric keys are treated as attribute names with a boolean value.
     *
     * @param array|string $attributes   Attribute definitions.
     * @param bool         $leading_space Whether to prefix the returned string with a space.
     * @return string
     */
    function beyond_gotham_format_html_attributes( $attributes, $leading_space = true ) {
        if ( empty( $attributes ) && '0' !== $attributes ) {
            return '';
        }

        if ( is_string( $attributes ) ) {
            $attributes = trim( $attributes );

            if ( '' === $attributes ) {
                return '';
            }

            return $leading_space ? ' ' . $attributes : $attributes;
        }

        if ( ! is_array( $attributes ) ) {
            return '';
        }

        $chunks = array();

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

            if ( is_bool( $value ) ) {
                if ( $value ) {
                    $chunks[] = esc_attr( strtolower( $name ) );
                }
                continue;
            }

            if ( null === $value ) {
                continue;
            }

            if ( is_array( $value ) ) {
                $value = implode( ' ', array_filter( array_map( 'trim', $value ) ) );
            }

            $value = trim( (string) $value );

            if ( '' === $value ) {
                continue;
            }

            $chunks[] = sprintf( '%s="%s"', esc_attr( strtolower( $name ) ), esc_attr( $value ) );
        }

        if ( empty( $chunks ) ) {
            return '';
        }

        $compiled = implode( ' ', $chunks );

        return $leading_space ? ' ' . $compiled : $compiled;
    }
}
