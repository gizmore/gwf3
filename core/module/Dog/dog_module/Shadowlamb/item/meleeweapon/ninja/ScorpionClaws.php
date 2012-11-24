<?php
final class Item_ScorpionClaws extends SR_NinjaWeapon
{
	public function getAttackTime() { return 50; }
	public function getItemRange() { return 2.2; }
	public function getItemWeight() { return 0; }
	public function getItemDescription() { return 'Giant claws of a giant scorpion. Although not their main weapon they can cause serious harm.'; }
	
	public function isItemLootable() { return false; }
	public function isItemDropable() { return false; }
	public function isItemSellable() { return false; }
	public function isItemTradeable() { return false; }
	public function isItemStattable() { return false; }
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack'  => 12.0,
			'min_dmg' => 4.0,
			'max_dmg' => 16.0,
		);
	}
	
}
?>
