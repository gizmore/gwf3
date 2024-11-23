<?php
final class Shadowcmd_use extends Shadowcmd
{
	public static function isCombatCommand() { return true; }
	
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) < 1)
		{
			$player->message(Shadowhelp::getHelp($player, 'use'));
			return false;
		}
		
		$itemname = array_shift($args);
		if (false === ($item = $player->getItem($itemname)))
		{
			$player->msg('1029');
// 			self::rply($player, '1029');
// 			self::reply($player, "You don't have this item.");
			return false;
		}
		
		return $item->onItemUse($player, $args);
	}
}
?>
