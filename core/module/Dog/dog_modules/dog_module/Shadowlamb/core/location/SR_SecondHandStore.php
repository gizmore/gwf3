<?php
abstract class SR_SecondHandStore extends SR_Store
{
	public function getAbstractClassName() { return __CLASS__; }
	
	public function allowShopSellAll(SR_Player $player) { return false; }
	public function getMaxItems() { return 23; }
	public function getStoreSettingsName() { return 'SR_SHS_'.$this->getName(); }
	public function getStoreSettings() { return GWF_Settings::getSetting($this->getStoreSettingsName(), NULL); }
// 	public function getHelpText(SR_Player $player) { return 'You can sell statted items to higher prices here. The statted items that get sold here will stay in the shop.'; }
	public function getHelpText(SR_Player $player) { return $player->lang('hlp_second_hand'); }
	
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
	
	public function calcSellPrice(SR_Player $player, SR_Item $item, $amt=1)
	{
		$price = $item->getItemPriceStatted() * 0.09 * $amt;
		return Shadowfunc::calcSellPrice($price, $player);
	}
	
	public function on_buy(SR_Player $player, array $args, $max_amt=false, $confirm=true)
	{
		if (false === parent::on_buy($player, $args, 1, true))
		{
			return false;
		}
		return $this->removeSecondHandItem($player, $this->getSecondsHandArgID($player));
	}
	
	private function getSecondsHandArgID(SR_Player $player)
	{
		$itemname = $this->getLastPurchasedItemName();
		return $this->_getSecondsHandArgID($player, $itemname);
	}
	
	private function _getSecondsHandArgID(SR_Player $player, $itemname)
	{
		$items = $this->getStoreItems($player);
		foreach ($items as $id => $data)
		{
			if (!strcmp($data[0], $itemname))
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
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'secondhand_sell'));
			return false;
		}
		if (false === ($item = $player->getInvItem($args[0])))
		{
			$bot->rply('1029');
// 			$bot->reply('You don`t have that item.');
			return false;
		}
		if ( (!$item->isItemSellable()) || (!$item instanceof SR_Equipment) )
		{
			$bot->rply('1151', array($item->getItemName()));
// 			$bot->reply('I don`t want your '.$item->getItemName().'. We only trade equipment here.');
			return false;
		}

		$price = $this->calcSellPrice($player, $item);
		
		# Sell it
		if ($item->isEquipped($player))
		{
			$player->unequip($item);
		}
		$player->removeFromInventory($item);
		if ($item->isItemStatted())
		{
			$player->msg('5198', array($item->displayFullName($player)));
// 			$statmsg = 'The salesman smiles and puts the item in the shop window.';
			$this->addSecondHandItem($player, $item, $price);
		}
// 		else
// 		{
// 			$statmsg = ' The salesman puts the item into the storage room.';
// 		}
		$item->delete();

		$player->giveNuyen($price);

		$dprice = Shadowfunc::displayNuyen($price);
		return $bot->rply('5191', array('1', $item->displayFullName($player), $dprice, $player->displayWeight(), $player->displayMaxWeight()));
// 		$bot->reply(sprintf('You sold your %s for %s.%s', $item->getItemName(), Shadowfunc::displayNuyen($price), $statmsg));
// 		return true;
	}
	
	protected function onStealSuccess(SR_Player $player, $itemname)
	{
		if (parent::onStealSuccess($player, $itemname))
		{
			$id = $this->_getSecondsHandArgID($player, $itemname);
			$this->removeSecondHandItem($player, $id);
			return true;
		}
		return false;
	}
}
