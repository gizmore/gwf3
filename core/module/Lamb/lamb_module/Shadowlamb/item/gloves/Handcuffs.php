<?php
final class Item_Handcuffs extends SR_Gloves
{
	public function isItemDropable() { return false; }
	public function getItemLevel() { return 0; }
	public function getItemPrice() { return 69; }
	public function getItemWeight() { return 260; }
	public function getItemDescription() { return 'Strong steel handcuffs. Probably produced by a subdivision of Ares and hard to crack.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => '-8.0',
			'defense' => '-2.0',
			'quickness' => '-2.0',
			'strength' => '-3.0',
		);
	}
}
?>
