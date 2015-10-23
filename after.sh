#!/bin/bash

#Variables
DBHOST=localhost
DBNAME=spacexstats
DBUSER=localuser
DBPASSWD=localpassword

echo "Begin custom provisioning..."

echo "Installing ffmpeg"
#sudo add-apt-repository ppa:kirillshkrogalev/ffmpeg-next -y >/dev/null 2>&1
#sudo apt-get update >/dev/null 2>&1
#sudo apt-get install ffmpeg -y

echo "Installing & starting Elasticsearch"
sudo apt-get install openjdk-7-jre-headless -y > /dev/null
wget https://download.elastic.co/elasticsearch/elasticsearch/elasticsearch-1.7.3.deb >/dev/null 2>&1
sudo dpkg -i elasticsearch-1.7.3.deb > /dev/null
sudo service elasticsearch start

echo "Installing PHP extensions..."
#sudo apt-get install php5-imagick -y

echo "Customizing MySQL..."
#mysql -uroot -psecret -e "grant all privileges on $DBNAME.* to '$DBUSER'@'localhost' identified by '$DBPASSWD'"

echo "Migrating..."
#cd /home/vagrant/spacexstats
#php artisan migrate
#php artisan db:seed

echo "Restarting nginx..."
service nginx restart