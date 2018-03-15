#!/bin/bash

set -e

cmd="$@"

export DBSERVER=db
export AUTH_MAGIC=XjosAXOzO1B3mE0egwQA
export MAIL_HOST=mailcatcher
export MAIL_PORT=1025


echo "Waiting for mysql"
until mysql -h db --password=password -uroot &> /dev/null
do
  printf "."
  sleep 1
done


>&2 echo "MySQL Ready"
/exec_env.sh
cd /var/www
composer install

if [ ! -e /eccube_installed ]; then
	php /var/www/eccube_install.php mysql none --skip-createdb --verbose
	echo "installed" > /eccube_installed
fi

chown -R www-data:www-data /var/www
apache2-foreground
