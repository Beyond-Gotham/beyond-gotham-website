<?php
/**
 * Customizer module binding for typography settings.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __DIR__ ) . '/utils/typography.php';

/**
 * Registers typography settings with the customizer.
 */
class Beyond_Gotham_Customizer_Module_Typography extends Beyond_Gotham_Abstract_Customizer_Module {
    /**
     * {@inheritdoc}
     */
    public function get_id() {
        return 'typography';
    }

    /**
     * {@inheritdoc}
     */
    public function get_priority() {
        return 20;
    }

    /**
     * Retrieve the preset choices for controls.
     *
     * @return array
     */
    protected function get_preset_choices() {
        $presets = beyond_gotham_get_typography_presets();
        $choices = array();

        foreach ( $presets as $key => $preset ) {
            $choices[ $key ] = isset( $preset['label'] ) ? $preset['label'] : ucfirst( $key );
        }

        return $choices;
    }

    /**
     * {@inheritdoc}
     */
    public function register( WP_Customize_Manager $wp_customize ) {
        $wp_customize->add_section(
            'beyond_gotham_typography',
            array(
                'title'    => __( 'Typografie', 'beyond_gotham' ),
                'priority' => 30,
            )
        );

        $choices = $this->get_preset_choices();

        $wp_customize->add_setting(
            'beyond_gotham_body_font_family',
            array(
                'default'           => 'inter',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'beyond_gotham_sanitize_typography_choice',
                'transport'         => 'postMessage',
            )
        );

        $wp_customize->add_control(
            'beyond_gotham_body_font_family_control',
            array(
                'label'       => __( 'Primäre Schriftfamilie', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_typography',
                'settings'    => 'beyond_gotham_body_font_family',
                'type'        => 'select',
                'choices'     => $choices,
                'description' => __( 'Steuert die Standardschrift des Themes.', 'beyond_gotham' ),
            )
        );

        $wp_customize->add_setting(
            'beyond_gotham_heading_font_family',
            array(
                'default'           => 'merriweather',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'beyond_gotham_sanitize_typography_choice',
                'transport'         => 'postMessage',
            )
        );

        $wp_customize->add_control(
            'beyond_gotham_heading_font_family_control',
            array(
                'label'       => __( 'Überschrift-Schriftfamilie', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_typography',
                'settings'    => 'beyond_gotham_heading_font_family',
                'type'        => 'select',
                'choices'     => $choices,
                'description' => __( 'Wähle eine kontrastierende Schrift für Headlines.', 'beyond_gotham' ),
            )
        );

        $wp_customize->add_setting(
            'beyond_gotham_body_font_size',
            array(
                'default'           => 16,
                'type'              => 'theme_mod',
                'sanitize_callback' => 'beyond_gotham_sanitize_float',
                'transport'         => 'postMessage',
            )
        );

        $wp_customize->add_control(
            'beyond_gotham_body_font_size_control',
            array(
                'label'       => __( 'Grundschriftgröße', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_typography',
                'settings'    => 'beyond_gotham_body_font_size',
                'type'        => 'number',
                'input_attrs' => array(
                    'min'  => 12,
                    'max'  => 24,
                    'step' => 0.5,
                ),
                'description' => __( 'Passe die Basisgröße für Text an.', 'beyond_gotham' ),
            )
        );

        $wp_customize->add_setting(
            'beyond_gotham_body_font_size_unit',
            array(
                'default'           => 'px',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'beyond_gotham_sanitize_font_unit',
                'transport'         => 'postMessage',
            )
        );

        $wp_customize->add_control(
            'beyond_gotham_body_font_size_unit_control',
            array(
                'label'    => __( 'Einheit für Schriftgröße', 'beyond_gotham' ),
                'section'  => 'beyond_gotham_typography',
                'settings' => 'beyond_gotham_body_font_size_unit',
                'type'     => 'select',
                'choices'  => array(
                    'px'  => 'px',
                    'rem' => 'rem',
                    'em'  => 'em',
                ),
            )
        );

        $wp_customize->add_setting(
            'beyond_gotham_body_line_height',
            array(
                'default'           => 1.6,
                'type'              => 'theme_mod',
                'sanitize_callback' => 'beyond_gotham_sanitize_float',
                'transport'         => 'postMessage',
            )
        );

        $wp_customize->add_control(
            'beyond_gotham_body_line_height_control',
            array(
                'label'       => __( 'Zeilenhöhe', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_typography',
                'settings'    => 'beyond_gotham_body_line_height',
                'type'        => 'number',
                'input_attrs' => array(
                    'min'  => 1.1,
                    'max'  => 2.6,
                    'step' => 0.1,
                ),
                'description' => __( 'Abstand zwischen Textzeilen.', 'beyond_gotham' ),
            )
        );

        if ( class_exists( 'Beyond_Gotham_Customize_Heading_Control' ) ) {
            $wp_customize->add_control(
                new Beyond_Gotham_Customize_Heading_Control(
                    $wp_customize,
                    'beyond_gotham_typography_advanced_heading',
                    array(
                        'label'   => __( 'Erweiterte Einstellungen', 'beyond_gotham' ),
                        'section' => 'beyond_gotham_typography',
                    )
                )
            );
        }

        $wp_customize->add_setting(
            'beyond_gotham_letter_spacing',
            array(
                'default'           => 0,
                'type'              => 'theme_mod',
                'sanitize_callback' => 'beyond_gotham_sanitize_float',
                'transport'         => 'postMessage',
            )
        );

        $wp_customize->add_control(
            'beyond_gotham_letter_spacing_control',
            array(
                'label'       => __( 'Zeichenabstand', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_typography',
                'settings'    => 'beyond_gotham_letter_spacing',
                'type'        => 'number',
                'input_attrs' => array(
                    'min'  => -0.1,
                    'max'  => 0.3,
                    'step' => 0.01,
                ),
                'description' => __( 'Abstand zwischen Zeichen in em. Standard: 0', 'beyond_gotham' ),
            )
        );

        $wp_customize->add_setting(
            'beyond_gotham_paragraph_spacing',
            array(
                'default'           => 1.5,
                'type'              => 'theme_mod',
                'sanitize_callback' => 'beyond_gotham_sanitize_float',
                'transport'         => 'postMessage',
            )
        );

        $wp_customize->add_control(
            'beyond_gotham_paragraph_spacing_control',
            array(
                'label'       => __( 'Absatzabstand', 'beyond_gotham' ),
                'section'     => 'beyond_gotham_typography',
                'settings'    => 'beyond_gotham_paragraph_spacing',
                'type'        => 'number',
                'input_attrs' => array(
                    'min'  => 0.5,
                    'max'  => 3,
                    'step' => 0.1,
                ),
                'description' => __( 'Abstand zwischen Absätzen in em.', 'beyond_gotham' ),
            )
        );
    }
}
