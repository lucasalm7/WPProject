<?php
get_header();
?>

<main class="page-shell about-page">
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

                <form class="vegama-contact-form" method="post" action="<?php echo esc_url( get_permalink() ); ?>">
                    <?php wp_nonce_field( 'vegama_about_form', 'vegama_about_nonce' ); ?>

                    <div class="form-grid">
                        <label>
                            <span>Full Name</span>
                            <input type="text" name="full_name" required>
                        </label>

                        <label>
                            <span>Email Address</span>
                            <input type="email" name="email" required>
                        </label>

                        <label>
                            <span>Company / Brand Name</span>
                            <input type="text" name="company">
                        </label>

                        <label>
                            <span>Contact Person</span>
                            <input type="text" name="contact_person">
                        </label>

                        <label class="full-width">
                            <span>Website / URL</span>
                            <input type="url" name="website" placeholder="https://example.com">
                        </label>

                        <label class="full-width">
                            <span>Short Description</span>
                            <textarea name="message" rows="5" required></textarea>
                        </label>
                    </div>

                    <button type="submit" name="vegama_about_submit" value="1" class="btn-primary btn-primary--dark">
                        Send inquiry
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?>