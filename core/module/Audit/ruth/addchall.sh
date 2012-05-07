#!/bin/bash
groupadd -g $1 $2
useradd -m -u $1 -g $1 -d /home/level/$2 -s /usr/local/bin/sudosh $2
