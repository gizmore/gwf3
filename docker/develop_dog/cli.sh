#!/bin/bash

# prevent attempts at name resolution from causing long timeouts
echo "nameserver 127.0.0.1" > /etc/resolv.conf

/ircd/miniircd --setuid root &

# show ip
ip a s eth0

echo
echo ".super default password: gizmore"
echo "Shadowlamb: must add core/module/Dog/dog_modules/dog_module/Shadowlamb/secret.php"
echo "Shadowlamb: for #gm*, must add core/module/Dog/dog_modules/dog_module/Shadowlamb/GameMasters.php"
echo

while true; do

  echo -n "> "
  read cmd

  case "$cmd" in
    "setup")
      # use example config
      cp /gwf3_src/www/protected/config.example.php /gwf3_run/config.php

      # create dog db
      mysql -e "CREATE USER 'dog'@'localhost' IDENTIFIED BY 'dog'; CREATE DATABASE dog; GRANT ALL ON dog.* TO 'dog'@'localhost' IDENTIFIED BY 'dog';"

      # this will fail a bit, but not a big problem, it seems
      php /gwf3_src/core/module/Dog/dog_bin/dog.php ../../../gwf3_run/config.php install

      # add local irc server
      mysql -e "USE dog; INSERT INTO dog_servers (serv_host, serv_port) VALUES ('localhost', 6667); INSERT INTO dog_nicks (nick_sid, nick_name) VALUES (1, 'dog');"
      ;;

    "run")
      php /gwf3_src/core/module/Dog/dog_bin/dog.php ../../../gwf3_run/config.php
      ;;

    "shell")
      bash
      ;;

    "help")
      echo "setup  setup dog (only needed once if you keep the volumes)"
      echo "run    start dog"
      echo "shell  open (bash) shell"
      echo "help   list all available commands"
      echo "quit   quit"
      ;;

    "quit")
      exit 0
      ;;

    *)
      echo "unknown command: $cmd"
      echo "try: help"
      ;;
  esac

done
