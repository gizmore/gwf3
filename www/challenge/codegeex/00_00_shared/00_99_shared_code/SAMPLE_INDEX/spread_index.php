<?php
/**
 * Copy the default index.php to all codinggeex challenges.
 */
chdir(__DIR__);
chdir('../../../../../');
require_once getcwd().'/protected/config.php'; # <-- You might need to adjust this path.
require_once '../gwf3.class.php';
$gwf = new GWF3(getcwd(), array());

echo "Spreading the word!\n..........\n";

define('CGX_SAMPLE', __DIR__ . DIRECTORY_SEPARATOR);

/**
 * Loop all codegeex files... slow?
 */
GWF_File::filewalker('challenge/codegeex', function($entry, $fullpath, $args=NULL){

	if (strpos($fullpath, '00_00') !== false)
	{
		return; # ignore the /shared/ folder
	}
	if ($entry === 'index.php' ||
		$entry === 'install.php')
	{
		echo "Replacing {$fullpath}\n";
		copy(CGX_SAMPLE . $entry, $fullpath);
	}
});
