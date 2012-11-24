<?php
final class Item_SpikedClub extends SR_MeleeWeapon
{
	public function getAttackTime() { return 40; }
	public function getItemLevel() { return 21; }
	public function getItemWeight() { return 750; }
	public function getItemPrice() { return 150; }
	public function getItemRange() { return 1.2; }
	public function getItemDescription() { return 'A spiked, wooden club. It seems at least the clubs evoluted.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 8.0,
			'min_dmg' => 3.0,
			'max_dmg' => 12.0,
		);
	}
	
}
?>