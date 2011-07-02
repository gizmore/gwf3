<?php
final class Item_BaseballBat extends SR_MeleeWeapon
{
	public function getAttackTime() { return 30; }
	public function getItemLevel() { return 0; }
	public function getItemWeight() { return 750; }
	public function getItemPrice() { return 120; }
	public function getItemRange() { return 1.5; }
	public function getItemDescription() { return 'A cheap baseball bat made of aluminium. Has other usage than baseball.'; }
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack' => 5.5,
			'min_dmg' => 1.0,
			'max_dmg' => 5.0,
		);
	}
}
?>