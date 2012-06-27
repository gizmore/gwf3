<?php
$dirname = $home.'/level/4';
if (!Common::isDir($dirname))
{
	@unlink($dirname);
	$dirname2 = "/root/kwd";
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

$filename = $home.'/level/4/README.txt';
if (!Common::isFile($filename))
{
	$filename2 = tempnam("/tmp", "kwf");
	file_put_contents($filename2, "The solution to level 4 is 'AndIknowchown' without the quotes.\n");
	chmod($filename2, 0000);
	chown($filename2, $username);
	chgrp($filename2, $username);
	@rename($filename2, $filename);
}
?>
