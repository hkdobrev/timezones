#!/usr/bin/env bash

if [ $# -eq 0 ]; then
    >&2 echo "usage: provision.sh <project-name>"
    exit 1
fi

PROJECT_NAME=$1
SCRIPTPATH=/vagrant/provision

echo "Copying $SCRIPTPATH/etc to /etc..."
sudo cp -r $SCRIPTPATH/etc/* /etc/

echo "Configuring en_US.UTF-8 locale..."
sudo locale-gen --purge en_US.UTF-8.1 >/dev/null

# Update apt get repositories
sudo apt-get install python-software-properties
sudo add-apt-repository ppa:ondrej/php5
sudo apt-get update

# Set answers for mysql-server
sudo debconf-set-selections <<< 'mysql-server-5.1 mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server-5.1 mysql-server/root_password_again password root'

# Install Git, Apache, MySQL, PHP, htop and Vim
sudo apt-get -q -y install \
	git-core htop vim \
    apache2 \
    mysql-server mysql-client \
	php5 php5-curl php5-intl php5-mcrypt \
    php5-imagick php5-gd \
    php5-memcache php5-apcu \
	php5-mysqlnd php5-sqlite \
    php5-xdebug

# Enable project virtual host
eval "sudo a2ensite ${PROJECT_NAME}.conf"
sudo service apache2 reload

# Remove password for MySQL root user
mysqladmin --user=root --password=root password '' >/dev/null 2>&1

# Create MySQL databases
eval "mysql -uroot -e 'CREATE DATABASE IF NOT EXISTS ${PROJECT_NAME}
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci';"

eval "mysql -uroot -e 'CREATE DATABASE IF NOT EXISTS ${PROJECT_NAME}_test
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci';"

echo "Creating Vagrant MySQL user with all priveleges..."
mysql -uroot -e "GRANT ALL PRIVILEGES ON *.* TO 'vagrant'@'%' IDENTIFIED BY '';"
mysql -uroot -e "GRANT ALL PRIVILEGES ON *.* TO 'vagrant'@'localhost' IDENTIFIED BY '';"
mysql -uroot -e "GRANT ALL PRIVILEGES ON *.* TO 'vagrant'@'127.0.0.1' IDENTIFIED BY '';"

# Set environment variables
source /etc/environment

# Set up sudo-less binary path
mkdir -p $HOME/bin
export PATH=$PATH:/home/vagrant/bin

# Hush login message
touch $HOME/.hushlogin

echo "Install Composer..."
curl -sS https://getcomposer.org/installer | php -- --install-dir=/home/vagrant/bin --filename=composer
composer --version
composer --working-dir=/vagrant install

echo "Cleanup apt-get..."
sudo apt-get autoremove
