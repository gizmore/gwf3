<?php
final class Item_ON_Rune extends SR_Rune
{
	public function getItemLevel() { return 30; }
	public function getItemDropChance() { return 6.25; }
	public function getItemPrice() { return 800; }
	public function getItemDescription() { return 'A rune made by the council of wizards.'; }
	public function getItemWeight() { return 250; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array('body'=>2);
	}
}
?>