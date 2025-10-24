<?php
/**
 * Template for displaying pages.
 *
 * @package beyond_gotham
 */

get_header();
?>

<main id="primary" class="site-main single-post-main">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
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
                <?php if ( function_exists( 'beyond_gotham_is_social_sharing_enabled_for' ) && beyond_gotham_is_social_sharing_enabled_for( 'page' ) ) : ?>
                    <?php get_template_part( 'template-parts/share-buttons' ); ?>
                <?php endif; ?>
            </article>
            <?php
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
        endwhile;
    endif;
    ?>
</main>

<?php get_template_part( 'template-parts/cta' ); ?>

<?php
get_footer();
