<?php
get_header();

$classes = vegama_get_upcoming_classes();

$gift_cards = function_exists( 'wc_get_products' ) ? wc_get_products( array(
    'status'   => 'publish',
    'category' => array( 'gift-cards' ),
    'limit'    => 1,
) ) : array();
$gift_card = $gift_cards ? $gift_cards[0] : null;
?>

<main id="main" class="about-page classes-page">
    <section class="about-hero"><div class="about-hero__inner">
        <p class="sec-eye">Masterclasses</p>
        <h1>Cook it <em>with us.</em></h1>
        <p>Hands-on plant-based cooking evenings in Esbjerg. Cook three dishes in pairs,
            then we sit down and eat together. Up to 10 people per class.</p>
    </div></section>

    <section class="classes-wrap" aria-labelledby="classes-title">
        <p class="sec-eye sec-eye--dark">Upcoming dates</p>
        <h2 id="classes-title" class="classes-h">Book a <em>seat.</em></h2>

        <?php if ( $classes ) : ?>
            <ul class="class-list">
                <?php foreach ( $classes as $class ) :
                    $date  = $class->get_meta( '_vegama_class_date' );
                    $time  = $class->get_meta( '_vegama_class_time' );
                    $stamp = strtotime( $date . ' 12:00' );
                    $seats = $class->managing_stock() ? (int) $class->get_stock_quantity() : null;
                ?>
                    <li class="class-card">
                        <time class="class-date" datetime="<?php echo esc_attr( $date ); ?>">
                            <span class="class-date__day"><?php echo esc_html( wp_date( 'D', $stamp ) ); ?></span>
                            <span class="class-date__num"><?php echo esc_html( wp_date( 'j', $stamp ) ); ?></span>
                            <span class="class-date__month"><?php echo esc_html( wp_date( 'M', $stamp ) ); ?></span>
                        </time>
                        <div class="class-info">
                            <h3><?php echo esc_html( $class->get_name() ); ?></h3>
                            <?php if ( $class->get_short_description() ) : ?>
                                <p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $class->get_short_description() ), 30 ) ); ?></p>
                            <?php endif; ?>
                            <p class="class-meta">
                                <?php if ( $time ) : ?>
                                    <span><?php echo esc_html( $time ); ?></span>
                                <?php endif; ?>
                                <span>Esbjerg</span>
                                <?php if ( $class->is_in_stock() && null !== $seats ) : ?>
                                    <span><?php echo esc_html( sprintf( _n( '%d seat left', '%d seats left', $seats, 'vegama' ), $seats ) ); ?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="class-buy">
                            <span class="class-price"><?php echo wp_kses_post( $class->get_price_html() ); ?></span>
                            <?php if ( $class->is_in_stock() ) : ?>
                                <a class="btn-primary" href="<?php echo esc_url( $class->add_to_cart_url() ); ?>"
                                    aria-label="<?php echo esc_attr( 'Book a seat: ' . $class->get_name() . ', ' . wp_date( 'j F', $stamp ) ); ?>">Book a seat</a>
                            <?php else : ?>
                                <span class="class-soldout">Sold out</span>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p class="classes-empty">New dates are coming soon.
                <a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>">Contact us</a> to hear about them first.</p>
        <?php endif; ?>
    </section>

    <section class="about-layout classes-layout">
        <div class="about-card">
            <p class="sec-eye sec-eye--dark">Good to know</p>
            <h2>Before you book</h2>
            <ul>
                <li>All classes take place in Esbjerg. You get the address in your confirmation email.</li>
                <li>The price includes all ingredients, aprons and moms. You take the recipes home.</li>
                <li>Everything we cook is plant-based. Tell us about allergies in the order notes at checkout.</li>
                <li>Free cancellation up to 7 days before the class.</li>
                <li>Questions? <a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>">Contact us</a>.</li>
            </ul>
        </div>
        <?php if ( $gift_card ) : ?>
            <div class="about-card class-gift">
                <p class="sec-eye sec-eye--dark">Gift card</p>
                <h2>Give a masterclass</h2>
                <p>A seat at the table for someone you like to cook for. They choose the date themselves.</p>
                <p class="class-price"><?php echo wp_kses_post( $gift_card->get_price_html() ); ?></p>
                <a class="btn-primary btn-primary--dark" href="<?php echo esc_url( $gift_card->add_to_cart_url() ); ?>">Buy a gift card</a>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php get_footer();
