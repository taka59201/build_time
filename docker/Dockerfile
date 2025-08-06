FROM php:8.3.7-apache

# ドキュメントルートを変更
ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e "s!DocumentRoot /var/www/html!DocumentRoot ${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/000-default.conf \
 && sed -ri -e "s!<Directory /var/www/>!<Directory ${APACHE_DOCUMENT_ROOT}/>!g" /etc/apache2/apache2.conf \
 && sed -ri -e "s!AllowOverride None!AllowOverride All!g" /etc/apache2/apache2.conf \
 && a2enmod rewrite

# パッケージインストール
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    zlib1g-dev \
    unzip \
    locales \
    vim \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Apache の rewrite_module を有効化
RUN a2enmod rewrite

# PHP のエクステンションをインストール 〜コメントアウトしているライブラリはお好みで〜
RUN docker-php-ext-install \
    # ctype \
    # curl \
    # dom \
    # fileinfo \
    # filter \
    # hash \
    intl \
    # json \
    # mbstring \
    # openssl \
    # pcre \
    # PDO \
    pdo_mysql \
    # pdo_sqlite \
    # session \
    # tokenizer \
    # xml \
    zip

RUN pecl install xdebug && \
    docker-php-ext-enable xdebug

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
 && apt-get update \
 && apt-get install -y --no-install-recommends nodejs \
 && rm -rf /var/lib/apt/lists/*

# Composer インストール
COPY --from=composer /usr/bin/composer /usr/bin/composer

# コンテナログイン時のパス指定
WORKDIR /var/www

