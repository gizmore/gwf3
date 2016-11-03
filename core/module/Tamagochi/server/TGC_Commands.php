<?php
final class TGC_Commands
{
	public static function execute(TGC_Player $player, $message)
	{
		GWF_Log::logCron(sprintf("%s executes %s", $player->getName(), $message));
		$parts = explode(':', $message, 5);
		$methodName = 'cmd_'.$parts[3];
		$payload = $parts[4];
		return call_user_func(array(__CLASS__, $methodName), $player, $payload);
	}
	
	public static function validCommand($commandName)
	{
		$methodName = 'cmd_'.$commandName;
		return method_exists(__CLASS__, $methodName);
	}
	
	################
	### Commands ###
	################
	public static function cmd_ping(TGC_Player $player, $payload)
	{
		$version = $payload;
		$player->sendCommand('PONG', $version);
	}
	
	public static function cmd_join(TGC_Player $player, $payload)
	{
	
	}
	
	public static function cmd_say(TGC_Player $player, $payload)
	{
		
	}
	
	
	public static function cmd_pos(TGC_Player $player, $payload)
	{
	
	}
	
	public static function cmd_slap(TGC_Player $player, $payload)
	{
	
	}
	
	
}