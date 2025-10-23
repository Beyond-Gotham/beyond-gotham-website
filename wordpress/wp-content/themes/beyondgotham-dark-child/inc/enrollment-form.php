<?php
/**
 * Enrollment form shortcode and AJAX handling.
 *
 * @package BeyondGothamDarkChild
 */

defined('ABSPATH') || exit;

// -----------------------------------------------------------------------------
// Shortcode
// -----------------------------------------------------------------------------

add_shortcode('bg_course_enrollment', 'bg_course_enrollment_shortcode');
/**
 * Render enrollment form shortcode.
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function bg_course_enrollment_shortcode($atts) {
    $atts = shortcode_atts([
        'course_id' => get_the_ID(),
    ], $atts, 'bg_course_enrollment');

    $course_id = absint($atts['course_id']);

    if (!$course_id || 'bg_course' !== get_post_type($course_id)) {
        return '<p class="bg-enrollment-message">' . esc_html__('Kurs nicht gefunden.', 'beyondgotham-dark-child') . '</p>';
    }

    ob_start();
    bg_render_enrollment_form($course_id);
    return ob_get_clean();
}

/**
 * Output enrollment form markup.
 *
 * @param int $course_id Course ID.
 */
function bg_render_enrollment_form($course_id) {
    wp_enqueue_script('bg-frontend');

    $course_title       = get_the_title($course_id);
    $total_spots        = bg_get_course_total_spots($course_id);
    $available_spots    = bg_get_course_available_spots($course_id);
    $has_voucher_option = (bool) get_post_meta($course_id, '_bg_bildungsgutschein', true);

    $is_full = $total_spots > 0 && 0 === $available_spots;
    $submit_label = $is_full ? __('Zur Warteliste anmelden', 'beyondgotham-dark-child') : __('Verbindlich anmelden', 'beyondgotham-dark-child');
    $form_id = 'bg-enrollment-form-' . $course_id;

    ?>
    <div class="bg-enrollment" id="bg-course-enrollment" data-course-id="<?php echo esc_attr($course_id); ?>">
        <div class="bg-enrollment__header">
            <h2 class="bg-enrollment__title"><?php printf(esc_html__('Anmeldung für %s', 'beyondgotham-dark-child'), esc_html($course_title)); ?></h2>
            <p class="bg-enrollment__meta">
                <?php
                if ($is_full) {
                    esc_html_e('Aktuell ausgebucht – wir setzen Sie gerne auf die Warteliste.', 'beyondgotham-dark-child');
                } else {
                    printf(
                        esc_html(_n('Noch %d Platz verfügbar', 'Noch %d Plätze verfügbar', $available_spots, 'beyondgotham-dark-child')),
                        intval($available_spots)
                    );
                }
                ?>
            </p>
        </div>

        <form id="<?php echo esc_attr($form_id); ?>" class="bg-enrollment__form" method="post" enctype="multipart/form-data" novalidate>
            <?php wp_nonce_field('bg_submit_enrollment', 'bg_enrollment_nonce'); ?>
            <input type="hidden" name="action" value="bg_enroll_course">
            <input type="hidden" name="course_id" value="<?php echo esc_attr($course_id); ?>">

            <div class="bg-enrollment__grid">
                <div class="bg-enrollment__field">
                    <label class="bg-enrollment__label" for="<?php echo esc_attr($form_id . '-first-name'); ?>"><?php esc_html_e('Vorname *', 'beyondgotham-dark-child'); ?></label>
                    <input class="bg-enrollment__input" type="text" id="<?php echo esc_attr($form_id . '-first-name'); ?>" name="first_name" required>
                </div>
                <div class="bg-enrollment__field">
                    <label class="bg-enrollment__label" for="<?php echo esc_attr($form_id . '-last-name'); ?>"><?php esc_html_e('Nachname *', 'beyondgotham-dark-child'); ?></label>
                    <input class="bg-enrollment__input" type="text" id="<?php echo esc_attr($form_id . '-last-name'); ?>" name="last_name" required>
                </div>
            </div>

            <div class="bg-enrollment__grid">
                <div class="bg-enrollment__field">
                    <label class="bg-enrollment__label" for="<?php echo esc_attr($form_id . '-email'); ?>"><?php esc_html_e('E-Mail *', 'beyondgotham-dark-child'); ?></label>
                    <input class="bg-enrollment__input" type="email" id="<?php echo esc_attr($form_id . '-email'); ?>" name="email" required>
                </div>
                <div class="bg-enrollment__field">
                    <label class="bg-enrollment__label" for="<?php echo esc_attr($form_id . '-phone'); ?>"><?php esc_html_e('Telefon', 'beyondgotham-dark-child'); ?></label>
                    <input class="bg-enrollment__input" type="tel" id="<?php echo esc_attr($form_id . '-phone'); ?>" name="phone">
                </div>
            </div>

            <div class="bg-enrollment__field">
                <label class="bg-enrollment__label" for="<?php echo esc_attr($form_id . '-motivation'); ?>"><?php esc_html_e('Motivation & Vorerfahrung', 'beyondgotham-dark-child'); ?></label>
                <textarea class="bg-enrollment__textarea" id="<?php echo esc_attr($form_id . '-motivation'); ?>" name="motivation" rows="4"></textarea>
            </div>

            <?php if ($has_voucher_option) : ?>
                <fieldset class="bg-enrollment__fieldset">
                    <legend class="bg-enrollment__legend"><?php esc_html_e('Bildungsgutschein', 'beyondgotham-dark-child'); ?></legend>
                    <label class="bg-enrollment__checkbox">
                        <input type="checkbox" class="bg-enrollment__checkbox-input" name="has_voucher" value="1" data-bg-toggle="voucher-fields">
                        <span><?php esc_html_e('Ich habe einen gültigen Bildungsgutschein', 'beyondgotham-dark-child'); ?></span>
                    </label>

                    <div class="bg-enrollment__voucher" data-bg-target="voucher-fields" hidden>
                        <div class="bg-enrollment__field">
                            <label class="bg-enrollment__label" for="<?php echo esc_attr($form_id . '-voucher-number'); ?>"><?php esc_html_e('Gutschein-Nummer', 'beyondgotham-dark-child'); ?></label>
                            <input class="bg-enrollment__input" type="text" id="<?php echo esc_attr($form_id . '-voucher-number'); ?>" name="voucher_number">
                        </div>
                        <div class="bg-enrollment__field">
                            <label class="bg-enrollment__label" for="<?php echo esc_attr($form_id . '-voucher-agency'); ?>"><?php esc_html_e('Ausstellende Agentur / Jobcenter', 'beyondgotham-dark-child'); ?></label>
                            <input class="bg-enrollment__input" type="text" id="<?php echo esc_attr($form_id . '-voucher-agency'); ?>" name="voucher_agency">
                        </div>
                        <div class="bg-enrollment__field">
                            <label class="bg-enrollment__label" for="<?php echo esc_attr($form_id . '-voucher-file'); ?>"><?php esc_html_e('Gutschein (PDF/JPG/PNG, optional)', 'beyondgotham-dark-child'); ?></label>
                            <input class="bg-enrollment__input" type="file" id="<?php echo esc_attr($form_id . '-voucher-file'); ?>" name="voucher_document" accept="application/pdf,image/jpeg,image/png">
                        </div>
                    </div>
                </fieldset>
            <?php endif; ?>

            <div class="bg-enrollment__field bg-enrollment__field--consent">
                <label class="bg-enrollment__checkbox">
                    <input type="checkbox" class="bg-enrollment__checkbox-input" name="privacy_consent" value="1" required>
                    <span><?php esc_html_e('Ich habe die Datenschutzerklärung gelesen und stimme zu.', 'beyondgotham-dark-child'); ?></span>
                </label>
            </div>

            <div class="bg-enrollment__messages" aria-live="polite"></div>

            <button type="submit" class="bg-enrollment__submit" data-default-label="<?php echo esc_attr($submit_label); ?>"><?php echo esc_html($submit_label); ?></button>
        </form>
    </div>
    <?php
}

// -----------------------------------------------------------------------------
// AJAX handler
// -----------------------------------------------------------------------------

add_action('wp_ajax_bg_enroll_course', 'bg_handle_enrollment_submission');
add_action('wp_ajax_nopriv_bg_enroll_course', 'bg_handle_enrollment_submission');
/**
 * Handle enrollment AJAX requests.
 */
function bg_handle_enrollment_submission() {
    check_ajax_referer('bg_ajax_nonce', 'security');

    if (!isset($_POST['bg_enrollment_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bg_enrollment_nonce'])), 'bg_submit_enrollment')) {
        wp_send_json_error(['message' => __('Sicherheitsprüfung fehlgeschlagen.', 'beyondgotham-dark-child')], 400);
    }

    if (!isset($_POST['course_id'])) {
        wp_send_json_error(['message' => __('Ungültige Anfrage.', 'beyondgotham-dark-child')], 400);
    }

    $course_id = absint(wp_unslash($_POST['course_id']));
    if (!$course_id || 'bg_course' !== get_post_type($course_id)) {
        wp_send_json_error(['message' => __('Kurs konnte nicht gefunden werden.', 'beyondgotham-dark-child')], 404);
    }

    $rate_key = bg_get_enrollment_rate_limit_key();
    $rate_limit = (int) get_transient($rate_key);
    if ($rate_limit >= 3) {
        wp_send_json_error(['message' => __('Sie haben das Limit für Anfragen erreicht. Bitte versuchen Sie es später erneut.', 'beyondgotham-dark-child')], 429);
    }

    $data = [
        'first_name'  => sanitize_text_field(wp_unslash($_POST['first_name'] ?? '')),
        'last_name'   => sanitize_text_field(wp_unslash($_POST['last_name'] ?? '')),
        'email'       => sanitize_email(wp_unslash($_POST['email'] ?? '')),
        'phone'       => sanitize_text_field(wp_unslash($_POST['phone'] ?? '')),
        'motivation'  => sanitize_textarea_field(wp_unslash($_POST['motivation'] ?? '')),
        'has_voucher' => isset($_POST['has_voucher']) ? '1' : '',
    ];

    if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email'])) {
        wp_send_json_error(['message' => __('Bitte füllen Sie alle Pflichtfelder aus.', 'beyondgotham-dark-child')], 400);
    }

    if (!is_email($data['email'])) {
        wp_send_json_error(['message' => __('Bitte geben Sie eine gültige E-Mail-Adresse an.', 'beyondgotham-dark-child')], 400);
    }

    if (empty($_POST['privacy_consent'])) {
        wp_send_json_error(['message' => __('Bitte akzeptieren Sie die Datenschutzbestimmungen.', 'beyondgotham-dark-child')], 400);
    }

    $total_spots     = bg_get_course_total_spots($course_id);
    $available_spots = bg_get_course_available_spots($course_id);
    $status          = ($total_spots > 0 && $available_spots <= 0) ? 'waitlist' : 'confirmed';

    $voucher_meta = [];
    if ($data['has_voucher']) {
        $voucher_meta['_bg_voucher_number'] = sanitize_text_field(wp_unslash($_POST['voucher_number'] ?? ''));
        $voucher_meta['_bg_voucher_agency'] = sanitize_text_field(wp_unslash($_POST['voucher_agency'] ?? ''));

        if (!empty($_FILES['voucher_document']['name'])) {
            $upload = wp_handle_upload($_FILES['voucher_document'], ['test_form' => false]);
            if (!isset($upload['error']) && isset($upload['file'])) {
                $attachment_id = bg_store_uploaded_file($upload, $data['first_name'] . ' ' . $data['last_name']);
                if ($attachment_id) {
                    $voucher_meta['_bg_voucher_attachment_id'] = $attachment_id;
                }
            }
        }
    }

    $enrollment_meta = array_merge([
        '_bg_course_id'    => $course_id,
        '_bg_first_name'   => $data['first_name'],
        '_bg_last_name'    => $data['last_name'],
        '_bg_email'        => $data['email'],
        '_bg_phone'        => $data['phone'],
        '_bg_motivation'   => $data['motivation'],
        '_bg_status'       => $status,
        '_bg_submitted_at' => current_time('mysql'),
    ], $voucher_meta);

    $enrollment_id = wp_insert_post([
        'post_type'   => 'bg_enrollment',
        'post_status' => 'publish',
        'post_title'  => $data['first_name'] . ' ' . $data['last_name'],
        'meta_input'  => $enrollment_meta,
    ]);

    if (is_wp_error($enrollment_id)) {
        wp_send_json_error(['message' => __('Die Anmeldung konnte nicht gespeichert werden.', 'beyondgotham-dark-child')], 500);
    }

    if ('confirmed' === $status && $total_spots > 0) {
        bg_adjust_course_available_spots($course_id, -1);
    }

    set_transient($rate_key, $rate_limit + 1, 15 * MINUTE_IN_SECONDS);
    bg_flush_course_stats_widget_cache();

    $course_title = get_the_title($course_id);
    $admin_email  = get_option('admin_email');

    wp_mail(
        $admin_email,
        sprintf(__('Neue Kursanmeldung: %s', 'beyondgotham-dark-child'), $course_title),
        sprintf(
            "Kurs: %s\nName: %s %s\nE-Mail: %s\nTelefon: %s\nStatus: %s\nMotivation: %s",
            $course_title,
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'],
            $status,
            $data['motivation']
        )
    );

    $user_message = ('waitlist' === $status)
        ? __('Vielen Dank! Sie stehen auf der Warteliste und wir melden uns, sobald ein Platz frei wird.', 'beyondgotham-dark-child')
        : __('Vielen Dank für Ihre Anmeldung! Wir melden uns in Kürze mit weiteren Informationen.', 'beyondgotham-dark-child');

    wp_mail(
        $data['email'],
        sprintf(__('Anmeldung für %s', 'beyondgotham-dark-child'), $course_title),
        $user_message
    );

    wp_send_json_success([
        'message' => $user_message,
        'status'  => $status,
    ]);
}

// -----------------------------------------------------------------------------
// Helper utilities
// -----------------------------------------------------------------------------

if (!function_exists('bg_get_enrollment_rate_limit_key')) {
    /**
     * Build a transient key for rate limiting.
     *
     * @return string
     */
    function bg_get_enrollment_rate_limit_key() {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'cli';
        return 'bg_enrollment_rate_' . md5($ip);
    }
}

if (!function_exists('bg_store_uploaded_file')) {
    /**
     * Register uploaded voucher file in the media library.
     *
     * @param array  $upload Uploaded file array from wp_handle_upload.
     * @param string $title  Attachment title.
     * @return int Attachment ID.
     */
    function bg_store_uploaded_file($upload, $title) {
        $filetype = wp_check_filetype(basename($upload['file']), null);

        $attachment = [
            'guid'           => $upload['url'],
            'post_mime_type' => $filetype['type'],
            'post_title'     => sanitize_text_field($title),
            'post_content'   => '',
            'post_status'    => 'inherit',
        ];

        $attach_id = wp_insert_attachment($attachment, $upload['file']);
        if (!is_wp_error($attach_id)) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            wp_update_attachment_metadata($attach_id, wp_generate_attachment_metadata($attach_id, $upload['file']));
            return (int) $attach_id;
        }

        return 0;
    }
}
