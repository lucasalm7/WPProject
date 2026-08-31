<?php get_header(); ?>

<!-- Blog hero + search -->
<section class="blog-hero">
    <h1>The Vegama Blog</h1>
    <p>Stories, recipes, and insights from the world of plant-based living</p>
    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="blog-search">
        <input type="search" name="s" placeholder="Search articles..." value="<?php echo get_search_query(); ?>">
        <button type="submit">🔍</button>
    </form>
</section>

<!-- Category filter pills -->
<section class="category-filter">
    <?php
    $categories = get_categories(['hide_empty' => false]);
    ?>
    <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="cat-pill active">All Posts</a>
    <?php foreach ($categories as $cat) : ?>
        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="cat-pill">
            <?php echo esc_html($cat->name); ?> (<?php echo $cat->count; ?>)
        </a>
    <?php endforeach; ?>
</section>

<div class="blog-layout">
    <main class="blog-main">

        <?php
        // Featured article: most recent post
        $featured = new WP_Query(['posts_per_page' => 1]);
        if ($featured->have_posts()) : while ($featured->have_posts()) : $featured->the_post();
        ?>
        <section class="featured-article">
            <h2>Featured Article</h2>
            <div class="featured-card">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="featured-image"><?php the_post_thumbnail('large'); ?></div>
                <?php endif; ?>
                <div class="featured-content">
                    <span class="post-date"><?php echo get_the_date(); ?></span>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
                    <a href="<?php the_permalink(); ?>" class="cta-button">Read Article</a>
                </div>
            </div>
        </section>
        <?php endwhile; wp_reset_postdata(); endif; ?>

        <!-- Recent articles grid -->
        <section class="recent-articles">
            <h2>Recent Articles</h2>
            <div class="articles-grid">
                <?php
                $recent = new WP_Query(['posts_per_page' => 6, 'offset' => 1]);
                if ($recent->have_posts()) : while ($recent->have_posts()) : $recent->the_post();
                ?>
                <article class="article-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                    <?php endif; ?>
                    <span class="post-date"><?php echo get_the_date(); ?></span>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                </article>
                <?php endwhile; wp_reset_postdata(); else : ?>
                    <p>No posts yet.</p>
                <?php endif; ?>
            </div>

            <div class="load-more-wrap">
                <?php next_posts_link('Load More Articles'); ?>
            </div>
        </section>

    </main>

    <!-- Sidebar -->
    <aside class="blog-sidebar">
        <div class="sidebar-box newsletter-box">
            <h3>Stay Updated</h3>
            <p>Get the latest articles delivered to your inbox weekly</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Your email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>

        <div class="sidebar-box">
            <h3>Browse by Tag</h3>
            <div class="tag-cloud">
                <?php wp_tag_cloud(['smallest' => 14, 'largest' => 14]); ?>
            </div>
        </div>
    </aside>
</div>

<?php get_footer(); ?>