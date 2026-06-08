FROM php:8.2-cli-alpine

# လိုအပ်သော System packages များနှင့် PHP Extensions များ သွင်းခြင်း
RUN apk add --no-cache \
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

# Laravel Storage နှင့် Cache ဖိုင်များအတွက် ခွင့်ပြုချက် (Permission) အပြည့်ပေးခြင်း
RUN chmod -R 777 /var/www/storage /var/www/bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Port 80 ကို ဖွင့်ပေးခြင်း
EXPOSE 80

# ⚠️ အောက်က CMD စာကြောင်းအဟောင်းကို ဖြုတ်ပြီး ဒီစာကြောင်းအသစ်နဲ့ အစားထိုးပေးပါဗျာ
# ဒါဆိုရင် ဆာဗာပွင့်တိုင်း Database ထဲမှာ လိုအပ်တဲ့ Users Table တွေကို အလိုအလျောက် ဝင်ဆောက်ပေးသွားမှာပါ
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=80