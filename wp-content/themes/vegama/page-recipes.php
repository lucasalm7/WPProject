<?php get_header(); ?>

<section class="sec sec-dark" id="blog-listing">
    <div class="sec-inner">
        <span class="sec-eye">The Journal</span>
        <h1 class="sec-h">Vegama <em>Recipes</em></h1>

        <?php
        // Read the selected tag from the URL, if any
        $selected_tag = isset($_GET['tag']) ? sanitize_text_field($_GET['tag']) : ''; // Get the tag slug from the URL
        $all_tags = get_tags(['hide_empty' => true]); // Get all tags that have at least one post
        ?>

        <!-- Tag filter -->
        <div class="recipe-filters">
            <a href="<?php echo esc_url(remove_query_arg('tag')); // Link that clears the tag filter ?>"
               class="cat-pill <?php echo $selected_tag === '' ? 'active' : ''; // Highlight if no tag is selected ?>">
                All
            </a>
            <?php foreach ($all_tags as $tag): // Loop through each tag ?>
                <a href="<?php echo esc_url(add_query_arg('tag', $tag->slug)); // Build a link that adds this tag to the URL ?>"
                   class="cat-pill <?php echo $selected_tag === $tag->slug ? 'active' : ''; // Highlight if this tag is selected ?>">
                    <?php echo esc_html($tag->name); // Output the tag name ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php
        $query_args = [ // Build the query arguments based on the selected filter
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 12,
            'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
        ];
        if ($selected_tag !== '') { // If a tag filter is active, add it to the query
            $query_args['tag'] = $selected_tag;
        }
        $recipes_query = new WP_Query($query_args); // Run the filtered query
        ?>

        <div class="blog-grid">
            <?php if ($recipes_query->have_posts()): // Check if the query found any posts ?>
                <?php while ($recipes_query->have_posts()): $recipes_query->the_post(); // Loop through each post ?>
                    <?php
                    $title = get_the_title(); // Get the post title and store it in $title
                    $excerpt = get_the_excerpt(); // Get the post excerpt and store it in $excerpt
                    $permalink = get_permalink(); // Get the post's URL and store it in $permalink
                    $date = get_the_date(); // Get the post's publish date and store it in $date
                    $categories = get_the_category(); // Get the post's categories and store them in $categories
                    $category_name = !empty($categories) ? $categories[0]->name : ''; // Get the first category name, or empty string if none
                    ?>
                    <a href="<?php echo esc_url($permalink); // Output the post URL, escaped ?>" class="pc">
                        <div class="pc-thumb">
                            <?php if (has_post_thumbnail()): // Check if the post has a featured image ?>
                                <?php the_post_thumbnail('medium', ['style' => 'width:100%;height:100%;object-fit:cover;']); // Output the featured image, filling the thumbnail box ?>
                            <?php else: ?>
                                🥗
                            <?php endif; ?>
                        </div>
                        <div class="pc-body">
                            <?php if ($category_name): // Only show a tag if there's a category ?>
                                <div class="pc-tag"><?php echo esc_html($category_name); // Output the category name ?></div>
                            <?php endif; ?>
                            <h3 class="pc-title"><?php echo esc_html($title); // Output the post title ?></h3>
                            <p class="pc-excerpt"><?php echo esc_html(wp_trim_words($excerpt, 20)); // Output a shortened excerpt ?></p>
                            <div class="pc-meta"><?php echo esc_html($date); // Output the publish date ?></div>
                        </div>
                    </a>
                <?php endwhile; // End the loop ?>
            <?php else: ?>
                <p>No recipes match this filter.</p>
            <?php endif; ?>
        </div>

        <div class="blog-pagination">
            <?php
            echo paginate_links([ // Output pagination links, keeping the active filter in the URL
                'total'   => $recipes_query->max_num_pages,
                'current' => max(1, get_query_var('paged')),
            ]);
            ?>
        </div>

        <?php wp_reset_postdata(); // Restore the original global post data after our custom query ?>
    </div>
</section>

<?php get_footer(); ?>