<?php
require_once 'DOG_CVS_Worker.php';
final class Dog_CVS_Git_Worker extends Dog_CVS_Worker 
{
	################
	### Checkout ###
	################
	private static $TIME_START;
	private static $MESSAGE;
	
	private static function elapsed() { return microtime(true) - self::$TIME_START; }
	private static function parseProgress($message) { self::$MESSAGE = $message; }
	private static function printProgress() { self::reply(self::$MESSAGE); }
	
	public static function checkout($gdo_data)
	{
		self::$MESSAGE = '_NO_MSG_';
		self::$TIME_START = microtime(true);
		
		$url = $gdo_data['repo_url'];
		$eurl = escapeshellarg($url);
		
		$name = $gdo_data['repo_name'];
		$ename = escapeshellarg($name);
		
		$path = self::getRepoPath($gdo_data);
		$epath = escapeshellarg($path);
		
		self::proc_with_callback("git clone --progress $eurl $epath 2>&1", array(__CLASS__, 'proc_checkout'));
	}
	
	public static function proc_checkout($message)
	{
		self::parseProgress($message);
		if (self::elapsed() > 5.0)
		{
			self::$TIME_START = microtime(true);
			self::printProgress();
		}
	}
	
	############
	### Pull ###
	############
	public static function pull($gdo_data)
	{
		GWF_Log::logCron('Dog_CVS_Git_Worker::pull()');
		
		$function = array(__CLASS__, 'pull_'.$gdo_data['repo_type']);
		if (!GWF_Callback::isCallback($function))
		{
			// Compose result code 0
			return array(0, 'err_repo_type_stub');
		}
		return call_user_func($function, $gdo_data);
	}
	
	public static function pull_git($gdo_data)
	{
		GWF_Log::logCron('Dog_CVS_Git_Worker::pull_git()');
		
		$path = self::getRepoPath($gdo_data);
		$epath = escapeshellarg($path);
		
		// Pull
		self::exec("cd $epath && git pull");
		
		// Check revision counter
		$revcount = self::exec_line("cd $epath && git rev-list HEAD --count");
		
		// Check curent revision
		$lines = self::exec("cd $epath && git log -1");
		$revision = trim(Common::substrFrom(array_shift($lines), ' '));
		$commiter = Common::substrUntil(trim(Common::substrFrom(array_shift($lines), ' ')), ' ');;
		$date = trim(Common::substrFrom(array_shift($lines), ' '));
		$_emptyline = array_shift($lines);
		array_map('trim', $lines);
		$comment = implode(' ', $lines);

		// Compose result code 1
		$result = array(
			'revcount' => $revcount,
			'revision' => $revision,
			'revdate' => $date,
			'commiter' => $commiter,
			'comment' => $comment,
		);
		return array(1, $result);
	}
}
