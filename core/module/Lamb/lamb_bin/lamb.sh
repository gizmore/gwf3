#!/bin/bash

# TODO: clone this file or add options

# chroot
cd ../../../../

# backup db
cd www/protected
./db_backup.sh
cd ../../

# exec bot
php core/module/Lamb/lamb_bin/lamb_main.php www/protected/config_lamb.php Lamb_Config.php

# Oops
mplayer core/module/Lamb/lamb_bin/wecken.mp3
