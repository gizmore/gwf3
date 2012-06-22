#!/bin/bash
# -*- coding: utf-8 -*-

usage() {

cat <<<EOF
usage: $(basename $0) <config_lamp.php> <Lamb_Config.php> <www> <backup> <music>

EOF

}

if [ $# -eq 0 -o "$1" == "--help" -o "$1" == "-h" ]; then
	usage()
	exit 1
fi

# chroot
if [ $3 -eq 1 ]; then
	cd ../../../../
fi

# backup db
if [ $4 -eq 1 ]; then
	cd protected
	./db_backup.sh # WTF ?? why cd ?
	cd ..
fi

# paths
if [ $1 = "dev" ]; then
	config="www/protected/config_lamb_dev.php"
elif [ $1 = "gwf" ]; then #FIXME: name
	config="protected/config.php"
else
	config="protected/config.php"
fi

if [ $2 = "dev" ]; then
	lamb="Lamb_Config_dev.php"
else
	lamb="Lamb_Config_dev.php"
fi

#exec bot
php core/module/Lamb/lamb_bin/lamb_main.php $config $lamb

# Oops
case $5 in
	"once")
		# play music once
		mplayer core/module/Lamb/lamb_bin/wecken.mp3
		;;
	"yes")
		# play music every 20 seconds
		while [ 1 ]
		do
			mplayer core/module/Lamb/lamb_bin/wecken.mp3
			sleep 20
		done
		;;
esac
