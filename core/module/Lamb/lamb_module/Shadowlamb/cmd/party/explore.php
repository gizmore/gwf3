<?php
final class Shadowcmd_explore extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (false === self::checkLeader($player))
		{
			return false;
		}
		
		$party = $player->getParty();
		if (false === self::checkMove($party))
		{
			return false;
		}
		
		if ($party->getAction() === SR_Party::ACTION_EXPLORE)
		{
			self::rply($player, '1068', array($party->getCity(), $party->displayETA()));
// 			$bot->reply(sprintf('You are already exploring %s. ETA: %s.', $party->getCity(), $party->displayETA()));
			return false;
		}
		
		$city = $party->getCityClass();
		$cityname = $city->getName();
		$eta = $city->getExploreETA($party);
		$party->pushAction('explore', $cityname, $eta);
		$party->setContactEta(rand(10,20));
		$party->ntice('5126', array($cityname, GWF_Time::humanDuration($eta)));
// 		$party->notice(sprintf('You start to explore %s. ETA: %s', $cityname, GWF_Time::humanDuration($eta)));
		return true;
	}
}
?>
