<footer class="site-footer">
  <div class="ft-inner">
    <div class="ft-brand">
      <span class="logo-veg">veg</span><span class="logo-ama">ama</span>
      <p>Plant-based food from Copenhagen.</p>
    </div>
    <nav class="ft-nav">
      <?php wp_nav_menu( [ 'theme_location' => 'primary', 'menu_class' => 'ft-links', 'container' => false, 'depth' => 1 ] ); ?>
    </nav>
    <p class="ft-copy">&copy; <?php echo date( 'Y' ); ?> Vegama Plant Kitchen</p>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>