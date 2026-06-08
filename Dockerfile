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

# ... (အပေါ်က ကုဒ်တွေကို ဒီအတိုင်းထားပါ) ...

# Permission သတ်မှတ်ချက် (ဒီအတိုင်းထားပါ)
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# ⚠️ အရေးကြီးဆုံးအဆင့် - ရှိသမျှ default config အဟောင်းတွေကို အမြစ်ပြတ်အောင် အတင်းဖျက်ခိုင်းလိုက်တာပါ
RUN rm -f /etc/nginx/http.d/default.conf /etc/nginx/conf.d/default.conf /etc/nginx/nginx.conf

# ပြီးမှ ကျွန်တော်တို့ရဲ့ Laravel ရေလမ်းကြောင်းပါတဲ့ nginx.conf ကို နေရာမှန်ဆီ သွားထည့်ခိုင်းပါမယ်
COPY nginx.conf /etc/nginx/http.d/default.conf

EXPOSE 80

# Server ကို Run ခိုင်းခြင်း
CMD nginx && php-fpm