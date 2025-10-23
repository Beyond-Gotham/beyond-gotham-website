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

<main class="landing" id="main">
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

    <section class="landing-social" aria-labelledby="landing-social-title">
        <div class="landing-social__inner" data-bg-animate>
            <div class="landing-social__header">
                <h2 class="landing-social__title" id="landing-social-title"><?php esc_html_e('Stay Connected', 'beyondgotham-dark-child'); ?></h2>
                <p class="landing-social__intro"><?php esc_html_e('Folgen Sie unseren Einsatz- und Recherche-Updates auf allen Kanälen.', 'beyondgotham-dark-child'); ?></p>
            </div>
            <?php if (has_nav_menu('menu-2')) : ?>
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu-2',
                    'menu_class'     => 'landing-social__menu',
                    'container'      => false,
                    'depth'          => 1,
                ]);
                ?>
            <?php else : ?>
                <p class="landing-social__notice"><?php esc_html_e('Füge deine Social Links im Menü-Manager hinzu, um sie hier anzuzeigen.', 'beyondgotham-dark-child'); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <?php
    $landing_sections = [
        [
            'title' => __('Latest Sports News', 'beyondgotham-dark-child'),
            'slug'  => 'sport',
        ],
        [
            'title' => __('Local News', 'beyondgotham-dark-child'),
            'slug'  => 'reportagen',
        ],
        [
            'title'    => __('Arts & Culture', 'beyondgotham-dark-child'),
            'slug'     => 'interviews',
            'fallback' => 'dossiers',
        ],
    ];

    foreach ($landing_sections as $section) :
        $category_slug = $section['slug'];
        $category      = get_category_by_slug($category_slug);
        $query_args    = [
            'post_type'           => 'post',
            'posts_per_page'      => 6,
            'ignore_sticky_posts' => true,
            'category_name'       => $category_slug,
        ];

        $query = new WP_Query($query_args);

        if (!$query->have_posts() && !empty($section['fallback'])) {
            wp_reset_postdata();
            $category_slug = $section['fallback'];
            $category      = get_category_by_slug($category_slug);
            $query_args['category_name'] = $category_slug;
            $query = new WP_Query($query_args);
        }

        if (!$query->have_posts()) {
            continue;
        }

        $has_carousel = $query->post_count > 4;
        $archive_url  = $category instanceof WP_Term ? get_category_link($category) : get_post_type_archive_link('post');
        ?>
        <section class="landing-feed" aria-label="<?php echo esc_attr($section['title']); ?>">
            <div class="landing-feed__header" data-bg-animate>
                <h2 class="landing-feed__title"><?php echo esc_html($section['title']); ?></h2>
                <a class="landing-feed__more" href="<?php echo esc_url($archive_url); ?>">
                    <?php esc_html_e('Mehr', 'beyondgotham-dark-child'); ?>
                </a>
            </div>
            <div class="landing-feed__content<?php echo $has_carousel ? ' landing-feed__content--carousel' : ''; ?>"<?php echo $has_carousel ? ' data-bg-carousel' : ''; ?>>
                <div class="bg-grid<?php echo $has_carousel ? ' bg-grid--carousel' : ''; ?>"<?php echo $has_carousel ? ' data-bg-carousel-track' : ''; ?>>
                    <?php
                    while ($query->have_posts()) :
                        $query->the_post();
                        $post_id   = get_the_ID();
                        $permalink = get_permalink();
                        $badge     = '';

                        if ($category instanceof WP_Term) {
                            $badge = $category->name;
                        } else {
                            $post_categories = get_the_category();
                            if (!empty($post_categories)) {
                                $badge = $post_categories[0]->name;
                            }
                        }
                        ?>
                        <article class="bg-card" data-bg-animate>
                            <a class="bg-card__media" href="<?php echo esc_url($permalink); ?>">
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('bg-card', ['class' => 'bg-card__image']);
                                } else {
                                    echo '<span class="bg-card__placeholder" aria-hidden="true"></span>';
                                }
                                ?>
                            </a>
                            <div class="bg-card__body">
                                <?php if ($badge) : ?>
                                    <span class="bg-card__badge"><?php echo esc_html($badge); ?></span>
                                <?php endif; ?>
                                <h3 class="bg-card__title">
                                    <a href="<?php echo esc_url($permalink); ?>"><?php the_title(); ?></a>
                                </h3>
                                <div class="bg-card__meta">
                                    <time class="bg-card__meta-item" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo esc_html(get_the_date('d.m.Y')); ?>
                                    </time>
                                    <?php $reading_time = bg_get_reading_time($post_id); ?>
                                    <?php if ($reading_time) : ?>
                                        <span class="bg-card__meta-item"><?php echo esc_html($reading_time); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    ?>
                </div>
                <?php if ($has_carousel) : ?>
                    <div class="bg-carousel__controls" aria-hidden="false">
                        <button class="bg-carousel__button" type="button" data-bg-carousel-prev aria-label="<?php esc_attr_e('Vorherige Beiträge', 'beyondgotham-dark-child'); ?>">
                            <span aria-hidden="true">&#8592;</span>
                        </button>
                        <button class="bg-carousel__button" type="button" data-bg-carousel-next aria-label="<?php esc_attr_e('Nächste Beiträge', 'beyondgotham-dark-child'); ?>">
                            <span aria-hidden="true">&#8594;</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
        wp_reset_postdata();
    endforeach;
    ?>

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
