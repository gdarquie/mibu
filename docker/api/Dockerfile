FROM php:7.1.23

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        gnupg2 \
        git-core \
        imagemagick \
        libicu-dev \
        libghc-postgresql-libpq-dev \
        zlib1g-dev \
        netcat-openbsd \
    && rm -rf /var/lib/apt/lists/*

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

# Install composer
RUN curl -k -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer global require hirak/prestissimo \
    && composer clear-cache

ENV DATABASE_URL_TEST="pgsql://postgres:password@mibu_db:5432/fictio"
ENV JWT_SECRET_KEY="%kernel.project_dir%/config/jwt/private.pem"
ENV JWT_PUBLIC_KEY="%kernel.project_dir%/config/jwt/public.pem"
ENV JWT_PASSPHRASE=1234

WORKDIR /var/www/html

CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html/public", "/var/www/html/public/index.php"]
