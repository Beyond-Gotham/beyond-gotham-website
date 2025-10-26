<?php
/**
 * Customizer module binding for color settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/utils/colors.php';

/**
 * Registers the color settings with the WordPress customizer.
 */
class Beyond_Gotham_Customizer_Module_Colors extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'colors';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 15;
    }

    /**
     * Provide the color control definitions.
     *
     * @return array
     */
    protected function get_color_controls() {
        $defaults = beyond_gotham_get_color_defaults();

        return array(
            'background_color'        => array(
                'label'       => __( 'Hintergrundfarbe', 'beyond_gotham' ),
                'description' => __( 'Haupthintergrundfarbe der Seite.', 'beyond_gotham' ),
                'defaults'    => array(
                    'light' => $defaults['light']['background'],
                    'dark'  => $defaults['dark']['background'],
                ),
            ),
            'text_color'             => array(
                'label'       => __( 'Textfarbe', 'beyond_gotham' ),
                'description' => __( 'Standard-Textfarbe für Fließtext.', 'beyond_gotham' ),
                'defaults'    => array(
                    'light' => $defaults['light']['text_color'],
                    'dark'  => $defaults['dark']['text_color'],
                ),
            ),
            'primary_color'          => array(
                'label'       => __( 'Primäre Akzentfarbe', 'beyond_gotham' ),
                'description' => __( 'Markenfarbe für Buttons, Links und Highlights.', 'beyond_gotham' ),
                'defaults'    => array(
                    'light' => $defaults['light']['primary'],
                    'dark'  => $defaults['dark']['primary'],
                ),
                'legacy'      => 'accent',
            ),
            'secondary_color'        => array(
                'label'       => __( 'Sekundärfarbe', 'beyond_gotham' ),
                'description' => __( 'Zweite Markenfarbe für Badges oder Hover-Zustände.', 'beyond_gotham' ),
                'defaults'    => array(
                    'light' => $defaults['light']['secondary'],
                    'dark'  => $defaults['dark']['secondary'],
                ),
            ),
            'cta_accent_color'       => array(
                'label'       => __( 'CTA-Akzentfarbe', 'beyond_gotham' ),
                'description' => __( 'Farbe für Call-to-Action-Boxen und Sticky-CTA.', 'beyond_gotham' ),
                'defaults'    => array(
                    'light' => $defaults['light']['cta_accent'],
                    'dark'  => $defaults['dark']['cta_accent'],
                ),
                'legacy'      => 'accent',
            ),
            'header_background_color'=> array(
                'label'       => __( 'Header-Hintergrund', 'beyond_gotham' ),
                'description' => __( 'Steuert den Hintergrund des Kopfbereichs.', 'beyond_gotham' ),
                'defaults'    => array(
                    'light' => $defaults['light']['header_background'],
                    'dark'  => $defaults['dark']['header_background'],
                ),
            ),
            'footer_background_color'=> array(
                'label'       => __( 'Footer-Hintergrund', 'beyond_gotham' ),
                'description' => __( 'Farbe der Footer-Fläche.', 'beyond_gotham' ),
                'defaults'    => array(
                    'light' => $defaults['light']['footer_background'],
                    'dark'  => $defaults['dark']['footer_background'],
                ),
            ),
            'link_color'             => array(
                'label'       => __( 'Link-Farbe', 'beyond_gotham' ),
                'description' => __( 'Farbe für Textlinks.', 'beyond_gotham' ),
                'defaults'    => array(
                    'light' => $defaults['light']['link'],
                    'dark'  => $defaults['dark']['link'],
                ),
            ),
            'link_hover_color'       => array(
                'label'       => __( 'Link-Hover-Farbe', 'beyond_gotham' ),
                'description' => __( 'Link-Farbe beim Hover-Zustand.', 'beyond_gotham' ),
                'defaults'    => array(
                    'light' => $defaults['light']['link_hover'],
                    'dark'  => $defaults['dark']['link_hover'],
                ),
            ),
            'button_background_color' => array(
                'label'       => __( 'Button-Hintergrund', 'beyond_gotham' ),
                'description' => __( 'Hintergrundfarbe für primäre Buttons.', 'beyond_gotham' ),
                'defaults'    => array(
                    'light' => $defaults['light']['button_background'],
                    'dark'  => $defaults['dark']['button_background'],
                ),
            ),
            'button_text_color'     => array(
                'label'       => __( 'Button-Textfarbe', 'beyond_gotham' ),
                'description' => __( 'Textfarbe in Buttons.', 'beyond_gotham' ),
                'defaults'    => array(
                    'light' => $defaults['light']['button_text'],
                    'dark'  => $defaults['dark']['button_text'],
                ),
            ),
            'quote_background_color' => array(
                'label'       => __( 'Zitat-Hintergrund', 'beyond_gotham' ),
                'description' => __( 'Hintergrundfarbe für Zitate und Highlight-Boxen.', 'beyond_gotham' ),
                'defaults'    => array(
                    'light' => $defaults['light']['quote_background'],
                    'dark'  => $defaults['dark']['quote_background'],
                ),
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        $wp_customize->add_section(
            'beyond_gotham_colors',
            array(
                'title'       => __( 'Farben & Design', 'beyond_gotham' ),
                'priority'    => 20,
                'description' => __( 'Konfiguriere das Farbschema für Light- und Dark-Mode.', 'beyond_gotham' ),
            )
        );

        $wp_customize->add_section(
            'beyond_gotham_colors_light',
            array(
                'title'    => __( 'Light Mode Farben', 'beyond_gotham' ),
                'priority' => 21,
            )
        );

        $wp_customize->add_section(
            'beyond_gotham_colors_dark',
            array(
                'title'    => __( 'Dark Mode Farben', 'beyond_gotham' ),
                'priority' => 22,
            )
        );

        $color_modes = array(
            'light' => array(
                'label'   => __( 'Light', 'beyond_gotham' ),
                'section' => 'beyond_gotham_colors_light',
            ),
            'dark'  => array(
                'label'   => __( 'Dark', 'beyond_gotham' ),
                'section' => 'beyond_gotham_colors_dark',
            ),
        );

        $color_controls = $this->get_color_controls();

        foreach ( $color_controls as $setting_key => $control_args ) {
            foreach ( $color_modes as $mode_key => $mode_args ) {
                $setting_id = sprintf( 'beyond_gotham_%s_%s', $setting_key, $mode_key );
                $control_id = $setting_id . '_control';
                $default    = isset( $control_args['defaults'][ $mode_key ] ) ? $control_args['defaults'][ $mode_key ] : '';

                if ( ! empty( $control_args['legacy'] ) ) {
                    $legacy_setting = sprintf( 'beyond_gotham_%s_%s', $control_args['legacy'], $mode_key );
                    $legacy_value   = sanitize_hex_color( get_theme_mod( $legacy_setting ) );

                    if ( $legacy_value ) {
                        $default = $legacy_value;
                    }
                }

                $wp_customize->add_setting(
                    $setting_id,
                    array(
                        'default'           => $default,
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'sanitize_hex_color',
                        'transport'         => 'postMessage',
                    )
                );

                $label = sprintf(
                    /* translators: %1$s: Base label. %2$s: Color mode label. */
                    __( '%1$s (%2$s)', 'beyond_gotham' ),
                    $control_args['label'],
                    $mode_args['label']
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize,
                        $control_id,
                        array(
                            'label'       => $label,
                            'section'     => $mode_args['section'],
                            'settings'    => $setting_id,
                            'description' => $control_args['description'],
                        )
                    )
                );
            }
        }

        $wp_customize->add_setting(
            'beyond_gotham_enable_dark_mode',
            array(
                'default'           => true,
                'type'              => 'theme_mod',
                'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                'transport'         => 'postMessage',
            )
        );

        $wp_customize->add_control(
            'beyond_gotham_enable_dark_mode_control',
            array(
                'label'    => __( 'Dark Mode aktivieren', 'beyond_gotham' ),
                'section'  => 'beyond_gotham_colors',
                'settings' => 'beyond_gotham_enable_dark_mode',
                'type'     => 'checkbox',
            )
        );
    }
}
