#!/bin/sh
chown -R www-data:www-data /var/www/html/storage/public

su-exec www-data php /var/www/html/public/index.php migrate
su-exec www-data php /var/www/html/public/index.php seed
su-exec www-data php /var/www/html/public/index.php create_user --name=Ilya --email=sange0337@gmail.com --password=password

exec "$@"
