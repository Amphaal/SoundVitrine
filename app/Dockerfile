# https://frankenphp.dev/docs/docker/
# note: prefer non-alpine for compatibility and performance (https://frankenphp.dev/fr/docs/performance/)
FROM dunglas/frankenphp:1-php8.3 AS base
RUN install-php-extensions \
	intl

#
FROM base AS base-xdebug
RUN install-php-extensions \
	xdebug

#
#
#

FROM base-xdebug AS runtime-xdebug
# COPY ./files /app/public
# COPY Caddyfile /etc/frankenphp/Caddyfile

# must be last, as default stage to be built if not selecting a specific target
FROM base
COPY ./files /app/public
# COPY Caddyfile /etc/frankenphp/Caddyfile
