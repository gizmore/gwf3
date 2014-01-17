#!/bin/bash
gcc webspace_on.c
mv a.out /home/features/webserver_on
chmod 4755 /home/features/webserver_on

gcc webspace_off.c
mv a.out /home/features/webserver_off
chmod 4755 /home/features/webserver_off
