<?php
final class Item_ElvenSabre extends SR_MeleeWeapon
{
	public function getAttackTime() { return 35; }
	public function getItemLevel() { return 12; }
	public function getItemWeight() { return 720; }
	public function getItemPrice() { return 3700; }
	public function getItemDescription() { return 'A slim elven sabre. It is not robust but does good damage.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 6.5, 
			'min_dmg' => 3.5,
			'max_dmg' => 11.5,
		);
	}
}
?>