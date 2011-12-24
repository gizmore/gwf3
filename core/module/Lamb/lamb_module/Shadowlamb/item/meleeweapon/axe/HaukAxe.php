<?php
final class Item_HaukAxe extends SR_MeleeWeapon
{
	public function getAttackTime() { return 50; }
	public function getItemLevel() { return 6; }
	public function getItemWeight() { return 2500; }
	public function getItemPrice() { return 79.95; }
	public function getItemRange() { return 3.5; }
	public function getItemDescription() { return 'A big axe for woodcutting, produced by Hauk(tm), the leading woodaxe company.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 2.0, 
			'min_dmg' => 2.5,
			'max_dmg' => 12.0,
		);
	}
}
?>
