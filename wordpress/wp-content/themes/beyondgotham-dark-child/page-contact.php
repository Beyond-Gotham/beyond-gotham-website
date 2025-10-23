<?php
/**
 * Template Name: Kontakt
 * Description: Kontaktformular und Kontaktinformationen
 */

get_header(); ?>

<main id="primary" class="site-main page-contact" style="padding:60px 0;background:var(--bg);color:var(--fg);">
    
    <!-- Hero -->
    <section class="contact-hero" style="
        padding:80px 0;
        background:linear-gradient(135deg, var(--bg-2) 0%, var(--bg-3) 100%);
        text-align:center;
        margin-bottom:80px;
    ">
        <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">
            <h1 style="
                margin:0 0 24px;
                font-size:clamp(2.5rem, 5vw, 4rem);
                line-height:1.1;
                font-weight:800;
            ">
                Kontakt aufnehmen
            </h1>
            <p style="
                margin:0;
                font-size:1.4rem;
                color:var(--muted);
                max-width:700px;
                margin:0 auto;
                line-height:1.6;
            ">
                Wir freuen uns auf Ihre Nachricht –<br>
                ob für Kursanfragen, Partnerschaften oder Presseanfragen
            </p>
        </div>
    </section>

    <div class="container" style="max-width:1200px;margin:0 auto;padding:0 24px;">

        <div style="display:grid;grid-template-columns:1fr 400px;gap:64px;margin-bottom:80px;">
            
            <!-- Kontaktformular -->
            <div class="contact-form-section">
                <h2 style="margin:0 0 24px;font-size:2rem;">
                    Nachricht senden
                </h2>

                <form id="contact-form" method="post" action="" style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    padding:32px;
                ">
                    <?php wp_nonce_field('bg_contact_form', 'bg_contact_nonce'); ?>

                    <div style="margin-bottom:24px;">
                        <label for="contact_name" style="display:block;margin-bottom:8px;font-weight:600;">
                            Name *
                        </label>
                        <input 
                            type="text" 
                            id="contact_name" 
                            name="contact_name" 
                            required 
                            style="
                                width:100%;
                                padding:12px;
                                background:var(--bg);
                                border:1px solid var(--line);
                                border-radius:6px;
                                color:var(--fg);
                                font-size:1rem;
                            "
                        >
                    </div>

                    <div style="margin-bottom:24px;">
                        <label for="contact_email" style="display:block;margin-bottom:8px;font-weight:600;">
                            E-Mail *
                        </label>
                        <input 
                            type="email" 
                            id="contact_email" 
                            name="contact_email" 
                            required 
                            style="
                                width:100%;
                                padding:12px;
                                background:var(--bg);
                                border:1px solid var(--line);
                                border-radius:6px;
                                color:var(--fg);
                                font-size:1rem;
                            "
                        >
                    </div>

                    <div style="margin-bottom:24px;">
                        <label for="contact_subject" style="display:block;margin-bottom:8px;font-weight:600;">
                            Betreff
                        </label>
                        <select 
                            id="contact_subject" 
                            name="contact_subject" 
                            style="
                                width:100%;
                                padding:12px;
                                background:var(--bg);
                                border:1px solid var(--line);
                                border-radius:6px;
                                color:var(--fg);
                                font-size:1rem;
                            "
                        >
                            <option value="general">Allgemeine Anfrage</option>
                            <option value="courses">Kursanfrage</option>
                            <option value="partnership">Partnerschaft</option>
                            <option value="press">Presseanfrage</option>
                            <option value="donation">Spende / Förderung</option>
                            <option value="other">Sonstiges</option>
                        </select>
                    </div>

                    <div style="margin-bottom:24px;">
                        <label for="contact_message" style="display:block;margin-bottom:8px;font-weight:600;">
                            Nachricht *
                        </label>
                        <textarea 
                            id="contact_message" 
                            name="contact_message" 
                            rows="6" 
                            required 
                            style="
                                width:100%;
                                padding:12px;
                                background:var(--bg);
                                border:1px solid var(--line);
                                border-radius:6px;
                                color:var(--fg);
                                font-size:1rem;
                                resize:vertical;
                            "
                        ></textarea>
                    </div>

                    <div style="margin-bottom:24px;">
                        <label style="display:flex;align-items:start;gap:8px;">
                            <input type="checkbox" name="contact_privacy" required style="margin-top:4px;">
                            <span style="color:var(--muted);font-size:0.9rem;">
                                Ich habe die <a href="/datenschutz/" style="color:var(--accent);">Datenschutzerklärung</a> zur Kenntnis genommen. *
                            </span>
                        </label>
                    </div>

                    <div id="contact-response" style="margin-bottom:16px;"></div>

                    <button type="submit" style="
                        width:100%;
                        padding:16px;
                        background:var(--accent);
                        color:#001018;
                        border:none;
                        border-radius:6px;
                        font-weight:700;
                        font-size:1.1rem;
                        cursor:pointer;
                        transition:filter 0.2s;
                    " onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter=''">
                        Nachricht senden
                    </button>
                </form>
            </div>

            <!-- Kontaktinformationen -->
            <aside class="contact-info">
                
                <!-- Kontaktdaten -->
                <div style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    padding:32px;
                    margin-bottom:24px;
                ">
                    <h3 style="margin:0 0 24px;font-size:1.5rem;">
                        Kontaktdaten
                    </h3>

                    <div style="display:flex;flex-direction:column;gap:20px;">
                        
                        <!-- E-Mail -->
                        <div style="display:flex;gap:16px;align-items:start;">
                            <div style="
                                width:40px;
                                height:40px;
                                background:var(--bg-3);
                                border:1px solid var(--line);
                                border-radius:6px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-size:1.2rem;
                                flex-shrink:0;
                            ">
                                ✉️
                            </div>
                            <div>
                                <div style="font-size:0.85rem;color:var(--muted);margin-bottom:4px;">E-Mail</div>
                                <a href="mailto:kontakt@beyond-gotham.org" style="color:var(--accent);font-weight:600;">
                                    kontakt@beyond-gotham.org
                                </a>
                            </div>
                        </div>

                        <!-- Telefon -->
                        <div style="display:flex;gap:16px;align-items:start;">
                            <div style="
                                width:40px;
                                height:40px;
                                background:var(--bg-3);
                                border:1px solid var(--line);
                                border-radius:6px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-size:1.2rem;
                                flex-shrink:0;
                            ">
                                📞
                            </div>
                            <div>
                                <div style="font-size:0.85rem;color:var(--muted);margin-bottom:4px;">Telefon</div>
                                <a href="tel:+493411234567" style="color:var(--accent);font-weight:600;">
                                    +49 (0) 341 123 456 7
                                </a>
                                <div style="font-size:0.85rem;color:var(--muted);margin-top:4px;">
                                    Mo-Fr: 9-17 Uhr
                                </div>
                            </div>
                        </div>

                        <!-- Adresse -->
                        <div style="display:flex;gap:16px;align-items:start;">
                            <div style="
                                width:40px;
                                height:40px;
                                background:var(--bg-3);
                                border:1px solid var(--line);
                                border-radius:6px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-size:1.2rem;
                                flex-shrink:0;
                            ">
                                📍
                            </div>
                            <div>
                                <div style="font-size:0.85rem;color:var(--muted);margin-bottom:4px;">Adresse</div>
                                <div style="color:var(--fg);line-height:1.6;">
                                    Beyond_Gotham gGmbH<br>
                                    Musterstraße 123<br>
                                    04107 Leipzig<br>
                                    Deutschland
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Spezielle Anfragen -->
                <div style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    padding:24px;
                    margin-bottom:24px;
                ">
                    <h4 style="margin:0 0 16px;font-size:1.2rem;">
                        Spezielle Anfragen
                    </h4>

                    <div style="display:flex;flex-direction:column;gap:12px;font-size:0.9rem;">
                        <div>
                            <strong style="color:var(--accent);">Presse:</strong><br>
                            <a href="mailto:presse@beyond-gotham.org" style="color:var(--fg);">presse@beyond-gotham.org</a>
                        </div>
                        <div>
                            <strong style="color:var(--accent);">Partnerschaften:</strong><br>
                            <a href="mailto:partner@beyond-gotham.org" style="color:var(--fg);">partner@beyond-gotham.org</a>
                        </div>
                        <div>
                            <strong style="color:var(--accent);">Kursanfragen:</strong><br>
                            <a href="mailto:kurse@beyond-gotham.org" style="color:var(--fg);">kurse@beyond-gotham.org</a>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div style="
                    background:var(--bg-2);
                    border:1px solid var(--line);
                    border-radius:12px;
                    padding:24px;
                ">
                    <h4 style="margin:0 0 16px;font-size:1.2rem;">
                        Folge uns
                    </h4>

                    <div style="display:flex;gap:12px;">
                        <a href="https://twitter.com/beyond_gotham" target="_blank" style="
                            width:44px;
                            height:44px;
                            background:var(--bg-3);
                            border:1px solid var(--line);
                            border-radius:6px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            color:var(--accent);
                            text-decoration:none;
                            font-size:1.2rem;
                        ">
                            𝕏
                        </a>
                        <a href="https://linkedin.com/company/beyond-gotham" target="_blank" style="
                            width:44px;
                            height:44px;
                            background:var(--bg-3);
                            border:1px solid var(--line);
                            border-radius:6px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            color:var(--accent);
                            text-decoration:none;
                            font-weight:700;
                        ">
                            in
                        </a>
                        <a href="https://github.com/beyond-gotham" target="_blank" style="
                            width:44px;
                            height:44px;
                            background:var(--bg-3);
                            border:1px solid var(--line);
                            border-radius:6px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            color:var(--accent);
                            text-decoration:none;
                        ">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </aside>

        </div>

        <!-- Weitere Kontaktmöglichkeiten -->
        <section class="additional-contact" style="
            background:var(--bg-2);
            border:1px solid var(--line);
            border-radius:12px;
            padding:48px;
            margin-bottom:80px;
        ">
            <h2 style="
                text-align:center;
                margin:0 0 48px;
                font-size:2rem;
            ">
                Weitere Möglichkeiten
            </h2>

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:32px;">
                
                <div style="text-align:center;">
                    <div style="font-size:3rem;margin-bottom:16px;">🎓</div>
                    <h3 style="margin:0 0 8px;font-size:1.3rem;">Kursberatung</h3>
                    <p style="margin:0 0 16px;color:var(--muted);">
                        Unsicher, welcher Kurs passt?
                    </p>
                    <a href="/kurse/" style="color:var(--accent);font-weight:600;">
                        Zur Kursübersicht →
                    </a>
                </div>

                <div style="text-align:center;">
                    <div style="font-size:3rem;margin-bottom:16px;">📝</div>
                    <h3 style="margin:0 0 8px;font-size:1.3rem;">Newsletter</h3>
                    <p style="margin:0 0 16px;color:var(--muted);">
                        Updates zu Kursen & Projekten
                    </p>
                    <a href="/newsletter/" style="color:var(--accent);font-weight:600;">
                        Jetzt anmelden →
                    </a>
                </div>

                <div style="text-align:center;">
                    <div style="font-size:3rem;margin-bottom:16px;">💼</div>
                    <h3 style="margin:0 0 8px;font-size:1.3rem;">Karriere</h3>
                    <p style="margin:0 0 16px;color:var(--muted);">
                        Werde Teil unseres Teams
                    </p>
                    <a href="/karriere/" style="color:var(--accent);font-weight:600;">
                        Offene Stellen →
                    </a>
                </div>

                <div style="text-align:center;">
                    <div style="font-size:3rem;margin-bottom:16px;">🤝</div>
                    <h3 style="margin:0 0 8px;font-size:1.3rem;">Partner werden</h3>
                    <p style="margin:0 0 16px;color:var(--muted);">
                        Gemeinsam mehr bewirken
                    </p>
                    <a href="mailto:partner@beyond-gotham.org" style="color:var(--accent);font-weight:600;">
                        Anfrage senden →
                    </a>
                </div>

            </div>
        </section>

    </div>

</main>

<script>
(function($) {
    $(document).ready(function() {
        $('#contact-form').on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var $btn = $form.find('button[type="submit"]');
            var $response = $('#contact-response');
            
            $btn.prop('disabled', true).text('Wird gesendet...');
            $response.html('');
            
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: $form.serialize() + '&action=bg_contact_form_submit',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $response.html('<div style="background:var(--bg-3);padding:12px;border-left:3px solid #4caf50;color:var(--fg);border-radius:6px;">' + response.data.message + '</div>');
                        $form[0].reset();
                    } else {
                        $response.html('<div style="background:var(--bg-3);padding:12px;border-left:3px solid #f44336;color:var(--fg);border-radius:6px;">' + response.data.message + '</div>');
                    }
                },
                error: function() {
                    $response.html('<div style="background:var(--bg-3);padding:12px;border-left:3px solid #f44336;color:var(--fg);border-radius:6px;">Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.</div>');
                },
                complete: function() {
                    $btn.prop('disabled', false).text('Nachricht senden');
                }
            });
        });
    });
})(jQuery);
</script>

<?php get_footer(); ?>
