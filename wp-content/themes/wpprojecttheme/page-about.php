<?php get_header(); ?>

<!-- Hero section with background image -->
<section class="about-hero" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/vegama1.webp');">
    <div class="about-hero-overlay">
        <span class="pill">Our Story</span>
        <h1>About Vegama</h1>
        <p>We believe in the power of plant-based living to transform lives, communities, and our planet</p>
    </div>
</section>

<!-- Our Story: text + image -->
<section class="our-story">
    <div class="our-story-text">
        <h2>Our Story</h2>
        <p>Vegama started with a simple mission: to make plant-based living accessible, delicious, and joyful for everyone. Founded in 2020, we've grown from a small blog into a thriving community of passionate vegans, vegetarians, and plant-curious individuals.</p>
        <p>What began as a collection of family recipes has blossomed into a comprehensive platform offering everything from beginner-friendly guides to advanced cooking techniques, wellness tips, and sustainability insights.</p>
    </div>
    <div class="our-story-image">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/vegama2.webp" alt="Fresh ingredients">
    </div>
</section>

<!-- Our Values: 4 icon cards -->
<section class="our-values">
    <h2>Our Values</h2>
    <p class="section-subtitle">The principles that guide everything we do</p>
    <div class="values-grid">
        <div class="value-card">
            <span class="value-icon">💚</span>
            <h3>Compassion</h3>
            <p>We believe in kindness to all living beings and our planet</p>
        </div>
        <div class="value-card">
            <span class="value-icon">🤝</span>
            <h3>Community</h3>
            <p>Building connections and supporting each other on this journey</p>
        </div>
        <div class="value-card">
            <span class="value-icon">🎯</span>
            <h3>Authenticity</h3>
            <p>Real recipes, honest reviews, and genuine experiences</p>
        </div>
        <div class="value-card">
            <span class="value-icon">✨</span>
            <h3>Innovation</h3>
            <p>Constantly exploring new flavors and techniques</p>
        </div>
    </div>
</section>

<!-- Our Mission: dark band with image + text -->
<section class="our-mission">
    <div class="mission-image">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/vegama3.webp" alt="Fresh greens">
    </div>
    <div class="mission-text">
        <h2>Our Mission</h2>
        <p>To inspire and empower people to embrace plant-based living through delicious recipes, practical guides, and a supportive community.</p>
        <p>We're committed to making vegan cooking accessible to everyone, regardless of their experience level or dietary restrictions.</p>
        <a href="#" class="cta-button">Join Our Community</a>
    </div>
</section>

<!-- Meet Our Team: single image with overlay text -->
<section class="meet-team">
    <h2>Meet Our Team</h2>
    <p class="section-subtitle">Passionate food lovers dedicated to plant-based living</p>
    <div class="team-image-wrapper">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/vegama4.webp" alt="Our team cooking">
        <div class="team-overlay-text">
            <p>Our team includes professional chefs, nutritionists, food photographers, and passionate home cooks — all united by a love for delicious plant-based food and a commitment to making the world a better place.</p>
        </div>
    </div>
</section>

<!-- Join Our Community CTA -->
<section class="join-community">
    <h2>Join Our Community</h2>
    <p>Get weekly recipes, tips, and exclusive content delivered to your inbox</p>
    <form class="newsletter-form">
        <input type="email" placeholder="Enter your email" required>
        <button type="submit">Subscribe</button>
    </form>
</section>

<?php get_footer(); ?>