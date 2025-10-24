<?php
/**
 * The template for displaying product content within loops.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>

<article <?php wc_product_class( 'bg-shop-card', $product ); ?>>
    <div class="bg-shop-card__media">
        <a href="<?php the_permalink(); ?>" class="bg-shop-card__link">
            <?php
            woocommerce_show_product_loop_sale_flash();
            echo woocommerce_get_product_thumbnail();
            ?>
        </a>
    </div>
    <div class="bg-shop-card__content">
        <h2 class="bg-shop-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        <div class="bg-price">
            <?php woocommerce_template_loop_price(); ?>
        </div>
        <div class="bg-shop-card__cta">
            <?php woocommerce_template_loop_add_to_cart(); ?>
        </div>
    </div>
</article>
