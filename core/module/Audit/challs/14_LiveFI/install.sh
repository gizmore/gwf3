#!/bin/bash
groupadd -g 1015 level14
useradd -g 1015 -u 1015 -d /home/level/14_live_fi -s /bin/false level14

# Create and clean www
mkdir /home/level/14_live_fi/www
rm -R /home/level/14_live_fi/www/.*

chown -R root:level14 /home/level/14_live_fi
chmod -R 0750 /home/level/14_live_fi

# Copy www files
cp /opt/php/gwf3/www/challenge/warchall/live_lfi/www/* /home/level/14_live_fi/www
rm /home/level/14_live_fi/www/.htaccess
chown -R root:level14 /home/level/14_live_fi/www
chmod -R 0640 /home/level/14_live_fi/www

# Copy VHOST APACHE
cp /opt/php/gwf3/www/challenge/warchall/live_lfi/install/live_fi.conf /etc/apache2/vhosts.d
chown -R root:root /etc/apache2/vhosts.d
chmod -R 0600 /etc/apache2/vhosts.d/*
