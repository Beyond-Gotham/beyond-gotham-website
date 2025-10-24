<?php
/**
 * Category loop template.
 *
 * @package beyond_gotham
 */

?>
<div class="beyond-category-grid">
    <?php
    $post_index = 0;

    while ( have_posts() ) :
        the_post();
        $post_index++;
        $card_classes = array( 'beyond-post-card' );

        if ( 1 === $post_index ) {
            $card_classes[] = 'beyond-highlight';
        }
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( $card_classes ); ?>>
            <a class="beyond-post-link" href="<?php the_permalink(); ?>">
                <?php if ( has_post_thumbnail() ) : ?>
                    <figure class="beyond-post-thumbnail">
                        <?php the_post_thumbnail( 'large', array( 'class' => 'beyond-post-image' ) ); ?>
                    </figure>
                <?php endif; ?>

                <header class="beyond-post-header">
                    <h2 class="beyond-post-title"><?php the_title(); ?></h2>
                </header>

                <div class="beyond-post-excerpt">
                    <?php
                    if ( has_excerpt() ) {
                        the_excerpt();
                    } else {
                        echo wp_kses_post( wpautop( wp_trim_words( get_the_content(), 30, '…' ) ) );
                    }
                    ?>
                </div>
            </a>
        </article>
    <?php endwhile; ?>
</div>
