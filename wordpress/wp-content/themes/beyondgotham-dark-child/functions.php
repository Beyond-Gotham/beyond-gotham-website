<?php
/**
 * BeyondGotham Dark – Child Theme for FreeNews
 * Version: 1.0.0
 */

// ============================================
// 1. STYLES & SCRIPTS
// ============================================
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'freenews-parent',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme('freenews')->get('Version') ?: null
    );

    wp_enqueue_style(
        'beyondgotham-child',
        get_stylesheet_uri(),
        ['freenews-parent'],
        '1.0.0'
    );

    wp_enqueue_style(
        'beyondgotham-dark',
        get_stylesheet_directory_uri() . '/assets/css/dark.css',
        ['beyondgotham-child'],
        '1.0.0'
    );

    wp_enqueue_script('jquery');

    if (is_page_template('page-contact.php')) {
        wp_enqueue_script(
            'bg-contact-form',
            get_stylesheet_directory_uri() . '/assets/js/contact-form.js',
            ['jquery'],
            '1.0.0',
            true
        );

        wp_localize_script('bg-contact-form', 'bgContactForm', [
            'ajaxUrl'      => admin_url('admin-ajax.php'),
            'errorMessage' => __('Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.', 'beyondgotham-dark-child'),
            'sendingLabel' => __('Wird gesendet …', 'beyondgotham-dark-child'),
        ]);
    }
}, 20);

add_action('admin_enqueue_scripts', function() {
    wp_enqueue_style(
        'beyondgotham-admin',
        get_stylesheet_directory_uri() . '/assets/css/admin.css',
        [],
        '1.0.0'
    );
});


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
    
    // Register Navigation Menus
    register_nav_menus([
        'primary' => 'Hauptmenü',
        'footer' => 'Footer-Menü',
    ]);
});


// ============================================
// 3. CUSTOM POST TYPES & ENROLLMENT
// ============================================
$custom_post_types_file = get_stylesheet_directory() . '/inc/custom-post-types.php';
if (file_exists($custom_post_types_file)) {
    require_once $custom_post_types_file;
} else {
    error_log(sprintf('[BeyondGotham] Missing file: %s', $custom_post_types_file));
}

$enrollment_form_file = get_stylesheet_directory() . '/inc/enrollment-form.php';
if (file_exists($enrollment_form_file)) {
    require_once $enrollment_form_file;
} else {
    error_log(sprintf('[BeyondGotham] Missing file: %s', $enrollment_form_file));
}


// ============================================
// 4. NAVIGATION & MENU ITEMS
// ============================================
add_action('init', function() {
    // Hauptmenü erstellen falls nicht vorhanden
    if (!has_nav_menu('primary')) {
        $menu_name = 'Hauptmenü';
        $menu_id = wp_create_nav_menu($menu_name);
        
        if (!is_wp_error($menu_id)) {
            $locations = get_theme_mod('nav_menu_locations');
            $locations['primary'] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
            
            // Menu-Items hinzufügen
            $menu_items = [
                ['title' => 'Start', 'url' => home_url('/')],
                ['title' => 'Über uns', 'url' => home_url('/ueber-uns/')],
                ['title' => 'Projekte', 'url' => home_url('/projekte/')],
                ['title' => 'Kurse', 'url' => home_url('/kurse/')],
                ['title' => 'Team', 'url' => home_url('/team/')],
                ['title' => 'Blog', 'url' => home_url('/blog/')],
                ['title' => 'Kontakt', 'url' => home_url('/kontakt/')],
            ];
            
            foreach ($menu_items as $index => $item) {
                wp_update_nav_menu_item($menu_id, 0, [
                    'menu-item-title' => $item['title'],
                    'menu-item-url' => $item['url'],
                    'menu-item-status' => 'publish',
                    'menu-item-position' => $index + 1,
                ]);
            }
        }
    }
});


// ============================================
// 5. ADMIN CUSTOMIZATION
// ============================================
add_action('admin_menu', function() {
    global $menu;
    foreach ($menu as $key => $item) {
        if ($item[2] === 'edit.php?post_type=bg_course') {
            $menu[$key][6] = 'dashicons-welcome-learn-more';
        }
    }
}, 99);


// ============================================
// 6. DASHBOARD WIDGET
// ============================================
add_action('wp_dashboard_setup', function() {
    wp_add_dashboard_widget(
        'bg_course_stats',
        '📊 Kurs-Statistiken',
        'bg_render_course_stats_widget'
    );
});

function bg_render_course_stats_widget() {
    $stats = get_transient('bg_course_stats_widget');

    if (!$stats) {
        $stats = [
            'courses'      => (int) wp_count_posts('bg_course')->publish,
            'enrollments'  => (int) wp_count_posts('bg_enrollment')->publish,
            'instructors'  => (int) wp_count_posts('bg_instructor')->publish,
            'pending'      => 0,
        ];

        $pending = new WP_Query([
            'post_type'      => 'bg_enrollment',
            'fields'         => 'ids',
            'no_found_rows'  => true,
            'posts_per_page' => -1,
            'meta_query'     => [
                [
                    'key'   => '_bg_status',
                    'value' => 'pending',
                ],
            ],
        ]);

        $stats['pending'] = count($pending->posts);

        set_transient('bg_course_stats_widget', $stats, HOUR_IN_SECONDS);
    }

    ?>
    <div class="bg-course-stats-widget">
        <div class="bg-course-stats-widget__item bg-course-stats-widget__item--courses">
            <div class="bg-course-stats-widget__value"><?php echo esc_html($stats['courses']); ?></div>
            <div class="bg-course-stats-widget__label"><?php esc_html_e('Aktive Kurse', 'beyondgotham-dark-child'); ?></div>
        </div>
        <div class="bg-course-stats-widget__item bg-course-stats-widget__item--enrollments">
            <div class="bg-course-stats-widget__value"><?php echo esc_html($stats['enrollments']); ?></div>
            <div class="bg-course-stats-widget__label"><?php esc_html_e('Anmeldungen', 'beyondgotham-dark-child'); ?></div>
        </div>
        <div class="bg-course-stats-widget__item bg-course-stats-widget__item--pending">
            <div class="bg-course-stats-widget__value"><?php echo esc_html($stats['pending']); ?></div>
            <div class="bg-course-stats-widget__label"><?php esc_html_e('Offene Anmeldungen', 'beyondgotham-dark-child'); ?></div>
        </div>
        <div class="bg-course-stats-widget__item bg-course-stats-widget__item--instructors">
            <div class="bg-course-stats-widget__value"><?php echo esc_html($stats['instructors']); ?></div>
            <div class="bg-course-stats-widget__label"><?php esc_html_e('Dozenten', 'beyondgotham-dark-child'); ?></div>
        </div>
    </div>
    <p class="bg-course-stats-widget__actions">
        <a href="<?php echo esc_url(admin_url('edit.php?post_type=bg_enrollment')); ?>" class="button"><?php esc_html_e('Anmeldungen verwalten', 'beyondgotham-dark-child'); ?></a>
    </p>
    <?php
}

function bg_flush_course_stats_widget_cache() {
    delete_transient('bg_course_stats_widget');
}

add_action('save_post_bg_course', 'bg_flush_course_stats_widget_cache');
add_action('save_post_bg_enrollment', 'bg_flush_course_stats_widget_cache');
add_action('save_post_bg_instructor', 'bg_flush_course_stats_widget_cache');
add_action('delete_post', function($post_id) {
    $post_type = get_post_type($post_id);
    if (in_array($post_type, ['bg_course', 'bg_enrollment', 'bg_instructor'], true)) {
        bg_flush_course_stats_widget_cache();
    }
});


// ============================================
// 7. DEMO DATA GENERATOR
// ============================================
function bg_create_demo_data() {
    // Prüfen ob bereits Demo-Daten existieren
    $existing_courses = get_posts(['post_type' => 'bg_course', 'posts_per_page' => 1]);
    if (!empty($existing_courses)) {
        return; // Bereits Daten vorhanden
    }
    
    // Kategorien erstellen
    $cat_osint = wp_insert_term('OSINT & Forensik', 'course_category', ['slug' => 'osint-forensik']);
    $cat_journalism = wp_insert_term('Investigativer Journalismus', 'course_category', ['slug' => 'investigativ-journalismus']);
    $cat_it = wp_insert_term('IT & Linux', 'course_category', ['slug' => 'it-linux']);
    $cat_medical = wp_insert_term('Rettungsdienst', 'course_category', ['slug' => 'rettungsdienst']);
    
    // Levels
    $level_beginner = wp_insert_term('Anfänger', 'course_level', ['slug' => 'anfaenger']);
    $level_advanced = wp_insert_term('Fortgeschritten', 'course_level', ['slug' => 'fortgeschritten']);
    $level_expert = wp_insert_term('Experte', 'course_level', ['slug' => 'experte']);
    
    // Blog-Kategorien
    wp_insert_term('OSINT', 'category', ['slug' => 'osint']);
    wp_insert_term('Reportagen', 'category', ['slug' => 'reportagen']);
    wp_insert_term('Dossiers', 'category', ['slug' => 'dossiers']);
    wp_insert_term('Interviews', 'category', ['slug' => 'interviews']);
    wp_insert_term('InfoTerminal', 'category', ['slug' => 'infoterminal']);
    
    // Dozenten erstellen
    $instructors = [];
    
    $instructors[] = wp_insert_post([
        'post_type' => 'bg_instructor',
        'post_title' => 'Sarah Chen',
        'post_content' => 'Sarah ist eine erfahrene OSINT-Analystin mit über 12 Jahren Berufserfahrung. Sie hat für führende Nachrichtenagenturen gearbeitet und spezialisiert sich auf digitale Forensik und Verifikationsmethoden.',
        'post_status' => 'publish',
        'meta_input' => [
            '_bg_qualification' => 'MSc Digital Forensics, OSINT-Zertifikat',
            '_bg_experience' => '12',
            '_bg_email' => 'sarah.chen@beyond-gotham.org',
            '_bg_linkedin' => 'https://linkedin.com/in/sarahchen',
        ],
    ]);
    
    $instructors[] = wp_insert_post([
        'post_type' => 'bg_instructor',
        'post_title' => 'Marcus Weber',
        'post_content' => 'Marcus ist investigativer Journalist mit Schwerpunkt auf Datenjournalismus. Er deckte mehrere internationale Korruptionsfälle auf und gewann den Wächterpreis für investigativen Journalismus.',
        'post_status' => 'publish',
        'meta_input' => [
            '_bg_qualification' => 'Diplom-Journalist, Datenjournalismus-Zertifikat',
            '_bg_experience' => '15',
            '_bg_email' => 'marcus.weber@beyond-gotham.org',
        ],
    ]);
    
    $instructors[] = wp_insert_post([
        'post_type' => 'bg_instructor',
        'post_title' => 'Dr. Lisa Hoffmann',
        'post_content' => 'Lisa ist Notärztin mit umfangreicher Erfahrung in Krisengebieten. Sie leitete medizinische Teams für MSF und Spezialisiert sich auf Tactical Combat Casualty Care (TCCC).',
        'post_status' => 'publish',
        'meta_input' => [
            '_bg_qualification' => 'Fachärztin Notfallmedizin, TCCC-Instructor',
            '_bg_experience' => '10',
            '_bg_email' => 'lisa.hoffmann@beyond-gotham.org',
        ],
    ]);
    
    $instructors[] = wp_insert_post([
        'post_type' => 'bg_instructor',
        'post_title' => 'Alex Kovalenko',
        'post_content' => 'Alex ist Linux-Systemadministrator und IT-Security-Experte. Er unterrichtet LPIC-Zertifizierungskurse und spezialisiert sich auf sichere Infrastrukturen für Recherche-Teams.',
        'post_status' => 'publish',
        'meta_input' => [
            '_bg_qualification' => 'LPIC-3, CISSP, Certified Ethical Hacker',
            '_bg_experience' => '8',
            '_bg_email' => 'alex.kovalenko@beyond-gotham.org',
        ],
    ]);
    
    // Kurse erstellen
    $courses_data = [
        [
            'title' => 'OSINT Professional – Digitale Recherche & Verifikation',
            'content' => '<h2>Kursbeschreibung</h2>
<p>Dieser umfassende Kurs vermittelt professionelle OSINT-Methoden (Open Source Intelligence) für investigative Recherchen. Sie lernen, wie Sie öffentlich zugängliche Datenquellen systematisch analysieren, Informationen verifizieren und digitale Spuren nachverfolgen.</p>

<h2>Inhalte</h2>
<ul>
<li>Grundlagen der OSINT-Methodik</li>
<li>Social Media Intelligence (SOCMINT)</li>
<li>Geolocation und Chronolocation</li>
<li>Digitale Forensik und Metadaten-Analyse</li>
<li>Verifikationstechniken für Bilder und Videos</li>
<li>Dark Web Recherche</li>
<li>Datenschutz und OPSEC</li>
<li>InfoTerminal-Plattform im Praxiseinsatz</li>
</ul>

<h2>Lernziele</h2>
<p>Nach Abschluss des Kurses können Sie:</p>
<ul>
<li>Komplexe OSINT-Recherchen selbstständig durchführen</li>
<li>Informationen aus verschiedenen Quellen verifizieren</li>
<li>Professionelle Recherche-Tools effektiv einsetzen</li>
<li>Digitale Spuren analysieren und dokumentieren</li>
<li>Eigene Sicherheit bei Recherchen gewährleisten</li>
</ul>

<h2>Zielgruppe</h2>
<p>Journalist:innen, Researcher, Analyst:innen, NGO-Mitarbeiter:innen, Behördenmitarbeiter:innen</p>',
            'excerpt' => 'Professionelle Open-Source Intelligence Methoden für investigative Recherchen, Verifikation und digitale Forensik.',
            'category' => $cat_osint['term_id'],
            'level' => $level_advanced['term_id'],
            'meta' => [
                '_bg_duration' => '12',
                '_bg_price' => '5400.00',
                '_bg_start_date' => '2025-02-03',
                '_bg_end_date' => '2025-04-28',
                '_bg_max_participants' => '15',
                '_bg_bildungsgutschein' => '1',
                '_bg_azav_id' => 'BG-OSINT-PRO-01',
                '_bg_instructor_id' => $instructors[0],
            ],
        ],
        [
            'title' => 'Investigativer Journalismus & Datenjournalismus',
            'content' => '<h2>Kursbeschreibung</h2>
<p>Lernen Sie die Kunst des investigativen Journalismus von Grund auf. Dieser Kurs verbindet klassische Recherchemethoden mit modernem Datenjournalismus und vermittelt, wie Sie komplexe Geschichten aufdecken und erzählen.</p>

<h2>Inhalte</h2>
<ul>
<li>Grundlagen investigativer Recherche</li>
<li>Quellenschutz und Whistleblower-Kommunikation</li>
<li>Datenjournalismus und Datenvisualisierung</li>
<li>Dokumentenrecherche und Leak-Analyse</li>
<li>Storytelling für komplexe Themen</li>
<li>Ethik und Presserecht</li>
<li>Publikationsstrategien</li>
<li>Internationale Kooperationen</li>
</ul>

<h2>Praxisprojekt</h2>
<p>Sie arbeiten an einem eigenen investigativen Projekt, das Sie von der Recherche bis zur Veröffentlichung begleiten. Dabei werden Sie von erfahrenen Journalist:innen betreut.</p>

<h2>Zertifikat</h2>
<p>Anerkanntes Zertifikat mit detailliertem Kompetenznachweis</p>',
            'excerpt' => 'Von der Recherche zur Veröffentlichung: Investigative Methoden, Datenjournalismus und ethische Standards für moderne Berichterstattung.',
            'category' => $cat_journalism['term_id'],
            'level' => $level_advanced['term_id'],
            'meta' => [
                '_bg_duration' => '16',
                '_bg_price' => '6800.00',
                '_bg_start_date' => '2025-02-10',
                '_bg_end_date' => '2025-06-02',
                '_bg_max_participants' => '12',
                '_bg_bildungsgutschein' => '1',
                '_bg_azav_id' => 'BG-JOURNAL-01',
                '_bg_instructor_id' => $instructors[1],
            ],
        ],
        [
            'title' => 'Linux System Administration (LPIC-1 & LPIC-2)',
            'content' => '<h2>Kursbeschreibung</h2>
<p>Umfassende Linux-Ausbildung für angehende Systemadministratoren. Vorbereitung auf die LPIC-1 und LPIC-2 Zertifizierungen mit Fokus auf sichere Infrastrukturen für Recherche-Teams.</p>

<h2>Inhalte</h2>
<ul>
<li>Linux-Grundlagen und Shell-Scripting</li>
<li>Systemarchitektur und Boot-Prozess</li>
<li>Paketmanagement und Software-Installation</li>
<li>Netzwerkkonfiguration und Sicherheit</li>
<li>Systemüberwachung und Troubleshooting</li>
<li>Firewall-Konfiguration (iptables, nftables)</li>
<li>VPN-Setup (OpenVPN, WireGuard)</li>
<li>Sichere Server-Konfiguration</li>
<li>Backup und Disaster Recovery</li>
</ul>

<h2>Prüfungsvorbereitung</h2>
<p>Intensive Vorbereitung auf LPIC-1 (101+102) und LPIC-2 (201+202) Prüfungen mit Übungsexamen.</p>

<h2>Zielgruppe</h2>
<p>IT-Einsteiger, Quereinsteiger, angehende Systemadministratoren</p>',
            'excerpt' => 'LPIC-1 und LPIC-2 Zertifizierungsvorbereitung mit Fokus auf sichere Infrastrukturen und praktischer Systemadministration.',
            'category' => $cat_it['term_id'],
            'level' => $level_beginner['term_id'],
            'meta' => [
                '_bg_duration' => '20',
                '_bg_price' => '7500.00',
                '_bg_start_date' => '2025-01-27',
                '_bg_end_date' => '2025-06-16',
                '_bg_max_participants' => '10',
                '_bg_bildungsgutschein' => '1',
                '_bg_azav_id' => 'BG-LINUX-LPIC-01',
                '_bg_instructor_id' => $instructors[3],
            ],
        ],
        [
            'title' => 'Rettungssanitäter – Ausbildung für Kriseneinsätze',
            'content' => '<h2>Kursbeschreibung</h2>
<p>Staatlich anerkannte Rettungssanitäter-Ausbildung mit zusätzlichem Fokus auf medizinische Versorgung in Krisengebieten und Konfliktregionen. Ideal für den Einsatz in humanitären Missionen.</p>

<h2>Inhalte</h2>
<ul>
<li>Anatomie und Physiologie</li>
<li>Notfallmedizin und Erstversorgung</li>
<li>Traumaversorgung (PHTLS)</li>
<li>Tactical Combat Casualty Care (TCCC)</li>
<li>Triage und Massenanfall von Verletzten</li>
<li>Medikamentenlehre</li>
<li>Hygiene und Infektionsschutz</li>
<li>Psychische Erste Hilfe</li>
<li>Sicherheit in Krisengebieten</li>
</ul>

<h2>Praktische Ausbildung</h2>
<p>160 Stunden Rettungswachen-Praktikum und 40 Stunden Klinikpraktikum in Notaufnahmen.</p>

<h2>Abschluss</h2>
<p>Staatlich anerkannte Prüfung zum/zur Rettungssanitäter:in + TCCC-Zertifikat</p>',
            'excerpt' => 'Staatlich anerkannte Rettungssanitäter-Ausbildung mit TCCC-Zertifizierung für Einsätze in Krisen- und Konfliktregionen.',
            'category' => $cat_medical['term_id'],
            'level' => $level_beginner['term_id'],
            'meta' => [
                '_bg_duration' => '14',
                '_bg_price' => '4200.00',
                '_bg_start_date' => '2025-03-03',
                '_bg_end_date' => '2025-06-09',
                '_bg_max_participants' => '16',
                '_bg_bildungsgutschein' => '1',
                '_bg_azav_id' => 'BG-RETTUNG-01',
                '_bg_instructor_id' => $instructors[2],
            ],
        ],
        [
            'title' => 'OSINT Bootcamp – Intensivkurs (4 Wochen)',
            'content' => '<h2>Kursbeschreibung</h2>
<p>Kompakter Intensivkurs für schnellen Einstieg in OSINT-Methoden. Ideal für Quereinsteiger und als Auffrischung für Profis.</p>

<h2>Inhalte</h2>
<ul>
<li>OSINT-Grundlagen und Tools</li>
<li>Social Media Recherche</li>
<li>Bildersuche und Geolocation</li>
<li>Basis Verifikationstechniken</li>
<li>Praktische Fallstudien</li>
</ul>

<h2>Format</h2>
<p>Vollzeit-Intensivkurs mit täglichen Praxisübungen. Kleine Gruppen für optimale Betreuung.</p>',
            'excerpt' => 'Kompakter 4-Wochen Intensivkurs für schnellen Einstieg in professionelle OSINT-Methoden.',
            'category' => $cat_osint['term_id'],
            'level' => $level_beginner['term_id'],
            'meta' => [
                '_bg_duration' => '4',
                '_bg_price' => '1800.00',
                '_bg_start_date' => '2025-02-17',
                '_bg_end_date' => '2025-03-14',
                '_bg_max_participants' => '20',
                '_bg_bildungsgutschein' => '0',
                '_bg_azav_id' => '',
                '_bg_instructor_id' => $instructors[0],
            ],
        ],
        [
            'title' => 'InfoTerminal Master Class – OSINT-Tooling',
            'content' => '<h2>Kursbeschreibung</h2>
<p>Spezialkurs zur professionellen Nutzung der InfoTerminal-Plattform für investigative Recherchen. Lernen Sie, wie Sie die Plattform optimal für Ihre Projekte einsetzen.</p>

<h2>Inhalte</h2>
<ul>
<li>InfoTerminal Setup und Konfiguration</li>
<li>Daten-Ingestion Pipelines</li>
<li>Graph-Analysen und Visualisierungen</li>
<li>Verifikations-Workflows</li>
<li>Kollaborative Recherche</li>
<li>Plugin-Entwicklung</li>
<li>Best Practices und Use Cases</li>
</ul>

<h2>Voraussetzungen</h2>
<p>Grundkenntnisse in OSINT, Linux-Basics von Vorteil</p>',
            'excerpt' => 'Professionelle Nutzung der InfoTerminal-Plattform für investigative Recherchen und OSINT-Analysen.',
            'category' => $cat_it['term_id'],
            'level' => $level_advanced['term_id'],
            'meta' => [
                '_bg_duration' => '3',
                '_bg_price' => '1200.00',
                '_bg_start_date' => '2025-03-10',
                '_bg_end_date' => '2025-03-28',
                '_bg_max_participants' => '12',
                '_bg_bildungsgutschein' => '0',
                '_bg_azav_id' => '',
                '_bg_instructor_id' => $instructors[3],
            ],
        ],
    ];
    
    foreach ($courses_data as $course_data) {
        $course_id = wp_insert_post([
            'post_type' => 'bg_course',
            'post_title' => $course_data['title'],
            'post_content' => $course_data['content'],
            'post_excerpt' => $course_data['excerpt'],
            'post_status' => 'publish',
            'meta_input' => $course_data['meta'],
        ]);
        
        if ($course_id && !is_wp_error($course_id)) {
            wp_set_object_terms($course_id, [$course_data['category']], 'course_category');
            wp_set_object_terms($course_id, [$course_data['level']], 'course_level');
        }
    }
    
    // Blog-Posts erstellen
    $blog_posts = [
        [
            'title' => 'Die Zukunft der OSINT-Recherche: Künstliche Intelligenz im Fact-Checking',
            'content' => '<p>Künstliche Intelligenz revolutioniert die Art und Weise, wie wir Informationen verifizieren. In diesem Artikel untersuchen wir, wie Machine Learning-Algorithmen dabei helfen, Desinformation zu erkennen und faktische Wahrheit von Manipulation zu unterscheiden.</p>

<h2>Die Herausforderung</h2>
<p>Deepfakes, synthetische Medien und koordinierte Desinformationskampagnen stellen OSINT-Analyst:innen vor neue Herausforderungen. Traditionelle Verifikationsmethoden stoßen an ihre Grenzen, wenn es um die Analyse von Millionen von Datenpunkten in Echtzeit geht.</p>

<h2>KI-gestützte Lösungsansätze</h2>
<p>Moderne NLP-Modelle können Narrative automatisch erkennen und clustern. Computer Vision-Algorithmen identifizieren manipulierte Bilder mit hoher Genauigkeit. Und semantische Suchsysteme finden Zusammenhänge, die menschlichen Analyst:innen verborgen bleiben würden.</p>

<p>Mehr dazu in unserem <a href="/kurse/">OSINT Professional Kurs</a>.</p>',
            'category' => 'osint',
        ],
        [
            'title' => 'Reportage: 6 Monate Ukraine – Unsere Mission an der Front',
            'content' => '<p>Von Februar bis August 2024 war unser Team im Donbas-Gebiet im Einsatz. Eine Reportage über investigative Recherche unter Kriegsbedingungen, medizinische Nothilfe und den Aufbau lokaler Strukturen.</p>

<h2>Tag 1: Ankunft in Kramatorsk</h2>
<p>Der Krankenwagen ist vollgepackt mit medizinischem Equipment, unsere Laptops verschlüsselt, die Recherche-Tools einsatzbereit. Unser Team besteht aus Sarah (OSINT), Marcus (Journalist) und Lisa (Notärztin).</p>

<h2>Die Arbeit vor Ort</h2>
<p>Während Lisa täglich in Feldlazaretten arbeitete, dokumentierten Sarah und Marcus Kriegsverbrechen. 47 Vorfälle konnten wir verifizieren, 3 umfassende Dossiers erstellen.</p>

<p>Am Ende der Mission blieben 2 vollausgestattete Krankenwagen vor Ort – gespendet an lokale Rettungsdienste, die unsere Arbeit fortführen.</p>',
            'category' => 'reportagen',
        ],
        [
            'title' => 'InfoTerminal 2.0: Neue Features für investigative Teams',
            'content' => '<p>Wir haben InfoTerminal grundlegend überarbeitet. Die neue Version 2.0 bringt zahlreiche Features, die investigative Recherchen noch effizienter machen.</p>

<h2>Highlights</h2>
<ul>
<li><strong>Echtzeit-Kollaboration:</strong> Mehrere Analyst:innen können gleichzeitig an Dossiers arbeiten</li>
<li><strong>Verbesserter Verification Layer:</strong> KI-gestützte Fact-Checks mit höherer Genauigkeit</li>
<li><strong>Plugin-System:</strong> Eigene Tools einfach integrieren</li>
<li><strong>Enhanced Security:</strong> Noch bessere OPSEC-Features</li>
</ul>

<p>Testen Sie InfoTerminal in unserer <a href="/infoterminal/">Live-Demo</a>.</p>',
            'category' => 'infoterminal',
        ],
    ];
    
    foreach ($blog_posts as $post_data) {
        $post_id = wp_insert_post([
            'post_type' => 'post',
            'post_title' => $post_data['title'],
            'post_content' => $post_data['content'],
            'post_status' => 'publish',
            'post_category' => [get_cat_ID($post_data['category'])],
        ]);
    }
}

// Demo-Daten bei Theme-Aktivierung erstellen
// Demo-Daten werden nicht mehr automatisch erzeugt, um Live-Systeme schlank zu halten.
// add_action('after_switch_theme', 'bg_create_demo_data');


// ============================================
// 8. CONTACT FORM HANDLER
// ============================================
function bg_handle_contact_form() {
    if (!isset($_POST['bg_contact_nonce']) || !wp_verify_nonce($_POST['bg_contact_nonce'], 'bg_contact_form')) {
        wp_send_json_error(['message' => 'Sicherheitsprüfung fehlgeschlagen.']);
    }
    
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $subject = sanitize_text_field($_POST['contact_subject']);
    $message = sanitize_textarea_field($_POST['contact_message']);
    $privacy = isset($_POST['contact_privacy']) ? 1 : 0;
    
    if (!$name || !$email || !$message || !$privacy) {
        wp_send_json_error(['message' => 'Bitte füllen Sie alle Pflichtfelder aus.']);
    }
    
    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.']);
    }
    
    $admin_email = get_option('admin_email');
    $subject_map = [
        'general' => 'Allgemeine Anfrage',
        'courses' => 'Kursanfrage',
        'partnership' => 'Partnerschaft',
        'press' => 'Presseanfrage',
        'donation' => 'Spende / Förderung',
        'other' => 'Sonstiges',
    ];
    
    $email_subject = '[Beyond_Gotham] ' . ($subject_map[$subject] ?? 'Kontaktanfrage');
    
    $email_message = "Neue Kontaktanfrage über die Website:\n\n";
    $email_message .= "Name: $name\n";
    $email_message .= "E-Mail: $email\n";
    $email_message .= "Betreff: " . ($subject_map[$subject] ?? $subject) . "\n\n";
    $email_message .= "Nachricht:\n$message\n\n";
    $email_message .= "---\n";
    $email_message .= "Gesendet am: " . current_time('mysql') . "\n";
    $email_message .= "IP-Adresse: " . $_SERVER['REMOTE_ADDR'];
    
    $sent = wp_mail($admin_email, $email_subject, $email_message, [
        'From: Beyond_Gotham Website <noreply@beyond-gotham.org>',
        'Reply-To: ' . $email,
    ]);
    
    if ($sent) {
        $confirmation_subject = 'Ihre Anfrage bei Beyond_Gotham';
        $confirmation_message = "Hallo $name,\n\n";
        $confirmation_message .= "vielen Dank für Ihre Nachricht. Wir haben Ihre Anfrage erhalten und werden uns schnellstmöglich bei Ihnen melden.\n\n";
        $confirmation_message .= "Ihre Nachricht:\n---\n$message\n---\n\n";
        $confirmation_message .= "Mit freundlichen Grüßen\n";
        $confirmation_message .= "Ihr Beyond_Gotham Team\n\n";
        $confirmation_message .= "---\n";
        $confirmation_message .= "Beyond_Gotham gGmbH\n";
        $confirmation_message .= "kontakt@beyond-gotham.org\n";
        $confirmation_message .= "www.beyond-gotham.com";
        
        wp_mail($email, $confirmation_subject, $confirmation_message, [
            'From: Beyond_Gotham <noreply@beyond-gotham.org>',
        ]);
    }
    
    if ($sent) {
        wp_send_json_success([
            'message' => 'Vielen Dank für Ihre Nachricht! Wir melden uns in Kürze bei Ihnen.',
        ]);
    } else {
        wp_send_json_error([
            'message' => 'Ein Fehler ist aufgetreten. Bitte senden Sie uns eine E-Mail an kontakt@beyond-gotham.org',
        ]);
    }
}
add_action('wp_ajax_bg_contact_form_submit', 'bg_handle_contact_form');
add_action('wp_ajax_nopriv_bg_contact_form_submit', 'bg_handle_contact_form');


// ============================================
// 9. EXCERPT LENGTH
// ============================================
add_filter('excerpt_length', function($length) {
    return 30;
});


// ============================================
// 10. URL FIX HELPER
// ============================================
function bg_ensure_page_exists($slug, $title, $template = '') {
    $page = get_page_by_path($slug);
    if (!$page) {
        $page_data = [
            'post_title' => $title,
            'post_name' => $slug,
            'post_status' => 'publish',
            'post_type' => 'page',
        ];
        
        $page_id = wp_insert_post($page_data);
        
        if ($template && $page_id) {
            update_post_meta($page_id, '_wp_page_template', $template);
        }
    }
}

// Seiten bei Theme-Aktivierung erstellen
add_action('after_switch_theme', function() {
    bg_ensure_page_exists('ueber-uns', 'Über uns', 'page-about.php');
    bg_ensure_page_exists('projekte', 'Projekte', 'page-projects.php');
    bg_ensure_page_exists('kurse', 'Kurse', 'page-courses.php');
    bg_ensure_page_exists('team', 'Team', 'page-team.php');
    bg_ensure_page_exists('kontakt', 'Kontakt', 'page-contact.php');
    bg_ensure_page_exists('impressum', 'Impressum', 'page-impressum.php');
    bg_ensure_page_exists('datenschutz', 'Datenschutz', 'page-datenschutz.php');
    bg_ensure_page_exists('infoterminal', 'InfoTerminal', 'page-infoterminal.php');

    // Flush rewrite rules
    flush_rewrite_rules();
});


// ============================================
// 11. DEMO KURSE (OSINT, GEO, FORENSIK)
// ============================================

add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

function bg_seed_demo_course_thumbnail($post_id, $relative_path) {
    if (!$post_id || !$relative_path) {
        return;
    }

    $source_path = trailingslashit(get_stylesheet_directory()) . ltrim($relative_path, '/');

    if (!file_exists($source_path)) {
        return;
    }

    $upload_dir = wp_upload_dir();

    if (!empty($upload_dir['error'])) {
        return;
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    wp_mkdir_p($upload_dir['path']);

    $filename = wp_unique_filename($upload_dir['path'], basename($source_path));
    $destination = trailingslashit($upload_dir['path']) . $filename;

    if (!file_exists($destination)) {
        copy($source_path, $destination);
    }

    $filetype = wp_check_filetype($filename, null);

    if (!$filetype || empty($filetype['type'])) {
        return;
    }

    $attachment = [
        'post_mime_type' => $filetype['type'],
        'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filename)),
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];

    $attach_id = wp_insert_attachment($attachment, $destination, $post_id);

    if (is_wp_error($attach_id)) {
        return;
    }

    if ($filetype['type'] !== 'image/svg+xml') {
        $attach_data = wp_generate_attachment_metadata($attach_id, $destination);
        wp_update_attachment_metadata($attach_id, $attach_data);
    }

    update_post_meta($attach_id, '_wp_attachment_image_alt', get_the_title($post_id) . ' – Kursvisualisierung');
    set_post_thumbnail($post_id, $attach_id);
}

function bg_create_demo_courses() {
    if (!post_type_exists('bg_course')) {
        return;
    }

    if (get_option('bg_demo_courses_created')) {
        return;
    }

    $courses = [
        [
            'title'      => 'OSINT-Grundlagen',
            'excerpt'    => 'Strukturierter Einstieg in Open Source Intelligence mit praxisnahen Monitoring- und Verifikationsübungen.',
            'content'    => <<<HTML
<h2>Überblick</h2>
<p>Im Demo-Kurs <strong>OSINT-Grundlagen</strong> lernen Teilnehmende, wie sie offene Quellen strukturiert erfassen, bewerten und dokumentieren. Der Fokus liegt auf Recherche-Frameworks, Monitoring-Workflows und digitalen Sicherheitsstandards.</p>

<h3>Module</h3>
<ul>
    <li>Open Source Intelligence Basics &amp; Recherche-Workflow</li>
    <li>Social Media Monitoring &amp; Verifikation von Posts</li>
    <li>Geolokalisierung und Zeitverifikation (Geo/Chrono)</li>
    <li>Dashboarding, Alerts &amp; Reporting</li>
    <li>OPSEC &amp; sichere Teamkollaboration</li>
</ul>

<h3>Lernziele</h3>
<p>Nach Abschluss können Teams Monitoring-Aufträge priorisieren, Funde dokumentieren und Erkenntnisse konsistent in Lagebilder überführen.</p>

<h3>Demo-Hinweis</h3>
<p>Alle Inhalte dienen als Platzhalter für Design- und Template-Tests.</p>
HTML,
            'image'      => 'assets/images/demo-courses/osint-intro.svg',
            'taxonomies' => [
                'course_category' => ['OSINT & Recherche'],
                'course_level'    => ['Einsteiger'],
            ],
            'meta'       => [
                '_bg_duration'       => '4 Wochen',
                '_bg_language'       => 'Deutsch',
                '_bg_learning_format' => 'Live-Online & Präsenz',
                '_bg_effort'         => '6 Stunden/Woche',
            ],
        ],
        [
            'title'      => 'Geo-Analyse mit Satellitendaten',
            'excerpt'    => 'Visuelle Auswertung von Erdbeobachtungsdaten für Krisen- und Lageanalysen – von Rohdaten zum Lagebild.',
            'content'    => <<<HTML
<h2>Kursprofil</h2>
<p>Dieser Demo-Kurs zeigt, wie Analyst:innen Satellitendaten und Luftbilder kombinieren, um Ereignisse zu verifizieren und Trendanalysen für Einsatzteams aufzubereiten.</p>

<h3>Module</h3>
<ol>
    <li>Einführung in Erdbeobachtung &amp; Sensorik</li>
    <li>Datenbeschaffung (Open Data, kommerzielle Provider)</li>
    <li>Raster- und Vektor-Workflows in QGIS</li>
    <li>Change Detection &amp; Heatmaps</li>
    <li>Storytelling für Entscheidungsträger</li>
</ol>

<h3>Praxisszenarien</h3>
<p>Beispielhafte Fallstudien rund um Infrastrukturmonitoring, Krisenhilfe und humanitäre Lageberichte.</p>

<h3>Demo-Hinweis</h3>
<p>Die Inhalte fungieren als Testdaten für Archive, Filter und Detailseiten.</p>
HTML,
            'image'      => 'assets/images/demo-courses/geo-analysis.svg',
            'taxonomies' => [
                'course_category' => ['Geodaten & Visualisierung'],
                'course_level'    => ['Fortgeschritten'],
            ],
            'meta'       => [
                '_bg_duration'       => '6 Wochen',
                '_bg_language'       => 'Deutsch &amp; Englisch',
                '_bg_learning_format' => 'Hybrid (Remote &amp; Lab)',
                '_bg_effort'         => '8 Stunden/Woche',
            ],
        ],
        [
            'title'      => 'Digitale Beweissicherung',
            'excerpt'    => 'Workflow-Demo zur Sicherung, Analyse und Dokumentation digitaler Spuren mit forensischen Standards.',
            'content'    => <<<HTML
<h2>Kurssteckbrief</h2>
<p>Der Demo-Kurs <em>Digitale Beweissicherung</em> illustriert Prozesse zur Aufnahme, Analyse und Dokumentation digitaler Beweise für investigative Projekte.</p>

<h3>Inhalte</h3>
<ul>
    <li>Forensische Sicherung von Datenträgern</li>
    <li>Auswertung mobiler Endgeräte &amp; Cloud-Dumps</li>
    <li>Metadatenanalyse und Kettennachverfolgung</li>
    <li>Chain-of-Custody Dokumentation</li>
    <li>Gerichtsfeste Berichterstattung</li>
</ul>

<h3>Praxisphasen</h3>
<p>Simulierte Laborstationen mit Incident-Response-Playbooks und Review-Checklisten.</p>

<h3>Demo-Hinweis</h3>
<p>Die Textblöcke dienen als realitätsnahe Inhalte für Templates und Übersichten.</p>
HTML,
            'image'      => 'assets/images/demo-courses/digital-forensics.svg',
            'taxonomies' => [
                'course_category' => ['Digitale Forensik'],
                'course_level'    => ['Professional'],
            ],
            'meta'       => [
                '_bg_duration'       => '5 Wochen',
                '_bg_language'       => 'Deutsch',
                '_bg_learning_format' => 'Lab-basiert',
                '_bg_effort'         => '10 Stunden/Woche',
            ],
        ],
    ];

    $created = false;

    foreach ($courses as $course) {
        if (get_page_by_title($course['title'], OBJECT, 'bg_course')) {
            continue;
        }

        $post_id = wp_insert_post([
            'post_type'    => 'bg_course',
            'post_status'  => 'publish',
            'post_title'   => $course['title'],
            'post_content' => $course['content'],
            'post_excerpt' => $course['excerpt'],
            'post_author'  => get_current_user_id() ?: 1,
        ]);

        if (is_wp_error($post_id) || !$post_id) {
            continue;
        }

        foreach ($course['meta'] as $key => $value) {
            update_post_meta($post_id, $key, $value);
        }

        if (!empty($course['taxonomies'])) {
            foreach ($course['taxonomies'] as $taxonomy => $terms) {
                $term_ids = [];

                foreach ((array) $terms as $term_name) {
                    $existing = term_exists($term_name, $taxonomy);

                    if (!$existing) {
                        $existing = wp_insert_term($term_name, $taxonomy);
                    }

                    if (is_wp_error($existing)) {
                        continue;
                    }

                    if (is_array($existing)) {
                        $term_ids[] = (int) $existing['term_id'];
                    } else {
                        $term_ids[] = (int) $existing;
                    }
                }

                if (!empty($term_ids)) {
                    wp_set_object_terms($post_id, $term_ids, $taxonomy, false);
                }
            }
        }

        if (!empty($course['image'])) {
            bg_seed_demo_course_thumbnail($post_id, $course['image']);
        }

        $created = true;
    }

    if ($created || !get_option('bg_demo_courses_created')) {
        update_option('bg_demo_courses_created', 1, false);
    }
}

function bg_maybe_create_demo_courses() {
    if (!current_user_can('manage_options')) {
        return;
    }

    bg_create_demo_courses();
}
add_action('admin_init', 'bg_maybe_create_demo_courses');
