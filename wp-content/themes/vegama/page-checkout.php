<?php get_header() ?>
<main id="main" class="sec shop-flow">
  <div class="sec-inner">
    <span class="sec-eye">Almost there</span>
    <h1 class="sec-h">Check<em>out</em></h1>
    <?php echo do_shortcode( '[woocommerce_checkout]' ); ?>
  </div>
</main>
<?php get_footer() ?>