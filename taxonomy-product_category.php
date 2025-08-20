<?php get_header(); ?>

<div class="container">
    <div class="products-archive-page">
        <h1 class="archive-title"><?php single_term_title(); ?></h1>
        
        <?php 
        $category_description = term_description();
        if (!empty($category_description)) : ?>
            <div class="category-description bg-blue-50 p-6 rounded-xl mb-8 text-center">
                <?php echo $category_description; ?>
            </div>
        <?php endif; ?>

        <div class="products-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
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
                <?php endwhile; ?>
                
                <div class="pagination">
                    <?php 
                    echo paginate_links(array(
                        'prev_text' => '&laquo; قبلی',
                        'next_text' => 'بعدی &raquo;',
                        'type' => 'list'
                    )); 
                    ?>
                </div>
            <?php else : ?>
                <div class="no-products-found">
                    <p>هیچ محصولی در این دسته‌بندی یافت نشد.</p>
                    <a href="<?php echo home_url('/products'); ?>" class="back-to-all">بازگشت به همه محصولات</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>