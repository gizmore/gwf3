<?php
require_once '../../bootstrap.php';
GWF_File::filewalker('/home/user', true, 'install_level_5', false);
function install_level_5($entry, $fullpath, $args=NULL)
{
	$home = $fullpath;
	$username = $entry;
	include 'install_user.php';
}
?>
