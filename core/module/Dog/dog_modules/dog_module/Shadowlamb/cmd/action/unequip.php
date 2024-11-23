<?php
final class Shadowcmd_unequip extends Shadowcmd
{
	public static function isCombatCommand() { return true; }
	
	public static function execute(SR_Player $player, array $args)
	{
// 		$bot = Shadowrap::instance($player);
		if (count($args) !== 1)
		{
			$player->message(Shadowhelp::getHelp($player, 'unequip'));
			return false;
		}

// 		if ($player->isFighting() && $player->isLocked())
// 		{
// 			$player->message('You cannot change your equipment in combat when it\'s locked.');
// 			return false;
// 		}
		
		if (false === ($item = $player->getItem($args[0])))
		{
			$player->msg('1029');
// 			$player->message(sprintf('You don`t have that item.'));
			return false;
		}
		
		if ( (!$item->isEquipped($player)) || ($item instanceof SR_Piercing) )
		{
			$player->msg('1067', array($player->lang($item->getItemType())));
// 			$player->message(sprintf('You don`t have a %s equipped.', $item->getItemName()));
			return false;
		}
		
		$item->onItemUnequip($player);
		$player->modify();
		$player->healHP(0);
		$player->healMP(0);
		return true;
	}
}
?>
