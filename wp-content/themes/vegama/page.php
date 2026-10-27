<?php get_header(); ?>

<main id="main" class="sec sec-dark">
    <div class="sec-inner">
        <?php while ( have_posts() ) : the_post(); ?>
            <h1 class="sec-h"><?php the_title(); ?></h1>
            <div class="page-content">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>