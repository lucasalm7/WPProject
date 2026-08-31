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
  
    <section id="recipes" class="sec">
    <div class="sec-inner">
      <div class="rec-header">
        <div>
          <p class="sec-eye">Recipe Library</p>
          <h2 class="sec-h">This week's <em>picks.</em></h2>
        </div>
      </div>
      <div class="rec-rail">

        <div class="rc">
          <div class="rc-thumb">🥑</div>
          <div class="rc-body">
            <div class="rc-tag">BREAKFAST</div>
            <div class="rc-name">Smashed Avocado Toast with Micro Herbs</div>
            <div class="rc-meta"><span>15 min</span><span>★★★★★</span><span>Easy</span></div>
          </div>
        </div>

        <div class="rc">
          <div class="rc-thumb">🍜</div>
          <div class="rc-body">
            <div class="rc-tag">MAIN</div>
            <div class="rc-name">Miso Ramen with Crispy Tofu &amp; Pak Choi</div>
            <div class="rc-meta"><span>35 min</span><span>★★★★☆</span><span>Medium</span></div>
          </div>
        </div>

        <div class="rc">
          <div class="rc-thumb">🍋</div>
          <div class="rc-body">
            <div class="rc-tag">MAIN</div>
            <div class="rc-name">Lemon Tahini Buddha Bowl</div>
            <div class="rc-meta"><span>25 min</span><span>★★★★★</span><span>Easy</span></div>
          </div>
        </div>

        <div class="rc">
          <div class="rc-thumb">🫐</div>
          <div class="rc-body">
            <div class="rc-tag">BREAKFAST</div>
            <div class="rc-name">Wild Blueberry Chia Pudding</div>
            <div class="rc-meta"><span>Overnight</span><span>★★★★☆</span><span>Easy</span></div>
          </div>
        </div>

        <div class="rc">
          <div class="rc-thumb">🍫</div>
          <div class="rc-body">
            <div class="rc-tag">DESSERT</div>
            <div class="rc-name">Dark Chocolate Avocado Mousse</div>
            <div class="rc-meta"><span>20 min</span><span>★★★★★</span><span>Easy</span></div>
          </div>
        </div>

        <div class="rc">
          <div class="rc-thumb">🥜</div>
          <div class="rc-body">
            <div class="rc-tag">MAIN</div>
            <div class="rc-name">Peanut &amp; Sweet Potato Curry</div>
            <div class="rc-meta"><span>40 min</span><span>★★★★☆</span><span>Medium</span></div>
          </div>
        </div>

        <div class="rc">
          <div class="rc-thumb">🫙</div>
          <div class="rc-body">
            <div class="rc-tag">SNACK</div>
            <div class="rc-name">Pickled Cucumber Kimchi Rolls</div>
            <div class="rc-meta"><span>30 min</span><span>★★★★☆</span><span>Medium</span></div>
          </div>
        </div>

        <div class="rc">
          <div class="rc-thumb">🍓</div>
          <div class="rc-body">
            <div class="rc-tag">BREAKFAST</div>
            <div class="rc-name">Strawberry &amp; Basil Overnight Oats</div>
            <div class="rc-meta"><span>Overnight</span><span>★★★★★</span><span>Easy</span></div>
          </div>
        </div>

      </div>
    </div>
  </section>
  
</main>

<?php get_footer(); ?>