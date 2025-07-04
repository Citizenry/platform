FROM php:8.2-fpm-alpine
LABEL org.opencontainers.image.source="https://github.com/ushahidi/platform"

# TODO: non-root user container setup
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install system dependencies
RUN apk add --no-cache \
    $PHPIZE_DEPS \
    bash \
    curl \
    git

# Install dockerize
ENV DOCKERIZE_VERSION v0.6.1
RUN curl -sL https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz | tar xz \
    && mv dockerize /usr/local/bin/dockerize

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www

# Install Composer
COPY composer.json ./
COPY composer.lock ./
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"
RUN composer install --no-autoloader --no-scripts

# Copy application code and scripts
COPY . .
COPY docker/utils.sh /utils.sh
COPY docker/run.tasks.conf /etc/chaperone.d/
COPY docker/run.run.sh /run.run.sh
RUN echo '#!/bin/bash\n. /utils.sh\n"$@"' > /bin/util ; chmod +x /bin/util ;

ARG GIT_COMMIT_ID
ARG GIT_BUILD_REF

ENV ENABLE_PLATFORM_TASKS=true \
    DB_MIGRATIONS_HANDLED=true \
    RUN_PLATFORM_MIGRATIONS=true \
    VHOST_ROOT=/var/www/httpdocs \
    VHOST_INDEX=index.php \
    PHP_EXEC_TIME_LIMIT=3600 \
    GIT_COMMIT_ID=${GIT_COMMIT_ID} \
    GIT_BUILD_REF=${GIT_BUILD_REF}

ENTRYPOINT ["dockerize", "-wait", "tcp://mysql:3306", "-timeout", "60s"]
# The default command to run PHP-FPM
CMD [ "php-fpm" ]
