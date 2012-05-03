<?php
final class Shadowcmd_debug extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'debug'));
			return true;
		}
		
		$total_amt = 0;
		foreach ($player->getAllItems() as $item)
		{
			$item instanceof SR_Item;
			$total_amt += $item->getAmount();
			printf("%99s: %20s %10s\n", $item->getItemName(), $item->getAmount().'x'.$item->getItemWeight(), $item->getItemWeightStacked());
		}
		printf("%99s: %20s %10s\n", 'Total weight according to stats', $total_amt.' items', $player->get('weight'));
	}
}
?>
