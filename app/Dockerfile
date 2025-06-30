FROM phpswoole/swoole:php8.3-alpine

# install requirements
# note: we must do it in one single layer to allow optimization of build size
RUN apk add icu-dev \
    && docker-php-ext-configure intl \ 
    && docker-php-ext-install intl \
    && docker-php-ext-enable intl

# copy files
COPY . /var/www

# Expose the port used by your Swoole server
ENV PORT=9501
EXPOSE 9501

# Run the server
CMD ["php", "/var/www/server.php"]