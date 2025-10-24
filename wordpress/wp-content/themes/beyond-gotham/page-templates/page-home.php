<?php
/*
 * Template Name: Landingpage
 */

defined( 'ABSPATH' ) || exit;

global $post;

if ( ! function_exists( 'beyond_gotham_landing_reading_time' ) ) {
    /**
     * Estimate reading time for a given post.
     *
     * @param int|WP_Post|null $post_id Optional post reference.
     * @return string
     */
    function beyond_gotham_landing_reading_time( $post_id = null ) {
        $content = get_post_field( 'post_content', $post_id );
        $word_count = $content ? str_word_count( wp_strip_all_tags( $content ) ) : 0;

        if ( $word_count <= 0 ) {
            return '';
        }

        $minutes = max( 1, (int) ceil( $word_count / 200 ) );

        return sprintf(
            _n( '%d Minute Lesezeit', '%d Minuten Lesezeit', $minutes, 'beyond_gotham' ),
            $minutes
        );
    }
}

get_header();
?>

<main id="primary" class="site-main landing">
    <section class="landing-hero" aria-labelledby="landing-hero-title">
        <div class="landing-hero__grid">
            <div class="landing-hero__content" data-bg-animate>
                <span class="landing-hero__eyebrow"><?php esc_html_e( 'AZAV-zertifizierte Weiterbildung', 'beyond_gotham' ); ?></span>
                <h1 class="landing-hero__title" id="landing-hero-title">
                    <?php esc_html_e( 'Investigativer Journalismus neu gedacht', 'beyond_gotham' ); ?>
                </h1>
                <p class="landing-hero__lead">
                    <?php esc_html_e( 'Beyond Gotham verbindet OSINT, Datenanalyse und Einsatztraining zu einem praxisorientierten Curriculum für moderne Recherchenteams.', 'beyond_gotham' ); ?>
                </p>
                <div class="landing-hero__actions">
                    <a class="bg-button bg-button--primary" href="<?php echo esc_url( home_url( '/kurse/' ) ); ?>">
                        <?php esc_html_e( 'Kurse entdecken', 'beyond_gotham' ); ?>
                    </a>
                    <a class="bg-button bg-button--ghost" data-bg-scroll="#landing-newsletter" href="#landing-newsletter">
                        <?php esc_html_e( 'Newsletter abonnieren', 'beyond_gotham' ); ?>
                    </a>
                </div>
                <dl class="landing-hero__stats">
                    <div>
                        <dt><?php esc_html_e( 'Absolvent:innen', 'beyond_gotham' ); ?></dt>
                        <dd>500+</dd>
                    </div>
                    <div>
                        <dt><?php esc_html_e( 'Zufriedenheit', 'beyond_gotham' ); ?></dt>
                        <dd>95%</dd>
                    </div>
                    <div>
                        <dt><?php esc_html_e( 'Partnerorganisationen', 'beyond_gotham' ); ?></dt>
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
                <h2 class="landing-social__title" id="landing-social-title"><?php esc_html_e( 'Stay Connected', 'beyond_gotham' ); ?></h2>
                <p class="landing-social__intro"><?php esc_html_e( 'Folgen Sie unseren Einsatz- und Recherche-Updates auf allen Kanälen.', 'beyond_gotham' ); ?></p>
            </div>
            <?php if ( has_nav_menu( 'menu-2' ) ) : ?>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'menu-2',
                        'menu_class'     => 'landing-social__menu',
                        'container'      => false,
                        'depth'          => 1,
                    )
                );
                ?>
            <?php else : ?>
                <p class="landing-social__notice"><?php esc_html_e( 'Füge deine Social Links im Menü-Manager hinzu, um sie hier anzuzeigen.', 'beyond_gotham' ); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <?php
    $landing_sections = array(
        array(
            'title' => __( 'Latest Sports News', 'beyond_gotham' ),
            'slug'  => 'sport',
        ),
        array(
            'title' => __( 'Local News', 'beyond_gotham' ),
            'slug'  => 'reportagen',
        ),
        array(
            'title'    => __( 'Arts & Culture', 'beyond_gotham' ),
            'slug'     => 'interviews',
            'fallback' => 'dossiers',
        ),
    );

    foreach ( $landing_sections as $section ) :
        $category_slug = $section['slug'];
        $category      = get_category_by_slug( $category_slug );
        $query_args    = array(
            'post_type'           => 'post',
            'posts_per_page'      => 6,
            'ignore_sticky_posts' => true,
            'category_name'       => $category_slug,
        );

        $query = new WP_Query( $query_args );

        if ( ! $query->have_posts() && ! empty( $section['fallback'] ) ) {
            wp_reset_postdata();
            $category_slug             = $section['fallback'];
            $category                  = get_category_by_slug( $category_slug );
            $query_args['category_name'] = $category_slug;
            $query                     = new WP_Query( $query_args );
        }

        if ( ! $query->have_posts() ) {
            continue;
        }

        $has_carousel = $query->post_count > 4;
        $archive_url  = $category instanceof WP_Term ? get_category_link( $category ) : get_post_type_archive_link( 'post' );
        ?>
        <section class="landing-feed" aria-label="<?php echo esc_attr( $section['title'] ); ?>">
            <div class="landing-feed__header" data-bg-animate>
                <h2 class="landing-feed__title"><?php echo esc_html( $section['title'] ); ?></h2>
                <a class="landing-feed__more" href="<?php echo esc_url( $archive_url ); ?>">
                    <?php esc_html_e( 'Mehr', 'beyond_gotham' ); ?>
                </a>
            </div>
            <div class="landing-feed__content<?php echo $has_carousel ? ' landing-feed__content--carousel' : ''; ?>"<?php echo $has_carousel ? ' data-bg-carousel' : ''; ?>>
                <div class="bg-grid<?php echo $has_carousel ? ' bg-grid--carousel' : ''; ?>"<?php echo $has_carousel ? ' data-bg-carousel-track' : ''; ?>>
                    <?php
                    while ( $query->have_posts() ) :
                        $query->the_post();
                        $post_id   = get_the_ID();
                        $permalink = get_permalink();
                        $badge     = '';

                        if ( $category instanceof WP_Term ) {
                            $badge = $category->name;
                        } else {
                            $post_categories = get_the_category();
                            if ( ! empty( $post_categories ) ) {
                                $badge = $post_categories[0]->name;
                            }
                        }
                        ?>
                        <article class="bg-card" data-bg-animate>
                            <a class="bg-card__media" href="<?php echo esc_url( $permalink ); ?>" data-bg-skeleton>
                                <?php
                                $thumbnail_id = get_post_thumbnail_id();
                                if ( $thumbnail_id ) {
                                    echo wp_get_attachment_image(
                                        $thumbnail_id,
                                        'bg-card',
                                        false,
                                        array(
                                            'class'         => 'bg-card__image',
                                            'loading'       => 'lazy',
                                            'decoding'      => 'async',
                                            'sizes'         => '(min-width: 960px) 320px, (min-width: 600px) 50vw, 100vw',
                                            'fetchpriority' => 'auto',
                                        )
                                    );
                                } else {
                                    echo '<span class="bg-card__placeholder" aria-hidden="true"></span>';
                                }
                                ?>
                            </a>
                            <div class="bg-card__body">
                                <?php if ( $badge ) : ?>
                                    <span class="bg-card__badge"><?php echo esc_html( $badge ); ?></span>
                                <?php endif; ?>
                                <h3 class="bg-card__title">
                                    <a href="<?php echo esc_url( $permalink ); ?>"><?php the_title(); ?></a>
                                </h3>
                                <div class="bg-card__meta">
                                    <time class="bg-card__meta-item" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                        <?php echo esc_html( get_the_date( 'd.m.Y' ) ); ?>
                                    </time>
                                    <?php $reading_time = beyond_gotham_landing_reading_time( $post_id ); ?>
                                    <?php if ( $reading_time ) : ?>
                                        <span class="bg-card__meta-item"><?php echo esc_html( $reading_time ); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    ?>
                </div>
                <?php if ( $has_carousel ) : ?>
                    <div class="bg-carousel__controls" aria-hidden="false">
                        <button class="bg-carousel__button" type="button" data-bg-carousel-prev aria-label="<?php esc_attr_e( 'Vorherige Beiträge', 'beyond_gotham' ); ?>">
                            <span aria-hidden="true">&#8592;</span>
                        </button>
                        <button class="bg-carousel__button" type="button" data-bg-carousel-next aria-label="<?php esc_attr_e( 'Nächste Beiträge', 'beyond_gotham' ); ?>">
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
            <h2 class="bg-section__title"><?php esc_html_e( 'Warum Beyond Gotham?', 'beyond_gotham' ); ?></h2>
            <p class="bg-section__subtitle"><?php esc_html_e( 'Wir kombinieren investigatives Handwerk mit Technologie und Safety-Training.', 'beyond_gotham' ); ?></p>
        </div>
        <div class="features-grid">
            <?php
            $features = array(
                array(
                    'title' => __( 'OSINT Deep Dives', 'beyond_gotham' ),
                    'text'  => __( 'Strukturierte Recherche-Playbooks, Analysen und Open-Source-Verifikation für komplexe Lagen.', 'beyond_gotham' ),
                ),
                array(
                    'title' => __( 'Datenjournalismus', 'beyond_gotham' ),
                    'text'  => __( 'Lerne, aus Daten Geschichten zu formen: Scraping, Cleaning und Storytelling mit evidenzbasierten Insights.', 'beyond_gotham' ),
                ),
                array(
                    'title' => __( 'Humanitäre Ersthilfe', 'beyond_gotham' ),
                    'text'  => __( 'Tactical Casualty Care, Stress-Szenarien und Resilienztraining für Einsätze in Krisenregionen.', 'beyond_gotham' ),
                ),
                array(
                    'title' => __( 'Mentor:innen aus der Praxis', 'beyond_gotham' ),
                    'text'  => __( 'Investigative Journalist:innen, Analyst:innen und Einsatzkräfte begleiten jede Kohorte persönlich.', 'beyond_gotham' ),
                ),
                array(
                    'title' => __( 'Remote & Onsite', 'beyond_gotham' ),
                    'text'  => __( 'Hybride Lernformate: Live-Online-Sessions, Field Labs vor Ort und Simulationen in unserem Trainingshub.', 'beyond_gotham' ),
                ),
                array(
                    'title' => __( 'Förderfähig via Bildungsgutschein', 'beyond_gotham' ),
                    'text'  => __( 'AZAV-zertifiziert mit voll digitalem Anmeldeprozess inklusive Upload von Voucher-Dokumenten.', 'beyond_gotham' ),
                ),
            );

            foreach ( $features as $feature ) :
                ?>
                <article class="feature-card" data-bg-animate>
                    <h3 class="feature-card__title"><?php echo esc_html( $feature['title'] ); ?></h3>
                    <p class="feature-card__text"><?php echo esc_html( $feature['text'] ); ?></p>
                </article>
                <?php
            endforeach;
            ?>
        </div>
    </section>

    <section class="bg-section bg-section--split" id="landing-testimonials">
        <div class="bg-section__header" data-bg-animate>
            <h2 class="bg-section__title"><?php esc_html_e( 'Stimmen unserer Alumni', 'beyond_gotham' ); ?></h2>
            <p class="bg-section__subtitle"><?php esc_html_e( 'Ergebnisse, die in Newsrooms und Einsatzteams Wirkung zeigen.', 'beyond_gotham' ); ?></p>
        </div>
        <div class="testimonials">
            <?php
            $testimonials = array(
                array(
                    'name'  => __( 'Jasmin K., Investigativreporterin', 'beyond_gotham' ),
                    'quote' => __( '„Die OSINT-Methodik von Beyond Gotham hat meine Recherchearbeit auf ein neues Niveau gehoben. Unsere Redaktion konnte dank der Trainings zwei große Datenlecks aufdecken.“', 'beyond_gotham' ),
                ),
                array(
                    'name'  => __( 'Daniel F., Einsatzleiter NGO', 'beyond_gotham' ),
                    'quote' => __( '„Die Kombination aus Sicherheitsbriefings und Datenanalyse ist einzigartig. Unser Team fühlt sich erstmals wirklich vorbereitet auf Kriseneinsätze.“', 'beyond_gotham' ),
                ),
                array(
                    'name'  => __( 'Lea S., Datenjournalistin', 'beyond_gotham' ),
                    'quote' => __( '„Vom ersten Tag an praxisnah – wir haben echte Fälle aufgearbeitet und Tools integriert, die wir jetzt täglich einsetzen.“', 'beyond_gotham' ),
                ),
            );

            foreach ( $testimonials as $testimonial ) :
                ?>
                <figure class="testimonial" data-bg-animate>
                    <blockquote class="testimonial__quote"><?php echo esc_html( $testimonial['quote'] ); ?></blockquote>
                    <figcaption class="testimonial__author"><?php echo esc_html( $testimonial['name'] ); ?></figcaption>
                </figure>
                <?php
            endforeach;
            ?>
        </div>
    </section>

    <?php
    $cta_layout_settings = function_exists( 'beyond_gotham_get_cta_layout_settings' ) ? beyond_gotham_get_cta_layout_settings() : array();
    $cta_layout_classes  = isset( $cta_layout_settings['class_list'] ) ? array_map( 'sanitize_html_class', (array) $cta_layout_settings['class_list'] ) : array();
    $cta_layout_style    = '';

    if ( ! empty( $cta_layout_settings['style_map'] ) && is_array( $cta_layout_settings['style_map'] ) ) {
        $cta_style_chunks = array();

        foreach ( $cta_layout_settings['style_map'] as $property => $value ) {
            $property = is_string( $property ) ? trim( $property ) : '';
            $value    = is_string( $value ) ? trim( $value ) : '';

            if ( '' === $property || '' === $value ) {
                continue;
            }

            $cta_style_chunks[] = $property . ': ' . $value . ';';
        }

        if ( ! empty( $cta_style_chunks ) ) {
            $cta_layout_style = ' style="' . esc_attr( implode( ' ', $cta_style_chunks ) ) . '"';
        }
    }
    ?>
    <section class="bg-section bg-section--accent" id="landing-cta">
        <?php
        $landing_cta_classes = array_merge( array( 'cta' ), $cta_layout_classes );
        ?>
        <div class="<?php echo esc_attr( implode( ' ', array_unique( $landing_cta_classes ) ) ); ?>" data-bg-animate data-bg-cta<?php echo $cta_layout_style; ?>>
            <h2 class="cta__title"><?php esc_html_e( 'Bereit für die nächste Kohorte?', 'beyond_gotham' ); ?></h2>
            <p class="cta__lead"><?php esc_html_e( 'Sichere dir deinen Platz und kombiniere journalistisches Handwerk mit taktischer Einsatzkompetenz.', 'beyond_gotham' ); ?></p>
            <a class="bg-button bg-button--primary" href="<?php echo esc_url( home_url( '/kurse/' ) ); ?>"><?php esc_html_e( 'Alle Kurse ansehen', 'beyond_gotham' ); ?></a>
        </div>
    </section>

    <section class="bg-section bg-section--newsletter" id="landing-newsletter">
        <?php
        $cta_settings     = function_exists( 'beyond_gotham_get_cta_settings' ) ? beyond_gotham_get_cta_settings() : array();
        $cta_text         = isset( $cta_settings['text'] ) ? $cta_settings['text'] : '';
        $cta_label        = isset( $cta_settings['label'] ) ? $cta_settings['label'] : '';
        $cta_url          = isset( $cta_settings['url'] ) ? $cta_settings['url'] : '';
        $cta_text_clean   = trim( wp_strip_all_tags( $cta_text ) );
        $cta_label_clean  = trim( $cta_label );
        $cta_is_empty     = ( '' === $cta_text_clean ) && ( '' === $cta_label_clean );
        $cta_attributes   = $cta_is_empty ? ' hidden aria-hidden="true"' : '';
        $cta_classes      = array( 'newsletter' );

        if ( $cta_is_empty ) {
            $cta_classes[] = 'newsletter--empty';
        }

        $cta_classes = array_merge( $cta_classes, $cta_layout_classes );

        $cta_class_string = implode( ' ', array_unique( array_map( 'sanitize_html_class', $cta_classes ) ) );
        ?>
        <div class="<?php echo esc_attr( $cta_class_string ); ?>" data-bg-animate data-bg-cta<?php echo $cta_attributes; ?><?php echo $cta_layout_style; ?>>
            <div class="newsletter__content">
                <h2 class="newsletter__title"><?php esc_html_e( 'Newsletter & Einsatzbriefing', 'beyond_gotham' ); ?></h2>
                <p class="newsletter__text" data-bg-cta-text><?php echo $cta_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
            </div>
            <div class="newsletter__form newsletter__actions">
                <a class="bg-button bg-button--primary" data-bg-cta-button<?php echo $cta_url ? ' href="' . esc_url( $cta_url ) . '"' : ' aria-disabled="true"'; ?>>
                    <?php echo esc_html( $cta_label ); ?>
                </a>
            </div>
        </div>
    </section>
</main>

<?php get_template_part( 'template-parts/cta' ); ?>

<?php
get_footer();
