<?php
final class Item_Mon_Rune extends SR_Rune
{
	public function getItemLevel() { return 60; }
	public function getItemDropChance() { return 0.74; }
	public function getItemPrice() { return 6400; }
	public function getItemDescription() { return 'One of the mysterious runes made from the dungeon masters themself.'; }
	public function getItemWeight() { return 250; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array('essence'=>2.0);
	}
}
?>