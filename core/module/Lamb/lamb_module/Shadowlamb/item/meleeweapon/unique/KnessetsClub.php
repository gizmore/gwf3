<?php
final class Item_KnessetsClub extends SR_MeleeWeapon
{
	public function getAttackTime() { return 35; }
	public function getItemDropChance() { return 2.5; }
	public function getItemLevel() { return 0; }
	public function getItemWeight() { return 950; }
	public function getItemPrice() { return 95; }
	public function getItemRange() { return 1.2; }
	public function getItemDescription() { return 'A nicely made wooden club. Seems a bit more heavy than the usual clubs.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 4.5,
			'min_dmg' => 0.5,
			'max_dmg' => 7.5,
			'melee' => 1.0,
		);
	}
}
?>
