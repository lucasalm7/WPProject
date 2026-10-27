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

    <section class="about-rows">
        <div class="about-row">
            <figure class="about-photo about-row__media" style="--pos: 50% 22%;">
                <?php vegama_photo( 'class-masterclass.webp', 'Four people laughing while they cook a festive plant-based dish together at a Vegama masterclass' ); ?>
            </figure>
            <div class="about-card about-row__text">
                <h2>Our story</h2>
                <p>
                    Founded in Denmark, Vegama started with a simple idea: good food should be kind, beautiful, and memorable.
                    We create recipes, e-books and cooking classes that help people cook with confidence while staying close to the planet.
                </p>
            </div>
        </div>

        <div class="about-row about-row--flip">
            <div class="about-card about-row__text">
                <h2>What we do</h2>
                <ul>
                    <li>Plant-based recipes and seasonal inspiration</li>
                    <li>Cooking classes and community events</li>
                    <li>E-books, workshops and food storytelling</li>
                    <li>Partnerships with brands and creative founders</li>
                </ul>
            </div>
            <figure class="about-photo about-row__media" style="--pos: 30% 50%;">
                <?php vegama_photo( 'initiative2.webp', 'People cooking together around a long table in a kitchen workshop' ); ?>
            </figure>
        </div>

        <div class="about-cta">
            <figure class="about-cta__media">
                <?php vegama_photo( 'about-class-group.webp', 'Four people in aprons talking and cooking together in a bright kitchen' ); ?>
            </figure>
            <div class="about-cta__text">
                <p class="sec-eye">Get in touch</p>
                <h2>Work with us</h2>
                <p>Questions about a masterclass, an e-book, a partnership or press? We answer within 24 hours.</p>
                <a class="btn-primary" href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>">Contact us</a>
            </div>
        </div>
    </section>

    <?php get_template_part( 'template-parts/media-rich-block' ); ?>
</main>
<?php
get_footer();
