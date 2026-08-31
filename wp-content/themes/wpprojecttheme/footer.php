<?php
$site_name = get_bloginfo('name'); // Get the site's name and store it in $site_name
$current_year = date('Y'); // Get the current year and store it in $current_year
?>

<footer class="site-footer">
    <p>&copy; <?php echo esc_html($current_year); // Output the current year ?> <?php echo esc_html($site_name); // Output the site name ?>. All rights reserved.</p>
</footer>

<?php wp_footer(); // Hook required by WordPress and plugins to inject scripts before </body> ?>
</body>
</html>