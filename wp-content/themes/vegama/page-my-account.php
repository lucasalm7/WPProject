<?php
get_header();

$user       = wp_get_current_user();
$first_name = $user->exists() ? ( $user->first_name ? $user->first_name : $user->display_name ) : '';
?>

<main id="main" class="about-page account-page">
    <section class="about-hero"><div class="about-hero__inner">
        <p class="sec-eye">My account</p>
        <?php if ( is_user_logged_in() ) : ?>
            <h1>Hi, <em><?php echo esc_html( $first_name ); ?>.</em></h1>
            <p>Your masterclass bookings, orders and e-books in one place.</p>
        <?php else : ?>
            <h1>Welcome <em>back.</em></h1>
            <p>Sign in to see your masterclass bookings, orders and e-books.</p>
        <?php endif; ?>
    </div></section>

    <section class="account-wrap">
        <?php echo do_shortcode( '[woocommerce_my_account]' ); ?>
    </section>
</main>

<?php get_footer();
