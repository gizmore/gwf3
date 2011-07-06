<?php
final class Item_ButchersKnife extends SR_MeleeWeapon
{
	public function getAttackTime() { return 45; }
	public function getItemLevel() { return 7; }
	public function getItemWeight() { return 450; }
	public function getItemPrice() { return 350; }
	public function getItemDescription() { return 'A big butchers knife. Nice to cut dead meat with it, but not a fast weapon.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 2.5,
			'min_dmg' => 3.5,
			'max_dmg' => 9.0,
		);
	}
}
?>