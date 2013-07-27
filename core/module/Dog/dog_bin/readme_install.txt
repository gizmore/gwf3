Lamb4/Dog install guide.

Lamb4/Dog is a GWF3 module meanwhile, so it needs at least the gwf3 core in "core/inc/", "core/inc/3p/" and the Dog module itself in "core/module/Dog"
Also, the "www/protected/" folder is required for the logfiles, db_backups and the gwf3_config.
Also, the "www/dbimg" folder is required by GWF_Mail and various modules to write application data files.

===================================

1) Create a database.

Of course you need to create a database for dog, by issuing these commands:

CREATE USER 'dog'@'localhost' IDENTIFIED BY 'dog';
CREATE DATABASE dog;
GRANT ALL ON dog.* TO 'dog'@'localhost' IDENTIFIED BY 'dog';

If you plan to use Dog+GW3Website, you can use the same database for both of it, but it's also possible to have a separate "config.php" for Dog.

===================================

2b) Install via install wizard.

You will need a webserver to access install/wizard.php
Simply follow the instructions to install gwf3 and the needed modules.
You will then have a working gwf3 website + Dog. 

===================================

2a) Install via mini installer for console.

This will install only the minimal components required for the Lamb bot.

First you need a working gwf3 config for Dog.
As we don't use install wizard, we have to create it manually from config.example.php


cd www/protected
cp config.example.php config.php 
nano config.php


To mini_install Dog simply run "php core/modules/Dog/dog_bin/dog.php config.php install"
This will also already launch the bot.
It is safe to exexute with "install" on any launch.

===================================

ANNOYING: Adding the first irc network

You have to do this manually in the database after the install.
You have to add 1 row to dog_servers and 1 row to dog_nicknames

dog_servers example: 2 	irc.freenode.net 	en 	CFILMPQbcefgijklmnopqrstvz 	DOQRSZaghilopswz 	305 	6697 	NULL
dpg_nicks   example: 1 	2 	Lamb3 	uhohnono 	Dawg 	dog.gizmore.org 	Doggy 	0

===================================

LAUNCHing THE BOT:
php core/modules/Dog/dog_bin/dog.php config.php install
