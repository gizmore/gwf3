<?php
final class Item_Fists extends SR_NinjaWeapon
{
	public static function staticFists() { return self::instance('Fists'); }
	
	public function getAttackTime() { return 35; }
	public function getItemRange() { return 1.0; }
	public function getItemWeight() { return 0; }
	public function getItemDescription() { return 'Your fists. You got two of them.'; }
	
	public function isItemLootable() { return false; }
	public function isItemDropable() { return false; }
	public function isItemSellable() { return false; }
	public function isItemTradeable() { return false; }
	public function isItemStattable() { return false; }
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack'  => 3.5,
			'min_dmg' => 0.0,
			'max_dmg' => 3.0,
		);
	}
}
?>
