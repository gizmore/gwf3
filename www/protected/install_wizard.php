<?php
//die('Dont use it atm, its also not protected!-.-');
$dir = __DIR__;
$prefix = '../';

require_once $prefix.'core/inc/install/install.php';

if(isset($_GET['selfdelete'])) {
	// after installation: delete this file...
}

/*
if(!file_exists($cpath) || !file_exists($spath))
{
	$error = '<p>The config-file OR the Smarty-class couldn\'t be found! Please give me the needed information!</p>';
	$error .= sprintf('
	<form action="%s" method="GET">
		<label for="config">Example-Config-Path:</label><input size="50" id="config" type="text" name="path" value="%s"><br>
		<label for="smarty">Smarty-Config-Path:</label><input size="50" id="smarty" type="text" name="path" value="%s"><br>
		<label for="logging">Logging-Path: </label><input size="50" id="logging" type="text" name="path" value="%s">
		<input type="submit" value="Install GWF!">
	</form>
	', '/install.php', $cpath, $spath, $lpath);
	die($error);
}
*/