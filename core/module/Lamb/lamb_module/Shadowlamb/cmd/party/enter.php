<?php
final class Shadowcmd_enter extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
// 		$bot = Shadowrap::instance($player);
		$party = $player->getParty();
		
		if (false === ($location = $party->getLocationClass('outside')))
		{
			self::rply($player, '1031');
// 			$bot->reply('You are not outside of a location.');
			return false;
		}
		
		if (!$player->isLeader())
		{
			self::rply($player, '1032');
// 			$bot->reply('Only the leader of a party can enter locations.');
			return false;
		}
		
		$location->onEnter($player);
		
		return true;
	}
}
?>
