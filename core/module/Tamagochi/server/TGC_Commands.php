<?php
final class TGC_Commands
{
	public static function execute(TGC_Player $player, $message)
	{
		GWF_Log::logCron(sprintf("%s executes %s", $player->getName(), $message));
		$parts = explode(':', $message, 5);
		$methodName = 'cmd_'.$parts[3];
		$payload = $parts[4];
		return call_user_func(array(__CLASS__, $methodName), $payload);
	}
	
	public static function validCommand($commandName)
	{
		$methodName = 'cmd_'.$commandName;
		return method_exists(__CLASS__, $methodName);
	}
	
	################
	### Commands ###
	################
	public static function cmd_ping($payload)
	{
	
	}
	
	public static function cmd_join($payload)
	{
	
	}
	
	public static function cmd_pos($payload)
	{
	
	}
	
	public static function cmd_slap($payload)
	{
	
	}
	
	
}