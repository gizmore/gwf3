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
	
	public static function cmd_stats(TGC_Player $player, $payload)
	{
		$stats = array(
			'players' => count(TGC_Global::$PLAYERS),
			'memory' => memory_get_usage(),
			'peak' => memory_get_peak_usage(true),
			'cpu' => 1.00,
		);
		$player->sendJSONCommand('STATS', $stats);
	}
	
	public static function cmd_chat(TGC_Player $player, $payload)
	{
		$player->forNearMe(function($p){
			$p->sendCommand('CHAT', $payload);
		});
		$player->sendCommand('CHAT', $payload);
	}
	
	public static function cmd_pos(TGC_Player $player, $payload)
	{
		$coords = json_decode($payload);
		
		$player->moveTo($coords->lat, $coords->lng);
		
		$payload = json_encode(array(
			'player' => array_merge(array('name' => $player->getName(), 'gender' => $player->getGender()), $player->playerDTO()),
			'pos' => array(
				'lat' => $coords->lat,
				'lng' => $coords->lng,
			),
		));

		$player->sendCommand('POS', $payload);
		$player->forNearMe(function($p) {
			$p->sendCommand('POS', $payload);
		});
	}
	
	public static function cmd_slap(TGC_Player $player, $payload)
	{
	
	}
	
	
}