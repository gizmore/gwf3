<?php
final class Shadowcmd_whisper extends Shadowcmd
{
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
		
		$result = Shadowrun4::getPlayerByShortName($name);
		
		if ($result === false)
		{
			return $player->message('The player is unknown or not in memory.');
		}
		elseif ($result === -1)
		{
			return $player->message('The player name is ambigous. Try the {server} version.');
		}
		else
		{
			return self::onWhisper($player, $result, $message);
		}
	}
	
	public static function onWhisper(SR_Player $from, SR_Player $to, $message)
	{
		return $to->message(sprintf('%s whisper: "%s"', $from->getName(), $message));
	}
}
?>
