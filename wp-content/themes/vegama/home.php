<?php get_header(); ?>

<section class="sec sec-dark" id="blog-listing">
    <div class="sec-inner">
        <span class="sec-eye">The Journal</span>
        <h1 class="sec-h">Vegama <em>Blog</em></h1>

        <div class="blog-grid">
            <?php if (have_posts()):?>
                <?php while (have_posts()): the_post();?>
                    <?php
                    $title = get_the_title(); 
                    $excerpt = get_the_excerpt(); 
                    $permalink = get_permalink(); 
                    $date = get_the_date();
                    $categories = get_the_category(); 
                    $category_name = !empty($categories) ? $categories[0]->name : ''; 
                    ?>
                    <a href="<?php echo esc_url($permalink); ?>" class="pc">
                        <div class="pc-thumb">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('medium', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                            <?php else: ?>
                                🥗
                            <?php endif; ?>
                        </div>
                        <div class="pc-body">
                            <?php if ($category_name): ?>
                                <div class="pc-tag"><?php echo esc_html($category_name);?></div>
                            <?php endif; ?>
                            <h3 class="pc-title"><?php echo esc_html($title); ?></h3>
                            <p class="pc-excerpt"><?php echo esc_html(wp_trim_words($excerpt, 20)); ?></p>
                            <div class="pc-meta"><?php echo esc_html($date);?></div>
                        </div>
                    </a>
                <?php endwhile;?>
            <?php else: ?>
                <p>No posts yet.</p>
            <?php endif; ?>
        </div>

        <?php
        $older_link = get_next_posts_link('← Older posts');
        $newer_link = get_previous_posts_link('Newer posts →');
        ?>
        <div class="blog-pagination">
            <?php if ($newer_link):?>
                <?php echo $newer_link;?>
            <?php endif; ?>
            <?php if ($older_link):?>
                <?php echo $older_link;?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>