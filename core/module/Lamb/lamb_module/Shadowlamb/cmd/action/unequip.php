<?php
final class Shadowcmd_unequip extends Shadowcmd
{
	public static function isCombatCommand() { return true; }
	
	public static function execute(SR_Player $player, array $args)
	{
// 		$bot = Shadowrap::instance($player);
		if (count($args) !== 1)
		{
			self::reply($player, Shadowhelp::getHelp($player, 'unequip'));
			return false;
		}

// 		if ($player->isFighting() && $player->isLocked())
// 		{
// 			$player->message('You cannot change your equipment in combat when it\'s locked.');
// 			return false;
// 		}
		
		if (false === ($item = $player->getItem($args[0])))
		{
			self::rply($player, '1029');
// 			$player->message(sprintf('You don`t have that item.'));
			return false;
		}
		
		if (false === $item->isEquipped($player))
		{
			self::rply($player, '1067', array($item->getItemName()));
// 			$player->message(sprintf('You don`t have a %s equipped.', $item->getItemName()));
			return false;
		}
		
		$item->onItemUnequip($player);
		$player->modify();
		return true;
	}
}
?>
