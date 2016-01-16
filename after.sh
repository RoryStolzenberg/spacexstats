#!/bin/bash

#Variables
DBHOST=localhost
DBNAME=spacexstats
DBUSER=localuser
DBPASSWD=localpassword

echo "Begin custom provisioning..."

echo "[1/7] Installing ffmpeg..."
sudo add-apt-repository ppa:kirillshkrogalev/ffmpeg-next -y >/dev/null 2>&1
sudo apt-get update
sudo apt-get install ffmpeg -y

echo "[2/7] Installing & starting Elasticsearch..."
sudo apt-get update

# install java
sudo apt-get install openjdk-7-jre-headless -y >/dev/null 2>&1

# fetch and install elasticsearch
wget https://download.elasticsearch.org/elasticsearch/elasticsearch/elasticsearch-1.7.3.deb >/dev/null 2>&1
sudo dpkg -i elasticsearch-1.7.3.deb >/dev/null 2>&1

# make elasticsearch run on startup
update-rc.d elasticsearch defaults 95 10

sudo service elasticsearch start

echo "[3/7] Installing PHP extensions..."
sudo apt-get install php5-imagick -y
sudo service php5-fpm restart

echo "[4/7] Customizing MySQL..."
mysql -uroot -psecret -e "grant all privileges on $DBNAME.* to '$DBUSER'@'localhost' identified by '$DBPASSWD'"

#uninstall postgres
if [ -f "/etc/init.d/postgresql" ];  then
	apt-get purge -y postgresql-9.4 postgresql-client-common postgresql-contrib-9.4 postgresql-client-9.4 postgresql-common
	apt-get autoremove -y -qq
fi

echo "[5/7] Migrating..."
cd /home/vagrant/spacexstats
php artisan migrate
php artisan db:seed

echo "[6/7] Setting up Node.js server"
# --no-bin-links is not required if you are not using Vagrant for Windows
npm install -g --save --no-bin-links
forever start socket.js

echo "[7/7] Creating queue listeners"
apt-get install supervisor

echo [program:laravel-worker] >> /etc/supervisor/conf.d/laravel-worker.conf
echo command=php /home/vagrant/spacexstats/artisan queue:work redis --queue=default,live,email,uploads --sleep=1 --tries=3 --daemon >> /etc/supervisor/conf.d/laravel-worker.conf
echo autostart=true >> /etc/supervisor/conf.d/laravel-worker.conf
echo autorestart=true >> /etc/supervisor/conf.d/laravel-worker.conf
echo user=root >> /etc/supervisor/conf.d/laravel-worker.conf
echo numprocs=1 >> /etc/supervisor/conf.d/laravel-worker.conf
echo redirect_stderr=true >> /etc/supervisor/conf.d/laravel-worker.conf
echo stdout_logfile=/home/vagrant/spacexstats/worker.log >> /etc/supervisor/conf.d/laravel-worker.conf

supervisorctl reread
supervisorctl update
supervisorctl start laravel-worker:*

echo "[8/8] Restarting nginx..."
service nginx restart