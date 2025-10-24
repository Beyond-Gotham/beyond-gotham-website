<?php
/**
 * Post Meta Customizer Settings
 *
 * Handles post metadata display configuration (author, date, categories, tags).
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Post Meta Configuration
// =============================================================================

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
				$visibility                     = (array) $field['default_visibility'][ $type ];
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

// =============================================================================
// Customizer Registration
// =============================================================================

/**
 * Register post meta customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function beyond_gotham_register_post_meta_customizer( WP_Customize_Manager $wp_customize ) {
	// Post Meta Section
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
	$meta_defaults   = beyond_gotham_get_post_meta_defaults();
	$meta_priority   = 1;

	foreach ( $meta_post_types as $post_type => $type_args ) {
		$type_label = isset( $type_args['label'] ) ? $type_args['label'] : $post_type;

		// Add heading for post type
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

		// Add controls for each field
		foreach ( $meta_fields as $field_key => $field_config ) {
			$field_label = isset( $field_config['control_label'] ) ? $field_config['control_label'] : ucfirst( $field_key );
			$base_id     = sprintf( 'beyond_gotham_meta_%s_%s', $post_type, $field_key );

			$field_defaults = isset( $meta_defaults[ $post_type ][ $field_key ] ) ? $meta_defaults[ $post_type ][ $field_key ] : array(
				'order'        => 10,
				'show_desktop' => false,
				'show_mobile'  => false,
			);

			// Desktop Visibility
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

			// Mobile Visibility
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

			// Display Order
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

		$meta_priority += 5; // Add gap between post types
	}
}
add_action( 'customize_register', 'beyond_gotham_register_post_meta_customizer' );
