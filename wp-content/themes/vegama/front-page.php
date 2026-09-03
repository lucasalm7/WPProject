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
      <span>Esbjerg Kitchen</span><span class="marquee-dot">✿</span>
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
    <h2 class="sec-h">Everything you need to cook <em>tastefully.</em></h2>
    <div class="prod-grid">

      <?php
      $products = new WP_Query( array(
          'post_type'      => 'vegama_product',
          'posts_per_page' => -1,
          'post_status'    => 'publish',
          'orderby'        => 'menu_order',
          'order'          => 'ASC',
      ) );

      if ( $products->have_posts() ) :
          while ( $products->have_posts() ) : $products->the_post();
              $badge = get_post_meta( get_the_ID(), '_product_badge', true );
              $price = get_post_meta( get_the_ID(), '_product_price', true );
              $link  = get_post_meta( get_the_ID(), '_product_link',  true );
      ?>

        <div class="prod-card">

          <div class="prod-img">
            <?php if ( has_post_thumbnail() ) : ?>
              <?php the_post_thumbnail( 'medium', array(
                  'style' => 'width:100%;height:100%;object-fit:cover;'
              ) ); ?>
            <?php else : ?>
              <div class="prod-img-placeholder">🌿</div>
            <?php endif; ?>
          </div>

          <?php if ( $badge ) : ?>
            <span class="prod-badge"><?php echo esc_html( $badge ); ?></span>
          <?php endif; ?>

          <div class="prod-name"><?php the_title(); ?></div>
          <div class="prod-desc"><?php echo wp_kses_post( get_the_content() ); ?></div>
          <div class="prod-price"><?php echo esc_html( $price ); ?></div>
          <a href="<?php echo esc_url( home_url( $link ) ); ?>" class="btn-sm">View details →</a>

        </div>

      <?php
          endwhile;
          wp_reset_postdata();
      else : ?>
        <p style="color:var(--mist)">No products yet — check back soon.</p>
      <?php endif; ?>

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
        'category_name'  => 'Recipe',
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

      <?php
      $merch = new WP_Query( array(
          'post_type'      => 'vegama_merch',
          'posts_per_page' => 5,
          'post_status'    => 'publish',
          'orderby'        => 'menu_order',
          'order'          => 'ASC',
      ) );

      if ( $merch->have_posts() ) :
          while ( $merch->have_posts() ) : $merch->the_post();
              $price = get_post_meta( get_the_ID(), '_merch_price', true );
              $link  = get_post_meta( get_the_ID(), '_merch_link',  true );
      ?>

        <div class="mc">
          <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'medium', array(
                'style' => 'width:100%;aspect-ratio:1;object-fit:cover;border-radius:10px;margin-bottom:12px;display:block;'
            ) ); ?>
          <?php endif; ?>
          <div class="mc-name"><?php the_title(); ?></div>
          <div class="mc-price"><?php echo esc_html( $price ); ?></div>
          <a href="<?php echo esc_url( home_url( $link ) ); ?>" class="mc-add">Add to cart</a>
        </div>

      <?php
          endwhile;
          wp_reset_postdata();
      else : ?>
        <p style="color:var(--mist)">No merch yet — check back soon.</p>
      <?php endif; ?>

    </div>
  </div>
</section>
  
<!-- Testimonials -->
<section id="testimonials" class="sec sec-dark">
  <div class="sec-inner">
    <p class="sec-eye">Community</p>
    <h2 class="sec-h">Real voices from <em>the table.</em></h2>
    <div class="testi-grid">

      <?php
      $testimonials = new WP_Query( array(
          'post_type'      => 'vegama_testimonial',
          'posts_per_page' => 6,
          'post_status'    => 'publish',
          'orderby'        => 'menu_order',
          'order'          => 'ASC',
      ) );

      if ( $testimonials->have_posts() ) :
          while ( $testimonials->have_posts() ) : $testimonials->the_post();
              $quote  = get_post_meta( get_the_ID(), '_testimonial_quote',  true );
              $author = get_post_meta( get_the_ID(), '_testimonial_author', true );
              $stars  = get_post_meta( get_the_ID(), '_testimonial_stars',  true ) ?: 5;
      ?>

        <div class="tc">
          <div class="tc-stars"><?php echo str_repeat( '★', intval( $stars ) ); ?></div>
          <p class="tc-q">"<?php echo esc_html( $quote ); ?>"</p>
          <p class="tc-a"><?php echo esc_html( $author ); ?></p>
        </div>

      <?php
          endwhile;
          wp_reset_postdata();
      else : ?>
        <p style="color:var(--mist)">No testimonials yet.</p>
      <?php endif; ?>

    </div>
  </div>
</section>

      <!-- Newsletter -->
    <section id="newsletter">
  <div class="nl-inner">
    <h2 class="nl-h">Plant-based recipes<br>in your <em>inbox.</em></h2>
    <p class="nl-sub">Join 2,400+ plant-based cooks across Scandinavia. One seasonal recipe, one story, and early access to new class dates, every Wednesday.</p>
    <form class="nl-form" id="nlForm">
      <input type="email" name="email" placeholder="your@email.com" required>
      <button type="submit">Subscribe</button>
    </form>
    <p id="nlMsg" style="display:none;margin-top:16px;color:var(--sage);font-weight:700;font-size:14px;">
      You're in! Check your inbox every Wednesday.
    </p>
  </div>
  <script>
  document.getElementById('nlForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var data = new FormData(this);
    fetch('https://api.simplyforms.app/v1/forms/0DsXtVUU08iTF4IFtyv6KQ', {
      method: 'POST',
      body: data
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
      if (res.success) {
        document.getElementById('nlForm').style.display = 'none';
        document.getElementById('nlMsg').style.display = 'block';
      }
    });
  });
  </script>
</section>

</main>

<?php get_footer(); ?>