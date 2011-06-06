<?php
/**
 * Lamb log wrapper.
 * @author gizmore
 * @version 3.0
 */
final class Lamb_Log
{
	public static function logChat(Lamb_Server $server, $message)
	{
		# One file per server
		$host = preg_replace('/[^a-z0-9_\\.]/', '', strtolower($server->getHostname()));
		return GWF_Log::log("lamb_chat_{$host}", $message, true);
	}
	
	public static function logError($message)
	{
		GWF_Log::log('lamb_error', $message, true);
		GWF_Log::log('lamb_error_details', GWF_Debug::backtrace($message, false));
		return false;
	}
	
	#############
	### Debug ###
	#############
	public static function logDebug($message)
	{
		return GWF_Log::log('lamb_debug', $message, true);
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