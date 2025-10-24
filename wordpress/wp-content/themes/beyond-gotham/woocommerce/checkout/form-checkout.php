<?php
/**
 * Checkout Form Override for Beyond Gotham Theme
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}
?>

<section class="bg-checkout-wrapper" aria-labelledby="checkout-title">
    <header class="bg-checkout-header">
        <h1 id="checkout-title" class="bg-checkout-header__title"><?php esc_html_e( 'Kasse', 'beyond-gotham' ); ?></h1>
        <p class="bg-checkout-header__description"><?php esc_html_e( 'Füllen Sie Ihre Rechnungs- und Lieferadresse aus und prüfen Sie Ihre Bestellung.', 'beyond-gotham' ); ?></p>
    </header>

    <form name="checkout" method="post" class="checkout woocommerce-checkout bg-checkout-form" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">

        <?php if ( $checkout->get_checkout_fields() ) : ?>
            <div class="bg-checkout-layout">
                <section class="bg-checkout-details" aria-labelledby="checkout-details-title">
                    <h2 id="checkout-details-title" class="bg-checkout-details__title"><?php esc_html_e( 'Adressdaten', 'beyond-gotham' ); ?></h2>

                    <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                    <div class="bg-form-sections" id="customer_details">
                        <div class="bg-form-section bg-form-section--billing" aria-labelledby="billing-details-title">
                            <h3 id="billing-details-title" class="bg-form-section__title"><?php esc_html_e( 'Rechnungsadresse', 'beyond-gotham' ); ?></h3>
                            <?php do_action( 'woocommerce_checkout_billing' ); ?>
                        </div>

                        <div class="bg-form-section bg-form-section--shipping" aria-labelledby="shipping-details-title">
                            <h3 id="shipping-details-title" class="bg-form-section__title"><?php esc_html_e( 'Lieferadresse', 'beyond-gotham' ); ?></h3>
                            <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                        </div>
                    </div>

                    <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
                </section>

                <aside class="checkout-summary bg-form-section" aria-labelledby="order_review_heading">
                    <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

                    <h2 id="order_review_heading" class="checkout-summary__title"><?php esc_html_e( 'Ihre Bestellung', 'beyond-gotham' ); ?></h2>

                    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                    <div id="order_review" class="woocommerce-checkout-review-order checkout-summary__content">
                        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                    </div>

                    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
                </aside>
            </div>
        <?php endif; ?>
    </form>
</section>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
