<?php get_header(); ?>

<div class="container">
    <h1 class="archive-title"><?php the_archive_title(); ?></h1>
    
    <div class="archive-content">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article class="archive-item">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p>هیچ مطلبی یافت نشد.</p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>