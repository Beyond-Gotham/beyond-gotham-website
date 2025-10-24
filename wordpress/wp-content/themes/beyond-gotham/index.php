<?php
/**
 * Main template file.
 *
 * @package beyond_gotham
 */

get_header();
?>

<main id="primary" class="site-main archive">
    <?php
    $page_for_posts = (int) get_option( 'page_for_posts' );
    $archive_title  = $page_for_posts ? get_the_title( $page_for_posts ) : get_bloginfo( 'name' );
    $archive_intro  = $page_for_posts ? get_post_field( 'post_excerpt', $page_for_posts ) : get_bloginfo( 'description' );
    ?>

    <header class="archive__header" data-bg-animate>
        <h1 class="archive__title"><?php echo esc_html( $archive_title ); ?></h1>
        <?php if ( $archive_intro ) : ?>
            <div class="archive__intro"><?php echo wp_kses_post( wpautop( $archive_intro ) ); ?></div>
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
                    <h2 class="bg-card__title"><?php esc_html_e( 'Keine Beiträge gefunden', 'beyond_gotham' ); ?></h2>
                    <p class="bg-card__excerpt"><?php esc_html_e( 'Bitte versuchen Sie es mit einer anderen Kategorie oder Suche.', 'beyond_gotham' ); ?></p>
                </div>
            </article>
        </section>
    <?php endif; ?>
</main>

<?php get_template_part( 'template-parts/cta-box' ); ?>

<?php get_footer(); ?>
