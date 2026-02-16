FROM php:8.2.30-fpm

RUN echo 'alias ll="ls -la"' >> ~/.bashrc
RUN apt-get update
RUN apt-get install -y less
RUN apt-get install -y nano
#RUN apt-get install -y libfreetype6-dev
#RUN apt-get install -y libjpeg62-turbo-dev
RUN apt-get install -y libpng-dev

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install gd

WORKDIR /var/www/csrv