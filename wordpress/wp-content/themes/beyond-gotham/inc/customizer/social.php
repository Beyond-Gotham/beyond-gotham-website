<?php
/**
 * Social Media Customizer Settings
 *
 * Handles social media links, socialbar display options, and social icon rendering.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Social Links & Settings
// =============================================================================

/**
 * Retrieve configured social links as a keyed array.
 *
 * @return array
 */
function beyond_gotham_get_social_links() {
        $networks = array(
                'github',
                'linkedin',
                'mastodon',
		'twitter',
		'facebook',
		'instagram',
		'tiktok',
		'youtube',
		'telegram',
		'email',
	);

	$links = array();

	foreach ( $networks as $network ) {
		$value = get_theme_mod( 'beyond_gotham_social_' . $network );

		if ( 'email' === $network ) {
			$value = beyond_gotham_sanitize_optional_email( $value );
			if ( $value ) {
				$links[ $network ] = 'mailto:' . $value;
			}
		} else {
			$value = beyond_gotham_sanitize_optional_url( $value );
			if ( $value ) {
				$links[ $network ] = $value;
			}
		}
	}

	/**
	 * Filter the configured social links.
	 *
	 * @param array $links Social network links.
	 */
        return apply_filters( 'beyond_gotham_social_links', $links );
}

/**
 * Retrieve available socialbar variant choices.
 *
 * @return string[]
 */
function beyond_gotham_get_socialbar_variant_choices() {
        return array( 'minimal', 'boxed', 'pill', 'labelled' );
}

/**
 * Retrieve available icon style choices for the socialbar.
 *
 * @return string[]
 */
function beyond_gotham_get_socialbar_icon_style_choices() {
        return array( 'default', 'monochrom', 'farbig', 'invertiert' );
}

/**
 * Retrieve color keys used for socialbar variants.
 *
 * @return string[]
 */
function beyond_gotham_get_socialbar_color_types() {
        return array( 'background', 'hover', 'icon' );
}

/**
 * Sanitize socialbar variant selection.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_socialbar_variant( $value ) {
        $value    = is_string( $value ) ? strtolower( trim( $value ) ) : '';
        $allowed  = beyond_gotham_get_socialbar_variant_choices();

        if ( 'default' === $value ) {
                $value = 'minimal';
        }

        if ( in_array( $value, $allowed, true ) ) {
                return $value;
        }

        return 'minimal';
}

/**
 * Sanitize socialbar icon style selection.
 *
 * @param string $value Raw value.
 * @return string
 */
function beyond_gotham_sanitize_socialbar_icon_style( $value ) {
        $value   = is_string( $value ) ? strtolower( trim( $value ) ) : '';
        $allowed = beyond_gotham_get_socialbar_icon_style_choices();

        if ( in_array( $value, $allowed, true ) ) {
                return $value;
        }

        return 'default';
}

/**
 * Get socialbar display settings.
 *
 * @return array
 */
function beyond_gotham_get_socialbar_settings() {
        $variant_mod = get_theme_mod( 'beyond_gotham_socialbar_style_variant', null );

        if ( null === $variant_mod ) {
                $variant_mod = get_theme_mod( 'beyond_gotham_socialbar_style', 'minimal' );
        }

        $icon_style = beyond_gotham_sanitize_socialbar_icon_style( get_theme_mod( 'beyond_gotham_socialbar_icon_style', 'default' ) );
        $variant    = beyond_gotham_sanitize_socialbar_variant( $variant_mod );

        $surface_background = sanitize_hex_color( get_theme_mod( 'beyond_gotham_socialbar_background_color' ) );
        $surface_icon       = sanitize_hex_color( get_theme_mod( 'beyond_gotham_socialbar_icon_color' ) );

        $variant_colors = array();
        foreach ( beyond_gotham_get_socialbar_variant_choices() as $variant_key ) {
                foreach ( beyond_gotham_get_socialbar_color_types() as $type ) {
                        $option_id = 'beyond_gotham_socialbar_' . $variant_key . '_' . $type . '_color';
                        $color     = sanitize_hex_color( get_theme_mod( $option_id ) );

                        $variant_colors[ $variant_key ][ $type ] = $color ? $color : '';
                }
        }

        return array(
                'show_header'    => (bool) get_theme_mod( 'beyond_gotham_show_socialbar_header', false ),
                'show_mobile'    => (bool) get_theme_mod( 'beyond_gotham_show_socialbar_mobile', true ),
                'icon_style'     => $icon_style,
                'style_variant'  => $variant,
                'surface'        => array(
                        'background' => $surface_background ? $surface_background : '',
                        'icon'       => $surface_icon ? $surface_icon : '',
                ),
                'variants'       => $variant_colors,
        );
}

/**
 * Get social icon SVGs.
 *
 * @return array
 */
function beyond_gotham_get_social_icon_svgs() {
	return array(
		'github'    => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.17 6.839 9.49.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.463-1.11-1.463-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.578 9.578 0 0112 6.836c.85.004 1.705.114 2.504.336 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C19.138 20.167 22 16.418 22 12c0-5.523-4.477-10-10-10z"/></svg>',
		'linkedin'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14m-.5 15.5v-5.3a3.26 3.26 0 00-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 011.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 001.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 00-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>',
		'mastodon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M21.327 8.566c0-4.339-2.843-5.61-2.843-5.61-1.433-.658-3.894-.935-6.451-.956h-.063c-2.557.021-5.016.298-6.45.956 0 0-2.843 1.272-2.843 5.61 0 .993-.019 2.181.012 3.441.103 4.243.778 8.425 4.701 9.463 1.809.479 3.362.579 4.612.51 2.268-.126 3.541-.809 3.541-.809l-.075-1.646s-1.621.511-3.441.449c-1.804-.062-3.707-.194-3.999-2.409a4.523 4.523 0 01-.04-.621s1.77.433 4.014.536c1.372.063 2.658-.08 3.965-.236 2.506-.299 4.688-1.843 4.962-3.254.434-2.223.398-5.424.398-5.424zm-3.353 5.59h-2.081V9.057c0-1.075-.452-1.62-1.357-1.62-1 0-1.501.647-1.501 1.927v2.791h-2.069V9.364c0-1.28-.501-1.927-1.502-1.927-.905 0-1.357.546-1.357 1.62v5.099H6.026V8.903c0-1.074.273-1.927.823-2.558.566-.631 1.307-.955 2.228-.955 1.065 0 1.872.409 2.405 1.228l.518.869.519-.869c.533-.819 1.34-1.228 2.405-1.228.92 0 1.662.324 2.228.955.549.631.822 1.484.822 2.558v5.253z"/></svg>',
		'twitter'   => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
		'facebook'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
		'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 01-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 017.8 2m-.2 2A3.6 3.6 0 004 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 003.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.25 1.25 0 011.25 1.25A1.25 1.25 0 0117.25 8 1.25 1.25 0 0116 6.75a1.25 1.25 0 011.25-1.25M12 7a5 5 0 015 5 5 5 0 01-5 5 5 5 0 01-5-5 5 5 0 015-5m0 2a3 3 0 00-3 3 3 3 0 003 3 3 3 0 003-3 3 3 0 00-3-3z"/></svg>',
		'tiktok'    => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/></svg>',
		'youtube'   => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M10 15l5.19-3L10 9v6m11.56-7.83c.13.47.22 1.1.28 1.9.07.8.1 1.49.1 2.09L22 12c0 2.19-.16 3.8-.44 4.83-.25.9-.83 1.48-1.73 1.73-.47.13-1.33.22-2.65.28-1.3.07-2.49.1-3.59.1L12 19c-4.19 0-6.8-.16-7.83-.44-.9-.25-1.48-.83-1.73-1.73-.13-.47-.22-1.1-.28-1.9-.07-.8-.1-1.49-.1-2.09L2 12c0-2.19.16-3.8.44-4.83.25-.9.83-1.48 1.73-1.73.47-.13 1.33-.22 2.65-.28 1.3-.07 2.49-.1 3.59-.1L12 5c4.19 0 6.8.16 7.83.44.9.25 1.48.83 1.73 1.73z"/></svg>',
		'telegram'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M9.78 18.65l.28-4.23 7.68-6.92c.34-.31-.07-.46-.52-.19L7.74 13.3 3.64 12c-.88-.25-.89-.86.2-1.3l15.97-6.16c.73-.33 1.43.18 1.15 1.3l-2.72 12.81c-.19.91-.74 1.13-1.5.71L12.6 16.3l-1.99 1.93c-.23.23-.42.42-.83.42z"/></svg>',
		'email'     => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>',
	);
}

// =============================================================================
// Rendering Functions
// =============================================================================

/**
 * Render the social bar markup for the requested location.
 *
 * @param string $location Social bar location. Accepts 'header' or 'mobile'.
 */
function beyond_gotham_render_socialbar( $location = 'header' ) {
        static $rendered_locations = array();

	$allowed_locations = array( 'header', 'mobile' );

	if ( ! in_array( $location, $allowed_locations, true ) ) {
		$location = 'header';
	}

	if ( isset( $rendered_locations[ $location ] ) ) {
		return;
	}

	$links    = beyond_gotham_get_social_links();
	$settings = beyond_gotham_get_socialbar_settings();

        $is_preview       = function_exists( 'is_customize_preview' ) && is_customize_preview();
        $location_enabled = array(
                'header' => ! empty( $settings['show_header'] ),
                'mobile' => ! empty( $settings['show_mobile'] ),
        );

        if ( empty( $links ) && ! $is_preview ) {
                return;
        }

        if ( isset( $location_enabled[ $location ] ) && ! $location_enabled[ $location ] && ! $is_preview ) {
                return;
        }

        $labels = array(
                'github'    => __( 'GitHub', 'beyond_gotham' ),
                'linkedin'  => __( 'LinkedIn', 'beyond_gotham' ),
                'mastodon'  => __( 'Mastodon', 'beyond_gotham' ),
                'twitter'   => __( 'X (Twitter)', 'beyond_gotham' ),
                'facebook'  => __( 'Facebook', 'beyond_gotham' ),
		'instagram' => __( 'Instagram', 'beyond_gotham' ),
		'tiktok'    => __( 'TikTok', 'beyond_gotham' ),
		'youtube'   => __( 'YouTube', 'beyond_gotham' ),
		'telegram'  => __( 'Telegram', 'beyond_gotham' ),
		'email'     => __( 'E-Mail', 'beyond_gotham' ),
	);

	$icons = beyond_gotham_get_social_icon_svgs();

        $wrapper_classes = array( 'socialbar', 'socialbar--' . $location );

        if ( ! empty( $settings['icon_style'] ) ) {
                $wrapper_classes[] = 'socialbar--icon-' . sanitize_html_class( $settings['icon_style'] );
        }

        if ( ! empty( $settings['style_variant'] ) ) {
                $wrapper_classes[] = 'socialbar--' . sanitize_html_class( $settings['style_variant'] );
        }

        $wrapper_attributes = array(
                'class'            => implode( ' ', array_map( 'sanitize_html_class', array_unique( $wrapper_classes ) ) ),
                'data-bg-socialbar'=> $location,
                'data-location'    => $location,
        );

        if ( ! empty( $settings['style_variant'] ) ) {
                $wrapper_attributes['data-variant'] = sanitize_html_class( $settings['style_variant'] );
        }

        if ( ! empty( $settings['icon_style'] ) && 'default' !== $settings['icon_style'] ) {
                $wrapper_attributes['data-icon-style'] = sanitize_html_class( $settings['icon_style'] );
        }

        $style_rules = array();

        if ( ! empty( $settings['surface']['background'] ) ) {
                $style_rules[] = '--socialbar-surface: ' . $settings['surface']['background'] . ';';
        }

        if ( ! empty( $settings['surface']['icon'] ) ) {
                $style_rules[] = '--socialbar-icon: ' . $settings['surface']['icon'] . ';';
        }

        $active_variant = isset( $settings['style_variant'] ) ? $settings['style_variant'] : 'minimal';

        if ( isset( $settings['variants'][ $active_variant ] ) && is_array( $settings['variants'][ $active_variant ] ) ) {
                $variant_colors = $settings['variants'][ $active_variant ];

                if ( ! empty( $variant_colors['background'] ) ) {
                        $style_rules[] = '--socialbar-bg: ' . $variant_colors['background'] . ';';
                }

                if ( ! empty( $variant_colors['hover'] ) ) {
                        $style_rules[] = '--socialbar-hover: ' . $variant_colors['hover'] . ';';
                }

                if ( ! empty( $variant_colors['icon'] ) ) {
                        $style_rules[] = '--socialbar-icon: ' . $variant_colors['icon'] . ';';
                }
        }

        if ( ! empty( $style_rules ) ) {
                $wrapper_attributes['style'] = implode( ' ', $style_rules );
        }

        if ( isset( $location_enabled[ $location ] ) && ! $location_enabled[ $location ] ) {
                $wrapper_attributes['hidden']                = true;
                $wrapper_attributes['aria-hidden']           = 'true';
                $wrapper_attributes['data-preview-inactive'] = 'true';
        }

        if ( $is_preview ) {
                $wrapper_attributes['data-customize-preview'] = 'true';
        }

        $attribute_chunks = array();

        foreach ( $wrapper_attributes as $attr => $value ) {
                if ( true === $value ) {
                        $attribute_chunks[] = esc_attr( $attr );
                        continue;
                }

                if ( '' === $value ) {
                        continue;
                }

                $attribute_chunks[] = sprintf( '%s="%s"', esc_attr( $attr ), esc_attr( $value ) );
        }

        echo '<ul ' . implode( ' ', $attribute_chunks ) . '>';

        $networks_to_render = array_keys( $links );

        if ( $is_preview ) {
                $networks_to_render = array_unique( array_merge( $networks_to_render, array_keys( $icons ) ) );
        }

        foreach ( $networks_to_render as $network ) {
                $label       = isset( $labels[ $network ] ) ? $labels[ $network ] : ucfirst( $network );
                $icon        = isset( $icons[ $network ] ) ? $icons[ $network ] : '';
                $url         = isset( $links[ $network ] ) ? $links[ $network ] : '';
                $is_empty    = '' === $url;
                $network_slug = $is_empty ? $network : ( beyond_gotham_detect_social_network( $url ) ?: $network );
                $item_classes = array( 'socialbar__item', 'socialbar__item--' . $network_slug );

                $item_attributes = array();

                if ( $is_empty ) {
                        $item_classes[]            = 'socialbar__item--empty';
                        $item_attributes['hidden'] = true;
                        $item_attributes['aria-hidden'] = 'true';
                        $item_attributes['data-empty'] = 'true';
                }

                echo '<li class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', $item_classes ) ) ) . '"';

                foreach ( $item_attributes as $attr => $value ) {
                        if ( true === $value ) {
                                echo ' ' . esc_attr( $attr );
                                continue;
                        }

                        echo ' ' . esc_attr( $attr ) . '="' . esc_attr( $value ) . '"';
                }

                echo '>';

                $link_attributes = array(
                        'class'        => 'socialbar__link',
                        'data-network' => $network_slug,
                );

                if ( ! $is_empty ) {
                        $link_attributes['href'] = esc_url( $url );

                        $is_mail = 0 === strpos( $url, 'mailto:' );

                        if ( ! $is_mail ) {
                                $link_attributes['target'] = '_blank';
                                $link_attributes['rel']    = 'noopener';
                        }
                } else {
                        $link_attributes['href']       = '#';
                        $link_attributes['aria-hidden'] = 'true';
                        $link_attributes['tabindex']   = '-1';
                }

                $link_attribute_parts = array();

                foreach ( $link_attributes as $attr => $value ) {
                        if ( '' === $value ) {
                                continue;
                        }

                        $link_attribute_parts[] = sprintf( '%s="%s"', esc_attr( $attr ), esc_attr( $value ) );
                }

                echo '<a ' . implode( ' ', $link_attribute_parts ) . '>';

                if ( $icon ) {
                        echo '<span class="socialbar__icon" aria-hidden="true">' . $icon . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                }

                echo '<span class="socialbar__label">' . esc_html( $label ) . '</span>';
                echo '</a>';
                echo '</li>';
        }

        echo '</ul>';

        $rendered_locations[ $location ] = true;
}

/**
 * Provide socialbar settings for the Customizer preview script.
 *
 * @return array
 */
function beyond_gotham_get_socialbar_preview_data() {
        $settings = beyond_gotham_get_socialbar_settings();

        return array(
                'variant'   => isset( $settings['style_variant'] ) ? $settings['style_variant'] : 'minimal',
                'surface'   => isset( $settings['surface'] ) ? $settings['surface'] : array(),
                'variants'  => isset( $settings['variants'] ) ? $settings['variants'] : array(),
                'iconStyle' => isset( $settings['icon_style'] ) ? $settings['icon_style'] : 'default',
        );
}

/**
 * Output the mobile social bar in the footer when enabled.
 */
function beyond_gotham_output_mobile_socialbar() {
	beyond_gotham_render_socialbar( 'mobile' );
}
add_action( 'wp_footer', 'beyond_gotham_output_mobile_socialbar', 15 );

// =============================================================================
// Customizer Registration
// =============================================================================

/**
 * Register social media customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function beyond_gotham_register_social_customizer( WP_Customize_Manager $wp_customize ) {
	// Social Media Section
	$wp_customize->add_section(
		'beyond_gotham_social_media',
		array(
			'title'       => __( 'Social Media', 'beyond_gotham' ),
			'priority'    => 91,
			'description' => __( 'Links zu Social-Media-Profilen pflegen. Die Vorschau zeigt Desktop & Mobile-Varianten.', 'beyond_gotham' ),
		)
	);

	// Socialbar Display Settings
	$wp_customize->add_setting(
		'beyond_gotham_show_socialbar_header',
		array(
			'default'           => false,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'beyond_gotham_show_socialbar_header_control',
		array(
			'label'    => __( 'Social-Bar im Header anzeigen?', 'beyond_gotham' ),
			'section'  => 'beyond_gotham_social_media',
			'settings' => 'beyond_gotham_show_socialbar_header',
			'type'     => 'checkbox',
		)
	);

        $wp_customize->add_setting(
                'beyond_gotham_show_socialbar_mobile',
                array(
                        'default'           => true,
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_show_socialbar_mobile_control',
                array(
                        'label'    => __( 'Sticky-Social-Bar auf Mobilgeräten anzeigen?', 'beyond_gotham' ),
                        'section'  => 'beyond_gotham_social_media',
                        'settings' => 'beyond_gotham_show_socialbar_mobile',
                        'type'     => 'checkbox',
                )
        );

        // Socialbar appearance settings.
        $wp_customize->add_control(
                new Beyond_Gotham_Customize_Heading_Control(
                        $wp_customize,
                        'beyond_gotham_socialbar_style_heading',
                        array(
                                'label'       => __( 'Darstellung & Farben', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_social_media',
                                'description' => __( 'Passe Layout und Farben der Social-Bar an.', 'beyond_gotham' ),
                        )
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_socialbar_style_variant',
                array(
                        'default'           => 'minimal',
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_socialbar_variant',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_socialbar_style_variant',
                array(
                        'label'   => __( 'Darstellungsvariante', 'beyond_gotham' ),
                        'section' => 'beyond_gotham_social_media',
                        'type'    => 'select',
                        'choices' => array(
                                'minimal'  => __( 'Minimal', 'beyond_gotham' ),
                                'boxed'    => __( 'Boxed', 'beyond_gotham' ),
                                'pill'     => __( 'Pill', 'beyond_gotham' ),
                                'labelled' => __( 'Mit Label', 'beyond_gotham' ),
                        ),
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_socialbar_icon_style',
                array(
                        'default'           => 'default',
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_socialbar_icon_style',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_socialbar_icon_style',
                array(
                        'label'   => __( 'Icon-Stil', 'beyond_gotham' ),
                        'section' => 'beyond_gotham_social_media',
                        'type'    => 'select',
                        'choices' => array(
                                'default'    => __( 'Themefarben', 'beyond_gotham' ),
                                'monochrom'  => __( 'Monochrom', 'beyond_gotham' ),
                                'farbig'     => __( 'Markenfarben', 'beyond_gotham' ),
                                'invertiert' => __( 'Invertiert', 'beyond_gotham' ),
                        ),
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_socialbar_background_color',
                array(
                        'default'           => '',
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'sanitize_hex_color',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                        $wp_customize,
                        'beyond_gotham_socialbar_background_color',
                        array(
                                'label'       => __( 'Oberflächenfarbe', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_social_media',
                                'settings'    => 'beyond_gotham_socialbar_background_color',
                                'description' => __( 'Grundfarbe der Social-Bar.', 'beyond_gotham' ),
                        )
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_socialbar_icon_color',
                array(
                        'default'           => '',
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'sanitize_hex_color',
                        'transport'         => 'postMessage',
                )
        );

        $wp_customize->add_control(
                new WP_Customize_Color_Control(
                        $wp_customize,
                        'beyond_gotham_socialbar_icon_color',
                        array(
                                'label'       => __( 'Icon-Farbe (Oberfläche)', 'beyond_gotham' ),
                                'section'     => 'beyond_gotham_social_media',
                                'settings'    => 'beyond_gotham_socialbar_icon_color',
                        )
                )
        );

        $variant_labels = array(
                'minimal'  => __( 'Minimal', 'beyond_gotham' ),
                'boxed'    => __( 'Boxed', 'beyond_gotham' ),
                'pill'     => __( 'Pill', 'beyond_gotham' ),
                'labelled' => __( 'Mit Label', 'beyond_gotham' ),
        );

        $color_labels = array(
                'background' => __( 'Hintergrund', 'beyond_gotham' ),
                'hover'      => __( 'Hover', 'beyond_gotham' ),
                'icon'       => __( 'Icon', 'beyond_gotham' ),
        );

        foreach ( beyond_gotham_get_socialbar_variant_choices() as $variant_key ) {
                foreach ( beyond_gotham_get_socialbar_color_types() as $color_type ) {
                        $setting_id = 'beyond_gotham_socialbar_' . $variant_key . '_' . $color_type . '_color';

                        $wp_customize->add_setting(
                                $setting_id,
                                array(
                                        'default'           => '',
                                        'type'              => 'theme_mod',
                                        'sanitize_callback' => 'sanitize_hex_color',
                                        'transport'         => 'postMessage',
                                )
                        );

                        $label = sprintf(
                                /* translators: 1: Variant label, 2: color label */
                                __( '%1$s · %2$s', 'beyond_gotham' ),
                                isset( $variant_labels[ $variant_key ] ) ? $variant_labels[ $variant_key ] : ucfirst( $variant_key ),
                                isset( $color_labels[ $color_type ] ) ? $color_labels[ $color_type ] : ucfirst( $color_type )
                        );

                        $wp_customize->add_control(
                                new WP_Customize_Color_Control(
                                        $wp_customize,
                                        $setting_id,
                                        array(
                                                'label'    => $label,
                                                'section'  => 'beyond_gotham_social_media',
                                                'settings' => $setting_id,
                                        )
                                )
                        );
                }
        }

        // Social Network URLs
        $networks = array(
		'github'    => array(
			'label'       => __( 'GitHub URL', 'beyond_gotham' ),
			'placeholder' => 'https://github.com/beyondgotham',
		),
		'linkedin'  => array(
			'label'       => __( 'LinkedIn URL', 'beyond_gotham' ),
			'placeholder' => 'https://www.linkedin.com/company/beyondgotham',
		),
		'mastodon'  => array(
			'label'       => __( 'Mastodon URL', 'beyond_gotham' ),
			'placeholder' => 'https://chaos.social/@beyondgotham',
		),
		'twitter'   => array(
			'label'       => __( 'X (Twitter) URL', 'beyond_gotham' ),
			'placeholder' => 'https://twitter.com/beyondgotham',
		),
		'facebook'  => array(
			'label'       => __( 'Facebook URL', 'beyond_gotham' ),
			'placeholder' => 'https://www.facebook.com/beyondgotham',
		),
		'instagram' => array(
			'label'       => __( 'Instagram URL', 'beyond_gotham' ),
			'placeholder' => 'https://www.instagram.com/beyondgotham',
		),
		'tiktok'    => array(
			'label'       => __( 'TikTok URL', 'beyond_gotham' ),
			'placeholder' => 'https://www.tiktok.com/@beyondgotham',
		),
		'youtube'   => array(
			'label'       => __( 'YouTube URL', 'beyond_gotham' ),
			'placeholder' => 'https://www.youtube.com/@beyondgotham',
		),
		'telegram'  => array(
			'label'       => __( 'Telegram URL', 'beyond_gotham' ),
			'placeholder' => 'https://t.me/beyondgotham',
		),
	);

	foreach ( $networks as $network => $args ) {
                $wp_customize->add_setting(
                        'beyond_gotham_social_' . $network,
                        array(
                                'type'              => 'theme_mod',
                                'sanitize_callback' => 'beyond_gotham_sanitize_optional_url',
                                'transport'         => 'postMessage',
                        )
                );

		$wp_customize->add_control(
			'beyond_gotham_social_' . $network . '_control',
			array(
				'label'       => $args['label'],
				'section'     => 'beyond_gotham_social_media',
				'settings'    => 'beyond_gotham_social_' . $network,
				'type'        => 'url',
				'description' => sprintf( __( 'Beispiel: %s', 'beyond_gotham' ), $args['placeholder'] ),
			)
		);
	}

	// Email (separate handling)
        $wp_customize->add_setting(
                'beyond_gotham_social_email',
                array(
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_optional_email',
                        'transport'         => 'postMessage',
                )
        );

	$wp_customize->add_control(
		'beyond_gotham_social_email_control',
		array(
			'label'       => __( 'E-Mail-Adresse', 'beyond_gotham' ),
			'section'     => 'beyond_gotham_social_media',
			'settings'    => 'beyond_gotham_social_email',
			'type'        => 'text',
			'description' => __( 'Beispiel: redaktion@beyondgotham.org', 'beyond_gotham' ),
		)
	);
}
