<?php
/**
 * Helper file to remove the utf8 byte order mark from all files.
 * @author gizmore
 */

chdir('../'); # To gwf path.

bom_rec('.'); # Do it!

/**
 * Recursively check dir(s) 
 * @param string $path
 * @return void
 */
function bom_rec($path)
{
	if (false === ($dir = dir($path)))
	{
		return false;
	}
	
	while (false !== ($entry = $dir->read()))
	{
		if ($entry[0] === '.')
		{
			continue;
		}
		
		$fullpath = $path.'/'.$entry;
		
		if (is_dir($fullpath))
		{
			bom_rec($fullpath);
		}
		else
		{
			bom_fix($fullpath);	
		}
	}
	
	$dir->close();
}


/**
 * Check for magic bytes. Return true if BOM is found.
 * @param $filename
 * @return boolean
 */
function bom_need_fix($filename)
{
	if (false === ($fh = fopen($filename, 'rb')))
	{
		return false;
	}

	$fix_me = false;
	
	$one = ord(fgetc($fh));
	$two = ord(fgetc($fh));
	$three = ord(fgetc($fh));
	
	if ($one === 239 && $two === 187 && $three == 191)
	{
		$fix_me = true;
	}
	
	fclose($fh);
	
	return $fix_me;
}

/**
 * Remove magic bytes from a file, given the full path filename.
 * @param $filename
 * @return void
 */
function bom_fix($filename)
{
	if (bom_need_fix($filename))
	{
		var_dump('FIXING '.$filename);
		file_put_contents($filename, substr(file_get_contents($filename), 3));
	}
}
?>