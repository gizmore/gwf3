<?php
final class Shadowcmd_gml extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if ( (count($args) < 2) || (count($args) > 3) )
		{
			$bot->reply(Shadowhelp::getHelp($player, 'gml'));
			return false;
		}
		
		$action = SR_Party::ACTION_OUTSIDE;
		
		if (count($args) > 2)
		{
			switch ($args[2])
			{
				case SR_Party::ACTION_INSIDE:
				case SR_Party::ACTION_OUTSIDE:
					$action = $args[2];
					break;
				default:
					$bot->reply(Shadowhelp::getHelp($player, 'gml'));
					return false;
			}
		}
		
//		$server = $player->getUser()->getServer();
//		if (false === ($user = $server->getUserByNickname($args[0])))
		if (false === ($target = Shadowrun4::getPlayerByShortName($args[0])))
		{
			$bot->reply(sprintf('The user %s is unknown.', $args[0]));
			return false;
		}
		elseif ($target === -1)
		{
			$bot->reply('The player name is ambigious.');
			return false;
		}
		
//		if (false === ($target = Shadowrun4::getPlayerForUser($user)))
//		{
//			$bot->reply(sprintf('The player %s is unknown.', $args[0]));
//			return false;
//		}
		
		if (false === $target->isCreated())
		{
			$bot->reply(sprintf('The player %s has not started a game yet.', $args[0]));
			return false;
		}

		$p = $target->getParty();
		$a = $p->getAction();
		if ($a !== SR_Party::ACTION_INSIDE && $a !== SR_Party::ACTION_OUTSIDE)
		{
			$bot->reply('The party with '.$args[0].' is moving.');
			return false;
		}
		
		$cityname = Common::substrUntil($args[1], '_', '');
		$locname = Common::substrFrom($args[1], '_', '');
		
		if (false === ($city = Shadowrun4::getCity($cityname)))
		{
			$bot->reply('The city '.$cityname.' is unknown');
			return false;
		}
		
		if (false === ($loc = $city->getLocation($locname)))
		{
			$bot->reply(sprintf('The location %s is unknown in %s.', $locname, $cityname));
			return false;
		}
		
		$p->pushAction(SR_Party::ACTION_DELETE);
		
		$cl = $loc->getName();
		$city->onCityEnter($p);
		$p->pushAction($action, $cl);
// 		$p->pushAction(SR_Party::ACTION_OUTSIDE, $cl);
		$bot->reply(sprintf('The party is now %s of %s.', $action, $cl));
		$p->giveKnowledge('places', $cl);
		
		return true;
	}
}
?>
