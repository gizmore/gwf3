#!/bin/bash
groupadd -g 1022 level21
useradd -g 1022 -u 1022 -d /home/level/21_nurxxed -s /bin/false level21

# Create and clean www
mkdir -p /home/level/21_nurxxed/www
rm -R /home/level/21_nurxxed/www/.*

chown -R root:level21 /home/level/21_nurxxed
chmod -R 0750 /home/level/21_nurxxed

# Copy www files
cp -R /opt/php/gwf3/www/challenge/warchall/nurxxed/www/* /home/level/21_nurxxed/www
rm /home/level/21_nurxxed/www/.htaccess
chown -R root:level21 /home/level/21_nurxxed/www
chmod -R 0750 /home/level/21_nurxxed/www

# Copy VHOST APACHE
cp /opt/php/gwf3/www/challenge/warchall/nurxxed/install/nurxxed.conf /etc/apache2/vhosts.d
chown -R root:root /etc/apache2/vhosts.d
chmod -R 0600 /etc/apache2/vhosts.d/*
