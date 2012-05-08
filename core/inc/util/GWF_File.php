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
	 * Wrapper for file_get_contents.
	 * @param string $path
	 */
	public static function getContents($filename)
	{
		return file_get_contents($filename);
	}

	/**
	 * Check if a file is writeable or could be created. Returns true or false.
	 * @param string $filename
	 * @return boolean
	 */
	public static function isWriteable($filename)
	{
		if (file_exists($filename))
		{
			return is_writable($filename);
		}
		$dir = dirname($filename);
		return is_dir($dir) && is_writable($dir);
	}

	public static function createDir($path)
	{
		if (true === Common::isDir($path))
		{
			return true;
		}
		return @mkdir($path, GWF_CHMOD, true);
	}

	/**
	 * Write file contents to a file.
	 * @param string $path path with a filename
	 * @param string $content
	 * @return boolean
	 */
	public static function writeFile($path, $content)
	{
		if (false === @file_put_contents($path, $content))
		{
			return false;
		}
		if (false === @chmod($path, GWF_CHMOD))
		{
			return false;
		}
		return true;
	}

	public static function touch($filename)
	{
		if (false === ($fh = @fopen($filename, 'w')))
		{
			return false;
		}
		if (false === @fclose($fh))
		{
			return false;
		}
		if (false === @chmod($filename, GWF_CHMOD&0666))
		{
			return false;
		}
		return true;
	}


	/**
	 * Remove a dir recursively. Returns boolean, true on success. Prints error messages when verbose. Can keep the affected dir if desired.
	 * @param string $path
	 * @param boolean $verbose
	 * @param boolean $keep_dir
	 * @return true|false
	 */
	public static function removeDir($path, $verbose=true, $keep_dir=false, $remove_dotfiles=true)
	{
		$success = true;

		# Does not work on basedir or even one up.
		$failsafe = array('','/','.','./','..','../');
		if (in_array($path, $failsafe, true)) { return false; }

		if (false === ($dir = @dir($path)))
		{
			if ($verbose)
			{ 
				echo GWF_HTML::err('ERR_FILE_NOT_FOUND', htmlspecialchars($path));
			}
			return false;
		}

		while (false !== ($entry = $dir->read()))
		{
			if ($entry === '.' || $entry === '..')
			{
				continue;
			}

			if ( (!$remove_dotfiles)  && ($entry[0] === '.') )
			{
				continue;
			}

			$fullpath = $path.'/'.$entry;
			if (is_dir($fullpath))
			{ // dir
				if (!self::removeDir($fullpath, $verbose, false))
				{
					$success = false;
				}
			}
			else // file
			{
				if (!@unlink($fullpath))
				{
					if($verbose)
					{
						echo GWF_HTML::err('ERR_WRITE_FILE', htmlspecialchars($fullpath));
					}
					$success = false;
				}
			}
		}

		// current dir
		if (!$keep_dir)
		{
			if (!@rmdir($path))
			{
				if ($verbose)
				{
					echo GWF_HTML::err('ERR_WRITE_FILE', htmlspecialchars($path));
				}
				$success = false;
			}
		}

		return $success;
	}

	/**
	 * Template for a filewalker callback.
	 * @param string $entry dir/filename.
	 * @param string $fullpath fullpath of this dir/file.
	 * @param mixed $args Custom args.
	 */
	public static function filewalker_stub($entry, $fullpath, $args=NULL) {}

	/**
	 * Walk a dir and trigger callbacks on files and dirs
	 * @param string $path
	 * @param mixed $callback_file
	 * @param mixed $callback_dir
	 * @return void
	 */
	public static function filewalker($path, $callback_file=false, $callback_dir=false, $recursive=true, $args=NULL)
	{
		# Readable?
		if (false === ($dir = @dir($path)))
		{
			return false;
		}

		if (is_bool($callback_file))
		{
			$callback_file = array(__CLASS__, 'filewalker_stub');
		}

		if (is_bool($callback_dir))
		{
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
				call_user_func($callback_file, $entry, $fullpath, $args);
			}
		}

		$dir->close();

		foreach ($dirstack as $d)
		{
			call_user_func($callback_dir, $d[0], $d[1], $args);

			if ($recursive === true)
			{
				self::filewalker($d[1], $callback_file, $callback_dir, $recursive, $args);
			}
		}
	}
}

