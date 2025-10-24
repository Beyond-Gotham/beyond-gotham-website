<?php
/**
 * Helpers for configurable post meta output.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

if ( defined( 'BEYOND_GOTHAM_POST_META_LOADED' ) ) {
    return;
}

/**
 * Guard to keep the helper set as a single source of truth when loaded from different entry points.
 */
define( 'BEYOND_GOTHAM_POST_META_LOADED', true );

if ( ! function_exists( 'beyond_gotham_get_post_meta_fields' ) ) {
    /**
     * Retrieve the supported meta fields.
     *
     * @return array
     */
    function beyond_gotham_get_post_meta_fields() {
        $fields = array(
            'date'       => array(
                'control_label'      => __( 'Datum', 'beyond_gotham' ),
                'default_order'      => 10,
                'default_visibility' => array(
                    'post'      => array( 'desktop', 'mobile' ),
                    'bg_course' => array( 'desktop', 'mobile' ),
                ),
            ),
            'author'     => array(
                'control_label'      => __( 'Autor', 'beyond_gotham' ),
                'default_order'      => 20,
                'default_visibility' => array(
                    'post'      => array( 'desktop', 'mobile' ),
                    'bg_course' => array( 'desktop', 'mobile' ),
                ),
            ),
            'categories' => array(
                'control_label'      => __( 'Kategorien', 'beyond_gotham' ),
                'default_order'      => 30,
                'default_visibility' => array(
                    'post' => array( 'desktop', 'mobile' ),
                ),
            ),
            'tags'       => array(
                'control_label'      => __( 'Tags', 'beyond_gotham' ),
                'default_order'      => 40,
                'default_visibility' => array(
                    'post' => array( 'desktop', 'mobile' ),
                ),
            ),
        );

        /**
         * Filter the meta fields available for configuration.
         *
         * @param array $fields Meta field definitions.
         */
        return apply_filters( 'beyond_gotham_post_meta_fields', $fields );
    }
}

if ( ! function_exists( 'beyond_gotham_get_post_meta_post_types' ) ) {
    /**
     * Retrieve the post types that expose configurable meta.
     *
     * @return array
     */
    function beyond_gotham_get_post_meta_post_types() {
        $post_types = array(
            'post'      => array(
                'label' => __( 'Beiträge', 'beyond_gotham' ),
            ),
            'page'      => array(
                'label' => __( 'Seiten', 'beyond_gotham' ),
            ),
            'bg_course' => array(
                'label' => __( 'Kurse (bg_course)', 'beyond_gotham' ),
            ),
        );

        /**
         * Filter the post types exposing configurable meta.
         *
         * @param array $post_types Post type configuration.
         */
        return apply_filters( 'beyond_gotham_post_meta_post_types', $post_types );
    }
}

if ( ! function_exists( 'beyond_gotham_get_post_meta_defaults' ) ) {
    /**
     * Retrieve the default visibility and order for post meta.
     *
     * @return array
     */
    function beyond_gotham_get_post_meta_defaults() {
        $fields     = beyond_gotham_get_post_meta_fields();
        $post_types = beyond_gotham_get_post_meta_post_types();

        $defaults = array();

        foreach ( $post_types as $type => $args ) {
            $defaults[ $type ] = array();

            foreach ( $fields as $key => $field ) {
                $field_defaults = array(
                    'order'        => isset( $field['default_order'] ) ? (int) $field['default_order'] : 10,
                    'show_desktop' => false,
                    'show_mobile'  => false,
                );

                if ( isset( $field['default_visibility'][ $type ] ) ) {
                    $visibility = (array) $field['default_visibility'][ $type ];
                    $field_defaults['show_desktop'] = in_array( 'desktop', $visibility, true );
                    $field_defaults['show_mobile']  = in_array( 'mobile', $visibility, true );
                }

                $defaults[ $type ][ $key ] = $field_defaults;
            }
        }

        /**
         * Filter the default post meta configuration.
         *
         * @param array $defaults Default configuration.
         */
        return apply_filters( 'beyond_gotham_post_meta_default_settings', $defaults );
    }
}

if ( ! function_exists( 'beyond_gotham_get_post_meta_settings' ) ) {
    /**
     * Retrieve the configured settings for a given post type.
     *
     * @param string $post_type Post type slug.
     * @return array
     */
    function beyond_gotham_get_post_meta_settings( $post_type ) {
        $post_type = $post_type ? sanitize_key( $post_type ) : 'post';

        $fields   = beyond_gotham_get_post_meta_fields();
        $defaults = beyond_gotham_get_post_meta_defaults();

        $settings = array();

        foreach ( $fields as $key => $field ) {
            $field_defaults = isset( $defaults[ $post_type ][ $key ] ) ? $defaults[ $post_type ][ $key ] : array(
                'order'        => isset( $field['default_order'] ) ? (int) $field['default_order'] : 10,
                'show_desktop' => false,
                'show_mobile'  => false,
            );

            $base_id = sprintf( 'beyond_gotham_meta_%s_%s', $post_type, $key );

            $settings[ $key ] = array(
                'order'        => (int) get_theme_mod( $base_id . '_order', $field_defaults['order'] ),
                'show_desktop' => (bool) get_theme_mod( $base_id . '_desktop', $field_defaults['show_desktop'] ),
                'show_mobile'  => (bool) get_theme_mod( $base_id . '_mobile', $field_defaults['show_mobile'] ),
            );
        }

        /**
         * Filter the resolved meta settings for a post type.
         *
         * @param array  $settings  Settings per meta key.
         * @param string $post_type Post type slug.
         */
        return apply_filters( 'beyond_gotham_post_meta_settings', $settings, $post_type );
    }
}

if ( ! function_exists( 'beyond_gotham_render_post_meta' ) ) {
    /**
     * Render the configured post meta for a given post.
     *
     * @param int|WP_Post|null $post Optional post object or ID. Defaults to current post in the loop.
     * @param array            $args Optional rendering arguments.
     */
    function beyond_gotham_render_post_meta( $post = null, $args = array() ) {
        $post = get_post( $post );

        if ( ! $post ) {
            return;
        }

        $defaults = array(
            'container_tag'         => 'div',
            'container_class'       => 'article-meta',
            'item_base_class'       => 'article-meta__item',
            'item_key_class_prefix' => 'article-meta__',
            'aria_label'            => '',
        );

        $args = wp_parse_args( $args, $defaults );

        $container_tag = preg_replace( '/[^a-z0-9:-]/i', '', (string) $args['container_tag'] );
        if ( '' === $container_tag ) {
            $container_tag = 'div';
        }

        $post_type     = get_post_type( $post );
        $fields        = beyond_gotham_get_post_meta_fields();
        $meta_settings = beyond_gotham_get_post_meta_settings( $post_type );

        $items = array();
        $index = 0;

        foreach ( $meta_settings as $key => $config ) {
            if ( empty( $config['show_desktop'] ) && empty( $config['show_mobile'] ) ) {
                continue;
            }

            if ( ! isset( $fields[ $key ] ) ) {
                continue;
            }

            $content = '';

            switch ( $key ) {
                case 'date':
                    $datetime = get_the_date( DATE_W3C, $post );
                    $label    = get_the_date( '', $post );

                    if ( $label ) {
                        $content = sprintf(
                            '<time datetime="%1$s">%2$s</time>',
                            esc_attr( $datetime ),
                            esc_html( $label )
                        );
                    }
                    break;
                case 'author':
                    $author_name = get_the_author_meta( 'display_name', $post->post_author );

                    if ( $author_name ) {
                        $content = sprintf(
                            /* translators: %s: post author name. */
                            esc_html__( 'Von %s', 'beyond_gotham' ),
                            sprintf(
                                '<span class="%1$s">%2$s</span>',
                                esc_attr( $args['item_key_class_prefix'] . 'author-name' ),
                                esc_html( $author_name )
                            )
                        );
                    }
                    break;
                case 'categories':
                    $categories_list = get_the_category_list( ', ', '', $post->ID );

                    if ( $categories_list ) {
                        $content = sprintf(
                            /* translators: %s: list of categories. */
                            esc_html__( 'In %s', 'beyond_gotham' ),
                            $categories_list
                        );
                    }
                    break;
                case 'tags':
                    $tags_list = get_the_tag_list( '', ', ', '', $post->ID );

                    if ( $tags_list ) {
                        $content = sprintf(
                            /* translators: %s: list of tags. */
                            esc_html__( 'Tags: %s', 'beyond_gotham' ),
                            $tags_list
                        );
                    }
                    break;
                default:
                    /**
                     * Allow rendering of custom meta fields.
                     *
                     * @param string $content Current meta content.
                     * @param array  $config  Meta configuration.
                     * @param WP_Post $post   Post object.
                     */
                    $content = apply_filters( 'beyond_gotham_render_custom_post_meta', $content, $key, $config, $post );
                    break;
            }

            if ( '' === $content ) {
                continue;
            }

            $item_classes = array();

            if ( ! empty( $args['item_base_class'] ) ) {
                $item_classes[] = sanitize_html_class( $args['item_base_class'] );
            }

            if ( ! empty( $args['item_key_class_prefix'] ) ) {
                $item_classes[] = sanitize_html_class( $args['item_key_class_prefix'] . $key );
            }

            if ( empty( $config['show_desktop'] ) ) {
                $item_classes[] = 'bg-meta--hide-desktop';
            }

            if ( empty( $config['show_mobile'] ) ) {
                $item_classes[] = 'bg-meta--hide-mobile';
            }

            $items[] = array(
                'order'           => isset( $config['order'] ) ? (int) $config['order'] : ( isset( $fields[ $key ]['default_order'] ) ? (int) $fields[ $key ]['default_order'] : 10 ),
                'fallback_order'  => isset( $fields[ $key ]['default_order'] ) ? (int) $fields[ $key ]['default_order'] : ( ++$index * 10 ),
                'html'            => sprintf(
                    '<span class="%1$s">%2$s</span>',
                    esc_attr( implode( ' ', array_filter( $item_classes ) ) ),
                    wp_kses_post( $content )
                ),
            );
        }

        if ( empty( $items ) ) {
            return;
        }

        usort(
            $items,
            function ( $a, $b ) {
                if ( $a['order'] === $b['order'] ) {
                    return $a['fallback_order'] <=> $b['fallback_order'];
                }

                return $a['order'] <=> $b['order'];
            }
        );

        $aria_attribute = '';
        if ( ! empty( $args['aria_label'] ) ) {
            $aria_attribute = ' aria-label="' . esc_attr( $args['aria_label'] ) . '"';
        }

        printf(
            '<%1$s class="%2$s"%3$s>%4$s</%1$s>',
            esc_html( strtolower( $container_tag ) ),
            esc_attr( $args['container_class'] ),
            $aria_attribute,
            implode( '', wp_list_pluck( $items, 'html' ) )
        );
    }
}
