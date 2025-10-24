<?php
/* Template Name: Landingpage */

get_header();
?>

<main id="primary" class="site-main beyond-landing">
    <?php
    $hero_query = new WP_Query(
        array(
            'category_name'  => 'reportagen',
            'posts_per_page' => 1,
        )
    );
    ?>

    <section class="beyond-hero" aria-label="Top Story">
        <?php if ( $hero_query->have_posts() ) : ?>
            <?php
            while ( $hero_query->have_posts() ) :
                $hero_query->the_post();
                $hero_category = get_the_category();
                $hero_label    = ! empty( $hero_category ) ? $hero_category[0]->name : esc_html__( 'Reportagen', 'beyond-gotham' );
                ?>
                <article <?php post_class( 'beyond-hero__article' ); ?>>
                    <div class="beyond-hero__media">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a class="beyond-hero__image-link" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail( 'large', array( 'class' => 'beyond-hero__image' ) ); ?>
                            </a>
                        <?php else : ?>
                            <div class="beyond-hero__image beyond-hero__image--placeholder" aria-hidden="true">
                                <span><?php esc_html_e( 'Beitragsbild Platzhalter', 'beyond-gotham' ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="beyond-hero__content">
                        <span class="beyond-hero__category"><?php echo esc_html( $hero_label ); ?></span>
                        <h1 class="beyond-hero__title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h1>
                        <div class="beyond-hero__excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <article class="beyond-hero__article beyond-hero__article--placeholder">
                <div class="beyond-hero__media">
                    <div class="beyond-hero__image beyond-hero__image--placeholder" aria-hidden="true">
                        <span><?php esc_html_e( 'Beitragsbild Platzhalter', 'beyond-gotham' ); ?></span>
                    </div>
                </div>
                <div class="beyond-hero__content">
                    <span class="beyond-hero__category"><?php esc_html_e( 'Reportagen', 'beyond-gotham' ); ?></span>
                    <h1 class="beyond-hero__title"><?php esc_html_e( 'Titel der Aufmacher-Geschichte', 'beyond-gotham' ); ?></h1>
                    <div class="beyond-hero__excerpt">
                        <p><?php esc_html_e( 'Kurzer Platzhalter-Teaser für den Aufmacher.', 'beyond-gotham' ); ?></p>
                    </div>
                </div>
            </article>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </section>

    <?php
    $category_sections = array(
        'dossiers'    => esc_html__( 'Dossiers', 'beyond-gotham' ),
        'interviews' => esc_html__( 'Interviews', 'beyond-gotham' ),
        'osint'      => esc_html__( 'OSINT', 'beyond-gotham' ),
    );

    foreach ( $category_sections as $category_slug => $section_title ) :
        $category_obj = get_category_by_slug( $category_slug );
        $section_link = $category_obj ? get_category_link( $category_obj->term_id ) : '#';

        $section_posts = new WP_Query(
            array(
                'posts_per_page' => 4,
                'category_name'  => $category_slug,
            )
        );
        ?>
        <section class="beyond-section beyond-section--<?php echo esc_attr( $category_slug ); ?>">
            <header class="beyond-section__header">
                <h2 class="beyond-section__title">
                    <a href="<?php echo esc_url( $section_link ); ?>">
                        <?php echo esc_html( $section_title ); ?>
                    </a>
                </h2>
            </header>
            <div class="beyond-section__grid">
                <?php if ( $section_posts->have_posts() ) : ?>
                    <?php
                    while ( $section_posts->have_posts() ) :
                        $section_posts->the_post();
                        ?>
                        <article <?php post_class( 'beyond-card' ); ?>>
                            <div class="beyond-card__media">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a class="beyond-card__image-link" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                                        <?php the_post_thumbnail( 'medium', array( 'class' => 'beyond-card__image' ) ); ?>
                                    </a>
                                <?php else : ?>
                                    <div class="beyond-card__image beyond-card__image--placeholder" aria-hidden="true">
                                        <span><?php esc_html_e( 'Bild Platzhalter', 'beyond-gotham' ); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="beyond-card__content">
                                <h3 class="beyond-card__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <div class="beyond-card__excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                <a class="beyond-card__link" href="<?php the_permalink(); ?>">
                                    <?php esc_html_e( 'Zum Beitrag', 'beyond-gotham' ); ?>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                <?php else : ?>
                    <article class="beyond-card beyond-card--placeholder">
                        <div class="beyond-card__media">
                            <div class="beyond-card__image beyond-card__image--placeholder" aria-hidden="true">
                                <span><?php esc_html_e( 'Bild Platzhalter', 'beyond-gotham' ); ?></span>
                            </div>
                        </div>
                        <div class="beyond-card__content">
                            <h3 class="beyond-card__title"><?php esc_html_e( 'Titel des Beitrags', 'beyond-gotham' ); ?></h3>
                            <div class="beyond-card__excerpt">
                                <p><?php esc_html_e( 'Platzhalter-Teaser für diese Kategorie.', 'beyond-gotham' ); ?></p>
                            </div>
                            <a class="beyond-card__link" href="<?php echo esc_url( $section_link ); ?>">
                                <?php esc_html_e( 'Alle Beiträge ansehen', 'beyond-gotham' ); ?>
                            </a>
                        </div>
                    </article>
                <?php endif; ?>
            </div>
        </section>
        <?php wp_reset_postdata(); ?>
    <?php endforeach; ?>

    <?php
    $course_page = get_page_by_path( 'bg_course' );
    $course_link = $course_page ? get_permalink( $course_page ) : '#';
    ?>
    <section class="beyond-section beyond-section--weiterbildung">
        <div class="beyond-section__content beyond-section__content--cta">
            <h2 class="beyond-section__title"><?php esc_html_e( 'Weiterbildung', 'beyond-gotham' ); ?></h2>
            <p><?php esc_html_e( 'Mehr über unsere Weiterbildung erfahren.', 'beyond-gotham' ); ?></p>
            <a class="beyond-section__cta" href="<?php echo esc_url( $course_link ); ?>">
                <?php esc_html_e( 'Zur Kursübersicht', 'beyond-gotham' ); ?>
            </a>
        </div>
    </section>

    <section class="beyond-section beyond-section--newsletter" aria-label="Newsletter">
        <div class="beyond-section__content beyond-section__content--newsletter">
            <h2 class="beyond-section__title"><?php esc_html_e( 'Bleibe auf dem Laufenden', 'beyond-gotham' ); ?></h2>
            <p><?php esc_html_e( 'Trage deine E-Mail-Adresse ein, um regelmäßig Neuigkeiten zu erhalten.', 'beyond-gotham' ); ?></p>
            <form class="beyond-newsletter__form" action="#" method="post">
                <label class="screen-reader-text" for="beyond-newsletter-email"><?php esc_html_e( 'E-Mail-Adresse', 'beyond-gotham' ); ?></label>
                <input type="email" id="beyond-newsletter-email" name="beyond-newsletter-email" placeholder="<?php esc_attr_e( 'E-Mail-Adresse', 'beyond-gotham' ); ?>" required />
                <button type="submit"><?php esc_html_e( 'Anmelden', 'beyond-gotham' ); ?></button>
            </form>
        </div>
    </section>
</main>

<?php
get_footer();
