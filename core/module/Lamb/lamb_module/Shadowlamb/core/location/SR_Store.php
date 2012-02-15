<?php
abstract class SR_Store extends SR_Location
{
	const BAD_KARMA_STEAL_PRISON = 0.4;
	const BAD_KARMA_STEAL_COMBAT = 0.2;
	
	public function allowShopBuy(SR_Player $player) { return true; }
	public function allowShopSell(SR_Player $player) { return true; }
	public function allowShopSteal(SR_Player $player) { return $player->getBase('thief') > 0; }
	
	public function getCommands(SR_Player $player)
	{
		$back = array();
		if (true === $this->allowShopBuy($player))
		{
			$back[] = 'view';
			$back[] = 'buy';
		}
			if (true === $this->allowShopSell($player))
		{
			$back[] = 'sell';
		}
		if (true === $this->allowShopSteal($player))
		{
			$back[] = 'steal';
		}
		return $back;
	}
	
	public function getHelpText(SR_Player $player)
	{
		$c = Shadowrun4::SR_SHORTCUT; 
		$cmds = $this->getCommands($player);
		foreach ($cmds as $i => $cmd)
		{
			$cmds[$i] = "{$c}{$cmd}";
		}
		return $player->lang('hlp_store', array(GWF_Array::implodeHuman($cmds)));
// 		if ($player->getBase('thief') > 0)
// 		{
// 			return "In shops you can use {$c}view, {$c}buy, {$c}sell and {$c}steal.";
// 		}
// 		else
// 		{
// 			return "In shops you can use {$c}view, {$c}buy and {$c}sell.";
// 		}
	}
	
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
		
		if (!is_array($items))
		{
			return array();
		}
		
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

	public function calcSellPrice(SR_Player $player, SR_Item $item, $amt=1)
	{
		$price = $item->getItemPrice() * 0.10 * $amt;
		return Shadowfunc::calcSellPrice($price, $player);
	}
	
	public function getStoreItem(SR_Player $player, $itemname, $amount=false)
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
				if (stripos($d[0], $itemname) === 0)
				{
					$data = $d;
					break;
				}
			}
		}
		if ($data === false)
		{
			return false;
		}

		return $this->createItemFromData($player, $data, $amount);
	}
	
	private function createItemFromData(SR_Player $player, array $data, $amount=false)
	{
		$avail = isset($data[1]) ? $data[1] : 100.0;
		if ( $amount === false )
		{
			$amount = isset($data[3]) ? $data[3] : true;
		}
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
		return $this->onViewItems($player, $args);
// 		$bot = Shadowrap::instance($player);
// 		if (count($args) === 0)
// 		{
// // 			$bot->reply($this->onViewItems($player));
// 			$this->onViewItems($player, array());
// 		}
// 		elseif (count($args) === 1)
// 		{
// 			$this->onViewItem($player, $args[0]);
// 		}
// 		else
// 		{
// 			$bot->reply(Shadowhelp::getHelp($player, 'view'));
// 		}
	}
	
	private function onViewItem(SR_Player $player, $itemname)
	{
		$bot = Shadowrap::instance($player);
		if (false === ($item = $this->getStoreItem($player, $itemname)))
		{
			$bot->rply('1029');
// 			return 'We don`t have that item.';
			return false;
		}
		return $bot->rply('5189', array($item->getItemInfo($player)));
// 		return $item->getItemInfo($player);
	}
	
	private function getStoreItemsC(SR_Player $player)
	{
		$back = array();
		$items = $this->getStoreItemsB($player);
		foreach ($items as $data)
		{
			$back[] = $this->createItemFromData($player, $data);
		}
		return $back;
	}
	
	private function onViewItems(SR_Player $player, array $args=array())
	{
		$player->setOption(SR_Player::RESPONSE_ITEMS);
		$text = array(
		);
		$items = $this->getStoreItemsC($player);
		return Shadowfunc::genericViewS($player, $items, $args, $text);
		
		
// 		$bot = Shadowrap::instance($player);
		
// 		$back = '';
// 		$items = $this->getStoreItemsB($player);
		
// 		if (count($items) === 0)
// 		{
// 			return $bot->rply('1008');
// // 			return 'There are no items here.';
// 		}
		
// 		$i = 1;
// 		$format = $player->lang('fmt_sumlist');
// 		foreach ($items as $data)
// 		{
// 			if (false === ($item = $this->createItemFromData($player, $data))) {
// 				continue;
// 			}
// 			$back .= sprintf($format, $i++, $item->getItemName(), Shadowfunc::displayNuyen($item->getStorePrice()));
// // 			$back .= sprintf(', %d-%s(%s)', $i++, $item->getItemName(), Shadowfunc::displayNuyen($item->getStorePrice()));
// 		}
		
// 		return $bot->rply('5188', array(substr($back, 2)));
// // 		return substr($back, 2);
	}
	
	###########
	### Buy ###
	###########
	public function on_buy(SR_Player $player, array $args, $max_amt=false)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) < 1 or count($args) > 2)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'buy'));
			return false;
		}
		if (false === ($dummyitem = $this->getStoreItem($player, $args[0])))
		{
			$bot->rply('1029');
// 			$bot->reply('We don`t have that item.');
			return false;
		}
		
		$amt = (count($args) == 2) ? ((int) $args[1]) : 1;
		if ( $amt < 1 )
		{
			$bot->rply('1038'); # specify positive amt
			return false;
		}
		if ( false !== $max_amt and $amt > $max_amt )
		{
			$bot->rply('1175'); # more than offered
			return false;
		}
		$total_amount = $amt * $dummyitem->getAmount();
		$price = $amt * $dummyitem->getStorePrice();
		
		if (false === ($player->pay($price)))
		{
			$bot->rply('1063', array(Shadowfunc::displayNuyen($price), $player->displayNuyen()));
// 			$bot->reply(sprintf('You can not afford %s. You need %s but only have %s.', $item->getItemName(), Shadowfunc::displayNuyen($price), Shadowfunc::displayNuyen($player->getBase('nuyen'))));
			return false;
		}
		
		if ( $dummyitem->isItemStackable() )
		{
			$item = $this->getStoreItem($player, $args[0],$total_amount);
			$items = array($item);
		} else {
			$items = array($dummyitem);
			for ($i=1; $i<$amt; $i++) # using $amt here in case the default amount !== 1
			{
				$item = $this->getStoreItem($player, $args[0]);
				$items[] = $item;
			}
		}

		
		foreach ( $items as $item )
		{
			if (false === $item->insert())
			{
				$bot->reply('Database error 5.');
				return false;
			}
		}

		$player->giveItems($items);
		$player->modify();
		$item = $player->getInvItemByName($dummyitem->getItemName());
		$dprice = Shadowfunc::displayNuyen($price);
		$damount = ($total_amount == 1) ? '' : "({$total_amount})";
		$bot->rply('5190', array($dprice, $item->getItemName().$damount, $item->getInventoryID()));
// 		$bot->reply(sprintf('You paid %s and bought %s. Inventory ID: %d.', Shadowfunc::displayNuyen($price), $item->getItemName(), $item->getInventoryID()));
		return true;
	}
	
	############
	### Sell ###
	############
	public function on_sell(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) === 0) {
			$bot->reply(Shadowhelp::getHelp($player, 'sell'));
			return false;
		}
		
		# Item
		$itemname = array_shift($args);
		if (false === ($item = $player->getInvItem($itemname)))
		{
			$bot->rply('1029');
// 			$bot->reply('You don\'t have that item.');
			return false;
		}
		$itemname = $item->getItemName();
		if (!$item->isItemSellable())
		{
			$bot->rply('1151', array($item->getItemName()));
// 			$bot->reply(sprintf('I don\'t want your %s.', $item->getItemName()));
			return false;
		}
		
		# Price
		$price = $item->getItemPrice();# / $item->getItemDefaultAmount();
		$total = 0.0;
		
		# Amount
		$amt = isset($args[0]) ? array_shift($args) : 1;
		
		
		# A stackable?
		if ($item->isItemStackable())
		{
			$have_amt = $item->getAmount();
			# Split item
			if ($amt > $have_amt)
			{
				$bot->rply('1040', array($item->getItemName()));
// 				$bot->reply(sprintf('You have not that much %s.', $item->getItemName()));
				return false;
			}
				
			if (!$item->useAmount($player, $amt))
			{
				$bot->reply('Database Error R2 D2.');
				return false;
			}
		}
		
		# Not stackable
		else
		{
			$items2 = $player->getInvItems($item->getItemName(), $amt);
			if (count($items2) < $amt)
			{
				$bot->rply('1040', array($item->getItemName()));
// 				$bot->reply(sprintf('You have not that much %s.', $item->getItemName()));
				return false;
			}
				
			$stored = 0;
			foreach ($items2 as $item2)
			{
				if (!$player->removeFromInventory($item2))
				{
					$bot->reply('Database Error R2 D2.');
					return false;
				}
			}
		}
		
		$total = $this->calcSellPrice($player, $item, $amt);
		
		$player->giveNuyen($total);

		return $bot->rply('5191', array(
			$amt, $item->getItemName(), Shadowfunc::displayNuyen($total),
			Shadowfunc::displayWeight($player->get('weight')), Shadowfunc::displayWeight($player->get('max_weight'))
		));
		
// 		$bot->reply(sprintf('You sold %d of your %s for %s. You now carry %s/%s.',
// 			$amt, $item->getItemName(), Shadowfunc::displayNuyen($total),
// 			Shadowfunc::displayWeight($player->get('weight')), Shadowfunc::displayWeight($player->get('max_weight'))
// 		));
// 		return true;
	}


	public function checkLocation()
	{
// 		return true;
		$player = new SR_Player(SR_Player::getPlayerData(0));
		$player->modify();
		$items = $this->getStoreItems($player);
		foreach ($items as $data)
		{
			$iname = $data[0];
//			printf("Checking %s in %s.\n", $iname, $this->getName());
			if (false === SR_Item::createByName($iname, 1, false))
			{
				die(sprintf('%s has an invalid item: %s.', $this->getName(), $iname));
			}
		}
		return parent::checkLocation();
	}
	
	################
	### Stealing ###
	################
	
	
	public function on_steal(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'steal'));
			return false;
		}
		
		if (false === ($item = $this->getStoreItem($player, $args[0])))
		{
			$bot->rply('1140');
// 			$bot->reply('There is no such item here.');
			return false;
		}
		$itemname = $item->getItemName();
		
// 		if ($player->getBase('thief') < 0)
// 		{
// 			$bot->reply('You are missing the thief skill.');
// 			return false;
// 		}
		
		# Steal difficulty
		$difficulty = $item->getItemLevel();
		
		if ($difficulty < 0)
		{
			return $this->onStealOops($player, $itemname);
		}
		
		# Your skill
		$qu = $player->get('quickness');
		$th = $player->get('thief');
		$skill = $qu + $th*2;
		
		# DEBUG
		printf("Dicing DIFF %.02f against SKILL %.02f ...\n", $difficulty, $skill);
		
		# Dice diff
		$min = $difficulty + 2;
		$max = $min * 2 + 1;
		$dice_diff = Shadowfunc::diceFloat($min, $max, 2);
		
		# Dice skill
		$min = 1;
		$max = $min + $skill + 1;
		$dice_skill = Shadowfunc::diceFloat($min, $max, 2);
		
		$bot->rply('5192', array($item->getItemName()));
// 		$bot->reply(sprintf('You attempt to steal %s...', $item->getItemName()));
		
		# On succes we have a negative value.
		$difference = $dice_diff - $dice_skill;
		
		if ($difference < (-$difficulty))
		{
			# Yay!
			return $this->onStealSuccess($player, $itemname);
		}
		elseif ($difference < 1)
		{
			# Nuts!
			return $this->onStealNothing($player, $itemname);
		}
		elseif ($difference > $difficulty*2)
		{
			# Prison!
			return $this->onStealPrisoned($player, $itemname);
		}
		elseif ($difference > $difficulty)
		{
			# Police!
			return $this->onStealCombat($player, $itemname);
		}
		else
		{
			# Oops im beeing watched! :)
			return $this->onStealOops($player, $itemname);
		}
		
		$bot->reply('WRONG CODE IS WRONG!');
		return false;
	}
	
	private function onStealSuccess(SR_Player $player, $itemname)
	{
		$bot = Shadowrap::instance($player);
		
		if (false === ($item = SR_Item::createByName($itemname)))
		{
			return $bot->reply('DB ERROR!');
		}
		
		$bot->rply('5193', array($itemname));
// 		$bot->reply(sprintf('You were lucky and able to steal %s.', $itemname));
		
		if (false === $player->giveItems(array($item), 'stealing'))
		{
			return $bot->reply('DB ERROR 2!');
		}
		
		return true;
	}
	
	private function onStealNothing(SR_Player $player, $itemname)
	{
		$bot = Shadowrap::instance($player);
		return $bot->rply('5194');
// 		return $bot->reply('You cannot find the right moment to steal something.');
	}

	private function onStealPrisoned(SR_Player $player, $itemname)
	{
		$bot = Shadowrap::instance($player);
		$bot->rply('5195');
// 		$bot->reply('You are out of luck ... the shop owner silently called the cops and you are put into Delaware Prison.');
		SR_BadKarma::addBadKarma($player, self::BAD_KARMA_STEAL_PRISON);
		
		$p = $player->getParty();
		$p->kickUser($player);
		$np = SR_Party::createParty();
		$np->addUser($player, true);
		$np->cloneAction($p);
		$np->clonePreviousAction($p);
		$np->pushAction(SR_Party::ACTION_INSIDE, 'Prison_Block1');
		return true;
	}

	private function onStealCombat(SR_Player $player, $itemname)
	{
		$bot = Shadowrap::instance($player);
		$bot->rply('5196');
// 		$bot->reply('You are out of luck ... the shop owner silently called the cops ...');
		SR_BadKarma::addBadKarma($player, self::BAD_KARMA_STEAL_COMBAT);
		
		$p = $player->getParty();
		$p->kickUser($player);
		$np = SR_Party::createParty();
		$np->addUser($player, true);
		$np->cloneAction($p);
		$np->clonePreviousAction($p);
		$np->fight(SR_NPC::createEnemyParty('Prison_GrayOp', 'Prison_GrayOp', 'Prison_GrayOp'));
		return true;
	}

	private function onStealOops(SR_Player $player, $itemname)
	{
		$bot = Shadowrap::instance($player);
		$bot->rply('5197');
// 		return $bot->reply('The shop owner is watching ... you better wait a bit.');
	}
}
?>
