FROM php:7.1-apache

# Xdebug の設定に関して
# https://blog.philipphauer.de/debug-php-docker-container-idea-phpstorm/

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PGUSER cube3_dev_user

RUN apt-get update \
		&& apt-get install --no-install-recommends -y git curl wget sudo libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libxml2-dev libpq-dev libpq5 mysql-client ssl-cert \
        && pecl install mcrypt-1.0.1 \
        && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
        && docker-php-ext-install -j$(nproc) mbstring zip gd xml pdo pdo_pgsql pdo_mysql soap \
        && rm -r /var/lib/apt/lists/*

RUN pecl install xdebug-2.5.5 && docker-php-ext-enable xdebug
RUN echo 'zend_extension="/usr/local/lib/php/extensions/no-debug-non-zts-20151012/xdebug.so"' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_port=9000' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_enable=1' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_connect_back=1' >> /usr/local/etc/php/php.ini

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
