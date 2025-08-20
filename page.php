<?php get_header(); ?>

<div class="container">
    <article class="page-content">
        <h1><?php the_title(); ?></h1>
        <div class="page-body">
            <?php 
            // محتوای اصلی صفحه
            the_content(); 
            
            // اگر صفحه ارتباط با ما است، فرم را اضافه کن
            if (is_page('ارتباط با ما') || is_page('contact-us')) {
                echo '<div class="contact-form-container">';
                get_template_part('template-parts/contact', 'form');
                echo '</div>';
            }
            ?>
        </div>
    </article>
</div>

<?php get_footer(); ?>