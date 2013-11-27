<?php
final class Item_HanBo extends SR_NinjaWeapon
{
	public function getAttackTime() { return 40; }
	public function getItemLevel() { return 1; }
	public function getItemWeight() { return 1050; }
	public function getItemPrice() { return 215; }
	public function getItemRange() { return 1.5; }
	public function getItemDescription() { return 'A simple staff around 1.0m in length with a nice grip and slightly aerodynamic design.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 5.0,
			'min_dmg' => 1.5,
			'max_dmg' => 5.5,
		);
	}
}
?>