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
    <div class="rec-header">
      <div>
        <p class="sec-eye">Masterclasses</p>
        <h2 class="sec-h">Everything you need to cook <em>tastefully.</em></h2>
      </div>
      <a href="<?php echo esc_url( home_url( '/classes' ) ); ?>" class="btn-sm">All dates →</a>
    </div>
    <div class="prod-grid">

      <?php
      $classes   = function_exists( 'vegama_get_upcoming_classes' ) ? vegama_get_upcoming_classes( 3 ) : array();
      $gift_card = function_exists( 'wc_get_products' ) ? wc_get_products( array(
          'status'   => 'publish',
          'category' => array( 'gift-cards' ),
          'limit'    => 1,
      ) ) : array();

      if ( ! $classes ) : ?>
        <p style="color:var(--mist)">New masterclass dates are coming soon.</p>
      <?php endif;

      foreach ( array_merge( $classes, $gift_card ) as $product ) :
          $is_class = in_array( $product, $classes, true );
          $badge    = $is_class ? wp_date( 'D j M', strtotime( $product->get_meta( '_vegama_class_date' ) . ' 12:00' ) ) : 'Gift card';
          $action   = $is_class ? 'Book a seat' : 'Buy a gift card';
      ?>

        <div class="prod-card">

          <div class="prod-img">
            <?php if ( $product->get_image_id() ) : ?>
              <?php echo $product->get_image( 'medium' ); ?>
            <?php else : ?>
              <div class="prod-img-placeholder">🌿</div>
            <?php endif; ?>
          </div>

          <span class="prod-badge"><?php echo esc_html( $badge ); ?></span>

          <div class="prod-name"><?php echo esc_html( $product->get_name() ); ?></div>
          <div class="prod-desc"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $product->get_short_description() ), 22 ) ); ?></div>
          <div class="prod-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
          <?php if ( $product->is_in_stock() ) : ?>
            <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="btn-sm"
              aria-label="<?php echo esc_attr( $action . ': ' . $product->get_name() ); ?>"><?php echo esc_html( $action ); ?> →</a>
          <?php else : ?>
            <p class="prod-desc">Sold out</p>
          <?php endif; ?>

        </div>

      <?php endforeach; ?>

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
      // Find the recipe category regardless of whether slug is 'recipe' or 'recipes'
      $recipe_cat = get_category_by_slug( 'recipes' ) ?: get_category_by_slug( 'recipe' );
      $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 8,
        'post_status'    => 'publish',
      );
      if ( $recipe_cat ) {
        $args['cat'] = $recipe_cat->term_id;
      }
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
      $merch_cats = get_terms( array(
          'taxonomy'   => 'product_cat',
          'fields'     => 'slugs',
          'hide_empty' => true,
      ) );
      $merch_cats = is_wp_error( $merch_cats ) ? array() : array_diff( $merch_cats, array( 'masterclasses', 'gift-cards', 'uncategorized' ) );
      $merch = ( $merch_cats && function_exists( 'wc_get_products' ) ) ? wc_get_products( array(
          'status'   => 'publish',
          'category' => array_values( $merch_cats ),
          'limit'    => 10,
          'orderby'  => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
      ) ) : array();

      if ( $merch ) :
          foreach ( $merch as $product ) :
      ?>

        <div class="mc">
          <?php if ( $product->get_image_id() ) : ?>
            <div class="mc-img">
            <?php echo $product->get_image( 'medium' ); ?>
          </div>
          <?php endif; ?>
          <div class="mc-name"><?php echo esc_html( $product->get_name() ); ?></div>
          <div class="mc-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
          <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="mc-add">View product</a>
        </div>

      <?php
          endforeach;
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
           <div class="tc-author">
            <?php if ( has_post_thumbnail() ) : ?>
              <div class="tc-avatar-wrap">
            <?php the_post_thumbnail( 'thumbnail' ); ?>
          </div>
          <?php else : ?>
          <?php $initial = strtoupper( substr( $author, 0, 1 ) ); ?>
          <span class="tc-avatar"><?php echo esc_html( $initial ); ?></span>
            <?php endif; ?>
            <p class="tc-a"><?php echo esc_html( $author ); ?></p>
        </div>
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
          <label for="nl-email" class="screen-reader-text">Email address</label>
      <input type="email" id="nl-email" name="email" placeholder="your@email.com" required>
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