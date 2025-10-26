<?php
/**
 * Customizer module binding for post meta visibility settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Registers post meta controls with the customizer.
 */
class Beyond_Gotham_Customizer_Module_Post_Meta extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'post-meta';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 55;
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        if ( ! function_exists( 'beyond_gotham_get_post_meta_fields' ) || ! function_exists( 'beyond_gotham_get_post_meta_post_types' ) ) {
            if ( function_exists( '_doing_it_wrong' ) ) {
                _doing_it_wrong(
                    __METHOD__,
                    __( 'Post meta helpers must be loaded before registering the customizer module.', 'beyond_gotham' ),
                    defined( 'BEYOND_GOTHAM_VERSION' ) ? BEYOND_GOTHAM_VERSION : '0.1.0'
                );
            }

            return;
        }

        $wp_customize->add_section(
            'post_meta_settings',
            array(
                'title'       => __( 'Beitragsmetadaten', 'beyond_gotham' ),
                'priority'    => 55,
                'description' => __( 'Wähle für jeden Inhaltstyp aus, welche Metadaten sichtbar sind. Die Reihenfolge wird über die Priorität gesteuert (kleinere Zahlen erscheinen zuerst).', 'beyond_gotham' ),
            )
        );

        $meta_post_types = beyond_gotham_get_post_meta_post_types();
        $meta_fields     = beyond_gotham_get_post_meta_fields();
        $meta_defaults   = function_exists( 'beyond_gotham_get_post_meta_defaults' ) ? beyond_gotham_get_post_meta_defaults() : array();
        $meta_priority   = 1;

        foreach ( $meta_post_types as $post_type => $type_args ) {
            $type_label = isset( $type_args['label'] ) ? $type_args['label'] : $post_type;

            if ( class_exists( 'Beyond_Gotham_Customize_Heading_Control' ) ) {
                $wp_customize->add_control(
                    new Beyond_Gotham_Customize_Heading_Control(
                        $wp_customize,
                        'beyond_gotham_meta_heading_' . $post_type,
                        array(
                            'section'  => 'post_meta_settings',
                            'label'    => $type_label,
                            'priority' => $meta_priority,
                        )
                    )
                );

                ++$meta_priority;
            }

            foreach ( $meta_fields as $field_key => $field_config ) {
                $field_label = isset( $field_config['control_label'] ) ? $field_config['control_label'] : ucfirst( $field_key );
                $base_id     = sprintf( 'beyond_gotham_meta_%s_%s', $post_type, $field_key );

                $field_defaults = isset( $meta_defaults[ $post_type ][ $field_key ] ) ? $meta_defaults[ $post_type ][ $field_key ] : array(
                    'order'        => 10,
                    'show_desktop' => false,
                    'show_mobile'  => false,
                );

                $wp_customize->add_setting(
                    $base_id . '_desktop',
                    array(
                        'default'           => $field_defaults['show_desktop'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                    )
                );

                $wp_customize->add_control(
                    $base_id . '_desktop_control',
                    array(
                        'label'       => sprintf( __( '%s (Desktop)', 'beyond_gotham' ), $field_label ),
                        'section'     => 'post_meta_settings',
                        'settings'    => $base_id . '_desktop',
                        'type'        => 'checkbox',
                        'priority'    => $meta_priority,
                    )
                );

                ++$meta_priority;

                $wp_customize->add_setting(
                    $base_id . '_mobile',
                    array(
                        'default'           => $field_defaults['show_mobile'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                    )
                );

                $wp_customize->add_control(
                    $base_id . '_mobile_control',
                    array(
                        'label'       => sprintf( __( '%s (Mobil)', 'beyond_gotham' ), $field_label ),
                        'section'     => 'post_meta_settings',
                        'settings'    => $base_id . '_mobile',
                        'type'        => 'checkbox',
                        'priority'    => $meta_priority,
                    )
                );

                ++$meta_priority;

                $wp_customize->add_setting(
                    $base_id . '_order',
                    array(
                        'default'           => $field_defaults['order'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'absint',
                    )
                );

                $wp_customize->add_control(
                    $base_id . '_order_control',
                    array(
                        'label'       => sprintf( __( '%s – Priorität', 'beyond_gotham' ), $field_label ),
                        'section'     => 'post_meta_settings',
                        'settings'    => $base_id . '_order',
                        'type'        => 'number',
                        'description' => __( 'Niedrigere Zahlen erscheinen zuerst.', 'beyond_gotham' ),
                        'input_attrs' => array(
                            'min'  => 1,
                            'max'  => 100,
                            'step' => 1,
                        ),
                        'priority'    => $meta_priority,
                    )
                );

                ++$meta_priority;
            }

            $meta_priority += 5;
        }
    }
}
