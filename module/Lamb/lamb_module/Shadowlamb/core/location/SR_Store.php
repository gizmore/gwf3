<?php
abstract class SR_Store extends SR_Location
{
	public function getCommands(SR_Player $player) { return array('view','buy','sell'); }
	public function getHelpText(SR_Player $player) { $c = Shadowrun4::SR_SHORTCUT; return "In shops you can use {$c}view, {$c}buy and {$c}sell."; }
	
	/**
	 * Get the items available at the store.
	 * @param SR_Player $player
	 * @return array(array(name, availperc, price, amount))
	 */
	public abstract function getStoreItems(SR_Player $player);
	
	/**
	 * Filter Store Items through availability.
	 * @param SR_Player $player
	 */
	public function getStoreItemsB(SR_Player $player)
	{
		$key = $this->getStoreItemsKey();
		if ($player->hasTemp($key)) {
			return $player->getTemp($key);
		}
		
		$rep = Common::clamp($player->get('reputation'), 0, 25) * 0.5;
		$items = $this->getStoreItems($player);
		$back = array();
		$unique = false;
		foreach ($items as $i => $data)
		{
			$avail = isset($data[1]) ? $data[1] : 100.0;
			$avail += $rep;
			if (Shadowfunc::dicePercent($avail))
			{
				$back[] = $data;
			}
			else
			{
				$unique = true;
			}
		}
		
		if ($unique === true)
		{
			$player->setTemp($key, $back);
		}
		
		return $back;
	}
	
	public function getStoreItemsKey()
	{
		return sprintf('%s_ITEMS', $this->getName());
	}
	
	public function onEnter(SR_Player $player)
	{
		$p = $player->getParty();
		$key = $this->getStoreItemsKey();
		foreach ($p->getMembers() as $m)
		{
			$m->unsetTemp($key);
		}
		parent::onEnter($player);
	}

	public function calcSellPrice(SR_Player $player, SR_Item $item)
	{
		$price = $item->getItemPrice() * 0.10;
		return Shadowfunc::calcSellPrice($price, $player);
	}
	
	public function getStoreItem(SR_Player $player, $itemname)
	{
		$items = $this->getStoreItemsB($player);
		$data = false;
		if (is_numeric($itemname))
		{
			$id = (int)$itemname;
			if ($id < 1 || $id > count($items)) {
				return false;
			}
			$data = $items[$id-1];
		}
		else
		{
			$itemname = strtolower($itemname);
			foreach ($items as $d)
			{
				if (strtolower($d[0]) === $itemname)
				{
					$data = $d;
					break;
				}
			}
		}
		if ($data === false) {
			return false;
		}

		return $this->createItemFromData($player, $data);
	}
	
	private function createItemFromData(SR_Player $player, array $data)
	{
		$avail = isset($data[1]) ? $data[1] : 100.0;
		$amount = isset($data[3]) ? $data[3] : true;
		if (false === ($item = SR_Item::createByName($data[0], $amount, false))) {
			return false;
		}
		$price = isset($data[2]) ? $data[2] : $item->getItemPrice();
		$price = Shadowfunc::calcBuyPrice($price, $player);
		$item->setStorePrice($price);
		return $item;
	}
	
	############
	### View ###
	############
	public function on_view(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) === 0) {
			$bot->reply($this->onViewItems($player));
		}
		elseif (count($args) === 1) {
			$bot->reply($this->onViewItem($player, $args[0]));
		}
		else {
			$bot->reply(Shadowhelp::getHelp($player, 'view'));
		}
	}
	
	private function onViewItem(SR_Player $player, $itemname)
	{
		if (false === ($item = $this->getStoreItem($player, $itemname))) {
			return 'We don`t have that item.';
		}
		return $item->getItemInfo($player);
	}
	
	private function onViewItems(SR_Player $player)
	{
		$player->setOption(SR_Player::RESPONSE_ITEMS);
		
		$back = '';
		$items = $this->getStoreItemsB($player);
		
		if (count($items) === 0) {
			return 'There are no items here.';
		}
		$i = 1;
		foreach ($items as $data)
		{
			if (false === ($item = $this->createItemFromData($player, $data))) {
				continue;
			}
			$back .= sprintf(', %d-%s(%s)', $i++, $item->getItemName(), Shadowfunc::displayPrice($item->getStorePrice()));
		}
		return substr($back, 2);
	}
	
	###########
	### Buy ###
	###########
	public function on_buy(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'buy'));
			return false;
		}
		if (false === ($item = $this->getStoreItem($player, $args[0])))
		{
			$bot->reply('We don`t have that item.');
			return false;
		}
		
		$price = $item->getStorePrice();
		if (false === ($player->pay($price)))
		{
			$bot->reply(sprintf('You can not afford %s. You need %s but only have %s.', $item->getItemName(), Shadowfunc::displayPrice($price), Shadowfunc::displayPrice($player->getBase('nuyen'))));
			return false;
		}
		
		if (false === $item->insert())
		{
			$bot->reply('Database error 5.');
			return false;
		}
		
		$bot->reply(sprintf('You paid %s and bought %s.', Shadowfunc::displayPrice($price), $item->getItemName()));
		$player->giveItems(array($item));
		$player->modify();
		return true;
	}
	
	############
	### Sell ###
	############
	public function on_sell(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$bot->reply(Shadowhelp::getHelp($player, 'sell'));
			return false;
		}
		if (false === ($item = $player->getInvItem($args[0]))) {
			$bot->reply('You don`t have that item in your inventory.');
			return false;
		}
		if (!$item->isItemSellable()) {
			$bot->reply('I don`t want your '.$item->getItemName().'.');
			return false;
		}

		# Sell it
		if ($item->isEquipped($player))
		{
			$player->unequip($item);
		}
		
		$price = $this->calcSellPrice($player, $item);
		
		if (false === $item->useAmount($player, 1)) {
			$bot->reply('Database error in SR_Store::on_sell()');
			return false;
		}

		$player->giveNuyen($price);
				
		$bot->reply(sprintf('You sold your %s for %s.', $item->getItemName(), Shadowfunc::displayPrice($price)));
		return true;
	}
	
}
?>