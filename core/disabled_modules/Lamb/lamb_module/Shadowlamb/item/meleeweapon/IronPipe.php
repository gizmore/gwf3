<?php
final class Item_IronPipe extends SR_MeleeWeapon
{
	public function getAttackTime() { return 40; }
	public function getItemLevel() { return 1; }
	public function getItemPrice() { return 80.00; }
	public function getItemWeight() { return 1250; }
	public function getItemDescription() { return 'A heavy iron pipe. Good to break bones.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 6.0, 
			'min_dmg' => 0.0,
			'max_dmg' => 7.0
		);
	}
	
}
?>