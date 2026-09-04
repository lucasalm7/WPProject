<?php
get_header();
?>

<script>
function vegama_sustainability_page_template( $template ) {
    if ( is_page( 'sustainability-initiatives' ) || is_page( 'Sustainability Initiatives' ) ) {
        $custom_template = locate_template( array( 'sustainability-page.php' ) );
        if ( $custom_template ) {
            return $custom_template;
        }
    }
    return $template;
}
add_filter( 'template_include', 'vegama_sustainability_page_template' );
</script>

<main class="page-shell sustainability-page">
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="about-hero__inner">
            <p class="sec-eye">Our Footprint</p>
            <h1>Sustainability, shaped by nature and craft.</h1>
            <p>
                At Vegama, we believe true sustainability is rooted in respect—for the ingredients we source, 
                the local ecosystems of Denmark, and the community we cook alongside. Here is how we bring 
                conscious choices into everyday plant-based living.
            </p>
        </div>
    </section>

    <!-- Initiative 1: Hyper-Seasonal Kitchen Culture -->
    <section class="about-layout" style="align-items: center; margin-bottom: 60px;">
        <div class="about-copy">
            <div class="about-card" style="height: 100%;">
                <span class="sec-eye sec-eye--dark">Initiative 01</span>
                <h2>The Micro-Seasonal Harvest</h2>
                <p>
                    Instead of relying on global out-of-season supply chains, our recipes strictly follow the Nordic 
                    micro-seasons. We partner directly with small-scale, regenerative Danish farms that prioritize soil health, 
                    crop rotation, and chemical-free cultivation. 
                </p>
                <p>
                    <strong>The Impact:</strong> Drastically lowered transport emissions and a deep reconnection with the natural rhythm 
                    of what grows right beneath our northern sky.
                </p>
            </div>
        </div>
        <div class="about-form-wrap">
            <div class="about-form-card" style="background: var(--sage); color: #fff; padding: 40px; border-radius: 16px;">
                <h3 style="color: #fff; margin-bottom: 15px;">Rooted in the Soil</h3>
                <p style="opacity: 0.9; line-height: 1.6;">
                    "When you cook with root vegetables harvested just 20 kilometers away after the first autumn frost, 
                    the flavor speaks for itself. Sustainability doesn't require complexity; it requires listening to the land."
                </p>
                <p style="margin-top: 20px; font-weight: bold; font-size: 14px; opacity: 0.8;">— The Vegama Kitchen Manifesto</p>
            </div>
        </div>
    </section>

    <!-- Initiative 2: Zero-Waste Mastery -->
    <section class="about-layout" style="align-items: center; margin-bottom: 60px; direction: rtl;">
        <div class="about-copy" style="direction: ltr;">
            <div class="about-card" style="height: 100%;">
                <span class="sec-eye sec-eye--dark">Initiative 02</span>
                <h2>The Zero-Waste Craft Workshop</h2>
                <p>
                    In our physical masterclasses and e-books, we champion "root-to-stem" and "peel-to-plate" cooking. 
                    We teach home cooks how vegetable scraps, herb stems, and day-old sourdough can be transformed into rich stocks, 
                    crispy garnishes, and fermented condiments.
                </p>
                <p>
                    <strong>The Impact:</strong> Minimizing household food waste through practical, elegant culinary techniques 
                    that prove sustainability tastes extraordinary.
                </p>
            </div>
        </div>
        <div class="about-form-wrap" style="direction: ltr;">
            <div class="about-form-card" style="background: #eef4f1; padding: 40px; border-radius: 16px; border: 1px solid rgba(24, 95, 48, 0.1);">
                <h3 style="color: var(--txt); margin-bottom: 15px;">From Scrap to Centerpiece</h3>
                <ul style="padding-left: 20px; line-height: 1.8; color: #555;">
                    <li>Transforming cauliflower leaves into roasted side dishes</li>
                    <li>Fermenting leftover fruit peels into custom vinegars</li>
                    <li>Reviving stale grains into hearty hearth crackers</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Initiative 3: Conscious Circulation (Community & Publishing) -->
    <section class="about-layout" style="align-items: center; margin-bottom: 80px;">
        <div class="about-copy">
            <div class="about-card" style="height: 100%;">
                <span class="sec-eye sec-eye--dark">Initiative 03</span>
                <h2>Conscious Circulation & Publishing</h2>
                <p>
                    Our e-books and digital guides are designed to eliminate paper waste entirely. For our physical print collections 
                    and community gatherings, we partner exclusively with certified eco-conscious binderies using FSC-certified paper 
                    and vegetable-based inks. 
                </p>
                <p>
                    Furthermore, through our local "Cook & Share" circles in Copenhagen and Esbjerg, we redistribute surplus organic produce 
                    from collaborative markets directly into community cooking sessions.
                </p>
            </div>
        </div>
        <div class="about-form-wrap">
            <div class="about-form-card" style="background: #185f30; color: #fff; padding: 40px; border-radius: 16px;">
                <h3 style="color: #fff; margin-bottom: 15px;">Join the Movement</h3>
                <p style="opacity: 0.9; margin-bottom: 20px;">
                    Want to learn more about how we integrate sustainable food culture into our masterclasses? Get in touch with our community team.
                </p>
                <a href="<?php echo esc_url( home_url('/about#vegama-conversational-form') ); ?>" class="btn-primary" style="display: inline-block; background: #fff; color: #185f30; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">Reach out to us</a>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?>