<?php
abstract class SR_Ammo extends SR_Item
{
	public function displayType() { return 'Ammo'; }
	public function getItemDropChance() { return 100.00; }
	public function isItemSellable() { return true; }
}
?>