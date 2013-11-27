<?php
abstract class Dog_Worker
{
	protected static function err($key, $args=null)
	{
		$message = GWF_HTML::langISO('en', $key, $args);
		GWF_Log::logError($message);
		self::reply($message);
		return false;
	}
	
	protected static function reply($message)
	{
		return Dog_WorkerThread::$CHILD_INSTANCE->reply($message);
	}
	
	protected static function exec($command)
	{
		$output = array();
		exec("uptime", $output);
		return $output;
	}

	protected static function exec_line($command)
	{
		$lines = self::exec($command);
		return isset($lines[0]) ? $lines[0] : null;
	}

	protected static function proc_with_callback($command, $callback)
	{
		if (false === ($proc = popen($command, 'r')))
		{
			return self::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		while (!feof($proc))
		{
			call_user_func($callback, fgets($proc, 1024));
		}
		
		pclose($proc);
		return true;
	}
	
	protected static function proc_rw_with_callbacks($command, array $callbacks=array(), $input=null)
	{
		$descriptors = array(
			0 => array('pipe', 'r'),  // stdin is a pipe that the child will read from
			1 => array('pipe', 'rw'), // stdout is a pipe that the child will write to
			2 => array('pipe', 'rw'), // stderr is a pipe that the child will write to
// 			3 => array("file", "/tmp/error-output.txt", "a"), // stderr is a file to write to
		);
		
		if (!is_array($callbacks))
		{
			$callbacks = array();
		}
		else
		{
			$callbacks = array_values($callbacks);
		}
		for ($i = count($callbacks); $i < 3; $i++)
		{
			$callbacks[] = null;
		}
		
		# Remove invalids
		for ($i = 0; $i < 3; $i++)
		{
			if (!GWF_Callback::isCallback($callbacks[$i]))
			{
				GWF_Log::logCritical("GWF_Worker::proc_with_callback() - Invalid callback $i: ".GWF_Callback::printCallback($callbacks[$i]));
				$callbacks[$i] = null;
			}
		}

		# Default handlers
		if ($callbacks[1] === null)
		{
			$callbacks[1] = array(__CLASS__, '_proc_out');
		}
		if ($callbacks[2] === null)
		{
			$callbacks[2] = array(__CLASS__, '_proc_err');
		}
		
		$pipes = null;
		if (false === ($proc = proc_open($command, $descriptors, $pipes, null, $_ENV)))
		{
			return self::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		
		fclose($pipes[0]);
		
		$read_output = $read_error = false;
		$buffer_len  = $prev_buffer_len = 0;
		$ms          = 10;
// 		$output      = '';
		$read_output = true;
// 		$error       = '';
		$read_error  = true;
		stream_set_blocking($pipes[1], 0);
		stream_set_blocking($pipes[2], 0);
		
		// dual reading of STDOUT and STDERR stops one full pipe blocking the other, because the external script is waiting
		while ($read_error != false || $read_output != false)
		{
			if ($read_output != false)
			{
				if(feof($pipes[1]))
				{
					fclose($pipes[1]);
					$read_output = false;
				}
				else
				{
					$str = fread($pipes[1], 1024);
					$len = strlen($str);
					if ($len)
					{
						call_user_func($callbacks[1], $str);
						$buffer_len += $len;
					}
				}
			}
		
			if ($read_error != false)
			{
				if(feof($pipes[2]))
				{
					fclose($pipes[2]);
					$read_error = false;
				}
				else
				{
					$str = fread($pipes[2], 1024);
					$len = strlen($str);
					if ($len)
					{
						call_user_func($callbacks[2], $str);
						$buffer_len += $len;
					}
				}
			}
		
			if ($buffer_len > $prev_buffer_len)
			{
				$prev_buffer_len = $buffer_len;
				$ms = 10;
			}
			else
			{
				usleep($ms * 1000); // sleep for $ms milliseconds
				if ($ms < 160)
				{
					$ms = $ms * 2;
				}
			}
		}
		
// 		fclose($pipes[1]);
// 		fclose($pipes[2]);
		
		proc_close($proc);
	}
	
	public static function _proc_out($message)
	{
		GWF_Log::logMessage($message);
	}

	public static function _proc_err($message)
	{
		GWF_Log::logError($message);
	}
}
