# chroot
cd ../../../

# backup db
cd protected
./db_backup.sh
cd ../

# exec bot
php module/Lamb/lamb_bin/lamb_main.php
