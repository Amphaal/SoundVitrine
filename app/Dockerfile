# https://frankenphp.dev/docs/docker/
# note: prefer non-alpine for compatibility and performance (https://frankenphp.dev/fr/docs/performance/)
FROM dunglas/frankenphp:1-php8.3 AS base
RUN install-php-extensions \
	intl

#
FROM base AS base-xdebug
RUN install-php-extensions \
	xdebug
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	&& echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

#
#
#

FROM base-xdebug AS runtime-xdebug
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY ./files /app/public
COPY ./Caddyfile /etc/frankenphp/Caddyfile

# must be last, as default stage to be built if not selecting a specific target
FROM base
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY ./files /app/public
COPY ./Caddyfile /etc/frankenphp/Caddyfile
