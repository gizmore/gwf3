<?php
/**
 * Debug backtrace and error handler.
 * Can send email on PHP errors.
 * Also has a method to get debug timings.
 * @example GWF_Debug::enableErrorHandler(); fatal_ooops();
 * @see GWF_DEBUG_EMAIL in protected/config.php
 * @author gizmore
 * @version 3.0
 */
final class GWF_Debug
{
	private static $die = true;
	private static $enabled = false;
	################
	### Settings ###
	################
	
	public static function setDieOnError($bool)
	{
		if (is_bool($bool))
		{
			self::$die = $bool;
		}
	}
	
	public static function disableErrorHandler()
	{
		if (self::$enabled === true)
		{
			restore_error_handler();
			self::$enabled = false;
		}
	}
	
	public static function enableErrorHandler()
	{
		if (self::$enabled === false)
		{
			set_error_handler(array('GWF_Debug', 'error_handler'));
			register_shutdown_function(array('GWF_DEBUG', 'shutdown_function'));
//			ini_set('display_errors', 0);
			self::$enabled = true;
		}
	}
	
	public static function enableStubErrorHandler()
	{
		self::disableErrorHandler();
		set_error_handler(array('GWF_Debug', 'error_handler_stub'));
		self::$enabled = true;
	}

	##########
	### GC ###
	##########
	public static function collectGarbage()
	{
		if (function_exists('gc_collect_cycles'))
		{
			gc_collect_cycles();
		}
	}

	######################
	### Error Handlers ###
	######################
	public static function error_handler_stub($errno, $errstr, $errfile, $errline, $errcontext)
	{
		return false;
	}
	
	public static function shutdown_function()
	{
		if (self::$enabled)
		{
			$error = error_get_last();

			if ($error['type'] != 0)
			{
				require_once dirname(__FILE__).'/GWF_Log.php';
				require_once dirname(__FILE__).'/GWF_IP6.php';
				require_once dirname(__FILE__).'/GWF_Mail.php';
				self::error_handler(1, $error['message'], self::shortpath($error['file']), $error['line'], NULL);
			}
		}
	}
	
	/**
	 * Error handler creates some html backtrace and dies on _every_ warning etc.
	 * @param int $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param int $errline
	 * @param $errcontext
	 * @return unknown_type
	 */
	public static function error_handler($errno, $errstr, $errfile, $errline, $errcontext)
	{
		# Log as critical!
		if (class_exists('GWF_Log'))
		{
			GWF_Log::logCritical(sprintf('%s in %s line %s', $errstr, $errfile, $errline), false);
		}
		
		switch($errno)
		{
			case 1: $errnostring = 'PHP Fatal Error'; break;
			case 2:
			case 8:
			case E_USER_WARNING: $errnostring = 'PHP Warning'; break;
			case E_USER_ERROR: $errnostring = 'PHP Error'; break;
			case E_USER_NOTICE: $errnostring = 'PHP Notice'; break;
			case 2048: $errnostring = 'PHP No Timezone'; break;
			default: $errnostring = 'PHP Unknown Error'; break;
		}

		$is_html = isset($_SERVER['REMOTE_ADDR']);

		if ($is_html)
		{
			$message = sprintf('<p>%s(%s):&nbsp;%s&nbsp;in&nbsp;<b style=\"font-size:16px;\">%s</b>&nbsp;line&nbsp;<b style=\"font-size:16px;\">%s</b></p>', $errnostring, $errno, $errstr, $errfile, $errline).PHP_EOL;
		}
		else
		{
			$message = sprintf('%s(%s) %s in %s line %s.', $errnostring, $errno, $errstr, $errfile, $errline).PHP_EOL;
		}
		
		# Show error to user
		if (GWF_USER_STACKTRACE)
		{
			echo self::backtrace($message, $is_html).PHP_EOL;
		}
		else
		{
			echo $message;
		}
		
		# Send error to admin
		if (GWF_DEBUG_EMAIL & 2)
		{
			self::sendDebugMail(self::backtrace($message, false));
		}
		
		return self::$die ? die(1) : false;
	}

	/**
	 * Send a debug mail lvl 2
	 * @param string $message
	 */
	public static function sendDebugMail($message)
	{
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver(GWF_BOT_EMAIL);
		$mail->setSubject(GWF_SITENAME.': PHP Error');
		$mail->setBody($message);
		$mail->sendAsText();
	}
	
	############################
	### Own Backtrace Output ###
	############################
	/**
	 * Return a backtrace in either HTML or plaintext. You should use monospace font for html.
	 * HTML means (x)html(5) and <pre> stlye.
	 * Plaintext means nice for logfiles.
	 * @param string $message
	 * @param boolean $html
	 * @return string
	 */
	public static function backtrace($message='', $html=true)
	{
		$back = '';
		
		# Fix full path disclosure
		$message = self::shortpath($message);
		
		# Append PRE header.
		$back .= $html ? ('<pre class="gwf_backtrace">'.PHP_EOL) : '';
		
		# Append general title message.
		if ($message !== '')
		{
			$back .= $html ? '<em>'.$message.'</em>' : $message;
		}
		
		$implode = array();
		$preline = 'Unknown';
		$prefile = 'Unknown';
		$longest = 0;
		$i = 0;
		foreach (debug_backtrace() as $row)
		{
			if ($i++ > 0)
			{
				$function = sprintf('%s%s()', isset($row['class']) ? $row['class'].'::' : '', $row['function']);
				$implode[] = array(
					$function,
					$prefile,
					$preline,
				);
				$len = strlen($function);
				$longest = max(array($len, $longest));
			}
			$preline = isset($row['line']) ? $row['line'] : '?';
			$prefile = isset($row['file']) ? $row['file'] : '[unknown file]';
		}
		
		$copy = array();
		foreach ($implode as $imp)
		{
			list($func, $file, $line) = $imp;
			$len = strlen($func);
			$func .= str_repeat('.', $longest-$len);
			$copy[] = sprintf('%s %s line %s.', $func, self::shortpath($file), $line);
		}
		
		$back .= $html === true ? '<hr/>' : PHP_EOL;
		$back .= sprintf('Backtrace starts in %s line %s.', self::shortpath($prefile), $preline).PHP_EOL;
		$back .= implode(PHP_EOL, array_reverse($copy));
		$back .= $html ? "\n</pre>\n" : "\n";
		return $back;
	}
	
	public static function shortpath($path)
	{
		$path = str_replace(GWF_PATH, '', $path);
		$path = str_replace(GWF_WWW_PATH, '', $path); // if isn't a GWF3 instance, it could not be defined!
		return trim($path, ' /');
	}
}
?>