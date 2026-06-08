FROM php:8.2-fpm-alpine

# လိုအပ်သော System packages များနှင့် PHP Extensions များ သွင်းခြင်း
RUN apk add --no-cache \
    nginx \
    shadow \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    libzip-dev \
    unzip \
    git \
    curl \
    postgresql-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql zip

# Composer သွင်းခြင်း
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# အလုပ်လုပ်မည့် Directory သတ်မှတ်ခြင်း
WORKDIR /var/www

# Project ဖိုင်များအားလုံးကို Container ထဲ ကူးထည့်ခြင်း
COPY . .

# Composer package များ သွင်းခြင်း
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Laravel Storage နှင့် Cache ဖိုင်များအတွက် ခွင့်ပြုချက် (Permission) ပေးခြင်း
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# ကျွန်တော်တို့ ပြင်ဆင်ထားသော Nginx Config ကို အဓိကလမ်းကြောင်းတွင် အတင်းအစားထိုးခြင်း
COPY nginx.conf /etc/nginx/nginx.conf

# Port 80 ကို ဖွင့်ပေးခြင်း
EXPOSE 80

# PHP-FPM ကို Background တွင် Run ပြီး Nginx ကို ရှေ့တန်း (Foreground) တွင် အပိတ်မကျအောင် ထိန်းပြီး Run ခြင်း
CMD php-fpm -D && nginx -g "daemon off;"