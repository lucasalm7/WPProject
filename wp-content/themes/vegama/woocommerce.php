<?php get_header(); ?>

<?php if ( is_product() ) : ?>
<main id="main" class="sec sec-dark product-page">
  <div class="sec-inner">
    <?php woocommerce_content(); ?>
  </div>
</main>
<?php else : ?>
  <?php woocommerce_content(); ?>
<?php endif; ?>

<?php get_footer(); ?>
