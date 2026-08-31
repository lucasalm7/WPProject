<!DOCTYPE html>
<html <?php language_attributes(); // Output language attributes for the <html> tag ?>>
<head>
    <meta charset="<?php bloginfo('charset'); // Output the site's character encoding ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); // Hook required by WordPress and plugins to inject styles/scripts into <head> ?>
</head>
<body <?php body_class(); // Output dynamic body classes (page type, etc.) ?>>
<?php wp_body_open(); // Hook required by WordPress right after the opening <body> tag ?>

<?php
$site_name = get_bloginfo('name'); // Get the site's name and store it in $site_name
$home_url = home_url('/'); // Get the site's home URL and store it in $home_url
$logo_url = get_template_directory_uri() . '/assets/img/logovegama.png'; // Build the path to the logo image
$is_logged_in = is_user_logged_in(); // Check if the current visitor is logged in
$account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url(); // Get the WooCommerce account URL if available, otherwise the default login URL
$cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#'; // Get the WooCommerce cart URL if available
?>

<header class="site-header">
    <div class="logo">
        <a href="<?php echo esc_url($home_url); // Output the home URL, escaped for safe HTML output ?>">
            <img src="<?php echo esc_url($logo_url); // Output the logo image path, escaped ?>" alt="<?php echo esc_attr($site_name); // Output the site name as the image's alt text ?>">
        </a>
    </div>

    <nav class="main-nav">
        <?php
        wp_nav_menu([ // Output the menu assigned to the 'primary' location
            'theme_location' => 'primary',
            'container' => false,
        ]);
        ?>
    </nav>

    <div class="header-actions">
        <a href="<?php echo esc_url($cart_url); // Output the cart URL, escaped ?>" class="cart-icon">🛒</a>
        <a href="<?php echo esc_url($account_url); // Output the account/login URL, escaped ?>" class="login-btn">
            <?php echo $is_logged_in ? 'My account' : 'Log in'; // Show different label depending on login status ?>
        </a>
    </div>
</header>