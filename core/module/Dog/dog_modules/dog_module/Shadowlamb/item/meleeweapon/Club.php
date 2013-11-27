<?php
final class Item_Club extends SR_MeleeWeapon
{
	public function getAttackTime() { return 40; }
	public function getItemLevel() { return 0; }
	public function getItemWeight() { return 750; }
	public function getItemPrice() { return 70; }
	public function getItemRange() { return 1.2; }
	public function getItemDescription() { return 'A wooden club. You wonder if the humanity does evolute at all.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 4.2,
			'min_dmg' => 0.0,
			'max_dmg' => 6.5,
		);
	}
	
}
?>