<?php
final class Item_SmithHammer extends SR_QuestItem
{
	public function getItemLevel() { return 5; }
//	public function getAttackTime() { return 50; }
	public function getItemDescription() { return 'A high quality hammer to punch steel. Not a weapon.'; }
	public function getItemWeight() { return 5000; }
	public function getItemPrice() { return 99.95; }
	public function isItemSellable() { return true; }
	public function isItemDropable() { return true; }
	public function isItemTradeable() { return true; }
//	public function getItemModifiersA(SR_Player $player)
//	{
//		return array(
//			'attack' => 0.5,
//			'min_dmg' => 2.0,
//			'max_dmg' => 5.0,
//		);
//	}
}
?>