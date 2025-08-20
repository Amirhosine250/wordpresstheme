<?php get_header(); ?>

<div class="container">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article class="page-content">
                <h1><?php the_title(); ?></h1>
                <div class="page-body">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <div class="no-content">
            <p>محتوایی برای نمایش وجود ندارد.</p>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>