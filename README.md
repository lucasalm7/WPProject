# Vegama Plant Kitchen — WordPress Theme

Custom WordPress theme for Vegama, a Danish plant based food brand.
Built with pure PHP/CSS.

## Tech Stack
- WordPress 
- PHP templates
- Vanilla CSS 
- Vanilla JS

## Folder Structure
wp-content/themes/vegama/
├── style.css          # Theme header (required by WP)
├── functions.php      # Enqueue scripts/styles
├── index.php          # Main template
├── header.php         # Site header + nav
├── footer.php         # Site footer
└── assets/
    ├── css/main.css   # All styles
    └── js/main.js     # All scripts

## Local Setup
1. Clone repo
2. Copy `wp-content/themes/vegama/` to your LocalWP site
3. Activate theme in WP Admin → Appearance → Themes

## Branch Strategy
- `main` — stable, production-ready
- `develop` — active development
- `feature/xxx` — individual features