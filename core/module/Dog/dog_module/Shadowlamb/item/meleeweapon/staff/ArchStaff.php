<?php
final class Item_ArchStaff extends SR_MagicWeapon
{
	public function getAttackTime() { return 40; }
	public function getItemRange() { return 9; }
	public function getItemLevel() { return 12; }
	public function getItemWeight() { return 950; }
	public function getItemPrice() { return 425; }
	public function getItemDescription() { return 'A dark brown staff made from the evil archelves. It requires arcane powers to use it properly.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 8.0, 
			'min_dmg' => 1.0,
			'max_dmg' => 3.0,
			'max_mp' => 4.0,
			'intelligence' => 2.2,
		);
	}
}
?>