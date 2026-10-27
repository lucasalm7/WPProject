<?php get_header(); ?>
<main id="main">

<section class="sec sec-dark" id="blog-listing">
    <div class="sec-inner">
        <span class="sec-eye">The Journal</span>
        <h1 class="sec-h">Vegama <em>Blog</em></h1>

        <?php
        // Filters: ?type=recipe (category) and ?tag=tofu (tag). Both can be combined.
        $selected_type = isset( $_GET['type'] ) ? sanitize_title( wp_unslash( $_GET['type'] ) ) : '';
        $selected_tag  = isset( $_GET['tag'] ) ? sanitize_title( wp_unslash( $_GET['tag'] ) ) : '';
        $blog_url      = get_permalink( get_option( 'page_for_posts' ) );

        $types = array(
            ''       => 'All posts',
            'recipe' => 'Recipes',
            'guides' => 'Guides',
        );
        ?>

        <nav class="recipe-filters" aria-label="Filter posts by type">
            <?php foreach ( $types as $slug => $label ) : ?>
                <?php $url = $slug ? add_query_arg( 'type', $slug, $blog_url ) : $blog_url; ?>
                <a href="<?php echo esc_url( $url ); ?>"
                   class="cat-pill <?php echo $selected_type === $slug ? 'active' : ''; ?>"
                   <?php echo $selected_type === $slug ? 'aria-current="true"' : ''; ?>>
                    <?php echo esc_html( $label ); ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <?php $all_tags = get_tags( array( 'hide_empty' => true ) ); ?>
        <?php if ( $all_tags ) : ?>
            <nav class="recipe-filters" aria-label="Filter posts by ingredient or diet">
                <a href="<?php echo esc_url( remove_query_arg( 'tag' ) ); ?>"
                   class="cat-pill <?php echo $selected_tag === '' ? 'active' : ''; ?>"
                   <?php echo $selected_tag === '' ? 'aria-current="true"' : ''; ?>>
                    All tags
                </a>
                <?php foreach ( $all_tags as $tag ) : ?>
                    <a href="<?php echo esc_url( add_query_arg( 'tag', $tag->slug ) ); ?>"
                       class="cat-pill <?php echo $selected_tag === $tag->slug ? 'active' : ''; ?>"
                       <?php echo $selected_tag === $tag->slug ? 'aria-current="true"' : ''; ?>>
                        <?php echo esc_html( $tag->name ); ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        <?php endif; ?>

        <?php
        $query_args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 12,
            'paged'          => max( 1, get_query_var( 'paged' ) ),
        );
        if ( $selected_type ) {
            $query_args['category_name'] = $selected_type;
        }
        if ( $selected_tag ) {
            $query_args['tag'] = $selected_tag;
        }
        $blog_query = new WP_Query( $query_args );
        ?>

        <div class="blog-grid">
            <?php if ( $blog_query->have_posts() ) : ?>
                <?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
                    <?php
                    $categories    = get_the_category();
                    $category_name = ! empty( $categories ) ? $categories[0]->name : '';
                    ?>
                    <a href="<?php the_permalink(); ?>" class="pc">
                        <div class="pc-thumb">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium', array( 'style' => 'width:100%;height:100%;object-fit:cover;' ) ); ?>
                            <?php else : ?>
                                🥗
                            <?php endif; ?>
                        </div>
                        <div class="pc-body">
                            <?php if ( $category_name ) : ?>
                                <div class="pc-tag"><?php echo esc_html( $category_name ); ?></div>
                            <?php endif; ?>
                            <h2 class="pc-title"><?php echo esc_html( get_the_title() ); ?></h2>
                            <p class="pc-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
                            <div class="pc-meta"><?php echo esc_html( get_the_date() ); ?></div>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php else : ?>
                <p>No posts match this filter.</p>
            <?php endif; ?>
        </div>

        <div class="blog-pagination">
            <?php
            echo paginate_links( array(
                'total'   => $blog_query->max_num_pages,
                'current' => max( 1, get_query_var( 'paged' ) ),
            ) );
            ?>
        </div>

        <?php wp_reset_postdata(); ?>
    </div>
</section>
</main>
<?php get_footer(); ?>