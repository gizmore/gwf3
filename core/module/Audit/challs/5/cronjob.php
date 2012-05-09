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
		// Create solution file
		$tmp = '/root/_tmp_5';
		file_put_contents($tmp, "The solution to level 5 is 'OhRightThePerms', without the quotes.\n");
		chmod($tmp, '0700');
		chown($tmp, $username);
		chgrp($tmp, $username);
		
		// Copy it to user home
		rename($tmp, $filename);
	}
}
?>
