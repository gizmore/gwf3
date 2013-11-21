#!/bin/bash
# -*- coding: utf-8 -*-

curl http://192.168.0.4/dogstart.php?shall_restart=1

USERNAME = `whoami`

php dog.php $1 $2 $3 $4 $USERNAME

mplayer /DATA/_ProjectPDT7/GWF3/core/module/Lamb/lamb_bin/wecken.mp3
mplayer /DATA/_ProjectPDT7/GWF3/core/module/Lamb/lamb_bin/wecken.mp3
mplayer /DATA/_ProjectPDT7/GWF3/core/module/Lamb/lamb_bin/wecken.mp3

#while true;
#do
#	STATUS=`curl http://192.168.0.4/dogstart.php?shall_restart=1`
#	if [ $STATUS == "1" ];
#	then
#		php dog.php $1 $2 $3 $4
#	fi
#
#	sleep 5
#	
#done
