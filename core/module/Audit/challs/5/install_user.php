<?php
$dirname = $home.'/level/5';
if (!Common::isDir($dirname))
{
	if (!@mkdir($dirname, 0700, true))
	{
		echo GWF_HTML::err('ERR_WRITE_FILE', array($dirname));
		return;
	}
	chmod($dirname, 0700);
	chown($dirname, $username);
	chgrp($dirname, $username);
}

$filename = $home.'/level/5/README.txt';
if (!Common::isFile($filename))
{
	file_put_contents($filename, "Protect your /home/user/{$username}/level directory from other users. Then wait 5 minutes.\n");
	chmod($filename, 0004);
	chown($filename, 'root');
	chgrp($filename, 'root');
}
?>