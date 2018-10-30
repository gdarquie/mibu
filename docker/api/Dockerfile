FROM php:7.1-alpine

RUN apk add --no-cache \
        curl \
        gnupg \
        git \
        imagemagick \
        icu-dev \
        postgresql-dev \
        zlib-dev \
        netcat-openbsd

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/include/postgresql/
RUN docker-php-ext-install \
    bcmath \
    intl \
    mbstring \
    pcntl \
    pdo_pgsql \
    pgsql \
    shmop \
    zip

ENV JWT_SECRET_KEY="%kernel.project_dir%/config/jwt/private.pem"
ENV JWT_PUBLIC_KEY="%kernel.project_dir%/config/jwt/public.pem"
ENV JWT_PASSPHRASE=1234

WORKDIR /var/www/html

COPY ./entrypoint.sh /docker/

ENTRYPOINT ["/bin/sh", "/docker/entrypoint.sh"]
CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html/public", "/var/www/html/public/index.php"]
