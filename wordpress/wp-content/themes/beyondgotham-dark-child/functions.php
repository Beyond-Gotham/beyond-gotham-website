<?php
/**
 * BeyondGotham Dark Child Theme functions
 *
 * @package BeyondGothamDarkChild
 */

defined('ABSPATH') || exit;

// -----------------------------------------------------------------------------
// Theme constants
// -----------------------------------------------------------------------------

define('BG_THEME_VERSION', wp_get_theme()->get('Version'));
define('BG_THEME_DIR', get_stylesheet_directory());
define('BG_THEME_URI', get_stylesheet_directory_uri());

// -----------------------------------------------------------------------------
// Includes
// -----------------------------------------------------------------------------

require_once BG_THEME_DIR . '/inc/custom-post-types.php';
require_once BG_THEME_DIR . '/inc/enrollment-form.php';
require_once BG_THEME_DIR . '/inc/course-pages.php';

// -----------------------------------------------------------------------------
// Theme setup
// -----------------------------------------------------------------------------

add_action('after_setup_theme', 'bg_setup_theme');
/**
 * Register theme supports and menus.
 */
function bg_setup_theme() {
    load_child_theme_textdomain('beyondgotham-dark-child', BG_THEME_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('custom-logo');

    add_image_size('bg-card', 640, 400, true);
    add_image_size('bg-thumb', 320, 200, true);
    add_image_size('bg-hero', 1440, 720, true);

    register_nav_menus([
        'primary' => __('Hauptmenü', 'beyondgotham-dark-child'),
        'footer'  => __('Footer-Menü', 'beyondgotham-dark-child'),
        'menu-2'  => __('Social Links', 'beyondgotham-dark-child'),
    ]);
}

// -----------------------------------------------------------------------------
// Asset loading
// -----------------------------------------------------------------------------

add_action('wp_enqueue_scripts', 'bg_enqueue_assets');
/**
 * Enqueue front-end assets.
 */
function bg_enqueue_assets() {
    $parent_theme = wp_get_theme('freenews');
    $parent_version = $parent_theme ? $parent_theme->get('Version') : null;

    wp_enqueue_style(
        'bg-parent-theme',
        get_template_directory_uri() . '/style.css',
        [],
        $parent_version
    );

    wp_enqueue_style(
        'bg-theme',
        BG_THEME_URI . '/style.css',
        ['bg-parent-theme'],
        BG_THEME_VERSION
    );

    wp_enqueue_style(
        'bg-frontend',
        BG_THEME_URI . '/assets/css/frontend.css',
        ['bg-theme'],
        BG_THEME_VERSION
    );

    wp_enqueue_script(
        'bg-ui',
        BG_THEME_URI . '/assets/js/ui.js',
        [],
        BG_THEME_VERSION,
        true
    );
    wp_script_add_data('bg-ui', 'defer', true);

    wp_enqueue_script(
        'bg-frontend',
        BG_THEME_URI . '/assets/js/frontend.js',
        ['jquery'],
        BG_THEME_VERSION,
        true
    );

    wp_localize_script('bg-frontend', 'BG_AJAX', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('bg_ajax_nonce'),
        'messages' => [
            'genericError' => __('Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.', 'beyondgotham-dark-child'),
            'rateLimited'  => __('Bitte versuchen Sie es in einigen Minuten erneut.', 'beyondgotham-dark-child'),
            'sending'       => __('Wird gesendet …', 'beyondgotham-dark-child'),
        ],
    ]);
}

add_action('admin_enqueue_scripts', 'bg_enqueue_admin_assets');
/**
 * Load admin-only assets.
 *
 * @param string $hook Admin page identifier.
 */
function bg_enqueue_admin_assets($hook) {
    wp_enqueue_style(
        'bg-admin',
        BG_THEME_URI . '/assets/css/admin.css',
        [],
        BG_THEME_VERSION
    );
}

// -----------------------------------------------------------------------------
// Media helpers & metadata
// -----------------------------------------------------------------------------

add_filter('image_size_names_choose', 'bg_register_custom_image_sizes');
/**
 * Expose custom image sizes in the editor.
 *
 * @param array $sizes Available sizes.
 * @return array
 */
function bg_register_custom_image_sizes($sizes) {
    $sizes['bg-card'] = __('Karte (640×400)', 'beyondgotham-dark-child');
    $sizes['bg-thumb'] = __('Vorschau (320×200)', 'beyondgotham-dark-child');
    $sizes['bg-hero'] = __('Hero (1440×720)', 'beyondgotham-dark-child');

    return $sizes;
}

add_filter('wp_get_attachment_image_attributes', 'bg_adjust_attachment_image_attributes', 10, 3);
/**
 * Ensure responsive attributes & lazy loading for theme images.
 *
 * @param array        $attr       Attributes for the image markup.
 * @param WP_Post      $attachment Attachment object.
 * @param string|array $size       Requested size.
 * @return array
 */
function bg_adjust_attachment_image_attributes($attr, $attachment, $size) {
    if (empty($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }

    if (empty($attr['decoding'])) {
        $attr['decoding'] = 'async';
    }

    if (is_string($size)) {
        switch ($size) {
            case 'bg-card':
                $attr['sizes'] = '(min-width: 1280px) 320px, (min-width: 768px) 45vw, 100vw';
                break;
            case 'bg-thumb':
                $attr['sizes'] = '(min-width: 1280px) 240px, (min-width: 768px) 30vw, 100vw';
                break;
            case 'bg-hero':
                $attr['loading'] = 'eager';
                $attr['sizes'] = '(min-width: 1280px) 1200px, 100vw';
                break;
        }
    }

    return $attr;
}

// -----------------------------------------------------------------------------
// Content helpers
// -----------------------------------------------------------------------------

add_filter('excerpt_length', 'bg_filter_excerpt_length', 20);
/**
 * Adjust excerpt length per post type context.
 *
 * @param int $length Default length.
 * @return int
 */
function bg_filter_excerpt_length($length) {
    if (is_admin()) {
        return $length;
    }

    $post_type = get_post_type();

    if ('bg_course' === $post_type) {
        return 26;
    }

    if ('post' === $post_type || is_home() || is_archive()) {
        return 28;
    }

    return $length;
}

/**
 * Calculate reading time for a post.
 *
 * @param int|WP_Post|null $post Post object or ID.
 * @param int              $wpm  Words per minute baseline.
 * @return string
 */
function bg_get_reading_time($post = null, $wpm = 180) {
    $post = get_post($post);

    if (!$post instanceof WP_Post) {
        return '';
    }

    $content = wp_strip_all_tags($post->post_content, true);
    $word_count = str_word_count($content);

    if ($word_count <= 0) {
        return '';
    }

    $wpm = (int) apply_filters('bg_reading_time_wpm', $wpm, $post);
    $wpm = max(120, $wpm);

    $minutes = (int) ceil($word_count / $wpm);

    return sprintf(
        _n('%d Minute Lesezeit', '%d Minuten Lesezeit', $minutes, 'beyondgotham-dark-child'),
        $minutes
    );
}

/**
 * Echo helper for reading time.
 *
 * @param int|WP_Post|null $post Optional post override.
 */
function bg_the_reading_time($post = null) {
    $reading_time = bg_get_reading_time($post);

    if ($reading_time) {
        echo esc_html($reading_time);
    }
}

// -----------------------------------------------------------------------------
// Navigation helpers
// -----------------------------------------------------------------------------

add_filter('body_class', 'bg_body_classes');
/**
 * Extend body classes with theme specific flags.
 *
 * @param array $classes Default classes.
 * @return array
 */
function bg_body_classes($classes) {
    $classes[] = 'bg-site';
    $classes[] = 'bg-has-sticky-header';
    $classes[] = 'bg-ui-loading';

    return array_unique($classes);
}

add_filter('nav_menu_link_attributes', 'bg_nav_menu_link_attributes', 10, 4);
/**
 * Add accessibility attributes to navigation links.
 *
 * @param array   $atts  Link attributes.
 * @param WP_Post $item  Menu item.
 * @param stdClass $args Menu arguments.
 * @param int     $depth Depth.
 * @return array
 */
function bg_nav_menu_link_attributes($atts, $item, $args, $depth) {
    $classes = isset($item->classes) ? (array) $item->classes : [];

    if (isset($args->theme_location) && 'primary' === $args->theme_location) {
        if (!empty($classes) && array_intersect($classes, ['current-menu-item', 'current_page_parent', 'current-menu-ancestor', 'current_page_ancestor'])) {
            $atts['aria-current'] = 'page';
        }
    }

    if (isset($args->theme_location) && 'menu-2' === $args->theme_location) {
        $atts['class'] = isset($atts['class']) ? $atts['class'] . ' bg-social-link' : 'bg-social-link';
        if (!empty($item->title)) {
            $atts['aria-label'] = $item->title;
        }

        $network = bg_detect_social_network($item->url);
        if ($network) {
            $atts['data-network'] = $network;
        }
    }

    return $atts;
}

add_filter('nav_menu_item_args', 'bg_adjust_social_menu_args', 10, 3);
/**
 * Inject icon markup for social menus.
 *
 * @param stdClass $args Menu arguments.
 * @param WP_Post  $item Menu item.
 * @param int      $depth Depth.
 * @return stdClass
 */
function bg_adjust_social_menu_args($args, $item, $depth) {
    if (isset($args->theme_location) && 'menu-2' === $args->theme_location) {
        $initial = function_exists('mb_substr')
            ? mb_strtoupper(mb_substr($item->title, 0, 2))
            : strtoupper(substr($item->title, 0, 2));
        $args->link_before = '<span class="bg-social-link__icon" aria-hidden="true" data-initial="' . esc_attr($initial) . '"></span><span class="bg-social-link__text">';
        $args->link_after  = '</span>';
    }

    return $args;
}

/**
 * Guess network slug from URL.
 *
 * @param string $url Social URL.
 * @return string
 */
function bg_detect_social_network($url) {
    if (!$url) {
        return '';
    }

    $host = wp_parse_url($url, PHP_URL_HOST);
    if (!$host) {
        return '';
    }

    $networks = [
        'twitter'   => ['twitter.com', 'x.com'],
        'instagram' => ['instagram.com'],
        'facebook'  => ['facebook.com'],
        'linkedin'  => ['linkedin.com'],
        'youtube'   => ['youtube.com', 'youtu.be'],
        'mastodon'  => ['mastodon.social'],
        'github'    => ['github.com'],
    ];

    foreach ($networks as $slug => $candidates) {
        foreach ($candidates as $candidate) {
            if (false !== stripos($host, $candidate)) {
                return $slug;
            }
        }
    }

    return sanitize_title(str_replace('www.', '', $host));
}

// -----------------------------------------------------------------------------
// Breadcrumbs
// -----------------------------------------------------------------------------

/**
 * Render breadcrumb navigation with schema.org markup.
 *
 * @param array $args Optional overrides.
 */
function bg_breadcrumbs($args = []) {
    if (is_front_page()) {
        return;
    }

    $defaults = [
        'class'       => 'bg-breadcrumbs',
        'aria_label'  => __('Brotkrumennavigation', 'beyondgotham-dark-child'),
        'show_on_home'=> false,
    ];

    $args = wp_parse_args($args, $defaults);

    if (is_home() && !$args['show_on_home']) {
        return;
    }

    $items = [];
    $position = 1;

    $items[] = [
        'label'    => __('Startseite', 'beyondgotham-dark-child'),
        'url'      => home_url('/'),
        'position' => $position++,
    ];

    if (is_home()) {
        $items[] = [
            'label'    => get_the_title(get_option('page_for_posts')) ?: __('Blog', 'beyondgotham-dark-child'),
            'url'      => '',
            'position' => $position++,
        ];
    } elseif (is_singular('post')) {
        $blog_page_id = (int) get_option('page_for_posts');
        if ($blog_page_id) {
            $items[] = [
                'label'    => get_the_title($blog_page_id),
                'url'      => get_permalink($blog_page_id),
                'position' => $position++,
            ];
        }

        $primary_category = null;
        $categories = get_the_category();
        if (!empty($categories)) {
            $primary_category = $categories[0];
        }

        if ($primary_category instanceof WP_Term) {
            $items[] = [
                'label'    => $primary_category->name,
                'url'      => get_category_link($primary_category),
                'position' => $position++,
            ];
        }

        $items[] = [
            'label'    => get_the_title(),
            'url'      => '',
            'position' => $position++,
        ];
    } elseif (is_singular('bg_course')) {
        $courses_page = get_page_by_path('kurse');
        if ($courses_page instanceof WP_Post) {
            $items[] = [
                'label'    => get_the_title($courses_page),
                'url'      => get_permalink($courses_page),
                'position' => $position++,
            ];
        }

        $terms = wp_get_post_terms(get_the_ID(), 'bg_course_category');
        if (!empty($terms) && !is_wp_error($terms)) {
            $items[] = [
                'label'    => $terms[0]->name,
                'url'      => get_term_link($terms[0]),
                'position' => $position++,
            ];
        }

        $items[] = [
            'label'    => get_the_title(),
            'url'      => '',
            'position' => $position++,
        ];
    } elseif (is_category()) {
        $queried = get_queried_object();
        if ($queried instanceof WP_Term) {
            $items[] = [
                'label'    => $queried->name,
                'url'      => '',
                'position' => $position++,
            ];
        }
    } elseif (is_post_type_archive('bg_course')) {
        $items[] = [
            'label'    => post_type_archive_title('', false),
            'url'      => '',
            'position' => $position++,
        ];
    } elseif (is_page()) {
        $ancestors = get_post_ancestors(get_the_ID());
        $ancestors = array_reverse($ancestors);
        foreach ($ancestors as $ancestor_id) {
            $items[] = [
                'label'    => get_the_title($ancestor_id),
                'url'      => get_permalink($ancestor_id),
                'position' => $position++,
            ];
        }

        $items[] = [
            'label'    => get_the_title(),
            'url'      => '',
            'position' => $position++,
        ];
    } elseif (is_search()) {
        $items[] = [
            'label'    => sprintf(__('Suche: %s', 'beyondgotham-dark-child'), get_search_query()),
            'url'      => '',
            'position' => $position++,
        ];
    } elseif (is_archive()) {
        $items[] = [
            'label'    => get_the_archive_title(),
            'url'      => '',
            'position' => $position++,
        ];
    }

    $items = apply_filters('bg_breadcrumb_items', $items, $args);

    if (count($items) <= 1) {
        return;
    }

    echo '<nav class="' . esc_attr($args['class']) . '" aria-label="' . esc_attr($args['aria_label']) . '">';
    echo '<ol itemscope itemtype="https://schema.org/BreadcrumbList">';

    foreach ($items as $index => $item) {
        if (empty($item['label'])) {
            continue;
        }

        $position = isset($item['position']) ? (int) $item['position'] : $index + 1;
        $is_current = empty($item['url']);

        echo '<li class="bg-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        if ($is_current) {
            echo '<span itemprop="name" aria-current="page">' . esc_html($item['label']) . '</span>';
        } else {
            echo '<a itemprop="item" href="' . esc_url($item['url']) . '"><span itemprop="name">' . esc_html($item['label']) . '</span></a>';
        }
        echo '<meta itemprop="position" content="' . esc_attr($position) . '" />';
        echo '</li>';
    }

    echo '</ol>';
    echo '</nav>';
}

// -----------------------------------------------------------------------------
// SEO meta fallbacks
// -----------------------------------------------------------------------------

add_action('wp_head', 'bg_output_social_meta', 5);
/**
 * Provide Open Graph & Twitter card fallbacks when no SEO plugin is active.
 */
function bg_output_social_meta() {
    if (
        defined('WPSEO_VERSION')
        || defined('RANK_MATH_VERSION')
        || class_exists('SEOPress_Core')
        || class_exists('All_in_One_SEO_Pack')
        || class_exists('AIOSEO\\Plugin\\AIOSEO')
    ) {
        return;
    }

    global $wp;

    $title = wp_get_document_title();
    $description = get_bloginfo('description');
    $url = home_url('/');
    $image = '';

    if (is_singular()) {
        $post_id = get_queried_object_id();
        $maybe_excerpt = get_the_excerpt($post_id);
        if ($maybe_excerpt) {
            $description = wp_strip_all_tags($maybe_excerpt);
        }
        $url = get_permalink($post_id);

        $thumb_id = get_post_thumbnail_id($post_id);
        if ($thumb_id) {
            $image_data = wp_get_attachment_image_src($thumb_id, 'bg-hero');
            if ($image_data) {
                $image = $image_data[0];
            }
        }
    }

    if (!is_singular() && isset($wp->request)) {
        $url = home_url($wp->request ? '/' . ltrim($wp->request, '/') : '/');
    }

    if (!$image) {
        $custom_logo_id = get_theme_mod('custom_logo');
        if ($custom_logo_id) {
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            if ($logo) {
                $image = $logo[0];
            }
        }
    }

    echo '<meta property="og:title" content="' . esc_attr($title) . '" />';
    echo '<meta property="og:description" content="' . esc_attr($description) . '" />';
    echo '<meta property="og:url" content="' . esc_url($url) . '" />';
    echo '<meta property="og:type" content="' . (is_singular() ? 'article' : 'website') . '" />';

    if ($image) {
        echo '<meta property="og:image" content="' . esc_url($image) . '" />';
    }

    echo '<meta name="twitter:card" content="summary_large_image" />';
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '" />';
    echo '<meta name="twitter:description" content="' . esc_attr($description) . '" />';
    if ($image) {
        echo '<meta name="twitter:image" content="' . esc_url($image) . '" />';
    }
}

// -----------------------------------------------------------------------------
// Dashboard widget
// -----------------------------------------------------------------------------

add_action('wp_dashboard_setup', 'bg_register_course_widget');
/**
 * Register BeyondGotham course statistics widget.
 */
function bg_register_course_widget() {
    wp_add_dashboard_widget(
        'bg_course_stats',
        __('📊 Kurs-Statistiken', 'beyondgotham-dark-child'),
        'bg_render_course_stats_widget'
    );
}

/**
 * Render widget contents.
 */
function bg_render_course_stats_widget() {
    $stats = get_transient('bg_course_stats_widget');

    if (false === $stats) {
        $stats = [
            'courses'      => (int) wp_count_posts('bg_course')->publish,
            'enrollments'  => (int) wp_count_posts('bg_enrollment')->publish,
            'instructors'  => (int) wp_count_posts('bg_instructor')->publish,
            'waitlist'     => 0,
        ];

        $waitlist = new WP_Query([
            'post_type'      => 'bg_enrollment',
            'fields'         => 'ids',
            'no_found_rows'  => true,
            'posts_per_page' => -1,
            'meta_key'       => '_bg_status',
            'meta_value'     => 'waitlist',
        ]);

        $stats['waitlist'] = count($waitlist->posts);

        set_transient('bg_course_stats_widget', $stats, HOUR_IN_SECONDS);
    }
    ?>
    <div class="bg-dashboard-widget">
        <div class="bg-dashboard-widget__row">
            <div class="bg-dashboard-widget__card">
                <span class="bg-dashboard-widget__value"><?php echo esc_html($stats['courses']); ?></span>
                <span class="bg-dashboard-widget__label"><?php esc_html_e('Aktive Kurse', 'beyondgotham-dark-child'); ?></span>
            </div>
            <div class="bg-dashboard-widget__card">
                <span class="bg-dashboard-widget__value"><?php echo esc_html($stats['enrollments']); ?></span>
                <span class="bg-dashboard-widget__label"><?php esc_html_e('Gesamte Anmeldungen', 'beyondgotham-dark-child'); ?></span>
            </div>
            <div class="bg-dashboard-widget__card">
                <span class="bg-dashboard-widget__value"><?php echo esc_html($stats['waitlist']); ?></span>
                <span class="bg-dashboard-widget__label"><?php esc_html_e('Warteliste', 'beyondgotham-dark-child'); ?></span>
            </div>
            <div class="bg-dashboard-widget__card">
                <span class="bg-dashboard-widget__value"><?php echo esc_html($stats['instructors']); ?></span>
                <span class="bg-dashboard-widget__label"><?php esc_html_e('Dozent:innen', 'beyondgotham-dark-child'); ?></span>
            </div>
        </div>
        <p class="bg-dashboard-widget__actions">
            <a class="button" href="<?php echo esc_url(admin_url('edit.php?post_type=bg_enrollment')); ?>">
                <?php esc_html_e('Anmeldungen verwalten', 'beyondgotham-dark-child'); ?>
            </a>
        </p>
    </div>
    <?php
}

/**
 * Clear widget cache when enrollment data changes.
 */
function bg_flush_course_stats_widget_cache() {
    delete_transient('bg_course_stats_widget');
}
add_action('save_post_bg_course', 'bg_flush_course_stats_widget_cache');
add_action('save_post_bg_enrollment', 'bg_flush_course_stats_widget_cache');
add_action('save_post_bg_instructor', 'bg_flush_course_stats_widget_cache');
add_action('deleted_post', 'bg_flush_course_stats_widget_cache');

// -----------------------------------------------------------------------------
// Admin customisations
// -----------------------------------------------------------------------------

add_action('admin_menu', 'bg_customize_admin_menu', 99);
/**
 * Adjust admin menu icons.
 */
function bg_customize_admin_menu() {
    global $menu;

    if (!is_array($menu)) {
        return;
    }

    foreach ($menu as $index => $item) {
        if (isset($item[2]) && 'edit.php?post_type=bg_course' === $item[2]) {
            $menu[$index][6] = 'dashicons-welcome-learn-more';
        }
        if (isset($item[2]) && 'edit.php?post_type=bg_enrollment' === $item[2]) {
            $menu[$index][6] = 'dashicons-clipboard';
        }
    }
}

// -----------------------------------------------------------------------------
// Rewrite rules
// -----------------------------------------------------------------------------

add_action('after_switch_theme', 'bg_flush_rewrite_rules');
/**
 * Flush rewrite rules when the theme is activated.
 */
function bg_flush_rewrite_rules() {
    flush_rewrite_rules();
}

// -----------------------------------------------------------------------------
// Demo data helper (manual trigger)
// -----------------------------------------------------------------------------

if (!function_exists('bg_seed_demo_courses')) {
    /**
     * Seed demo content for development environments.
     *
     * To run: remove the comment in the call below and reload wp-admin once.
     */
    function bg_seed_demo_courses() {
        if (!current_user_can('manage_options')) {
            return;
        }

        if (get_option('bg_demo_content_seeded')) {
            return;
        }

        $taxonomy_map = [
            'bg_course_category' => [
                'osint-forensics'   => __('OSINT & Forensik', 'beyondgotham-dark-child'),
                'investigative'     => __('Investigativer Journalismus', 'beyondgotham-dark-child'),
                'it-linux'          => __('IT & Linux', 'beyondgotham-dark-child'),
            ],
            'bg_course_level' => [
                'beginner'     => __('Beginner', 'beyondgotham-dark-child'),
                'intermediate' => __('Intermediate', 'beyondgotham-dark-child'),
                'advanced'     => __('Advanced', 'beyondgotham-dark-child'),
            ],
        ];

        foreach ($taxonomy_map as $taxonomy => $terms) {
            foreach ($terms as $slug => $label) {
                if (!term_exists($slug, $taxonomy)) {
                    wp_insert_term($label, $taxonomy, ['slug' => $slug]);
                }
            }
        }

        $instructors = [];
        for ($i = 1; $i <= 2; $i++) {
            $instructors[] = wp_insert_post([
                'post_type'   => 'bg_instructor',
                'post_status' => 'publish',
                'post_title'  => sprintf(__('Demo Dozent %d', 'beyondgotham-dark-child'), $i),
                'post_content'=> __('Kurzvita des Demo-Dozenten. Dieser Eintrag dient als Platzhalter für echte Inhalte.', 'beyondgotham-dark-child'),
                'meta_input'  => [
                    '_bg_qualification' => __('Mehrjährige Praxiserfahrung', 'beyondgotham-dark-child'),
                    '_bg_experience'    => '5',
                    '_bg_email'         => sprintf('instructor%d@example.com', $i),
                ],
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            $course_id = wp_insert_post([
                'post_type'   => 'bg_course',
                'post_status' => 'publish',
                'post_title'  => sprintf(__('Demo Kurs %d', 'beyondgotham-dark-child'), $i),
                'post_content'=> wp_kses_post('<p>' . __('Dies ist ein Demo-Kurs mit Beispielinhalten.', 'beyondgotham-dark-child') . '</p>'),
                'meta_input'  => [
                    '_bg_duration'        => '6',
                    '_bg_price'           => '2490',
                    '_bg_start_date'      => gmdate('Y-m-d', strtotime('+' . $i . ' month')),
                    '_bg_end_date'        => gmdate('Y-m-d', strtotime('+' . ($i + 1) . ' month')),
                    '_bg_total_spots'     => '12',
                    '_bg_available_spots' => '12',
                    '_bg_language'        => __('Deutsch', 'beyondgotham-dark-child'),
                    '_bg_location'        => __('Remote', 'beyondgotham-dark-child'),
                    '_bg_delivery_mode'   => 'online',
                    '_bg_instructor_id'   => $instructors[array_rand($instructors)],
                ],
            ]);

            if ($course_id && !is_wp_error($course_id)) {
                wp_set_object_terms($course_id, 'osint-forensics', 'bg_course_category', true);
                wp_set_object_terms($course_id, 'beginner', 'bg_course_level', true);
            }
        }

        update_option('bg_demo_content_seeded', 1);
    }

    // add_action('admin_init', 'bg_seed_demo_courses'); // Uncomment for local seeding.
}
