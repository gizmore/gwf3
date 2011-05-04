<?php
abstract class SR_SecondHandStore extends SR_Store
{
	public function getStoreSettingsName() { return 'SR_SHS_'.$this->getName(); }
	public function getStoreSettings() { return GWF_Settings::getSetting($this->getStoreSettingsName(), NULL); }
	
	private function saveStoreSettings(array $data)
	{
		if (count($data) === 0) {
			$s = NULL;
		} else {
			$s = serialize($data);
		}
		return GWF_Settings::setSetting($this->getStoreSettingsName(), $s);
	}
	
	public function getStoreItems(SR_Player $player)
	{
		if (NULL === ($settings = $this->getStoreSettings())) {
			$settings = array();
		} else {
			$settings = unserialize($settings);
		}
		return $settings;
	}
	
	public function addSecondHandItem(SR_Player $player, SR_Item $item, $price)
	{
		$items = $this->getStoreItems($player);
		$items[] = array($item->getItemName(), round($price*11.5, 2));
		return $this->saveStoreSettings($items);
	}
	
	public function calcSellPrice(SR_Player $player, SR_Item $item)
	{
		$price = $item->getItemPriceStatted() * 0.08;
		return Shadowfunc::calcSellPrice($price, $player);
	}
	
	
	public function on_sell(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'sell'));
			return false;
		}
		if (false === ($item = $player->getItem($args[0]))) {
			$bot->reply('You don`t have that item.');
			return false;
		}
		if (!$item->isItemSellable()) {
			$bot->reply('I don`t want your '.$item->getItemName().'.');
			return false;
		}

		$price = $this->calcSellPrice($player, $item);
		
		# Sell it
		if ($item->isEquipped($player)) {
			$player->unequip($item);
		}
		$player->removeFromInventory($item);
		if ($item->isItemStatted())
		{
			$statmsg = ' The salesman smiles and put`s the item in the shop window.';
			$this->addSecondHandItem($player, $item, $price);
		}
		else
		{
			$statmsg = ' The salesman put`s the item into the storage room.';
		}
		$item->delete();

		$player->giveNuyen($price);
				
		$bot->reply(sprintf('You sold your %s for %s.%s', $item->getItemName(), Shadowfunc::displayPrice($price), $statmsg));
		return true;
	}
}
?>