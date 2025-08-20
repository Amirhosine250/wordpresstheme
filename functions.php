<?php
// فعال کردن تصاویر شاخص
add_theme_support('post-thumbnails');

// فعال کردن لوگو
add_theme_support('custom-logo', array(
    'height'      => 100,
    'width'       => 200,
    'flex-height' => true,
    'flex-width'  => true,
));

// ثبت منوها
function digishop_register_menus() {
    register_nav_menus(array(
        'primary' => 'منوی اصلی',
        'footer' => 'منوی فوتر'
    ));
}
add_action('init', 'digishop_register_menus');

// ثبت نوع پست سفارشی برای محصولات
function digishop_register_product_post_type() {
    $labels = array(
        'name' => 'محصولات',
        'singular_name' => 'محصول',
        'add_new' => 'افزودن محصول جدید',
        'add_new_item' => 'افزودن محصول جدید',
        'edit_item' => 'ویرایش محصول',
        'new_item' => 'محصول جدید',
        'view_item' => 'مشاهده محصول',
        'search_items' => 'جستجوی محصولات',
        'not_found' => 'محصولی یافت نشد',
        'not_found_in_trash' => 'محصولی در زباله دان یافت نشد'
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-camera',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'products'),
        'show_in_rest' => true,
    );
    
    register_post_type('product', $args);
}
add_action('init', 'digishop_register_product_post_type');

// ثبت دسته‌بندی برای محصولات
function digishop_register_product_taxonomy() {
    $labels = array(
        'name' => 'دسته‌بندی محصولات',
        'singular_name' => 'دسته‌بندی',
        'search_items' => 'جستجوی دسته‌بندی',
        'all_items' => 'همه دسته‌بندی‌ها',
        'parent_item' => 'دسته‌بندی والد',
        'parent_item_colon' => 'دسته‌بندی والد:',
        'edit_item' => 'ویرایش دسته‌بندی',
        'update_item' => 'بروزرسانی دسته‌بندی',
        'add_new_item' => 'افزودن دسته‌بندی جدید',
        'new_item_name' => 'نام دسته‌بندی جدید',
        'menu_name' => 'دسته‌بندی محصولات',
    );
    
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'product-category'),
    );
    
    register_taxonomy('product_category', array('product'), $args);
}
add_action('init', 'digishop_register_product_taxonomy');

// ایجاد دسته‌بندی‌های پیش‌فرض
function digishop_create_default_categories() {
    $categories = array(
        'دوربین‌های دیجیتال',
        'هدست و هدفون',
        'تجهیزات گیمینگ',
        'کنسول‌های بازی'
    );
    
    foreach ($categories as $category) {
        if (!term_exists($category, 'product_category')) {
            wp_insert_term($category, 'product_category');
        }
    }
}
add_action('init', 'digishop_create_default_categories');

// اضافه کردن فیلدهای سفارشی برای محصولات
function digishop_add_product_meta_boxes() {
    add_meta_box(
        'product_info',
        'اطلاعات محصول',
        'digishop_product_meta_box_callback',
        'product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'digishop_add_product_meta_boxes');

function digishop_product_meta_box_callback($post) {
    // دریافت مقادیر موجود
    $price = get_post_meta($post->ID, '_product_price', true);
    $model = get_post_meta($post->ID, '_product_model', true);
    $features = get_post_meta($post->ID, '_product_features', true);
    
    // فیلد قیمت
    echo '<div style="margin-bottom: 15px;">';
    echo '<label for="product_price" style="display: block; margin-bottom: 5px; font-weight: bold;">قیمت (ریال):</label>';
    echo '<input type="number" id="product_price" name="product_price" value="' . esc_attr($price) . '" style="width: 100%; padding: 8px;">';
    echo '</div>';
    
    // فیلد مدل
    echo '<div style="margin-bottom: 15px;">';
    echo '<label for="product_model" style="display: block; margin-bottom: 5px; font-weight: bold;">مدل محصول:</label>';
    echo '<input type="text" id="product_model" name="product_model" value="' . esc_attr($model) . '" style="width: 100%; padding: 8px;">';
    echo '</div>';
    
    // فیلد ویژگی‌ها
    echo '<div>';
    echo '<label for="product_features" style="display: block; margin-bottom: 5px; font-weight: bold;">ویژگی‌های محصول (هر ویژگی در یک خط):</label>';
    echo '<textarea id="product_features" name="product_features" style="width: 100%; height: 100px; padding: 8px;">' . esc_textarea($features) . '</textarea>';
    echo '<p style="color: #666; font-size: 13px; margin-top: 5px;">هر ویژگی را در یک خط جداگانه وارد کنید</p>';
    echo '</div>';
    
    // افزودن nonce برای امنیت
    wp_nonce_field('digishop_save_product_meta', 'digishop_product_meta_nonce');
}

// ذخیره اطلاعات فیلدهای سفارشی
function digishop_save_product_meta($post_id) {
    // بررسی nonce
    if (!isset($_POST['digishop_product_meta_nonce']) || 
        !wp_verify_nonce($_POST['digishop_product_meta_nonce'], 'digishop_save_product_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    if (isset($_POST['product_price'])) {
        update_post_meta($post_id, '_product_price', sanitize_text_field($_POST['product_price']));
    }
    
    if (isset($_POST['product_model'])) {
        update_post_meta($post_id, '_product_model', sanitize_text_field($_POST['product_model']));
    }
    
    if (isset($_POST['product_features'])) {
        update_post_meta($post_id, '_product_features', sanitize_textarea_field($_POST['product_features']));
    }
}
add_action('save_post', 'digishop_save_product_meta');

// فرمت کردن قیمت به ریال
function digishop_format_price($price) {
    if (empty($price)) return '۰ ریال';
    return number_format($price) . ' ریال';
}

// ایجاد صفحات ضروری هنگام فعال سازی قالب
function digishop_create_necessary_pages() {
    // ایجاد صفحه خانه
    $home_page = array(
        'post_title'    => 'خانه',
        'post_content'  => 'به فروشگاه ما خوش آمدید. اینجا فروشگاه ماست و ما بهترین لوازم جانبی را می‌فروشیم.',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_name'     => 'home'
    );
    $home_page_id = wp_insert_post($home_page);
    
    // ایجاد صفحه ارتباط با ما
    $contact_page = array(
        'post_title'    => 'ارتباط با ما',
        'post_content'  => '<!-- فرم تماس در اینجا نمایش داده می شود -->',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_name'     => 'contact-us'
    );
    $contact_page_id = wp_insert_post($contact_page);
    
    // تنظیم صفحه خانه به عنوان صفحه اصلی
    update_option('page_on_front', $home_page_id);
    update_option('show_on_front', 'page');
}
add_action('after_switch_theme', 'digishop_create_necessary_pages');

// ایجاد منوی اصلی به صورت خودکار
function digishop_create_main_menu() {
    $menu_name = 'منوی اصلی';
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        
        // اضافه کردن آیتم‌های منو
        $pages = array(
            'خانه' => array('url' => home_url('/'), 'order' => 1),
            'محصولات' => array('url' => home_url('/products'), 'order' => 2),
            'ارتباط با ما' => array('url' => home_url('/contact-us'), 'order' => 3)
        );
        
        foreach ($pages as $title => $details) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => $title,
                'menu-item-url' => $details['url'],
                'menu-item-status' => 'publish',
                'menu-item-position' => $details['order']
            ));
        }
        
        // اختصاص منو به مکان اصلی
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}
add_action('after_switch_theme', 'digishop_create_main_menu');

// ایجاد محصولات نمونه
function digishop_create_sample_products() {
    $products = array(
        array(
            'title' => 'دوربین دیجیتال کانن',
            'model' => 'EOS 250D',
            'price' => '27339000',
            'category' => 'دوربین‌های دیجیتال',
            'features' => "حسگر APS-C CMOS\nفیلمبرداری 4K با کیفیت 24/25fps\nISO بین 100 تا 25600\nسیستم فوکوس خودکار دقیق\nصفحه نمایش لمسی چرخشی\nاتصال Wi-Fi و Bluetooth\nقابلیت کنترل از طریق موبایل"
        ),
        array(
            'title' => 'هدست بلوتوث سونی',
            'model' => 'WH-CH720N',
            'price' => '37399000',
            'category' => 'هدست و هدفون',
            'features' => "فناوری نویزکنسلی\nباتری با عمر 35 ساعت\nطراحی ارگونومیک\nقابلیت اتصال چند دستگاه\nمیکروفون با کیفیت بالا\nوزن سبک و راحت"
        ),
        array(
            'title' => 'هدفون بلوتوثی سونی',
            'model' => 'SBH54',
            'price' => '26640000',
            'category' => 'هدست و هدفون',
            'features' => "طراحی ورزشی و ضد عرق\nباتری با عمر 20 ساعت\nمقاوم در برابر آب و گرد و غبار\nکنترل‌های لمسی\nکیفیت صدای استریو\nقابلیت پاسخگویی به تماس"
        ),
        array(
            'title' => 'موس گیمینگ حرفه‌ای',
            'model' => 'G502',
            'price' => '4500000',
            'category' => 'تجهیزات گیمینگ',
            'features' => "حسگر نوری پیشرفته\n11 دکمه programmable\nوزن قابل تنظیم\nRGB lighting\nپشتیبانی از DPI بالا\nساختار ارگونومیک"
        ),
        array(
            'title' => 'کیبورد گیمینگ مکانیکی',
            'model' => 'K95',
            'price' => '12800000',
            'category' => 'تجهیزات گیمینگ',
            'features' => "سوییچ‌های مکانیکی Cherry MX\nRGB lighting قابل تنظیم\n6 macro keys\nپشتیبانی از نرم‌افزار اختصاصی\nضد آب و ضد گرد و غبار\nطرح ergonomic"
        ),
        array(
            'title' => 'صندلی گیمینگ ارگونومیک',
            'model' => 'GC01',
            'price' => '49900000',
            'category' => 'تجهیزات گیمینگ',
            'features' => "پشتیبانی از کمر و گردن\nقابلیت تنظیم ارتفاع\nجنس چرم مصنوعی با کیفیت\nقابلیت reclining تا 180 درجه\nچرخ‌های نرم و روان\nقابلیت اضافه کردن بالشتک‌های اضافی"
        ),
        array(
            'title' => 'کنسول بازی PlayStation 5',
            'model' => 'PS5',
            'price' => '28000000',
            'category' => 'کنسول‌های بازی',
            'features' => "پردازنده 8-core AMD Zen 2\nکارت گرافیک AMD Radeon RDNA 2\nحافظه SSD 825GB\nپشتیبانی از 4K تا 120fps\nRay tracing support\nسازگاری با بازی‌های PS4"
        ),
        array(
            'title' => 'هدفون حرفه‌ای استودیو',
            'model' => 'HD660S',
            'price' => '32500000',
            'category' => 'هدست و هدفون',
            'features' => "پاسخ فرکانسی 10-41000 Hz\nامپدانس 150 Ohm\nفناوری open-back\nکابل قابل تعویض\nساختار با کیفیت و بادوام\nمناسب برای mixing و mastering"
        ),
        array(
            'title' => 'دوربین حرفه‌ای DSLR',
            'model' => '5D Mark IV',
            'price' => '125000000',
            'category' => 'دوربین‌های دیجیتال',
            'features' => "حسگر full-frame 30.4MP\nفیلمبرداری 4K DCI\nسیستم فوکوس 61-point\nISO 100-32000 (قابل گسترش)\nصفحه نمایش لمسی 3.2 اینچی\nعمر باتری 900 شات"
        )
    );
    
    foreach ($products as $product_data) {
        $post_id = wp_insert_post(array(
            'post_title' => $product_data['title'],
            'post_content' => 'توضیحات کامل محصول ' . $product_data['title'] . '. این محصول یکی از بهترین‌ها در بازار است و ویژگی‌های منحصر به فردی دارد.',
            'post_excerpt' => 'این ' . $product_data['title'] . ' یکی از محصولات معروف بازار است که کیفیت و عملکرد فوق‌العاده‌ای ارائه می‌دهد.',
            'post_status' => 'publish',
            'post_type' => 'product'
        ));
        
        if ($post_id) {
            update_post_meta($post_id, '_product_price', $product_data['price']);
            update_post_meta($post_id, '_product_model', $product_data['model']);
            update_post_meta($post_id, '_product_features', $product_data['features']);
            
            // اختصاص دسته‌بندی
            wp_set_object_terms($post_id, $product_data['category'], 'product_category');
        }
    }
}
add_action('after_switch_theme', 'digishop_create_sample_products');

// Walker مخصوص برای منو با Tailwind
class Digishop_Menu_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $output .= '<li' . $class_names . '>';
        
        $attributes = '';
        $attributes .= !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . ' class="text-white no-repeat font-medium px-5 py-3 rounded transition-all hover:bg-white hover:bg-opacity-20"';
        $item_output .= '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

// منوی پیش‌فرض اگر منویی ایجاد نشده باشد
function digishop_fallback_menu() {
    echo '<ul class="primary-menu">';
    echo '<li><a href="' . home_url() . '" class="text-white no-repeat font-medium px-5 py-3 rounded transition-all hover:bg-white hover:bg-opacity-20">خانه</a></li>';
    echo '<li><a href="' . home_url('/products') . '" class="text-white no-repeat font-medium px-5 py-3 rounded transition-all hover:bg-white hover:bg-opacity-20">محصولات</a></li>';
    echo '<li><a href="' . home_url('/contact-us') . '" class="text-white no-repeat font-medium px-5 py-3 rounded transition-all hover:bg-white hover:bg-opacity-20">ارتباط با ما</a></li>';
    echo '<li class="menu-cart-item"><a href="#" class="cart-link text-white no-repeat font-medium px-5 py-3 rounded transition-all hover:bg-white hover:bg-opacity-20">سبد خرید <span class="cart-count">0</span></a></li>';
    echo '</ul>';
}

// اضافه کردن آیتم سبد خرید به منو
function digishop_add_cart_to_menu($items, $args) {
    if ($args->theme_location == 'primary') {
        $cart_count = 0;
        if (isset($_COOKIE['digishop_cart_count'])) {
            $cart_count = intval($_COOKIE['digishop_cart_count']);
        }
        
        $items .= '<li class="menu-cart-item"><a href="#" class="cart-link bg-red-500 text-white px-4 py-2 rounded-full no-repeat">سبد خرید <span class="cart-count">' . $cart_count . '</span></a></li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'digishop_add_cart_to_menu', 10, 2);

// اضافه کردن استایل‌ها
function digishop_enqueue_styles() {
    wp_enqueue_style('digishop-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'digishop_enqueue_styles');

// فلاش رورایت规则ها بعد از ثبت نوع پست
function digishop_flush_rewrite_rules() {
    digishop_register_product_post_type();
    digishop_register_product_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'digishop_flush_rewrite_rules');

// رفع مشکل فونت و encoding
function digishop_fix_font_issues() {
    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
    echo '<meta charset="UTF-8">';
}
add_action('wp_head', 'digishop_fix_font_issues');
?>