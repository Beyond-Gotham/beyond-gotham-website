<?php
/**
 * Template Name: InfoTerminal Showcase
 * Description: Präsentiert die InfoTerminal-Plattform innerhalb des regulären WordPress-Layouts.
 */

get_header(); ?>

<main id="primary" class="site-main page-infoterminal">
    <?php while (have_posts()) : the_post(); ?>
        <section class="infoterminal-hero">
            <div class="bg-container infoterminal-hero__inner">
                <div class="infoterminal-hero__meta">
                    <span class="infoterminal-hero__badge"><?php esc_html_e('OSINT Intelligence Platform', 'beyondgotham-dark-child'); ?></span>
                    <h1 class="infoterminal-hero__title"><?php the_title(); ?></h1>
                    <p class="infoterminal-hero__lead">
                        <?php
                        $excerpt = get_the_excerpt();
                        if ($excerpt) {
                            echo esc_html($excerpt);
                        } else {
                            esc_html_e('Erlebe unsere investigative InfoTerminal-Demo mit visualisierten Netzwerken, Filteroptionen und Fallstudien auf einen Blick.', 'beyondgotham-dark-child');
                        }
                        ?>
                    </p>
                    <div class="infoterminal-hero__actions">
                        <a class="btn infoterminal-hero__btn" href="#infoterminal-demo"><?php esc_html_e('Demo öffnen', 'beyondgotham-dark-child'); ?></a>
                        <a class="btn btn--ghost infoterminal-hero__btn" href="#infoterminal-features"><?php esc_html_e('Features entdecken', 'beyondgotham-dark-child'); ?></a>
                    </div>
                </div>
                <div class="infoterminal-status" aria-live="polite">
                    <h2 class="infoterminal-status__title"><?php esc_html_e('Systemstatus', 'beyondgotham-dark-child'); ?></h2>
                    <ul class="infoterminal-status__list">
                        <?php
                        $services = [
                            ['label' => __('API Gateway', 'beyondgotham-dark-child'), 'latency' => '23ms'],
                            ['label' => __('Graph Datenbank', 'beyondgotham-dark-child'), 'latency' => '15ms'],
                            ['label' => __('Query Engine', 'beyondgotham-dark-child'), 'latency' => '31ms'],
                            ['label' => __('Frontend Renderer', 'beyondgotham-dark-child'), 'latency' => '18ms'],
                        ];
                        foreach ($services as $service) :
                            ?>
                            <li class="infoterminal-status__item">
                                <span class="infoterminal-status__indicator" aria-hidden="true"></span>
                                <span class="infoterminal-status__label"><?php echo esc_html($service['label']); ?></span>
                                <span class="infoterminal-status__latency"><?php echo esc_html($service['latency']); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </section>

        <section id="infoterminal-demo" class="infoterminal-demo">
            <div class="bg-container">
                <?php
                $embed_url = get_post_meta(get_the_ID(), '_bg_infoterminal_embed_url', true);
                if ($embed_url) :
                    ?>
                    <div class="infoterminal-demo__frame">
                        <iframe src="<?php echo esc_url($embed_url); ?>" title="<?php esc_attr_e('InfoTerminal Demo', 'beyondgotham-dark-child'); ?>" loading="lazy" allowfullscreen></iframe>
                    </div>
                <?php else : ?>
                    <div class="infoterminal-demo__placeholder">
                        <p><?php esc_html_e('Hinterlege eine Demo-URL über das benutzerdefinierte Feld „_bg_infoterminal_embed_url“, um hier eine Live-Ansicht einzubetten.', 'beyondgotham-dark-child'); ?></p>
                        <p><?php esc_html_e('Alternativ kann der reguläre Seiteninhalt genutzt werden, um Screenshots oder Videos einzubetten.', 'beyondgotham-dark-child'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section id="infoterminal-features" class="infoterminal-features">
            <div class="bg-container infoterminal-features__grid">
                <article class="infoterminal-feature">
                    <h3><?php esc_html_e('Netzwerk-Visualisierung', 'beyondgotham-dark-child'); ?></h3>
                    <p><?php esc_html_e('Erstelle interaktive Graphen, verfolge Beziehungen zwischen Akteuren und filtere Ergebnisse nach Regionen, Quellen oder Risiko-Level.', 'beyondgotham-dark-child'); ?></p>
                </article>
                <article class="infoterminal-feature">
                    <h3><?php esc_html_e('Fall-Dossiers', 'beyondgotham-dark-child'); ?></h3>
                    <p><?php esc_html_e('Alle Cases laufen jetzt über reguläre WordPress-Kategorien wie „Dossiers“ oder „Reportagen“ – ideal zur Einbindung im Redaktions-Workflow.', 'beyondgotham-dark-child'); ?></p>
                </article>
                <article class="infoterminal-feature">
                    <h3><?php esc_html_e('Live-Datenimporte', 'beyondgotham-dark-child'); ?></h3>
                    <p><?php esc_html_e('Importiere Datensätze aus OSINT-Quellen, aktualisiere Visualisierungen in Echtzeit und exportiere Ergebnisse für Partnerredaktionen.', 'beyondgotham-dark-child'); ?></p>
                </article>
            </div>
        </section>

        <?php if (get_the_content()) : ?>
            <section class="infoterminal-content">
                <div class="bg-container infoterminal-content__inner">
                    <?php the_content(); ?>
                </div>
            </section>
        <?php endif; ?>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
