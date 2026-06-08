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

# Permission သတ်မှတ်ချက် (ဒီအတိုင်းထားပါ)
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Nginx config ကူးခြင်း (ဒီအတိုင်းထားပါ)
COPY nginx.conf /etc/nginx/http.d/default.conf

EXPOSE 80

# ပြင်ဆင်ရမည့် အောက်ဆုံးစာကြောင်း (Runtime ကျမှ တစ်ခါတည်း အကုန် run ခိုင်းတာပါ)
CMD php artisan migrate --force && nginx && php-fpm