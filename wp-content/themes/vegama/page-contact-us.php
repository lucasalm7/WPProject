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

    <section class="contact-faq" aria-labelledby="faq-title">
        <p class="sec-eye sec-eye--dark">Good to know</p>
        <h2 id="faq-title" class="contact-faq__h">Frequently asked <em>questions.</em></h2>
        <div class="faq-list">
            <details class="faq-item" id="delivery">
                <summary>How long does delivery take, and what does it cost?</summary>
                <div class="faq-a">
                    <p>We send merch and spices within Denmark. Your order leaves our kitchen within 2 working days, and the shipping price is shown at checkout before you pay.</p>
                    <p>E-books arrive straight away by email and under My account. Masterclasses need no delivery: you get the address in your confirmation email.</p>
                </div>
            </details>
            <details class="faq-item" id="returns">
                <summary>Can I return something?</summary>
                <div class="faq-a">
                    <p>Yes. For merch and spices you have 14 days from delivery to change your mind. Write to us through the form above, then send the item back unused. We refund the full price, including the standard shipping, within 14 days. The return shipping is paid by you.</p>
                    <p>E-books cannot be returned once the download has started, because you get the file straight away. If a file does not work, write to us and we fix it.</p>
                </div>
            </details>
            <details class="faq-item" id="cancellation">
                <summary>Can I cancel a masterclass booking?</summary>
                <div class="faq-a">
                    <p>Yes, free of charge up to 7 days before the class. Write to us and we refund you or move you to another date.</p>
                    <p>Classes on a fixed date are not covered by the 14-day right of withdrawal, so after that we cannot refund the seat.</p>
                </div>
            </details>
            <details class="faq-item" id="gift-card">
                <summary>How does the gift card work?</summary>
                <div class="faq-a">
                    <p>After you pay, we email you a personal code within 24 hours. The person you give it to picks any masterclass date and enters the code at checkout. The code is valid for 12 months.</p>
                </div>
            </details>
            <details class="faq-item" id="allergies">
                <summary>I have an allergy. Can I still join a class?</summary>
                <div class="faq-a">
                    <p>Yes. Everything we cook is plant-based. Write your allergies in the order notes at checkout, and we adapt the dishes or tell you before the class if we cannot.</p>
                </div>
            </details>
            <details class="faq-item" id="ebooks">
                <summary>Where do I find my e-book?</summary>
                <div class="faq-a">
                    <p>In your order email, and under My account → My e-books whenever you are signed in.</p>
                </div>
            </details>
        </div>
    </section>
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
