<?php 
require_once 'Dog_Includes.php';
/**
 * Dog log wrapper.
 * @author gizmore, tehron
 * @version 4.1
 */
final class Dog_Log
{
	public static function server(Dog_Server $server, Dog_IRCMsg $irc_msg)
	{
		echo date("H:i:s") . " " . $server->getTLD();

		if (in_array(strtolower($irc_msg->getCommand()), array('privmsg', 'notice')) && $irc_msg->getArgc() > 1) {
			$from = $irc_msg->getFrom();
			$target = $irc_msg->getArg(0);
			$msg = $irc_msg->getArg(1);
			if ($target[0] !== '#' && $irc_msg->getDirection() == Direction::IN) {
				$target = $from;
			}
			echo " " . $target . ": " . $from . ": " . $msg . PHP_EOL;
		} else {
			$d = $irc_msg->getDirection() === Direction::IN ? ' << ' : ' >> ';
			echo $d . $irc_msg->getRaw() . PHP_EOL;
		}

		if ($server->isLogging())
		{
			$host = GWF_String::remove($server->getHost(), '/', '!');
			GWF_Log::rawLog("dog/{$host}/{$host}", $irc_msg->getRaw());
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
		self::warn("Unknown command: {$msg->getCommand()}");
		echo $msg->getRaw().PHP_EOL;
		echo 'CMND: '.$msg->getCommand().PHP_EOL;
		echo 'PRFX: '.$msg->getPrefix().PHP_EOL;
		echo 'ARGS: '.implode(',', $msg->getArgs()).PHP_EOL;
		echo '============================================='.PHP_EOL;
	}
}
?>
