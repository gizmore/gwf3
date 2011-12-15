<?php
$dirname = $home.'/level/4';
if (!GWF_File::createDir($dirname))
{
	echo GWF_HTML::err('ERR_WRITE_FILE', array($dirname));
	return;
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