<?php
final class Item_Claws extends SR_NinjaWeapon
{
	public function getAttackTime() { return 45; }
	public function getItemRange() { return 1.4; }
	public function getItemWeight() { return 0; }
	public function getItemDescription() { return 'Animal claws. Can surely hurt you if you are not caucios.'; }
	
	public function isItemLootable() { return false; }
	public function isItemDropable() { return false; }
	public function isItemSellable() { return false; }
	public function isItemTradeable() { return false; }
	public function isItemStattable() { return false; }
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack'  => 6.0,
			'min_dmg' => 1.0,
			'max_dmg' => 12.0,
		);
	}
}
?>
