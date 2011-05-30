<?php
final class Shadowcmd_inventory extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$bot->reply('Your inventory: '.Shadowfunc::getInventory($player));
		return true;
	}
}
?>
