<?php
/**
 * Template Name: Kontakt
 * Description: Kontaktformular und Kontaktinformationen
 */

get_header(); ?>

<main id="primary" class="site-main page-contact">
    <section class="contact-hero">
        <div class="bg-container">
            <p class="contact-hero__eyebrow"><?php esc_html_e('Direkter Draht zur Beyond-Gotham Redaktion', 'beyondgotham-dark-child'); ?></p>
            <h1 class="contact-hero__title"><?php the_title(); ?></h1>
            <p class="contact-hero__lead">
                <?php
                $excerpt = get_the_excerpt();
                if ($excerpt) {
                    echo esc_html($excerpt);
                } else {
                    esc_html_e('Wir freuen uns auf Ihre Nachricht – ob für Kursanfragen, Partnerschaften oder Presseanfragen.', 'beyondgotham-dark-child');
                }
                ?>
            </p>
        </div>
    </section>

    <div class="bg-container">
        <div class="contact-layout">
            <div class="contact-form-section">
                <h2 class="contact-section-title"><?php esc_html_e('Nachricht senden', 'beyondgotham-dark-child'); ?></h2>

                <form id="contact-form" class="contact-form" method="post" action="">
                    <?php wp_nonce_field('bg_contact_form', 'bg_contact_nonce'); ?>

                    <div class="contact-field">
                        <label class="contact-label" for="contact_name"><?php esc_html_e('Name *', 'beyondgotham-dark-child'); ?></label>
                        <input class="contact-input" type="text" id="contact_name" name="contact_name" required>
                    </div>

                    <div class="contact-field">
                        <label class="contact-label" for="contact_email"><?php esc_html_e('E-Mail *', 'beyondgotham-dark-child'); ?></label>
                        <input class="contact-input" type="email" id="contact_email" name="contact_email" required>
                    </div>

                    <div class="contact-field">
                        <label class="contact-label" for="contact_subject"><?php esc_html_e('Betreff', 'beyondgotham-dark-child'); ?></label>
                        <select class="contact-select" id="contact_subject" name="contact_subject">
                            <option value="general"><?php esc_html_e('Allgemeine Anfrage', 'beyondgotham-dark-child'); ?></option>
                            <option value="courses"><?php esc_html_e('Kursanfrage', 'beyondgotham-dark-child'); ?></option>
                            <option value="partnership"><?php esc_html_e('Partnerschaft', 'beyondgotham-dark-child'); ?></option>
                            <option value="press"><?php esc_html_e('Presseanfrage', 'beyondgotham-dark-child'); ?></option>
                            <option value="donation"><?php esc_html_e('Spende / Förderung', 'beyondgotham-dark-child'); ?></option>
                            <option value="other"><?php esc_html_e('Sonstiges', 'beyondgotham-dark-child'); ?></option>
                        </select>
                    </div>

                    <div class="contact-field">
                        <label class="contact-label" for="contact_message"><?php esc_html_e('Nachricht *', 'beyondgotham-dark-child'); ?></label>
                        <textarea class="contact-textarea" id="contact_message" name="contact_message" rows="6" required></textarea>
                    </div>

                    <div class="contact-field contact-field--checkbox">
                        <label class="contact-checkbox">
                            <input class="contact-checkbox__input" type="checkbox" name="contact_privacy" required>
                            <span class="contact-checkbox__text">
                                <?php
                                printf(
                                    /* translators: %s: URL to privacy policy */
                                    esc_html__('Ich habe die %s zur Kenntnis genommen. *', 'beyondgotham-dark-child'),
                                    '<a href="' . esc_url(home_url('/datenschutz/')) . '" class="contact-link">' . esc_html__('Datenschutzerklärung', 'beyondgotham-dark-child') . '</a>'
                                );
                                ?>
                            </span>
                        </label>
                    </div>

                    <div id="contact-response" class="contact-response" aria-live="polite"></div>

                    <button type="submit" class="contact-submit">
                        <?php esc_html_e('Nachricht senden', 'beyondgotham-dark-child'); ?>
                    </button>
                </form>
            </div>

            <aside class="contact-info" aria-label="Beyond-Gotham Kontaktdaten">
                <div class="contact-card">
                    <h3 class="contact-card__title"><?php esc_html_e('Kontaktdaten', 'beyondgotham-dark-child'); ?></h3>
                    <div class="contact-card__list">
                        <div class="contact-card__item">
                            <div class="contact-card__icon" aria-hidden="true">✉️</div>
                            <div>
                                <p class="contact-card__label"><?php esc_html_e('E-Mail', 'beyondgotham-dark-child'); ?></p>
                                <a class="contact-link" href="mailto:kontakt@beyond-gotham.org">kontakt@beyond-gotham.org</a>
                            </div>
                        </div>
                        <div class="contact-card__item">
                            <div class="contact-card__icon" aria-hidden="true">📞</div>
                            <div>
                                <p class="contact-card__label"><?php esc_html_e('Telefon', 'beyondgotham-dark-child'); ?></p>
                                <a class="contact-link" href="tel:+49301234567">+49 (0)30 123 45 67</a>
                            </div>
                        </div>
                        <div class="contact-card__item">
                            <div class="contact-card__icon" aria-hidden="true">📍</div>
                            <div>
                                <p class="contact-card__label"><?php esc_html_e('Büro', 'beyondgotham-dark-child'); ?></p>
                                <address class="contact-card__address">
                                    Beyond-Gotham gGmbH<br>
                                    Media Lab Berlin<br>
                                    Köpenicker Str. 40, 10179 Berlin
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-card">
                    <h3 class="contact-card__title"><?php esc_html_e('Direkte Ansprechpartner:innen', 'beyondgotham-dark-child'); ?></h3>
                    <div class="contact-card__list contact-card__list--grid">
                        <div>
                            <p class="contact-card__label">Investigativ-Team</p>
                            <a class="contact-link" href="mailto:investigativ@beyond-gotham.org">investigativ@beyond-gotham.org</a>
                        </div>
                        <div>
                            <p class="contact-card__label">Partnerschaften</p>
                            <a class="contact-link" href="mailto:partner@beyond-gotham.org">partner@beyond-gotham.org</a>
                        </div>
                        <div>
                            <p class="contact-card__label">Presse</p>
                            <a class="contact-link" href="mailto:presse@beyond-gotham.org">presse@beyond-gotham.org</a>
                        </div>
                        <div>
                            <p class="contact-card__label">Kursberatung</p>
                            <a class="contact-link" href="mailto:kurse@beyond-gotham.org">kurse@beyond-gotham.org</a>
                        </div>
                    </div>
                </div>

                <div class="contact-card contact-card--accent">
                    <h3 class="contact-card__title"><?php esc_html_e('Antwortzeiten', 'beyondgotham-dark-child'); ?></h3>
                    <p class="contact-card__text"><?php esc_html_e('Wir melden uns in der Regel innerhalb von 24 Stunden bei Ihnen.', 'beyondgotham-dark-child'); ?></p>
                    <p class="contact-card__text"><?php esc_html_e('Für dringende Presseanfragen nutzen Sie bitte den Betreff „Presse“.', 'beyondgotham-dark-child'); ?></p>
                </div>
            </aside>
        </div>

        <section class="additional-contact" aria-label="Weitere Kontaktmöglichkeiten">
            <h2 class="contact-section-title contact-section-title--center"><?php esc_html_e('Weitere Möglichkeiten', 'beyondgotham-dark-child'); ?></h2>
            <div class="additional-contact__grid">
                <div class="additional-contact__item">
                    <div class="additional-contact__icon" aria-hidden="true">🎓</div>
                    <h3 class="additional-contact__title"><?php esc_html_e('Kursberatung', 'beyondgotham-dark-child'); ?></h3>
                    <p class="additional-contact__text"><?php esc_html_e('Unsicher, welcher Kurs passt? Wir beraten Sie gerne persönlich.', 'beyondgotham-dark-child'); ?></p>
                    <a class="contact-link" href="<?php echo esc_url(home_url('/kurse/')); ?>"><?php esc_html_e('Zur Kursübersicht →', 'beyondgotham-dark-child'); ?></a>
                </div>
                <div class="additional-contact__item">
                    <div class="additional-contact__icon" aria-hidden="true">📝</div>
                    <h3 class="additional-contact__title"><?php esc_html_e('Newsletter', 'beyondgotham-dark-child'); ?></h3>
                    <p class="additional-contact__text"><?php esc_html_e('Updates zu Kursen & Projekten direkt in Ihr Postfach.', 'beyondgotham-dark-child'); ?></p>
                    <a class="contact-link" href="<?php echo esc_url(home_url('/newsletter/')); ?>"><?php esc_html_e('Jetzt anmelden →', 'beyondgotham-dark-child'); ?></a>
                </div>
                <div class="additional-contact__item">
                    <div class="additional-contact__icon" aria-hidden="true">💼</div>
                    <h3 class="additional-contact__title"><?php esc_html_e('Karriere', 'beyondgotham-dark-child'); ?></h3>
                    <p class="additional-contact__text"><?php esc_html_e('Werde Teil unseres Teams und gestalte investigative Projekte.', 'beyondgotham-dark-child'); ?></p>
                    <a class="contact-link" href="<?php echo esc_url(home_url('/karriere/')); ?>"><?php esc_html_e('Offene Stellen →', 'beyondgotham-dark-child'); ?></a>
                </div>
                <div class="additional-contact__item">
                    <div class="additional-contact__icon" aria-hidden="true">🤝</div>
                    <h3 class="additional-contact__title"><?php esc_html_e('Partner werden', 'beyondgotham-dark-child'); ?></h3>
                    <p class="additional-contact__text"><?php esc_html_e('Gemeinsam mehr bewirken – wir freuen uns auf Ihre Idee.', 'beyondgotham-dark-child'); ?></p>
                    <a class="contact-link" href="mailto:partner@beyond-gotham.org"><?php esc_html_e('Anfrage senden →', 'beyondgotham-dark-child'); ?></a>
                </div>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>
