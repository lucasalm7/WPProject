<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header" id="site-header">
  <nav class="site-nav">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo" rel="home">
      <svg class="nav-mark" viewBox="39 37 200 200" width="38" height="38" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
        <circle cx="138.8" cy="137.4" r="99.5" fill="#f4eedc"/>
        <path fill="#185f30" d="M170.6,96.6h0c-1.1-.3-2.4-.5-3.5-.8-.1,0-.2,0-.3-.2,1.1-4.5,6.2-6,9.6-8.4,1.9-1.4,2.8-2.3,2.2-4.8-.7-3-3-6.9-6.6-6.5-1.3.1-3.5,1.3-4.7,1.9-4,2.2-7.5,5.1-10.8,8.2,1.1-4.1,2.6-8,4.2-12,.5-1.3,1.2-2.6,1.6-3.9.6-1.6,1.3-3.1-.3-4.5-1.3-1.2-8-4-9.8-4.2-1.5,0-2,.7-2.7,1.8-1.4,2.3-2.4,5.3-3.6,7.7-1.5,3.1-3.1,6.1-4.9,9-.3.2-.5-.7-.5-.9-.7-3.4-.6-7.5-1.1-11-.1-.9-.2-1.8-1-2.4-1.5-1-7.5-.4-9.2.4-1.1.5-1.5,1.1-1.7,2.3-.4,2.2-.5,5.1-.7,7.3-.2,2.2,0,4.9-.5,6.9,0,.2,0,.2-.2.1-2.8-6.7-4-14-6.3-20.9-.5-1.4-.9-2.9-2.4-3.4-2.4-.9-9.4-.9-11.7,0-2.1.8-2.9,2.2-2.4,4.4.7,3.6,2.6,7.7,3.6,11.4.9,3.5,1.5,7.1,1.6,10.7v3.9l-.5,5.3c-9,3.3-15.1,11.4-16.4,20.8-.5,3.6-.5,7.3,0,10.8,0,.6.1,1.3.3,1.8,2,12.1,8.8,23.5,17.5,31.7,6.1,5.7,13.9,11.4,20.8,16.1,2.6,1.7,6.2,4.4,9.4,4.2,3.9-.3,11.5-6.1,14.8-8.6,13.5-9.8,24.7-20.6,29.7-37.1.4-1.4.8-2.8,1.1-4.2h0c0-.1,0-.3,0-.4v.3c2.6-13.2-.7-28.4-14.8-33.2h0Z"/>
      </svg>
      <div>
        <span class="nav-wrd"><span class="veg">veg</span><span class="ama">ama</span></span>
        <span class="nav-sub">PLANT KITCHEN</span>
      </div>
    </a>
     <ul class="nav-links">
      <li><a href="<?php echo esc_url( home_url( '/shop' ) ); ?>">Shop</a></li>
      <li><a href="<?php echo esc_url( home_url( '/recipes' ) ); ?>">Blog</a></li>
      <li><a href="<?php echo esc_url( home_url( '/blog' ) ); ?>">Recipes</a></li>
      <li><a href="<?php echo esc_url( home_url( '/classes' ) ); ?>">Classes</a></li>
      <li><a href="<?php echo esc_url( home_url( '/corporate' ) ); ?>">Corporate</a></li>
    </ul>
        <div class="nav-right">
      <a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart' ) ); ?>" class="cart-btn" aria-label="Cart">
        🛒<span class="cart-badge" id="cartBadge">0</span>
      </a>
      <a href="<?php echo esc_url( wp_login_url() ); ?>" class="btn-nav">Sign in</a>
    </div>
  </nav>
  <script>
    const hd = document.getElementById('site-header');
    window.addEventListener('scroll', () => {
      hd.classList.toggle('solid', window.scrollY > 20);
    });
  </script>
</header>