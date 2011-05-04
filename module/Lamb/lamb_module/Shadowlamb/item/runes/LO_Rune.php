<?php
final class Item_LO_Rune extends SR_Rune
{
	public function getItemLevel() { return 5; }
	public function getItemDropChance() { return 20.00; }
	public function getItemPrice() { return 500; }
	public function getItemDescription() { return 'A rune from the caves of Ugah.'; }
	public function getItemWeight() { return 250; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array('max_weight'=>0.2);
	}
}
?>