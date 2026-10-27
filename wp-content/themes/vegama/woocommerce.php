<?php get_header(); ?>

<?php if ( is_product() ) : ?>
<main id="main" class="sec sec-dark product-page">
  <div class="sec-inner">
    <?php woocommerce_content(); ?>
  </div>
</main>
<?php else : ?>
  <main id="main"><?php woocommerce_content(); ?></main>
<?php endif; ?>

<?php get_template_part( 'template-parts/media-rich-block' ); ?>

<?php get_footer(); ?>