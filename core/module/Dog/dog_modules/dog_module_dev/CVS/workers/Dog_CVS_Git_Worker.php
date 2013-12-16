<?php
final class Dog_CVS_Git_Worker extends Dog_Worker 
{
	private static function getRepoPath(array $gdo_data) { return GWF_WWW_PATH.'dbimg/dogrepo/'.$gdo_data['repo_name']; }
	
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
	### Find ###
	############
	private static $FIND_RESULTS = array();
	private static $FIND_MORE = 0;
	private static $FIND_MAX = 5;
	
	public static function proc_find($message)
	{
		if (count(self::$FIND_RESULTS) < self::$FIND_MAX)
		{
			self::$FIND_RESULTS[] = self::findLink($message);
		}
		else
		{
			self::$FIND_MORE++;
		}
		echo $message;
	}
	
	private static function findLink($message)
	{
		return $message;
	}
	
	private static function printFindResults()
	{
		self::reply(self::composeFindResults());
		self::$FIND_MORE = 0;
		self::$FIND_RESULTS = array();
	}
	
	private static function composeFindResults()
	{
		if (count(self::$FIND_RESULTS) === 0)
		{
			return 'err_no_results';
		}
		
		$message = implode(', ', self::$FIND_RESULTS);
		
		if (self::$FIND_MORE > 0)
		{
			$message .= ' and '.self::$FIND_MORE.' more';
		}
		
		return $message;
	}

	public static function find($term, $gdo_data)
	{
		$path = self::getRepoPath($gdo_data);
		$epath = escapeshellarg($path);
		$eterm = escapeshellarg($term);
		self::proc_with_callback("find $epath -type f -name $eterm", array(__CLASS__, 'proc_find'));
		self::printFindResults();
	}
	
	public static function findi($term, $gdo_data)
	{
		$path = self::getRepoPath($gdo_data);
		$epath = escapeshellarg($path);
		$eterm = escapeshellarg($term);
		self::proc_with_callback("find $epath -type f -iname $eterm", array(__CLASS__, 'proc_find'));
		self::printFindResults();
	}	

	public static function findd($term, $gdo_data)
	{
		$path = self::getRepoPath($gdo_data);
		$epath = escapeshellarg($path);
		$eterm = escapeshellarg($term);
		self::proc_with_callback("find $epath -type d -name $eterm", array(__CLASS__, 'proc_find'));
		self::printFindResults();
	}
	
	public static function finddi($term, $gdo_data)
	{
		$path = self::getRepoPath($gdo_data);
		$epath = escapeshellarg($path);
		$eterm = escapeshellarg($term);
		self::proc_with_callback("find $epath -type d -iname $eterm", array(__CLASS__, 'proc_find'));
		self::printFindResults();
	}	

	public static function search($term, $gdo_data)
	{
		$path = self::getRepoPath($gdo_data);
		$epath = escapeshellarg($path);
		$eterm = escapeshellarg($term);
		self::proc_with_callback("grep -r $eterm $epath", array(__CLASS__, 'proc_find'));
		self::printFindResults();
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
