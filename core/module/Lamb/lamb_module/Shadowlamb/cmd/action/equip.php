<?php
final class Shadowcmd_equip extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'equip'));
			return false;
		}

		if ($player->isFighting() && $player->isLocked())
		{
			$player->message('You cannot change your equipment in combat when it\'s locked.');
			return false;
		}
		
		$itemname = array_shift($args);
		if (false === ($item = $player->getItem($itemname)))
		{
			$player->message("You don't have that item.");
			return false;
		}
		
		return $item->onItemEquip($player);
	}
}
?>
