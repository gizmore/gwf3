#!/bin/bash
groupadd -g 1021 level20
useradd -g 1021 -u 1021 -d /home/level/20_live_fi -s /bin/false level20

# Create and clean www
mkdir /home/level/20_live_rce/www
rm -R /home/level/20_live_rce/www/.*

chown -R root:level20 /home/level/20_live_rce
chmod -R 0750 /home/level/20_live_rce

# Copy www files
cp -R /opt/php/gwf3/www/challenge/warchall/live_rce/www/* /home/level/20_live_rce/www
rm /home/level/20_live_fi/www/.htaccess
chown -R root:level20 /home/level/20_live_rce/www
chmod -R 0750 /home/level/20_live_rce/www
chmod -R 0770 /home/level/14_live_rce/www/temp

# Copy VHOST APACHE
cp /opt/php/gwf3/www/challenge/warchall/live_lfi/install/live_fi.conf /etc/apache2/vhosts.d
chown -R root:root /etc/apache2/vhosts.d
chmod -R 0600 /etc/apache2/vhosts.d/*
