<?php
final class Item_SourMilk extends SR_Usable
{
	public function getItemLevel() { return -1; }
	public function getItemWeight() { return 520; }
	public function getItemPrice() { return 0.55; }
	public function getLitres() { return 500; }
	public function getItemDescription() { return 'A half litre of sour milk.'; }

	public function onItemUse(SR_Player $player, array $args)
	{
		$player->message('You open the milk and put it at your mouth ... but you have to gag immediately.');
		return false;
	}
}
?>
