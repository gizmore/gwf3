<?php
final class Shadowcmd_party_loot extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) > 1)
		{
			self::reply($player, Shadowhelp::getHelp($player, 'party_loot'));
			return false;
		}
		
		$party = $player->getParty();

		# Show mode
		if (count($args) === 0)
		{
			$type = 'unknown';
			switch($party->getLootMode())
			{
				case SR_Party::LOOT_CYCLE: $type = 'cycle'; break;
				case SR_Party::LOOT_RAND: $type = 'random'; break;
				case SR_Party::LOOT_KILL: $type = 'killer'; break;
			}
			return self::reply($player, sprintf("Your party has set it's loot mode to: \X02%s\X02.", $type));
		}
		
		if (!$player->isLeader())
		{
			return self::reply($player, 'Only the leader can change the party loot settings.');
		}
		
		# Change mode
		switch ($args[0])
		{
			case 'rand': $bit = SR_Party::LOOT_RAND; break;
			case 'cycle': $bit = SR_Party::LOOT_CYCLE; break;
			case 'killer': $bit = SR_Party::LOOT_KILL; break;
			default:
				self::reply($player, 'The loot mode is invalid. '.Shadowhelp::getHelp($player, 'party_loot'));
				return false;
		}
		
		$party->setLootMode($bit);
		$party->notice(sprintf("The party's loot mode has been set to: \X02%s\X02.", $args[0]));
		return true;
	}
}
?>