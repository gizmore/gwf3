<?php
final class Shadowcmd_known_places extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$party = $player->getParty();
		$city = false;
		if (count($args) === 1) {
			$city = Shadowrun4::getCity($args[0]);
		}
		if ($city === false) {
			$city = $party->getCityClass();
		}
		$cityname = $city->getName();
		$bot->reply(sprintf('Known Places in %s: %s.', $cityname, Shadowfunc::getKnownPlaces($player, $cityname)));
		return true;
	}
}
?>
