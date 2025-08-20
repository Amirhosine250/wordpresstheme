</main>
        
        <footer class="footer">
            <div class="container mx-auto px-4">
                <p class="text-white">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> - تمام حقوق محفوظ است</p>
                
                <nav class="footer-navigation mt-4">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class' => 'flex justify-center space-x-6 space-x-reverse',
                        'container' => false,
                    ));
                    ?>
                </nav>
            </div>
        </footer>
        
        <!-- JavaScript برای سبد خرید -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButtons = document.querySelectorAll('.add-to-cart-btn, .add-to-cart-btn-large');
            
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productCard = this.closest('.product-card') || this.closest('.main-product-detail');
                    const productName = productCard.querySelector('.product-title').textContent;
                    const productPrice = productCard.querySelector('.product-price').textContent;
                    
                    // افزودن به localStorage
                    let cart = JSON.parse(localStorage.getItem('digishop_cart')) || [];
                    
                    // بررسی وجود محصول در سبد
                    const existingItemIndex = cart.findIndex(item => item.id === productId);
                    
                    if (existingItemIndex !== -1) {
                        cart[existingItemIndex].quantity += 1;
                    } else {
                        cart.push({
                            id: productId,
                            name: productName,
                            quantity: 1,
                            price: productPrice,
                            added_at: new Date().toISOString()
                        });
                    }
                    
                    localStorage.setItem('digishop_cart', JSON.stringify(cart));
                    
                    // نمایش نوتیفیکیشن
                    showNotification('محصول به سبد خرید اضافه شد!', 'success');
                    
                    // به روزرسانی شماره سبد خرید
                    updateCartCount();
                });
            });
            
            function showNotification(message, type = 'info') {
                // ایجاد عنصر نوتیفیکیشن
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-medium transition-all transform translate-x-full ${
                    type === 'success' ? 'bg-green-500' : 
                    type === 'error' ? 'bg-red-500' : 'bg-blue-500'
                }`;
                notification.textContent = message;
                notification.style.fontFamily = 'Vazirmatn, Tahoma, sans-serif';
                
                document.body.appendChild(notification);
                
                // نمایش نوتیفیکیشن
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                    notification.classList.add('translate-x-0');
                }, 100);
                
                // حذف خودکار پس از 3 ثانیه
                setTimeout(() => {
                    notification.classList.remove('translate-x-0');
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }
            
            function updateCartCount() {
                const cart = JSON.parse(localStorage.getItem('digishop_cart')) || [];
                const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
                
                // به روزرسانی شماره در منو
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    element.textContent = totalItems;
                });
                
                // ذخیره در cookie برای sessions بعدی
                document.cookie = `digishop_cart_count=${totalItems}; path=/; max-age=${60 * 60 * 24 * 7}`;
            }
            
            // مقدار اولیه
            updateCartCount();
        });
        </script>
        
        <?php wp_footer(); ?>
    </div>
</body>
</html>