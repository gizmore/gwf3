<?php
final class Shadowcmd_enter extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$party = $player->getParty();
		
		if (false === ($location = $party->getLocationClass(SR_Party::ACTION_OUTSIDE)))
		{
			self::rply($player, '1031'); # You are not outside of a location.
			return false;
		}
		
		if (!$player->isLeader())
		{
			self::rply($player, '1032'); # Only the leader of a party can enter locations.
			return false;
		}
		
		return $location->onEnter($player);
	}
}
?>
