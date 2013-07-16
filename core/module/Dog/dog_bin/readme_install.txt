Lamb install guide.

Lamb3 is a GWF3 module meanwhile, so it needs at least the gwf3 core in "core/inc/", "core/inc/3p/" and the lamb module itself in "core/module/Lamb"
Also, the "protected/" folder is used for the logfiles, db_backups and the gwf3_config.

===================================

1) Create a database.

Of course you need to create a database for lamb, by issuing these commands:

CREATE USER 'lamb3'@'localhost' IDENTIFIED BY 'lamb3';
CREATE DATABASE lamb3;
GRANT ALL ON lamb3.* TO 'lamb3'@'localhost' IDENTIFIED BY 'lamb3';

If you plan to use lamb+website, you can use the same database for both of it, but it's also possible to have a separate gwfconfig for lamb.

===================================

2b) Install via install wizard.

You will need a webserver to access install/wizard.php
Simply follow the instructions and all modules will be installed.
You will then have a working gwf3 website + bot. 

===================================

2a) Install via mini installer for console.

This will install only the minimal components required for the Lamb bot.

First you need a working gwf3 config for lamb.
As we don't use install wizard, we have to create it manually from config.example.php

cd protected
cp config.example.php config.php 
nano config.php

Now we edit the lamb config in core/module/Lamb/lamb_bin/Lamb_Config.php

Then we patch lamb_mini_install.php to make use of the right gwf3 config file.

Now we try to run the lamb_mini_install.php:

cd core/module/Lamb/lamb_bin
php lamb_mini_install.php

Now we create our own .sh file to launch the bot:
cd core/module/Lamb/lamb_bin
cp lamb.sh my_lamb.sh
nano my_lamb.sh

IMPORTANT Is to give the right config files to the lamb.php!

If everything works well, run the bot via:
cd core/module/Lamb/lamb_bin
./my_lamb.sh

===================================
