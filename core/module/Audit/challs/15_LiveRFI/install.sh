#!/bin/bash
groupadd -g 1016 level15
useradd -g 1016 -u 1016 -d /home/level/15_live_rfi -s /bin/false level15

# Create and clean www
mkdir /home/level/15_live_rfi/www
rm -R /home/level/15_live_rfi/www/.*

chown -R root:level15 /home/level/15_live_rfi
chmod -R 0750 /home/level/15_live_rfi

# Copy www files
cp -R /opt/php/gwf3/www/challenge/warchall/live_rfi/www/* /home/level/15_live_fi/www
rm /home/level/15_live_rfi/www/.htaccess
chown -R root:level15 /home/level/15_live_rfi/www
chmod -R 0750 /home/level/15_live_rfi/www
chmod -R 0770 /home/level/15_live_rfi/www/temp

# Copy VHOST APACHE
cp /opt/php/gwf3/www/challenge/warchall/live_rfi/install/live_rfi.conf /etc/apache2/vhosts.d
chown -R root:root /etc/apache2/vhosts.d
chmod -R 0600 /etc/apache2/vhosts.d/*
