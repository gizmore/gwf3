<?php
final class Item_ArchStaff extends SR_MeleeWeapon
{
	public function getAttackTime() { return 40; }
	public function getItemLevel() { return 12; }
	public function getItemWeight() { return 950; }
	public function getItemPrice() { return 425; }
	public function getItemDescription() { return 'A dark brown staff made from the evil archelves. It requires arcane powers to use it properly.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 0.5* $player->get('magic'),
			'min_dmg' => 0.5 * $player->get('magic'),
			'max_dmg' => 1.0 * $player->get('magic'),
			'max_mp' => 6.0,
			'intelligence' => 1.6,
		);
	}
}
?>