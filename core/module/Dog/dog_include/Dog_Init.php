<?php
final class Dog_Init
{
	private static $STARTUP_TIME = NULL;
	public static function getStartupTime() { return self::$STARTUP_TIME; }
	public static function getUptime() { return microtime(true) - self::$STARTUP_TIME; }
	
	public static function init()
	{
		Dog_Lang::init();
		
		self::initModules();
	
		foreach (Dog_Server::getAllServers() as $server)
		{
			$server instanceof Dog_Server;
			Dog::addServer($server);
		}
		
		Dog_Timer::init(self::getSleepMillis());
	
		Dog_Timer::addTimer(array(__CLASS__, 'initTimers'), NULL, count(Dog::getServers())*2+1, false);
		
		self::$STARTUP_TIME = microtime(true);
				
		return true;
	}
	
	public static function validate()
	{
		$servers = Dog::getServers();
		
		if (count($servers) === 0)
		{
			return Dog_Log::error('No server available!');
		}
		
		foreach ($servers as $server)
		{
			$server instanceof Dog_Server;
			if ($server->isWebsocket())
			{
				
			}
			elseif (false === Dog_Nick::getNickFor($server))
			{
				return Dog_Log::error(sprintf('Server %s has no nickname setup!', $server->displayName()));
			}
		}
		
		return true;
	}
	
	public static function installModules($flush_tables=false)
	{
		self::initModules();
		
		foreach (Dog_Module::getModules() as $module)
		{
			self::installModule($module, $flush_tables);
			$module->onInit();
		}
	}
	
	public static function installModule(Dog_Module $module, $flush_tables)
	{
		$path = $module->getTablePath();
		if (Common::isDir($path))
		{
			foreach (scandir($path) as $filename)
			{
				if (Common::endsWith($filename, '.php'))
				{
					GDO::table(substr($filename, 0, -4))->createTable($flush_tables);
				}
			}
		}
		$module->onInstall($flush_tables);
	}
	
	private static function initModules()
	{
		foreach (scandir(DOG_PATH.'dog_module') as $filename)
		{
			if ($filename[0] !== '.')
			{
				$path = DOG_PATH.'dog_module/'.$filename;
				if (Common::isDir($path))
				{
					$modf = $path.'/DOGMOD_'.$filename.'.php';
					require_once $modf;
					Dog_Module::createModule($filename);
				}
			}
		}
	}

	public static function isValidISO($iso)
	{
		return in_array($iso, array_merge(GWF_Language::getAvailable(), array('bot', 'ibd')), true);
	}
	
	public static function getTriggers()
	{
		return Dog_Conf_Bot::getConf('triggers', '.');
	}
	
	public static function isTrigger(Dog_Server $serv, $chan, $trigger)
	{
		$triggers = NULL;
		if ($chan !== false)
		{
			$triggers = $chan->getTriggers();
		}
		if ($triggers === NULL)
		{
			$triggers = $serv->getTriggers();
		}
		if ($triggers === NULL)
		{
			$triggers = self::getTriggers();
		}
		return strpos($triggers, $trigger) !== false;
	}
	
	public static function getSleepMillis()
	{
		return (int) Dog_Conf_Bot::getConf('millis', 50);
	}
	
	public static function isBlocking()
	{
		return (int) Dog_Conf_Bot::getConf('blocking', 0);
	}
	
	##############
	### Timers ###
	##############
	public static function getTimerDir() { return DOG_PATH.'dog_timer/'; }
	public static function initTimers()
	{
		# Modules
		foreach (Dog_Module::getModules() as $module)
		{
			$module instanceof Dog_Module;
			$module->onInitTimers();
		}
		
		# One timer for each server.
		$d = self::getTimerDir();
		$dir =  $d.'all_servers_all';
		foreach (Dog::getServers() as $server)
		{
			$server instanceof Dog_Server;
			GWF_File::filewalker($dir, true, array(__CLASS__, 'initTimersDir'), false, $server);
		}

		# One timer per server for all servers.
		$dir = $d.'all_servers_one';
		GWF_File::filewalker($dir, true, array(__CLASS__, 'initTimersDir'), false, $server);
		
		# One timer per server for a single server.
		$dir = $d.'one_server_one';
		GWF_File::filewalker($dir, true, array(__CLASS__, 'initTimersDirServer'), false, NULL);
	}
	
	public static function initTimersDirServer($entry, $fullpath, $null=NULL)
	{
		
		if (false !== ($server = Dog_Server::getByTLD($entry)))
		{
			if (false !== ($server = Dog::getServerByID($server->getID())))
			{
				GWF_File::filewalker($fullpath, true, array(__CLASS__, 'initTimersDir'), false, $server);
			}
			else
			{
				Dog_Log::debug(sprintf("Server %d-%s for Timer in path \"%s\" is not Online.", $serverid, $entry, $fullpath));
			}
		}
		else
		{
			Dog_Log::debug(sprintf('Timer in path "%s" could not find it\'s server: %s.', $fullpath, $entry));
		}
	}
	
	public static function initTimersDir($entry, $fullpath, $server)
	{
		GWF_File::filewalker($fullpath.'/infinity', true, array(__CLASS__, 'initTimerInfDir'), false, $server);
		GWF_File::filewalker($fullpath.'/triggered', true, array(__CLASS__, 'initTimerTrigDir'), false, $server);
	}
	
	public static function initTimerInfDir($entry, $fullpath, $server)
	{
		GWF_File::filewalker($fullpath, array(__CLASS__, 'initTimerInf'), true, true, array($server, $entry));
	}
	
	public static function initTimerInf($entry, $fullpath, $data)
	{
		list($server, $seconds) = $data;
		Dog_Timer::addTimer($fullpath, $server, $seconds);
	}

	public static function initTimerTrigDir($entry, $fullpath, $server)
	{
		GWF_File::filewalker($fullpath, true, array(__CLASS__, 'initTimerTrigDirRep'), false, array($server, $entry));
	}
	
	public static function initTimerTrigDirRep($entry, $fullpath, $data)
	{
		$data[] = $entry;
		GWF_File::filewalker($fullpath, array(__CLASS__, 'initTimerTrig'), true, true, $data);
	}
	
	public static function initTimerTrig($entry, $fullpath, $data)
	{
		list($server, $repeat, $seconds) = $data;
		Dog_Timer::addTimer($fullpath, $server, $seconds, $repeat);
	}
}
?>
