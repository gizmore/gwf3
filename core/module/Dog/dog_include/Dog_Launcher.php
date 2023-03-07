<?php
declare(ticks = 1);

if (function_exists('pcntl_signal'))
{
	if (false === pcntl_signal(SIGINT, array('Dog_Launcher',  'SIGINT')))
	{
		die('Cannot install SIGINT handler in '.__FILE__.PHP_EOL);
	}
}

# Crash handler
set_error_handler(array('Dog_Launcher', 'error_handler'));
register_shutdown_function(array('Dog_Launcher', 'shutdown'));


final class Dog_Launcher
{
	private static $KILL = false;
	private static $CLEANED = false;
	public static function kill($kill = true) { self::$KILL = $kill; self::$CLEANED = true; }
	public static function SIGINT() { echo PHP_EOL; self::cleanup('I have catched a SIGINT!'); }
	public static function shouldRestart() { return self::$KILL; }
	
	public static function cleanup($message='Clean shutdown!')
	{
		GWF_CachedCounter::persist();
		if (NULL !== Dog_Init::getStartupTime())
		{
			GWF_Counter::increaseCount('dog_uptime', Dog_Init::getUptime());
		}
		if (self::$CLEANED === false)
		{
			self::$CLEANED = true;
			foreach (Dog::getServers() as $server)
			{
				$server instanceof Dog_Server;
				if ($server->isConnected())
				{
					$server->disconnect($message);
				}
			}
		}
		die(0);
	}
	
	public static function error_handler($errno, $errstr, $errfile, $errline, $errcontext=null)
	{
		GWF_Debug::error_handler($errno, $errstr, $errfile, $errline, $errcontext);
		if ($errno === E_ERROR)
		{
			self::cleanup('Fatal PHP Error :O');
		}
	}
	
	public static function shutdown()
	{
		$error = error_get_last();
		
		if ($error && $error['type'] != 0)
		{
			self::cleanup('Fatal PHP Error :O');
		}
	}
}
?>
