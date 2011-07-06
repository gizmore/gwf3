<?php
final class Item_LO_Rune extends SR_Rune
{
	public function getItemLevel() { return 10; }
	public function getItemDropChance() { return 25.00; }
	public function getItemPrice() { return 200; }
	public function getItemDescription() { return 'A rune from the caves of Ugah.'; }
	public function getItemWeight() { return 250; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array('attack'=>0.2);
	}
}
?>