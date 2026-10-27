<?php
get_header();
?>

<main id="main" class="about-page">
    <section class="about-hero">
        <div class="about-hero__inner">
            <p class="sec-eye">About Vegama</p>
            <h1>Plant-based living, shaped by culture and craft.</h1>
            <p>
                Vegama brings together thoughtful recipes, immersive events, and a slower way of eating through food.
                We believe plant-based living can be beautifully practical and deeply nourishing.
            </p>
        </div>
    </section>

    <section class="about-layout">
        <div class="about-copy">
            <div class="about-card">
                <h2>Our story</h2>
                <p>
                    Founded in Denmark, Vegama started with a simple idea: good food should be kind, beautiful, and memorable.
                    We create recipe content, cookbooks, and workshops that help people cook with confidence while staying close to the planet.
                </p>
            </div>

            <div class="about-card">
                <h2>What we do</h2>
                <ul>
                    <li>Plant-based recipes and seasonal inspiration</li>
                    <li>Cooking classes and community events</li>
                    <li>Cookbooks, workshops, and food storytelling</li>
                    <li>Partnerships with brands and creative founders</li>
                </ul>
            </div>
        </div>

        <div class="about-form-wrap">
            <div class="about-form-card">
                <p class="sec-eye sec-eye--dark">Get in touch</p>
                <h2>Work with us</h2>

                <p>Questions about a masterclass, an e-book, a partnership or press? We answer within 24 hours.</p>
                <a class="btn-primary btn-primary--dark" href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>">Contact us</a>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
?>