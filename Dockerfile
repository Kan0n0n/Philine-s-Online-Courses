# 1. Sử dụng PHP 8.2 với Apache
FROM php:8.4.14-apache

# 2. Cài đặt các thư viện hệ thống cần thiết
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 3. Cài đặt Node.js (Để build Tailwind CSS/Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 4. Cấu hình Apache để trỏ vào thư mục public/ của Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Bật Mod Rewrite của Apache (Cho Laravel Routes)
RUN a2enmod rewrite

# 6. Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Thiết lập thư mục làm việc
WORKDIR /var/www/html

# 8. Copy toàn bộ code vào Docker
COPY . .

# 9. Cài đặt các gói PHP (Composer)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 10. Cài đặt các gói JS và Build Frontend (Tailwind/Vite)
RUN npm install
RUN npm run build

# 11. Phân quyền cho thư mục storage và cache (Quan trọng!)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 12. Expose Port 80
EXPOSE 80

# 13. Lệnh chạy server (Tự động chạy migration khi start)
# Lưu ý: Nếu database chưa sẵn sàng, lệnh migrate có thể lỗi. 
# Bạn có thể bỏ đoạn "php artisan migrate --force &&" nếu muốn chạy tay.
CMD ["sh", "-c", "php artisan config:cache && php artisan route:cache && apache2-foreground"]