// ============================================
// 9. CONTACT FORM HANDLER
// ============================================
function bg_handle_contact_form() {
    // Nonce-Prüfung
    if (!isset($_POST['bg_contact_nonce']) || !wp_verify_nonce($_POST['bg_contact_nonce'], 'bg_contact_form')) {
        wp_send_json_error(['message' => 'Sicherheitsprüfung fehlgeschlagen.']);
    }
    
    // Daten validieren
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
    
    // E-Mail an Admin
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
    
    // Bestätigungs-E-Mail an Absender
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
