<?php
/**
 * Theme functions and definitions for Beyond Gotham.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'BEYOND_GOTHAM_VERSION' ) ) {
    define( 'BEYOND_GOTHAM_VERSION', '0.1.0' );
}

// Load the shared post meta helpers before any consumer touches them.
require_once get_template_directory() . '/inc/post-meta.php';

if ( ! function_exists( 'beyond_gotham_asset_version' ) ) {
    /**
     * Resolve a file version based on the file modification time.
     *
     * @param string $relative_path Asset path relative to the theme root.
     * @return string
     */
    function beyond_gotham_asset_version( $relative_path ) {
        $file_path = trailingslashit( get_template_directory() ) . ltrim( $relative_path, '/' );

        if ( file_exists( $file_path ) ) {
            return (string) filemtime( $file_path );
        }

        return BEYOND_GOTHAM_VERSION;
    }
}

if ( ! function_exists( 'beyond_gotham_theme_setup' ) ) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function beyond_gotham_theme_setup() {
        load_theme_textdomain( 'beyond_gotham', get_template_directory() . '/languages' );

        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_image_size( 'bg-card', 640, 400, true );
        add_image_size( 'bg-thumb', 320, 200, true );
        add_image_size( 'bg-hero', 1440, 720, true );
        add_theme_support( 'custom-logo', array(
            'height'      => 120,
            'width'       => 120,
            'flex-height' => true,
            'flex-width'  => true,
        ) );
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
        add_theme_support( 'editor-styles' );
        add_editor_style( 'assets/editor.css' );
        add_theme_support( 'wp-block-styles' );
        add_theme_support( 'align-wide' );
        add_theme_support( 'responsive-embeds' );
        add_theme_support( 'woocommerce' );

        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'beyond_gotham' ),
            'footer'  => __( 'Footer Menu', 'beyond_gotham' ),
            'menu-2'  => __( 'Social Links Menu', 'beyond_gotham' ),
        ) );
    }
}
add_action( 'after_setup_theme', 'beyond_gotham_theme_setup' );

/**
 * Extend body classes with Beyond Gotham layout helpers.
 *
 * @param array $classes Default body classes.
 * @return array
 */
function beyond_gotham_body_classes( $classes ) {
    $classes[] = 'bg-site';
    $classes[] = 'bg-ui-loading';
    $classes[] = 'theme-light';

    if ( function_exists( 'beyond_gotham_get_navigation_settings' ) ) {
        $nav_settings = beyond_gotham_get_navigation_settings();

        if ( function_exists( 'beyond_gotham_get_nav_alignment_class' ) ) {
            $classes[] = beyond_gotham_get_nav_alignment_class();
        }

        if ( ! empty( $nav_settings['sticky'] ) ) {
            $classes[] = 'bg-has-sticky-header';
        } else {
            $classes[] = 'bg-no-sticky-header';
        }
    } else {
        $classes[] = 'nav-align-space-between';
        $classes[] = 'bg-has-sticky-header';
    }

    if ( function_exists( 'beyond_gotham_is_branding_text_only' ) && beyond_gotham_is_branding_text_only() ) {
        $classes[] = 'brand-text-only';
    }

    if ( function_exists( 'beyond_gotham_get_cta_layout_settings' ) ) {
        $cta_layout = beyond_gotham_get_cta_layout_settings();

        if ( isset( $cta_layout['show_mobile'] ) && ! $cta_layout['show_mobile'] ) {
            $classes[] = 'hide-cta-mobile';
        }
    }

    if ( function_exists( 'beyond_gotham_get_sticky_cta_settings' ) ) {
        $sticky_cta = beyond_gotham_get_sticky_cta_settings();

        if ( ! empty( $sticky_cta['enabled'] ) ) {
            $classes[] = 'bg-has-sticky-cta';
        }

        if ( isset( $sticky_cta['show_mobile'] ) && ! $sticky_cta['show_mobile'] ) {
            $classes[] = 'hide-sticky-cta-mobile';
        }

        if ( isset( $sticky_cta['show_desktop'] ) && ! $sticky_cta['show_desktop'] ) {
            $classes[] = 'hide-sticky-cta-desktop';
        }
    }

    return array_unique( $classes );
}
add_filter( 'body_class', 'beyond_gotham_body_classes' );

/**
 * Output an inline script that resolves the preferred color scheme early in the render path.
 */
function beyond_gotham_output_theme_pref_script() {
    ?>
    <script>
      (function () {
        var doc = document.documentElement;
        if (!doc) {
          return;
        }

        var storedTheme = null;
        try {
          storedTheme = window.localStorage.getItem('themeMode');
        } catch (error) {
          storedTheme = null;
        }

        var theme = storedTheme === 'dark' || storedTheme === 'light' ? storedTheme : null;

        if (!theme && window.matchMedia) {
          try {
            theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
          } catch (error) {
            theme = null;
          }
        }

        if (!theme) {
          theme = 'light';
        }

        doc.classList.remove('theme-light', 'theme-dark');
        doc.classList.add('theme-' + theme);
        doc.setAttribute('data-theme', theme);
      }());
    </script>
    <?php
}
add_action( 'wp_head', 'beyond_gotham_output_theme_pref_script', 0 );

/**
 * Detect social network slug from URL.
 *
 * @param string $url Social URL.
 * @return string
 */
function beyond_gotham_detect_social_network( $url ) {
    if ( ! $url ) {
        return '';
    }

    $url       = trim( $url );
    $lower_url = strtolower( $url );

    if ( 0 === strpos( $lower_url, 'mailto:' ) ) {
        return 'email';
    }

    if ( false !== strpos( $lower_url, '@' ) && false === strpos( $lower_url, '://' ) && false === strpos( $lower_url, '/' ) ) {
        return 'mastodon';
    }

    $host = wp_parse_url( $url, PHP_URL_HOST );
    if ( ! $host ) {
        return '';
    }

    $host = strtolower( $host );

    $networks = array(
        'twitter'   => array( 'twitter.com', 'x.com' ),
        'instagram' => array( 'instagram.com' ),
        'facebook'  => array( 'facebook.com', 'fb.com' ),
        'linkedin'  => array( 'linkedin.com' ),
        'youtube'   => array( 'youtube.com', 'youtu.be' ),
        'mastodon'  => array( 'mastodon.social' ),
        'github'    => array( 'github.com' ),
        'tiktok'    => array( 'tiktok.com' ),
        'telegram'  => array( 't.me', 'telegram.me', 'telegram.org' ),
    );

    foreach ( $networks as $slug => $candidates ) {
        foreach ( $candidates as $candidate ) {
            if ( false !== strpos( $host, $candidate ) ) {
                return $slug;
            }
        }
    }

    return sanitize_title( str_replace( 'www.', '', $host ) );
}

if ( ! function_exists( 'beyond_gotham_prepare_social_icon_items' ) ) {
    /**
     * Prepare normalized social icon data for template rendering.
     *
     * @param array|null $links Optional associative array of network => url pairs.
     * @param array      $args  Optional arguments.
     *
     * @return array[]
     */
    function beyond_gotham_prepare_social_icon_items( $links = null, $args = array() ) {
        if ( null === $links && function_exists( 'beyond_gotham_get_social_links' ) ) {
            $links = beyond_gotham_get_social_links();
        }

        if ( ! is_array( $links ) ) {
            $links = array();
        }

        $defaults = array(
            'include_empty' => false,
            'order'         => array(),
        );

        $args = wp_parse_args( $args, $defaults );

        $icons = function_exists( 'beyond_gotham_get_social_icon_svgs' ) ? beyond_gotham_get_social_icon_svgs() : array();

        if ( empty( $icons ) || ! is_array( $icons ) ) {
            return array();
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

        $order = array();

        if ( ! empty( $args['order'] ) ) {
            foreach ( (array) $args['order'] as $value ) {
                $key = sanitize_key( $value );

                if ( '' !== $key ) {
                    $order[] = $key;
                }
            }
        }

        $normalized_links = array();

        foreach ( $links as $network => $url ) {
            if ( ! is_string( $network ) ) {
                continue;
            }

            $key = sanitize_key( $network );

            if ( '' === $key ) {
                continue;
            }

            $normalized_links[ $key ] = is_string( $url ) ? trim( $url ) : '';

            if ( ! in_array( $key, $order, true ) ) {
                $order[] = $key;
            }
        }

        if ( empty( $order ) ) {
            $order = array_keys( $icons );
        } else {
            // Append any remaining icon keys to ensure consistent ordering when previewing empty states.
            foreach ( array_keys( $icons ) as $icon_key ) {
                if ( ! in_array( $icon_key, $order, true ) ) {
                    $order[] = $icon_key;
                }
            }
        }

        $include_empty = ! empty( $args['include_empty'] );
        $items         = array();

        foreach ( $order as $network ) {
            $url      = isset( $normalized_links[ $network ] ) ? $normalized_links[ $network ] : '';
            $url      = is_string( $url ) ? trim( $url ) : '';
            $is_empty = '' === $url;

            if ( $is_empty && ! $include_empty ) {
                continue;
            }

            $slug = $network;

            if ( ! $is_empty ) {
                $detected = beyond_gotham_detect_social_network( $url );

                if ( $detected ) {
                    $slug = $detected;
                }
            }

            if ( ! isset( $icons[ $slug ] ) ) {
                if ( isset( $icons[ $network ] ) ) {
                    $slug = $network;
                } elseif ( $is_empty ) {
                    continue;
                } else {
                    continue;
                }
            }

            $label_key = isset( $labels[ $slug ] ) ? $slug : $network;
            $label     = isset( $labels[ $label_key ] ) ? $labels[ $label_key ] : ucfirst( $label_key );
            $is_mail   = false;

            if ( ! $is_empty ) {
                if ( 'email' === $slug && 0 !== strpos( $url, 'mailto:' ) ) {
                    $url = 'mailto:' . ltrim( $url );
                }

                $is_mail = 0 === strpos( $url, 'mailto:' );
            }

            $items[] = array(
                'network'  => $network,
                'slug'     => $slug,
                'url'      => $url,
                'label'    => $label,
                'icon'     => $icons[ $slug ],
                'is_mail'  => $is_mail,
                'is_empty' => $is_empty,
            );
        }

        /**
         * Filter the prepared social icon items.
         *
         * @param array $items Prepared icon data.
         * @param array $args  Arguments used for preparation.
         */
        return apply_filters( 'beyond_gotham_social_icon_items', $items, $args );
    }
}

/**
 * Adjust navigation link attributes for accessibility and styling.
 *
 * @param array    $atts  Default attributes.
 * @param WP_Post  $item  Menu item instance.
 * @param stdClass $args  Menu arguments.
 * @param int      $depth Menu depth.
 *
 * @return array
 */
function beyond_gotham_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
    $classes = isset( $item->classes ) ? (array) $item->classes : array();

    if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
        $current_classes = array( 'current-menu-item', 'current_page_parent', 'current-menu-ancestor', 'current_page_ancestor' );
        if ( array_intersect( $current_classes, $classes ) ) {
            $atts['aria-current'] = 'page';
        }
    }

    if ( isset( $args->theme_location ) && 'menu-2' === $args->theme_location ) {
        $atts['class'] = isset( $atts['class'] ) ? $atts['class'] . ' bg-social-link' : 'bg-social-link';

        if ( ! empty( $item->title ) ) {
            $atts['aria-label'] = $item->title;
        }

        $network = beyond_gotham_detect_social_network( $item->url );
        if ( $network ) {
            $atts['data-network'] = $network;
        }
    }

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'beyond_gotham_nav_menu_link_attributes', 10, 4 );

/**
 * Inject icon markup for social navigation links.
 *
 * @param stdClass $args Menu arguments.
 * @param WP_Post  $item Menu item instance.
 * @param int      $depth Menu depth.
 *
 * @return stdClass
 */
function beyond_gotham_nav_menu_item_args( $args, $item, $depth ) {
    if ( isset( $args->theme_location ) && 'menu-2' === $args->theme_location ) {
        $initial = function_exists( 'mb_substr' )
            ? mb_strtoupper( mb_substr( $item->title, 0, 2 ) )
            : strtoupper( substr( $item->title, 0, 2 ) );

        $args->link_before = '<span class="bg-social-link__icon" aria-hidden="true" data-initial="' . esc_attr( $initial ) . '"></span><span class="bg-social-link__text">';
        $args->link_after  = '</span>';
    }

    return $args;
}
add_filter( 'nav_menu_item_args', 'beyond_gotham_nav_menu_item_args', 10, 3 );

/**
 * Add a custom class to the admin body when using the block editor.
 *
 * @param string $classes Existing admin body classes.
 *
 * @return string
 */
function beyond_gotham_editor_body_class( $classes ) {
    if ( ! function_exists( 'get_current_screen' ) ) {
        return $classes;
    }

    $screen = get_current_screen();

    if ( $screen && method_exists( $screen, 'is_block_editor' ) && $screen->is_block_editor() ) {
        $classes .= ' beyond-gotham-editor';
    }

    return $classes;
}
add_filter( 'admin_body_class', 'beyond_gotham_editor_body_class' );

/**
 * Enqueue scripts and styles.
 */
function beyond_gotham_enqueue_assets() {
    $style_version  = beyond_gotham_asset_version( 'dist/style.css' );
    $script_version = beyond_gotham_asset_version( 'dist/theme.js' );

    wp_enqueue_style(
        'beyond-gotham-style',
        get_template_directory_uri() . '/dist/style.css',
        array(),
        $style_version
    );

    wp_enqueue_script(
        'beyond-gotham-theme',
        get_template_directory_uri() . '/dist/theme.js',
        array(),
        $script_version,
        true
    );

    wp_script_add_data( 'beyond-gotham-theme', 'defer', true );

    wp_localize_script(
        'beyond-gotham-theme',
        'BG_AJAX',
        array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'bg_ajax_nonce' ),
            'messages' => array(
                'genericError' => __( 'Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.', 'beyond_gotham' ),
                'rateLimited'  => __( 'Bitte versuchen Sie es in einigen Minuten erneut.', 'beyond_gotham' ),
                'sending'      => __( 'Wird gesendet …', 'beyond_gotham' ),
            ),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'beyond_gotham_enqueue_assets' );

/**
 * Customize WooCommerce wrappers to align with the theme layout.
 */
function beyond_gotham_woocommerce_wrapper_before() {
    echo '<main id="primary" class="site-main bg-woocommerce"><div class="bg-woocommerce__inner">';
}

/**
 * Close the custom WooCommerce wrapper.
 */
function beyond_gotham_woocommerce_wrapper_after() {
    echo '</div></main>';
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'beyond_gotham_woocommerce_wrapper_before', 10 );
add_action( 'woocommerce_after_main_content', 'beyond_gotham_woocommerce_wrapper_after', 10 );

/**
 * Ensure shop buttons use the Beyond Gotham CTA styling.
 *
 * @param array           $args    Arguments used to generate the button.
 * @param WC_Product|null $product The related product instance.
 *
 * @return array
 */
function beyond_gotham_woocommerce_add_to_cart_args( $args, $product ) {
    if ( isset( $args['class'] ) ) {
        $args['class'] .= ' bg-cta-button';
    } else {
        $args['class'] = 'bg-cta-button';
    }

    return $args;
}
add_filter( 'woocommerce_loop_add_to_cart_args', 'beyond_gotham_woocommerce_add_to_cart_args', 10, 2 );

/**
 * Ensure the single product add to cart button uses the CTA styling.
 *
 * @param string     $classes Button classes string.
 * @param WC_Product $product Product instance.
 *
 * @return string
 */
function beyond_gotham_single_add_to_cart_classes( $classes, $product ) {
    if ( false === strpos( $classes, 'bg-cta-button' ) ) {
        $classes .= ' bg-cta-button';
    }

    return $classes;
}
add_filter( 'woocommerce_product_single_add_to_cart_classes', 'beyond_gotham_single_add_to_cart_classes', 10, 2 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

/**
 * Output the single product price within the Beyond Gotham price wrapper.
 */
function beyond_gotham_single_product_price() {
    echo '<div class="bg-price">';
    woocommerce_template_single_price();
    echo '</div>';
}
add_action( 'woocommerce_single_product_summary', 'beyond_gotham_single_product_price', 10 );

/**
 * Replace the default WooCommerce loop wrappers with a grid container.
 *
 * @param string $markup The default opening markup.
 *
 * @return string
 */
function beyond_gotham_woocommerce_product_loop_start( $markup ) {
    return '<div class="product-grid">';
}
add_filter( 'woocommerce_product_loop_start', 'beyond_gotham_woocommerce_product_loop_start' );

/**
 * Close the custom product grid container.
 *
 * @param string $markup The default closing markup.
 *
 * @return string
 */
function beyond_gotham_woocommerce_product_loop_end( $markup ) {
    return '</div>';
}
add_filter( 'woocommerce_product_loop_end', 'beyond_gotham_woocommerce_product_loop_end' );

/**
 * Add a placeholder shipping information tab on single product pages.
 *
 * @param array $tabs Existing WooCommerce product tabs.
 *
 * @return array
 */
function beyond_gotham_woocommerce_product_tabs( $tabs ) {
    $tabs['bg_shipping'] = array(
        'title'    => __( 'Shipping', 'beyond_gotham' ),
        'priority' => 35,
        'callback' => 'beyond_gotham_woocommerce_shipping_tab_content',
    );

    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'beyond_gotham_woocommerce_product_tabs' );

/**
 * Output placeholder content for the shipping tab.
 */
function beyond_gotham_woocommerce_shipping_tab_content() {
    echo '<div class="bg-product-shipping">';
    echo '<p>' . esc_html__( 'Shipping details will be updated soon. Expect fast, secure delivery across Gotham and beyond.', 'beyond_gotham' ) . '</p>';
    echo '</div>';
}

/**
 * Ensure lazy loading defaults for images and prefer async decoding.
 *
 * @param array        $attr       Existing attributes.
 * @param WP_Post      $attachment Attachment instance.
 * @param string|array $size       Image size.
 *
 * @return array
 */
function beyond_gotham_image_attributes( $attr, $attachment, $size ) {
    $classes = isset( $attr['class'] ) ? (string) $attr['class'] : '';

    if ( false !== strpos( $classes, 'custom-logo' ) ) {
        $attr['loading']       = 'eager';
        $attr['fetchpriority'] = 'high';
    } elseif ( empty( $attr['loading'] ) ) {
        $attr['loading'] = 'lazy';
    }

    if ( empty( $attr['decoding'] ) ) {
        $attr['decoding'] = 'async';
    }

    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'beyond_gotham_image_attributes', 10, 3 );

/**
 * Render the sticky CTA bar if configured.
 */
function beyond_gotham_render_sticky_cta_bar() {
    if ( ! function_exists( 'beyond_gotham_get_sticky_cta_settings' ) ) {
        return;
    }

    $settings = beyond_gotham_get_sticky_cta_settings();

    $has_content = ! empty( $settings['has_content'] );
    $has_link    = ! empty( $settings['has_link'] );

    $classes = array( 'sticky-cta' );

    if ( ! empty( $settings['is_empty'] ) ) {
        $classes[] = 'sticky-cta--empty';
    }

    if ( empty( $settings['enabled'] ) ) {
        $classes[] = 'sticky-cta--disabled';
    }

    $attributes = array(
        'class'             => implode( ' ', array_map( 'sanitize_html_class', array_unique( $classes ) ) ),
        'data-bg-sticky-cta' => 'true',
        'data-active'       => ! empty( $settings['active'] ) ? 'true' : 'false',
        'data-enabled'      => ! empty( $settings['enabled'] ) ? 'true' : 'false',
        'data-delay'        => isset( $settings['delay_ms'] ) ? (string) (int) $settings['delay_ms'] : '0',
        'data-trigger'      => isset( $settings['trigger'] ) ? (string) $settings['trigger'] : 'delay',
        'data-scroll-depth' => isset( $settings['scroll_depth'] ) ? (string) (int) $settings['scroll_depth'] : '0',
        'data-trigger-selector' => isset( $settings['trigger_selector'] ) ? (string) $settings['trigger_selector'] : '',
        'data-show-desktop' => ! empty( $settings['show_desktop'] ) ? 'true' : 'false',
        'data-show-mobile'  => ! empty( $settings['show_mobile'] ) ? 'true' : 'false',
        'data-has-content'  => $has_content ? 'true' : 'false',
        'data-has-link'     => $has_link ? 'true' : 'false',
        'data-empty'        => ( $has_content || $has_link ) ? 'false' : 'true',
        'role'              => 'region',
        'aria-label'        => esc_attr__( 'Call-to-Action', 'beyond_gotham' ),
        'aria-hidden'       => 'true',
    );

    if ( empty( $settings['enabled'] ) ) {
        $attributes['hidden'] = true;
    }

    $style_rules = array();

    if ( ! empty( $settings['background'] ) ) {
        $style_rules[] = '--sticky-cta-bg: ' . $settings['background'] . ';';
    }

    if ( ! empty( $settings['text_color'] ) ) {
        $style_rules[] = '--sticky-cta-text: ' . $settings['text_color'] . ';';
    }

    if ( ! empty( $settings['button_color'] ) ) {
        $style_rules[] = '--sticky-cta-button-bg: ' . $settings['button_color'] . ';';
    }

    if ( ! empty( $settings['button_text_color'] ) ) {
        $style_rules[] = '--sticky-cta-button-text: ' . $settings['button_text_color'] . ';';
    }

    if ( ! empty( $style_rules ) ) {
        $attributes['style'] = implode( ' ', $style_rules );
    }

    $button_label = apply_filters( 'beyond_gotham_sticky_cta_button_label', __( 'Jetzt informieren', 'beyond_gotham' ), $settings );
    $button_label = is_string( $button_label ) ? $button_label : '';

    $button_attributes = array(
        'data-bg-sticky-cta-button' => true,
    );

    if ( $has_link && ! empty( $settings['link'] ) ) {
        $button_attributes['href'] = $settings['link'];
    } else {
        $button_attributes['aria-disabled'] = 'true';
        $button_attributes['tabindex']      = '-1';
        $button_attributes['hidden']        = true;
    }

    $wrapper_attributes = $attributes;

    if ( empty( $settings['enabled'] ) ) {
        $wrapper_attributes['hidden'] = true;
    }

    get_template_part(
        'template-parts/components/sticky-cta',
        null,
        array(
            'wrapper_attributes' => $wrapper_attributes,
            'content'            => $has_content ? $settings['content'] : '',
            'button'             => array(
                'label'      => $button_label,
                'url'        => $has_link ? $settings['link'] : '',
                'attributes' => $button_attributes,
            ),
            'close_label'        => __( 'CTA schließen', 'beyond_gotham' ),
        )
    );
}
add_action( 'wp_footer', 'beyond_gotham_render_sticky_cta_bar', 15 );

/**
 * Enhance custom logo markup with high priority loading hints.
 *
 * @param string $html Custom logo HTML.
 * @return string
 */
function beyond_gotham_custom_logo_attributes( $html ) {
    if ( false === strpos( $html, 'loading=' ) ) {
        $html = str_replace( '<img ', '<img loading="eager" decoding="async" fetchpriority="high" ', $html );
    }

    return $html;
}
add_filter( 'get_custom_logo', 'beyond_gotham_custom_logo_attributes' );

/**
 * Remove emoji scripts and styles for leaner pages.
 */
function beyond_gotham_disable_emoji() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'beyond_gotham_disable_emoji' );

/**
 * Remove the wp-embed script on the front end when it is not needed.
 */
function beyond_gotham_disable_wp_embed() {
    wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_enqueue_scripts', 'beyond_gotham_disable_wp_embed', 100 );

/**
 * Allow uploading modern image formats.
 *
 * @param array $mimes Allowed mime types.
 * @return array
 */
function beyond_gotham_enable_modern_image_mimes( $mimes ) {
    $mimes['webp']  = 'image/webp';
    $mimes['woff2'] = 'font/woff2';

    return $mimes;
}
add_filter( 'upload_mimes', 'beyond_gotham_enable_modern_image_mimes' );

/**
 * Determine whether the CTA box should be displayed on the current view.
 *
 * @return bool
 */
function should_display_cta() {
    if ( ! function_exists( 'beyond_gotham_get_cta_settings' ) ) {
        return true;
    }

    $settings = beyond_gotham_get_cta_settings();

    $scope    = isset( $settings['visibility_scope'] ) && is_array( $settings['visibility_scope'] ) ? $settings['visibility_scope'] : array();
    $excluded = isset( $settings['exclude_pages'] ) && is_array( $settings['exclude_pages'] ) ? array_map( 'absint', $settings['exclude_pages'] ) : array();

    $queried_id = get_queried_object_id();

    if ( $queried_id && in_array( (int) $queried_id, $excluded, true ) ) {
        return false;
    }

    if ( empty( $scope ) ) {
        return false;
    }

    $conditions = array(
        'front_page' => is_front_page(),
        'posts'      => is_singular( 'post' ),
        'courses'    => is_singular( 'bg_course' ),
        'products'   => function_exists( 'is_product' ) ? is_product() : false,
    );

    if ( in_array( 'all', $scope, true ) ) {
        return apply_filters( 'beyond_gotham_should_display_cta', true, $settings, $conditions );
    }

    foreach ( $conditions as $key => $result ) {
        if ( in_array( $key, $scope, true ) && $result ) {
            return apply_filters( 'beyond_gotham_should_display_cta', true, $settings, $conditions );
        }
    }

    return apply_filters( 'beyond_gotham_should_display_cta', false, $settings, $conditions );
}

require_once get_template_directory() . '/inc/customizer/loader.php';
require_once get_template_directory() . '/inc/rest-api.php';
require_once get_template_directory() . '/inc/blocks.php';
