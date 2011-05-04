#!/bin/bash
# Call this script once a day

# Database Settings
# Please escape password properly.
MY_DB=lamb3;
MY_USER=lamb3;
MY_PASS=lamb3;

# Generate often used Vars
MY_DAY=`date +%d`
MY_DATE=`date +%y%m%d`
MY_FILENAME="$MY_DATE""_db_backup.sql.gz";

# Delete all files older than 7 days
find db_backups/* -mtime +7 -exec rm {} \;

# Back it up
mysqldump --user=$MY_USER --password=$MY_PASS $MY_DB | gzip -9 > "db_backups/$MY_FILENAME"

# Move the file if its a permanent backup 
if [ "$MY_DAY" == 01 ] || [ "$MY_DAY" == 15 ]
then
	mv "db_backups/$MY_FILENAME" "db_backups_old/$MY_FILENAME"
fi
