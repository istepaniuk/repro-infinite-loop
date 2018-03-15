FROM zaherg/php-7.1-xdebug-alpine

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /srv
