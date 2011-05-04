<?php
final class Item_UM_Rune extends SR_Rune
{
	public function getItemLevel() { return 8; }
	public function getItemDropChance() { return 18.00; }
	public function getItemPrice() { return 1200; }
	public function getItemDescription() { return 'A rune made by the smiths of Ugah.'; }
	public function getItemWeight() { return 250; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array('strength'=>0.3);
	}
}
?>