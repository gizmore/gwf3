<?php
class Dog_CVS_Worker extends Dog_Worker
{
	protected static function getRepoPath(array $gdo_data) { return GWF_WWW_PATH.'dbimg/dogrepo/'.$gdo_data['repo_name']; }
	
	############
	### Trac ###
	############
	protected static function tracInit()
	{
		
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

}
