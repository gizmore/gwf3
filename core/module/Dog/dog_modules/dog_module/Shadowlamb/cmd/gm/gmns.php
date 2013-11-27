<?php
final class Shadowcmd_gmns extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) !== 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'gmns'));
			return false;
		}
		
		$username = $args[0];
		$remote = Shadowrun4::getPlayerByShortName($username);
		
		if ($remote === -1)
		{
			$player->message('The username is ambigious.');
			return false;
		}
		
		if ($remote === false)
		{
			$player->message('The player is not in memory or unknown.');
			return false;
		}
		
		return self::onGMNS($player, $remote, $args[1]);
	}
	
	private static function onGMNS(SR_Player $player, SR_Player $target, $arg)
	{
		$pid = $target->getID();
		
		if (strtolower($arg) === 'on')
		{
			if (false === SR_NoShout::setNoShout($pid, -1))
			{
				return false;
			}
			return $player->message(sprintf('Banned %s from shouting.', $target->getName()));
		}
		elseif (strtolower($arg) === 'off')
		{
			if (false === SR_NoShout::setShout($pid))
			{
				return false;
			}
			return $player->message(sprintf('Allowed %s to shout again.', $target->getName()));
		}
		elseif (0 < ($seconds = GWF_TimeConvert::humanToSeconds($arg)))
		{
			if (false === SR_NoShout::setNoShout($pid, $seconds))
			{
				return false;
			}
			return $player->message(sprintf('Banned %s from shouting for %s.', $target->getName(), GWF_TimeConvert::humanDuration($seconds)));
		}
		else
		{
			$player->message(Shadowhelp::getHelp($player, 'gmns'));
			return false;
		}
	}
}
?>