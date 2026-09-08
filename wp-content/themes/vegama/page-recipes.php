<?php get_header(); ?>

<section class="sec sec-dark" id="blog-listing">
    <div class="sec-inner">
        <span class="sec-eye">The Journal</span>
        <h1 class="sec-h">Vegama <em>Recipes</em></h1>

        <?php
        $selected_tag = isset($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '';
        $all_tags = get_tags(['hide_empty' => true]); 
        ?>

        <div class="recipe-filters">
            <a href="<?php echo esc_url(remove_query_arg('tag')); ?>"
               class="cat-pill <?php echo $selected_tag === '' ? 'active' : '';  ?>">
                All
            </a>
            <?php foreach ($all_tags as $tag): ?>
                <a href="<?php echo esc_url(add_query_arg('tag', $tag->slug));  ?>"
                   class="cat-pill <?php echo $selected_tag === $tag->slug ? 'active' : '';  ?>">
                    <?php echo esc_html($tag->name); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php
        $query_args = [ 
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 12,
            'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
        ];
        if ($selected_tag !== '') { 
            $query_args['tag'] = $selected_tag;
        }
        $recipes_query = new WP_Query($query_args);
        ?>

        <div class="blog-grid">
            <?php if ($recipes_query->have_posts()): ?>
                <?php while ($recipes_query->have_posts()): $recipes_query->the_post(); ?>
                    <?php
                    $title = get_the_title(); 
                    $excerpt = get_the_excerpt();
                    $permalink = get_permalink(); 
                    $date = get_the_date();
                    $categories = get_the_category(); 
                    $category_name = !empty($categories) ? $categories[0]->name : ''; 
                    ?>
                    <a href="<?php echo esc_url($permalink);  ?>" class="pc">
                        <div class="pc-thumb">
                            <?php if (has_post_thumbnail()):  ?>
                                <?php the_post_thumbnail('medium', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                            <?php else: ?>
                                🥗
                            <?php endif; ?>
                        </div>
                        <div class="pc-body">
                            <?php if ($category_name):  ?>
                                <div class="pc-tag"><?php echo esc_html($category_name);  ?></div>
                            <?php endif; ?>
                            <h3 class="pc-title"><?php echo esc_html($title); ?></h3>
                            <p class="pc-excerpt"><?php echo esc_html(wp_trim_words($excerpt, 20));  ?></p>
                            <div class="pc-meta"><?php echo esc_html($date); ?></div>
                        </div>
                    </a>
                <?php endwhile;  ?>
            <?php else: ?>
                <p>No recipes match this filter.</p>
            <?php endif; ?>
        </div>

        <div class="blog-pagination">
            <?php
            echo paginate_links([ 
                'total'   => $recipes_query->max_num_pages,
                'current' => max(1, get_query_var('paged')),
            ]);
            ?>
        </div>

        <?php wp_reset_postdata();?>
    </div>
</section>

<?php get_footer(); ?>