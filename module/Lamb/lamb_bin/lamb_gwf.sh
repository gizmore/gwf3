#!/bin/bash

# TODO: clone this file or add options

# chroot
cd ../../../

# backup db
cd protected
./db_backup.sh
cd ../

# exec bot
php module/Lamb/lamb_bin/lamb_main.php protected/config.php Lamb_Config.php

# Oops
mplayer module/Lamb/lamb_bin/wecken.mp3
