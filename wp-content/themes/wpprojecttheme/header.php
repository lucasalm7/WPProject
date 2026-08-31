<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="logo">
    <a href="<?php echo esc_url(home_url('/')); ?>">
<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logovegama.png" alt="<?php bloginfo('name'); ?>">
    </a>
 </div>

    <nav class="main-nav">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'container' => false,
        ]);
        ?>
    </nav>

    <div class="header-actions">
        <!-- Cart icon: links to cart page once WooCommerce is active -->
        <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_cart_url() : '#'); ?>" class="cart-icon">
            🛒
        </a>
        <!-- Login/account button: WooCommerce account page if available, otherwise WP login -->
        <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url()); ?>" class="login-btn">
            <?php echo is_user_logged_in() ? 'My account' : 'Log in'; ?>
        </a>
    </div>
</header>