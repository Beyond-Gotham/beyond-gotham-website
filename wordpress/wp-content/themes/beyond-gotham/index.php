<?php
/**
 * Main template file.
 *
 * @package beyond_gotham
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
                </header>
                <div class="entry-content">
                    <?php the_excerpt(); ?>
                </div>
            </article>
        <?php endwhile; ?>

        <?php the_posts_navigation(); ?>
    <?php else : ?>
        <article class="no-results">
            <header class="entry-header">
                <h2><?php esc_html_e( 'Nothing Found', 'beyond_gotham' ); ?></h2>
            </header>
            <div class="entry-content">
                <p><?php esc_html_e( 'It seems we can’t find what you’re looking for.', 'beyond_gotham' ); ?></p>
            </div>
        </article>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
