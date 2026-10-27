<?php
/**
 * Vegama account overview: upcoming masterclasses and quick links.
 *
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

defined( 'ABSPATH' ) || exit;
?>

<p>Welcome to your Vegama account. Your masterclass bookings, orders and e-books are all here.</p>

<?php do_action( 'woocommerce_account_dashboard' ); ?>

<h2>Your account</h2>
<div class="account-cards">
    <a class="account-card" href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>">
        <strong>Orders and bookings</strong>
        <span>Check the status of everything you have bought.</span>
    </a>
    <a class="account-card" href="<?php echo esc_url( wc_get_account_endpoint_url( 'downloads' ) ); ?>">
        <strong>My e-books</strong>
        <span>Download your e-books again at any time.</span>
    </a>
    <a class="account-card" href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-account' ) ); ?>">
        <strong>Account details</strong>
        <span>Change your name, email or password.</span>
    </a>
</div>

<?php
do_action( 'woocommerce_before_my_account' );
do_action( 'woocommerce_after_my_account' );
