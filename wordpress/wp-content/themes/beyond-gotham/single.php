<?php
/**
 * Template for displaying single posts.
 *
 * @package beyond_gotham
 */

get_header();
?>

<main id="primary" class="site-main single-post-main">
    <?php if ( have_posts() ) : ?>
        <?php
        while ( have_posts() ) :
            the_post();

            if ( 'post' === get_post_type() ) {
                get_template_part( 'template-parts/single', 'post' );
            } else {
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article single-article--generic' ); ?>>
                    <?php the_title( '<h1 class="article-title">', '</h1>' ); ?>
                    <div class="article-content typography-content">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
            }
        endwhile;
        ?>
    <?php else : ?>
        <section class="single-post-empty">
            <p><?php esc_html_e( 'Der angeforderte Beitrag konnte nicht gefunden werden.', 'beyond_gotham' ); ?></p>
        </section>
    <?php endif; ?>
</main>

<?php
get_footer();
