<?php
final class Item_ArabianAxe extends SR_Axe
{
	public function getAttackTime() { return 55; }
	public function getItemLevel() { return 20; }
	public function getItemWeight() { return 1950; }
	public function getItemPrice() { return 375; }
	public function getItemRange() { return 2.5; }
	public function getItemDescription() { return 'More a club than an axe, still sharp, heavy and dangerous.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 9.5, 
			'min_dmg' => 1.5,
			'max_dmg' => 15.5,
		);
	}
}
?>
