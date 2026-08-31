<?php get_header(); ?>
    <?php if (have_posts()): // Check if there are any posts ?>
        <?php while (have_posts()): the_post(); // Start the WordPress Loop and set up the current post ?>

            <?php
            $title = get_the_title(); // Get the title of the current post and store it in the $title variable
            $date = get_the_date(); // Get the publication date of the current post and store it in the $date variable
            $author = get_the_author(); // Get the author of the current post and store it in the $author variable
            $content = get_the_content(); // Get the content of the current post and store it in the $content variable
            $categories = get_the_category(); // Get all categories assigned to the current post and store them in $categories
            $tags = get_the_tags(); // Get all tags assigned to the current post and store them in $tags
            ?>

            <article class="single-post">
                <div class="single-post-header">
                    <span class="post-date"><?php echo esc_html($date); // Output the post date ?></span>
                    <h1 class="post-title"><?php echo esc_html($title); // Output the post title ?></h1>
                    <p class="post-author">By <?php echo esc_html($author); // Output the post author's name ?></p>
                </div>

                <?php if (has_post_thumbnail()): // Check if the post has a featured image ?>
                    <div class="single-post-image">
                        <?php the_post_thumbnail('large'); // Output the featured image ?>
                    </div>
                <?php endif; ?>

                <div class="single-post-content">
                    <?php echo $content; // Output the post content (already HTML from the editor, so not escaped) ?>
                </div>

                <?php if ($categories): // Check if the post has any categories ?>
                    <div class="single-post-categories">
                        <?php foreach ($categories as $category): // Loop through each category ?>
                            <a href="<?php echo get_category_link($category->term_id); // Link to that category's archive ?>">
                                <?php echo esc_html($category->name); // Output the category name ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($tags): // Check if the post has any tags ?>
                    <div class="single-post-tags">
                        <?php foreach ($tags as $tag): // Loop through each tag ?>
                            <a href="<?php echo get_tag_link($tag->term_id); // Link to that tag's archive ?>" class="badge rounded-pill text-bg-primary">
                                <?php echo esc_html($tag->name); // Output the tag name ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>

            <?php
            // Load comments.php from the theme, which handles displaying
            // existing comments and the form to submit a new one
            comments_template();
            ?>

        <?php endwhile; // End the loop ?>
    <?php endif; ?>
<?php get_footer(); ?>