<?php
/* Template Name: InfoTerminal Produktseite */

get_header();
?>
<main id="primary" class="site-main product-page product-info-terminal">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <section class="product-section product-hero" aria-labelledby="product-hero-title">
                <div class="product-hero__inner">
                    <div class="product-hero__content">
                        <p class="product-hero__eyebrow"><?php esc_html_e( 'Produktlösung', 'beyond-gotham' ); ?></p>
                        <h1 id="product-hero-title" class="product-hero__title"><?php the_title(); ?></h1>
                        <p class="product-hero__subtitle">
                            <?php echo esc_html__( 'Das OSINT-Dashboard für investigativen Journalismus – vernetzt Daten, Quellen und Analysen in einem Interface.', 'beyond-gotham' ); ?>
                        </p>
                        <div class="product-hero__cta-group">
                            <a class="product-hero__cta" href="<?php echo esc_url( home_url( '/kontakt' ) ); ?>">
                                <?php echo esc_html__( 'Demo anfragen', 'beyond-gotham' ); ?>
                            </a>
                            <a class="product-hero__secondary" href="<?php echo esc_url( home_url( '/services' ) ); ?>">
                                <?php echo esc_html__( 'Leistungsübersicht', 'beyond-gotham' ); ?>
                            </a>
                        </div>
                    </div>
                    <div class="product-hero__media" aria-hidden="true">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <figure class="product-hero__figure" data-bg-skeleton>
                                <?php
                                echo wp_get_attachment_image(
                                    get_post_thumbnail_id(),
                                    'large',
                                    false,
                                    array(
                                        'class'         => 'product-hero__image',
                                        'loading'       => 'eager',
                                        'decoding'      => 'async',
                                        'fetchpriority' => 'high',
                                        'sizes'         => '(min-width: 1024px) 640px, 90vw',
                                    )
                                );
                                ?>
                            </figure>
                        <?php else : ?>
                            <div class="product-hero__placeholder" role="img" aria-label="Illustration des InfoTerminal Dashboards">
                                <span><?php esc_html_e( 'Visualisierung des InfoTerminal Dashboards', 'beyond-gotham' ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <section class="product-section product-description" aria-labelledby="product-description-title">
                <div class="product-section__inner">
                    <h2 id="product-description-title" class="product-section__title"><?php esc_html_e( 'Warum InfoTerminal?', 'beyond-gotham' ); ?></h2>
                    <div class="product-description__content">
                        <p><?php echo esc_html__( 'InfoTerminal bündelt investigative Recherchewerkzeuge, automatisierte Datenfeeds und redaktionelle Workflows in einem verlässlichen Kontrollzentrum. Reporterinnen und Analysten behalten komplexe Lagen im Blick, ohne zwischen Tools wechseln zu müssen.', 'beyond-gotham' ); ?></p>
                        <p><?php echo esc_html__( 'Mit konfigurierbaren Dashboards, intelligenten Alarmierungen und einem klaren Rechte-Management unterstützt InfoTerminal Redaktionsteams bei der schnellen Verifizierung von Quellen und beim sicheren Teilen sensibler Erkenntnisse.', 'beyond-gotham' ); ?></p>
                        <p><?php echo esc_html__( 'Das System ist für investigative Redaktionen, OSINT-Teams in NGOs sowie Compliance- und Sicherheitsabteilungen konzipiert, die auf zuverlässige Analysen und revisionssichere Dokumentation angewiesen sind.', 'beyond-gotham' ); ?></p>
                    </div>

                    <?php if ( '' !== get_the_content() ) : ?>
                        <div class="product-description__editor">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section class="product-section product-features" aria-labelledby="product-features-title">
                <div class="product-section__inner">
                    <h2 id="product-features-title" class="product-section__title"><?php esc_html_e( 'Leistungsmerkmale im Überblick', 'beyond-gotham' ); ?></h2>
                    <ul class="product-features__grid" role="list">
                        <?php
                        $features = array(
                            array(
                                'title'       => esc_html__( 'Zentralisierte Datenfeeds', 'beyond-gotham' ),
                                'description' => esc_html__( 'Aggregiert offene Quellen, Social Media und proprietäre Datenbanken mit Echtzeit-Updates.', 'beyond-gotham' ),
                            ),
                            array(
                                'title'       => esc_html__( 'Adaptive Dashboards', 'beyond-gotham' ),
                                'description' => esc_html__( 'Personalisierbare Widgets, Filter und KPI-Module für individuelle Recherchefragen.', 'beyond-gotham' ),
                            ),
                            array(
                                'title'       => esc_html__( 'Alarm- & Hinweislogik', 'beyond-gotham' ),
                                'description' => esc_html__( 'Intelligente Benachrichtigungen bei relevanten Datenmustern, Vorfällen oder Schwellenwerten.', 'beyond-gotham' ),
                            ),
                            array(
                                'title'       => esc_html__( 'Kollaboration & Rollen', 'beyond-gotham' ),
                                'description' => esc_html__( 'Teamarbeitsbereiche, Kommentierung und Berechtigungen für sensible Inhalte.', 'beyond-gotham' ),
                            ),
                            array(
                                'title'       => esc_html__( 'Forensische Dokumentation', 'beyond-gotham' ),
                                'description' => esc_html__( 'Audit-sichere Dossiers, Exportfunktionen und Nachvollziehbarkeit aller Recherche-Schritte.', 'beyond-gotham' ),
                            ),
                            array(
                                'title'       => esc_html__( 'API- & Integrationsfähigkeit', 'beyond-gotham' ),
                                'description' => esc_html__( 'Anbindung an bestehende Redaktionstools, sichere Schnittstellen und Webhooks.', 'beyond-gotham' ),
                            ),
                        );

                        foreach ( $features as $feature ) :
                            ?>
                            <li class="feature-card">
                                <div class="feature-card__icon" aria-hidden="true">
                                    <span class="feature-card__icon-shape"></span>
                                </div>
                                <div class="feature-card__content">
                                    <h3 class="feature-card__title"><?php echo esc_html( $feature['title'] ); ?></h3>
                                    <p class="feature-card__text"><?php echo esc_html( $feature['description'] ); ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section>

            <section class="product-section product-demo" aria-labelledby="product-demo-title">
                <div class="product-section__inner">
                    <div class="product-demo__header">
                        <h2 id="product-demo-title" class="product-section__title"><?php esc_html_e( 'InfoTerminal live erleben', 'beyond-gotham' ); ?></h2>
                        <p class="product-demo__description">
                            <?php echo esc_html__( 'Erkunden Sie das Dashboard mit interaktiven Karten, Zeitleisten und Prioritätslisten. Die Vorschau zeigt, wie Informationen priorisiert und verdichtet werden.', 'beyond-gotham' ); ?>
                        </p>
                    </div>
                    <div class="product-demo__preview-wrapper">
                        <div class="product-preview" role="img" aria-label="Platzhalter für eine InfoTerminal-Dashboard Vorschau"></div>
                    </div>
                </div>
            </section>

            <section class="product-section product-cta" aria-labelledby="product-cta-title">
                <div class="product-section__inner">
                    <div class="product-cta__content">
                        <h2 id="product-cta-title" class="product-section__title"><?php esc_html_e( 'Bereit für eine individuelle Demo?', 'beyond-gotham' ); ?></h2>
                        <p><?php echo esc_html__( 'Unser Team stellt das InfoTerminal gerne in einem persönlichen Gespräch vor und zeigt, wie sich das System in Ihre Abläufe integrieren lässt.', 'beyond-gotham' ); ?></p>
                    </div>
                    <div class="product-cta__actions">
                        <a class="product-cta__button" href="<?php echo esc_url( home_url( '/kontakt' ) ); ?>">
                            <?php echo esc_html__( 'Kontakt aufnehmen', 'beyond-gotham' ); ?>
                        </a>
                        <a class="product-cta__secondary" href="mailto:info@beyondgotham.org">
                            <?php echo esc_html__( 'Direkt eine Nachricht senden', 'beyond-gotham' ); ?>
                        </a>
                    </div>
                </div>
            </section>
        <?php endwhile; ?>
    <?php else : ?>
        <section class="product-section product-empty" aria-live="polite">
            <div class="product-section__inner">
                <h1 class="product-section__title"><?php esc_html_e( 'InfoTerminal', 'beyond-gotham' ); ?></h1>
                <p><?php esc_html_e( 'Inhalte für diese Produktseite sind derzeit nicht verfügbar.', 'beyond-gotham' ); ?></p>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php get_template_part( 'template-parts/cta-box' ); ?>

<?php
get_footer();
?>
