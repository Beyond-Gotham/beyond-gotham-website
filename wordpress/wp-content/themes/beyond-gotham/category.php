<?php
/**
 * Template for category archives.
 *
 * @package beyond_gotham
 */

get_header();

$category_description = category_description();
?>

<main id="primary" class="site-main archive">
    <header class="archive__header" data-bg-animate>
        <h1 class="archive__title"><?php single_cat_title(); ?></h1>
        <?php if ( ! empty( $category_description ) ) : ?>
            <div class="archive__intro"><?php echo wp_kses_post( wpautop( $category_description ) ); ?></div>
        <?php endif; ?>
    </header>

    <?php if ( have_posts() ) : ?>
        <div class="archive__layout">
            <section class="archive__grid">
                <?php get_template_part( 'template-parts/category', 'loop' ); ?>
            </section>

            <nav class="archive__pagination" aria-label="<?php esc_attr_e( 'Beiträge blättern', 'beyond_gotham' ); ?>">
                <?php
                the_posts_pagination(
                    array(
                        'mid_size'  => 1,
                        'prev_text' => '&laquo;',
                        'next_text' => '&raquo;',
                    )
                );
                ?>
            </nav>
        </div>
    <?php else : ?>
        <section class="archive__grid">
            <article class="bg-card" data-bg-animate>
                <div class="bg-card__body">
                    <h2 class="bg-card__title"><?php esc_html_e( 'Keine Artikel gefunden', 'beyond_gotham' ); ?></h2>
                    <p class="bg-card__excerpt"><?php esc_html_e( 'Bitte wählen Sie eine andere Kategorie oder besuchen Sie die Startseite.', 'beyond_gotham' ); ?></p>
                </div>
            </article>
        </section>
    <?php endif; ?>
</main>

<?php get_template_part( 'template-parts/cta-box' ); ?>

<?php
get_footer();
