<?php
/**
 * Custom Post Types für Beyond_Gotham Kurssystem
 * 
 * Registriert:
 * - bg_course (Kurse)
 * - bg_instructor (Dozenten)
 * - bg_enrollment (Anmeldungen - intern)
 */

// ============================================
// 1. KURSE (bg_course)
// ============================================
function bg_register_course_post_type() {
    $labels = [
        'name'               => 'Kurse',
        'singular_name'      => 'Kurs',
        'menu_name'          => 'Kurse',
        'add_new'            => 'Neuer Kurs',
        'add_new_item'       => 'Neuen Kurs hinzufügen',
        'edit_item'          => 'Kurs bearbeiten',
        'new_item'           => 'Neuer Kurs',
        'view_item'          => 'Kurs ansehen',
        'search_items'       => 'Kurse durchsuchen',
        'not_found'          => 'Keine Kurse gefunden',
        'not_found_in_trash' => 'Keine Kurse im Papierkorb',
    ];

    $args = [
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'kurse'],
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-welcome-learn-more',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'show_in_rest'        => true, // Gutenberg Support
    ];

    register_post_type('bg_course', $args);
}
add_action('init', 'bg_register_course_post_type');


// ============================================
// 2. DOZENTEN (bg_instructor)
// ============================================
function bg_register_instructor_post_type() {
    $labels = [
        'name'               => 'Dozenten',
        'singular_name'      => 'Dozent:in',
        'menu_name'          => 'Dozenten',
        'add_new'            => 'Neue:r Dozent:in',
        'add_new_item'       => 'Neue:n Dozent:in hinzufügen',
        'edit_item'          => 'Dozent:in bearbeiten',
        'new_item'           => 'Neue:r Dozent:in',
        'view_item'          => 'Dozent:in ansehen',
        'search_items'       => 'Dozenten durchsuchen',
        'not_found'          => 'Keine Dozenten gefunden',
        'not_found_in_trash' => 'Keine Dozenten im Papierkorb',
    ];

    $args = [
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => ['slug' => 'dozenten'],
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-businessperson',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest'        => true,
    ];

    register_post_type('bg_instructor', $args);
}
add_action('init', 'bg_register_instructor_post_type');


// ============================================
// 3. ANMELDUNGEN (bg_enrollment - intern)
// ============================================
function bg_register_enrollment_post_type() {
    $labels = [
        'name'               => 'Anmeldungen',
        'singular_name'      => 'Anmeldung',
        'menu_name'          => 'Anmeldungen',
        'add_new'            => 'Neue Anmeldung',
        'edit_item'          => 'Anmeldung bearbeiten',
        'view_item'          => 'Anmeldung ansehen',
        'search_items'       => 'Anmeldungen durchsuchen',
        'not_found'          => 'Keine Anmeldungen gefunden',
    ];

    $args = [
        'labels'              => $labels,
        'public'              => false, // Nicht öffentlich sichtbar
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 7,
        'menu_icon'           => 'dashicons-clipboard',
        'supports'            => ['title', 'custom-fields'],
        'show_in_rest'        => false, // Kein Gutenberg nötig
    ];

    register_post_type('bg_enrollment', $args);
}
add_action('init', 'bg_register_enrollment_post_type');


// ============================================
// 4. TAXONOMIEN (Kategorien)
// ============================================
function bg_register_course_taxonomies() {
    // Kurs-Kategorie (OSINT, Journalismus, IT, etc.)
    register_taxonomy('course_category', 'bg_course', [
        'hierarchical'      => true,
        'labels'            => [
            'name'          => 'Kurs-Kategorien',
            'singular_name' => 'Kurs-Kategorie',
            'search_items'  => 'Kategorien durchsuchen',
            'all_items'     => 'Alle Kategorien',
            'edit_item'     => 'Kategorie bearbeiten',
            'add_new_item'  => 'Neue Kategorie hinzufügen',
        ],
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'kurs-kategorie'],
    ]);

    // Kurs-Level (Anfänger, Fortgeschritten, Experte)
    register_taxonomy('course_level', 'bg_course', [
        'hierarchical'      => false,
        'labels'            => [
            'name'          => 'Kurs-Level',
            'singular_name' => 'Level',
            'search_items'  => 'Level durchsuchen',
            'all_items'     => 'Alle Level',
            'edit_item'     => 'Level bearbeiten',
            'add_new_item'  => 'Neues Level hinzufügen',
        ],
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'level'],
    ]);
}
add_action('init', 'bg_register_course_taxonomies');


// ============================================
// 5. META BOXES (Custom Fields)
// ============================================
function bg_add_course_meta_boxes() {
    add_meta_box(
        'bg_course_details',
        'Kurs-Details',
        'bg_course_details_callback',
        'bg_course',
        'normal',
        'high'
    );

    add_meta_box(
        'bg_instructor_details',
        'Dozenten-Details',
        'bg_instructor_details_callback',
        'bg_instructor',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'bg_add_course_meta_boxes');

// Kurs-Details Meta Box
function bg_course_details_callback($post) {
    wp_nonce_field('bg_save_course_details', 'bg_course_nonce');
    
    $duration = get_post_meta($post->ID, '_bg_duration', true);
    $price = get_post_meta($post->ID, '_bg_price', true);
    $start_date = get_post_meta($post->ID, '_bg_start_date', true);
    $end_date = get_post_meta($post->ID, '_bg_end_date', true);
    $max_participants = get_post_meta($post->ID, '_bg_max_participants', true);
    $bildungsgutschein = get_post_meta($post->ID, '_bg_bildungsgutschein', true);
    $azav_id = get_post_meta($post->ID, '_bg_azav_id', true);
    $instructor_id = get_post_meta($post->ID, '_bg_instructor_id', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="bg_duration">Dauer (Wochen)</label></th>
            <td><input type="number" id="bg_duration" name="bg_duration" value="<?php echo esc_attr($duration); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="bg_price">Preis (€)</label></th>
            <td><input type="number" id="bg_price" name="bg_price" value="<?php echo esc_attr($price); ?>" class="regular-text" step="0.01"></td>
        </tr>
        <tr>
            <th><label for="bg_start_date">Startdatum</label></th>
            <td><input type="date" id="bg_start_date" name="bg_start_date" value="<?php echo esc_attr($start_date); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="bg_end_date">Enddatum</label></th>
            <td><input type="date" id="bg_end_date" name="bg_end_date" value="<?php echo esc_attr($end_date); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="bg_max_participants">Max. Teilnehmer</label></th>
            <td><input type="number" id="bg_max_participants" name="bg_max_participants" value="<?php echo esc_attr($max_participants); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="bg_bildungsgutschein">Bildungsgutschein</label></th>
            <td>
                <input type="checkbox" id="bg_bildungsgutschein" name="bg_bildungsgutschein" value="1" <?php checked($bildungsgutschein, '1'); ?>>
                <span class="description">Kurs ist förderfähig</span>
            </td>
        </tr>
        <tr>
            <th><label for="bg_azav_id">AZAV-ID</label></th>
            <td><input type="text" id="bg_azav_id" name="bg_azav_id" value="<?php echo esc_attr($azav_id); ?>" class="regular-text" placeholder="BG-OSINT-01"></td>
        </tr>
        <tr>
            <th><label for="bg_instructor_id">Dozent:in</label></th>
            <td>
                <?php
                $instructors = get_posts([
                    'post_type' => 'bg_instructor',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC'
                ]);
                ?>
                <select id="bg_instructor_id" name="bg_instructor_id" class="regular-text">
                    <option value="">-- Dozent:in wählen --</option>
                    <?php foreach ($instructors as $instructor): ?>
                        <option value="<?php echo $instructor->ID; ?>" <?php selected($instructor_id, $instructor->ID); ?>>
                            <?php echo esc_html($instructor->post_title); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

// Dozenten-Details Meta Box
function bg_instructor_details_callback($post) {
    wp_nonce_field('bg_save_instructor_details', 'bg_instructor_nonce');
    
    $qualification = get_post_meta($post->ID, '_bg_qualification', true);
    $experience = get_post_meta($post->ID, '_bg_experience', true);
    $email = get_post_meta($post->ID, '_bg_email', true);
    $linkedin = get_post_meta($post->ID, '_bg_linkedin', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="bg_qualification">Qualifikation</label></th>
            <td><input type="text" id="bg_qualification" name="bg_qualification" value="<?php echo esc_attr($qualification); ?>" class="regular-text" placeholder="LPIC-2, OSINT-Zertifikat"></td>
        </tr>
        <tr>
            <th><label for="bg_experience">Erfahrung (Jahre)</label></th>
            <td><input type="number" id="bg_experience" name="bg_experience" value="<?php echo esc_attr($experience); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="bg_email">E-Mail</label></th>
            <td><input type="email" id="bg_email" name="bg_email" value="<?php echo esc_attr($email); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="bg_linkedin">LinkedIn</label></th>
            <td><input type="url" id="bg_linkedin" name="bg_linkedin" value="<?php echo esc_attr($linkedin); ?>" class="regular-text" placeholder="https://linkedin.com/in/..."></td>
        </tr>
    </table>
    <?php
}

// Speichern der Kurs-Meta-Daten
function bg_save_course_details($post_id) {
    if (!isset($_POST['bg_course_nonce']) || !wp_verify_nonce($_POST['bg_course_nonce'], 'bg_save_course_details')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = ['duration', 'price', 'start_date', 'end_date', 'max_participants', 'bildungsgutschein', 'azav_id', 'instructor_id'];
    
    foreach ($fields as $field) {
        if (isset($_POST['bg_' . $field])) {
            update_post_meta($post_id, '_bg_' . $field, sanitize_text_field($_POST['bg_' . $field]));
        }
    }
}
add_action('save_post_bg_course', 'bg_save_course_details');

// Speichern der Dozenten-Meta-Daten
function bg_save_instructor_details($post_id) {
    if (!isset($_POST['bg_instructor_nonce']) || !wp_verify_nonce($_POST['bg_instructor_nonce'], 'bg_save_instructor_details')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = ['qualification', 'experience', 'email', 'linkedin'];
    
    foreach ($fields as $field) {
        if (isset($_POST['bg_' . $field])) {
            update_post_meta($post_id, '_bg_' . $field, sanitize_text_field($_POST['bg_' . $field]));
        }
    }
}
add_action('save_post_bg_instructor', 'bg_save_instructor_details');


// ============================================
// 6. ADMIN COLUMNS (Übersicht)
// ============================================
function bg_course_admin_columns($columns) {
    $new_columns = [
        'cb' => $columns['cb'],
        'title' => 'Kurs',
        'course_category' => 'Kategorie',
        'bg_duration' => 'Dauer',
        'bg_start_date' => 'Start',
        'bg_bildungsgutschein' => 'Förderbar',
        'bg_instructor' => 'Dozent:in',
        'date' => 'Erstellt',
    ];
    return $new_columns;
}
add_filter('manage_bg_course_posts_columns', 'bg_course_admin_columns');

function bg_course_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'bg_duration':
            $duration = get_post_meta($post_id, '_bg_duration', true);
            echo $duration ? esc_html($duration) . ' Wochen' : '—';
            break;
        case 'bg_start_date':
            $start = get_post_meta($post_id, '_bg_start_date', true);
            echo $start ? esc_html(date_i18n('d.m.Y', strtotime($start))) : '—';
            break;
        case 'bg_bildungsgutschein':
            $bg = get_post_meta($post_id, '_bg_bildungsgutschein', true);
            echo $bg ? '✅' : '—';
            break;
        case 'bg_instructor':
            $instructor_id = get_post_meta($post_id, '_bg_instructor_id', true);
            if ($instructor_id) {
                echo '<a href="' . get_edit_post_link($instructor_id) . '">' . get_the_title($instructor_id) . '</a>';
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_bg_course_posts_custom_column', 'bg_course_admin_column_content', 10, 2);
