<?php
/**
 * Goto command also holds helper functions for getting locations by abbrev.
 * @author gizmore
 */
final class Shadowcmd_goto extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (false !== ($error = self::checkLeader($player)))
		{
			$player->message($error);
			return false;
		}
		
		if (count($args) !== 1)
		{
			$player->message(Shadowhelp::getHelp($player, 'goto'));
			return false;
		}
		
		$party = $player->getParty();
		$cityname = $party->getCity();
		$cityclass = $party->getCityClass();
		
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkMove($party)))
		{
			$bot->reply($error);
			return false;
		}
		
		if (false === ($tlc = self::getTLCByArg($player, $args[0])))
		{
			self::rply($player, '1069');
// 			$player->message('This location is unknown or ambigious.');
			return false;
		}
		
		if (false === ($target = $cityclass->getLocation($tlc)))
		{
			self::rply($player, '1070', array($cityname));
// 			$bot->reply(sprintf('The location %s does not exist in %s.', $tlc, $cityname));
			return false;
		}
		
		$tlc = $target->getName();
		if (!$player->hasKnowledge('places', $tlc))
		{
			self::rply($player, '1023');
// 			$bot->reply(sprintf('You don`t know where the %s is.', $tlc));
			return false;
		}
		
		if ($party->getLocation('inside') === $tlc)
		{
			self::rply($player, '1071', array($tlc));
// 			$bot->reply(sprintf('You are already in %s.', $tlc));
			return false;
		}
		
		if ($party->getLocation('outside') === $tlc)
		{
			$target->onEnter($player);
			return true;
		}
		
		if ( ($party->getAction() === SR_Party::ACTION_GOTO) && ($party->getTarget() === $tlc) )
		{
			self::rply($player, '5127', array($tlc, $party->displayETA()));
// 			$bot->reply(sprintf('You are already going to %s. ETA: %s.', $tlc, $party->displayETA()));
			return false;
		}

		$cityclass = $party->getCityClass();
		$eta = $cityclass->getGotoETA($party);
		
		$party->pushAction(SR_Party::ACTION_GOTO, $tlc, $eta);
		$party->setContactEta(rand(5,15));
		$party->ntice('5127', array($tlc, $party->displayETA()));
// 		$party->notice(sprintf('You are going to %s. ETA: %s.', $tlc, GWF_Time::humanDuration($eta)));
		
		return true;
	}
	
	###########################
	### Get Location by arg ###
	###########################
	/**
	 * Get a location in current city.
	 * @param SR_Player $player
	 * @param int|string $arg
	 */
	public static function getTLCByArg(SR_Player $player, $arg)
	{
		return Common::isNumeric($arg) ?
			self::getTLCByID($player, $arg) :
			self::getTLCByName($player, $arg);
	}
	
	public static function getTLCByID(SR_Player $player, $arg)
	{
		if (0 >= ($arg = (int)$arg))
		{
			return false;
		}
		if (false === ($cityname = $player->getParty()->getCity()))
		{
			return false;
		}
		$places = self::getPlacesInCity($player, $cityname);
		if ($arg > count($places))
		{
			return false;
		}
		return $places[$arg-1];
	}
	
	public static function getTLCByName(SR_Player $player, $arg)
	{
		if (false === ($cityname = $player->getParty()->getCity()))
		{
			return false;
		}
		$places = self::getPlacesInCity($player, $cityname);
		return self::getTCLByNameB($player, $arg, $places);
	}
	
	/**
	 * Get a location in current city.
	 * @param SR_Player $player
	 * @param int|string $arg
	 */
	public static function getTLCByArgMulticity(SR_Player $player, $arg)
	{
		return Common::isNumeric($arg) ?
			self::getTLCByIDMulticity($player, $arg) :
			self::getTLCByNameMulticity($player, $arg);
	}
	
	public static function getTLCByIDMulticity(SR_Player $player, $arg)
	{
		# Not possible
		return false;
	}
	
	public static function getTLCByNameMulticity(SR_Player $player, $arg)
	{
		if ('' === ($kp = $player->getKnowledge('places')))
		{
			return false;
		}
		$places = explode(',', $kp);
		return self::getTCLByNameB($player, $arg, $places);
	}
	
	public static function getPlacesInCurrentCity(SR_Player $player)
	{
		return self::getPlacesInCity($player, $player->getParty()->getCity());
	}
	
	private static function getPlacesInCity(SR_Player $player, $cityname)
	{
		$back = array();
		if ('' === ($kp = $player->getKnowledge('places')))
		{
			return $back;
		}
		$cityname .= '_';
		foreach (explode(',', $kp) as $place)
		{
			if (strpos($place, $cityname) === 0)
			{
				$back[] = $place;
			}
		}
		return $back;
	}
	
	private static function getTCLByNameB(SR_Player $player, $arg, array $places)
	{
		$back = array();
		foreach ($places as $place)
		{
			if (stripos($place, $arg) !== false)
			{
				$back[] = $place;
			}
		}
		return count($back) === 1 ? $back[0] : false;
	}
}
?>