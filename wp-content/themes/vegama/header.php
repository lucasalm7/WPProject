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
      <span class="logo-veg">veg</span><span class="logo-ama">ama</span>
    </a>
    <?php wp_nav_menu( [ 'theme_location' => 'primary', 'menu_class' => 'nav-links', 'container' => false ] ); ?>
    <a href="#" class="btn-nav">Cart (0)</a>
  </nav>
</header>