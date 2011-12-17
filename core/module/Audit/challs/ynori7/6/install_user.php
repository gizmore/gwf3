<?php
$dirname = $home.'/level/6';
if (!Common::isDir($dirname))
{
	if (!@mkdir($dirname, 0705, true))
	{
		echo GWF_HTML::err('ERR_WRITE_FILE', array($dirname));
		return;
	}
}

$filename = $dirname.'/solution.php';
if (!Common::isFile($filename))
{
	@unlink($filename);
	system("ln -s /home/levels/ynori7/6/solution.php $filename");
// 	chmod($filename, 0700);
// 	chown($filename, $username);
// 	chgrp($filename, $username);
}
?>