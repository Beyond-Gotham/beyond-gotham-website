<?php
/**
 * Template part for displaying single posts.
 *
 * @package beyond_gotham
 */

$categories_list = get_the_category_list( ', ' );
$author_id       = get_the_author_meta( 'ID' );
$author_bio      = get_the_author_meta( 'description', $author_id );
$author_avatar   = get_avatar( $author_id, 120, '', esc_attr( get_the_author() ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article' ); ?>>
    <header class="article-header">
        <?php if ( has_post_thumbnail() ) : ?>
            <figure class="article-hero" data-bg-skeleton>
                <?php
                echo wp_get_attachment_image(
                    get_post_thumbnail_id(),
                    'full',
                    false,
                    array(
                        'class'         => 'post-hero',
                        'loading'       => 'eager',
                        'decoding'      => 'async',
                        'fetchpriority' => 'high',
                        'sizes'         => '100vw',
                    )
                );
                ?>
                <?php if ( get_the_post_thumbnail_caption() ) : ?>
                    <figcaption class="article-hero__caption"><?php echo wp_kses_post( get_the_post_thumbnail_caption() ); ?></figcaption>
                <?php endif; ?>
            </figure>
        <?php endif; ?>

        <div class="article-header__inner">
            <?php the_title( '<h1 class="article-title">', '</h1>' ); ?>

            <div class="article-meta" aria-label="<?php esc_attr_e( 'Beitragsinformationen', 'beyond_gotham' ); ?>">
                <span class="article-meta__item article-meta__date">
                    <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                </span>

                <span class="article-meta__item article-meta__author">
                    <?php
                    printf(
                        /* translators: %s: post author. */
                        esc_html__( 'Von %s', 'beyond_gotham' ),
                        sprintf( '<span class="article-meta__author-name">%s</span>', esc_html( get_the_author() ) )
                    );
                    ?>
                </span>

                <?php if ( $categories_list ) : ?>
                    <span class="article-meta__item article-meta__categories">
                        <?php
                        printf(
                            /* translators: %s: list of categories. */
                            esc_html__( 'In %s', 'beyond_gotham' ),
                            wp_kses_post( $categories_list )
                        );
                        ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="article-content typography-content">
        <?php the_content(); ?>
        <?php
        wp_link_pages(
            array(
                'before' => '<nav class="article-pagination" aria-label="' . esc_attr__( 'Seiten', 'beyond_gotham' ) . '">',
                'after'  => '</nav>',
            )
        );
        ?>
    </div>

    <footer class="article-footer">
        <?php if ( function_exists( 'beyond_gotham_is_social_sharing_enabled_for' ) && beyond_gotham_is_social_sharing_enabled_for( 'post' ) ) : ?>
            <?php get_template_part( 'template-parts/share-buttons' ); ?>
        <?php endif; ?>

        <?php if ( $author_bio || $author_avatar ) : ?>
            <section class="article-author" aria-label="<?php esc_attr_e( 'Über die Autorin oder den Autor', 'beyond_gotham' ); ?>">
                <?php if ( $author_avatar ) : ?>
                    <div class="article-author__media"><?php echo wp_kses_post( $author_avatar ); ?></div>
                <?php endif; ?>
                <div class="article-author__body">
                    <h2 class="article-author__title"><?php esc_html_e( 'Über den Autor / die Autorin', 'beyond_gotham' ); ?></h2>
                    <p class="article-author__name"><?php echo esc_html( get_the_author() ); ?></p>
                    <?php if ( $author_bio ) : ?>
                        <div class="article-author__bio"><?php echo wpautop( wp_kses_post( $author_bio ) ); ?></div>
                    <?php else : ?>
                        <p class="article-author__bio"><?php esc_html_e( 'Weitere Informationen zum Autor folgen in Kürze.', 'beyond_gotham' ); ?></p>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <nav class="article-navigation" aria-label="<?php esc_attr_e( 'Weitere Beiträge', 'beyond_gotham' ); ?>">
            <?php
            the_post_navigation(
                array(
                    'prev_text' => '<span class="nav-label">' . esc_html__( 'Vorheriger Artikel', 'beyond_gotham' ) . '</span><span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-label">' . esc_html__( 'Nächster Artikel', 'beyond_gotham' ) . '</span><span class="nav-title">%title</span>',
                )
            );
            ?>
        </nav>
    </footer>
</article>

<?php
if ( comments_open() || get_comments_number() ) {
    comments_template();
}
