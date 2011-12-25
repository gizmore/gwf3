<?php
/**
 * Helper file to remove all .svn files.
 * @author spaceone
 * @todo svn export is way better
 * @todo analyze return values
 * @todo do with PHP?
 */

chdir('../');

//$cmd = 'svn export --force . .';
$cmd = 'rm -fR .svn; find -name \'*.swp\' -exec rm -f {} \;';

$error = false;
if( !function_exists('system') )
{
	$funcs = array('shell_exec', 'passthru', 'exec', 'popen');
	foreach($funcs as $f)
	{
		if(function_exists($f))
		{
			function system($arg) { return $f($arg); }
			break;
		}
		$error = true;
	}
}
elseif(false === $error)
{
	echo system($cmd);
	echo PHP_EOL.PHP_EOL.'I dunno if errors occured!';
}
else
{
	echo 'no system() function is allowed! Try to manually delete the .svn directory and all .swp files!'.PHP_EOL;
	echo '$ '.$cmd;
}
