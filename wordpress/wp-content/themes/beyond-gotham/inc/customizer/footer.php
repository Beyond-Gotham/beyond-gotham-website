<?php
/**
 * Footer Customizer Settings
 *
 * Handles footer text and footer menu configuration.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Footer Settings
// =============================================================================

/**
 * Provide a consistent accessor for the footer text theme mod.
 *
 * @return string
 */
function beyond_gotham_get_footer_text() {
        $text = get_theme_mod( 'beyond_gotham_footer_text', sprintf( '© Beyond Gotham %s', esc_html( date_i18n( 'Y' ) ) ) );

        return wp_kses_post( $text );
}

/**
 * Get the allowed footer menu alignment keys.
 *
 * @return string[]
 */
function beyond_gotham_get_footer_menu_alignment_choices() {
        return array( 'left', 'center', 'right', 'justify' );
}

/**
 * Sanitize the footer menu alignment option.
 *
 * @param string $value Raw alignment value.
 * @return string
 */
function beyond_gotham_sanitize_footer_menu_alignment( $value ) {
        $value    = is_string( $value ) ? strtolower( trim( $value ) ) : '';
        $allowed  = beyond_gotham_get_footer_menu_alignment_choices();
        $fallback = 'center';

        if ( in_array( $value, $allowed, true ) ) {
                return $value;
        }

        return $fallback;
}

/**
 * Retrieve the current footer menu alignment.
 *
 * @return string
 */
function beyond_gotham_get_footer_menu_alignment() {
        $value = get_theme_mod( 'beyond_gotham_footer_menu_alignment', 'center' );

        return beyond_gotham_sanitize_footer_menu_alignment( $value );
}

// =============================================================================
// Customizer Registration
// =============================================================================

/**
 * Register footer customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function beyond_gotham_register_footer_customizer( WP_Customize_Manager $wp_customize ) {
	// Footer Section
	$wp_customize->add_section(
		'beyond_gotham_footer',
		array(
			'title'       => __( 'Footer', 'beyond_gotham' ),
			'priority'    => 90,
			'description' => __( 'Gestalte Copyright- und Footer-Informationen.', 'beyond_gotham' ),
		)
	);

	// Footer Text
	$wp_customize->add_setting(
		'beyond_gotham_footer_text',
		array(
			'default'           => sprintf( '© Beyond Gotham %s', esc_html( date_i18n( 'Y' ) ) ),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_footer_text_control',
		array(
			'label'       => __( 'Footer-Text', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_footer',
			'settings'    => 'beyond_gotham_footer_text',
			'type'        => 'textarea',
			'description' => __( 'Unterstützt einfachen Text sowie Links (HTML).', 'beyond_gotham' ),
		)
	);

        // Footer Menu Location Control
        if ( isset( $wp_customize->nav_menus ) && class_exists( 'WP_Customize_Nav_Menu_Location_Control' ) ) {
                $wp_customize->add_control(
                        new WP_Customize_Nav_Menu_Location_Control(
                                $wp_customize,
                                'beyond_gotham_footer_menu_location',
                                array(
					'label'         => __( 'Footer-Menü auswählen', 'beyond_gotham' ),
					'section'       => 'beyond_gotham_footer',
					'menu_location' => 'footer',
					'settings'      => 'nav_menu_locations[footer]',
					'description'   => __( 'Ordne ein bestehendes Menü dem Footer zu.', 'beyond_gotham' ),
				)
                        )
                );
        }

        $wp_customize->add_setting(
                'beyond_gotham_footer_menu_alignment',
                array(
                        'default'           => 'center',
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_footer_menu_alignment',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_footer_menu_alignment_control',
                array(
                        'label'       => __( 'Footer-Menü Ausrichtung', 'beyond_gotham' ),
                        'section'     => 'beyond_gotham_footer',
                        'settings'    => 'beyond_gotham_footer_menu_alignment',
                        'type'        => 'radio',
                        'choices'     => array(
                                'left'    => __( 'Links', 'beyond_gotham' ),
                                'center'  => __( 'Mitte', 'beyond_gotham' ),
                                'right'   => __( 'Rechts', 'beyond_gotham' ),
                                'justify' => __( 'Verteilt', 'beyond_gotham' ),
                        ),
                        'description' => __( 'Steuert die horizontale Ausrichtung des Footer-Menüs.', 'beyond_gotham' ),
                )
        );
}
