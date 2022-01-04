FROM php:7.4.11-apache-buster

# Copia os arquivos para dentro da container
COPY ./docker/composer.sh /usr/local/bin/composer
COPY ./docker/app.conf /etc/apache2/sites-available/000-default.conf
COPY ./docker/app.ini /usr/local/etc/php/conf.d/php-extras.ini
COPY ./docker/artisan.sh /usr/local/bin/artisan
COPY ./docker/init.sh /init.sh

# Instala as extensões do PHP e outras ferramentas
RUN apt-get update && apt-get install -y libmcrypt-dev libxml2-dev
RUN docker-php-ext-install pdo pdo_mysql bcmath soap
RUN apt-get install -q -y wget curl openssl git zip unzip nano

# Instalar o GD
#RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && docker-php-ext-install gd

# Instalar o zip
#RUN apt-get update && apt-get install -y zlib1g-dev && docker-php-ext-configure zip && docker-php-ext-install zip

# instala o composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer.phar

# Limpa tudo para a imagem ficar mais leve
RUN apt-get autoremove -y && apt-get clean

RUN chown -R www-data:www-data /var/www/html && a2enmod rewrite
RUN chmod 0777 /init.sh /usr/local/bin/artisan /usr/local/bin/composer /usr/local/bin/composer.phar

WORKDIR /var/www/html

EXPOSE 80

CMD ["/init.sh"]
