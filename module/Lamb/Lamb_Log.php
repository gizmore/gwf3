<?php
/**
 * Lamb log wrapper.
 * @author gizmore
 * @version 3.0
 */
final class Lamb_Log
{
	public static function log($message)
	{
		if (PHP_SAPI === 'cli')
		{
			echo $message.PHP_EOL;
		}
		GWF_Log::log('lamb', $message, true);
		return true;
	}
	
	public static function logChat(Lamb_Server $server, $message)
	{
		if (PHP_SAPI === 'cli')
		{
			echo $message.PHP_EOL;
		}
		
		# One file per server
		$host = preg_replace('/[^a-z0-9_\\.]/', '', strtolower($server->getHostname()));
		
		# Log it
		GWF_Log::log("lamb_chat_{$host}", $message, true);
		return true;
	}
	
	public static function logError($message)
	{
		if (PHP_SAPI === 'cli')
		{
			echo 'ERROR: '.$message.PHP_EOL;
		}
		GWF_Log::log('lamb_error', $message, true);
		GWF_Log::log('lamb_error_details', GWF_Debug::backtrace($message, false));
		return false;
	}
	
	public static function logDebug($message)
	{
		if (PHP_SAPI === 'cli')
		{
			echo $message.PHP_EOL;
		}
		GWF_Log::log('lamb_debug', $message, true);
		return true;
	}
	
	/**
	 * Output info about errorneous ircd message.
	 * @param Lamb_Server $server
	 * @param unknown_type $command
	 * @param unknown_type $from
	 * @param array $args
	 */
	public static function debugCommand(Lamb_Server $server, $command, $from, array $args)
	{
		if (PHP_SAPI === 'cli')
		{
			echo '======================'.PHP_EOL;
			echo 'Lamb_Log::debugCommand'.PHP_EOL;
			echo 'CMD: '.$command.PHP_EOL;
			echo 'FROM: '.$from.PHP_EOL;
			echo 'ARGS: '.implode(',', $args).PHP_EOL;
			echo '======================'.PHP_EOL;
		}
		return true;
	}
}
?>