<?php get_header(); ?>
    <?php if (have_posts()): // Check if there are any posts ?>
        <?php while (have_posts()): the_post(); // Start the loop and set up the current post ?>
            <?php
            $title = get_the_title(); // Get the title of the current post and store it in $title
            $content = get_the_content(); // Get the content of the current post and store it in $content
            ?>
            <main>
                <h1><?php echo esc_html($title); // Output the post title ?></h1>
                <div><?php echo $content; // Output the post content (already HTML, not escaped) ?></div>
            </main>
        <?php endwhile; // End the loop ?>
    <?php endif; ?>
<?php get_footer(); ?>