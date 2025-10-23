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
        return '<p style="color:var(--muted);">Kurs nicht gefunden.</p>';
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
    $course_title = get_the_title($course_id);
    $max_participants = get_post_meta($course_id, '_bg_max_participants', true);
    $bildungsgutschein = get_post_meta($course_id, '_bg_bildungsgutschein', true);
    
    // Aktuelle Anmeldungen zählen
    $current_enrollments = new WP_Query([
        'post_type' => 'bg_enrollment',
        'meta_query' => [
            [
                'key' => '_bg_course_id',
                'value' => $course_id,
            ],
            [
                'key' => '_bg_status',
                'value' => ['confirmed', 'pending'],
                'compare' => 'IN',
            ],
        ],
        'posts_per_page' => -1,
    ]);
    
    $enrolled = $current_enrollments->found_posts;
    $spots_left = $max_participants ? max(0, intval($max_participants) - $enrolled) : 99;
    $is_full = $max_participants && $enrolled >= intval($max_participants);
    
    ?>
    <div class="bg-enrollment-form-wrapper" style="background:var(--bg-2);padding:24px;border:1px solid var(--line);border-radius:4px;">
        <h3 style="margin:0 0 16px;">Anmeldung: <?php echo esc_html($course_title); ?></h3>
        
        <?php if ($is_full): ?>
            <div class="alert alert-warning" style="background:var(--bg-3);padding:12px;border-left:3px solid #ff9800;margin-bottom:16px;">
                <strong>Warteliste:</strong> Dieser Kurs ist ausgebucht. Sie können sich auf die Warteliste setzen lassen.
            </div>
        <?php else: ?>
            <div class="alert alert-info" style="background:var(--bg-3);padding:12px;border-left:3px solid var(--accent);margin-bottom:16px;">
                Noch <strong><?php echo $spots_left; ?></strong> Plätze verfügbar
            </div>
        <?php endif; ?>
        
        <form id="bg-enrollment-form" method="post" action="" class="bg-form">
            <?php wp_nonce_field('bg_submit_enrollment', 'bg_enrollment_nonce'); ?>
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
            <input type="hidden" name="action" value="bg_submit_enrollment">
            
            <div class="form-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                <div class="form-group">
                    <label for="first_name">Vorname *</label>
                    <input type="text" id="first_name" name="first_name" required style="width:100%;padding:8px;background:var(--bg);border:1px solid var(--line);color:var(--fg);">
                </div>
                
                <div class="form-group">
                    <label for="last_name">Nachname *</label>
                    <input type="text" id="last_name" name="last_name" required style="width:100%;padding:8px;background:var(--bg);border:1px solid var(--line);color:var(--fg);">
                </div>
            </div>
            
            <div class="form-group" style="margin-bottom:16px;">
                <label for="email">E-Mail *</label>
                <input type="email" id="email" name="email" required style="width:100%;padding:8px;background:var(--bg);border:1px solid var(--line);color:var(--fg);">
            </div>
            
            <div class="form-group" style="margin-bottom:16px;">
                <label for="phone">Telefon</label>
                <input type="tel" id="phone" name="phone" style="width:100%;padding:8px;background:var(--bg);border:1px solid var(--line);color:var(--fg);">
            </div>
            
            <?php if ($bildungsgutschein): ?>
            <div class="form-group" style="margin-bottom:16px;">
                <label>
                    <input type="checkbox" id="has_bildungsgutschein" name="has_bildungsgutschein" value="1">
                    Ich habe einen Bildungsgutschein
                </label>
            </div>
            
            <div id="bildungsgutschein-fields" style="display:none;background:var(--bg-3);padding:16px;border-radius:4px;margin-bottom:16px;">
                <h4 style="margin:0 0 12px;">Bildungsgutschein-Details</h4>
                <div class="form-group" style="margin-bottom:12px;">
                    <label for="gutschein_number">Gutschein-Nummer</label>
                    <input type="text" id="gutschein_number" name="gutschein_number" style="width:100%;padding:8px;background:var(--bg);border:1px solid var(--line);color:var(--fg);">
                </div>
                <div class="form-group">
                    <label for="gutschein_agency">Ausstellende Agentur/Jobcenter</label>
                    <input type="text" id="gutschein_agency" name="gutschein_agency" placeholder="Agentur für Arbeit Leipzig" style="width:100%;padding:8px;background:var(--bg);border:1px solid var(--line);color:var(--fg);">
                </div>
            </div>
            <?php endif; ?>
            
            <div class="form-group" style="margin-bottom:16px;">
                <label for="motivation">Motivation / Vorerfahrung</label>
                <textarea id="motivation" name="motivation" rows="4" style="width:100%;padding:8px;background:var(--bg);border:1px solid var(--line);color:var(--fg);resize:vertical;"></textarea>
            </div>
            
            <div class="form-group" style="margin-bottom:16px;">
                <label>
                    <input type="checkbox" id="dsgvo_consent" name="dsgvo_consent" required value="1">
                    Ich stimme der <a href="/datenschutz/" target="_blank" style="color:var(--accent);">Datenschutzerklärung</a> zu *
                </label>
            </div>
            
            <div id="form-response" style="margin-bottom:16px;"></div>
            
            <button type="submit" class="btn" style="padding:12px 24px;background:var(--accent);color:#001018;border:none;border-radius:4px;cursor:pointer;font-weight:600;">
                <?php echo $is_full ? 'Zur Warteliste' : 'Verbindlich anmelden'; ?>
            </button>
        </form>
    </div>
    
    <script>
    (function($) {
        $(document).ready(function() {
            // Bildungsgutschein Toggle
            $('#has_bildungsgutschein').on('change', function() {
                $('#bildungsgutschein-fields').toggle(this.checked);
            });
            
            // AJAX Form Submission
            $('#bg-enrollment-form').on('submit', function(e) {
                e.preventDefault();
                
                var $form = $(this);
                var $btn = $form.find('button[type="submit"]');
                var $response = $('#form-response');
                
                $btn.prop('disabled', true).text('Wird gesendet...');
                $response.html('');
                
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $response.html('<div class="alert alert-success" style="background:var(--bg-3);padding:12px;border-left:3px solid #4caf50;color:var(--fg);">' + response.data.message + '</div>');
                            $form[0].reset();
                            
                            // Redirect nach 2 Sekunden
                            setTimeout(function() {
                                if (response.data.redirect) {
                                    window.location.href = response.data.redirect;
                                }
                            }, 2000);
                        } else {
                            $response.html('<div class="alert alert-error" style="background:var(--bg-3);padding:12px;border-left:3px solid #f44336;color:var(--fg);">' + response.data.message + '</div>');
                        }
                    },
                    error: function() {
                        $response.html('<div class="alert alert-error" style="background:var(--bg-3);padding:12px;border-left:3px solid #f44336;color:var(--fg);">Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.</div>');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text('<?php echo $is_full ? 'Zur Warteliste' : 'Verbindlich anmelden'; ?>');
                    }
                });
            });
        });
    })(jQuery);
    </script>
    <?php
}


// ============================================
// AJAX HANDLER
// ============================================
function bg_handle_enrollment_submission() {
    // Nonce-Prüfung
    if (!isset($_POST['bg_enrollment_nonce']) || !wp_verify_nonce($_POST['bg_enrollment_nonce'], 'bg_submit_enrollment')) {
        wp_send_json_error(['message' => 'Sicherheitsprüfung fehlgeschlagen.']);
    }
    
    // Daten validieren
    $course_id = intval($_POST['course_id']);
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $motivation = sanitize_textarea_field($_POST['motivation']);
    $has_bildungsgutschein = isset($_POST['has_bildungsgutschein']) ? 1 : 0;
    $gutschein_number = sanitize_text_field($_POST['gutschein_number'] ?? '');
    $gutschein_agency = sanitize_text_field($_POST['gutschein_agency'] ?? '');
    $dsgvo_consent = isset($_POST['dsgvo_consent']) ? 1 : 0;
    
    if (!$course_id || !$first_name || !$last_name || !$email || !$dsgvo_consent) {
        wp_send_json_error(['message' => 'Bitte füllen Sie alle Pflichtfelder aus.']);
    }
    
    // Prüfen ob Kurs existiert
    if (get_post_type($course_id) !== 'bg_course') {
        wp_send_json_error(['message' => 'Kurs nicht gefunden.']);
    }
    
    // Prüfen ob noch Plätze frei
    $max_participants = get_post_meta($course_id, '_bg_max_participants', true);
    $current_enrollments = new WP_Query([
        'post_type' => 'bg_enrollment',
        'meta_query' => [
            ['key' => '_bg_course_id', 'value' => $course_id],
            ['key' => '_bg_status', 'value' => ['confirmed', 'pending'], 'compare' => 'IN'],
        ],
        'posts_per_page' => -1,
    ]);
    
    $enrolled = $current_enrollments->found_posts;
    $is_full = $max_participants && $enrolled >= intval($max_participants);
    $status = $is_full ? 'waitlist' : 'pending';
    
    // Anmeldung erstellen
    $enrollment_id = wp_insert_post([
        'post_type' => 'bg_enrollment',
        'post_title' => $first_name . ' ' . $last_name . ' - ' . get_the_title($course_id),
        'post_status' => 'publish',
        'meta_input' => [
            '_bg_course_id' => $course_id,
            '_bg_first_name' => $first_name,
            '_bg_last_name' => $last_name,
            '_bg_email' => $email,
            '_bg_phone' => $phone,
            '_bg_motivation' => $motivation,
            '_bg_has_bildungsgutschein' => $has_bildungsgutschein,
            '_bg_gutschein_number' => $gutschein_number,
            '_bg_gutschein_agency' => $gutschein_agency,
            '_bg_status' => $status,
            '_bg_submission_date' => current_time('mysql'),
        ],
    ]);
    
    if ($enrollment_id) {
        // E-Mail an Teilnehmer
        bg_send_enrollment_confirmation($enrollment_id, $email, $status);
        
        // E-Mail an Admin
        bg_send_admin_notification($enrollment_id);
        
        $message = $is_full 
            ? 'Sie wurden auf die Warteliste gesetzt. Wir melden uns, sobald ein Platz frei wird.'
            : 'Ihre Anmeldung wurde erfolgreich übermittelt. Sie erhalten in Kürze eine Bestätigung per E-Mail.';
        
        wp_send_json_success([
            'message' => $message,
            'redirect' => get_permalink($course_id) . '?enrolled=1',
        ]);
    } else {
        wp_send_json_error(['message' => 'Ein Fehler ist aufgetreten. Bitte kontaktieren Sie uns direkt.']);
    }
}
add_action('wp_ajax_bg_submit_enrollment', 'bg_handle_enrollment_submission');
add_action('wp_ajax_nopriv_bg_submit_enrollment', 'bg_handle_enrollment_submission');


// ============================================
// E-MAIL NOTIFICATIONS
// ============================================
function bg_send_enrollment_confirmation($enrollment_id, $email, $status) {
    $first_name = get_post_meta($enrollment_id, '_bg_first_name', true);
    $course_id = get_post_meta($enrollment_id, '_bg_course_id', true);
    $course_title = get_the_title($course_id);
    $start_date = get_post_meta($course_id, '_bg_start_date', true);
    
    $subject = $status === 'waitlist' 
        ? 'Warteliste: ' . $course_title 
        : 'Anmeldebestätigung: ' . $course_title;
    
    $message = "Hallo $first_name,\n\n";
    
    if ($status === 'waitlist') {
        $message .= "Sie wurden auf die Warteliste für den Kurs \"$course_title\" gesetzt.\n\n";
        $message .= "Wir informieren Sie umgehend, sobald ein Platz frei wird.\n\n";
    } else {
        $message .= "Ihre Anmeldung für den Kurs \"$course_title\" ist bei uns eingegangen.\n\n";
        if ($start_date) {
            $message .= "Kursbeginn: " . date_i18n('d.m.Y', strtotime($start_date)) . "\n\n";
        }
        $message .= "Wir prüfen Ihre Anmeldung und senden Ihnen in Kürze weitere Informationen.\n\n";
    }
    
    $message .= "Bei Fragen erreichen Sie uns unter:\nkontakt@beyond-gotham.org\n\n";
    $message .= "Mit freundlichen Grüßen\nIhr Beyond_Gotham Team";
    
    wp_mail($email, $subject, $message, ['From: Beyond_Gotham <noreply@beyond-gotham.org>']);
}

function bg_send_admin_notification($enrollment_id) {
    $admin_email = get_option('admin_email');
    $first_name = get_post_meta($enrollment_id, '_bg_first_name', true);
    $last_name = get_post_meta($enrollment_id, '_bg_last_name', true);
    $email = get_post_meta($enrollment_id, '_bg_email', true);
    $course_id = get_post_meta($enrollment_id, '_bg_course_id', true);
    $course_title = get_the_title($course_id);
    $status = get_post_meta($enrollment_id, '_bg_status', true);
    
    $subject = "[Beyond_Gotham] Neue Anmeldung: $course_title";
    
    $message = "Neue Kurs-Anmeldung:\n\n";
    $message .= "Kurs: $course_title\n";
    $message .= "Status: " . ($status === 'waitlist' ? 'Warteliste' : 'Pending') . "\n\n";
    $message .= "Teilnehmer: $first_name $last_name\n";
    $message .= "E-Mail: $email\n\n";
    $message .= "Anmeldung bearbeiten:\n" . admin_url('post.php?post=' . $enrollment_id . '&action=edit');
    
    wp_mail($admin_email, $subject, $message);
}
