<?php
/**
 * Template Name: Landing Page
 * Description: Conversion-optimierte Landing Page.
 *
 * @package BeyondGothamDarkChild
 */

defined('ABSPATH') || exit;

get_header();
?>

<main class="landing" id="primary">
    <section class="landing-hero" aria-labelledby="landing-hero-title">
        <div class="landing-hero__grid">
            <div class="landing-hero__content" data-bg-animate>
                <span class="landing-hero__eyebrow"><?php esc_html_e('AZAV-zertifizierte Weiterbildung', 'beyondgotham-dark-child'); ?></span>
                <h1 class="landing-hero__title" id="landing-hero-title">
                    <?php esc_html_e('Investigativer Journalismus neu gedacht', 'beyondgotham-dark-child'); ?>
                </h1>
                <p class="landing-hero__lead">
                    <?php esc_html_e('Beyond Gotham verbindet OSINT, Datenanalyse und Einsatztraining zu einem praxisorientierten Curriculum für moderne Recherchenteams.', 'beyondgotham-dark-child'); ?>
                </p>
                <div class="landing-hero__actions">
                    <a class="bg-button bg-button--primary" href="<?php echo esc_url(home_url('/kurse/')); ?>">
                        <?php esc_html_e('Kurse entdecken', 'beyondgotham-dark-child'); ?>
                    </a>
                    <a class="bg-button bg-button--ghost" data-bg-scroll="#landing-newsletter" href="#landing-newsletter">
                        <?php esc_html_e('Newsletter abonnieren', 'beyondgotham-dark-child'); ?>
                    </a>
                </div>
                <dl class="landing-hero__stats">
                    <div>
                        <dt><?php esc_html_e('Absolvent:innen', 'beyondgotham-dark-child'); ?></dt>
                        <dd>500+</dd>
                    </div>
                    <div>
                        <dt><?php esc_html_e('Zufriedenheit', 'beyondgotham-dark-child'); ?></dt>
                        <dd>95%</dd>
                    </div>
                    <div>
                        <dt><?php esc_html_e('Partnerorganisationen', 'beyondgotham-dark-child'); ?></dt>
                        <dd>12+</dd>
                    </div>
                </dl>
            </div>
            <div class="landing-hero__media" aria-hidden="true" data-bg-animate>
                <div class="landing-hero__media-frame">
                    <div class="landing-hero__media-gradient"></div>
                    <div class="landing-hero__media-terminal">
                        <span class="landing-hero__prompt">$ launch beyond-gotham --preset osint</span>
                        <span class="landing-hero__line landing-hero__line--accent">✓ Graph engine ready</span>
                        <span class="landing-hero__line landing-hero__line--accent">✓ Verification layer active</span>
                        <span class="landing-hero__line landing-hero__line--accent">✓ Field training module synced</span>
                        <span class="landing-hero__cursor" aria-hidden="true">_</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-section" id="landing-features">
        <div class="bg-section__header" data-bg-animate>
            <h2 class="bg-section__title"><?php esc_html_e('Warum Beyond Gotham?', 'beyondgotham-dark-child'); ?></h2>
            <p class="bg-section__subtitle"><?php esc_html_e('Wir kombinieren investigatives Handwerk mit Technologie und Safety-Training.', 'beyondgotham-dark-child'); ?></p>
        </div>
        <div class="features-grid">
            <?php
            $features = [
                [
                    'title' => __('OSINT Deep Dives', 'beyondgotham-dark-child'),
                    'text'  => __('Strukturierte Recherche-Playbooks, Analysen und Open-Source-Verifikation für komplexe Lagen.', 'beyondgotham-dark-child'),
                ],
                [
                    'title' => __('Datenjournalismus', 'beyondgotham-dark-child'),
                    'text'  => __('Lerne, aus Daten Geschichten zu formen: Scraping, Cleaning und Storytelling mit evidenzbasierten Insights.', 'beyondgotham-dark-child'),
                ],
                [
                    'title' => __('Humanitäre Ersthilfe', 'beyondgotham-dark-child'),
                    'text'  => __('Tactical Casualty Care, Stress-Szenarien und Resilienztraining für Einsätze in Krisenregionen.', 'beyondgotham-dark-child'),
                ],
                [
                    'title' => __('Mentor:innen aus der Praxis', 'beyondgotham-dark-child'),
                    'text'  => __('Investigative Journalist:innen, Analyst:innen und Einsatzkräfte begleiten jede Kohorte persönlich.', 'beyondgotham-dark-child'),
                ],
                [
                    'title' => __('Remote & Onsite', 'beyondgotham-dark-child'),
                    'text'  => __('Hybride Lernformate: Live-Online-Sessions, Field Labs vor Ort und Simulationen in unserem Trainingshub.', 'beyondgotham-dark-child'),
                ],
                [
                    'title' => __('Förderfähig via Bildungsgutschein', 'beyondgotham-dark-child'),
                    'text'  => __('AZAV-zertifiziert mit voll digitalem Anmeldeprozess inklusive Upload von Voucher-Dokumenten.', 'beyondgotham-dark-child'),
                ],
            ];

            foreach ($features as $feature) :
                ?>
                <article class="feature-card" data-bg-animate>
                    <h3 class="feature-card__title"><?php echo esc_html($feature['title']); ?></h3>
                    <p class="feature-card__text"><?php echo esc_html($feature['text']); ?></p>
                </article>
                <?php
            endforeach;
            ?>
        </div>
    </section>

    <section class="bg-section bg-section--split" id="landing-testimonials">
        <div class="bg-section__header" data-bg-animate>
            <h2 class="bg-section__title"><?php esc_html_e('Stimmen unserer Alumni', 'beyondgotham-dark-child'); ?></h2>
            <p class="bg-section__subtitle"><?php esc_html_e('Ergebnisse, die in Newsrooms und Einsatzteams Wirkung zeigen.', 'beyondgotham-dark-child'); ?></p>
        </div>
        <div class="testimonials">
            <?php
            $testimonials = [
                [
                    'name'    => __('Jasmin K., Investigativreporterin', 'beyondgotham-dark-child'),
                    'quote'   => __('„Die OSINT-Methodik von Beyond Gotham hat meine Recherchearbeit auf ein neues Niveau gehoben. Unsere Redaktion konnte dank der Trainings zwei große Datenlecks aufdecken.“', 'beyondgotham-dark-child'),
                ],
                [
                    'name'    => __('Daniel F., Einsatzleiter NGO', 'beyondgotham-dark-child'),
                    'quote'   => __('„Die Kombination aus Sicherheitsbriefings und Datenanalyse ist einzigartig. Unser Team fühlt sich erstmals wirklich vorbereitet auf Kriseneinsätze.“', 'beyondgotham-dark-child'),
                ],
                [
                    'name'    => __('Lea S., Datenjournalistin', 'beyondgotham-dark-child'),
                    'quote'   => __('„Vom ersten Tag an praxisnah – wir haben echte Fälle aufgearbeitet und Tools integriert, die wir jetzt täglich einsetzen.“', 'beyondgotham-dark-child'),
                ],
            ];

            foreach ($testimonials as $testimonial) :
                ?>
                <figure class="testimonial" data-bg-animate>
                    <blockquote class="testimonial__quote"><?php echo esc_html($testimonial['quote']); ?></blockquote>
                    <figcaption class="testimonial__author"><?php echo esc_html($testimonial['name']); ?></figcaption>
                </figure>
                <?php
            endforeach;
            ?>
        </div>
    </section>

    <section class="bg-section bg-section--accent" id="landing-cta">
        <div class="cta" data-bg-animate>
            <h2 class="cta__title"><?php esc_html_e('Bereit für die nächste Kohorte?', 'beyondgotham-dark-child'); ?></h2>
            <p class="cta__lead"><?php esc_html_e('Sichere dir deinen Platz und kombiniere journalistisches Handwerk mit taktischer Einsatzkompetenz.', 'beyondgotham-dark-child'); ?></p>
            <a class="bg-button bg-button--primary" href="<?php echo esc_url(home_url('/kurse/')); ?>"><?php esc_html_e('Alle Kurse ansehen', 'beyondgotham-dark-child'); ?></a>
        </div>
    </section>

    <section class="bg-section bg-section--newsletter" id="landing-newsletter">
        <div class="newsletter" data-bg-animate>
            <div class="newsletter__content">
                <h2 class="newsletter__title"><?php esc_html_e('Newsletter & Einsatzbriefing', 'beyondgotham-dark-child'); ?></h2>
                <p class="newsletter__text"><?php esc_html_e('Monatliches Briefing mit Kursupdates, Einsatzreports und exklusiven Ressourcen. Jederzeit kündbar.', 'beyondgotham-dark-child'); ?></p>
            </div>
            <form class="newsletter__form" action="<?php echo esc_url(home_url('/')); ?>" method="post">
                <label class="screen-reader-text" for="newsletter-email"><?php esc_html_e('E-Mail Adresse', 'beyondgotham-dark-child'); ?></label>
                <input class="newsletter__input" type="email" id="newsletter-email" name="newsletter_email" placeholder="<?php esc_attr_e('Ihre E-Mail-Adresse', 'beyondgotham-dark-child'); ?>" required>
                <button class="bg-button bg-button--primary" type="submit"><?php esc_html_e('Anmelden', 'beyondgotham-dark-child'); ?></button>
                <p class="newsletter__legal"><?php esc_html_e('Mit Klick auf „Anmelden“ stimmen Sie dem Erhalt des Newsletters laut Datenschutzerklärung zu.', 'beyondgotham-dark-child'); ?></p>
            </form>
        </div>
    </section>
</main>

<?php
get_footer();
