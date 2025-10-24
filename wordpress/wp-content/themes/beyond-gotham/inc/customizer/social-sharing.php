<?php
/**
 * Social Sharing Customizer Settings
 *
 * Handles social sharing buttons configuration and display options.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Social Sharing Defaults & Settings
// =============================================================================

/**
 * Get default social sharing settings.
 *
 * @return array
 */
function beyond_gotham_get_social_share_defaults() {
	return array(
		'display'  => array(
			'post'     => true,
			'page'     => false,
			'category' => true,
		),
		'networks' => array(
			'linkedin' => true,
			'twitter'  => true,
			'mastodon' => false,
			'facebook' => true,
			'whatsapp' => true,
			'github'   => false,
		),
	);
}

/**
 * Retrieve the current social sharing settings.
 *
 * @return array
 */
function beyond_gotham_get_social_share_settings() {
	$defaults = beyond_gotham_get_social_share_defaults();

	$settings = array(
		'display'  => array(),
		'networks' => array(),
	);

	foreach ( $defaults['display'] as $context => $default ) {
		$settings['display'][ $context ] = (bool) get_theme_mod( 'beyond_gotham_share_display_' . $context, $default );
	}

	foreach ( $defaults['networks'] as $network => $default ) {
		$settings['networks'][ $network ] = (bool) get_theme_mod( 'beyond_gotham_share_network_' . $network, $default );
	}

	/**
	 * Filter the resolved social sharing settings.
	 *
	 * @param array $settings Current social sharing settings.
	 * @param array $defaults Default social sharing settings.
	 */
	return apply_filters( 'beyond_gotham_social_share_settings', $settings, $defaults );
}

/**
 * Determine whether social sharing is enabled for a given context.
 *
 * @param string $context Content context (post, page, category, ...).
 * @return bool
 */
function beyond_gotham_is_social_sharing_enabled_for( $context ) {
	$context = is_string( $context ) ? strtolower( trim( $context ) ) : '';

	if ( '' === $context ) {
		return false;
	}

	if ( ! get_theme_mod( 'enable_social_share', true ) ) {
		return false;
	}

	$settings = beyond_gotham_get_social_share_settings();

	$enabled = ! empty( $settings['display'][ $context ] );

	/**
	 * Filter whether social sharing should be shown for a given context.
	 *
	 * @param bool   $enabled  Whether sharing is enabled.
	 * @param string $context  The evaluated context.
	 * @param array  $settings The resolved sharing settings.
	 */
	return (bool) apply_filters( 'beyond_gotham_social_share_enabled', $enabled, $context, $settings );
}

/**
 * Build share links for the enabled social networks.
 *
 * @param string $share_url   URL that should be shared.
 * @param string $share_title Title that accompanies the share.
 * @return array
 */
function beyond_gotham_build_social_share_links( $share_url, $share_title ) {
	$share_url = esc_url_raw( $share_url );

	if ( '' === $share_url ) {
		return array();
	}

	$share_title = wp_strip_all_tags( (string) $share_title );

	if ( '' === $share_title ) {
		$share_title = wp_strip_all_tags( get_bloginfo( 'name' ) );
	}

	$settings = beyond_gotham_get_social_share_settings();

	$encoded_url   = rawurlencode( $share_url );
	$encoded_title = rawurlencode( $share_title );
	$encoded_text  = rawurlencode( trim( $share_title . ' ' . $share_url ) );

	$available_networks = array(
		'linkedin' => array(
			'label' => __( 'LinkedIn', 'beyond_gotham' ),
			'icon'  => 'in',
		),
		'twitter'  => array(
			'label' => __( 'X (Twitter)', 'beyond_gotham' ),
			'icon'  => 'x',
		),
		'mastodon' => array(
			'label' => __( 'Mastodon', 'beyond_gotham' ),
			'icon'  => 'M',
		),
		'facebook' => array(
			'label' => __( 'Facebook', 'beyond_gotham' ),
			'icon'  => 'f',
		),
		'whatsapp' => array(
			'label' => __( 'WhatsApp', 'beyond_gotham' ),
			'icon'  => 'WA',
		),
		'github'   => array(
			'label' => __( 'GitHub', 'beyond_gotham' ),
			'icon'  => 'GH',
		),
	);

	$links = array();

	foreach ( $available_networks as $network_key => $network ) {
		if ( empty( $settings['networks'][ $network_key ] ) ) {
			continue;
		}

		$url = '';

		switch ( $network_key ) {
			case 'linkedin':
				$url = sprintf( 'https://www.linkedin.com/shareArticle?mini=1&url=%1$s&title=%2$s', $encoded_url, $encoded_title );
				break;
			case 'twitter':
				$url = sprintf( 'https://twitter.com/intent/tweet?url=%1$s&text=%2$s', $encoded_url, $encoded_title );
				break;
			case 'mastodon':
				$url = sprintf( 'https://mastodonshare.com/?text=%s', $encoded_text );
				break;
			case 'facebook':
				$url = sprintf( 'https://www.facebook.com/sharer/sharer.php?u=%s', $encoded_url );
				break;
			case 'whatsapp':
				$url = sprintf( 'https://api.whatsapp.com/send?text=%s', $encoded_text );
				break;
			case 'github':
				$url = sprintf( 'https://github.com/search?q=%s&type=discussions', $encoded_url );
				break;
		}

		if ( '' === $url ) {
			continue;
		}

		$network['key']        = $network_key;
		$network['url']        = $url;
		$network['aria_label'] = sprintf( __( 'Auf %s teilen', 'beyond_gotham' ), $network['label'] );

		$links[] = $network;
	}

	/**
	 * Filter the generated social share links.
	 *
	 * @param array  $links       Share links prepared for output.
	 * @param string $share_url   The URL that should be shared.
	 * @param string $share_title The title associated with the share.
	 * @param array  $settings    The resolved sharing settings.
	 */
	return apply_filters( 'beyond_gotham_social_share_links', $links, $share_url, $share_title, $settings );
}

// =============================================================================
// Customizer Registration
// =============================================================================

/**
 * Register social sharing customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function beyond_gotham_register_social_sharing_customizer( WP_Customize_Manager $wp_customize ) {
	$share_defaults = beyond_gotham_get_social_share_defaults();

	// Social Sharing Section
	$wp_customize->add_section(
		'beyond_gotham_social_sharing',
		array(
			'title'       => __( 'Social Sharing', 'beyond_gotham' ),
			'priority'    => 92,
			'description' => __( 'Konfiguriere die Share-Buttons für Social Media.', 'beyond_gotham' ),
		)
	);

	// Global Enable Toggle
	$wp_customize->add_setting(
		'enable_social_share',
		array(
			'default'           => true,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'enable_social_share_control',
		array(
			'label'    => __( 'Social Sharing aktivieren', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_social_sharing',
			'settings' => 'enable_social_share',
			'type'     => 'checkbox',
			'priority' => 5,
		)
	);

	// Display Context Heading
	if ( class_exists( 'Beyond_Gotham_Customize_Heading_Control' ) ) {
		$wp_customize->add_control(
			new Beyond_Gotham_Customize_Heading_Control(
				$wp_customize,
				'beyond_gotham_social_share_display_heading',
				array(
					'label'       => __( 'Social-Share-Leiste anzeigen bei …', 'beyond_gotham' ),
					'section'     => 'beyond_gotham_social_sharing',
					'priority'    => 10,
					'description' => __( 'Wähle die Inhaltstypen aus, für die die Sharing-Leiste eingeblendet wird.', 'beyond_gotham' ),
				)
			)
		);
	}

	// Display Context Controls
	$share_display_choices = array(
		'post'     => __( 'Blog-Artikeln', 'beyond_gotham' ),
		'category' => __( 'Dossiers, Reportagen & Interviews (Kategorien)', 'beyond_gotham' ),
		'page'     => __( 'Seiten', 'beyond_gotham' ),
	);

	$display_priority = 11;
	foreach ( $share_display_choices as $context => $label ) {
		$setting_id = 'beyond_gotham_share_display_' . $context;

		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => isset( $share_defaults['display'][ $context ] ) ? $share_defaults['display'][ $context ] : false,
				'type'              => 'theme_mod',
				'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			$setting_id,
			array(
				'label'    => $label,
				'section'  => 'beyond_gotham_social_sharing',
				'type'     => 'checkbox',
				'priority' => $display_priority,
			)
		);

		++$display_priority;
	}

	// Networks Heading
	if ( class_exists( 'Beyond_Gotham_Customize_Heading_Control' ) ) {
		$wp_customize->add_control(
			new Beyond_Gotham_Customize_Heading_Control(
				$wp_customize,
				'beyond_gotham_social_share_networks_heading',
				array(
					'label'       => __( 'Aktive Netzwerke', 'beyond_gotham' ),
					'section'     => 'beyond_gotham_social_sharing',
					'priority'    => 30,
					'description' => __( 'Schalte einzelne Netzwerke für die Sharing-Leiste ein oder aus.', 'beyond_gotham' ),
				)
			)
		);
	}

	// Network Controls
	$share_network_labels = array(
		'linkedin' => __( 'LinkedIn', 'beyond_gotham' ),
		'twitter'  => __( 'X (Twitter)', 'beyond_gotham' ),
		'mastodon' => __( 'Mastodon', 'beyond_gotham' ),
		'facebook' => __( 'Facebook', 'beyond_gotham' ),
		'whatsapp' => __( 'WhatsApp', 'beyond_gotham' ),
		'github'   => __( 'GitHub', 'beyond_gotham' ),
	);

	$network_priority = 31;
	foreach ( $share_network_labels as $network => $label ) {
		$setting_id = 'beyond_gotham_share_network_' . $network;

		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => isset( $share_defaults['networks'][ $network ] ) ? $share_defaults['networks'][ $network ] : false,
				'type'              => 'theme_mod',
				'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			$setting_id,
			array(
				'label'    => $label,
				'section'  => 'beyond_gotham_social_sharing',
				'type'     => 'checkbox',
				'priority' => $network_priority,
			)
		);

		++$network_priority;
	}
}
add_action( 'customize_register', 'beyond_gotham_register_social_sharing_customizer' );
