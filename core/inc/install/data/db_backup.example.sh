#!/bin/bash
#
# Daily database backup and log zipping.
# Call this script once a day.
# Example crontab for 3 o'clock: 0 3 * * * cd /path/to/protected && ./db_backup.sh
#
# @author: gizmore
#
cd "$(dirname "$0")"

###################
### DB settings ###
###################
MY_DB=%%DB%%;
MY_USER=%%USER%%;
MY_PASS=%%PASS%%;
MY_SALT=%%SALT%%;

#################
### More vars ###
#################
MY_DAY=`date +%d`
MY_DATE=`date +%y%m%d`
MY_FILENAME="./""$MY_DATE""_db_backup_""$MY_SALT"".sql.gz";
MY_DBIMGFILE="./""$MY_DATE""_dbimg_""$MY_SALT"".tar.bz2"

##################
### DB backups ###
##################
echo "Doing the daily database backup.";
echo "Deleting all backups older than 7 days.";
find ./db_backups -name "*.sql.gz" -mtime +7 -exec rm {} \;

echo "Creating a new database backup.";
rm -f "db_backups/$MY_FILENAME"
mysqldump --user=$MY_USER --password=$MY_PASS $MY_DB | gzip -9 > "db_backups/$MY_FILENAME"

# Move the file if its a permanent backup 
if [ "$MY_DAY" == 01 ] || [ "$MY_DAY" == 15 ]
then
	echo "Moving the backup to permanent backups.";
	mv "db_backups/$MY_FILENAME" "db_backups_old/$MY_FILENAME"
	echo "Creating a dbimg/ backup.";
	tar -cjf "db_backups_old/$MY_DBIMGFILE" ../dbimg
fi


################
### Logfiles ###
################
MY_DATE=`date +%y%m%d%H%M%S`
MY_FILENAME="./zipped/""$MY_DATE""$MY_SALT""_logfiles.tar.gz";

echo "Compressing logfiles older than one day.";
find ./logs/ -name "*.txt" -mmin +1441 | xargs tar --gzip -cf "$MY_FILENAME"

echo "Removing these old logfiles.";
find ./logs -name "*.txt" -mmin +1441 -exec rm {} \;

echo "Removing the dirs that are empty now.";
find ./logs -depth -type d -empty -exec rmdir {} \;
