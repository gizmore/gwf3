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
		$player->message(sprintf('The scroll reads:  `Congrats! Enter "%s" without the quotes`.', $this->getSolution($player)));
		$player->message(sprintf('The scroll puffs into magic challenging dust.'));
		return true;
	}
	
	public function getSolution(SR_Player $player)
	{
		$pname = strtolower($player->getName());
		$hash = substr(md5(md5($pname).LAMB_PASSWORD2), 2, 16);
		return sprintf('%s!%s!wisdom', $pname, $hash);
	}
}
?>