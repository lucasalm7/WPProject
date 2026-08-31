<?php

// Enqueue styles and fonts
function wppproject_enqueue_assets() {
wp_enqueue_style('wppproject-fonts', 'https://fonts.googleapis.com/css2?family=Bagel+Fat+One&family=Poppins:wght@400;500;600&display=swap', [], null);    wp_enqueue_style('wppproject-style', get_stylesheet_uri(), [], '1.0');
}
add_action('wp_enqueue_scripts', 'wppproject_enqueue_assets');

// Theme support
function wppproject_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    register_nav_menus([
        'primary' => 'Main Menu',
    ]);
}
add_action('after_setup_theme', 'wppproject_theme_setup');