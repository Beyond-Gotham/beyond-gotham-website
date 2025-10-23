<?php
/**
 * BeyondGotham Dark – Child Theme for FreeNews
 * 
 * Includes:
 * - Custom Post Types (Kurse, Dozenten, Anmeldungen)
 * - Enrollment Form System
 * - AJAX Handlers
 * - Enhanced Theme Support
 */

// ============================================
// 1. STYLES & SCRIPTS
// ============================================
add_action('wp_enqueue_scripts', function () {
    // Parent Styles
    wp_enqueue_style(
        'freenews-parent',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme('freenews')->get('Version') ?: null
    );
    
    // Child main
    wp_enqueue_style(
        'beyondgotham-child',
        get_stylesheet_uri(),
        ['freenews-parent'],
        wp_get_theme()->get('Version')
    );
    
    // Extra dark tune
    wp_enqueue_style(
        'beyondgotham-dark',
        get_stylesheet_directory_uri() . '/assets/css/dark.css',
        ['beyondgotham-child'],
        wp_get_theme()->get('Version')
    );
    
    // jQuery (for AJAX forms)
    wp_enqueue_script('jquery');
}, 20);


// ============================================
// 2. THEME SUPPORT
// ============================================
add_action('after_setup_theme', function(){
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ]);
});


// ============================================
// 3. CUSTOM POST TYPES & ENROLLMENT
// ============================================
require_once get_stylesheet_directory() . '/inc/custom-post-types.php';
require_once get_stylesheet_directory() . '/inc/enrollment-form.php';


// ============================================
// 4. ADMIN MENU CUSTOMIZATION
// ============================================
add_action('admin_menu', function() {
    // Custom Icon für Kursverwaltung
    global $menu;
    foreach ($menu as $key => $item) {
        if ($item[2] === 'edit.php?post_type=bg_course') {
            $menu[$key][6] = 'dashicons-welcome-learn-more';
        }
    }
}, 99);


// ============================================
// 5. EXCERPT LENGTH
// ============================================
add_filter('excerpt_length', function($length) {
    return 30;
});


// ============================================
// 6. DEFAULT CATEGORIES (einmalig aktivieren)
// ============================================
/**
 * Einmal-Helfer: Legt Kern-Kategorien an
 * Kommentarzeichen entfernen, Frontend laden, wieder auskommentieren
 */
// add_action('init', function(){
//     $cats = [
//       ['OSINT','osint'],
//       ['Reportagen','reportagen'],
//       ['Dossiers','dossiers'],
//       ['Interviews','interviews'],
//       ['InfoTerminal','infoterminal']
//     ];
//     foreach ($cats as [$name,$slug]) {
//         if (!term_exists($name, 'category')) {
//             wp_insert_term($name, 'category', ['slug'=>$slug]);
//         }
//     }
// });


// ============================================
// 7. DEMO COURSE CATEGORIES (einmalig)
// ============================================
/**
 * Legt Demo-Kurs-Kategorien an
 * Einmal aktivieren, dann wieder auskommentieren
 */
// add_action('init', function(){
//     $course_cats = [
//         ['OSINT & Forensik', 'osint-forensik'],
//         ['Investigativer Journalismus', 'investigativ-journalismus'],
//         ['IT & Linux', 'it-linux'],
//         ['Rettungsdienst', 'rettungsdienst'],
//     ];
//     
//     foreach ($course_cats as [$name, $slug]) {
//         if (!term_exists($name, 'course_category')) {
//             wp_insert_term($name, 'course_category', ['slug' => $slug]);
//         }
//     }
//     
//     $levels = [
//         ['Anfänger', 'anfaenger'],
//         ['Fortgeschritten', 'fortgeschritten'],
//         ['Experte', 'experte'],
//     ];
//     
//     foreach ($levels as [$name, $slug]) {
//         if (!term_exists($name, 'course_level')) {
//             wp_insert_term($name, 'course_level', ['slug' => $slug]);
//         }
//     }
// });


// ============================================
// 8. DASHBOARD WIDGET (Kurs-Statistiken)
// ============================================
add_action('wp_dashboard_setup', function() {
    wp_add_dashboard_widget(
        'bg_course_stats',
        '📊 Kurs-Statistiken',
        'bg_render_course_stats_widget'
    );
});

function bg_render_course_stats_widget() {
    $total_courses = wp_count_posts('bg_course')->publish;
    $total_enrollments = wp_count_posts('bg_enrollment')->publish;
    $total_instructors = wp_count_posts('bg_instructor')->publish;
    
    $pending = new WP_Query([
        'post_type' => 'bg_enrollment',
        'meta_key' => '_bg_status',
        'meta_value' => 'pending',
        'posts_per_page' => -1,
    ]);
    
    ?>
    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;">
        <div style="padding:16px;background:#f0f0f1;border-radius:4px;">
            <div style="font-size:2rem;font-weight:700;color:#0073aa;"><?php echo $total_courses; ?></div>
            <div style="font-size:0.9rem;color:#666;">Aktive Kurse</div>
        </div>
        <div style="padding:16px;background:#f0f0f1;border-radius:4px;">
            <div style="font-size:2rem;font-weight:700;color:#00a32a;"><?php echo $total_enrollments; ?></div>
            <div style="font-size:0.9rem;color:#666;">Anmeldungen</div>
        </div>
        <div style="padding:16px;background:#f0f0f1;border-radius:4px;">
            <div style="font-size:2rem;font-weight:700;color:#d63638;"><?php echo $pending->found_posts; ?></div>
            <div style="font-size:0.9rem;color:#666;">Offene Anmeldungen</div>
        </div>
        <div style="padding:16px;background:#f0f0f1;border-radius:4px;">
            <div style="font-size:2rem;font-weight:700;color:#2271b1;"><?php echo $total_instructors; ?></div>
            <div style="font-size:0.9rem;color:#666;">Dozenten</div>
        </div>
    </div>
    <p style="margin-top:16px;">
        <a href="<?php echo admin_url('edit.php?post_type=bg_enrollment'); ?>" class="button">Anmeldungen verwalten</a>
    </p>
    <?php
}
