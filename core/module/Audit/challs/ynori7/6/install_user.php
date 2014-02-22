<?php
$dirname = $home.'/level/6';
if (!Common::isDir($dirname))
{
	GWF_File::removeDir($dirname);
	$dirname2 = "/root/L6D";
	@mkdir($dirname2, 0700, true);
	@chmod($dirname2, 0700);
	@chown($dirname2, $username);
	@chgrp($dirname2, $username);
	@rename($dirname2, $dirname);
}

$filename = $dirname.'/solution.php';
if (!Common::isFile($filename))
{
	@unlink($filename);
	system("ln -s /home/levels/ynori7/6/solution.txt $filename");
// 	chmod($filename, 0700);
// 	chown($filename, $username);
// 	chgrp($filename, $username);
}
?>