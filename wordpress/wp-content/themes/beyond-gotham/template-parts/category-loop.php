<?php
/**
 * Category loop template.
 *
 * @package beyond_gotham
 */

?>
<div class="bg-grid">
    <?php
    while ( have_posts() ) :
        the_post();

        $categories      = get_the_category();
        $primary_category = ! empty( $categories ) ? $categories[0]->name : '';
        $word_count       = str_word_count( wp_strip_all_tags( get_the_content() ) );
        $reading_minutes  = $word_count ? max( 1, (int) ceil( $word_count / 200 ) ) : 0;
        $reading_label    = $reading_minutes
            ? sprintf( _n( '%d Minute Lesezeit', '%d Minuten Lesezeit', $reading_minutes, 'beyond_gotham' ), $reading_minutes )
            : '';
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-card' ); ?> data-bg-animate>
            <a class="bg-card__media" href="<?php the_permalink(); ?>">
                <?php
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail( 'bg-card', array( 'class' => 'bg-card__image' ) );
                } else {
                    echo '<span class="bg-card__placeholder" aria-hidden="true"></span>';
                }
                ?>
            </a>
            <div class="bg-card__body">
                <?php if ( $primary_category ) : ?>
                    <span class="bg-card__badge"><?php echo esc_html( $primary_category ); ?></span>
                <?php endif; ?>

                <h3 class="bg-card__title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>

                <div class="bg-card__excerpt">
                    <?php
                    if ( has_excerpt() ) {
                        the_excerpt();
                    } else {
                        echo wp_kses_post( wpautop( wp_trim_words( get_the_content(), 30, '…' ) ) );
                    }
                    ?>
                </div>

                <div class="bg-card__meta">
                    <time class="bg-card__meta-item" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
                        <?php echo esc_html( get_the_date() ); ?>
                    </time>
                    <?php if ( $reading_label ) : ?>
                        <span class="bg-card__meta-item"><?php echo esc_html( $reading_label ); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </article>
    <?php endwhile; ?>
</div>
