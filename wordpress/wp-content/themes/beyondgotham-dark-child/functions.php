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
