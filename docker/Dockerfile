FROM php:7.4-apache

RUN apt update

RUN apt install -y git
RUN apt install -y zip
RUN apt install -y curl
RUN apt install -y unzip
RUN apt install -y libicu-dev
RUN apt install -y libbz2-dev
RUN apt install -y libpng-dev
RUN apt install -y libjpeg-dev
RUN apt install -y libmcrypt-dev
RUN apt install -y libreadline-dev
RUN apt install -y libfreetype6-dev
RUN apt install -y libzip-dev
RUN apt install -y g++
RUN apt install -y nodejs
RUN apt install -y npm
#RUN apt install -y oniguruma

RUN docker-php-ext-install bz2
RUN docker-php-ext-install intl
RUN docker-php-ext-install iconv
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install opcache
RUN docker-php-ext-install calendar
#RUN docker-php-ext-install mbstring
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite
