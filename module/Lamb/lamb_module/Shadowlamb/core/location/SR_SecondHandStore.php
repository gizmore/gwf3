<?php
abstract class SR_SecondHandStore extends SR_Store
{
	public function getMaxItems() { return 23; }
	public function getStoreSettingsName() { return 'SR_SHS_'.$this->getName(); }
	public function getStoreSettings() { return GWF_Settings::getSetting($this->getStoreSettingsName(), NULL); }
	
	private function saveStoreSettings(array $data)
	{
		if (count($data) === 0) {
			$s = NULL;
		} else {
			$data = array_values($data);
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
		$items[] = array($item->getItemName(), 100.0, round($price*11.5, 2));
		
//		shuffle($items);
		
		$max = $this->getMaxItems();
		$num = count($items);
		if ($num > $max) {
			$items = array_slice($items, $num-$max, $max);
		}
		
		return $this->saveStoreSettings($items);
	}
	
	public function calcSellPrice(SR_Player $player, SR_Item $item)
	{
		$price = $item->getItemPriceStatted() * 0.08;
		return Shadowfunc::calcSellPrice($price, $player);
	}
	
	public function on_buy(SR_Player $player, array $args)
	{
		if (false === ($id = $this->getSecondsHandArgID($player, $args[0]))) {
			Shadowrap::instance($player)->reply('The item could not been found in the second hand store.');
			return false;
		}
		
		if (false === parent::on_buy($player, $args)) {
			return false;
		}
		
		$this->removeSecondHandItem($player, $id);
		
		return true;
	}
	
	public function getSecondsHandArgID(SR_Player $player, $arg)
	{
		$items = $this->getStoreItems($player);
		if (is_numeric($arg)) {
			return ($arg < 1 || $arg > count($items)) ? false : $arg;
		}
		
		foreach ($items as $id => $data)
		{
			if (!strcasecmp($data[0], $arg))
			{
				return $id+1;
			}
		}
		
		return false;
		
	}
	
	public function removeSecondHandItem(SR_Player $player, $id)
	{
		$items = $this->getStoreItems($player);
		unset($items[$id-1]);
		return $this->saveStoreSettings($items);
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
		if (!$item->isItemSellable() || $item->isItemStackable()) {
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