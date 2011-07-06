<?php
final class Item_SportBow extends SR_Bow
{
	public function getAttackTime() { return 50; }
	public function getAmmoName() { return 'Ammo_Arrow'; }
	public function getBulletsMax() { return 1; }
	public function getItemLevel() { return 5; }
	public function getItemWeight() { return 950; }
	public function getItemPrice() { return 250; }
	public function getItemDescription() { return 'A sporting bow. Can do some damage too.'; }
	
	public function getItemRequirements() { return array(); }
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 4,
			'min_dmg' => 1,
			'max_dmg' => 5,
		);
	}
}
?>