<?php
final class Item_ScrollOfWisdom extends SR_Item
{
	public function getItemDescription() { return 'A so called "Scroll of Wisdom". You suppose there is only garbage written on it.'; }
	public function getItemWeight() { return 250; }
	public function getItemPrice() { return 19.95; }
	public function getItemLevel() { return 8; }
	
//	public function isItemDropable() { return true; }
//	public function isItemSellable() { return true; }
	public function isItemTradeable() { return false; }
	
	public function onItemUse(SR_Player $player, array $args)
	{
		$this->deleteItem($player);
		$player->message(sprintf('The scroll reads: "Congrats! Enter %s_%s without the quotes".', $player->getName(), substr(md5(md5($player->getName().'scroll').'of'), 3, 8).'_wisdom'));
		$player->message(sprintf('The scroll puffs into magic challenging dust.'));
		return true;
	}
	
}
?>