FROM php:7.2.3-apache

# Xdebug の設定に関して
# http://blog.shin1x1.com/entry/setup-test-and-debug-on-phpstorm-and-docker-for-mac

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PGUSER cube3_dev_user

RUN apt-get update \
		&& apt-get install --no-install-recommends -y git curl wget sudo libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libxml2-dev libpq-dev libpq5 mysql-client ssl-cert \
        && pecl install mcrypt-1.0.1 \
        && pecl install xdebug-2.6.0 \
        && docker-php-ext-enable xdebug \
        && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
        && docker-php-ext-install -j$(nproc) mbstring zip gd xml pdo pdo_pgsql pdo_mysql soap \
        && rm -r /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin \
        && composer global require --optimize-autoloader "hirak/prestissimo"

COPY php.ini ${PHP_INI_DIR}/
ADD exec_env.sh /exec_env.sh
ADD entrypoint.sh /entrypoint.sh

RUN useradd -ms /bin/bash ${PGUSER} \
	&& chmod +x /entrypoint.sh \
	&& chmod +x /exec_env.sh

EXPOSE 80
WORKDIR /var/www
ENTRYPOINT /entrypoint.sh
