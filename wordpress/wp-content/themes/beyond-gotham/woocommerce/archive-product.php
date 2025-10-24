<?php
/**
 * Template for displaying product archives, including the main shop page.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

do_action( 'woocommerce_before_main_content' );
?>

<div class="bg-shop-page">
    <header class="bg-shop-header">
        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
            <h1 class="bg-shop-title"><?php woocommerce_page_title(); ?></h1>
        <?php endif; ?>

        <div class="bg-shop-description">
            <?php do_action( 'woocommerce_archive_description' ); ?>
        </div>
    </header>

    <div class="bg-shop-layout">
        <aside class="bg-shop-sidebar">
            <div class="bg-shop-sidebar__inner">
                <h2 class="bg-shop-sidebar__title"><?php esc_html_e( 'Filter', 'beyond_gotham' ); ?></h2>
                <p class="bg-shop-sidebar__placeholder"><?php esc_html_e( 'Filter options coming soon to help you narrow results.', 'beyond_gotham' ); ?></p>
                <?php do_action( 'woocommerce_sidebar' ); ?>
            </div>
        </aside>

        <section class="bg-shop-results">
            <?php if ( woocommerce_product_loop() ) : ?>
                <div class="bg-shop-tools">
                    <?php do_action( 'woocommerce_before_shop_loop' ); ?>
                </div>

                <?php woocommerce_product_loop_start(); ?>

                <?php while ( have_posts() ) : ?>
                    <?php the_post(); ?>
                    <?php wc_get_template_part( 'content', 'product' ); ?>
                <?php endwhile; ?>

                <?php woocommerce_product_loop_end(); ?>

                <div class="bg-shop-pagination">
                    <?php do_action( 'woocommerce_after_shop_loop' ); ?>
                </div>
            <?php else : ?>
                <?php do_action( 'woocommerce_no_products_found' ); ?>
            <?php endif; ?>
        </section>
    </div>
</div>

<?php

do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
