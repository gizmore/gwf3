<?php
final class Shadowcmd_use extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		if (count($args) < 1)
		{
			self::reply($player, Shadowhelp::getHelp($player, 'use'));
			return false;
		}
		
		$itemname = array_shift($args);
		if (false === ($item = $player->getItem($itemname)))
		{
			self::reply($player, "You don't have this item.");
			return false;
		}
		
		return $item->onItemUse($player, $args);
	}
}
?>
