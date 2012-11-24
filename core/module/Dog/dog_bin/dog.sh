#!/bin/bash
# -*- coding: utf-8 -*-

curl http://192.168.0.4/dogstart.php?shall_restart=1

php dog.php $1 $2 $3 $4

while true;
do
	STATUS=`curl http://192.168.0.4/dogstart.php?shall_restart=1`
	if [ $STATUS == "1" ];
	then
		php dog.php $1 $2 $3 $4
	fi

	sleep 5
	
done
