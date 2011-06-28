<?php
abstract class SR_Ammo extends SR_Item
{
	public function getItemDropChance() { return 100.00; }
	public function isItemSellable() { return false; }
}
?>