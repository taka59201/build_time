# PHPの公式イメージを使用
FROM php:8.2-fpm

# Node.jsとnpmのインストール
RUN apt-get update && apt-get install -y \
  curl \
  git \
  unzip \
  libpng-dev \
  nodejs \
  npm

# 必要な拡張機能をインストール
RUN apt-get update && apt-get install -y \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  locales \
  zip \
  unzip \
  git \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo pdo_mysql gd

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリの設定
WORKDIR /var/www
