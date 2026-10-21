<?php get_header() ?>
<main id="main" class="sec shop-flow">
  <div class="sec-inner">
    <span class="sec-eye">Your order</span>
    <h1 class="sec-h">Your <em>cart</em></h1>
    <?php echo do_shortcode( '[woocommerce_cart]' ); ?>
  </div>
</main>
<?php get_footer() ?>