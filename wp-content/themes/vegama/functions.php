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

// ── Auth: AJAX Login ─────────────────────────────────────────
add_action( 'wp_ajax_nopriv_vegama_login', 'vegama_handle_login' );
function vegama_handle_login() {
    check_ajax_referer( 'vegama_login', 'login_nonce' );
    $creds = [
        'user_login'    => sanitize_text_field( $_POST['log'] ),
        'user_password' => $_POST['pwd'],
        'remember'      => true,
    ];
    $user = wp_signon( $creds, false );
    if ( is_wp_error( $user ) ) {
        wp_send_json_error( 'Wrong username or password.' );
    }
    wp_send_json_success();
}

// ── Auth: AJAX Register ──────────────────────────────────────
add_action( 'wp_ajax_nopriv_vegama_register', 'vegama_handle_register' );
function vegama_handle_register() {
    check_ajax_referer( 'vegama_register', 'register_nonce' );
    if ( ! get_option( 'users_can_register' ) ) {
        wp_send_json_error( 'Registration is currently closed.' );
    }
    $username = sanitize_user( $_POST['user_login'] );
    $email    = sanitize_email( $_POST['user_email'] );
    $password = $_POST['user_pass'];
    $id = wp_create_user( $username, $password, $email );
    if ( is_wp_error( $id ) ) {
        wp_send_json_error( $id->get_error_message() );
    }
    wp_set_auth_cookie( $id );
    wp_send_json_success();
}

function vegama_register_product_cpt() {
    register_post_type( 'vegama_product', array(
        'labels' => array(
            'name'               => 'Products',
            'singular_name'      => 'Product',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Product',
            'edit_item'          => 'Edit Product',
            'new_item'           => 'New Product',
            'view_item'          => 'View Product',
            'search_items'       => 'Search Products',
            'not_found'          => 'No products found',
            'not_found_in_trash' => 'No products found in Trash',
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-cart',
        'supports'     => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
        'menu_position' => 5,
    ) );
}
add_action( 'init', 'vegama_register_product_cpt' );


function vegama_product_meta_box() {
    add_meta_box(
        'vegama_product_details',
        'Product Details',
        'vegama_product_meta_box_html',
        'vegama_product',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'vegama_product_meta_box' );

function vegama_product_meta_box_html( $post ) {
    wp_nonce_field( 'vegama_product_save', 'vegama_product_nonce' );
    $badge = get_post_meta( $post->ID, '_product_badge', true );
    $price = get_post_meta( $post->ID, '_product_price', true );
    $link  = get_post_meta( $post->ID, '_product_link',  true );
    ?>
    <p>
        <label for="product_badge"><strong>Badge</strong> (e.g. Bestseller, New)</label><br>
        <input type="text" id="product_badge" name="product_badge" value="<?php echo esc_attr( $badge ); ?>" style="width:100%">
    </p>
    <p>
        <label for="product_price"><strong>Price</strong> (e.g. DKK 299)</label><br>
        <input type="text" id="product_price" name="product_price" value="<?php echo esc_attr( $price ); ?>" style="width:100%">
    </p>
    <p>
        <label for="product_link"><strong>Link</strong> (e.g. /shop/cookbook)</label><br>
        <input type="text" id="product_link" name="product_link" value="<?php echo esc_attr( $link ); ?>" style="width:100%">
    </p>
    <?php
}

function vegama_product_save_meta( $post_id ) {
    if ( ! isset( $_POST['vegama_product_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['vegama_product_nonce'], 'vegama_product_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['product_badge'] ) )
        update_post_meta( $post_id, '_product_badge', sanitize_text_field( $_POST['product_badge'] ) );
    if ( isset( $_POST['product_price'] ) )
        update_post_meta( $post_id, '_product_price', sanitize_text_field( $_POST['product_price'] ) );
    if ( isset( $_POST['product_link'] ) )
        update_post_meta( $post_id, '_product_link',  sanitize_text_field( $_POST['product_link'] ) );
}
add_action( 'save_post', 'vegama_product_save_meta' );