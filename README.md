# WordPress Plugin Boilerplate

## Features

* [PSR-4: Autoloader](https://www.php-fig.org/psr/psr-4/)

## Composer

    composer create-project --no-install --remove-vcs arya/wordpress-plugin DIRECTORY dev-master

## Docker (18.06.0+)

Create and start the container

    docker-compose up -d
    docker exec CONTAINER chown -R www-data:www-data /var/www/html

Stop and remove containers, networks, images, and volumes

    docker-compose down --volumes

