<?php
final class Item_Present extends SR_Item
{
	public function getItemDescription() { return 'A special present for you. it is wrapped in colorful paper and stuff. Here you are!'; }
	public function getItemWeight() { return 1000; }
	public function getItemPrice() { return 9.95; }
// 	public function getItemLevel() { return -1; }	
//	public function isItemDropable() { return true; }
//	public function isItemSellable() { return true; }
// 	public function isItemTradeable() { return false; }
	
	public function onItemUse(SR_Player $player, array $args)
	{
		$player->message(sprintf('You open your present ... '));
		$this->deleteItem($player);
		
		$items = array();
		
		while (count($items) === 0)
		{
			$items = Shadowfunc::randLoot($player, 99999);
		}
		
		$player->giveItems($items, 'present');
		return true;
	}
}
?>