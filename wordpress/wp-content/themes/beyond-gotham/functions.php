<?php
/**
 * Theme functions and definitions for Beyond Gotham.
 *
 * @package beyond_gotham
 */

if ( ! defined( 'BEYOND_GOTHAM_VERSION' ) ) {
    define( 'BEYOND_GOTHAM_VERSION', '0.1.0' );
}

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
        add_theme_support(
            'editor-color-palette',
            array(
                array(
                    'name'  => __( 'Gotham Midnight', 'beyond_gotham' ),
                    'slug'  => 'gotham-midnight',
                    'color' => '#0b1d2a',
                ),
                array(
                    'name'  => __( 'Skyline Gray', 'beyond_gotham' ),
                    'slug'  => 'skyline-gray',
                    'color' => '#4c5b68',
                ),
                array(
                    'name'  => __( 'Signal Yellow', 'beyond_gotham' ),
                    'slug'  => 'signal-yellow',
                    'color' => '#f2b705',
                ),
                array(
                    'name'  => __( 'Beacon Red', 'beyond_gotham' ),
                    'slug'  => 'beacon-red',
                    'color' => '#d43a3a',
                ),
            )
        );
        add_theme_support(
            'editor-font-sizes',
            array(
                array(
                    'name' => __( 'Small', 'beyond_gotham' ),
                    'size' => 14,
                    'slug' => 'small',
                ),
                array(
                    'name' => __( 'Default', 'beyond_gotham' ),
                    'size' => 16,
                    'slug' => 'default',
                ),
                array(
                    'name' => __( 'Large', 'beyond_gotham' ),
                    'size' => 20,
                    'slug' => 'large',
                ),
                array(
                    'name' => __( 'Display', 'beyond_gotham' ),
                    'size' => 32,
                    'slug' => 'display',
                ),
            )
        );
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

    if ( function_exists( 'beyond_gotham_get_nav_layout_settings' ) ) {
        $nav_layout = beyond_gotham_get_nav_layout_settings();

        $orientation = isset( $nav_layout['orientation'] ) ? $nav_layout['orientation'] : 'horizontal';
        $position    = isset( $nav_layout['position'] ) ? $nav_layout['position'] : 'right';
        $dropdown    = isset( $nav_layout['dropdown'] ) ? $nav_layout['dropdown'] : 'down';

        $classes[] = 'nav-' . ( 'vertical' === $orientation ? 'vertical' : 'horizontal' );

        $allowed_positions = array( 'left', 'center', 'right', 'below' );
        if ( ! in_array( $position, $allowed_positions, true ) ) {
            $position = 'right';
        }
        $classes[] = 'nav-position-' . $position;

        $classes[] = 'nav-dropdown-' . ( 'right' === $dropdown ? 'right' : 'down' );

        if ( ! empty( $nav_layout['sticky'] ) ) {
            $classes[] = 'bg-has-sticky-header';
        }
    } else {
        $classes[] = 'nav-horizontal';
        $classes[] = 'nav-position-right';
        $classes[] = 'nav-dropdown-down';
        $classes[] = 'bg-has-sticky-header';
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

    $host = wp_parse_url( $url, PHP_URL_HOST );
    if ( ! $host ) {
        return '';
    }

    $networks = array(
        'twitter'   => array( 'twitter.com', 'x.com' ),
        'instagram' => array( 'instagram.com' ),
        'facebook'  => array( 'facebook.com' ),
        'linkedin'  => array( 'linkedin.com' ),
        'youtube'   => array( 'youtube.com', 'youtu.be' ),
        'mastodon'  => array( 'mastodon.social' ),
        'github'    => array( 'github.com' ),
    );

    foreach ( $networks as $slug => $candidates ) {
        foreach ( $candidates as $candidate ) {
            if ( false !== stripos( $host, $candidate ) ) {
                return $slug;
            }
        }
    }

    return sanitize_title( str_replace( 'www.', '', $host ) );
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
    $mimes['webp'] = 'image/webp';

    return $mimes;
}
add_filter( 'upload_mimes', 'beyond_gotham_enable_modern_image_mimes' );

require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/rest-api.php';
require_once get_template_directory() . '/inc/blocks.php';
