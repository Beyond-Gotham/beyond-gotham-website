<?php
/**
 * Template for category archives.
 *
 * @package beyond_gotham
 */

get_header();

$category_description = category_description();
?>

<main id="primary" class="site-main beyond-category">
    <header class="category-header">
        <h1 class="category-title"><?php single_cat_title(); ?></h1>
        <?php if ( ! empty( $category_description ) ) : ?>
            <div class="category-intro"><?php echo wp_kses_post( wpautop( $category_description ) ); ?></div>
        <?php endif; ?>
    </header>

    <?php if ( have_posts() ) : ?>
        <section class="category-posts">
            <?php get_template_part( 'template-parts/category', 'loop' ); ?>
        </section>

        <nav class="beyond-category-pagination" aria-label="<?php esc_attr_e( 'Beiträge blättern', 'beyond_gotham' ); ?>">
            <?php the_posts_pagination( array(
                'mid_size'  => 1,
                'prev_text' => '&laquo;',
                'next_text' => '&raquo;',
            ) ); ?>
        </nav>
    <?php else : ?>
        <section class="category-posts-empty">
            <p><?php esc_html_e( 'Keine Artikel in dieser Kategorie verfügbar.', 'beyond_gotham' ); ?></p>
        </section>
    <?php endif; ?>
</main>

<?php
get_footer();
