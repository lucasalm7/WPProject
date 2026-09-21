<?php
function vegama_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    register_nav_menus( [ 'primary' => __( 'Primary Menu', 'vegama' ) ] );
}
add_action( 'after_setup_theme', 'vegama_setup' );

function vegama_scripts() {
    wp_enqueue_style( 'vegama-style', get_template_directory_uri() . '/assets/css/main.css', [], '1.0.0' );
    wp_enqueue_script( 'vegama-js', get_template_directory_uri() . '/assets/js/main.js', [], '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'vegama_scripts' );

function vegama_about_page_template( $template ) {
    if ( is_page( 'about' ) ) {
        $custom_template = locate_template( array( 'page-about.php' ) );
        if ( $custom_template ) {
            return $custom_template;
        }
    }
    return $template;
}
add_filter( 'template_include', 'vegama_about_page_template' );

function vegama_handle_about_form() {
    if ( ! isset( $_POST['vegama_about_submit'] ) ) {
        return;
    }

    if ( ! isset( $_POST['vegama_about_nonce'] ) || ! wp_verify_nonce( $_POST['vegama_about_nonce'], 'vegama_about_form' ) ) {
        wp_die( 'Security check failed.' );
    }

    $full_name = sanitize_text_field( wp_unslash( $_POST['full_name'] ?? '' ) );
    $email     = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
    $company   = sanitize_text_field( wp_unslash( $_POST['company'] ?? '' ) );
    $person    = sanitize_text_field( wp_unslash( $_POST['contact_person'] ?? '' ) );
    $website   = esc_url_raw( wp_unslash( $_POST['website'] ?? '' ) );
    $message   = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

    if ( empty( $full_name ) || empty( $email ) || empty( $message ) ) {
        return;
    }

    $to      = get_option( 'admin_email' );
    $subject = 'New Vegama inquiry from ' . $full_name;

    $body = '
        <h3>New contact form submission</h3>
        <p><strong>Full name:</strong> ' . esc_html( $full_name ) . '</p>
        <p><strong>Email:</strong> ' . esc_html( $email ) . '</p>
        <p><strong>Company / Brand:</strong> ' . esc_html( $company ) . '</p>
        <p><strong>Contact person:</strong> ' . esc_html( $person ) . '</p>
        <p><strong>Website:</strong> ' . esc_url( $website ) . '</p>
        <p><strong>Message:</strong><br>' . nl2br( esc_html( $message ) ) . '</p>
    ';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $full_name . ' <' . $email . '>',
    );

    wp_mail( $to, $subject, $body, $headers );
}
add_action( 'init', 'vegama_handle_about_form' );

function vegama_seo_meta() {
    global $post;

    if ( is_singular() && $post ) {
        $desc = get_post_meta( $post->ID, '_meta_description', true );
        if ( ! $desc ) {
            $desc = has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 25, '…' );
        }
    } elseif ( is_home() || is_front_page() ) {
        $desc = 'Plant-based recipes, artisan cookbooks, and vegan cooking masterclasses in Esbjerg, Denmark.';
    } else {
        $desc = get_bloginfo( 'description' );
    }
    $desc = esc_attr( wp_strip_all_tags( $desc ) );

    $og_image = '';
    if ( is_singular() && has_post_thumbnail() ) {
        $img      = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
        $og_image = $img ? esc_url( $img[0] ) : '';
    }
    if ( ! $og_image ) {
        $og_image = esc_url( get_template_directory_uri() . '/assets/img/og-default.jpg' );
    }

    $url   = esc_url( get_permalink() ?: home_url( '/' ) );
    $title = esc_attr( get_the_title() ?: get_bloginfo( 'name' ) );
    $site  = esc_attr( get_bloginfo( 'name' ) );

    echo '<meta name="description" content="' . $desc . '">' . "\n";
    echo '<link rel="canonical" href="' . $url . '">' . "\n";
    echo '<meta property="og:type"        content="' . ( is_singular() ? 'article' : 'website' ) . '">' . "\n";
    echo '<meta property="og:url"         content="' . $url . '">' . "\n";
    echo '<meta property="og:title"       content="' . $title . '">' . "\n";
    echo '<meta property="og:description" content="' . $desc . '">' . "\n";
    echo '<meta property="og:image"       content="' . $og_image . '">' . "\n";
    echo '<meta property="og:site_name"   content="' . $site . '">' . "\n";
    echo '<meta property="og:locale"      content="en_DK">' . "\n";
    echo '<meta name="twitter:card"        content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title"       content="' . $title . '">' . "\n";
    echo '<meta name="twitter:description" content="' . $desc . '">' . "\n";
    echo '<meta name="twitter:image"       content="' . $og_image . '">' . "\n";
}
add_action( 'wp_head', 'vegama_seo_meta', 5 );

function vegama_recipe_schema() {
    if ( ! is_singular( 'post' ) ) return;

    global $post;

    $recipe_cat = get_category_by_slug( 'recipes' ) ?: get_category_by_slug( 'recipe' );
    if ( $recipe_cat ) {
        $in = false;
        foreach ( get_the_category( $post->ID ) as $cat ) {
            if ( $cat->term_id === $recipe_cat->term_id ) { $in = true; break; }
        }
        if ( ! $in ) return;
    }

    $image_url = '';
    if ( has_post_thumbnail( $post->ID ) ) {
        $img       = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
        $image_url = $img ? $img[0] : '';
    }

    $schema = array(
        '@context'       => 'https://schema.org',
        '@type'          => 'Recipe',
        'name'           => get_the_title( $post->ID ),
        'description'    => wp_strip_all_tags( wp_trim_words( get_the_content(), 30, '…' ) ),
        'datePublished'  => get_the_date( 'c', $post->ID ),
        'author'         => array( '@type' => 'Person', 'name' => get_the_author_meta( 'display_name', $post->post_author ) ),
        'url'            => get_permalink( $post->ID ),
        'publisher'      => array( '@type' => 'Organization', 'name' => get_bloginfo( 'name' ), 'url' => home_url( '/' ) ),
        'recipeCategory' => 'Vegan',
        'recipeCuisine'  => 'Plant-based',
        'keywords'       => 'vegan, plant-based, recipe, Denmark',
    );
    if ( $image_url ) $schema['image'] = array( $image_url );

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'vegama_recipe_schema', 10 );