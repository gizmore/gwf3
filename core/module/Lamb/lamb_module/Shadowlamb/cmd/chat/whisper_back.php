<?php
final class Shadowcmd_whisper_back extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) === 0)
		{
			$player->message(Shadowhelp::getHelp($player, 'whisper_back'));
			return false;
		}

		$target = self::getWBTarget($player);
		
		if ($target === -1)
		{
			$player->message(sprintf('Nobody whispered you in the last %s.', GWF_Time::humanDuration(Shadowcmd_whisper::WB_TIME)));
			return false;
		}
		elseif ($target === false)
		{
			$player->message('Your chat buddy is not in memory.');
			return false;
		}
		elseif ($target === -2)
		{
			$player->message('Multiple players whispered you, so I quit with this message.');
			return false;
		}
		
		return Shadowcmd_whisper::onWhisper($player, $target, implode(' ', $args));
	}
	
	private static function getWBTarget(SR_Player $player)
	{
		$pid = $player->getID();
		if (!isset(Shadowcmd_whisper::$WHISPER[$pid]))
		{
			return -1;
		}
		
		$data = Shadowcmd_whisper::$WHISPER[$pid];
		
		if (count($data) === 1)
		{
			return Shadowrun4::getPlayerByPID(key($data));
		}
		
		return -2;
	}
}
?>