FROM php:8.2-fpm-alpine

# လိုအပ်တဲ့ System Dependencies တွေ သွင်းခြင်း (postgresql-dev ထည့်ထားပါတယ်)
RUN apk add --no-cache nginx supervisor curl libpng-dev libxml2-dev zip unzip git postgresql-dev

# PHP Extensions သွင်းခြင်း (pdo_pgsql ထည့်ထားပါတယ်)
RUN docker-php-ext-install pdo_mysql pdo_pgsql bcmath gd

# Composer ကို Docker ထဲ ထည့်ခြင်း
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Project ဖိုင်တွေကို Container ထဲ ကူးခြင်း
WORKDIR /var/www
COPY . .

# Composer dependencies သွင်းခြင်း
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Permission တွေ သတ်မှတ်ခြင်း
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Nginx Configuration ကို ကူးထည့်ခြင်း
COPY nginx.conf /etc/nginx/http.d/default.conf

# Render ပေါ်မှာ run မယ့် port အတွက် ပြင်ဆင်ခြင်း
EXPOSE 80

# Website မပွင့်ခင် Database Migration ကို အလိုအလျောက် အရင် run ခိုင်းခြင်း
RUN php artisan migrate --force

# PHP-FPM ကော Nginx ပါ ပြိုင်တူ run ဖို့ Command ရေးခြင်း
CMD nginx && php-fpm