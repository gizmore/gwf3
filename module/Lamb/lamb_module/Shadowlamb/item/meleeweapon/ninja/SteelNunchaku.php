<?php
final class Item_SteelNunchaku extends SR_NinjaWeapon
{
	public function getAttackTime() { return 35; }
	public function getItemLevel() { return 10; }
	public function getItemWeight() { return 1250; }
	public function getItemPrice() { return 1200; }
	public function getItemDescription() { return 'A steel nunchaku. Better than the wooden ones.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 8.2,
			'min_dmg' => 2.5,
			'max_dmg' => 9.0,
		);
	}
}
?>