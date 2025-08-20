<?php get_header(); ?>

<div class="container">
    <div class="home-page">
        <?php if (is_active_sidebar('home-content')) : ?>
            <div class="home-welcome-section">
                <?php dynamic_sidebar('home-content'); ?>
            </div>
        <?php endif; ?>

        <h2 class="section-title">محصولات پرفروش</h2>
        
        <div class="products-grid">
            <?php
            // نمایش 9 محصول
            $products = new WP_Query(array(
                'post_type' => 'product',
                'posts_per_page' => 9,
                'orderby' => 'rand'
            ));
            
            if ($products->have_posts()) :
                while ($products->have_posts()) : $products->the_post(); ?>
                    <div class="product-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="product-image">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>
                        <?php else : ?>
                            <div class="product-image">
                                <img src="https://via.placeholder.com/300x200/3498db/ffffff?text=<?php echo urlencode(get_the_title()); ?>" alt="<?php the_title(); ?>">
                            </div>
                        <?php endif; ?>
                        
                        <h3 class="product-title"><?php the_title(); ?></h3>
                        
                        <?php $model = get_post_meta(get_the_ID(), '_product_model', true); ?>
                        <?php if ($model) : ?>
                            <div class="product-model">مدل: <?php echo esc_html($model); ?></div>
                        <?php endif; ?>
                        
                        <div class="product-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <?php $price = get_post_meta(get_the_ID(), '_product_price', true); ?>
                        <?php if ($price) : ?>
                            <div class="product-price"><?php echo number_format($price); ?> ریال</div>
                        <?php endif; ?>
                        
                        <div class="product-actions">
                            <a href="<?php the_permalink(); ?>" class="view-details-btn">مشاهده جزئیات</a>
                            <button class="add-to-cart-btn" data-product-id="<?php the_ID(); ?>">سبد خرید</button>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <div class="no-products">
                    <p>هیچ محصولی یافت نشد.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>