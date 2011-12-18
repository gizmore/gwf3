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
			file_put_contents($solution, 'The solution to level 6 is "SymbolicFlag".');
			chmod($solution, '0700');
			chown($solution, $username);
			chgrp($solution, $username);
		}
	}
}
?>
