<?php
final class TGC_Commands
{
	const DEFAULT_MID = '0000000';
	const MID_LENGTH = 7;
	
	public static function execute(TGC_Player $player, $message)
	{
		GWF_Log::logCron(sprintf("%s executes %s", $player->getName(), $message));
		$parts = explode(':', $message, 5);
		$methodName = 'cmd_'.$parts[3];
		$payload = $parts[4];
		$mid = self::DEFAULT_MID;
		if (substr($payload, 0, 4) === 'MID:') {
			$mid = substr($payload, 4, self::MID_LENGTH);
			$payload = substr($payload, 12);
		}
		return call_user_func(array(__CLASS__, $methodName), $player, $payload, $mid);
	}
	
	public static function validCommand($commandName)
	{
		$methodName = 'cmd_'.$commandName;
		return method_exists(__CLASS__, $methodName);
	}
	
	public static function disconnect(TGC_Player $player) {
		$payload = self::payload($player->getName());
		$player->forNearMe(function($p, $payload) {
			$p->sendCommand('QUIT', $payload);
		}, $payload);
		TGC_Global::removePlayer($player);
	}
	
	public static function payload($payload, $mid=self::DEFAULT_MID)
	{
		return $mid === self::DEFAULT_MID ? $payload : sprintf('MID:%7s:%s', $mid, $payload);
	}
	
	################
	### Commands ###
	################
	public static function cmd_ping(TGC_Player $player, $payload, $mid)
	{
		$clientVersion = $payload;
		$player->sendCommand('PONG', self::payload('1.0.0', $mid));
	}
	
	public static function cmd_stats(TGC_Player $player, $payload, $mid)
	{
		$stats = array(
			'players' => count(TGC_Global::$PLAYERS),
			'memory' => memory_get_usage(),
			'peak' => memory_get_peak_usage(true),
			'cpu' => 1.00,
		);
		$player->sendJSONCommand('STATS', $stats);
	}
	
	public static function cmd_chat(TGC_Player $player, $payload, $mid)
	{
		$payload = $player->getName().':'.$payload;
		$player->forNearMe(function($p, $payload){
			$p->sendCommand('CHAT', $payload);
		}, $payload);
		$player->sendCommand('CHAT', $payload);
	}
	
	public static function cmd_pos(TGC_Player $player, $payload, $mid)
	{
		$coords = json_decode($payload);
		
		$player->moveTo($coords->lat, $coords->lng);
		
		$payload = json_encode(array(
			'player' => array_merge(array('name' => $player->getName(), 'hash' => $player->getStatsHash())),
			'pos' => array(
				'lat' => $coords->lat,
				'lng' => $coords->lng,
			),
		));

		$player->sendCommand('POS', $payload);
		$player->forNearMe(function($p, $payload) {
			$p->sendCommand('POS', $payload);
		}, $payload);
		
// 		player->initialPositionUpdate();
	}
	
	public static function cmd_player(TGC_Player $player, $payload, $mid)
	{
		if (!($p = TGC_ServerUtil::getPlayerForName($payload)))
		{
			return $player->sendError('ERR_UNKNOWN_PLAYER');
		}
		$payload = json_encode(array(
			'player' => array_merge(array('name' => $p->getName(), 'hash' => $p->getStatsHash()), $p->playerDTO()),
		));
		$player->sendCommand('PLAYER', self::payload($payload, $mid));
	}
	
	public static function cmd_fight(TGC_Player $player, $payload, $mid)
	{
		if (!($p = TGC_ServerUtil::getPlayerForName($payload)))
		{
			return $player->sendError('ERR_UNKNOWN_PLAYER');
		}
		$attack = new TGC_Attack($player, $p, $mid);
		$attack->dice('fighter');
	}
	
	public static function cmd_attack(TGC_Player $player, $payload, $mid)
	{
		if (!($p = TGC_ServerUtil::getPlayerForName($payload)))
		{
			return $player->sendError('ERR_UNKNOWN_PLAYER');
		}
	
		$attack = new TGC_Attack($player, $p, $mid);
		$attack->dice('ninja');
	}
	
	public static function cmd_brew(TGC_Player $player, $payload, $mid)
	{
		$data = json_decode($payload);
		if (!($p = TGC_ServerUtil::getPlayerForName($data->target)))
		{
			return $player->sendError('ERR_UNKNOWN_PLAYER');
		}
		if ($potion = TGC_Potion::factory($player, $p, 'BREW', $data->runes, $mid))
		{
			$potion->brew();
		}
	}
	
	public static function cmd_cast(TGC_Player $player, $payload, $mid)
	{
		$data = json_decode($payload);
		if (!($p = TGC_ServerUtil::getPlayerForName($data->target)))
		{
			return $player->sendError('ERR_UNKNOWN_PLAYER');
		}
		if ($spell = TGC_Spell::factory($player, $p, 'CAST', $data->runes, $mid))
		{
			$spell->cast();
		}
	}
}
