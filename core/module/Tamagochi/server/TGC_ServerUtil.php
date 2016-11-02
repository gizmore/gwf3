<?php
/**
 * UID:NICK:SECRET:CMD:PAYLOAD
 * 
 * @author gizmore
 */
final class TGC_ServerUtil
{
	public static function getPlayerForMessage($msg)
	{
		$parts = str_split(':', $msg, 5);
		if (false === ($player = (TGC_Global::getOrLoadPlayer($parts[1])))) {
			return "ERR_PLAYER_NAME";
		}
		if ($player->getID() !== $parts[0]) {
			return "ERR_ID_MISMATCH";
		}
		if (substr($player->getVar('user_password', TGC_Const::SECRET_CUT)) !== $parts[2]) {
			return "ERR_SECRET";
		}
		TGC_Global::addPlayer($player);
		return $player;
	}
	
	public static function getPlayerForName($name)
	{
		return isset(TGC_Global::$PLAYERS[$name]) ? TGC_Global::$PLAYERS[$name] : false;
	}
	
	
	public static function getPlayerForConnection(InterfaceConnection $conn)
	{
		foreach (TGC_Global::$PLAYERS as $name => $player)
		{
			if ($player->getInterfaceConnection() === $conn) {
				return $player;
			}
		}
		return false;
	}

}