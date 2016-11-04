<?php
final class TGC_Global
{
	public static $PLAYERS = array();
	
	public static function addPlayer(TGC_Player $player)
	{
		self::$PLAYERS[$player->getName()] = $player;
	}
	
	public static function removePlayer(TGC_Player $player, $reason='NO_REASON')
	{
		if (!isset(self::$PLAYERS[$player->getName()])) {
			return false;
		}
		
		$player->disconnect($reason);
		unset(self::$PLAYERS[$player->getName()]);
		return true;
	}
	
	public static function getPlayer($name)
	{
		return isset(self::$PLAYERS[$name]) ? self::$PLAYERS[$name] : false;
	}
	
	public static function getOrLoadPlayer($name)
	{
		if (false !== ($player = self::getPlayer($name))) {
			return $player;
		}
		return self::loadPlayer($name);
	}
	

	###############
	### Private ###
	###############
	private static function loadPlayer($name)
	{
		$ename = GDO::escape($name);
		return GDO::table('TGC_Player')->selectFirstObject('*, user_name, user_gender', "user_name='$ename'", '', '', array('user'));
	}
	
}
