<?php
$dirname = $home.'/level/6';
if (!Common::isDir($dirname))
{
	@unlink($dirname);
	$dirname2 = tempnam("/root", "L6D");
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