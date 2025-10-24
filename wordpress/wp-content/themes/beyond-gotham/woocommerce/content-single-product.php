<?php
/**
 * The template for displaying product content in the single-product.php template.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

global $product;

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form();
    return;
}

?>

<article id="product-<?php the_ID(); ?>" <?php wc_product_class( 'bg-product-detail', $product ); ?>>
    <div class="bg-product-hero">
        <div class="bg-product-gallery">
            <?php do_action( 'woocommerce_before_single_product_summary' ); ?>
        </div>
        <div class="bg-product-summary entry-summary">
            <?php do_action( 'woocommerce_single_product_summary' ); ?>
        </div>
    </div>

    <section class="bg-product-tabs">
        <?php do_action( 'woocommerce_after_single_product_summary' ); ?>
    </section>
</article>

<?php do_action( 'woocommerce_after_single_product' ); ?>
