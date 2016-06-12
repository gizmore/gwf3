<?php
abstract class SR_Store extends SR_Location
{
	public function getAbstractClassName() { return __CLASS__; }
	
	const BAD_KARMA_STEAL_PRISON = 0.4;
	const BAD_KARMA_STEAL_COMBAT = 0.2;
	
	const CONFIRM_BUY_ID = 'STORE_CONFIRM_BUY_ID';
	
	public function allowShopBuy(SR_Player $player) { return true; }
	public function allowShopSell(SR_Player $player) { return true; }
	public function allowShopSellAll(SR_Player $player) { return true; }
	public function allowShopSteal(SR_Player $player) { return $player->getBase('thief') > 0; }
	
	private $lastPurchasedItem = NULL;
	public function getLastPurchasedItemName() { return $this->lastPurchasedItem; }
	
	public function getCommands(SR_Player $player)
	{
		$back = array();
		if (true === $this->allowShopBuy($player))
		{
			$back[] = 'view';
			$back[] = 'viewi';
			$back[] = 'buy';
		}
		if (true === $this->allowShopSell($player))
		{
			$back[] = 'sell';
		        if (true === $this->allowShopSellAll($player))
			{
				$back[] = 'sellall';
			}
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
		return $player->lang('hlp_store', array(GWF_Array::implodeHuman($cmds))).parent::getHelpText($player);
// 		if ($player->getBase('thief') > 0)
// 		{
// 			return "In shops you can use {$c}view, {$c}buy, {$c}sell and {$c}steal.";
// 		}
// 		else
// 		{
// 			return "In shops you can use {$c}view, {$c}buy and {$c}sell.";
// 		}
	}
	
	public function getFoundText(SR_Player $player)
	{
		return $player->lang('stub_found_store');
	}
	
	public function getEnterText(SR_Player $player)
	{
		return $player->lang('stub_enter_store', array($this->getCity()));
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
		if ($player->hasTemp($key))
		{
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
	
	public function getStoreItem(SR_Player $player, $itemname)
	{
		$items = $this->getStoreItemsC($player);
		if (is_numeric($itemname))
		{
			$id = (int)$itemname;
			return ($id < 1) || ($id > count($items)) ? false : $items[$id-1];
		}
		else
		{
			return $player->getItemByNameB($itemname, $items);
		}
	}
	
	private function createItemFromData(SR_Player $player, array $data, $amount=false)
	{
		$avail = isset($data[1]) ? $data[1] : 100.0;
		if ( $amount === false )
		{
			$amount = isset($data[3]) ? $data[3] : true;
		}
		if (false === ($item = SR_Item::createByName($data[0], $amount, false)))
		{
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
	public function getStoreViewCode() { return '5276'; }
	public function on_view(SR_Player $player, array $args)
	{
// 		$player->setOption(SR_Player::RESPONSE_ITEMS);
		$text = array(
			'code' => $this->getStoreViewCode(),
		);
		$items = $this->getStoreItemsC($player);
		return Shadowfunc::genericViewS($player, $items, $args, $text);
	}
	
	public function getStoreItemsC(SR_Player $player)
	{
		$back = array();
		$items = $this->getStoreItemsB($player);
		foreach ($items as $data)
		{
			$back[] = $this->createItemFromData($player, $data);
		}
		return $back;
	}
	
	public function on_viewi(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);

		if (count($args) !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'viewi'));
			return false;
		}

		if (false === ($item = $this->getStoreItem($player, $args[0])))
		{
			$bot->rply('1140'); # no such item
			return false;
		}

		return $bot->rply('5189', array($item->getItemInfo($player)));
	}

	###########
	### Buy ###
	###########
	public function on_buy(SR_Player $player, array $args, $max_amt=false, $confirm=false)
	{
		$bot = Shadowrap::instance($player);
		if ( (count($args) < 1) || (count($args) > 2) )
		{
			$bot->reply(Shadowhelp::getHelp($player, 'buy'));
			return false;
		}
		if (false === ($dummyitem = $this->getStoreItem($player, $args[0])))
		{
			$bot->rply('1140'); # no such item
			return false;
		}
		
		$itemname = $dummyitem->getItemName();
		
		# Amt
		$amt = (count($args) == 2) ? ((int) $args[1]) : 1;
		if ($amt < 1)
		{
			$bot->rply('1038'); # specify positive amt
			return false;
		}
		if ( (false !== $max_amt) && ($amt > $max_amt) )
		{
			$bot->rply('1175'); # more than offered
			return false;
		}
		
		# Calc price
		$total_amount = $amt * $dummyitem->getAmount();
		$price = $amt * $dummyitem->getStorePrice();
		$dprice = Shadowfunc::displayNuyen($price);
		
		# Confirm?
		if ($confirm)
		{
			$confirmstring = "{$total_amount}x{$itemname}";
			if ($player->getTemp(self::CONFIRM_BUY_ID) !== $confirmstring)
			{
				$player->setTemp(self::CONFIRM_BUY_ID, $confirmstring);
				$bot->rply('5155', array($total_amount, $dummyitem->displayFullName($player), $this->displayName($player), $dprice));
				# You attempt to purchase %s %s from %s for %s. Retype to confirm.
				return false;
			}
			else
			{
				$player->unsetTemp(self::CONFIRM_BUY_ID);
			}
		}
		
		if (false === ($player->pay($price)))
		{
			$bot->rply('1063', array($dprice, $player->displayNuyen()));
// 			$bot->reply(sprintf('You can not afford %s. You need %s but only have %s.', $item->getItemName(), Shadowfunc::displayNuyen($price), Shadowfunc::displayNuyen($player->getBase('nuyen'))));
			return false;
		}
		
		# Insert the items
		if ( $dummyitem->isItemStackable() )
		{
			$item = $this->getStoreItem($player, $args[0]);
			$item->setAmount($total_amount);
			$items = array($item);
		}
		else
		{
			$items = array($dummyitem);
			for ($i = 1; $i < $amt; $i++) # using $amt here in case the default amount !== 1
			{
				$item = $this->getStoreItem($player, $args[0], 1);
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

		$this->lastPurchasedItem = $dummyitem->getItemName();
		
		# Give to player
		$player->giveItems($items);
		$player->modify();
		$item = $player->getInvItemByName($this->lastPurchasedItem);
		$damount = ($total_amount == 1) ? '' : "({$total_amount})";
		$bot->rply('5190', array($dprice, $total_amount, $item->displayFullName($player), $player->displayWeight(), $player->displayMaxWeight(), $item->getInventoryID()));
// 		$bot->reply(sprintf('You paid %s and bought %s. Inventory ID: %d.', Shadowfunc::displayNuyen($price), $item->getItemName(), $item->getInventoryID()));
		return true;
	}
	
	############
	### Sell ###
	############
	public function on_sellall(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$argc = count($args);
		if ($argc !== 1)
		{
			$bot->reply(Shadowhelp::getHelp($player, 'sellall'));
			return false;
		}
		
		$min = 1;
		$max = $player->getInventory()->getNumGrouped();
		
		if (preg_match('/^\\d*-?\\d*$/', $args[0]))
		{
			$lims = explode('-',$args[0]);
			if (count($lims) === 1)
			{
				$from = (int)$lims[0];
				$to = $from;
			}
			else
			{
				$from = (strlen($lims[0]) === 0) ? $min : (int)$lims[0];
				$to = (strlen($lims[1]) === 0) ? $max : (int)$lims[1];
			}
		}
		else
		{
			$bot->reply(Shadowhelp::getHelp($player, 'sellall'));
			return false;
		}
		
		if ( ($from > $to) || ($from < 1) || ($to > $max) )
		{
			$bot->rply('1194');
			return false;
		}
		
		$inv = $player->getInventory()->getItemsByGroupedIndex($from-1, $to);

		$sold = 0;
		$unsold = 0;
		$price = 0;
		foreach ($inv as $itemname => $data)
		{
			foreach ($data[1] as $item)
			{
				$amt = $item->getAmount();

				if (!$item->isItemSellable())
				{
					$unsold += $amt;
					continue;
				}

				$item_price = $this->calcSellPrice($player, $item, $amt);

				if ( $item->deleteItem($player,false) )
				{
					$sold += $amt;
					$price += $item_price;
				} else {
					$unsold += $amt;
				}
			}
		}
		$player->modify();

		$player->giveNuyen($price);

		$msg_code = '5315';
		$msg_args = array($sold, Shadowfunc::displayNuyen($price));
		if ($unsold !== 0)
		{
			$msg_code = '5316';
			$msg_args[] = $unsold;
		}
		$msg_args[] = Shadowfunc::displayWeight($player->get('weight'));
		$msg_args[] = Shadowfunc::displayWeight($player->get('max_weight'));
		return $bot->rply($msg_code, $msg_args);
	}
	
	public function on_sell(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$argc = count($args);
		if ($argc < 1 || $argc > 2)
		{
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
		
		# Amount
		$amt = isset($args[0]) ? array_shift($args) : 1;
		
		if (!Common::isNumeric($amt))
		{
			$bot->rply('1040', array($item->getItemName()));
			return false; 
		}
		
		if ($amt < 1)
		{
			$bot->rply('1038', array($item->getItemName()));
			return false; 
		}
		
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
				
			foreach ($items2 as $item2)
			{
				$item2 instanceof SR_Item;
				if (!$item2->useAmount($player, 1, false))
				{
					$bot->reply('Database Error R3 D3.');
					$player->modify(); // in case some succeeded
					return false;
				}
			}
			$player->modify();
		}
		
		# Price
		$total = $this->calcSellPrice($player, $item, $amt);
		
		$player->giveNuyen($total);

		return $bot->rply('5191', array(
			$amt, $item->displayFullName($player), Shadowfunc::displayNuyen($total),
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
		$player = Shadowrun4::getDummyPlayer();
		$items = $this->getStoreItems($player);
		foreach ($items as $data)
		{
			$iname = $data[0];
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
	
	public function onCityExit(SR_Party $party)
	{
		parent::onCityExit($party);
		$party->unsetTemp($this->getStoreItemsKey());
	}
	
	public function onLeaveLocation(SR_Party $party)
	{
		parent::onLeaveLocation($party);
		$party->unsetTemp(self::CONFIRM_BUY_ID);
	}
}
?>
