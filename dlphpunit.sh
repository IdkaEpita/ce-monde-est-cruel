#!/bin/sh

wget https://phar.phpunit.de/phpunit-9.4.0.phar
chmod +x phpunit-9.4.0.phar
sudo mv phpunit-9.4.0.phar /usr/local/bin/phpunit
phpunit --version && echo "tout est ok"