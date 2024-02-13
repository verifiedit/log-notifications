FROM php:8.3

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y git

RUN install-php-extensions pcov @composer

COPY entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

ENTRYPOINT [ "/entrypoint.sh" ]
