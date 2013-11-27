<?php
final class Shadowcmd_whisper extends Shadowcmd
{
	const WB_TIME = 180;
	public static $WHISPER = array();
	
	public static function execute(SR_Player $player, array $args)
	{
		$c = count($args);
		if ($c < 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'whisper'));
			return false;
		}
		
		$name = array_shift($args);
		$message = implode(' ', $args);

// 		if (self::whisperToRealNPC($player, $name, $message))
// 		{
// 			return true;
// 		}
		
		$result = Shadowrun4::getPlayerByShortName($name);
		
		if ($result === false)
		{
			return $player->msg('1017');
// 			return $player->message('The player is unknown or not in memory.');
		}
		elseif ($result === -1)
		{
			return $player->msg('1018');
// 			return $player->message('The player name is ambigous. Try the {server} version.');
		}
		else
		{
			return self::onWhisper($player, $result, $message);
		}
	}
	
// 	private static function whisperToRealNPC(SR_Player $player, $name, $message)
// 	{
// 		if (false === ($location = $player->getParty()->getLocationClass()))
// 		{
// 			return false;
// 		}
		
// 		foreach ($location->getRealNPCS() as $npcname)
// 		{
// 			if ()
// 		}
// 		if (in_array($name, ->getRealNPCS()))
// 		{
// 			return self::onWhisper($player, SR_Player::getRealNPCByName($name), $message);
// 		}
		
// 	}
	
	public static function onWhisper(SR_Player $from, SR_Player $to, $message)
	{
		self::onWhispered($from, $to);
		return $to->msg('5086', array($from->getName(), $message));
// 		return $to->message(sprintf("\X02%s\X02 whispers: \"%s\"", $from->getName(), $message));
	}
	
	/**
	 * Set who whispered who to allow implementation of whisper_back.
	 * @param SR_Player $from
	 * @param SR_Player $to
	 */
	private static function onWhispered(SR_Player $from, SR_Player $to)
	{
		$pid = $to->getID();
		
		if (!isset(self::$WHISPER[$pid]))
		{
			self::$WHISPER[$pid] = array();
		}
		
		self::cleanupWhisper($pid);
		
		self::$WHISPER[$pid][$from->getID()] = Shadowrun4::getTime();
	}
	
	private static function cleanupWhisper($pid)
	{
		$data = self::$WHISPER[$pid];
		if (count($data) < 2)
		{
			return;
		}
		
		$time = Shadowrun4::getTime() - self::WB_TIME;
		foreach ($data as $fid => $t)
		{
			if ($t < $time)
			{
				unset(self::$WHISPER[$pid][$fid]);
			}
		}
	}
}
?>
