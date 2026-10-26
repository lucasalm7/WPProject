<?php get_header() ?>

<main id="main" class="sec sec-dark">
    <div class="sec-inner">
        <h1 class="sec-h"><?php the_title(); ?></h1>
        <?php echo do_shortcode("[woocommerce_my_account]") ?>
    </div>
</main>

<?php get_footer() ?>