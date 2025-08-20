<?php get_header(); ?>

<div class="container mx-auto px-4 py-8">
    <div class="product-detail-page bg-white rounded-xl shadow-lg overflow-hidden">
        <?php while (have_posts()) : the_post(); ?>
            
            <!-- مسیر ناوبری -->
            <nav class="breadcrumb bg-gray-50 px-6 py-4 border-b">
                <ul class="flex items-center space-x-2 space-x-reverse text-sm">
                    <li><a href="<?php echo home_url(); ?>" class="text-blue-500 hover:text-blue-700">خانه</a></li>
                    <li><span class="text-gray-400">/</span></li>
                    <li><a href="<?php echo home_url('/products'); ?>" class="text-blue-500 hover:text-blue-700">محصولات</a></li>
                    <li><span class="text-gray-400">/</span></li>
                    <li class="text-gray-600"><?php the_title(); ?></li>
                </ul>
            </nav>

            <!-- بخش اصلی محصول -->
            <div class="product-main-section grid grid-cols-1 lg:grid-cols-3 gap-8 p-6">
                
                <!-- گالری محصول -->
                <div class="product-gallery lg:col-span-1">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="main-product-image mb-4">
                            <?php the_post_thumbnail('large', array('class' => 'w-full h-auto rounded-lg shadow-md')); ?>
                        </div>
                    <?php else : ?>
                        <div class="main-product-image mb-4">
                            <img src="https://via.placeholder.com/600x400/3498db/ffffff?text=<?php echo urlencode(get_the_title()); ?>" 
                                 alt="<?php the_title(); ?>" class="w-full h-auto rounded-lg shadow-md">
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- اطلاعات محصول -->
                <div class="product-info lg:col-span-2">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2"><?php the_title(); ?></h1>
                    
                    <?php $model = get_post_meta(get_the_ID(), '_product_model', true); ?>
                    <?php if ($model) : ?>
                        <div class="product-model text-gray-600 text-lg mb-4">
                            <span class="font-semibold">مدل:</span> <?php echo esc_html($model); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php $price = get_post_meta(get_the_ID(), '_product_price', true); ?>
                    <?php if ($price) : ?>
                        <div class="product-price text-2xl font-bold text-red-600 mb-6">
                            <?php echo number_format($price); ?> ریال
                        </div>
                    <?php endif; ?>
                    
                    <!-- دکمه‌های اقدام -->
                    <div class="product-actions-large mb-6">
                        <button class="add-to-cart-btn-large bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-bold transition-colors flex items-center" 
                                data-product-id="<?php the_ID(); ?>">
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5 6m0 0h9M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"/>
                            </svg>
                            افزودن به سبد خرید
                        </button>
                    </div>
                    
                    <!-- اطلاعات سریع -->
                    <div class="quick-info grid grid-cols-1 gap-3 mb-6">
                    </div>
                </div>
            </div>

            <!-- تب‌های اطلاعات محصول -->
            <div class="product-tabs border-t">
                <nav class="tabs-navigation">
                    <ul class="flex border-b">
                        <li class="mr-1">
                            <a href="#description" class="tab-link bg-white inline-block py-4 px-6 text-blue-600 font-semibold border-b-2 border-blue-600">
                                توضیحات محصول
                            </a>
                        </li>
                        <li class="mr-1">
                            <a href="#features" class="tab-link bg-white inline-block py-4 px-6 text-gray-600 hover:text-blue-600">
                                ویژگی‌های فنی
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <div class="tab-content p-6">
                    <!-- توضیحات محصول -->
                    <div id="description" class="tab-pane active">
                        <h3 class="text-xl font-semibold mb-4">توضیحات کامل محصول</h3>
                        <div class="description-content prose max-w-none">
                            <?php 
                            // اگر محتوایی وجود دارد نمایش بده، در غیر این صورت متن پیش‌فرض
                            if (get_the_content()) {
                                the_content();
                            } else {
                                echo '<div class="space-y-4">';
                                echo '<p class="text-gray-700 leading-7">این ' . get_the_title() . ' یکی از برترین محصولات در دسته‌بندی خود محسوب می‌شود که با آخرین تکنولوژی‌های روز دنیا طراحی و تولید شده است.</p>';
                                
                                echo '<p class="text-gray-700 leading-7">طراحی ارگونومیک و مدرن این محصول، تجربه‌ای بی‌نظیر برای کاربران فراهم می‌آورد. کیفیت ساخت بالا و استفاده از مواد اولیه مرغوب، عمر طولانی و عملکرد پایدار محصول را تضمین می‌کند.</p>';
                                
                                echo '<p class="text-gray-700 leading-7">این محصول مناسب برای استفاده‌های حرفه‌ای و روزمره بوده و پاسخگوی تمام نیازهای شما خواهد بود. تنوع رنگی و طراحی شیک، آن را به انتخابی ایده‌آل برای سلیقه‌های مختلف تبدیل کرده است.</p>';
                                
                                echo '<div class="bg-yellow-50 border-r-4 border-yellow-400 p-4 rounded">';
                                echo '<h4 class="font-semibold text-yellow-800 mb-2">نکات برجسته:</h4>';
                                echo '<ul class="list-disc list-inside text-yellow-700 space-y-1">';
                                echo '<li>کیفیت ساخت فوق‌العاده</li>';
                                echo '<li>طراحی مدرن و کاربرپسند</li>';
                                echo '<li>قیمت بسیار مناسب نسبت به کیفیت</li>';
                                echo '<li>گارانتی و پشتیبانی معتبر</li>';
                                echo '</ul>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- ویژگی‌های محصول -->
                    <div id="features" class="tab-pane hidden">
                        <h3 class="text-xl font-semibold mb-4">ویژگی‌های فنی</h3>
                        <?php $features = get_post_meta(get_the_ID(), '_product_features', true); ?>
                        <?php if ($features) : ?>
                            <div class="features-list grid grid-cols-1 md:grid-cols-2 gap-4">
                                <?php 
                                $feature_items = explode("\n", $features);
                                foreach ($feature_items as $feature) {
                                    if (!empty(trim($feature))) {
                                        echo '<div class="feature-item flex items-center p-3 bg-gray-50 rounded-lg">';
                                        echo '<span class="w-2 h-2 bg-blue-500 rounded-full ml-3"></span>';
                                        echo '<span class="text-gray-700">' . esc_html(trim($feature)) . '</span>';
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        <?php else : ?>
                            <div class="technical-specs space-y-4">
                                <!-- ویژگی‌های عمومی برای محصولات دیجیتال -->
                                <div class="specs-category">
                                    <h4 class="font-semibold text-gray-800 mb-3">مشخصات کلی</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div class="spec-item flex justify-between py-2 border-b">
                                            <span class="text-gray-600">وزن</span>
                                            <span class="text-gray-800 font-medium">450 گرم</span>
                                        </div>
                                        <div class="spec-item flex justify-between py-2 border-b">
                                            <span class="text-gray-600">ابعاد</span>
                                            <span class="text-gray-800 font-medium">150 × 80 × 25 mm</span>
                                        </div>
                                        <div class="spec-item flex justify-between py-2 border-b">
                                            <span class="text-gray-600">رنگ‌بندی</span>
                                            <span class="text-gray-800 font-medium">مشکی، سفید، نقره‌ای</span>
                                        </div>
                                        <div class="spec-item flex justify-between py-2 border-b">
                                            <span class="text-gray-600">جنس بدنه</span>
                                            <span class="text-gray-800 font-medium">پلاستیک ABS با کیفیت</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- ویژگی‌های فنی -->
                                <div class="specs-category">
                                    <h4 class="font-semibold text-gray-800 mb-3">ویژگی‌های فنی</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div class="spec-item flex justify-between py-2 border-b">
                                            <span class="text-gray-600">فرکانس کاری</span>
                                            <span class="text-gray-800 font-medium">2.4 GHz</span>
                                        </div>
                                        <div class="spec-item flex justify-between py-2 border-b">
                                            <span class="text-gray-600">برد ارتباطی</span>
                                            <span class="text-gray-800 font-medium">10 متر</span>
                                        </div>
                                        <div class="spec-item flex justify-between py-2 border-b">
                                            <span class="text-gray-600">مدت زمان باتری</span>
                                            <span class="text-gray-800 font-medium">20 ساعت</span>
                                        </div>
                                        <div class="spec-item flex justify-between py-2 border-b">
                                            <span class="text-gray-600">زمان شارژ</span>
                                            <span class="text-gray-800 font-medium">2 ساعت</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- قابلیت‌ها -->
                                <div class="specs-category">
                                    <h4 class="font-semibold text-gray-800 mb-3">قابلیت‌های ویژه</h4>
                                    <div class="space-y-2">
                                        <div class="feature-badge bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm inline-block mr-2">
                                            ضد آب IPX4
                                        </div>
                                        <div class="feature-badge bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm inline-block mr-2">
                                            کاهش نویز فعال
                                        </div>
                                        <div class="feature-badge bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm inline-block mr-2">
                                            میکروفون دوطرفه
                                        </div>
                                        <div class="feature-badge bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm inline-block mr-2">
                                            کنترل لمسی
                                        </div>
                                    </div>
                                </div>

                                <!-- محتویات بسته‌بندی -->
                                <div class="specs-category">
                                    <h4 class="font-semibold text-gray-800 mb-3">محتویات جعبه</h4>
                                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                                        <li>دستگاه اصلی</li>
                                        <li>کابل USB شارژر</li>
                                        <li>دفترچه راهنما</li>
                                        <li>گارانتی 18 ماهه</li>
                                        <li>کیف حمل</li>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- محصولات مشابه -->
            <div class="similar-products-section bg-gray-50 p-6">
                <h3 class="text-2xl font-semibold mb-6 text-center">محصولات مرتبط</h3>
                <div class="similar-products-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php
                    // دریافت محصولات مشابه از همان دسته‌بندی
                    $categories = get_the_terms(get_the_ID(), 'product_category');
                    if ($categories && !is_wp_error($categories)) {
                        $category_ids = wp_list_pluck($categories, 'term_id');
                        
                        $similar_products = new WP_Query(array(
                            'post_type' => 'product',
                            'posts_per_page' => 4,
                            'post__not_in' => array(get_the_ID()),
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_category',
                                    'field' => 'id',
                                    'terms' => $category_ids
                                )
                            )
                        ));
                        
                        if ($similar_products->have_posts()) :
                            while ($similar_products->have_posts()) : $similar_products->the_post(); ?>
                                <div class="similar-product bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="similar-product-image">
                                            <?php the_post_thumbnail('medium', array('class' => 'w-full h-48 object-cover')); ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="similar-product-image">
                                            <img src="https://via.placeholder.com/300x200/3498db/ffffff?text=<?php echo urlencode(get_the_title()); ?>" 
                                                 alt="<?php the_title(); ?>" class="w-full h-48 object-cover">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="p-4">
                                        <h4 class="similar-product-title text-lg font-semibold mb-2"><?php the_title(); ?></h4>
                                        
                                        <?php 
                                        $similar_model = get_post_meta(get_the_ID(), '_product_model', true);
                                        if ($similar_model) : ?>
                                            <div class="similar-model text-gray-600 text-sm mb-2">مدل: <?php echo esc_html($similar_model); ?></div>
                                        <?php endif; ?>
                                        
                                        <?php 
                                        $similar_price = get_post_meta(get_the_ID(), '_product_price', true);
                                        if ($similar_price) : ?>
                                            <div class="similar-price text-red-600 font-bold mb-3"><?php echo number_format($similar_price); ?> ریال</div>
                                        <?php endif; ?>
                                        
                                        <a href="<?php the_permalink(); ?>" class="view-similar bg-blue-600 text-white px-4 py-2 rounded-lg inline-block text-sm hover:bg-blue-700 transition-colors w-full text-center">
                                            مشاهده جزئیات
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile;
                            wp_reset_postdata();
                        else : ?>
                            <p class="text-gray-500 text-center col-span-full py-8">هیچ محصول مشابهی یافت نشد.</p>
                        <?php endif;
                    }
                    ?>
                </div>
            </div>

        <?php endwhile; ?>
    </div>
</div>

<script>
// مدیریت تب‌ها
document.addEventListener('DOMContentLoaded', function() {
    const tabLinks = document.querySelectorAll('.tab-link');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // حذف کلاس active از همه تب‌ها
            tabLinks.forEach(l => l.classList.remove('text-blue-600', 'border-blue-600'));
            tabPanes.forEach(p => p.classList.add('hidden'));
            
            // اضافه کردن کلاس active به تب انتخاب شده
            this.classList.add('text-blue-600', 'border-blue-600');
            
            // نمایش محتوای تب مربوطه
            const targetTab = this.getAttribute('href').substring(1);
            document.getElementById(targetTab).classList.remove('hidden');
        });
    });
});
</script>

<?php get_footer(); ?>