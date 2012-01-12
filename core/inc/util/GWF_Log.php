<?php
Common::defineConst('GWF_CHMOD', '0777'); # Fallback

/**
 * The GWF Logger
 * @author gizmore
 * @version 3.0
 * @since 1.0
 */
final class GWF_Log
{
	const POST_DELIMITER = '.::.';
	
	private static $username = false;
	private static $basedir = 'protected/logs';
	private static $log_requests = true;
	
	############
	### Init ###
	############
	/**
	 * Init the logger. If a username is given, the logger will log _additionally_ into a logs/username dir. 
	 * @param string $username The username for memberlogs
	 * @param boolean $log_requests Log every request?
	 * @param string $basedir The path to the logfiles. Should be relative.
	 */
	public static function init($username=false, $log_requests=true, $basedir='protected/logs')
	{
		self::$username = $username;
		self::$log_requests = $log_requests;
		self::$basedir = $basedir;
// 		if ( ($log_requests) && (isset($_SERVER['REMOTE_ADDR'])) )
// 		{
// 			self::logRequest();
// 		}
	}
	
	###############
	### Request ###
	###############
	/**
	 * Get the whole request to log it. Censor passwords. 
	 * @return string
	 */
	private static function getRequest()
	{
		$back = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
		$back .= isset($_SERVER['REQUEST_URI']) ? ' '.$_SERVER['REQUEST_URI'] : '';
		
		$de = self::POST_DELIMITER;
		
		if (count($_POST) > 0)
		{
			$back .= "{$de}POSTDATA";
			foreach ($_POST as $k => $v)
			{
				if (stripos($k, 'pass') !== false)
				{
					$v = 'xxxxx';
				}
				elseif(is_array($v) === true)
				{
					$v = GWF_Array::implode(',', $v);
				}
				$back .= $de.$k.'=>'.$v;
			}
		}
		return $back;
	}
	
	/**
	 * Log the request.
	 */
	public static function logRequest() { self::log('request', self::getRequest()); }

	########################
	### Default logfiles ###
	########################
	public static function logCron($message) { self::log('cron', $message, true); echo $message.PHP_EOL; }
	public static function logError($message) { self::log('error', $message); }
	public static function logMessage($message) { self::log('message', $message); }
	public static function logWarning($message) { self::log('warning', $message); }
	public static function logCritical($message) { self::log('critical', $message); self::log('critical_details', GWF_Debug::backtrace(self::getRequest().PHP_EOL.$message, false)); }
	public static function logInstall($message) { self::log('install', $message); }
	
	##############
	### Helper ###
	##############
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
	 * If this function fails, it dies!
	 * @param string $filename
	 * @return boolean
	 */
	private static function createLogDir($filename)
	{
		$curr = '';
		foreach (explode('/', dirname($filename)) as $dir)
		{
			$curr .= $dir;
			if ($curr !== '') # root?
			{
				if (!is_dir($curr))
				{
					if (!@mkdir($curr))
					{
						die(sprintf('Cannot create dir \'%s\' in %s line %s.', $curr, __METHOD__, __LINE__));
					}
					if (!@chmod($curr, GWF_CHMOD))
					{
						die(sprintf('Cannot chmod dir \'%s\' in %s line %s.', $curr, __METHOD__, __LINE__));
					}
				}
			}
			$curr .= '/';
		}
		return true;
	}
	
	/**
	 * Open the logfile with GWF_CHMOD permissions.
	 * @param string $filename
	 * @return file_handle
	 */
	private static function createLogFile($filename)
	{
		if (!is_file($filename))
		{
			# Default kill banner.
			if (!file_put_contents($filename, '<?php die(2); ?>'.PHP_EOL))
			{
				return false;
			}
			if (!chmod($filename, GWF_CHMOD))
			{
				return false;
			}
		}
		return fopen($filename, 'a+');
	}

	/**
	 * Log a message.
	 * The core logging function.
	 * Raw mode will not write any datestamps or IP/username.
	 * If this function fails it dies.
	 * @param string $filename short logname
	 * @param string $message the message
	 * @param boolean $raw
	 */
	public static function log($filename, $message, $raw=false)
	{
		# Get the file
		$filename = self::getFullPath($filename, self::$username);
		if (false === self::createLogDir($filename))
		{
			die('Can not create logdir '.$filename);
		}
		if (false === ($fh = self::createLogFile($filename)))
		{
			die('Can not open logfile '.$filename);
		}
		
		# Write to file
		if (!$raw)
		{		
			$time = date('H:i');
			$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'localhost';
			$username = self::$username === false ? '' : ':'.self::$username;
			fprintf($fh, '%s [%s%s] - %s'.PHP_EOL, $time, $ip, $username, $message);
		}
		else
		{
			fprintf($fh, "%s\n", $message);
		}
		
		# Close handle
		if (false === fclose($fh))
		{
			die('Cannot close logfile '.$filename);
		}
	}
}
