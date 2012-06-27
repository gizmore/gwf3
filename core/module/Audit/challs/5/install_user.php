<?php
$dirname = $home.'/level/5';
if (!Common::isDir($dirname))
{
	@unlink($dirname);
	$dirname2 = "/root/L5D";
	if (!@mkdir($dirname2, 0700, true))
	{
		echo GWF_HTML::err('ERR_WRITE_FILE', array($dirname2));
		return;
	}
	@chmod($dirname2, 0700);
	@chown($dirname2, $username);
	@chgrp($dirname2, $username);
	@rename($dirname2, $dirname);
}

$filename = $home.'/level/5/README.txt';
if (!Common::isFile($filename))
{
	$filename2 = tempnam("/tmp", "L5F");
	file_put_contents($filename2, "Protect your /home/user/{$username}/level directory from other users. Then wait 5 minutes.\n");
	chmod($filename2, 0004);
	chown($filename2, 'root');
	chgrp($filename2, 'root');
	@rename($filename2, $filename);
}
?>
