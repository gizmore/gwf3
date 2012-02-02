<?php
final class Shadowcmd_exit extends Shadowcmd
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
		
		$party->pushAction(SR_Party::ACTION_OUTSIDE);
		return $party->ntice('5020', array($party->getLocation()));
		
// 		$party->notice(sprintf('You exit the %s.', $party->getLocation()));
// 		return true;
	}
}
?>
