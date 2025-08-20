<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'vazirmatn': ['Vazirmatn', 'Tahoma', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <!-- فونت Vazirmatn -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-gray-50 font-vazirmatn'); ?>>
    <div class="container mx-auto px-4">
        <header class="header">
            <div class="header-top">
                <?php if (function_exists('the_custom_logo') && has_custom_logo()) : ?>
                    <div class="site-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="text-white text-2xl font-bold hover:text-gray-200 transition-colors">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                <?php endif; ?>
                
                <nav class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class' => 'primary-menu',
                        'container' => false,
                        'fallback_cb' => 'digishop_fallback_menu',
                        'walker' => new Digishop_Menu_Walker()
                    ));
                    ?>
                </nav>
            </div>
        </header>
        
        <main class="min-h-screen">

        

        