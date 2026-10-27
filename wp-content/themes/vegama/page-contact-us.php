<?php
get_header();
?>

<main id="main" class="about-page contact-page">
    <section class="about-hero">
        <div class="about-hero__inner">
            <p class="sec-eye">Contact us</p>
            <h1>Ask us <em>anything.</em></h1>
            <p>
                Masterclasses, e-books, recipes, partnerships or press. Pick your topic and we only ask
                for what we need. We reply within 24 hours.
            </p>
        </div>
    </section>

    <section class="about-layout contact-layout">
        <div class="about-copy">
            <div class="about-card">
                <p class="sec-eye sec-eye--dark">How it works</p>
                <h2>Three quick steps</h2>
                <ol class="contact-steps">
                    <li>
                        <span class="contact-steps__n" aria-hidden="true">1</span>
                        <div><strong>Pick a topic</strong><p>Tell us what your question is about.</p></div>
                    </li>
                    <li>
                        <span class="contact-steps__n" aria-hidden="true">2</span>
                        <div><strong>Tell us a little more</strong><p>Only the fields that topic needs. No phone number.</p></div>
                    </li>
                    <li>
                        <span class="contact-steps__n" aria-hidden="true">3</span>
                        <div><strong>We answer within 24 hours</strong><p>By email, from a real person in our kitchen.</p></div>
                    </li>
                </ol>
            </div>

            <div class="about-card">
                <p class="sec-eye sec-eye--dark">Good to know</p>
                <h2>Before you write</h2>
                <ul>
                    <li>Masterclasses take place in Esbjerg, Denmark.</li>
                    <li>Bought an e-book? The download link is in your order email and under My account.</li>
                    <li>Follow us on Instagram and Pinterest: @vegama</li>
                </ul>
            </div>
        </div>

        <div class="about-form-wrap">
            <div class="about-form-card">
                <p class="sec-eye sec-eye--dark">Get in touch</p>
                <h2>How can we help?</h2>
                <?php get_template_part( 'template-parts/contact-form' ); ?>
            </div>
        </div>
    </section>
    <?php get_template_part( 'template-parts/media-rich-block' ); ?>
</main>

<?php
get_footer();
