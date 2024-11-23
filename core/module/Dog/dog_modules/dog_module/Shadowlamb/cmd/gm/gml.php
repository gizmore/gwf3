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
		
		if (false === ($location = self::getLocationByAbbrev($p->getCity(), $args[1])))
		{
			$bot->reply('What location?');
			return false;
		}
		
		
		$p->pushAction(SR_Party::ACTION_DELETE);
		
		$cl = $location->getName();
		$p->pushAction($action, $cl);
		$bot->reply(sprintf('The party is now %s of %s.', $action, $cl));
		$p->giveKnowledge('places', $cl);
		
		return true;
	}
	
	/**
	 * @param string $cityname
	 * @param string $arg
	 * @return SR_Location
	 */
	public static function getLocationByAbbrev($cityname, $arg)
	{
		$player = Shadowrun4::getCurrentPlayer();
		
		if (false !== ($c = Common::substrUntil($arg, '_', false)))
		{
			$cityname = $c;
			$arg = Common::substrFrom($arg, '_', $arg);
		}
		
		if (false === ($city = Shadowrun4::getCityByAbbrev($cityname)))
		{
			$player->message('Unknown city: '.$cityname);
			return false;
		}
		
		$city instanceof SR_City;
		
		return $city->getLocationByAbbrev($arg);
	}
}
?>
