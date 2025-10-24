<?php
/**
 * Post Meta Customizer Settings
 *
 * Handles post metadata display configuration (author, date, categories, tags).
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// Ensure the shared post meta helpers are available without redeclaring them.
if ( ! defined( 'BEYOND_GOTHAM_POST_META_LOADED' ) ) {
        require_once get_template_directory() . '/inc/post-meta.php';
}

// The customizer module consumes the helpers from inc/post-meta.php. Additional fields should
// be registered via the `beyond_gotham_post_meta_fields` filter instead of redefining the helpers.

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
