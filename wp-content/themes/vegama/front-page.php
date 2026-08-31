<?php get_header(); ?>

<main id="main" class="site-main">

  <section id="hero">
    <p class="hero-eyebrow">Plant-Based · Artisan · Esbjerg</p>
    <h1 class="hero-h1">Master the art<br>of <em>plants.</em></h1>
    <p class="hero-sub">Recipes, cookbooks, and immersive cooking experiences for people who believe food can be both ethical and extraordinary.</p>
    <div class="hero-ctas">
      <a href="/shop" class="btn-primary">Explore the kitchen</a>
      <a href="/blog" class="btn-ghost">Book a masterclass</a>
    </div>
    <div class="hero-stats">
      <div><div class="stat-n">2.4k+</div><div class="stat-l">Community</div></div>
      <div><div class="stat-n">140+</div><div class="stat-l">Free recipes</div></div>
      <div><div class="stat-n">96%</div><div class="stat-l">Class rating</div></div>
    </div>
    </section>

  <div class="marquee-band" aria-hidden="true">
    <div class="marquee-track">
      <span>Plant-Based Cooking</span><span class="marquee-dot">✿</span>
      <span>Vegan Masterclasses</span><span class="marquee-dot">✿</span>
      <span>Artisan Cookbooks</span><span class="marquee-dot">✿</span>
      <span>Community Recipes</span><span class="marquee-dot">✿</span>
      <span>Copenhagen Kitchen</span><span class="marquee-dot">✿</span>
      <span>Plant-Based Cooking</span><span class="marquee-dot">✿</span>
      <span>Vegan Masterclasses</span><span class="marquee-dot">✿</span>
      <span>Artisan Cookbooks</span><span class="marquee-dot">✿</span>
      <span>Community Recipes</span><span class="marquee-dot">✿</span>
      <span>Esbjerg Kitchen</span><span class="marquee-dot">✿</span>
    </div>
  </div>
  <section id="products" class="sec sec-dark">
    <div class="sec-inner">
      <p class="sec-eye">The Kitchen</p>
      <h2 class="sec-h">Everything you need to cook <em>beautifully.</em></h2>
      <div class="prod-grid">

        <div class="prod-card">
          <span class="prod-emo">📖</span>
          <span class="prod-badge">FREE</span>
          <div class="prod-name">Recipe Library</div>
          <div class="prod-desc">140+ plant-based recipes. No paywall, ever. Filter by category, save favourites, discover new dishes weekly.</div>
          <div class="prod-price">Free</div>
          <a href="<?php echo esc_url( home_url( '/recipes' ) ); ?>" class="btn-sm">View details →</a>
        </div>

        <div class="prod-card">
          <span class="prod-emo">📱</span>
          <span class="prod-badge">E-BOOK</span>
          <div class="prod-name">The Plant Kitchen E-Book</div>
          <div class="prod-desc">60 exclusive recipes not on the blog, with technique guides and meal planning templates.</div>
          <div class="prod-price">€25</div>
          <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="btn-sm">View details →</a>
        </div>

        <div class="prod-card">
          <span class="prod-emo">👨‍🍳</span>
          <span class="prod-badge">MASTERCLASS</span>
          <div class="prod-name">Vegan Cooking Masterclass</div>
          <div class="prod-desc">Hands on 3 hour experience in our Esbjerg's kitchen. Max 8 participants. All ingredients provided.</div>
          <div class="prod-price">€60–€120</div>
          <a href="<?php echo esc_url( home_url( '/classes' ) ); ?>" class="btn-sm">View details →</a>
        </div>

        <div class="prod-card">
          <span class="prod-emo">🎁</span>
          <span class="prod-badge">BEST VALUE</span>
          <div class="prod-name">Book + Class Bundle</div>
          <div class="prod-desc">The full Vegama experience. Our E-Book plus one masterclass seat. The perfect gift.</div>
          <div class="prod-price">€90</div>
          <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="btn-sm">View details →</a>
        </div>

      </div>
    </div>
  </section>
  
</main>

<?php get_footer(); ?>