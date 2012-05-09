<?php
GWF_File::filewalker('/home/user', true, 'cron_level_6', false);
function cron_level_6($entry, $fullpath, $args=NULL)
{
	$home = $fullpath;
	$username = $entry;
	
	$filename = $home.'/level/6/solution.txt';
	if (Common::isFile($filename))
	{
		$solution = $home.'/level/6/real_solution.txt';
		if (!Common::isFile($solution))
		{
			// Create solution file
			$tmp = '/root/_tmp_6';
			file_put_contents($tmp, 'The solution to level 6 is "SymbolicFlag".');
			chmod($tmp, '0700');
			chown($tmp, $username);
			chgrp($tmp, $username);
			
			// Copy it to user home
			rename($tmp, $solution);
		}
	}
}
?>
