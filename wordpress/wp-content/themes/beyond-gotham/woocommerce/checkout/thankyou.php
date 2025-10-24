<?php
/**
 * Thankyou page Override for Beyond Gotham Theme
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;

$shop_page_url = wc_get_page_permalink( 'shop' );

if ( empty( $shop_page_url ) ) {
    $shop_page_url = home_url( '/' );
}
?>

<section class="bg-checkout-thankyou" aria-labelledby="thankyou-title">
    <div class="thankyou-message">
        <h1 id="thankyou-title" class="thankyou-message__title"><?php esc_html_e( 'Vielen Dank für Ihre Bestellung', 'beyond-gotham' ); ?></h1>
        <p class="thankyou-message__intro"><?php esc_html_e( 'Ihre Bestellung ist eingegangen. Nachfolgend finden Sie eine Zusammenfassung.', 'beyond-gotham' ); ?></p>
    </div>

    <div class="thankyou-content">
        <?php if ( $order ) : ?>

            <?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

            <?php if ( $order->has_status( 'failed' ) ) : ?>
                <div class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
                    <?php esc_html_e( 'Leider konnte Ihre Bestellung nicht verarbeitet werden, da die Zahlung abgelehnt wurde. Bitte versuchen Sie es erneut.', 'beyond-gotham' ); ?>
                </div>
                <div class="thankyou-actions">
                    <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button bg-submit-button pay"><?php esc_html_e( 'Zahlung wiederholen', 'beyond-gotham' ); ?></a>
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button thankyou-actions__secondary"><?php esc_html_e( 'Mein Konto', 'beyond-gotham' ); ?></a>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>

                <section class="order-details" aria-labelledby="order-details-title">
                    <h2 id="order-details-title" class="order-details__title"><?php esc_html_e( 'Bestellübersicht', 'beyond-gotham' ); ?></h2>
                    <dl class="order-details__list">
                        <dt class="order-details__label"><?php esc_html_e( 'Bestellnummer', 'beyond-gotham' ); ?></dt>
                        <dd class="order-details__value"><?php echo esc_html( $order->get_order_number() ); ?></dd>

                        <dt class="order-details__label"><?php esc_html_e( 'Datum', 'beyond-gotham' ); ?></dt>
                        <dd class="order-details__value"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></dd>

                        <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
                            <dt class="order-details__label"><?php esc_html_e( 'E-Mail', 'beyond-gotham' ); ?></dt>
                            <dd class="order-details__value"><?php echo esc_html( $order->get_billing_email() ); ?></dd>
                        <?php endif; ?>

                        <dt class="order-details__label"><?php esc_html_e( 'Gesamtsumme', 'beyond-gotham' ); ?></dt>
                        <dd class="order-details__value"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></dd>

                        <?php if ( $order->get_payment_method_title() ) : ?>
                            <dt class="order-details__label"><?php esc_html_e( 'Zahlungsmethode', 'beyond-gotham' ); ?></dt>
                            <dd class="order-details__value"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></dd>
                        <?php endif; ?>
                    </dl>
                </section>

                <div class="thankyou-actions">
                    <a href="<?php echo esc_url( $shop_page_url ); ?>" class="button bg-submit-button thankyou-actions__primary"><?php esc_html_e( 'Zurück zum Shop', 'beyond-gotham' ); ?></a>
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button thankyou-actions__secondary"><?php esc_html_e( 'Mein Konto', 'beyond-gotham' ); ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
            <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

        <?php else : ?>

            <?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

            <div class="thankyou-actions">
                <a href="<?php echo esc_url( $shop_page_url ); ?>" class="button bg-submit-button thankyou-actions__primary"><?php esc_html_e( 'Zurück zum Shop', 'beyond-gotham' ); ?></a>
            </div>

        <?php endif; ?>
    </div>
</section>
