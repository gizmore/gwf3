<?php
if (!defined('GWF_CHMOD')) { define('GWF_CHMOD', '0777'); }

/**
 * The GWF Logger
 * @author gizmore
 * @version 3.0
 * @since 1.0
 */
final class GWF_Log
{
	private static $username = false;
	private static $basedir = 'protected/logs';
	private static $log_requests = true;
	
	private static $CRONJOB_MODE = false;
	public static function outputLogMessages($bool=true) { self::$CRONJOB_MODE = true; }
	
	############
	### Init ###
	############
	public static function init($username=false, $log_requests=true, $basedir='protected/logs')
	{
		self::$username = $username;
		self::$log_requests = $log_requests;
		self::$basedir = $basedir;
		
		if ($log_requests) {
			self::logRequest();
		}
	}
	
	###############
	### Request ###
	###############
	/**
	 * Get the whole request to log it. Censor passwords. 
	 */
	private static function getRequest()
	{
		$back = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'CRON';
		$back .= isset($_SERVER['REQUEST_URI']) ? ' '.$_SERVER['REQUEST_URI'] : '';
		
		if (count($_POST) > 0)
		{
			$back .= "\nPOSTDATA:\n";
			foreach ($_POST as $k => $v)
			{
				if (stripos($k, 'pass') !== false) {
					$v = 'xxxxxxxx';
				}
				$back .= sprintf('%s => %s', $k, $v).PHP_EOL;
			}
		}
		return $back;
	}
	
	/**
	 * Log the request first.
	 */
	public static function logRequest()
	{
		$request = self::getRequest();
		if (count($_POST) > 0) {
			return self::log('post', $request);
		} else {
			return self::log('get', $request);
		}
	}

	########################
	### Default logfiles ###
	########################
	public static function logCron($message) { return self::log('cron', $message, true); }
	public static function logMessage($message) { return self::log('message', $message); }
	public static function logError($message) { return self::log('error', $message); }
	public static function logCritical($message) { return self::log('critical', $message); }
	
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
		if (is_string($username)) {
			return sprintf('%s/memberlog/%s/%s_%s.txt', self::$basedir, $username, $date, $filename);
		} else {
			return sprintf('%s/%s_%s.txt', self::$basedir, $date, $filename);
		}
	}

	/**
	 * Recursively create logdir with GWF_CHMOD permissions.
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
					if (!mkdir($curr)) {
						printf('Cannot create dir \'%s\' in %s line %s.', $curr, __METHOD__, __LINE__);
						return false;
					}
					if (!chmod($curr, GWF_CHMOD)) {
						printf('Cannot chmod dir \'%s\' in %s line %s.', $curr, __METHOD__, __LINE__);
						return false;
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
	 * @return boolean
	 */
	private static function createLogFile($filename)
	{
		if (!is_file($filename)) {
			if (!touch($filename)) {
				return false;
			}
			if (!chmod($filename, GWF_CHMOD)) {
				return false;
			}
		}
		return fopen($filename, 'a+');
	}
	
	###########
	### Log ###
	###########
	/**
	 * Log a message. In Cronjob mode we also echo. Log member messages twice.
	 * @param string $filename short logname
	 * @param string $message the message
	 * @param boolean $raw
	 */
	public static function log($filename, $message, $raw=false)
	{
		
		if (self::$CRONJOB_MODE)
		{
			echo "$message\n";
		}
		
		elseif (is_string(self::$username))
		{
			# Log member
			self::logB($filename, $message, $raw, self::$username);
		}
		
		self::logB($filename, $message, $raw, false);
	}
	
	private static function logB($filename, $message, $raw, $username)
	{
		$filename = self::getFullPath($filename, $username);
		if (false === self::createLogDir($filename)) {
			die('Can not create logdir '.$filename);
		}
		if (false === ($fh = self::createLogFile($filename))) {
			die('Can not open logfile '.$filename);
		}
		if ($raw === false)
		{		
			$time = date('H:i');
			$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'localhost';
			$username = self::$username === false ? 'Unknown' : self::$username;
			fprintf($fh, '%s [%s] [%s] - %s'.PHP_EOL, $time, $ip, $username, $message);
		}
		else
		{
			fprintf($fh, "%s\n", $message);
		}
		
		fclose($fh);
	}
}
?>