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
		$bot = Lamb::instance();
		$host = preg_replace('/[^a-z0-9_\\.]/', '', strtolower($server->getHostname()));
		
		$result = true;
		
		if (false !== ($user = $bot->getCurrentUser()))
		{
			$name = $user->getName();
			$name = preg_replace('/[^a-z_0-9]/i', '', $name);
			GWF_Log::rawLog("lamb/lamb_chat_{$host}_{$name}", $message);
		}
		
		if (false !== ($chan = $bot->getCurrentChannel()))
		{
			$name = $chan->getName();
			GWF_Log::rawLog("lamb/lamb_chat_{$host}_{$name}", $message);
		}
		else
		{
			GWF_Log::rawLog("lamb/lamb_chat_{$host}", $message);
		}
		
		GWF_Log::flush();
		
		return $result;
	}
	
	public static function logError($message)
	{
		$message = GWF_Debug::backtrace($message, false);
		echo $message;
		GWF_Log::rawLog('lamb_error', $message);
		GWF_Log::flush();
// 		GWF_Log::log('lamb_error_details', GWF_Debug::backtrace($message, false));
		return false;
	}
	
	#############
	### Debug ###
	#############
	public static function logDebug($message)
	{
		echo $message.PHP_EOL;
		GWF_Log::rawLog('lamb_debug', $message);
		GWF_Log::flush();
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
