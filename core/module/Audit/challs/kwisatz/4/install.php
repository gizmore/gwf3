<?php
require_once 'gwf3.class.php';
GWF_File::filewalker('/home/user', true, 'install_level_4', false);

function install_level_4($entry, $fullpath, $args=NULL)
{
	$filename = $fullpath.'/LEVEL4.txt';
	if (!Common::isFile($filename))
	{
		file_put_contents($filename, 'The solution to level 4 is "ANDIKNOWCHOWNYA" without the quotes.');
		chmod($filename, 0000);
		chown($filename, $entry);
	}
}
?>
