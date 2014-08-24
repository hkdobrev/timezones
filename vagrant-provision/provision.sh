#!/usr/bin/env bash

if [ $# -eq 0 ]; then
    echo "usage: provision.sh <project-name>"
    exit 1
fi

PROJECT_NAME=$1

# Copy /etc configuration
sudo cp -r /vagrant/vagrant-provision/etc/* /etc/

# Configure en_US.UTF-8 locale
sudo locale-gen

# Update apt get repositories
sudo apt-get install python-software-properties
sudo add-apt-repository ppa:ondrej/php5
sudo apt-get update

# Set answers for mysql-server
sudo debconf-set-selections <<< 'mysql-server-5.1 mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server-5.1 mysql-server/root_password_again password root'

# Install Git, Apache, MySQL, PHP, htop and Vim
sudo apt-get -q -y install \
	git-core htop vim apache2 mysql-server mysql-client \
	php5 php5-imagick php5-gd php5-memcache php5-curl php5-intl \
	php5-mysqlnd php5-sqlite php5-xdebug php5-mcrypt

# Enable project virtual host
eval "sudo a2ensite ${PROJECT_NAME}.conf"
sudo service apache2 reload

# Remove password for MySQL root user
mysqladmin --user=root --password=root password ''

# Create MySQL databases
eval "mysql -uroot -e 'CREATE DATABASE IF NOT EXISTS ${PROJECT_NAME}
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci';"

eval "mysql -uroot -e 'CREATE DATABASE IF NOT EXISTS ${PROJECT_NAME}_test
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci';"

# Set environment variables
source /etc/environment

# Set up sudo-less binary path
mkdir -p $HOME/bin
export PATH=$PATH:/home/vagrant/bin

# Hush login message
touch $HOME/.hushlogin

# install composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/home/vagrant/bin --filename=composer
composer --working-dir=/vagrant install

# Make sure /tmp is writable
sudo chown -R vagrant:www-data /tmp
sudo chmod -R 777 /tmp
