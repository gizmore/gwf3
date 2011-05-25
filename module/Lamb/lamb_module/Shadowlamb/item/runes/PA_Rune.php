<?php
final class Item_PA_Rune extends SR_Rune
{
	public function getItemLevel() { return 50; }
	public function getItemDropChance() { return 1.56; }
	public function getItemPrice() { return 3200; }
	public function getItemDescription() { return 'A rare PA rune from the dark side of magic.'; }
	public function getItemWeight() { return 250; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array('min_dmg'=>2,'max_dmg'=>4);
	}
}
?>