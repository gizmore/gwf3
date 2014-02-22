<?php
$dirname = $home.'/level/4';
if (!Common::isDir($dirname))
{
	GWF_File::removeDir($dirname);
	
	$dirname2 = "/root/kwd";
	@mkdir($dirname2, 0700, true);
	@chmod($dirname2, 0700);
	@chown($dirname2, $username);
	@chgrp($dirname2, $username);
	@rename($dirname2, $dirname);
}

$filename = $home.'/level/4/README.txt';
if (!Common::isFile($filename))
{
	$filename2 = tempnam("/tmp", "kwf");
	@file_put_contents($filename2, "The solution to level 4 is 'AndIknowchown' without the quotes.\n");
	@chmod($filename2, 0000);
	@chown($filename2, $username);
	@chgrp($filename2, $username);
	@rename($filename2, $filename);
}
