<?php
final class Item_EE_Rune extends SR_Rune
{
	public function getItemLevel() { return 40; }
	public function getItemDropChance() { return 3.12; }
	public function getItemPrice() { return 1600; }
	public function getItemDescription() { return 'A rune made by the shamanes of Amerindian.'; }
	public function getItemWeight() { return 250; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array('strength'=>2);
	}
}
?>