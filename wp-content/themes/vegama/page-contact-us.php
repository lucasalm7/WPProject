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

            <figure class="about-photo contact-photo" style="--pos: 50% 50%;">
                <?php vegama_photo( 'class-kitchen.webp', 'Four people in aprons cooking together in a bright kitchen while one of them chops vegetables' ); ?>
            </figure>
        </div>

        <div class="about-form-wrap">
            <div class="about-form-card">
                <p class="sec-eye sec-eye--dark">Get in touch</p>
                <h2>How can we help?</h2>
                <?php get_template_part( 'template-parts/contact-form' ); ?>
            </div>
        </div>
    </section>

    <section class="contact-faq" aria-labelledby="faq-title">
        <div class="contact-faq__main">
            <p class="sec-eye sec-eye--dark">Good to know</p>
            <h2 id="faq-title" class="contact-faq__h">Frequently asked <em>questions.</em></h2>
            <div class="faq-list">
                <?php foreach ( vegama_faqs() as $faq ) : ?>
                    <details class="faq-item" id="<?php echo esc_attr( $faq['id'] ); ?>">
                        <summary><?php echo esc_html( $faq['q'] ); ?></summary>
                        <div class="faq-a">
                            <?php foreach ( $faq['a'] as $answer ) : ?>
                                <p><?php echo esc_html( $answer ); ?></p>
                            <?php endforeach; ?>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
        <figure class="about-photo contact-faq__media">
            <?php vegama_photo( 'class-masterclass.webp', 'Four people laughing while they cook a festive plant-based menu together at a Vegama masterclass' ); ?>
        </figure>
    </section>
    <?php get_template_part( 'template-parts/media-rich-block' ); ?>
</main>

<script>
function vegamaOpenFaq() {
    var item = location.hash ? document.getElementById(location.hash.slice(1)) : null;
    if (item && item.tagName === "DETAILS") {
        item.open = true;
        item.scrollIntoView({ block: "start" });
    }
}
window.addEventListener("hashchange", vegamaOpenFaq);
vegamaOpenFaq();
</script>

<?php
get_footer();
