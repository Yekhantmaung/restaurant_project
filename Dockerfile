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

# ⚠️ အရေးကြီးဆုံးအဆင့် - Nginx config ဖိုင်အဟောင်းတွေကို အပြတ်ဖျက်ပြီး Laravel Routing စနစ်အမှန်ကို တိုက်ရိုက် ရေးထည့်ခိုင်းလိုက်တာပါ
RUN rm -f /etc/nginx/http.d/default.conf /etc/nginx/nginx.conf

# Nginx ရဲ့ Main Config ကို ဆောက်ခြင်း
RUN echo $'user www-data;\n\
worker_processes auto;\n\
pid /run/nginx.pid;\n\
events { worker_connections 1024; }\n\
http {\n\
    include /etc/nginx/mime.types;\n\
    default_type application/octet-stream;\n\
    sendfile on;\n\
    keepalive_timeout 65;\n\
    server {\n\
        listen 80;\n\
        root /var/www/public;\n\
        index index.php index.html;\n\
        charset utf-8;\n\
        location / {\n\
            try_files $uri $uri/ /index.php?$query_string;\n\
        }\n\
        error_page 404 /index.php;\n\
        location ~ \.php$ {\n\
            fastcgi_pass 127.0.0.1:9000;\n\
            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;\n\
            include fastcgi_params;\n\
        }\n\
    }\n\
}' > /etc/nginx/nginx.conf

# Port 80 ကို ဖွင့်ပေးခြင်း
EXPOSE 80

# PHP-FPM နှင့် Nginx ကို အပိတ်မကျအောင် စနစ်တကျ Run ခြင်း
CMD php-fpm -D && nginx -g "daemon off;"