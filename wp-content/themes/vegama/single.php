<?php get_header(); ?>
    <?php if (have_posts()): // Check if there are any posts ?>
        <?php while (have_posts()): the_post(); // Start the loop and set up the current post ?>

            <?php
            $title = get_the_title(); // Get the post title and store it in $title
            $date = get_the_date(); // Get the publish date and store it in $date
            $author = get_the_author(); // Get the author name and store it in $author
            $content = get_the_content(); // Get the post content and store it in $content
            $categories = get_the_category(); // Get the post's categories and store them in $categories
            $tags = get_the_tags(); // Get the post's tags and store them in $tags
            $category_name = !empty($categories) ? $categories[0]->name : ''; // Get the first category name
            ?>

            <section class="single-post-hero">
                <?php if ($category_name): // Only show if a category exists ?>
                    <span class="pc-tag"><?php echo esc_html($category_name); // Output the category name ?></span>
                <?php endif; ?>
                <h1><?php echo esc_html($title); // Output the post title ?></h1>
                <p class="single-post-meta">
                    <?php echo esc_html($date); // Output the publish date ?> · By <?php echo esc_html($author); // Output the author name ?>
                </p>
            </section>

            <?php if (has_post_thumbnail()): // Check if the post has a featured image ?>
                <div class="single-post-image">
                    <?php the_post_thumbnail('large'); // Output the featured image ?>
                </div>
            <?php endif; ?>

            <div class="single-post-body">
                <?php echo $content; // Output the post content (already HTML, not escaped) ?>
            </div>

            <?php if ($categories || $tags): // Only show this row if there's at least one category or tag ?>
                <div class="single-post-taxonomy">
                    <?php if ($categories): // Loop through categories, if any ?>
                        <?php foreach ($categories as $category): ?>
                            <a href="<?php echo get_category_link($category->term_id); // Link to the category archive ?>">
                                <?php echo esc_html($category->name); // Output the category name ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ($tags): // Loop through tags, if any ?>
                        <?php foreach ($tags as $tag): ?>
                            <a href="<?php echo get_tag_link($tag->term_id); // Link to the tag archive ?>">
                                #<?php echo esc_html($tag->name); // Output the tag name ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php comments_template(); // Load comments.php to show the discussion + comment form ?>

        <?php endwhile; // End the loop ?>
    <?php endif; ?>
<?php get_footer(); ?>