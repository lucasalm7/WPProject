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

    wp_enqueue_style( 'vegama-fonts', 'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,700;0,9..144,900;1,9..144,400;1,9..144,700;1,9..144,900&family=Nunito:wght@400;500;600;700;800&display=swap', [], null );

    // Main base stylesheet
    $css( 'vegama-style', 'main.css', [ 'vegama-fonts' ] );

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
    if ( is_page( [ 'about', 'sustainability', 'contact-us', 'classes' ] ) || is_404() || ( function_exists( 'is_account_page' ) && is_account_page() ) ) {
        $css( 'vegama-about', 'about.css' );
    }
    if ( function_exists( 'is_account_page' ) && is_account_page() ) {
        $css( 'vegama-account', 'account.css', [ 'vegama-about', 'vegama-woocommerce' ] );
    }
    if ( is_page( 'contact-us' ) ) {
        $css( 'vegama-contact', 'contact.css', [ 'vegama-about' ] );
    }
    if ( is_page( 'classes' ) ) {
        $css( 'vegama-classes', 'classes.css', [ 'vegama-about' ] );
    }
    if ( is_home() || is_archive() || is_search() ) {
        $css( 'vegama-blog', 'blog.css' );
    }
    if ( is_home() ) {
        $css( 'vegama-recipes', 'recipes.css' );
    }
    if ( is_singular( 'post' ) ) {
        $css( 'vegama-single', 'single.css' );
    }

    if ( class_exists( 'WooCommerce' ) ) {
        wp_enqueue_script( 'wc-cart-fragments' );
    }

    wp_enqueue_script( 'vegama-js', $uri . '/assets/js/main.js', [], filemtime( $dir . '/assets/js/main.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'vegama_scripts' );

function vegama_font_hints( $urls, $relation ) {
    if ( 'preconnect' === $relation ) {
        $urls[] = 'https://fonts.googleapis.com';
        $urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'vegama_font_hints', 10, 2 );

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

function vegama_cart_badge() {
    $count = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
    return '<span class="cart-badge' . ( $count ? ' on' : '' ) . '" id="cartBadge">' . esc_html( $count ) . '</span>';
}

function vegama_cart_badge_fragment( $fragments ) {
    $fragments['#cartBadge'] = vegama_cart_badge();
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'vegama_cart_badge_fragment' );

function vegama_account_menu( $items ) {
    $labels = array(
        'dashboard'       => 'Overview',
        'orders'          => 'Orders and bookings',
        'downloads'       => 'My e-books',
        'edit-address'    => 'Addresses',
        'edit-account'    => 'Account details',
        'customer-logout' => 'Sign out',
    );
    foreach ( $labels as $key => $label ) {
        if ( isset( $items[ $key ] ) ) {
            $items[ $key ] = $label;
        }
    }
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'vegama_account_menu' );

function vegama_account_classes() {
    $orders = wc_get_orders( array(
        'customer_id' => get_current_user_id(),
        'status'      => array( 'processing', 'completed', 'on-hold' ),
        'limit'       => 50,
    ) );

    $classes = array();
    foreach ( $orders as $order ) {
        foreach ( $order->get_items() as $item ) {
            $product = $item->get_product();
            if ( ! $product || ! has_term( 'masterclasses', 'product_cat', $product->get_id() ) ) {
                continue;
            }
            $date = $product->get_meta( '_vegama_class_date' );
            if ( ! $date || $date < current_time( 'Y-m-d' ) ) {
                continue;
            }
            $classes[] = array(
                'name'  => $product->get_name(),
                'date'  => $date,
                'time'  => $product->get_meta( '_vegama_class_time' ),
                'seats' => $item->get_quantity(),
            );
        }
    }
    usort( $classes, function ( $a, $b ) {
        return strcmp( $a['date'], $b['date'] );
    } );
    ?>
    <div class="account-classes">
        <h2>Your upcoming masterclasses</h2>
        <?php if ( $classes ) : ?>
            <ul>
                <?php foreach ( $classes as $class ) :
                    $stamp = strtotime( $class['date'] . ' 12:00' );
                    $meta  = array_filter( array(
                        $class['time'],
                        'Esbjerg',
                        sprintf( _n( '%d seat', '%d seats', $class['seats'], 'vegama' ), $class['seats'] ),
                    ) );
                ?>
                    <li>
                        <time class="account-classes__date" datetime="<?php echo esc_attr( $class['date'] ); ?>">
                            <span><?php echo esc_html( wp_date( 'D', $stamp ) ); ?></span>
                            <b><?php echo esc_html( wp_date( 'j', $stamp ) ); ?></b>
                            <span><?php echo esc_html( wp_date( 'M', $stamp ) ); ?></span>
                        </time>
                        <div class="account-classes__info">
                            <strong><?php echo esc_html( $class['name'] ); ?></strong>
                            <span><?php echo esc_html( implode( ' · ', $meta ) ); ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p>The address is in your confirmation email. Can't make it? <a href="<?php echo esc_url( home_url( '/contact-us/#cancellation' ) ); ?>">Cancel for free</a> up to 7 days before.</p>
        <?php else : ?>
            <p class="account-classes__empty">No masterclasses booked yet. <a href="<?php echo esc_url( home_url( '/classes' ) ); ?>">See the next dates in Esbjerg</a>.</p>
        <?php endif; ?>
    </div>
    <?php
}
add_action( 'woocommerce_account_dashboard', 'vegama_account_classes' );

function vegama_account_signup_link() {
    if ( is_user_logged_in() || ! get_option( 'users_can_register' ) ) {
        return;
    }
    ?>
    <p class="account-signup">New to Vegama?
        <button type="button" onclick="openMo('moLogin'); switchTab('up', document.querySelectorAll('#moLogin .tab-b')[1]);">Create an account</button>
    </p>
    <?php
}
add_action( 'woocommerce_after_customer_login_form', 'vegama_account_signup_link' );

function vegama_direct_checkout( $url, $product = null ) {
    if ( $product instanceof WC_Product && has_term( array( 'masterclasses', 'gift-cards' ), 'product_cat', $product->get_id() ) ) {
        return wc_get_checkout_url();
    }
    return $url;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'vegama_direct_checkout', 10, 2 );

function vegama_is_class( $product ) {
    return $product instanceof WC_Product && has_term( 'masterclasses', 'product_cat', $product->get_id() );
}

function vegama_class_is_past( $product ) {
    $date = $product->get_meta( '_vegama_class_date' );
    return $date && $date < current_time( 'Y-m-d' );
}

function vegama_class_purchasable( $purchasable, $product ) {
    if ( vegama_is_class( $product ) && vegama_class_is_past( $product ) ) {
        return false;
    }
    return $purchasable;
}
add_filter( 'woocommerce_is_purchasable', 'vegama_class_purchasable', 10, 2 );

function vegama_class_button_text( $text, $product = null ) {
    if ( vegama_is_class( $product ) && $product->is_purchasable() && $product->is_in_stock() ) {
        return 'Book a seat';
    }
    return $text;
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'vegama_class_button_text', 10, 2 );
add_filter( 'woocommerce_product_add_to_cart_text', 'vegama_class_button_text', 10, 2 );

// Accessibility (WCAG 2.5.3 Label in Name): the hidden button name must contain the visible text "Book a seat".
function vegama_class_button_description( $description, $product = null ) {
    if ( vegama_is_class( $product ) && $product->is_purchasable() && $product->is_in_stock() ) {
        return sprintf( 'Book a seat: %s', $product->get_name() );
    }
    return $description;
}
add_filter( 'woocommerce_product_add_to_cart_description', 'vegama_class_button_description', 10, 2 );

function vegama_class_facts() {
    global $product;
    if ( ! vegama_is_class( $product ) ) {
        return;
    }
    $date  = $product->get_meta( '_vegama_class_date' );
    $time  = $product->get_meta( '_vegama_class_time' );
    $seats = $product->managing_stock() ? (int) $product->get_stock_quantity() : null;
    ?>
    <ul class="class-facts">
        <?php if ( $date ) : ?>
            <li><time datetime="<?php echo esc_attr( $date ); ?>"><?php echo esc_html( wp_date( 'l j F Y', strtotime( $date . ' 12:00' ) ) ); ?></time></li>
        <?php endif; ?>
        <?php if ( $time ) : ?>
            <li><?php echo esc_html( $time ); ?></li>
        <?php endif; ?>
        <li>Esbjerg</li>
        <?php if ( vegama_class_is_past( $product ) ) : ?>
            <li>This class has taken place</li>
        <?php elseif ( $product->is_in_stock() && null !== $seats ) : ?>
            <li><?php echo esc_html( sprintf( _n( '%d seat left', '%d seats left', $seats, 'vegama' ), $seats ) ); ?></li>
        <?php endif; ?>
    </ul>
    <?php
}
add_action( 'woocommerce_single_product_summary', 'vegama_class_facts', 6 );

function vegama_class_note() {
    global $product;
    if ( ! vegama_is_class( $product ) ) {
        return;
    }
    ?>
    <div class="class-note">
        <?php if ( vegama_class_is_past( $product ) ) : ?>
            <p><a href="<?php echo esc_url( home_url( '/classes' ) ); ?>">See the next masterclass dates</a></p>
        <?php else : ?>
            <p>Price includes all ingredients, aprons and VAT. Free cancellation up to 7 days before the class.</p>
            <p>Giving it as a present? <a href="<?php echo esc_url( home_url( '/classes' ) ); ?>#classes-gift">Buy a gift card</a> · Questions? <a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>">Contact us</a></p>
        <?php endif; ?>
    </div>
    <?php
}
add_action( 'woocommerce_single_product_summary', 'vegama_class_note', 35 );

function vegama_handle_newsletter() {
    if (
        ! isset( $_POST['vegama_newsletter_nonce'] ) ||
        ! wp_verify_nonce(
            sanitize_text_field( wp_unslash( $_POST['vegama_newsletter_nonce'] ) ),
            'vegama_newsletter'
        )
    ) {
        wp_send_json_error(
            array( 'message' => 'Security check failed. Please refresh the page and try again.' ),
            403
        );
    }

    $pdf = get_template_directory_uri() . '/assets/downloads/vegama-5-weeknight-dinners.pdf';

    if ( ! empty( $_POST['vegama_website'] ) ) {
        wp_send_json_success( array( 'message' => 'Almost done! Check your inbox and confirm your email address.' ) );
    }

    $email = sanitize_email( wp_unslash( $_POST['vegama_email'] ?? '' ) );

    if ( empty( $email ) || ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid email address.' ), 422 );
    }

    if ( empty( $_POST['vegama_consent'] ) ) {
        wp_send_json_error( array( 'message' => 'Please tick the box to agree to receive the newsletter.' ), 422 );
    }

    if ( ! class_exists( '\MailPoet\API\API' ) ) {
        wp_send_json_error( array( 'message' => 'The newsletter is not available right now. Please try again later.' ), 503 );
    }

    try {
        $mailpoet = \MailPoet\API\API::MP( 'v1' );
        $list_ids = array();
        foreach ( $mailpoet->getLists() as $list ) {
            if ( 'default' === $list['type'] ) {
                $list_ids[] = $list['id'];
                break;
            }
        }
        $mailpoet->addSubscriber( array( 'email' => $email ), $list_ids );
    } catch ( \Exception $e ) {
        if ( 12 === $e->getCode() ) {
            wp_send_json_success( array( 'message' => 'You are already on the list. Here are your free recipes again.', 'download' => $pdf ) );
        }
        wp_send_json_error( array( 'message' => 'Something went wrong. Please try again later.' ), 500 );
    }

    wp_send_json_success( array( 'message' => 'Here are your free recipes. Check your inbox to confirm your subscription.', 'download' => $pdf ) );
}
add_action( 'wp_ajax_vegama_newsletter', 'vegama_handle_newsletter' );
add_action( 'wp_ajax_nopriv_vegama_newsletter', 'vegama_handle_newsletter' );

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

    if ( ! empty( $_POST['vegama_website'] ) ) {
        wp_send_json_success( array( 'message' => 'Thanks! We reply within 24 hours.' ) );
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
function vegama_page_seo() {
    $pages = array(
        'classes'        => array( 'Plant-based cooking classes in Esbjerg | Vegama', 'Hands-on plant-based cooking evenings in Esbjerg for up to 10 people. Cook a seasonal menu, eat together and take the recipes home. From 395 kr.' ),
        'contact-us'     => array( 'Contact Vegama | Classes, e-books and orders', 'Questions about a masterclass, an e-book or an order? Pick a topic and we reply within 24 hours. Delivery, returns and gift cards in our FAQ.' ),
        'about'          => array( 'About Vegama | Plant-based cooking from Esbjerg', 'Vegama is a small plant-based kitchen in Esbjerg. We make easy recipes, e-books and cooking classes for people who want to eat more plants.' ),
        'sustainability' => array( 'Sustainability at Vegama | Seasonal, low-waste cooking', 'How we cook with the Danish seasons, waste less food and put plants first in our recipes, e-books and cooking classes in Esbjerg.' ),
    );

    if ( is_front_page() ) {
        return array( 'Vegama | Easy plant-based dinners & classes in Esbjerg', "You don't have to go vegan. Easy plant-based dinner recipes, e-books and hands-on cooking classes in Esbjerg. Get 5 weeknight dinners free." );
    }
    if ( function_exists( 'is_shop' ) && is_shop() ) {
        return array( 'Plant-based e-books, cooking classes and merch | Vegama', 'Plant-based e-books with easy dinners, cooking class seats in Esbjerg, gift cards, aprons, spices and tote bags. Prices in DKK.' );
    }
    if ( is_home() ) {
        return array( 'Easy plant-based recipes and guides | Vegama blog', 'Easy plant-based dinner recipes in grams and °C with allergens, and guides to cooking with plants in Denmark.' );
    }
    if ( is_page() ) {
        $slug = get_post_field( 'post_name', get_queried_object_id() );
        if ( isset( $pages[ $slug ] ) ) {
            return $pages[ $slug ];
        }
    }
    return array( '', '' );
}

function vegama_seo_title( $title ) {
    if ( is_singular() && ! is_front_page() ) {
        $custom = get_post_meta( get_queried_object_id(), 'seo_title', true );
        if ( $custom ) {
            return $custom;
        }
    }
    $seo = vegama_page_seo();
    return $seo[0] ? $seo[0] : $title;
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

    $seo = vegama_page_seo();

    if ( $seo[1] ) {
        $desc = $seo[1];
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

    $is_article = is_singular( 'post' );
    $site       = esc_attr( get_bloginfo( 'name' ) );

    if ( is_front_page() ) {
        $url   = esc_url( home_url( '/' ) );
        $title = esc_attr( $seo[0] );
    } elseif ( is_singular() ) {
        $url   = esc_url( get_permalink() );
        $title = esc_attr( get_post_meta( get_queried_object_id(), 'seo_title', true ) ?: ( $seo[0] ? $seo[0] : get_the_title() ) );
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

function vegama_print_schema( $schema ) {
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}

function vegama_class_event( $product ) {
    $date = $product->get_meta( '_vegama_class_date' );
    if ( ! $date ) {
        return null;
    }
    $tz    = wp_timezone();
    $start = new DateTime( $date . ' 17:30', $tz );
    $end   = new DateTime( $date . ' 20:30', $tz );
    if ( preg_match( '/(\d{1,2}:\d{2})\s*[–-]\s*(\d{1,2}:\d{2})/u', (string) $product->get_meta( '_vegama_class_time' ), $m ) ) {
        $start = new DateTime( $date . ' ' . $m[1], $tz );
        $end   = new DateTime( $date . ' ' . $m[2], $tz );
    }
    $image = wp_get_attachment_image_url( $product->get_image_id(), 'large' );

    return array(
        '@context'            => 'https://schema.org',
        '@type'               => 'Event',
        'name'                => $product->get_name(),
        'description'         => wp_strip_all_tags( $product->get_short_description() ),
        'startDate'           => $start->format( 'c' ),
        'endDate'             => $end->format( 'c' ),
        'eventStatus'         => 'https://schema.org/EventScheduled',
        'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
        'location'            => array(
            '@type'   => 'Place',
            'name'    => 'Vegama kitchen',
            'address' => array( '@type' => 'PostalAddress', 'addressLocality' => 'Esbjerg', 'addressCountry' => 'DK' ),
        ),
        'image'               => $image ? array( $image ) : array(),
        'organizer'           => array( '@type' => 'Organization', 'name' => 'Vegama', 'url' => home_url( '/' ) ),
        'offers'              => array(
            '@type'         => 'Offer',
            'price'         => $product->get_price(),
            'priceCurrency' => get_woocommerce_currency(),
            'availability'  => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/SoldOut',
            'url'           => $product->get_permalink(),
        ),
    );
}

function vegama_structured_data() {
    if ( is_front_page() ) {
        vegama_print_schema( array(
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => 'Vegama',
            'url'      => home_url( '/' ),
            'logo'     => get_template_directory_uri() . '/assets/img/og-default.jpg',
            'address'  => array( '@type' => 'PostalAddress', 'addressLocality' => 'Esbjerg', 'addressCountry' => 'DK' ),
            'sameAs'   => array( 'https://instagram.com/vegama' ),
        ) );
    }

    if ( function_exists( 'is_product' ) && is_product() ) {
        $product = wc_get_product( get_queried_object_id() );
        if ( vegama_is_class( $product ) && ! vegama_class_is_past( $product ) ) {
            $event = vegama_class_event( $product );
            if ( $event ) {
                vegama_print_schema( $event );
            }
        }
    }

    if ( is_page( 'classes' ) && function_exists( 'vegama_get_upcoming_classes' ) ) {
        foreach ( vegama_get_upcoming_classes() as $class ) {
            $event = vegama_class_event( $class );
            if ( $event ) {
                vegama_print_schema( $event );
            }
        }
    }

    if ( is_page( 'contact-us' ) ) {
        $questions = array();
        foreach ( vegama_faqs() as $faq ) {
            $questions[] = array(
                '@type'          => 'Question',
                'name'           => $faq['q'],
                'acceptedAnswer' => array( '@type' => 'Answer', 'text' => implode( ' ', $faq['a'] ) ),
            );
        }
        vegama_print_schema( array(
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $questions,
        ) );
    }
}
add_action( 'wp_head', 'vegama_structured_data', 11 );

/**
 * Prints a theme photo from assets/images with its real width and height.
 *
 * @param string $file File name in assets/images.
 * @param string $alt  Alt text.
 */
function vegama_photo( $file, $alt ) {
	$size = wp_getimagesize( get_template_directory() . '/assets/images/' . $file );
	printf(
		'<img src="%s" alt="%s"%s loading="lazy" decoding="async">',
		esc_url( get_template_directory_uri() . '/assets/images/' . $file ),
		esc_attr( $alt ),
		$size ? sprintf( ' width="%d" height="%d"', $size[0], $size[1] ) : ''
	);
}

function vegama_faqs() {
    return array(
        array( 'id' => 'delivery', 'q' => 'How long does delivery take, and what does it cost?', 'a' => array(
            'We send merch and spices within Denmark. Your order leaves our kitchen within 2 working days, and the shipping price is shown at checkout before you pay.',
            'E-books arrive straight away by email and under My account. Masterclasses need no delivery: you get the address in your confirmation email.',
        ) ),
        array( 'id' => 'returns', 'q' => 'Can I return something?', 'a' => array(
            'Yes. For merch and spices you have 14 days from delivery to change your mind. Write to us through the form above, then send the item back unused. We refund the full price, including the standard shipping, within 14 days. The return shipping is paid by you.',
            'E-books cannot be returned once the download has started, because you get the file straight away. If a file does not work, write to us and we fix it.',
        ) ),
        array( 'id' => 'cancellation', 'q' => 'Can I cancel a masterclass booking?', 'a' => array(
            'Yes, free of charge up to 7 days before the class. Write to us and we refund you or move you to another date.',
            'Classes on a fixed date are not covered by the 14-day right of withdrawal, so after that we cannot refund the seat.',
        ) ),
        array( 'id' => 'gift-card', 'q' => 'How does the gift card work?', 'a' => array(
            'After you pay, we email you a personal code within 24 hours. The person you give it to picks any masterclass date and enters the code at checkout. The code is valid for 12 months.',
        ) ),
        array( 'id' => 'allergies', 'q' => 'I have an allergy. Can I still join a class?', 'a' => array(
            'Yes. Everything we cook is plant-based. Write your allergies in the order notes at checkout, and we adapt the dishes or tell you before the class if we cannot.',
        ) ),
        array( 'id' => 'ebooks', 'q' => 'Where do I find my e-book?', 'a' => array(
            'In your order email, and under My account → My e-books whenever you are signed in.',
        ) ),
    );
}

remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

function vegama_security_headers() {
    if ( is_admin() ) {
        return;
    }
    header( 'X-Content-Type-Options: nosniff' );
    header( 'X-Frame-Options: SAMEORIGIN' );
    header( 'Referrer-Policy: strict-origin-when-cross-origin' );
    header( 'Permissions-Policy: camera=(), microphone=(), geolocation=()' );
}
add_action( 'send_headers', 'vegama_security_headers' );

function vegama_block_author_scans() {
    if ( ! is_user_logged_in() && isset( $_GET['author'] ) ) {
        wp_safe_redirect( home_url( '/' ), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'vegama_block_author_scans', 1 );

function vegama_hide_user_endpoints( $endpoints ) {
    if ( ! is_user_logged_in() ) {
        unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
    }
    return $endpoints;
}
add_filter( 'rest_endpoints', 'vegama_hide_user_endpoints' );

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
        'user_login'    => sanitize_text_field( wp_unslash( $_POST['log'] ?? '' ) ),
        'user_password' => wp_unslash( $_POST['pwd'] ?? '' ),
        'remember'      => true,
    ];
    $user = wp_signon( $creds, false );
    if ( is_wp_error( $user ) ) {
        if ( 0 === strpos( (string) $user->get_error_code(), 'wfls_' ) ) {
            wp_send_json_error( 'This account uses two-factor authentication. Please sign in on the My account page.' );
        }
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
    $username = sanitize_user( wp_unslash( $_POST['user_login'] ?? '' ) );
    $email    = sanitize_email( wp_unslash( $_POST['user_email'] ?? '' ) );
    $password = wp_unslash( $_POST['user_pass'] ?? '' );
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

function vegama_remove_comment_url_field($fields) {
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields', 'vegama_remove_comment_url_field');

// The Recipes page is now a filter on the Blog page: /recipes/ → /blog/?type=recipe (301).
function vegama_redirect_recipes_to_blog() {
    if ( is_page( 'recipes' ) && get_option( 'page_for_posts' ) ) {
        wp_safe_redirect( add_query_arg( 'type', 'recipe', get_permalink( get_option( 'page_for_posts' ) ) ), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'vegama_redirect_recipes_to_blog' );



// Accessibility (best practice "content missing after heading"): our product descriptions start with their own H2,
// so remove WooCommerce's extra "Description" H2 inside the tab.
add_filter( 'woocommerce_product_description_heading', '__return_null' );