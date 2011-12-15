<?php
$dirname = $home.'/level/6';
if (!GWF_File::createDir($dirname))
{
	echo GWF_HTML::err('ERR_WRITE_FILE', array($dirname));
	return;
}

$filename = $dirname.'/solution.php';
if (!Common::isFile($filename))
{
	unlink($filename);
	system("ln -s /home/levels/ynori7/6/solution.php $filename");
// 	chmod($filename, 0705);
// 	chown($filename, 'ynori7');
// 	chgrp($filename, 'ynori7');
}
?>