#!/bin/bash
#
# Daily database backup and log zipping.
# Call this script once a day.
# Example crontab for 3 o'clock: 0 3 * * * cd /path/to/protected && ./db_backup.sh
#
# @author: gizmore
#
###################
### DB settings ###
###################
# Please escape password properly.
MY_DB=lamb3;   # Edit me! #
MY_USER=lamb3; # Edit me! #
MY_PASS=lamb3; # Edit me! #
MY_SALT=_CHANGE_ME_; # Edit me! # We don't rely on the salt, but it might be a hurdle for an attacker.

#################
### More vars ###
#################
MY_DAY=`date +%d`
MY_DATE=`date +%y%m%d`
MY_FILENAME="./""$MY_DATE""_db_backup""$MY_SALT"".sql.gz";

##################
### DB backups ###
##################
echo "Doing the daily database backup.";
echo "Deleting all backups older than 7 days.";
find ./db_backups -name "*.sql.gz" -mtime +7 -exec rm {} \;

# Back it up
echo "Creating a new backup.";
mysqldump --user=$MY_USER --password=$MY_PASS $MY_DB | gzip -9 > "db_backups/$MY_FILENAME"

# Move the file if its a permanent backup 
if [ "$MY_DAY" == 01 ] || [ "$MY_DAY" == 15 ]
then
	echo "Moving the backup to permanent backups.";
	mv "db_backups/$MY_FILENAME" "db_backups_old/$MY_FILENAME"
fi

################
### Logfiles ###
################
MY_DATE=`date +%y%m%d%H%M%S`
MY_FILENAME="./zipped/""$MY_DATE""$MY_SALT""_logfiles.tar.gz";

echo "Compressing old logfiles.";
find ./logs/ -name "*.txt" -mmin +86401 | xargs tar --gzip -cf "$MY_FILENAME"

echo "Removing old logfiles.";
find ./logs -name "*.txt" -mmin +86401 -exec rm {} \;

echo "Removing empty dirs.";
find ./logs -depth -type d -empty -exec rmdir {} \;
