<?php
final class Shadowcmd_gml extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if ( (count($args) < 3) || (count($args) > 4) )
		{
			$bot->reply(Shadowhelp::getHelp($player, 'gml'));
			return false;
		}
		
		$action = SR_Party::ACTION_OUTSIDE;
		
		if (count($args) > 3)
		{
			switch ($args[3])
			{
				case SR_Party::ACTION_INSIDE:
				case SR_Party::ACTION_OUTSIDE:
					$action = $args[3];
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
		
		if (false !== ($error = self::checkCreated($target)))
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
		
		if (false === ($city = Shadowrun4::getCity($args[1])))
		{
			$bot->reply('The city '.$args[1].' is unknown');
			return false;
		}
		
		if (false === ($loc = $city->getLocation($args[2])))
		{
			$bot->reply(sprintf('The location %s is unknown in %s.', $args[2], $args[1]));
			return false;
		}
		
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
