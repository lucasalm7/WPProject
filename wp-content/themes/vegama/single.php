<?php get_header(); ?>
    <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post(); ?>
            <?php
            $title = get_the_title(); 
            $date = get_the_date(); 
            $author = get_the_author();
            $content = get_the_content(); 
            $categories = get_the_category(); 
            $tags = get_the_tags(); 
            $category_name = !empty($categories) ? $categories[0]->name : '';
            ?>
            <section class="single-post-hero">
                <?php if ($category_name): ?>
                    <span class="pc-tag"><?php echo esc_html($category_name);?></span>
                <?php endif; ?>
                <h1><?php echo esc_html($title); ?></h1>
                <p class="single-post-meta">
                    <?php echo esc_html($date); ?> · By <?php echo esc_html($author);  ?>
                </p>
            </section>

            <?php if (has_post_thumbnail()):  ?>
                <div class="single-post-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="single-post-body">
                <?php echo $content; ?>
            </div>

            <?php if ($categories || $tags):  ?>
                <div class="single-post-taxonomy">
                    <?php if ($categories):  ?>
                        <?php foreach ($categories as $category): ?>
                            <a href="<?php echo get_category_link($category->term_id);  ?>">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ($tags):?>
                        <?php foreach ($tags as $tag): ?>
                            <a href="<?php echo get_tag_link($tag->term_id); ?>">
                                #<?php echo esc_html($tag->name);  ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div style="background: #185f30; color: #fff; padding: 30px; border-radius: 12px; margin: 40px auto; max-width: 720px; text-align: center;">
                <h3 style="color: #fff; margin-top: 0; margin-bottom: 10px;">Love Cooking Plant-Based? Take It Further.</h3>
                <p style="opacity: 0.9; margin-bottom: 20px; line-height: 1.6; max-width: 600px; margin-left: auto; margin-right: auto;">Recipes are just the beginning. Connect with fellow conscious food enthusiasts in Denmark, share surplus market ingredients, and cook side-by-side with us in our local community workshops.</p>
                <a href="http://wpproject.local/classes" style="display: inline-block; background: #fff; color: #185f30; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">Reserve your spot in a class</a>
            </div>

            <?php comments_template();  ?>

        <?php endwhile; ?>
    <?php endif; ?>
<?php get_footer(); ?>