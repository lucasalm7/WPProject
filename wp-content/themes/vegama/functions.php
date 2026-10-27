<?php
function vegama_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    register_nav_menus( [ 'primary' => __( 'Primary Menu', 'vegama' ) ] );
}

// WooCommerce: declare theme support
function vegama_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'vegama_add_woocommerce_support' );
add_action( 'after_setup_theme', 'vegama_setup' );

function vegama_scripts() {
    $dir = get_template_directory();
    $uri = get_template_directory_uri();

    $css = function ( $handle, $file, $deps = [ 'vegama-style' ] ) use ( $dir, $uri ) {
        $path = '/assets/css/' . $file;
        if ( file_exists( $dir . $path ) ) {
            wp_enqueue_style( $handle, $uri . $path, $deps, filemtime( $dir . $path ) );
        }
    };

    // Main base stylesheet
    $css( 'vegama-style', 'main.css', [] );

    // WooCommerce Styles (Loads on all WC pages or single product pages)
    if ( class_exists( 'WooCommerce' ) && ( is_woocommerce() || is_shop() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page() ) ) {
            $css( 'vegama-woocommerce', 'woocommerce.css', [ 'vegama-style' ] );
    }
    if ( class_exists( 'WooCommerce' ) && ( is_cart() || is_checkout() ) ) {
        $css( 'vegama-cart-checkout', 'cart-checkout.css', [ 'vegama-woocommerce' ] );
    }

    if ( is_front_page() ) {
        $css( 'vegama-home', 'home.css' );
    }
    if ( is_page( [ 'about', 'sustainability', 'contact-us', 'classes' ] ) ) {
        $css( 'vegama-about', 'about.css' );
    }
    if ( is_page( 'contact-us' ) ) {
        $css( 'vegama-contact', 'contact.css', [ 'vegama-about' ] );
    }
    if ( is_page( 'classes' ) ) {
        $css( 'vegama-classes', 'classes.css', [ 'vegama-about' ] );
    }
    if ( is_home() || is_archive() || is_search() || is_page( 'recipes' ) ) {
        $css( 'vegama-blog', 'blog.css' );
    }
    if ( is_page( 'recipes' ) ) {
        $css( 'vegama-recipes', 'recipes.css' );
    }
    if ( is_singular( 'post' ) ) {
        $css( 'vegama-single', 'single.css' );
    }

    wp_enqueue_script( 'vegama-js', $uri . '/assets/js/main.js', [], filemtime( $dir . '/assets/js/main.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'vegama_scripts' );

function vegama_about_page_template( $template ) {
    if ( is_page( 'about' ) ) {
        $custom_template = locate_template( array( 'about-page.php' ) );
        if ( $custom_template ) {
            return $custom_template;
        }
    }
    return $template;
}

function vegama_sustainability_page_template( $template ) {
    if ( is_page( 'sustainability' ) ) {
        $custom_template = locate_template( array( 'sustainability.php' ) );

        if ( $custom_template ) {
            return $custom_template;
        }
    }

    return $template;
}

add_filter( 'template_include', 'vegama_sustainability_page_template' );
add_filter( 'template_include', 'vegama_about_page_template' );

function vegama_class_fields() {
    woocommerce_wp_text_input( array(
        'id'          => '_vegama_class_date',
        'label'       => 'Class date',
        'type'        => 'date',
        'desc_tip'    => true,
        'description' => 'Masterclasses only. The class is listed on the Masterclasses page until this date has passed.',
    ) );
    woocommerce_wp_text_input( array(
        'id'          => '_vegama_class_time',
        'label'       => 'Class time',
        'placeholder' => '17:30–20:30',
        'desc_tip'    => true,
        'description' => 'Masterclasses only. Shown next to the date.',
    ) );
}
add_action( 'woocommerce_product_options_general_product_data', 'vegama_class_fields' );

function vegama_save_class_fields( $product ) {
    if ( isset( $_POST['_vegama_class_date'] ) ) {
        $date = sanitize_text_field( wp_unslash( $_POST['_vegama_class_date'] ) );
        $product->update_meta_data( '_vegama_class_date', preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) ? $date : '' );
    }
    if ( isset( $_POST['_vegama_class_time'] ) ) {
        $product->update_meta_data( '_vegama_class_time', sanitize_text_field( wp_unslash( $_POST['_vegama_class_time'] ) ) );
    }
}
add_action( 'woocommerce_admin_process_product_object', 'vegama_save_class_fields' );

function vegama_get_upcoming_classes( $limit = 12 ) {
    if ( ! function_exists( 'wc_get_product' ) ) {
        return array();
    }
    $query = new WP_Query( array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
        'fields'         => 'ids',
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => 'masterclasses',
            ),
        ),
        'meta_key'       => '_vegama_class_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
        'meta_query'     => array(
            array(
                'key'     => '_vegama_class_date',
                'value'   => current_time( 'Y-m-d' ),
                'compare' => '>=',
                'type'    => 'DATE',
            ),
        ),
    ) );
    return array_filter( array_map( 'wc_get_product', $query->posts ) );
}

function vegama_direct_checkout( $url, $product = null ) {
    if ( $product instanceof WC_Product && has_term( array( 'masterclasses', 'gift-cards' ), 'product_cat', $product->get_id() ) ) {
        return wc_get_checkout_url();
    }
    return $url;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'vegama_direct_checkout', 10, 2 );

function vegama_handle_about_form() {
    if ( ! isset( $_POST['action'] ) || 'vegama_about_form' !== $_POST['action'] ) {
        return;
    }

    if (
        ! isset( $_POST['vegama_about_nonce'] ) ||
        ! wp_verify_nonce(
            sanitize_text_field( wp_unslash( $_POST['vegama_about_nonce'] ) ),
            'vegama_about_form'
        )
    ) {
        wp_send_json_error(
            array(
                'message' => 'Security check failed. Please refresh the page and try again.',
            ),
            403
        );
    }

    $main_intent = sanitize_text_field(
        wp_unslash( $_POST['vegama_main_intent'] ?? 'General' )
    );

    $sub_category = sanitize_text_field(
        wp_unslash( $_POST['vegama_sub_category'] ?? 'N/A' )
    );

    $full_name = sanitize_text_field(
        wp_unslash( $_POST['vegama_name'] ?? '' )
    );

    $email = sanitize_email(
        wp_unslash( $_POST['vegama_email'] ?? '' )
    );

    $company = sanitize_text_field(
        wp_unslash( $_POST['vegama_company'] ?? '' )
    );

    $message = sanitize_textarea_field(
        wp_unslash( $_POST['vegama_message'] ?? '' )
    );

    if (
        empty( $full_name ) ||
        ! preg_match( "/^[\p{L}\s'-]{2,}$/u", $full_name )
    ) {
        wp_send_json_error(
            array(
                'field'   => 'vegama_name',
                'message' => 'Please enter a valid name using at least two letters.',
            ),
            422
        );
    }

    if ( empty( $email ) || ! is_email( $email ) ) {
        wp_send_json_error(
            array(
                'field'   => 'vegama_email',
                'message' => 'Please provide a valid email address.',
            ),
            422
        );
    }

    if (
        empty( $message ) ||
        strlen( $message ) < 10 ||
        strlen( $message ) > 1000
    ) {
        wp_send_json_error(
            array(
                'field'   => 'vegama_message',
                'message' => 'Message must be between 10 and 1,000 characters.',
            ),
            422
        );
    }

    if ( empty( $_POST['vegama_gdpr'] ) ) {
        wp_send_json_error(
            array(
                'field'   => 'vegama_gdpr',
                'message' => 'Please confirm your consent before sending the form.',
            ),
            422
        );
    }
    $to      = get_option( 'admin_email' );
    $subject = 'New Vegama Conversational Inquiry: ' . $main_intent;

    $body  = '<h3>New Conversational Contact Form Submission</h3>';
    $body .= '<p><strong>Main Intent:</strong> ' . esc_html( $main_intent ) . '</p>';
    $body .= '<p><strong>Sub-Category / Detail:</strong> ' . esc_html( $sub_category ) . '</p>';

    if ( ! empty( $company ) ) {
        $body .= '<p><strong>Company / Brand:</strong> ' . esc_html( $company ) . '</p>';
    }

    $body .= '<p><strong>Full Name:</strong> ' . esc_html( $full_name ) . '</p>';
    $body .= '<p><strong>Email:</strong> ' . esc_html( $email ) . '</p>';
    $body .= '<p><strong>Message / Details:</strong><br>';
    $body .= nl2br( esc_html( $message ) );
    $body .= '</p>';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $full_name . ' <' . $email . '>',
    );

    if ( ! wp_mail( $to, $subject, $body, $headers ) ) {
        wp_send_json_error(
            array(
                'message' => 'Your message could not be sent. Please try again later.',
            ),
            500
        );
    }

    wp_send_json_success(
        array(
            'message' => 'Thanks! We have received your message and will get back to you within 24-48 hours.',
        )
    );
}

add_action( 'wp_ajax_vegama_about_form', 'vegama_handle_about_form' );
add_action( 'wp_ajax_nopriv_vegama_about_form', 'vegama_handle_about_form' );

// SEO title: a post can set its own <title> with the custom field "_seo_title".
function vegama_seo_title( $title ) {
    if ( is_singular() && ! is_front_page() ) {
               $custom = get_post_meta( get_queried_object_id(), 'seo_title', true );
        if ( $custom ) {
            return $custom;
        }
    }
    return $title;
}
add_filter( 'pre_get_document_title', 'vegama_seo_title' );

// Old date-based URLs (e.g. /2026/08/16/hello-world/) → 301 to the new /blog/ URL.
function vegama_redirect_old_post_urls() {
    if ( ! is_404() ) {
        return;
    }
    $path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
    if ( ! preg_match( '#^\d{4}/\d{2}/\d{2}/([a-z0-9-]+)$#', $path, $m ) ) {
        return;
    }
    $slug  = sanitize_title( $m[1] );
    $found = get_posts( array( 'post_type' => 'post', 'name' => $slug, 'numberposts' => 1 ) );
    if ( ! $found ) {
        // Slug was changed later: WordPress keeps the old one in "_wp_old_slug".
        $found = get_posts( array( 'post_type' => 'post', 'meta_key' => '_wp_old_slug', 'meta_value' => $slug, 'numberposts' => 1 ) );
    }
    if ( $found ) {
        wp_safe_redirect( get_permalink( $found[0] ), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'vegama_redirect_old_post_urls' );

// WordPress prints its own canonical on single pages; we print ours below, so remove the duplicate.
remove_action( 'wp_head', 'rel_canonical' );

function vegama_seo_meta() {
    global $post;

    // The front page is a static page with no content, so it must be checked first.
    if ( is_front_page() ) {
        $desc = 'Plant-based recipes, e-books and cooking masterclasses in Esbjerg, Denmark.';
    } elseif ( is_singular() && $post ) {
        $desc = get_post_meta( $post->ID, '_meta_description', true );
        if ( ! $desc ) {
            // strip_shortcodes: WooCommerce pages (My account, Cart) only contain a shortcode.
            $desc = has_excerpt() ? get_the_excerpt() : wp_trim_words( strip_shortcodes( get_the_content() ), 25, '…' );
        }
    } else {
        $desc = '';
    }
    if ( '' === trim( wp_strip_all_tags( $desc ) ) ) {
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

    $is_article = is_singular() && ! is_front_page();
    $site       = esc_attr( get_bloginfo( 'name' ) );

    if ( is_front_page() ) {
        $url   = esc_url( home_url( '/' ) );
        $title = esc_attr( get_bloginfo( 'name' ) . ' – ' . get_bloginfo( 'description' ) );
    } elseif ( is_singular() ) {
        $url   = esc_url( get_permalink() );
               $title = esc_attr( get_post_meta( get_queried_object_id(), 'seo_title', true ) ?: get_the_title() );
    } else {
        // Archives (e.g. the Shop): no canonical, so we never point to the first product by mistake.
        $url   = '';
        $title = esc_attr( wp_get_document_title() );
    }

    echo '<meta name="description" content="' . $desc . '">' . "\n";
    if ( $url ) {
        echo '<link rel="canonical" href="' . $url . '">' . "\n";
    }
    echo '<meta property="og:type"        content="' . ( $is_article ? 'article' : 'website' ) . '">' . "\n";
    if ( $url ) {
        echo '<meta property="og:url"         content="' . $url . '">' . "\n";
    }
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
        'description'    => wp_strip_all_tags( wp_trim_words( strip_shortcodes( get_the_content() ), 30, '…' ) ),
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

// Article + FAQ schema for blog posts that are NOT recipes (e.g. the campaign post).
// FAQ: every <h3> that ends with "?" becomes a question, the paragraph after it is the answer.
function vegama_article_schema() {
    if ( ! is_singular( 'post' ) ) return;

    global $post;

    $recipe_cat = get_category_by_slug( 'recipes' ) ?: get_category_by_slug( 'recipe' );
    if ( $recipe_cat && in_category( $recipe_cat->term_id, $post ) ) return; // recipes get Recipe schema instead

    $image_url = '';
    if ( has_post_thumbnail( $post->ID ) ) {
        $img       = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
        $image_url = $img ? $img[0] : '';
    }

    $article = array(
        '@context'         => 'https://schema.org',
        '@type'            => 'Article',
        'headline'         => get_the_title( $post->ID ),
        'description'      => wp_strip_all_tags( has_excerpt( $post->ID ) ? get_the_excerpt( $post ) : wp_trim_words( strip_shortcodes( $post->post_content ), 30, '…' ) ),
        'datePublished'    => get_the_date( 'c', $post->ID ),
        'dateModified'     => get_the_modified_date( 'c', $post->ID ),
        'author'           => array( '@type' => 'Organization', 'name' => get_the_author_meta( 'display_name', $post->post_author ) ),
        'publisher'        => array( '@type' => 'Organization', 'name' => get_bloginfo( 'name' ), 'url' => home_url( '/' ) ),
        'mainEntityOfPage' => get_permalink( $post->ID ),
    );
    if ( $image_url ) $article['image'] = array( $image_url );

    $schemas = array( $article );

    // FAQ from the post content
    $faq  = array();
    $html = apply_filters( 'the_content', $post->post_content );
    if ( preg_match_all( '#<h3[^>]*>(.*?)</h3>\s*<p[^>]*>(.*?)</p>#si', $html, $m, PREG_SET_ORDER ) ) {
        foreach ( $m as $pair ) {
            $q = trim( wp_strip_all_tags( $pair[1] ) );
            if ( substr( $q, -1 ) !== '?' ) continue;
            $faq[] = array(
                '@type'          => 'Question',
                'name'           => $q,
                'acceptedAnswer' => array( '@type' => 'Answer', 'text' => trim( wp_strip_all_tags( $pair[2] ) ) ),
            );
        }
    }
    if ( $faq ) {
        $schemas[] = array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $faq );
    }

    foreach ( $schemas as $schema ) {
        echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
    }
}
add_action( 'wp_head', 'vegama_article_schema', 10 );

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
        'supports'           => array( 'title', 'thumbnail' ),
    ) );
}
add_action( 'init', 'vegama_register_testimonial_cpt' );

function vegama_testimonial_meta_box() {
    add_meta_box( 'vegama_testimonial_details', 'Testimonial Details', 'vegama_testimonial_meta_box_html', 'vegama_testimonial', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'vegama_testimonial_meta_box' );

function vegama_testimonial_meta_box_html( $post ) {
    wp_nonce_field( 'vegama_testimonial_save', 'vegama_testimonial_nonce' );
    $quote  = get_post_meta( $post->ID, '_testimonial_quote',  true );
    $author = get_post_meta( $post->ID, '_testimonial_author', true );
    $stars  = get_post_meta( $post->ID, '_testimonial_stars',  true );
    ?>
    <p><label for="testimonial_quote"><strong>Quote</strong></label><br>
    <textarea id="testimonial_quote" name="testimonial_quote" rows="4" style="width:100%"><?php echo esc_textarea( $quote ); ?></textarea></p>
    <p><label for="testimonial_author"><strong>Author</strong> (e.g. Mia K., Copenhagen)</label><br>
    <input type="text" id="testimonial_author" name="testimonial_author" value="<?php echo esc_attr( $author ); ?>" style="width:100%"></p>
    <p><label for="testimonial_stars"><strong>Stars</strong> (1–5)</label><br>
    <input type="number" id="testimonial_stars" name="testimonial_stars" value="<?php echo esc_attr( $stars ?: 5 ); ?>" min="1" max="5" style="width:80px"></p>
    <?php
}

function vegama_testimonial_save_meta( $post_id ) {
    if ( ! isset( $_POST['vegama_testimonial_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['vegama_testimonial_nonce'], 'vegama_testimonial_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
    if ( isset( $_POST['testimonial_quote'] ) ) update_post_meta( $post_id, '_testimonial_quote',  sanitize_textarea_field( $_POST['testimonial_quote'] ) );
    if ( isset( $_POST['testimonial_author'] ) ) update_post_meta( $post_id, '_testimonial_author', sanitize_text_field( $_POST['testimonial_author'] ) );
    if ( isset( $_POST['testimonial_stars'] ) ) update_post_meta( $post_id, '_testimonial_stars',  absint( $_POST['testimonial_stars'] ) );
}
add_action( 'save_post', 'vegama_testimonial_save_meta' );

function vegama_editor_cpt_access() {
    $editor = get_role( 'editor' );
    if ( ! $editor ) return;
    $caps = array(
        'edit_vegama_testimonials',   'edit_others_vegama_testimonials',
        'publish_vegama_testimonials','read_private_vegama_testimonials',
        'delete_vegama_testimonials',
    );
    foreach ( $caps as $cap ) {
        $editor->add_cap( $cap );
    }
}
add_action( 'init', 'vegama_editor_cpt_access' );

function vegama_remove_comment_url_field($fields) {
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields', 'vegama_remove_comment_url_field');