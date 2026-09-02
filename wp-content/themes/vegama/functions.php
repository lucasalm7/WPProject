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