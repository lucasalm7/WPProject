<?php get_header(); ?>

<main id="main" class="site-main">

 <section id="hero">
  <p class="hero-eyebrow">Vegan Cooking · Esbjerg · Denmark</p>
  <h1 class="hero-h1">Plant-based<br><em>culture.</em></h1>
  <p class="hero-sub">Recipes, cookbooks, and immersive cooking experiences for people who believe food can be both ethical and extraordinary.</p>
  <div class="hero-ctas">
    <a href="<?php echo esc_url( home_url( '/recipes' ) ); ?>" class="btn-primary">Explore the kitchen</a>
    <a href="<?php echo esc_url( home_url( '/classes' ) ); ?>" class="btn-ghost">Book a masterclass</a>
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
        <p class="sec-eye">Recipes & Stories</p>
        <h2 class="sec-h">From the <em>kitchen.</em></h2>
      </div>
      <a href="<?php echo esc_url( home_url( '/recipes' ) ); ?>" class="btn-sm">View all →</a>
    </div>
    <div class="rec-rail">
      <?php
      $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 8,
        'category_name'  => 'recipes',
        'post_status'    => 'publish',
      );
      $query = new WP_Query( $args );
      if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
          $cats = get_the_category();
          $cat_name = ! empty( $cats ) ? strtoupper( $cats[0]->name ) : 'RECIPE';
      ?>
        <div class="rc">
          <div class="rc-thumb">
            <?php if ( has_post_thumbnail() ) : ?>
              <?php the_post_thumbnail( 'medium', array( 'style' => 'width:100%;height:178px;object-fit:cover;' ) ); ?>
            <?php else : ?>
              🌿
            <?php endif; ?>
          </div>
          <div class="rc-body">
            <div class="rc-tag"><?php echo esc_html( $cat_name ); ?></div>
            <div class="rc-name">
              <a href="<?php the_permalink(); ?>" style="text-decoration:none;color:inherit">
                <?php the_title(); ?>
              </a>
            </div>
            <div class="rc-meta">
              <span><?php echo get_the_date( 'M Y' ); ?></span>
              <span><?php echo esc_html( get_the_author() ); ?></span>
            </div>
          </div>
        </div>
      <?php
        endwhile;
        wp_reset_postdata();
      else : ?>
        <p style="color:var(--mist)">No recipes yet — check back soon.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

    <section id="merch" class="sec">
    <div class="sec-inner">
      <p class="sec-eye">The Shop</p>
      <h2 class="sec-h">Bring the kitchen <em>home.</em></h2>
      <div class="merch-grid">

        <div class="mc">
          <span class="mc-emo">👕</span>
          <div class="mc-name">Vegama Tee</div>
          <div class="mc-price">€35</div>
          <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="mc-add">Add to cart</a>
        </div>

        <div class="mc">
          <span class="mc-emo">🧴</span>
          <div class="mc-name">Kitchen Apron</div>
          <div class="mc-price">€45</div>
          <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="mc-add">Add to cart</a>
        </div>

        <div class="mc">
          <span class="mc-emo">🫙</span>
          <div class="mc-name">Spice Set (6)</div>
          <div class="mc-price">€28</div>
          <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="mc-add">Add to cart</a>
        </div>

        <div class="mc">
          <span class="mc-emo">🍴</span>
          <div class="mc-name">Bamboo Utensils</div>
          <div class="mc-price">€40</div>
          <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="mc-add">Add to cart</a>
        </div>

        <div class="mc">
          <span class="mc-emo">🎒</span>
          <div class="mc-name">Market Tote</div>
          <div class="mc-price">€22</div>
          <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="mc-add">Add to cart</a>
        </div>

      </div>
    </div>
  </section>
  
<!-- Testimonials -->
<section id="testimonials" class="sec sec-dark">
  <div class="sec-inner">
    <p class="sec-eye">Community</p>
    <h2 class="sec-h">Real voices from <em>the table.</em></h2>
    <div class="testi-grid">

      <div class="tc">
        <div class="tc-stars">★★★★★</div>
        <p class="tc-q">"The Spring Ramen class changed how I think about broths. I've made it six times since."</p>
        <p class="tc-a">Mia K., Copenhagen</p>
      </div>

      <div class="tc">
        <div class="tc-stars">★★★★★</div>
        <p class="tc-q">"Bought the cookbook as a gift and ended up ordering one for myself."</p>
        <p class="tc-a">Thomas R., Aarhus</p>
      </div>

      <div class="tc">
        <div class="tc-stars">★★★★★</div>
        <p class="tc-q">"I was never a plant-based cook. After two classes, I prefer cooking this way."</p>
        <p class="tc-a">Søren L., Odense</p>
      </div>

      <div class="tc">
        <div class="tc-stars">★★★★★</div>
        <p class="tc-q">"The fermentation workshop was the highlight of my year. We talk about it constantly."</p>
        <p class="tc-a">Anna P., Esbjerg</p>
      </div>

      <div class="tc">
        <div class="tc-stars">★★★★★</div>
        <p class="tc-q">"The free recipe library alone is worth bookmarking. Best plant-based resource I've found."</p>
        <p class="tc-a">Clara B., Malmö</p>
      </div>

      <div class="tc">
        <div class="tc-stars">★★★★★</div>
        <p class="tc-q">"We booked a private session for our team. The chef was extraordinary."</p>
        <p class="tc-a">Louise M., TechCorp DK</p>
      </div>
    </div>
    </div>
  </section>

      <!-- Newsletter -->
    <section id="newsletter">
     <div class="nl-inner">
      <h2 class="nl-h">Recipes in your<br><em>inbox.</em> Weekly.</h2>
         <p class="nl-sub">Join 2,400+ plant-based cooks. One recipe, one story, early access to new class dates — every Wednesday.</p>
      <form class="nl-form" action="#" method="post">
          <input type="email" name="nl_email" placeholder="your@email.com" required>
           <button type="submit">Subscribe</button>
         </form>
     </div>
    </section>

    </div>
  </div>
</section>

</main>

<?php get_footer(); ?>