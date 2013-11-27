<?php
final class Item_MorningStar extends SR_MeleeWeapon
{
	public function getAttackTime() { return 55; }
	public function getItemLevel() { return 25; }
	public function getItemWeight() { return 3500; }
	public function getItemPrice() { return 650; }
	public function getItemRange() { return 1.8; }
	public function getItemDescription() { return 'A long wooden bashing weapon with a spiked metal end. Quite heavy but can do serious damage.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 16.0,
			'min_dmg' => 2.0,
			'max_dmg' => 18.0,
		);
	}
}
?>
