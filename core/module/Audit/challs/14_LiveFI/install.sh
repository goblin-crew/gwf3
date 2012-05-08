#!/bin/bash
groupadd -g 1015 level14
useradd -g 1015 -u 1015 -d /home/level/14_live_fi -s /bin/false level14

mkdir /home/level/14_live_fi/www
chown -R root:level14 /home/level/14_live_fi
chmod 0740 /home/level/14_live_fi

rm -R /home/level/14_live_fi/www/.*
cp /opt/php/gwf3/www/challenge/warchall/project97/www/* /home/level/14_live_fi/www
rm /home/level/14_live_fi/www/.htaccess
chown -R root:level14 /home/level/14_live_fi/www
chmod -R 0640 /home/level/14_live_fi/www

cp /opt/php/gwf3/www/challenge/warchall/project97/install/live_fi.conf /etc/apache2/vhosts.d
chown -R root:root /etc/apache2/vhosts.d
chmod -R 0600 /etc/apache2/vhosts.d/*
