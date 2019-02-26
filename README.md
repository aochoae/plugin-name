# WordPress Plugin Boilerplate

# Requirements

* PHP version 7.0 or greater
* WordPress 5.0 or greater

## Features

* [PSR-1: Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)
* [PSR-2: Coding Style Guide](https://www.php-fig.org/psr/psr-2/)
* [PSR-4: Autoloader](https://www.php-fig.org/psr/psr-4/)

## Composer

    composer create-project --no-install --remove-vcs arya/wordpress-plugin DIRECTORY dev-master

## Docker (18.06.0+)

Create and start the container

    docker-compose up -d
    docker exec CONTAINER chown -R www-data:www-data /var/www/html

Stop and remove containers, networks, images, and volumes

    docker-compose down --volumes

## License

This project is licensed under the GNU General Public License, Version 2.0.
See [LICENSE](LICENSE) for the full license text.
