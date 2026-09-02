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

// ── Products CPT ─────────────────────────────────────────────
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
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-cart',
        'menu_position'      => 5,
        'supports'           => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
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

// ── Merch CPT ────────────────────────────────────────────────
function vegama_register_merch_cpt() {
    register_post_type( 'vegama_merch', array(
        'labels' => array(
            'name'               => 'Merch',
            'singular_name'      => 'Merch Item',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Merch Item',
            'edit_item'          => 'Edit Merch Item',
            'not_found'          => 'No merch items found',
            'not_found_in_trash' => 'No merch items found in Trash',
        ),
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-tag',
        'menu_position'      => 6,
        'supports'           => array( 'title', 'thumbnail' ),
    ) );
}
add_action( 'init', 'vegama_register_merch_cpt' );

function vegama_merch_meta_box() {
    add_meta_box(
        'vegama_merch_details',
        'Merch Details',
        'vegama_merch_meta_box_html',
        'vegama_merch',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'vegama_merch_meta_box' );

function vegama_merch_meta_box_html( $post ) {
    wp_nonce_field( 'vegama_merch_save', 'vegama_merch_nonce' );
    $price = get_post_meta( $post->ID, '_merch_price', true );
    $link  = get_post_meta( $post->ID, '_merch_link',  true );
    ?>
    <p>
        <label for="merch_price"><strong>Price</strong> (e.g. €35)</label><br>
        <input type="text" id="merch_price" name="merch_price" value="<?php echo esc_attr( $price ); ?>" style="width:100%">
    </p>
    <p>
        <label for="merch_link"><strong>Link</strong> (e.g. /shop)</label><br>
        <input type="text" id="merch_link" name="merch_link" value="<?php echo esc_attr( $link ); ?>" style="width:100%">
    </p>
    <?php
}

function vegama_merch_save_meta( $post_id ) {
    if ( ! isset( $_POST['vegama_merch_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['vegama_merch_nonce'], 'vegama_merch_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['merch_price'] ) )
        update_post_meta( $post_id, '_merch_price', sanitize_text_field( $_POST['merch_price'] ) );
    if ( isset( $_POST['merch_link'] ) )
        update_post_meta( $post_id, '_merch_link',  sanitize_text_field( $_POST['merch_link'] ) );
}
add_action( 'save_post', 'vegama_merch_save_meta' );

// ── Testimonials CPT ─────────────────────────────────────────
function vegama_register_testimonial_cpt() {
    register_post_type( 'vegama_testimonial', array(
        'labels' => array(
            'name'               => 'Testimonials',
            'singular_name'      => 'Testimonial',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Testimonial',
            'edit_item'          => 'Edit Testimonial',
            'not_found'          => 'No testimonials found',
            'not_found_in_trash' => 'No testimonials found in Trash',
        ),
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-format-quote',
        'menu_position'      => 7,
        'supports'           => array( 'title' ),
    ) );
}
add_action( 'init', 'vegama_register_testimonial_cpt' );

function vegama_testimonial_meta_box() {
    add_meta_box(
        'vegama_testimonial_details',
        'Testimonial Details',
        'vegama_testimonial_meta_box_html',
        'vegama_testimonial',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'vegama_testimonial_meta_box' );

function vegama_testimonial_meta_box_html( $post ) {
    wp_nonce_field( 'vegama_testimonial_save', 'vegama_testimonial_nonce' );
    $quote  = get_post_meta( $post->ID, '_testimonial_quote',  true );
    $author = get_post_meta( $post->ID, '_testimonial_author', true );
    $stars  = get_post_meta( $post->ID, '_testimonial_stars',  true );
    ?>
    <p>
        <label for="testimonial_quote"><strong>Quote</strong></label><br>
        <textarea id="testimonial_quote" name="testimonial_quote" rows="4" style="width:100%"><?php echo esc_textarea( $quote ); ?></textarea>
    </p>
    <p>
        <label for="testimonial_author"><strong>Author</strong> (e.g. Mia K., Copenhagen)</label><br>
        <input type="text" id="testimonial_author" name="testimonial_author" value="<?php echo esc_attr( $author ); ?>" style="width:100%">
    </p>
    <p>
        <label for="testimonial_stars"><strong>Stars</strong> (1–5)</label><br>
        <input type="number" id="testimonial_stars" name="testimonial_stars" value="<?php echo esc_attr( $stars ?: 5 ); ?>" min="1" max="5" style="width:80px">
    </p>
    <?php
}

function vegama_testimonial_save_meta( $post_id ) {
    if ( ! isset( $_POST['vegama_testimonial_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['vegama_testimonial_nonce'], 'vegama_testimonial_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['testimonial_quote'] ) )
        update_post_meta( $post_id, '_testimonial_quote',  sanitize_textarea_field( $_POST['testimonial_quote'] ) );
    if ( isset( $_POST['testimonial_author'] ) )
        update_post_meta( $post_id, '_testimonial_author', sanitize_text_field( $_POST['testimonial_author'] ) );
    if ( isset( $_POST['testimonial_stars'] ) )
        update_post_meta( $post_id, '_testimonial_stars',  absint( $_POST['testimonial_stars'] ) );
}
add_action( 'save_post', 'vegama_testimonial_save_meta' );