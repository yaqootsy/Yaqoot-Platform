FROM php:8.2-fpm

# ============================================================
# 1) تحديث النظام وتثبيت جميع المكتبات الضرورية
# ============================================================
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libicu-dev \
    libexif-dev \
    libmagickwand-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        zip \
        intl \
        exif \
        gd

# تفعيل EXIF بشكل صحيح
RUN docker-php-ext-enable exif

# ============================================================
# 2) تثبيت IMAGICK (مهم لـ Media Library Conversions)
# ============================================================
RUN pecl install imagick && docker-php-ext-enable imagick

# ============================================================
# 3) نسخ المشروع
# ============================================================
WORKDIR /var/www/html
COPY . .

# ============================================================
# 4) تهيئة composer داخل الحاوية
# ============================================================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# إصلاح مشكلة Git ownership
RUN git config --global --add safe.directory /var/www/html

# تثبيت dependencies داخل Docker (اختياري)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# ============================================================
# 5) صلاحيات Laravel
# ============================================================
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

USER www-data

CMD ["php-fpm"]
