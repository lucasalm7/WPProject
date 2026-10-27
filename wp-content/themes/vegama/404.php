<?php
get_header();
?>

<main id="main" class="about-page error-page">
    <section class="about-hero"><div class="about-hero__inner">
        <p class="sec-eye">Page not found</p>
        <h1>This page is <em>off the menu.</em></h1>
        <p>The link may be old or mistyped. Here is where most people want to go.</p>
    </div></section>

    <section class="about-layout error-layout">
        <div class="about-card">
            <p class="sec-eye sec-eye--dark">Popular pages</p>
            <h2>Find your way back</h2>
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Recipes and guides</a></li>
                <li><a href="<?php echo esc_url( home_url( '/classes' ) ); ?>">Masterclasses in Esbjerg</a></li>
                <li><a href="<?php echo esc_url( home_url( '/shop' ) ); ?>">E-books and merch</a></li>
                <li><a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>">Contact us</a></li>
            </ul>
            <a class="btn-primary btn-primary--dark" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to the homepage</a>
        </div>
    </section>
</main>

<?php get_footer();
