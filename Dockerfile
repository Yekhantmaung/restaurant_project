FROM php:8.2-fpm-alpine

# လိုအပ်သော Packages များ သွင်းခြင်း
RUN apk add --no-cache \
    nginx shadow libpng-dev libjpeg-turbo-dev freetype-dev zip libzip-dev unzip git curl postgresql-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

# ⚠️ အရေးကြီးဆုံးအဆင့် - Nginx ရဲ့ default config လမ်းကြောင်းဟောင်းတွေကို အမြစ်ပြတ် ဆွဲဖြုတ်ပစ်တာပါ
RUN rm -rf /etc/nginx/http.d/* /etc/nginx/conf.d/*

# Laravel အလုပ်လုပ်မည့် Nginx Site Config အစစ်အမှန်ကို ဆောက်ခြင်း
RUN echo $'server {\n\
    listen 80;\n\
    root /var/www/public;\n\
    index index.php index.html;\n\
    charset utf-8;\n\
    location / {\n\
        try_files $uri $uri/ /index.php?$query_string;\n\
    }\n\
    location ~ \.php$ {\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;\n\
        include fastcgi_params;\n\
    }\n\
}' > /etc/nginx/http.d/default.conf

# Storage Permission ကို အပတ်စက် ပေးခြင်း
RUN chmod -R 777 /var/www/storage /var/www/bootstrap/cache
RUN chown -R www-data:www-data /var/www

EXPOSE 80

CMD php-fpm -D && nginx -g "daemon off;"