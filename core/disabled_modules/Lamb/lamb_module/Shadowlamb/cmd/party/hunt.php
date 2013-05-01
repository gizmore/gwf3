<?php
final class Shadowcmd_hunt extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$p = $player->getParty();
		
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'hunt'));
			return false;
		}
		
		if (false === self::checkLeader($player))
		{
			return false;
		}
		if (false === self::checkMove($p))
		{
			return false;
		}
		
		$target = Shadowrun4::getPlayerByShortName($args[0]);
		if ($target === false)
		{
			self::rply($player, '1017');
// 			$bot->reply('This player is not in memory.');
			return false;
		}
		elseif ($target === -1)
		{
			self::rply($player, '1018');
// 			$bot->reply('The player name is ambigous. Try the {server} version.');
			return false;
		}
		$name = $target->getName();
		
		$p = $player->getParty();
		$ep = $target->getParty();
		if ($p->getID() === $ep->getID())
		{
			self::rply($player, '1083');
// 			$bot->reply('You cannot hunt own party members.');
			return false;
		}
		
		if ($p->getCity() !== $ep->getCity())
		{
			self::rply($player, '1084', array($name, $p->getCity(), $name, $ep->getCity()));
// 			$bot->reply(sprintf('You cannot hunt %s because you are in %s and %s is in %s.', $name, $p->getCity(), $name, $ep->getCity()));
			return false;
		}
		
		$city = $p->getCityClass();
		$eta = round($city->getExploreETA($p) * 1.2);
		$p->pushAction(SR_Party::ACTION_HUNT, $target->getName().' in '.$city->getName(), $eta);
		$p->setContactEta(rand(10,20));
		$p->ntice('5134', array($target->getName(), GWF_Time::humanDuration($eta)));
// 		$p->notice(sprintf('You start to hunt %s. ETA: %s.', $target->getName(), GWF_Time::humanDuration($eta)));
		return true;
	}
}
?>
