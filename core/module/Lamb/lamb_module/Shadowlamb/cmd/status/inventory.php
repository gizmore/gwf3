<?php
final class Shadowcmd_inventory extends Shadowcmd
{
	const IPP = 10;
	public static function execute(SR_Player $player, array $args)
	{
		$items = $player->getInventory();
		$text = array(
			'usage' => Shadowhelp::getHelp($player, 'i'),
			'prefix' => $player->lang('inventory'),
			'code' => '5005',
		);
		Shadowfunc::genericViewI($player, $items, $args, $text, false);
	}
}
?>
