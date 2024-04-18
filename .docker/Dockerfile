# Docker file
FROM php:8.2-fpm

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

### apt-utils é um extensão de recursos do gerenciador de pacotes APT
RUN apt-get update
RUN apt-get install -y --no-install-recommends \
    apt-utils

# dependências recomendadas de desenvolvido para ambiente linux
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip \
    libpng-dev \
    libpq-dev \
    libxml2-dev

RUN docker-php-ext-install pdo pdo_pgsql pgsql session xml

# Instalando composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN docker-php-ext-install zip iconv simplexml pcntl gd fileinfo

# Node.js, NPM, Yarn
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs
RUN npm install npm@latest -g
RUN npm install yarn -g

### Permissões
WORKDIR /application
COPY ./src .
RUN cd /application

RUN chmod 755 -R storage
RUN chmod 755 -R bootstrap/cache

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Expondo as portas
EXPOSE 80 443