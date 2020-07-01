FROM php:7.2-cli

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /usr/src/app

CMD [ "php", "./demo.php" ]