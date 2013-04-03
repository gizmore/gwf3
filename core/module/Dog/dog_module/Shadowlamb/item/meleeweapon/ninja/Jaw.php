<?php
final class Item_Jaw extends SR_NinjaWeapon
{
	public function getAttackTime() { return 42; }
	public function getItemRange() { return 1.2; }
	public function getItemWeight() { return 0; }
	public function getItemDescription() { return 'Spikey Jaw that bites you.'; }
	
	public function isItemLootable() { return false; }
	public function isItemDropable() { return false; }
	public function isItemSellable() { return false; }
	public function isItemTradeable() { return false; }
	public function isItemStattable() { return false; }
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack'  => 8.0,
			'min_dmg' => 2.0,
			'max_dmg' => 14.0,
		);
	}
}
?>
