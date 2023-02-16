FROM php:8.1.14-fpm-buster

# Copia os arquivos para dentro da container
COPY ./docker/php-fpm/composer.sh /usr/local/bin/composer
COPY ./docker/php-fpm/artisan.sh /usr/local/bin/artisan

# Instala as extensões do PHP e outras ferramentas
RUN apt-get update && apt-get install -y libmcrypt-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql bcmath soap \
    && apt-get install -q -y wget curl openssl git zip unzip nano \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Instalar o GD
#RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && docker-php-ext-install gd

# Instalar o zip
#RUN apt-get update && apt-get install -y zlib1g-dev && docker-php-ext-configure zip && docker-php-ext-install zip

# instala o composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer.phar

# Limpa tudo para a imagem ficar mais leve
RUN apt-get autoremove -y && apt-get clean

RUN chmod 0777 /usr/local/bin/artisan /usr/local/bin/composer /usr/local/bin/composer.phar

WORKDIR /var/www/html

EXPOSE 9000
