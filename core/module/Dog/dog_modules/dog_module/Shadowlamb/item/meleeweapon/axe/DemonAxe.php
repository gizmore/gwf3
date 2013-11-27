<?php
final class Item_DemonAxe extends SR_Axe
{
	public function getAttackTime() { return 52; }
	public function getItemLevel() { return 28; }
	public function getItemWeight() { return 2150; }
	public function getItemPrice() { return 975; }
	public function getItemRange() { return 2.9; }
	public function getItemDescription() { return 'A two sided large and heavy battle axe. It glows dark and is bloody sharp.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 11.0, 
			'min_dmg' => 4.5,
			'max_dmg' => 19.0,
		);
	}
}
?>