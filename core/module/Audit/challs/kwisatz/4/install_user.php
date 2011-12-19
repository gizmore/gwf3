<?php
$dirname = $home.'/level/4';
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

$filename = $home.'/level/4/README.txt';
if (!Common::isFile($filename))
{
	file_put_contents($filename, "The solution to level 4 is 'AndIknowchown' without the quotes.\n");
	chmod($filename, 0000);
	chown($filename, $username);
	chgrp($filename, $username);
}
?>