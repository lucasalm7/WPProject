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

<main class="sustainability-page">
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="about-hero__inner">
            <p class="sec-eye">Our Footprint & Impact</p>
            <h1>Sustainability, shaped by nature and craft.</h1>
            <p>At Vegama, we believe true sustainability is rooted in respect—for the local ecosystems of Denmark and the conscious choices we make in the kitchen. Moving beyond sterile corporate metrics, we highlight the real-world power of plant-based living: shifting away from animal agriculture—which uses 83% of global farmland while producing only 18% of human calories—to embrace a lighter, culturally rich footstep across Scandinavia.</p>
        </div>
    </section>

    <!-- Initiative 1 -->
    <section class="about-layout" style="align-items: center">
        <div class="about-copy">
            <div class="about-card" style="height: 100%;">
                <span class="sec-eye sec-eye--dark">Initiative 01</span>
                <h2>The Micro-Seasonal Harvest & Land Efficiency</h2>
                <p>Instead of relying on global out-of-season supply chains, our recipes strictly follow Nordic micro-seasons. We partner directly with small-scale, regenerative Danish farms that prioritize soil health, crop rotation, and chemical-free cultivation. This localized rhythm honors the land right beneath our northern sky.</p>
                <p><strong>The Global Impact:</strong> Shifting to plant-based systems can reduce global farmland use by 76%—freeing up an area the size of the US, China, EU, and Australia combined. Producing 1g of beef protein requires roughly 100 times more land than producing 1g of protein from peas or tofu, making our hyper-seasonal approach a vital tool for land preservation.</p>
            </div>
        </div>
        <div class="about-form-wrap">
            <div class="about-form-card" style="background: #fff; padding: 20px; border-radius: 16px; border: 1px solid rgba(24, 95, 48, 0.1); box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/initiative1.webp" alt="Regenerative Danish farmland and micro-seasonal root vegetables" style="width: 100%; height: auto; border-radius: 12px; margin-bottom: 20px; display: block;" />
                <h3 style="color: var(--txt); margin-bottom: 10px;">Rooted in the Soil</h3>
                <p style="color: #555; line-height: 1.6; font-style: italic;">"When you cook with root vegetables harvested just 20 kilometers away after the first autumn frost, the flavor speaks for itself. Sustainability doesn't require complexity; it requires listening to the land and honoring its natural capacity."</p>
                <p style="margin-top: 15px; font-weight: bold; font-size: 14px; color: var(--sage);">— The Vegama Kitchen Manifesto</p>
            </div>
        </div>
    </section>

    <!-- Initiative 2 -->
    <section class="about-layout" style="align-items: center; direction: rtl;">
        <div class="about-copy" style="direction: ltr;">
            <div class="about-card" style="height: 100%;">
                <span class="sec-eye sec-eye--dark">Initiative 02</span>
                <h2>The Zero-Waste Craft Workshop & Footprint Reduction</h2>
                <p>In our physical masterclasses and e-books, we champion "root-to-stem" and "peel-to-plate" cooking. We teach home cooks how vegetable scraps, herb stems, and day-old sourdough can be transformed into rich stocks, crispy garnishes, and fermented condiments—proving that sustainable food culture tastes extraordinary.</p>
                <p><strong>The Impact:</strong> Dietary shifts like ours emit up to 75% fewer greenhouse gases than high-meat diets, saving roughly 1.5 tonnes of CO₂ equivalent per person annually. Furthermore, plant-based cooking cuts personal water footprints by up to 54%, saving thousands of liters compared to meat production (where beef demands ~15,400 liters per kg versus vegetables at ~300 liters). </p>
            </div>
        </div>
        <div class="about-form-wrap" style="direction: ltr;">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/initiative2.webp' ); ?>"
            alt="Vegetable scraps and herbs prepared for zero-waste cooking"
            style="width: 100%; height: auto; border-radius: 12px; margin-bottom: 20px; display: block;"
            loading="lazy" decoding="async" >
        <div class="about-form-card" style="background: #eef4f1; padding: 40px; border-radius: 16px; border: 1px solid rgba(24, 95, 48, 0.1);">
            <h3 style="color: var(--txt); margin-bottom: 15px;">From Scrap to Centerpiece</h3>
            <ul style="padding-left: 20px; line-height: 1.8; color: #555;">
                <li>Transforming cauliflower leaves into roasted side dishes while cutting culinary water waste</li>
                <li>Fermenting leftover fruit peels into custom vinegars to eliminate kitchen scraps</li>
                <li>Reviving stale grains into hearty hearth crackers that decompose safely through clean composting</li>
            </ul>
        </div>
    </div>
    </section>

    <!-- Initiative 3 -->
    <section class="about-layout" style="align-items: center;">
        <div class="about-copy">
            <div class="about-card" style="height: 100%;">
                <span class="sec-eye sec-eye--dark">Initiative 03</span>
                <h2>Conscious Circulation & Community Action</h2>
                <p>Our e-books and digital guides are designed to eliminate paper waste entirely. For physical print collections and community gatherings, we partner exclusively with certified eco-conscious binderies using FSC-certified paper and vegetable-based inks. We actively curate content that educates our Scandinavian audience on resource conversion efficiency—such as highlighting how over 75% of global soy is fed to livestock rather than consumed directly as tofu.</p>
                <p>Through our local "Cook & Share" circles in Copenhagen and Esbjerg, we connect conscious food enthusiasts, micro-influencers, and home cooks to redistribute surplus organic produce directly into collaborative community cooking sessions.</p>
            </div>
        </div>
        <div class="about-form-wrap">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/initiative3.webp' ); ?>"
            alt="Vegetable scraps and herbs prepared for zero-waste cooking"
            style="width: 100%; height: auto; border-radius: 12px; margin-bottom: 20px; display: block;"
            loading="lazy" decoding="async" >
            <div class="about-form-card" style="background: #185f30; color: #fff; padding: 40px; border-radius: 16px;">
                <h3 style="color: #fff; margin-bottom: 15px;">Join the Movement</h3>
                <p style="opacity: 0.9; margin-bottom: 20px;">Want to learn more about how we integrate sustainable food culture, low-energy cooking practices, and upcoming masterclass schedules into our community? Get in touch with our team.</p>
                <a href="<?php echo esc_url( home_url('/about#vegama-conversational-form') ); ?>" class="btn-primary" style="display: inline-block; background: #fff; color: #185f30; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">Reach out to us</a>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?>