<?php
GWF_File::filewalker('/home/user', true, 'cron_level_5', false);
function cron_level_5($entry, $fullpath, $args=NULL)
{
	$home = $fullpath;
	$username = $entry;
	
	$dir = $fullpath.'/level';
	if (false === ($stat = @stat($dir)))
	{
		return;
	}
	$chmod = $stat['mode'];
	if ($chmod & 04)
	{
		return;
	}
	
	$filename = $home.'/level/5/solution.txt';
	if (!Common::isFile($filename))
	{
		file_put_contents($filename, "The solution to level 5 is 'OhRightThePerms', without the quotes.\n");
		chmod($filename, '0700');
		chown($filename, $username);
		chgrp($filename, $username);
	}
}
?>
