<?php
$dirname = $home.'/level/5';
if (!Common::isDir($dirname))
{
	if (@mkdir($dirname, 00705))
	{
		echo GWF_HTML::err('ERR_WRITE_FILE', array($dirname));
		return;
	}
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