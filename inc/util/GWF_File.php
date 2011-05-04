<?php
/**
 * Rarely used File utility.
 * @author gizmore
 * @version 3.0
 * @since 3.0
 */
final class GWF_File
{
	/**
	 * Check if a file is writeable or could be created. Returns true or false.
	 * @param string $filename
	 * @return boolean
	 */
	public static function isWriteable($filename)
	{
		if (file_exists($filename)) {
			return is_writable($filename);
		}
		$dir = dirname($filename);
		return is_dir($dir) && is_writable($dir);
	}
	
	/**
	 * Remove a dir recursively. Returns boolean, true on success. Prints error messages to stdout when verbose.
	 * @param string $path
	 * @param boolean $verbose
	 * @return boolean
	 */
	public static function removeDir($path, $verbose=true)
	{
		$success = true;
		
		# Does not work on basedir or even one up.
		$failsafe = array('','/','.','./','..','../');
		if (in_array($path, $failsafe, true)) { return false; }
		
		if (false === ($dir = @dir($path)))
		{
			if ($verbose) { 
				echo GWF_HTML::err('ERR_FILE_NOT_FOUND', htmlspecialchars($path));
			}
			
			return false;
		}
		
		while (false !== ($entry = $dir->read()))
		{
			if ($entry === '.' || $entry === '..') {
				continue;
			}
			$fullpath = $path.'/'.$entry;
			if (is_dir($fullpath)) { // dir
				if (!self::removeDir($fullpath)) {
					$success = false;
				}
			}
			else { // file
				if (!@unlink($fullpath)) {
					if($verbose) {
						echo GWF_HTML::err('ERR_WRITE_FILE', htmlspecialchars($fullpath));
					}
					$success = false;
				}
			}
		}
		
		// current dir
		if (!@rmdir($path)) {
			if ($verbose) {
				echo GWF_HTML::err('ERR_WRITE_FILE', htmlspecialchars($path));
			}
			$success = false;
		}
		
		return $success;
	}
	
	public static function filewalker_stub($entry, $fullpath) {}
	/**
	 * Walk a dir and trigger callbacks on files and dirs
	 * @param string $path
	 * @param mixed $callback_file
	 * @param mixed $callback_dir
	 * @return void
	 */
	public static function filewalker($path, $callback_file=true, $callback_dir=true, $recursive=true)
	{
		if (false === ($dir = dir($path))) {
			return false;
		}
		
		if (is_bool($callback_file)) {
			$callback_file = array(__CLASS__, 'filewalker_stub');
		}
		if (is_bool($callback_dir)) {
			$callback_dir = array(__CLASS__, 'filewalker_stub');
		}
		
		
		$dirstack = array();
		
		while (false !== ($entry = $dir->read()))
		{
			$fullpath = $path.'/'.$entry;
			if ( (strpos($entry, '.') === 0) || (!is_readable($fullpath)) )
			{
				continue;
			}
			
			if (is_dir($fullpath))
			{
				$dirstack[] = array($entry, $fullpath);
			}
			
			elseif (is_file($fullpath))
			{
				call_user_func($callback_file, $entry, $fullpath);
			}
		}
		
		$dir->close();
		
		foreach ($dirstack as $d)
		{
			call_user_func($callback_dir, $d[0], $d[1]);
			
			if ($recursive === true)
			{
				self::filewalker($d[1], $callback_file, $callback_dir);
			}
		}
	}
}
?>
