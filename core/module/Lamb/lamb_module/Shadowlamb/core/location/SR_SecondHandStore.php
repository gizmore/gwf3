<?php
abstract class SR_SecondHandStore extends SR_Store
{
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
	
	public function on_buy(SR_Player $player, array $args, $max_amt=false)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) === 0)
		{
			$player->message(Shadowhelp::getHelp($player, 'buy'));
			return false;
		}
		if (is_numeric($args[0]))
		{
			$bot->rply('1150');
// 			$bot->reply("Purchasing items by ID is disabled in second hand store, because of possible race conditions.");
			return false;
		}
		
		if (false === ($id = $this->getSecondsHandArgID($player, $args[0])))
		{
			$bot->rply('1108');
// 			$bot->reply('The item could not been found in the second hand store.');
			return false;
		}
		
		if (false === parent::on_buy($player, $args, 1)) {
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
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'sell'));
			return false;
		}
		if (false === ($item = $player->getInvItem($args[0])))
		{
			$bot->rply('1029');
// 			$bot->reply('You don`t have that item.');
			return false;
		}
		if (!$item->isItemSellable() || $item->isItemStackable())
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
			$player->msg('5198');
// 			$statmsg = ' The salesman smiles and puts the item in the shop window.';
			$this->addSecondHandItem($player, $item, $price);
		}
// 		else
// 		{
// 			$statmsg = ' The salesman puts the item into the storage room.';
// 		}
		$item->delete();

		$player->giveNuyen($price);

		$dprice = Shadowfunc::displayNuyen($price);
		return $bot->rply('5191', array('1', $item->getItemName(), $dprice, $player->displayWeight(), $player->displayMaxWeight()));
// 		$bot->reply(sprintf('You sold your %s for %s.%s', $item->getItemName(), Shadowfunc::displayNuyen($price), $statmsg));
// 		return true;
	}
}
?>
