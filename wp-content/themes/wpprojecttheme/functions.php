<?php

// Enqueue styles and fonts
function wppproject_enqueue_assets() {
    $fonts_url = 'https://fonts.googleapis.com/css2?family=Bagel+Fat+One&family=Poppins:wght@400;500;600&display=swap'; // Build the Google Fonts URL and store it in $fonts_url
    wp_enqueue_style('wppproject-fonts', $fonts_url, [], null); // Load the Google Fonts stylesheet
    wp_enqueue_style('wppproject-style', get_stylesheet_uri(), [], '1.0'); // Load the theme's main style.css
}
add_action('wp_enqueue_scripts', 'wppproject_enqueue_assets'); // Run the function above whenever WordPress loads front-end assets

// Theme support
function wppproject_theme_setup() {
    add_theme_support('title-tag'); // Let WordPress manage the <title> tag automatically
    add_theme_support('post-thumbnails'); // Enable featured images on posts/pages
    add_theme_support('custom-logo'); // Enable the custom logo feature
    register_nav_menus([ // Register a menu location called 'primary'
        'primary' => 'Main Menu',
    ]);
}
add_action('after_setup_theme', 'wppproject_theme_setup'); // Run the function above when the theme loads