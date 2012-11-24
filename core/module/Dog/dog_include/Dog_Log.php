<?php
/**
 * Dog log wrapper.
 * @author gizmore
 * @version 4.0
 */
final class Dog_Log
{
	public static function server(Dog_Server $server, $message, $direction = ' << ')
	{
		echo $server->getTLD().$direction.$message.PHP_EOL;
		if ($server->isLogging())
		{
			$host = GWF_String::remove($server->getHost(), '/', '!');
			GWF_Log::rawLog("dog/{$host}/{$host}", $message);
			GWF_Log::flush();
		}
	}
	
	public static function channel($channel, $message)
	{
		if ($channel !== false)
		{
			$server = $channel->getServer();
			if ($channel->isLogging() && $server->isLogging())
			{
				$host = GWF_String::remove($server->getHost(), '/', '!');
				$channame = GWF_String::remove($channel->getName(), '/', '!');
				GWF_Log::rawLog("dog/{$host}/channel/{$channame}", $message);
				GWF_Log::flush();
			}
		}
	}
	
	public static function user($user, $message)
	{
		if ($user !== false)
		{
			$server = $user->getServer();
			if ($server->isLogging())
			{
				$host = GWF_String::remove($server->getHost(), '/', '!');
				$nickname = GWF_String::remove($user->getName(), '/', '!');
				GWF_Log::rawLog("dog/{$host}/user/{$nickname}", $message);
				GWF_Log::flush();
			}
		}
	}
	
	public static function critical($message)
	{
		$message = GWF_Debug::backtrace($message, false);
		echo $message;
		GWF_Log::rawLog('dog/critical', trim($message));
		GWF_Log::flush();
		return false;
	}

	public static function error($message)
	{
		$message = GWF_Debug::backtrace($message, false);
		echo $message;
		GWF_Log::rawLog('dog/error', trim($message));
		GWF_Log::flush();
		return false;
	}
	
	public static function warn($message)
	{
		echo $message.PHP_EOL;
		GWF_Log::rawLog('dog/warning', $message);
		GWF_Log::flush();
		return false;
	}
	
	#############
	### Debug ###
	#############
	public static function debug($message)
	{
		echo $message.PHP_EOL;
		GWF_Log::rawLog('dog/debug', $message);
		GWF_Log::flush();
		return true;
	}
	
	/**
	 * Output info about errorneous ircd message.
	 */
	public static function debugMessage()
	{
		$msg = DOG::getIRCMsg();
		echo '============================================='.PHP_EOL;
		self::warn("Unknown event: {$msg->getEvent()}");
		echo $msg->getRaw().PHP_EOL;
		echo 'EVNT: '.$msg->getEvent().PHP_EOL;
		echo 'FROM: '.$msg->getFrom().PHP_EOL;
		echo 'ARGS: '.implode(',', $msg->getArgs()).PHP_EOL;
		echo '============================================='.PHP_EOL;
	}
}
?>
