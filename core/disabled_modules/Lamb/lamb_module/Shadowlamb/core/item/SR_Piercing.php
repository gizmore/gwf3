<?php
abstract class SR_Piercing extends SR_Equipment
{
	public function getItemType() { return 'piercing'; }
	public function displayType() { return 'Piercing'; }
	public function isItemStackable() { return false; }
	public function isItemStattable() { return false; }
	public function getItemLevel() { return -1; }
	public function isItemDropable() { return false; }
	public function isItemLootable() { return false; }
}
?>
