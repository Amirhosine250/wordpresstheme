<div class="contact-form">
    <h2 class="text-2xl font-bold text-center mb-6">فرم تماس با ما</h2>
    <p class="text-gray-600 text-center mb-8">در صورت داشتن سوال یا مشکل، از طریق فرم زیر با ما در ارتباط باشید.</p>
    
    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" class="contact-form">
        <input type="hidden" name="action" value="digishop_contact_form">
        
        <div class="form-group">
            <label for="contact_name">نام کامل</label>
            <input type="text" id="contact_name" name="contact_name" required 
                   placeholder="نام و نام خانوادگی خود را وارد کنید" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
        </div>
        
        <div class="form-group">
            <label for="contact_email">آدرس ایمیل</label>
            <input type="email" id="contact_email" name="contact_email" required 
                   placeholder="ایمیل خود را وارد کنید" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
        </div>
        
        <div class="form-group">
            <label for="contact_subject">موضوع</label>
            <select id="contact_subject" name="contact_subject" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                <option value="">انتخاب کنید</option>
                <option value="پشتیبانی">پشتیبانی فنی</option>
                <option value="خرید">خرید محصول</option>
                <option value="پیشنهاد">پیشنهاد و انتقاد</option>
                <option value="همکاری">همکاری</option>
                <option value="سایر">سایر</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="contact_message">پیام شما</label>
            <textarea id="contact_message" name="contact_message" rows="5" required 
                      placeholder="متن پیام خود را بنویسید" class="w-full px-4 py-3 border border-gray-300 rounded-lg"></textarea>
        </div>
        
        <button type="submit" class="submit-btn">ارسال پیام</button>
    </form>
</div>