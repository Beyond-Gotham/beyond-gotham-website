<?php
/**
 * Custom post types and taxonomies for Beyond Gotham.
 *
 * @package BeyondGothamDarkChild
 */

defined('ABSPATH') || exit;

// -----------------------------------------------------------------------------
// Register post types and taxonomies
// -----------------------------------------------------------------------------

add_action('init', 'bg_register_course_post_type');
/**
 * Register the bg_course post type.
 */
function bg_register_course_post_type() {
    $labels = [
        'name'                  => __('Kurse', 'beyondgotham-dark-child'),
        'singular_name'         => __('Kurs', 'beyondgotham-dark-child'),
        'menu_name'             => __('Kurse', 'beyondgotham-dark-child'),
        'name_admin_bar'        => __('Kurs', 'beyondgotham-dark-child'),
        'add_new'               => __('Neuer Kurs', 'beyondgotham-dark-child'),
        'add_new_item'          => __('Neuen Kurs hinzufügen', 'beyondgotham-dark-child'),
        'edit_item'             => __('Kurs bearbeiten', 'beyondgotham-dark-child'),
        'new_item'              => __('Neuer Kurs', 'beyondgotham-dark-child'),
        'view_item'             => __('Kurs anzeigen', 'beyondgotham-dark-child'),
        'search_items'          => __('Kurse durchsuchen', 'beyondgotham-dark-child'),
        'not_found'             => __('Keine Kurse gefunden', 'beyondgotham-dark-child'),
        'not_found_in_trash'    => __('Keine Kurse im Papierkorb', 'beyondgotham-dark-child'),
        'all_items'             => __('Alle Kurse', 'beyondgotham-dark-child'),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'rewrite'            => ['slug' => 'kurse'],
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
    ];

    register_post_type('bg_course', $args);
}

add_action('init', 'bg_register_instructor_post_type');
/**
 * Register the bg_instructor post type.
 */
function bg_register_instructor_post_type() {
    $labels = [
        'name'                  => __('Dozent:innen', 'beyondgotham-dark-child'),
        'singular_name'         => __('Dozent:in', 'beyondgotham-dark-child'),
        'menu_name'             => __('Dozent:innen', 'beyondgotham-dark-child'),
        'add_new'               => __('Neue:n Dozent:in', 'beyondgotham-dark-child'),
        'add_new_item'          => __('Neue:n Dozent:in hinzufügen', 'beyondgotham-dark-child'),
        'edit_item'             => __('Dozent:in bearbeiten', 'beyondgotham-dark-child'),
        'view_item'             => __('Dozent:in ansehen', 'beyondgotham-dark-child'),
        'search_items'          => __('Dozent:innen durchsuchen', 'beyondgotham-dark-child'),
        'not_found'             => __('Keine Dozent:innen gefunden', 'beyondgotham-dark-child'),
    ];

    $args = [
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-businessperson',
        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt'],
    ];

    register_post_type('bg_instructor', $args);
}

add_action('init', 'bg_register_enrollment_post_type');
/**
 * Register the internal bg_enrollment post type.
 */
function bg_register_enrollment_post_type() {
    $labels = [
        'name'               => __('Anmeldungen', 'beyondgotham-dark-child'),
        'singular_name'      => __('Anmeldung', 'beyondgotham-dark-child'),
        'menu_name'          => __('Anmeldungen', 'beyondgotham-dark-child'),
        'add_new'            => __('Neue Anmeldung', 'beyondgotham-dark-child'),
        'add_new_item'       => __('Neue Anmeldung hinzufügen', 'beyondgotham-dark-child'),
        'edit_item'          => __('Anmeldung bearbeiten', 'beyondgotham-dark-child'),
        'view_item'          => __('Anmeldung anzeigen', 'beyondgotham-dark-child'),
        'search_items'       => __('Anmeldungen durchsuchen', 'beyondgotham-dark-child'),
        'not_found'          => __('Keine Anmeldungen gefunden', 'beyondgotham-dark-child'),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => ['title', 'custom-fields'],
        'capability_type'    => 'post',
    ];

    register_post_type('bg_enrollment', $args);
}

add_action('init', 'bg_register_course_taxonomies');
/**
 * Register course taxonomies.
 */
function bg_register_course_taxonomies() {
    register_taxonomy('bg_course_category', 'bg_course', [
        'hierarchical'      => true,
        'labels'            => [
            'name'          => __('Kurs-Kategorien', 'beyondgotham-dark-child'),
            'singular_name' => __('Kurs-Kategorie', 'beyondgotham-dark-child'),
            'search_items'  => __('Kategorien durchsuchen', 'beyondgotham-dark-child'),
            'all_items'     => __('Alle Kategorien', 'beyondgotham-dark-child'),
            'edit_item'     => __('Kategorie bearbeiten', 'beyondgotham-dark-child'),
            'add_new_item'  => __('Kategorie hinzufügen', 'beyondgotham-dark-child'),
        ],
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => ['slug' => 'kurs-kategorie'],
    ]);

    register_taxonomy('bg_course_level', 'bg_course', [
        'hierarchical'      => false,
        'labels'            => [
            'name'          => __('Kurs-Level', 'beyondgotham-dark-child'),
            'singular_name' => __('Level', 'beyondgotham-dark-child'),
            'search_items'  => __('Level durchsuchen', 'beyondgotham-dark-child'),
            'all_items'     => __('Alle Level', 'beyondgotham-dark-child'),
            'edit_item'     => __('Level bearbeiten', 'beyondgotham-dark-child'),
            'add_new_item'  => __('Level hinzufügen', 'beyondgotham-dark-child'),
        ],
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => ['slug' => 'kurs-level'],
    ]);
}

// -----------------------------------------------------------------------------
// Meta boxes
// -----------------------------------------------------------------------------

add_action('add_meta_boxes', 'bg_register_meta_boxes');
/**
 * Register meta boxes for custom post types.
 */
function bg_register_meta_boxes() {
    add_meta_box(
        'bg_course_details',
        __('Kurs-Details', 'beyondgotham-dark-child'),
        'bg_render_course_meta_box',
        'bg_course',
        'normal',
        'high'
    );

    add_meta_box(
        'bg_instructor_details',
        __('Dozent:innen-Details', 'beyondgotham-dark-child'),
        'bg_render_instructor_meta_box',
        'bg_instructor',
        'normal',
        'high'
    );
}

/**
 * Render fields for the course meta box.
 *
 * @param WP_Post $post Current post.
 */
function bg_render_course_meta_box($post) {
    wp_nonce_field('bg_save_course_details', 'bg_course_nonce');

    $fields = [
        'duration'        => get_post_meta($post->ID, '_bg_duration', true),
        'price'           => get_post_meta($post->ID, '_bg_price', true),
        'start_date'      => get_post_meta($post->ID, '_bg_start_date', true),
        'end_date'        => get_post_meta($post->ID, '_bg_end_date', true),
        'total_spots'     => bg_get_course_total_spots($post->ID),
        'available_spots' => bg_get_course_available_spots($post->ID),
        'language'        => get_post_meta($post->ID, '_bg_language', true),
        'location'        => get_post_meta($post->ID, '_bg_location', true),
        'delivery_mode'   => get_post_meta($post->ID, '_bg_delivery_mode', true),
        'instructor_id'   => get_post_meta($post->ID, '_bg_instructor_id', true),
        'has_voucher'     => get_post_meta($post->ID, '_bg_bildungsgutschein', true),
    ];

    $instructors = get_posts([
        'post_type'      => 'bg_instructor',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);
    ?>
    <table class="form-table bg-course-meta">
        <tbody>
            <tr>
                <th scope="row"><label for="bg_duration"><?php esc_html_e('Dauer (Wochen)', 'beyondgotham-dark-child'); ?></label></th>
                <td><input type="number" id="bg_duration" name="bg_duration" value="<?php echo esc_attr($fields['duration']); ?>" min="1" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="bg_price"><?php esc_html_e('Preis (€)', 'beyondgotham-dark-child'); ?></label></th>
                <td><input type="number" id="bg_price" name="bg_price" value="<?php echo esc_attr($fields['price']); ?>" step="0.01" min="0" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="bg_start_date"><?php esc_html_e('Startdatum', 'beyondgotham-dark-child'); ?></label></th>
                <td><input type="date" id="bg_start_date" name="bg_start_date" value="<?php echo esc_attr($fields['start_date']); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="bg_end_date"><?php esc_html_e('Enddatum', 'beyondgotham-dark-child'); ?></label></th>
                <td><input type="date" id="bg_end_date" name="bg_end_date" value="<?php echo esc_attr($fields['end_date']); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="bg_total_spots"><?php esc_html_e('Plätze gesamt', 'beyondgotham-dark-child'); ?></label></th>
                <td><input type="number" id="bg_total_spots" name="bg_total_spots" value="<?php echo esc_attr($fields['total_spots']); ?>" min="0" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="bg_available_spots"><?php esc_html_e('Plätze frei', 'beyondgotham-dark-child'); ?></label></th>
                <td><input type="number" id="bg_available_spots" name="bg_available_spots" value="<?php echo esc_attr($fields['available_spots']); ?>" min="0" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="bg_language"><?php esc_html_e('Sprache', 'beyondgotham-dark-child'); ?></label></th>
                <td><input type="text" id="bg_language" name="bg_language" value="<?php echo esc_attr($fields['language']); ?>" class="regular-text" placeholder="<?php esc_attr_e('Deutsch', 'beyondgotham-dark-child'); ?>"></td>
            </tr>
            <tr>
                <th scope="row"><label for="bg_location"><?php esc_html_e('Ort / Remote', 'beyondgotham-dark-child'); ?></label></th>
                <td><input type="text" id="bg_location" name="bg_location" value="<?php echo esc_attr($fields['location']); ?>" class="regular-text" placeholder="<?php esc_attr_e('Berlin / Remote', 'beyondgotham-dark-child'); ?>"></td>
            </tr>
            <tr>
                <th scope="row"><label for="bg_delivery_mode"><?php esc_html_e('Durchführungsart', 'beyondgotham-dark-child'); ?></label></th>
                <td>
                    <select id="bg_delivery_mode" name="bg_delivery_mode">
                        <?php
                        $modes = [
                            ''         => __('Bitte wählen', 'beyondgotham-dark-child'),
                            'online'   => __('Online (Live)', 'beyondgotham-dark-child'),
                            'hybrid'   => __('Hybrid', 'beyondgotham-dark-child'),
                            'onsite'   => __('Vor Ort', 'beyondgotham-dark-child'),
                        ];
                        foreach ($modes as $value => $label) :
                            printf('<option value="%1$s" %2$s>%3$s</option>', esc_attr($value), selected($fields['delivery_mode'], $value, false), esc_html($label));
                        endforeach;
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Bildungsgutschein', 'beyondgotham-dark-child'); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="bg_bildungsgutschein" value="1" <?php checked($fields['has_voucher'], '1'); ?>>
                        <?php esc_html_e('Kurs ist AZAV förderfähig', 'beyondgotham-dark-child'); ?>
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="bg_instructor_id"><?php esc_html_e('Dozent:in', 'beyondgotham-dark-child'); ?></label></th>
                <td>
                    <select id="bg_instructor_id" name="bg_instructor_id" class="regular-text">
                        <option value=""><?php esc_html_e('Bitte wählen', 'beyondgotham-dark-child'); ?></option>
                        <?php foreach ($instructors as $instructor) : ?>
                            <option value="<?php echo esc_attr($instructor->ID); ?>" <?php selected($fields['instructor_id'], $instructor->ID); ?>>
                                <?php echo esc_html($instructor->post_title); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

/**
 * Render instructor meta box.
 *
 * @param WP_Post $post Current post.
 */
function bg_render_instructor_meta_box($post) {
    wp_nonce_field('bg_save_instructor_details', 'bg_instructor_nonce');

    $fields = [
        'qualification' => get_post_meta($post->ID, '_bg_qualification', true),
        'experience'    => get_post_meta($post->ID, '_bg_experience', true),
        'email'         => get_post_meta($post->ID, '_bg_email', true),
        'linkedin'      => get_post_meta($post->ID, '_bg_linkedin', true),
    ];
    ?>
    <table class="form-table bg-instructor-meta">
        <tbody>
            <tr>
                <th scope="row"><label for="bg_qualification"><?php esc_html_e('Qualifikation', 'beyondgotham-dark-child'); ?></label></th>
                <td><input type="text" id="bg_qualification" name="bg_qualification" value="<?php echo esc_attr($fields['qualification']); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="bg_experience"><?php esc_html_e('Erfahrung (Jahre)', 'beyondgotham-dark-child'); ?></label></th>
                <td><input type="number" id="bg_experience" name="bg_experience" value="<?php echo esc_attr($fields['experience']); ?>" min="0" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="bg_email"><?php esc_html_e('E-Mail', 'beyondgotham-dark-child'); ?></label></th>
                <td><input type="email" id="bg_email" name="bg_email" value="<?php echo esc_attr($fields['email']); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="bg_linkedin"><?php esc_html_e('LinkedIn', 'beyondgotham-dark-child'); ?></label></th>
                <td><input type="url" id="bg_linkedin" name="bg_linkedin" value="<?php echo esc_attr($fields['linkedin']); ?>" class="regular-text" placeholder="https://"></td>
            </tr>
        </tbody>
    </table>
    <?php
}

// -----------------------------------------------------------------------------
// Save meta
// -----------------------------------------------------------------------------

add_action('save_post_bg_course', 'bg_save_course_details');
/**
 * Persist course meta data.
 *
 * @param int $post_id Post ID.
 */
function bg_save_course_details($post_id) {
    if (!isset($_POST['bg_course_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bg_course_nonce'])), 'bg_save_course_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $total_spots     = isset($_POST['bg_total_spots']) ? absint(wp_unslash($_POST['bg_total_spots'])) : '';
    $available_spots = isset($_POST['bg_available_spots']) ? absint(wp_unslash($_POST['bg_available_spots'])) : '';

    if ('' === $total_spots) {
        $total_spots = 0;
    }

    if ('' === $available_spots) {
        $existing = bg_get_course_available_spots($post_id);
        $available_spots = '' !== $existing ? absint($existing) : $total_spots;
    }

    if ($available_spots > $total_spots) {
        $available_spots = $total_spots;
    }

    $meta_map = [
        '_bg_duration'          => isset($_POST['bg_duration']) ? sanitize_text_field(wp_unslash($_POST['bg_duration'])) : '',
        '_bg_price'             => isset($_POST['bg_price']) ? sanitize_text_field(wp_unslash($_POST['bg_price'])) : '',
        '_bg_start_date'        => isset($_POST['bg_start_date']) ? sanitize_text_field(wp_unslash($_POST['bg_start_date'])) : '',
        '_bg_end_date'          => isset($_POST['bg_end_date']) ? sanitize_text_field(wp_unslash($_POST['bg_end_date'])) : '',
        '_bg_language'          => isset($_POST['bg_language']) ? sanitize_text_field(wp_unslash($_POST['bg_language'])) : '',
        '_bg_location'          => isset($_POST['bg_location']) ? sanitize_text_field(wp_unslash($_POST['bg_location'])) : '',
        '_bg_delivery_mode'     => isset($_POST['bg_delivery_mode']) ? sanitize_text_field(wp_unslash($_POST['bg_delivery_mode'])) : '',
        '_bg_instructor_id'     => isset($_POST['bg_instructor_id']) ? absint(wp_unslash($_POST['bg_instructor_id'])) : '',
        '_bg_bildungsgutschein' => isset($_POST['bg_bildungsgutschein']) ? '1' : '',
        '_bg_total_spots'       => $total_spots,
        '_bg_available_spots'   => $available_spots,
        '_bg_max_participants'  => $total_spots, // Backwards compatibility.
    ];

    foreach ($meta_map as $key => $value) {
        update_post_meta($post_id, $key, $value);
    }
}

add_action('save_post_bg_instructor', 'bg_save_instructor_details');
/**
 * Persist instructor meta.
 *
 * @param int $post_id Post ID.
 */
function bg_save_instructor_details($post_id) {
    if (!isset($_POST['bg_instructor_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bg_instructor_nonce'])), 'bg_save_instructor_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $meta_map = [
        '_bg_qualification' => isset($_POST['bg_qualification']) ? sanitize_text_field(wp_unslash($_POST['bg_qualification'])) : '',
        '_bg_experience'    => isset($_POST['bg_experience']) ? absint(wp_unslash($_POST['bg_experience'])) : '',
        '_bg_email'         => isset($_POST['bg_email']) ? sanitize_email(wp_unslash($_POST['bg_email'])) : '',
        '_bg_linkedin'      => isset($_POST['bg_linkedin']) ? esc_url_raw(wp_unslash($_POST['bg_linkedin'])) : '',
    ];

    foreach ($meta_map as $key => $value) {
        update_post_meta($post_id, $key, $value);
    }
}

// -----------------------------------------------------------------------------
// Admin columns
// -----------------------------------------------------------------------------

add_filter('manage_bg_course_posts_columns', 'bg_course_admin_columns');
/**
 * Custom columns for courses list.
 *
 * @param array $columns Columns.
 * @return array
 */
function bg_course_admin_columns($columns) {
    $new_columns = [
        'cb'                          => $columns['cb'],
        'title'                       => __('Kurs', 'beyondgotham-dark-child'),
        'taxonomy-bg_course_category' => __('Kategorie', 'beyondgotham-dark-child'),
        'bg_level'                    => __('Level', 'beyondgotham-dark-child'),
        'bg_spots'                    => __('Plätze', 'beyondgotham-dark-child'),
        'bg_start_date'               => __('Start', 'beyondgotham-dark-child'),
        'bg_instructor'               => __('Dozent:in', 'beyondgotham-dark-child'),
        'date'                        => $columns['date'],
    ];

    return $new_columns;
}

add_action('manage_bg_course_posts_custom_column', 'bg_course_admin_column_content', 10, 2);
/**
 * Render course column content.
 *
 * @param string $column Column ID.
 * @param int    $post_id Post ID.
 */
function bg_course_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'bg_level':
            $level = wp_get_post_terms($post_id, 'bg_course_level');
            if (!empty($level) && !is_wp_error($level)) {
                echo esc_html($level[0]->name);
            } else {
                esc_html_e('—', 'beyondgotham-dark-child');
            }
            break;
        case 'bg_spots':
            $total = bg_get_course_total_spots($post_id);
            $available = bg_get_course_available_spots($post_id);
            echo esc_html(sprintf('%1$d / %2$d', $available, $total));
            break;
        case 'bg_start_date':
            $start = get_post_meta($post_id, '_bg_start_date', true);
            echo $start ? esc_html(date_i18n('d.m.Y', strtotime($start))) : esc_html__('—', 'beyondgotham-dark-child');
            break;
        case 'bg_instructor':
            $instructor_id = (int) get_post_meta($post_id, '_bg_instructor_id', true);
            if ($instructor_id) {
                printf('<a href="%1$s">%2$s</a>', esc_url(get_edit_post_link($instructor_id)), esc_html(get_the_title($instructor_id)));
            } else {
                esc_html_e('—', 'beyondgotham-dark-child');
            }
            break;
    }
}

add_filter('manage_bg_instructor_posts_columns', 'bg_instructor_admin_columns');
/**
 * Custom columns for instructors list.
 *
 * @param array $columns Columns.
 * @return array
 */
function bg_instructor_admin_columns($columns) {
    $columns['bg_email']      = __('E-Mail', 'beyondgotham-dark-child');
    $columns['bg_experience'] = __('Erfahrung', 'beyondgotham-dark-child');
    return $columns;
}

add_action('manage_bg_instructor_posts_custom_column', 'bg_instructor_admin_column_content', 10, 2);
/**
 * Render instructor column content.
 *
 * @param string $column Column ID.
 * @param int    $post_id Post ID.
 */
function bg_instructor_admin_column_content($column, $post_id) {
    if ('bg_email' === $column) {
        $email = get_post_meta($post_id, '_bg_email', true);
        echo $email ? esc_html($email) : esc_html__('—', 'beyondgotham-dark-child');
    }

    if ('bg_experience' === $column) {
        $experience = get_post_meta($post_id, '_bg_experience', true);
        echo $experience ? esc_html(sprintf(_n('%d Jahr', '%d Jahre', (int) $experience, 'beyondgotham-dark-child'), (int) $experience)) : esc_html__('—', 'beyondgotham-dark-child');
    }
}

add_filter('manage_bg_enrollment_posts_columns', 'bg_enrollment_admin_columns');
/**
 * Custom columns for enrollments.
 *
 * @param array $columns Columns.
 * @return array
 */
function bg_enrollment_admin_columns($columns) {
    $columns['bg_course']  = __('Kurs', 'beyondgotham-dark-child');
    $columns['bg_email']   = __('E-Mail', 'beyondgotham-dark-child');
    $columns['bg_status']  = __('Status', 'beyondgotham-dark-child');
    $columns['bg_created'] = __('Eingang', 'beyondgotham-dark-child');
    return $columns;
}

add_action('manage_bg_enrollment_posts_custom_column', 'bg_enrollment_admin_column_content', 10, 2);
/**
 * Render enrollment column content.
 *
 * @param string $column Column ID.
 * @param int    $post_id Post ID.
 */
function bg_enrollment_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'bg_course':
            $course_id = (int) get_post_meta($post_id, '_bg_course_id', true);
            if ($course_id) {
                printf('<a href="%1$s">%2$s</a>', esc_url(get_edit_post_link($course_id)), esc_html(get_the_title($course_id)));
            } else {
                esc_html_e('—', 'beyondgotham-dark-child');
            }
            break;
        case 'bg_email':
            $email = get_post_meta($post_id, '_bg_email', true);
            echo $email ? esc_html($email) : esc_html__('—', 'beyondgotham-dark-child');
            break;
        case 'bg_status':
            $status = get_post_meta($post_id, '_bg_status', true);
            echo $status ? esc_html(ucfirst($status)) : esc_html__('—', 'beyondgotham-dark-child');
            break;
        case 'bg_created':
            $created = get_post_meta($post_id, '_bg_submitted_at', true);
            echo $created ? esc_html(date_i18n('d.m.Y H:i', strtotime($created))) : esc_html__('—', 'beyondgotham-dark-child');
            break;
    }
}

// -----------------------------------------------------------------------------
// Helper functions (shared between templates and AJAX)
// -----------------------------------------------------------------------------

if (!function_exists('bg_get_course_total_spots')) {
    /**
     * Get total seats for a course.
     *
     * @param int $course_id Course ID.
     * @return int
     */
    function bg_get_course_total_spots($course_id) {
        $value = get_post_meta($course_id, '_bg_total_spots', true);
        if ('' === $value) {
            $value = get_post_meta($course_id, '_bg_max_participants', true);
        }
        return $value ? absint($value) : 0;
    }
}

if (!function_exists('bg_get_course_available_spots')) {
    /**
     * Get available seats for a course.
     *
     * @param int $course_id Course ID.
     * @return int
     */
    function bg_get_course_available_spots($course_id) {
        $value = get_post_meta($course_id, '_bg_available_spots', true);
        if ('' === $value) {
            $total = bg_get_course_total_spots($course_id);
            $value = $total;
        }
        return $value ? absint($value) : 0;
    }
}

if (!function_exists('bg_adjust_course_available_spots')) {
    /**
     * Adjust available spots for a course (never below zero).
     *
     * @param int $course_id Course ID.
     * @param int $delta     Delta to apply (negative to decrement).
     */
    function bg_adjust_course_available_spots($course_id, $delta) {
        $total     = bg_get_course_total_spots($course_id);
        $available = bg_get_course_available_spots($course_id);

        $updated = max(0, min($total, $available + (int) $delta));
        update_post_meta($course_id, '_bg_available_spots', $updated);
    }
}
