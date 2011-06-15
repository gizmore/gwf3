<?php
final class Shadowcmd_explore extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false !== ($error = self::checkLeader($player))) {
			$bot->reply($error);
			return false;
		}
		
		$party = $player->getParty();
		if (false !== ($error = self::checkMove($party))) {
			$bot->reply($error);
			return false;
		}
		
		if ($party->getAction() === SR_Party::ACTION_EXPLORE) {
			$bot->reply(sprintf('You are already exploring %s.', $party->getCity()));
			return false;
		}
		
		$city = $party->getCityClass();
		$cityname = $city->getName();
		$eta = $city->getExploreETA($party);
		$party->pushAction('explore', $cityname, $eta);
		$party->setContactEta(rand(10,20));
		$party->notice(sprintf('You start to explore %s. ETA: %s', $cityname, GWF_Time::humanDuration($eta)));
		return true;
	}
}
?>
