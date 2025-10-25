<?php
/**
 * SEO Customizer Settings
 *
 * Handles basic meta tags, schema markup and robots configuration.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Defaults & detection
// =============================================================================

/**
 * Default SEO values.
 *
 * @return array
 */
function beyond_gotham_get_seo_defaults() {
        return array(
                'title_format'        => 'post_site',
                'home_description'    => '',
                'archive_description' => '',
                'open_graph'          => true,
                'og_image'            => 0,
                'schema_type'         => 'organization',
                'schema_name'         => '',
                'schema_url'          => '',
                'schema_sameas'       => '',
                'schema_logo'         => 0,
                'breadcrumbs'         => false,
                'robots'              => 'index_follow',
        );
}

/**
 * Detect common SEO plugins to avoid duplicate output.
 *
 * @return array
 */
function beyond_gotham_seo_detect_plugins() {
        $plugins = array();

        if ( defined( 'WPSEO_VERSION' ) || class_exists( 'WPSEO_Options' ) ) {
                $plugins[] = 'Yoast SEO';
        }

        if ( defined( 'RANK_MATH_VERSION' ) || class_exists( 'RankMath' ) ) {
                $plugins[] = 'Rank Math';
        }

        if ( defined( 'AIOSEO_VERSION' ) || class_exists( 'AIOSEO\App\Common\Main\Main' ) ) {
                $plugins[] = 'All in One SEO';
        }

        if ( defined( 'SEOPRESS_VERSION' ) || class_exists( 'SEOPRESS_Core' ) ) {
                $plugins[] = 'SEOPress';
        }

        return $plugins;
}

/**
 * Whether an SEO plugin is active.
 *
 * @return bool
 */
function beyond_gotham_seo_plugin_active() {
        return ! empty( beyond_gotham_seo_detect_plugins() );
}

/**
 * Helper for customizer active callbacks.
 *
 * @return bool
 */
function beyond_gotham_seo_controls_available() {
        return ! beyond_gotham_seo_plugin_active();
}

// =============================================================================
// Customizer registration
// =============================================================================

/**
 * Register SEO controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 * @return void
 */
function beyond_gotham_register_seo_customizer( WP_Customize_Manager $wp_customize ) {
        $defaults = beyond_gotham_get_seo_defaults();
        $plugins  = beyond_gotham_seo_detect_plugins();

        $wp_customize->add_section(
                'beyond_gotham_seo',
                array(
                        'title'       => __( 'SEO & Metadaten', 'beyond_gotham' ),
                        'priority'    => 85,
                        'description' => __( 'Konfiguriere Titel, Meta-Beschreibungen, Open Graph sowie strukturierte Daten. Bei aktiven SEO-Plugins werden diese Einstellungen deaktiviert.', 'beyond_gotham' ),
                )
        );

        if ( ! empty( $plugins ) ) {
                $wp_customize->add_control(
                        new Beyond_Gotham_Customize_Info_Control(
                                $wp_customize,
                                'beyond_gotham_seo_plugin_notice',
                                array(
                                        'label'       => __( 'Externes SEO-Plugin aktiv', 'beyond_gotham' ),
                                        'section'     => 'beyond_gotham_seo',
                                        'notice_type' => 'warning',
                                        'description' => sprintf(
                                                /* translators: %s plugin list */
                                                __( 'Folgende Erweiterungen sind aktiv: %s. Theme-eigene Meta-Ausgaben werden deaktiviert, um Konflikte zu vermeiden.', 'beyond_gotham' ),
                                                esc_html( implode( ', ', $plugins ) )
                                        ),
                                )
                        )
                );
        }

        $wp_customize->add_setting(
                'beyond_gotham_seo_title_format',
                array(
                        'default'           => $defaults['title_format'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_choice',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_seo_title_format_control',
                array(
                        'label'           => __( 'Titel-Format', 'beyond_gotham' ),
                        'section'         => 'beyond_gotham_seo',
                        'settings'        => 'beyond_gotham_seo_title_format',
                        'type'            => 'select',
                        'choices'         => array(
                                'site_post' => __( 'Site Title – Beitragstitel', 'beyond_gotham' ),
                                'post_site' => __( 'Beitragstitel – Site Title', 'beyond_gotham' ),
                                'post_only' => __( 'Nur Beitragstitel', 'beyond_gotham' ),
                        ),
                        'active_callback' => 'beyond_gotham_seo_controls_available',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_seo_home_description',
                array(
                        'default'           => $defaults['home_description'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'sanitize_textarea_field',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_seo_home_description_control',
                array(
                        'label'           => __( 'Meta-Description Startseite', 'beyond_gotham' ),
                        'type'            => 'textarea',
                        'section'         => 'beyond_gotham_seo',
                        'settings'        => 'beyond_gotham_seo_home_description',
                        'active_callback' => 'beyond_gotham_seo_controls_available',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_seo_archive_description',
                array(
                        'default'           => $defaults['archive_description'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'sanitize_textarea_field',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_seo_archive_description_control',
                array(
                        'label'           => __( 'Meta-Description Archive', 'beyond_gotham' ),
                        'type'            => 'textarea',
                        'section'         => 'beyond_gotham_seo',
                        'settings'        => 'beyond_gotham_seo_archive_description',
                        'active_callback' => 'beyond_gotham_seo_controls_available',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_seo_open_graph',
                array(
                        'default'           => $defaults['open_graph'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_seo_open_graph_control',
                array(
                        'label'           => __( 'Open Graph Meta-Tags aktivieren', 'beyond_gotham' ),
                        'section'         => 'beyond_gotham_seo',
                        'settings'        => 'beyond_gotham_seo_open_graph',
                        'type'            => 'checkbox',
                        'active_callback' => 'beyond_gotham_seo_controls_available',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_seo_og_image',
                array(
                        'default'           => $defaults['og_image'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'absint',
                )
        );

        $wp_customize->add_control(
                new WP_Customize_Media_Control(
                        $wp_customize,
                        'beyond_gotham_seo_og_image_control',
                        array(
                                'label'           => __( 'Open Graph Standardbild', 'beyond_gotham' ),
                                'section'         => 'beyond_gotham_seo',
                                'settings'        => 'beyond_gotham_seo_og_image',
                                'mime_type'       => 'image',
                                'active_callback' => 'beyond_gotham_seo_controls_available',
                        )
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_seo_schema_type',
                array(
                        'default'           => $defaults['schema_type'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_choice',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_seo_schema_type_control',
                array(
                        'label'           => __( 'Schema-Typ', 'beyond_gotham' ),
                        'section'         => 'beyond_gotham_seo',
                        'settings'        => 'beyond_gotham_seo_schema_type',
                        'type'            => 'select',
                        'choices'         => array(
                                'organization' => __( 'Organisation', 'beyond_gotham' ),
                                'person'       => __( 'Person', 'beyond_gotham' ),
                                'none'         => __( 'Kein Schema ausgeben', 'beyond_gotham' ),
                        ),
                        'active_callback' => 'beyond_gotham_seo_controls_available',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_seo_schema_name',
                array(
                        'default'           => $defaults['schema_name'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'sanitize_text_field',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_seo_schema_name_control',
                array(
                        'label'           => __( 'Organisation/Person Name', 'beyond_gotham' ),
                        'section'         => 'beyond_gotham_seo',
                        'settings'        => 'beyond_gotham_seo_schema_name',
                        'type'            => 'text',
                        'active_callback' => 'beyond_gotham_seo_controls_available',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_seo_schema_url',
                array(
                        'default'           => $defaults['schema_url'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_optional_url',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_seo_schema_url_control',
                array(
                        'label'           => __( 'Offizielle Website / Profil-URL', 'beyond_gotham' ),
                        'section'         => 'beyond_gotham_seo',
                        'settings'        => 'beyond_gotham_seo_schema_url',
                        'type'            => 'url',
                        'active_callback' => 'beyond_gotham_seo_controls_available',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_seo_schema_sameas',
                array(
                        'default'           => $defaults['schema_sameas'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'sanitize_textarea_field',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_seo_schema_sameas_control',
                array(
                        'label'           => __( 'Weitere Profile (je Zeile)', 'beyond_gotham' ),
                        'section'         => 'beyond_gotham_seo',
                        'settings'        => 'beyond_gotham_seo_schema_sameas',
                        'type'            => 'textarea',
                        'active_callback' => 'beyond_gotham_seo_controls_available',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_seo_schema_logo',
                array(
                        'default'           => $defaults['schema_logo'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'absint',
                )
        );

        $wp_customize->add_control(
                new WP_Customize_Media_Control(
                        $wp_customize,
                        'beyond_gotham_seo_schema_logo_control',
                        array(
                                'label'           => __( 'Schema Logo', 'beyond_gotham' ),
                                'section'         => 'beyond_gotham_seo',
                                'settings'        => 'beyond_gotham_seo_schema_logo',
                                'mime_type'       => 'image',
                                'active_callback' => 'beyond_gotham_seo_controls_available',
                        )
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_seo_breadcrumbs',
                array(
                        'default'           => $defaults['breadcrumbs'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_checkbox',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_seo_breadcrumbs_control',
                array(
                        'label'           => __( 'Breadcrumb Schema aktivieren', 'beyond_gotham' ),
                        'section'         => 'beyond_gotham_seo',
                        'settings'        => 'beyond_gotham_seo_breadcrumbs',
                        'type'            => 'checkbox',
                        'active_callback' => 'beyond_gotham_seo_controls_available',
                )
        );

        $wp_customize->add_setting(
                'beyond_gotham_seo_robots',
                array(
                        'default'           => $defaults['robots'],
                        'type'              => 'theme_mod',
                        'sanitize_callback' => 'beyond_gotham_sanitize_choice',
                )
        );

        $wp_customize->add_control(
                'beyond_gotham_seo_robots_control',
                array(
                        'label'           => __( 'Robots-Standard', 'beyond_gotham' ),
                        'section'         => 'beyond_gotham_seo',
                        'settings'        => 'beyond_gotham_seo_robots',
                        'type'            => 'select',
                        'choices'         => array(
                                'index_follow'      => __( 'index, follow', 'beyond_gotham' ),
                                'index_nofollow'    => __( 'index, nofollow', 'beyond_gotham' ),
                                'noindex_follow'    => __( 'noindex, follow', 'beyond_gotham' ),
                                'noindex_nofollow'  => __( 'noindex, nofollow', 'beyond_gotham' ),
                        ),
                        'active_callback' => 'beyond_gotham_seo_controls_available',
                )
        );
}

// =============================================================================
// Helpers & runtime
// =============================================================================

/**
 * Retrieve SEO settings with defaults applied.
 *
 * @return array
 */
function beyond_gotham_get_seo_settings() {
        $defaults = beyond_gotham_get_seo_defaults();

        $settings = array(
                'title_format'        => get_theme_mod( 'beyond_gotham_seo_title_format', $defaults['title_format'] ),
                'home_description'    => get_theme_mod( 'beyond_gotham_seo_home_description', $defaults['home_description'] ),
                'archive_description' => get_theme_mod( 'beyond_gotham_seo_archive_description', $defaults['archive_description'] ),
                'open_graph'          => (bool) get_theme_mod( 'beyond_gotham_seo_open_graph', $defaults['open_graph'] ),
                'og_image'            => (int) get_theme_mod( 'beyond_gotham_seo_og_image', $defaults['og_image'] ),
                'schema_type'         => get_theme_mod( 'beyond_gotham_seo_schema_type', $defaults['schema_type'] ),
                'schema_name'         => get_theme_mod( 'beyond_gotham_seo_schema_name', $defaults['schema_name'] ),
                'schema_url'          => get_theme_mod( 'beyond_gotham_seo_schema_url', $defaults['schema_url'] ),
                'schema_sameas'       => get_theme_mod( 'beyond_gotham_seo_schema_sameas', $defaults['schema_sameas'] ),
                'schema_logo'         => (int) get_theme_mod( 'beyond_gotham_seo_schema_logo', $defaults['schema_logo'] ),
                'breadcrumbs'         => (bool) get_theme_mod( 'beyond_gotham_seo_breadcrumbs', $defaults['breadcrumbs'] ),
                'robots'              => get_theme_mod( 'beyond_gotham_seo_robots', $defaults['robots'] ),
        );

        $allowed_formats = array( 'site_post', 'post_site', 'post_only' );
        if ( ! in_array( $settings['title_format'], $allowed_formats, true ) ) {
                $settings['title_format'] = 'post_site';
        }

        $allowed_robots = array( 'index_follow', 'index_nofollow', 'noindex_follow', 'noindex_nofollow' );
        if ( ! in_array( $settings['robots'], $allowed_robots, true ) ) {
                $settings['robots'] = 'index_follow';
        }

        $schema_types = array( 'organization', 'person', 'none' );
        if ( ! in_array( $settings['schema_type'], $schema_types, true ) ) {
                $settings['schema_type'] = 'organization';
        }

        return $settings;
}

/**
 * Initialise SEO output if no conflicting plugin is active.
 *
 * @return void
 */
function beyond_gotham_bootstrap_seo_features() {
        if ( beyond_gotham_seo_plugin_active() ) {
                return;
        }

        add_filter( 'pre_get_document_title', 'beyond_gotham_seo_filter_document_title', 20 );
        add_action( 'wp_head', 'beyond_gotham_render_seo_meta', 1 );
}

/**
 * Modify the document title based on settings.
 *
 * @param string|null $title Current title.
 * @return string|null
 */
function beyond_gotham_seo_filter_document_title( $title ) {
        $settings = beyond_gotham_get_seo_settings();
        $site     = get_bloginfo( 'name' );

        if ( ! is_singular() && ! is_home() && ! is_front_page() ) {
                return $title;
        }

        $current = $title ? $title : wp_get_document_title();

        switch ( $settings['title_format'] ) {
                case 'site_post':
                        return trim( $site . ' – ' . $current );
                case 'post_only':
                        return $current;
                case 'post_site':
                default:
                        return trim( $current . ' – ' . $site );
        }
}

/**
 * Output meta tags, Open Graph and schema markup.
 *
 * @return void
 */
function beyond_gotham_render_seo_meta() {
        $settings = beyond_gotham_get_seo_settings();

        $description = beyond_gotham_seo_resolve_description( $settings );
        if ( $description ) {
                printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $description ) );
        }

        $robots = beyond_gotham_seo_resolve_robots( $settings['robots'] );
        if ( $robots ) {
                printf( '<meta name="robots" content="%s" />' . "\n", esc_attr( $robots ) );
        }

        if ( ! empty( $settings['open_graph'] ) ) {
                beyond_gotham_render_open_graph_tags( $description );
        }

        if ( 'none' !== $settings['schema_type'] ) {
                $schema = beyond_gotham_seo_build_schema_graph( $settings );

                if ( ! empty( $schema ) ) {
                        printf( '<script type="application/ld+json">%s</script>' . "\n", wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
                }
        }

        if ( ! empty( $settings['breadcrumbs'] ) ) {
                $breadcrumbs = beyond_gotham_seo_build_breadcrumbs();

                if ( ! empty( $breadcrumbs ) ) {
                        printf( '<script type="application/ld+json">%s</script>' . "\n", wp_json_encode( $breadcrumbs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
                }
        }
}

/**
 * Resolve meta description depending on context.
 *
 * @param array $settings SEO settings.
 * @return string
 */
function beyond_gotham_seo_resolve_description( array $settings ) {
        if ( is_front_page() || is_home() ) {
                $description = trim( $settings['home_description'] );
                if ( $description ) {
                        return $description;
                }

                return get_bloginfo( 'description' );
        }

        if ( is_archive() ) {
                $description = trim( $settings['archive_description'] );
                if ( $description ) {
                        return $description;
                }

        }

        if ( is_singular() ) {
                global $post;
                $excerpt = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $post ) ), 30, '' );
                return $excerpt ? $excerpt : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized later
        }

        return '';
}

/**
 * Build robots meta string.
 *
 * @param string $option Selected option.
 * @return string
 */
function beyond_gotham_seo_resolve_robots( $option ) {
        switch ( $option ) {
                case 'index_nofollow':
                        return 'index, nofollow';
                case 'noindex_follow':
                        return 'noindex, follow';
                case 'noindex_nofollow':
                        return 'noindex, nofollow';
                case 'index_follow':
                default:
                        return 'index, follow';
        }
}

/**
 * Print Open Graph tags.
 *
 * @param string $description Description fallback.
 * @return void
 */
function beyond_gotham_render_open_graph_tags( $description ) {
        global $wp;

        $title = wp_get_document_title();
        $request_path = '';

        if ( isset( $wp->request ) ) {
                $request_path = $wp->request;
        }

        $url  = home_url( add_query_arg( array(), $request_path ) );
        $type  = is_singular() ? 'article' : 'website';

        $image = beyond_gotham_seo_get_og_image_url();

        printf( '<meta property="og:type" content="%s" />' . "\n", esc_attr( $type ) );
        printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $title ) );
        printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( $url ) );
        printf( '<meta property="og:site_name" content="%s" />' . "\n", esc_attr( get_bloginfo( 'name' ) ) );

        if ( $description ) {
                printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $description ) );
        }

        if ( $image ) {
                printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $image ) );
        }
}

/**
 * Determine Open Graph image.
 *
 * @return string
 */
function beyond_gotham_seo_get_og_image_url() {
        $settings = beyond_gotham_get_seo_settings();

        if ( $settings['og_image'] ) {
                $image = wp_get_attachment_image_src( $settings['og_image'], 'full' );
                if ( $image ) {
                        return $image[0];
                }
        }

        if ( has_post_thumbnail() && is_singular() ) {
                $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                if ( $image ) {
                        return $image[0];
                }
        }

        if ( function_exists( 'beyond_gotham_get_brand_logo_id' ) ) {
                $logo_id = beyond_gotham_get_brand_logo_id();
                if ( $logo_id ) {
                        $image = wp_get_attachment_image_src( $logo_id, 'full' );
                        if ( $image ) {
                                return $image[0];
                        }
                }
        }

        if ( has_site_icon() ) {
                $icon = get_site_icon_url( 512 );
                if ( $icon ) {
                        return $icon;
                }
        }

        return '';
}

/**
 * Build schema graph for organisation/person.
 *
 * @param array $settings SEO settings.
 * @return array
 */
function beyond_gotham_seo_build_schema_graph( array $settings ) {
        $type = $settings['schema_type'];

        if ( 'none' === $type ) {
                return array();
        }

        $name = $settings['schema_name'] ? $settings['schema_name'] : get_bloginfo( 'name' );
        $url  = $settings['schema_url'] ? $settings['schema_url'] : home_url( '/' );

        $logo = '';
        if ( $settings['schema_logo'] ) {
                $src = wp_get_attachment_image_src( $settings['schema_logo'], 'full' );
                if ( $src ) {
                        $logo = $src[0];
                }
        } elseif ( function_exists( 'beyond_gotham_get_brand_logo_id' ) ) {
                $logo_id = beyond_gotham_get_brand_logo_id();
                if ( $logo_id ) {
                        $src = wp_get_attachment_image_src( $logo_id, 'full' );
                        if ( $src ) {
                                $logo = $src[0];
                        }
                }
        }

        $graph = array(
                '@context' => 'https://schema.org',
                '@type'    => 'organization' === $type ? 'Organization' : 'Person',
                'name'     => $name,
                'url'      => $url,
        );

        if ( $logo ) {
                $graph['logo'] = $logo;
        }

        $same_as = array_filter( array_map( 'trim', preg_split( '/\r?\n/', $settings['schema_sameas'] ) ) );
        if ( ! empty( $same_as ) ) {
                $graph['sameAs'] = array_values( array_unique( $same_as ) );
        }

        return $graph;
}

/**
 * Build breadcrumb JSON-LD.
 *
 * @return array
 */
function beyond_gotham_seo_build_breadcrumbs() {
        $items = beyond_gotham_seo_collect_breadcrumb_items();

        if ( empty( $items ) ) {
                return array();
        }

        $position = 1;
        $itemlist = array();

        foreach ( $items as $item ) {
                $itemlist[] = array(
                        '@type'    => 'ListItem',
                        'position' => $position++,
                        'name'     => $item['label'],
                        'item'     => $item['url'],
                );
        }

        return array(
                '@context'        => 'https://schema.org',
                '@type'           => 'BreadcrumbList',
                'itemListElement' => $itemlist,
        );
}

/**
 * Build breadcrumb trail (non-visual).
 *
 * @return array
 */
function beyond_gotham_seo_collect_breadcrumb_items() {
        $items = array();
        $home  = array(
                'label' => get_bloginfo( 'name' ),
                'url'   => home_url( '/' ),
        );

        $items[] = $home;

        if ( is_home() || is_front_page() ) {
                return $items;
        }

        if ( is_singular() ) {
                global $post;

                if ( 'page' === get_post_type( $post ) ) {
                        $ancestors = array_reverse( get_post_ancestors( $post ) );
                        foreach ( $ancestors as $ancestor_id ) {
                                $items[] = array(
                                        'label' => get_the_title( $ancestor_id ),
                                        'url'   => get_permalink( $ancestor_id ),
                                );
                        }
                } elseif ( 'post' === get_post_type( $post ) ) {
                        $category = get_the_category( $post->ID );
                        if ( ! empty( $category ) ) {
                                $primary = $category[0];
                                $ancestors = array_reverse( get_ancestors( $primary->term_id, 'category' ) );
                                foreach ( $ancestors as $ancestor_id ) {
                                        $term = get_category( $ancestor_id );
                                        if ( $term && ! is_wp_error( $term ) ) {
                                                $items[] = array(
                                                        'label' => $term->name,
                                                        'url'   => get_category_link( $term ),
                                                );
                                        }
                                }

                                $items[] = array(
                                        'label' => $primary->name,
                                        'url'   => get_category_link( $primary ),
                                );
                        }
                }

                $items[] = array(
                        'label' => get_the_title( $post ),
                        'url'   => get_permalink( $post ),
                );

                return $items;
        }

        if ( is_category() || is_tag() || is_tax() ) {
                $term = get_queried_object();
                if ( $term && ! is_wp_error( $term ) ) {
                        $ancestors = array_reverse( get_ancestors( $term->term_id, $term->taxonomy ) );
                        foreach ( $ancestors as $ancestor_id ) {
                                $ancestor = get_term( $ancestor_id, $term->taxonomy );
                                if ( $ancestor && ! is_wp_error( $ancestor ) ) {
                                        $items[] = array(
                                                'label' => $ancestor->name,
                                                'url'   => get_term_link( $ancestor ),
                                        );
                                }
                        }

                        $items[] = array(
                                'label' => $term->name,
                                'url'   => get_term_link( $term ),
                        );
                }

                return $items;
        }

        if ( is_post_type_archive() ) {
                $post_type = get_queried_object();
                if ( $post_type && isset( $post_type->labels->name ) ) {
                        $items[] = array(
                                'label' => $post_type->labels->name,
                                'url'   => get_post_type_archive_link( $post_type->name ),
                        );
                }

                return $items;
        }

        if ( is_author() ) {
                $author = get_queried_object();
                if ( $author && isset( $author->display_name ) ) {
                        $items[] = array(
                                'label' => $author->display_name,
                                'url'   => get_author_posts_url( $author->ID ),
                        );
                }

                return $items;
        }

        if ( is_search() ) {
                $items[] = array(
                        'label' => sprintf( __( 'Suche nach "%s"', 'beyond_gotham' ), get_search_query() ),
                        'url'   => get_search_link(),
                );
                return $items;
        }

        if ( is_404() ) {
                $request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/404';

                $items[] = array(
                        'label' => __( 'Seite nicht gefunden', 'beyond_gotham' ),
                        'url'   => home_url( $request_uri ),
                );
                return $items;
        }

        return $items;
}

/**
 * Provide SEO data for preview script.
 *
 * @return array
 */
function beyond_gotham_get_seo_preview_data() {
        $settings = beyond_gotham_get_seo_settings();

        return array(
                'titleFormat'   => $settings['title_format'],
                'openGraph'     => $settings['open_graph'],
                'breadcrumbs'   => $settings['breadcrumbs'],
                'robots'        => $settings['robots'],
                'pluginActive'  => beyond_gotham_seo_plugin_active(),
        );
}
