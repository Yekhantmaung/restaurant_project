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

# ⚠️ အရင်စာကြောင်းကို ဖြုတ်ပြီး ဒီ (၂) ကြောင်းပဲ အစားထိုးရေးပေးပါဗျာ
# (Nginx ရဲ့ Main Config နေရာရော၊ Default Config နေရာရော နှစ်ခုလုံးကို အပြတ်သိမ်းသွင်းလိုက်တာပါ)
COPY nginx.conf /etc/nginx/nginx.conf
COPY nginx.conf /etc/nginx/http.d/default.conf

EXPOSE 80

# Server ကို Run ခိုင်းခြင်း
CMD nginx && php-fpm