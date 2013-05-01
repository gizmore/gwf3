<?php
final class Item_Flail extends SR_MeleeWeapon
{
	public function getAttackTime() { return 60; }
	public function getItemLevel() { return 26; }
	public function getItemWeight() { return 3800; }
	public function getItemPrice() { return 750; }
	public function getItemRange() { return 1.9; }
	public function getItemDescription() { return 'A bashing weapon with a chain and a spiked metal ball at it`s end. A bit difficult to handle but can do serious damage.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 16.5,
			'min_dmg' => 1.0,
			'max_dmg' => 19.0,
		);
	}
	
}
?>
