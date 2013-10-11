<?php
Common::defineConst('GWF_CHMOD', '0777'); # Fallback

/**
 * The GWF Logger
 * @author gizmore
 * @author spaceone
 * @version 4.0
 * @since 1.0
 * @todo use only one logfile?!
 * @todo error_log() if GWF3-config
 */
final class GWF_Log
{
	const GWF_WARNING = 0x01;
	const GWF_MESSAGE = 0x02;
	const GWF_ERROR = 0x04;
	const GWF_CRITICAL = 0x08;
	const PHP_ERROR = 0x10;
	const DB_ERROR = 0x20;
	const SMARTY = 0x40;
	const HTTP_ERROR = 0x80;
	const HTTP_GET = 0x100;
	const HTTP_POST = 0x200;
	const IP = 0x400;
	const BUFFERED = 0x1000;
	
	const _NONE = 0x00;
	const _ALL = 0x17ff;
	const _DEFAULT = self::_ALL;

	private static $POST_DELIMITER = '.::.';

	private static $username = false;
	private static $basedir = 'protected/logs';
	private static $logbits = self::_DEFAULT;
	private static $logformat = "%s [%s%s] - %s\n";
	private static $cache = 0;
	private static $logs = array();

	/**
	 * Init the logger. If a username is given, the logger will log _additionally_ into a logs/username dir.
	 * @param string $username The username for memberlogs
	 * @param int $logbits bitmask for logging-modes
	 * @param string $basedir The path to the logfiles. Should be relative.
	 */
	public static function init($username=false, $logbits=self::_DEFAULT, $basedir='protected/logs')
	{
		self::$username = $username;
		self::$logbits = $logbits;
		self::$basedir = $basedir;
	}

	public static function isEnabled($bits) { return ($bits === (self::$logbits & $bits)); }
	public static function isDisabled($bits) { return ($bits !== (self::$logbits & $bits)); }

	public static function cache($new) { self::$cache = self::$logbits; self::$logbits = $new; }
	public static function restore() { self::$logbits = self::$cache; }

	public static function enable($bits) { self::$logbits |= $bits; }
	public static function disable($bits) { self::$logbits &= (~$bits); }

	public static function setLogFormat($format) { self::$logformat = $format; }
	
	public static function enableBuffer() { self::enable(self::BUFFERED); }
	public static function disableBuffer() { self::flush();	self::disable(self::BUFFERED); }
	public static function isBuffered() { return self::isEnabled(self::BUFFERED); }

	/**
	 * Get the whole request to log it. Censor passwords.
	 * @return string
	 */
	private static function getRequest()
	{
		$post = self::isDisabled(self::HTTP_POST);
		if (true === self::isDisabled(self::HTTP_GET) && true === $post)
		{
			return '';
		}

		$back = Common::getServer('REQUEST_METHOD', '').' ';
		$back .= Common::getServer('REQUEST_URI', '');

		if (false === $post && count($_POST) > 0)
		{
			$back .= self::$POST_DELIMITER .'POSTDATA'.self::stripPassword($_POST);
		}
		return $back;
	}

	/**
	 * shorten a string and remove dangerous pattern
	 *
	 */
	public static function &shortString(&$str, $length=256)
	{
		$str = substr($str, 0, $length);
		while (false !== strpos($str, '<?'))
		{
			$str = str_replace('<?', '##', $str);
		}
		return $str;
	}

	/**
	 * strip values from arraykeys which begin with 'pass'
	 * @todo faster way without foreach...
	 * print_r and preg_match ?
	 * array_map stripos('pass') return '';
	 */
	private static function stripPassword(array $a)
	{
		$back = '';
		foreach ($a as $k => $v)
		{
			if ( (stripos($k, 'pass') !== false) || ($k === 'answer') )
			{
				$v = 'xxxxx';
			}
			elseif (is_array($v) === true)
			{
				$v = GWF_Array::implode(',', $v);
			}
			$back .= self::$POST_DELIMITER.$k.'=>'.$v;
		}
		return self::shortString($back);
	}

	/**
	 * Log the request.
	 */
	public static function logRequest() { self::log('request', self::getRequest()); }

	########################
	### Default logfiles ###
	########################
	public static function logCron($message) { self::rawLog('cron', $message, 0); echo $message.PHP_EOL; } # TODO: remove echo
	public static function logError($message) { self::log('error', $message, self::GWF_ERROR); }
	public static function logMessage($message) { self::log('message', $message, self::GWF_MESSAGE); }
	public static function logWarning($message) { self::log('warning', $message, self::GWF_WARNING); }
	public static function logCritical($message)
	{
		self::log('critical', $message, self::GWF_CRITICAL);
		self::log('critical_details', GWF_Debug::backtrace(print_r($_GET, true).PHP_EOL.self::stripPassword($_POST).PHP_EOL.$message, false), self::GWF_CRITICAL); // TODO: formating
	}
	public static function logInstall($message) { self::log('install', $message, self::_NONE); }
	public static function logHTTP($message) { self::rawLog('http', $message, self::HTTP_ERROR); }

	/**
	 * Get the full log path, either for username log or site log.
	 * @param string $filename
	 * @param string|false $username
	 */
	private static function getFullPath($filename, $username=false)
	{
		$date = date('Ymd');
		return is_string($username)
			? sprintf('%s/memberlog/%s/%s_%s.txt', self::$basedir, $username, $date, $filename)
			: sprintf('%s/%s_%s.txt', self::$basedir, $date, $filename);
	}

	/**
	 * Recursively create logdir with GWF_CHMOD permissions.
	 * @param string $filename
	 * @return boolean
	 */
	private static function createLogDir($filename)
	{
		$dir = dirname($filename);
		return is_dir($dir) ? true : (false !== @mkdir($dir, GWF_CHMOD, true));
	}

	/**
	 * Flush all logfiles
	 * throws an GWF_Exception within logfile content when fails
	 */
	public static function flush()
	{
		foreach (self::$logs as $file => $msg)
		{
			if (true === ($e = self::writeLog($file, $msg)))
			{
				unset(self::$logs[$file]);
			}
			else
			{
				throw $e;
				# TODO: the logfile content could be important, it could be send by email
				# The TODO thing: optimize GWF_Exception
//				$e->_throw( 'flushing logfile failed: content:' . $msg );
			}
		}
	}

	/**
	 * Log a message.
	 * The core logging function.
	 * Raw mode will not write any datestamps or IP/username.
	 * @param string $filename short logname
	 * @param string $message the message
	 * format: $time, $ip, $username, $message
	 */
	public static function log($filename, $message, $logmode=0)
	{
		# log it?
		if (true === self::isEnabled($logmode))
		{
			$time = date('H:i');
			$ip = (false === isset($_SERVER['REMOTE_ADDR']) || self::isDisabled(self::IP))
				? '' : $_SERVER['REMOTE_ADDR'];
			$username = self::$username === false ? '' : ':'.self::$username;

			self::logB($filename, sprintf(self::$logformat, $time, $ip, $username, $message));
		}
	}

	public static function rawLog($filename, $message, $logmode=0)
	{
		# log it?
		if (self::isEnabled($logmode))
		{
			self::logB($filename, $message.PHP_EOL);
		}
	}


	private static function logB($filename, $message)
	{
		if (!self::isBuffered())
		{
			self::writeLog($filename, $message);
		}
		elseif (true === isset(self::$logs[$filename]))
		{
			self::$logs[$filename] .= $message;
		}
		else
		{
			self::$logs[$filename] = $message;
		}
	}

	private static function writeLog($filename, $message)
	{
		# Create logdir if not exists
		$filename = self::getFullPath($filename, self::$username);
		if (false === self::createLogDir($filename))
		{
			return new GWF_Exception(sprintf('Cannot create logdir "%s" in %s line %s.', dirname($filename), __METHOD__, __LINE__), GWF_Exception::LOG);
		}

		# Default kill banner.
		if (false === is_file($filename))
		{
			$bool = true;
			$bool = $bool && (false !== file_put_contents($filename, '<?php die(2); ?>'.PHP_EOL));
			$bool = $bool && @chmod($filename, GWF_CHMOD&0666);
			if (false === $bool)
			{
				return new GWF_Exception(sprintf('Cannot create logfile "%s" in %s line %s.', $filename, __METHOD__, __LINE__), GWF_Exception::LOG);
			}
		}

		# Write to file
		if (false === file_put_contents($filename, $message, FILE_APPEND))
		{
			return new GWF_Exception(sprintf('Cannot write logs: logfile "%s" in %s line %s.', $filename, __METHOD__, __LINE__), GWF_Exception::LOG);
		}

		return true;
	}
}
