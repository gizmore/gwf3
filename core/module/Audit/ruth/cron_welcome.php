<?php
GWF_File::filewalker('/home/user', true, 'cron_welcome', false);
function cron_welcome($entry, $fullpath, $args=NULL)
{
	$source = '/etc/skel/WELCOME.txt';
	$destin = $fullpath.'/WELCOME.txt';
	copy($source, $destin);
	chown($destin, 'root');
	chgrp($destin, 'root');
	chmod($destin, 0444);
}
?>