<?php
final class Item_WoodNunchaku extends SR_NinjaWeapon
{
	public function getAttackTime() { return 30; }
	public function getItemLevel() { return 2; }
	public function getItemWeight() { return 650; }
	public function getItemPrice() { return 320; }
	public function getItemDescription() { return 'A wooden nunchaku. Ninjas like this kind of weapon.'; }
	public function getItemDropChance() { return 120; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 5.8,
			'min_dmg' => 2.5,
			'max_dmg' => 7.2,
		);
	}
}
?>