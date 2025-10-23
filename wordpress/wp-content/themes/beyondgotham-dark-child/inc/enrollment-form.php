<?php
/**
 * Kurs-Anmeldeformular
 * Shortcode: [bg_course_enrollment course_id="123"]
 */

// ============================================
// SHORTCODE REGISTRIERUNG
// ============================================
function bg_course_enrollment_shortcode($atts) {
    $atts = shortcode_atts([
        'course_id' => get_the_ID(),
    ], $atts);

    $course_id = intval($atts['course_id']);

    if (!$course_id || get_post_type($course_id) !== 'bg_course') {
        return '<p class="bg-enrollment-message">' . esc_html__('Kurs nicht gefunden.', 'beyondgotham-dark-child') . '</p>';
    }

    ob_start();
    bg_render_enrollment_form($course_id);
    return ob_get_clean();
}
add_shortcode('bg_course_enrollment', 'bg_course_enrollment_shortcode');


// ============================================
// FORMULAR RENDERING
// ============================================
function bg_render_enrollment_form($course_id) {
    $course_title       = get_the_title($course_id);
    $max_participants   = get_post_meta($course_id, '_bg_max_participants', true);
    $bildungsgutschein  = get_post_meta($course_id, '_bg_bildungsgutschein', true);

    // Aktuelle Anmeldungen zählen
    $current_enrollments = new WP_Query([
        'post_type'      => 'bg_enrollment',
        'fields'         => 'ids',
        'no_found_rows'  => true,
        'meta_query'     => [
            [
                'key'   => '_bg_course_id',
                'value' => $course_id,
            ],
            [
                'key'     => '_bg_status',
                'value'   => ['confirmed', 'pending'],
                'compare' => 'IN',
            ],
        ],
        'posts_per_page' => -1,
    ]);

    $enrolled   = count($current_enrollments->posts);
    $spots_left = $max_participants ? max(0, intval($max_participants) - $enrolled) : 99;
    $is_full    = $max_participants && $enrolled >= intval($max_participants);

    wp_enqueue_script(
        'bg-enrollment-form',
        get_stylesheet_directory_uri() . '/assets/js/enrollment-form.js',
        ['jquery'],
        '1.0.0',
        true
    );

    static $enrollment_script_localized = false;

    if (!$enrollment_script_localized) {
        wp_localize_script('bg-enrollment-form', 'bgEnrollmentForm', [
            'ajaxUrl'       => admin_url('admin-ajax.php'),
            'errorMessage'  => __('Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.', 'beyondgotham-dark-child'),
            'redirectDelay' => 2000,
            'sendingLabel'  => __('Wird gesendet …', 'beyondgotham-dark-child'),
        ]);

        $enrollment_script_localized = true;
    }

    $form_id = 'bg-enrollment-form-' . $course_id;
    $field_ids = [
        'first_name'          => 'course-' . $course_id . '-first-name',
        'last_name'           => 'course-' . $course_id . '-last-name',
        'email'               => 'course-' . $course_id . '-email',
        'phone'               => 'course-' . $course_id . '-phone',
        'toggle_bildung'      => 'course-' . $course_id . '-toggle-bildung',
        'gutschein_number'    => 'course-' . $course_id . '-gutschein-number',
        'gutschein_agency'    => 'course-' . $course_id . '-gutschein-agency',
        'motivation'          => 'course-' . $course_id . '-motivation',
        'consent'             => 'course-' . $course_id . '-consent',
    ];
    $submit_label = $is_full ? __('Zur Warteliste', 'beyondgotham-dark-child') : __('Verbindlich anmelden', 'beyondgotham-dark-child');
    ?>
    <div class="bg-enrollment-form-wrapper" data-course="<?php echo esc_attr($course_id); ?>">
        <h3 class="bg-enrollment-form__heading"><?php printf(esc_html__('Anmeldung: %s', 'beyondgotham-dark-child'), esc_html($course_title)); ?></h3>

        <?php if ($is_full) : ?>
            <div class="bg-enrollment-alert bg-enrollment-alert--warning">
                <strong><?php esc_html_e('Warteliste', 'beyondgotham-dark-child'); ?>:</strong>
                <?php esc_html_e('Dieser Kurs ist ausgebucht. Sie können sich auf die Warteliste setzen lassen.', 'beyondgotham-dark-child'); ?>
            </div>
        <?php else : ?>
            <div class="bg-enrollment-alert bg-enrollment-alert--info">
                <?php printf(esc_html__('Noch %d Plätze verfügbar', 'beyondgotham-dark-child'), intval($spots_left)); ?>
            </div>
        <?php endif; ?>

        <form id="<?php echo esc_attr($form_id); ?>" class="bg-enrollment-form" method="post" action="" data-submit-label="<?php echo esc_attr($submit_label); ?>">
            <?php wp_nonce_field('bg_submit_enrollment', 'bg_enrollment_nonce'); ?>
            <input type="hidden" name="course_id" value="<?php echo esc_attr($course_id); ?>">
            <input type="hidden" name="action" value="bg_submit_enrollment">

            <div class="bg-enrollment-form__grid">
                <div class="bg-enrollment-field">
                    <label class="bg-enrollment-label" for="<?php echo esc_attr($field_ids['first_name']); ?>"><?php esc_html_e('Vorname *', 'beyondgotham-dark-child'); ?></label>
                    <input class="bg-enrollment-input" type="text" id="<?php echo esc_attr($field_ids['first_name']); ?>" name="first_name" required>
                </div>
                <div class="bg-enrollment-field">
                    <label class="bg-enrollment-label" for="<?php echo esc_attr($field_ids['last_name']); ?>"><?php esc_html_e('Nachname *', 'beyondgotham-dark-child'); ?></label>
                    <input class="bg-enrollment-input" type="text" id="<?php echo esc_attr($field_ids['last_name']); ?>" name="last_name" required>
                </div>
            </div>

            <div class="bg-enrollment-field">
                <label class="bg-enrollment-label" for="<?php echo esc_attr($field_ids['email']); ?>"><?php esc_html_e('E-Mail *', 'beyondgotham-dark-child'); ?></label>
                <input class="bg-enrollment-input" type="email" id="<?php echo esc_attr($field_ids['email']); ?>" name="email" required>
            </div>

            <div class="bg-enrollment-field">
                <label class="bg-enrollment-label" for="<?php echo esc_attr($field_ids['phone']); ?>"><?php esc_html_e('Telefon', 'beyondgotham-dark-child'); ?></label>
                <input class="bg-enrollment-input" type="tel" id="<?php echo esc_attr($field_ids['phone']); ?>" name="phone">
            </div>

            <?php if ($bildungsgutschein) : ?>
                <div class="bg-enrollment-field bg-enrollment-field--checkbox">
                    <label class="bg-enrollment-checkbox">
                        <input class="bg-enrollment-checkbox__input bg-enrollment-toggle" type="checkbox" id="<?php echo esc_attr($field_ids['toggle_bildung']); ?>" name="has_bildungsgutschein" value="1">
                        <span class="bg-enrollment-checkbox__text"><?php esc_html_e('Ich habe einen Bildungsgutschein', 'beyondgotham-dark-child'); ?></span>
                    </label>
                </div>

                <div class="bg-enrollment-bildungsgutschein" hidden>
                    <h4 class="bg-enrollment-bildungsgutschein__title"><?php esc_html_e('Bildungsgutschein-Details', 'beyondgotham-dark-child'); ?></h4>
                    <div class="bg-enrollment-field">
                        <label class="bg-enrollment-label" for="<?php echo esc_attr($field_ids['gutschein_number']); ?>"><?php esc_html_e('Gutschein-Nummer', 'beyondgotham-dark-child'); ?></label>
                        <input class="bg-enrollment-input" type="text" id="<?php echo esc_attr($field_ids['gutschein_number']); ?>" name="gutschein_number">
                    </div>
                    <div class="bg-enrollment-field">
                        <label class="bg-enrollment-label" for="<?php echo esc_attr($field_ids['gutschein_agency']); ?>"><?php esc_html_e('Ausstellende Agentur/Jobcenter', 'beyondgotham-dark-child'); ?></label>
                        <input class="bg-enrollment-input" type="text" id="<?php echo esc_attr($field_ids['gutschein_agency']); ?>" name="gutschein_agency" placeholder="<?php esc_attr_e('Agentur für Arbeit Leipzig', 'beyondgotham-dark-child'); ?>">
                    </div>
                </div>
            <?php endif; ?>

            <div class="bg-enrollment-field">
                <label class="bg-enrollment-label" for="<?php echo esc_attr($field_ids['motivation']); ?>"><?php esc_html_e('Motivation / Vorerfahrung', 'beyondgotham-dark-child'); ?></label>
                <textarea class="bg-enrollment-textarea" id="<?php echo esc_attr($field_ids['motivation']); ?>" name="motivation" rows="4"></textarea>
            </div>

            <div class="bg-enrollment-field bg-enrollment-field--checkbox">
                <label class="bg-enrollment-checkbox">
                    <input class="bg-enrollment-checkbox__input" type="checkbox" id="<?php echo esc_attr($field_ids['consent']); ?>" name="dsgvo_consent" value="1" required>
                    <span class="bg-enrollment-checkbox__text"><?php esc_html_e('Ich stimme der Datenschutzerklärung zu *', 'beyondgotham-dark-child'); ?></span>
                </label>
            </div>

            <div class="bg-enrollment-response" aria-live="polite"></div>

            <button type="submit" class="bg-enrollment-submit"><?php echo esc_html($submit_label); ?></button>
        </form>
    </div>
    <?php
}


// ============================================
// AJAX HANDLER
// ============================================
function bg_handle_enrollment_submission() {
    if (!isset($_POST['bg_enrollment_nonce']) || !wp_verify_nonce($_POST['bg_enrollment_nonce'], 'bg_submit_enrollment')) {
        wp_send_json_error(['message' => __('Sicherheitsprüfung fehlgeschlagen.', 'beyondgotham-dark-child')]);
    }

    $course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;
    if (!$course_id || get_post_type($course_id) !== 'bg_course') {
        wp_send_json_error(['message' => __('Der Kurs konnte nicht gefunden werden.', 'beyondgotham-dark-child')]);
    }

    $data = [
        '_bg_course_id'        => $course_id,
        '_bg_first_name'       => sanitize_text_field($_POST['first_name'] ?? ''),
        '_bg_last_name'        => sanitize_text_field($_POST['last_name'] ?? ''),
        '_bg_email'            => sanitize_email($_POST['email'] ?? ''),
        '_bg_phone'            => sanitize_text_field($_POST['phone'] ?? ''),
        '_bg_motivation'       => sanitize_textarea_field($_POST['motivation'] ?? ''),
        '_bg_status'           => 'pending',
        '_bg_submitted_at'     => current_time('mysql'),
    ];

    if (empty($data['_bg_first_name']) || empty($data['_bg_last_name']) || empty($data['_bg_email'])) {
        wp_send_json_error(['message' => __('Bitte füllen Sie alle Pflichtfelder aus.', 'beyondgotham-dark-child')]);
    }

    if (!is_email($data['_bg_email'])) {
        wp_send_json_error(['message' => __('Bitte geben Sie eine gültige E-Mail-Adresse an.', 'beyondgotham-dark-child')]);
    }

    $bildungsgutschein = get_post_meta($course_id, '_bg_bildungsgutschein', true);
    if ($bildungsgutschein && !empty($_POST['has_bildungsgutschein'])) {
        $data['_bg_has_bildungsgutschein'] = 1;
        $data['_bg_gutschein_number']      = sanitize_text_field($_POST['gutschein_number'] ?? '');
        $data['_bg_gutschein_agency']      = sanitize_text_field($_POST['gutschein_agency'] ?? '');
    }

    $enrollment_id = wp_insert_post([
        'post_type'   => 'bg_enrollment',
        'post_title'  => $data['_bg_first_name'] . ' ' . $data['_bg_last_name'],
        'post_status' => 'publish',
        'meta_input'  => $data,
    ]);

    if (is_wp_error($enrollment_id)) {
        wp_send_json_error(['message' => __('Die Anmeldung konnte nicht gespeichert werden.', 'beyondgotham-dark-child')]);
    }

    $course_title = get_the_title($course_id);
    $admin_email  = get_option('admin_email');

    wp_mail(
        $admin_email,
        sprintf(__('Neue Kursanmeldung: %s', 'beyondgotham-dark-child'), $course_title),
        sprintf(
            "Kurs: %s\nName: %s %s\nE-Mail: %s\nTelefon: %s\nMotivation: %s",
            $course_title,
            $data['_bg_first_name'],
            $data['_bg_last_name'],
            $data['_bg_email'],
            $data['_bg_phone'],
            $data['_bg_motivation']
        )
    );

    wp_send_json_success([
        'message'  => __('Vielen Dank! Wir melden uns in Kürze bei Ihnen.', 'beyondgotham-dark-child'),
        'redirect' => get_permalink($course_id),
    ]);
}
add_action('wp_ajax_bg_submit_enrollment', 'bg_handle_enrollment_submission');
add_action('wp_ajax_nopriv_bg_submit_enrollment', 'bg_handle_enrollment_submission');
