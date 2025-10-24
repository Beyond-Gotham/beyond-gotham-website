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
                    <?php if ( function_exists( 'beyond_gotham_render_post_meta' ) ) : ?>
                        <?php
                        beyond_gotham_render_post_meta(
                            get_the_ID(),
                            array(
                                'container_tag'         => 'div',
                                'container_class'       => 'article-meta',
                                'item_base_class'       => 'article-meta__item',
                                'item_key_class_prefix' => 'article-meta__',
                                'aria_label'            => __( 'Beitragsinformationen', 'beyond_gotham' ),
                            )
                        );
                        ?>
                    <?php endif; ?>
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

<?php get_template_part( 'template-parts/cta' ); ?>

<?php
get_footer();
