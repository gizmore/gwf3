<?php
final class Shadowcmd_known_places extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$party = $player->getParty();
		$city = false;
		if (count($args) >= 1)
		{
			if (is_numeric($args[0]))
			{
				$city = Shadowrun4::getCityByID($args[0]);
			}
			else
			{
				$city = Shadowrun4::getCityByAbbrev($args[0]);
			}
		}
		else
		{
			$city = $party->getCityClass();
		}
		
		if ($city === false)
		{
			return $player->message('Error: Cannot get city class for your party!');
		}
		
		$cityname = $city->getName();
		return $player->msg('5007', array($cityname, Shadowfunc::getKnownPlaces($player, $cityname)));
// 		$bot->reply(sprintf('Known Places in %s: %s.', $cityname, Shadowfunc::getKnownPlaces($player, $cityname)));
		return true;
	}
}
?>
