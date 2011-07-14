<?php
final class Item_ElvenSabre extends SR_NinjaWeapon
{
	public function getAttackTime() { return 35; }
	public function getItemLevel() { return 12; }
	public function getItemWeight() { return 720; }
	public function getItemPrice() { return 1500; }
	public function getItemDescription() { return 'A slim elven sabre. It is not robust but does good damage.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 9.5, 
			'min_dmg' => 1.5,
			'max_dmg' => 9.5,
		);
	}
}
?>