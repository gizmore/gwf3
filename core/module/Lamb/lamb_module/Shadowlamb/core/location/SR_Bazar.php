<?php
class SR_Bazar extends SR_Location
{
	const FEE = 4.5;
	const POP_FEE = 50;
	
	const SLOT_PRICE = 25;
//	const MAX_SLOTS = 20;
	const MIN_SLOTS = 2;
	const MAX_SLOTS_BUY = 18;
	
	const MIN_PRICE = 50;
	const MAX_PRICE = 1234567890;
	
	const TEMP_PAGE = 'BAZAR_PAGE';
	const TEMP_SEARCH = 'BAZAR_SEARCH';
	
	const TEMP_BUY_CONFIRM = 'BAZAR_BUY';
	const TEMP_BBUY_CONFIRM = 'BAZAR_BBUY';
	
	################
	### Location ###
	################
	public function getFoundPercentage()
	{
		return 50.0;
	}
	
	public function getHelpText(SR_Player $player)
	{
		return "In the bazar you can sell your items. You can use #push, #pop, #view, #search, #buy, #bestbuy, #buyslot, #slogan and #price here.";
	}
	
	public function getCommands(SR_Player $player)
	{
		return array('push','pop','view','search','buy','bestbuy','buyslot','slogan','price');
	}
	
	public function getBazarSlots(SR_Player $player)
	{
		return self::MIN_SLOTS + SR_PlayerVar::getVal($player, '__BAZAAR_SLOTS', 0);
	}
	
	public function getFoundText(SR_Player $player)
	{
		return "You found the local bazar, a place where you can offer your items and purchase them.";
	}
	
	public function getEnterText(SR_Player $player)
	{
		$shops = SR_BazarShop::getShopCount();
		$items = SR_BazarShop::getTotalItemCount();
		return "You enter the bazar. You see {$shops} shops with a total of {$items} items.";
	}
	
	public function getAreaSize()
	{
		return 600;
	}
	
	############
	### View ###
	############
	public function on_view(SR_Player $player, array $args)
	{
		$count = count($args);
		
		if ($count === 0)
		{
			return $this->onViewAllShops($player, 1);
		}
		elseif ( ($count === 1) && (is_numeric($args[0])) ) 
		{
			return $this->onViewAllShops($player, intval($args[0]));
		}
		elseif ( ($count === 1) )
		{
			return $this->onViewShop($player, $args[0]);
		}
		elseif (count($args) === 2)
		{
			return $this->onViewShopItem($player, $args[0], $args[1]);
		}
		else
		{
			return Shadowhelp::getHelp($player, 'bazar_view');
		}
	}
	
	public function onViewAllShops(SR_Player $player, $page)
	{
		$ipp = 10;
		$table = GDO::table('SR_BazarShop');
		$where = "sr4bs_itemcount > 0";
		$nShops = $table->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nShops);
		$page = Common::clamp($page, 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		if (false === ($result = $table->select('sr4bs_pname, sr4bs_itemcount', $where, "sr4bs_pname ASC", NULL, $ipp, $from)))
		{
			$player->message('Database error!');
			return false;
		}
		
		$out = '';
		while (false !== ($row = $table->fetch($result, GDO::ARRAY_N)))
		{
			$out .= sprintf(", \X02%s\X02(%d)", $row[0], $row[1]);
		}
		
		$table->free($result);
		
		$out = $out === '' ? 'There are no open shops yet' : substr($out, 2);
		
		return $player->message("Shops (Page {$page}/{$nPages}): {$out}.");
	}
	
	public function onViewShop(SR_Player $player, $pname)
	{
		$i_table = GDO::table('SR_BazarItem');

		if (false === ($shop = SR_BazarShop::getShop($pname)))
		{
			$player->message("{$pname} does not have a shop.");
			return false;
		}
		
		$epname = GDO::escape($pname);
		if (false === ($result = $i_table->select('sr4ba_iname, sr4ba_price, sr4ba_iamt', "sr4ba_pname='$epname'", 'sr4ba_price DESC')))
		{
			$player->message('Database error!');
			return false;
		}
		
		$itemcount = 0;
		$out = '';
		while (false !== ($row = $i_table->fetch($result, GDO::ARRAY_N)))
		{
			$amt = $row[2] < 2 ? '' : $row[2].'x';
			$out .= sprintf(", %s\X02%s\X02(%s)", $amt, $row[0], Shadowfunc::displayNuyen($this->calcBuyPrice($row[1])));
			$itemcount++;
		}
		$i_table->free($result);
		
		if ($out === '')
		{
			return $player->message(sprintf("%s's shop is empty.", $pname));
		}
		
		$player->message($shop->getSlogan());
		$player->message(sprintf("%d Items: %s.", $itemcount, substr($out, 2)));
		return true;
	}
	
	public function onViewShopItem(SR_Player $player, $pname, $iname)
	{
		if (false === ($shop = SR_BazarShop::getShop($pname)))
		{
			$player->message("{$pname} does not have a shop.");
			return false;
		}
		
		if (false === ($bi = SR_BazarItem::getBazarItem($pname, $iname)))
		{
			$player->message('This shop does not offer this item.');
			return false;
		}
		
		if (false === ($item = $bi->createItemClass()))
		{
			$player->message('The item seems invalid! Report this to gizmore!');
			return false;
		}
		
		$price = $this->calcBuyPrice($bi->getVar('sr4ba_price'));
		
		$out = sprintf("%s sells one of %d items for \X02%s\X02: %s.", $pname, $bi->getVar('sr4ba_iamt'), Shadowfunc::displayNuyen($price), $item->getItemInfo($player));
		
		return $player->message($out);
	}
	
	############
	### Push ###
	############
	public function on_push(SR_Player $player, array $args)
	{
		if ( (count($args) < 2) || (count($args) > 3) )
		{
			$player->message(Shadowhelp::getHelp($player, 'bazar_push'));
			return false;
		}
		
//		$nSlots = $this->getBazarSlots($player);

		$pname = $player->getName();
		
		$iname = $args[0];
		
		$price = round($args[1]);
		if ($price < self::MIN_PRICE)
		{
			$player->message(sprintf('The minimum price for an item is %s.', Shadowfunc::displayNuyen(self::MIN_PRICE)));
			return false;
		}
		if ($price > self::MAX_PRICE)
		{
			$player->message("Your price exceeds the max price.");
			return false;
		}
		
		$amt = isset($args[2]) ? ((int)$args[2]) : 0;
		if ($amt < 0)
		{
			$player->message("Please push a positive amount into your bazar.");
			return false;
		}
		$amt = Common::clamp($amt, 1);

		
		if (false === ($item = $player->getInvItem($iname)))
		{
			$player->message("You don't have this item in your inventory.");
			return false;
		}
		
		$iname = $item->getItemName();
		
		$bitem = SR_BazarItem::getBazarItem($pname, $iname);
		
		if ($bitem === false)
		{
			if (!$this->hasFreeSlot($player))
			{
				$player->message("All your bazar slots are in use. Try #pop or #buyslot.");
				return false;
			}
			
			if (false === SR_BazarShop::createShop($pname))
			{
				$player->message('Database Error 6!');
				return false;
			}
			
			if (false === ($shop = SR_BazarShop::getShop($pname)))
			{
				$player->message('Database Error 10!');
				return false;
			}
			
			# Stacked
			if ($item->isItemStackable())
			{
				if ($amt > $item->getAmount())
				{
					$player->message(sprintf("You only have %d of %s but you want to push %d.", $item->getAmount(), $item->getItemName(), $amt));
					return false;
				}
				
				if (false === $item->useAmount($player, $amt))
				{
					$player->message('Database Error 1!');
					return false;
				}
				
				if (false === SR_BazarItem::insertBazarItem($player->getName(), $iname, $price, $amt))
				{
					$player->message('Database Error 2!');
					return false;
				}
			}
			
			# Not Stacked
			else
			{
				$items = $player->getInvItems($iname, $amt);
				if (count($items) < $amt)
				{
					$player->message(sprintf("You only have %d of %s but you want to push %d.", count($items), $iname, $amt));
					return false;
				}
				
				foreach ($items as $item2)
				{
					$player->removeItem($item2);
				}
				
				if (false === SR_BazarItem::insertBazarItem($player->getName(), $iname, $price, $amt))
				{
					$player->message('Database Error 3!');
					return false;
				}
			}
			
//			if (false === ($shop->increase('sr4bs_itemcount', 1)))
//			{
//				$player->message('Database Error 12!');
//				return false;
//			}

			if (false === ($shop->fixItemCount()))
			{
				$player->message('Database Error 21!');
			}

			$price2 = $this->calcBuyPrice($price);
			return $player->message(sprintf('You offered %d %s for %s each in your bazar.', $amt, $iname, Shadowfunc::displayNuyen($price2)));
		}
		
		# Add to bazar stack
		else
		{
			if (false === ($shop = SR_BazarShop::getShop($pname)))
			{
				$player->message('Database Error 16!');
				return false;
			}
			
			# Stacked
			if ($item->isItemStackable())
			{
				if ($item->getAmount() < $amt)
				{
					$player->message(sprintf('You want to push %s %s, but you only have %s.', $amt, $iname, $item->getAmount()));
					return false;
				}
				if (false === $item->useAmount($player, $amt))
				{
					$player->message('Database Error 4!');
					return false;
				}
			}
			# Equipment
			else
			{
				$items2 = $player->getInvItems($iname, $amt);
				if (count($items2) < $amt)
				{
					$player->message(sprintf('You want to push %d %s but you only got %d.', $amt, $iname, count($items2)));
					return false;
				}
				
				foreach ($items2 as $item2)
				{
					$item2 instanceof SR_Item;
					if (false === $item2->deleteItem($player))
					{
						$player->message('Database Error 6!');
						return false;
					}
				}
			}

			if (false === $bitem->increase('sr4ba_iamt', $amt))
			{
				$player->message('Database Error 4!');
				return false;
			}
			
			if (false === ($shop->fixItemCount()))
			{
				$player->message('Database Error 21!');
			}
			
			if (false === $bitem->saveVar('sr4ba_price', $price))
			{
				$player->message('Database Error 5!');
				return false;
			}
			
			$price2 = $this->calcBuyPrice($price);
			return $player->message(sprintf('You now offer %d %s in your bazar for %s each.', $bitem->getVar('sr4ba_iamt'), $iname, Shadowfunc::displayNuyen($price2)));
		}
	}
	
	public function hasFreeSlot(SR_Player $player)
	{
		$pname = $player->getName();
		if (false === ($shop = SR_BazarShop::getShop($pname)))
		{
			return true;
		}
		$used_slots = SR_BazarItem::getUsedSlots($pname);
		$avail_slots = $this->getBazarSlots($player);
		return $used_slots < $avail_slots; 
	}
	
	###########
	### Pop ###
	###########
	public function calcPopFee(SR_Player $player, $amt=1)
	{
		$fee = self::POP_FEE * $amt;
		return Shadowfunc::calcBuyPrice($fee, $player);
	}
	
	public function onViewOwnShop(SR_Player $player)
	{
		return $this->onViewShop($player, $player->getName());
	}
	
	public function on_pop(SR_Player $player, array $args)
	{
		$c = count($args);
		if ($c > 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'bazar_pop'));
			return false;
		}
		if ($c === 0)
		{
			return $this->onViewOwnShop($player);
		}
		
		$pname = $player->getName();
		$iname = $args[0];
		$amt = isset($args[1]) ? intval($args[1], 10) : 1;
		
		if ($amt < 1)
		{
			$player->message('Please pop a positive amount of your bazar.');
			return false;
		}
		
		if (false === ($shop = SR_BazarShop::getShop($pname)))
		{
			$player->message('You don\'t have a shop yet.');
			return false;
		}
		
		if (false === ($bitem = SR_BazarItem::getBazarItem($pname, $iname)))
		{
			$player->message('You don\'t have this item in your bazar.');
			return false;
		}
		
		if ($amt > $bitem->getVar('sr4ba_iamt'))
		{
			$player->message(sprintf('You try to pop %d %s out of your bazar, but you only have %s.', $amt, $iname, $bitem->getVar('sr4ba_iamt')));
			return false;
		}
		
		if (false === ($item = $bitem->createItemClass()))
		{
			$player->message('The itemname is invalid. Please report this to gizmore!');
			return false;
		}
		$iname = $item->getItemName();
		
		$fee = $this->calcPopFee($player, $amt);
		if ($player->getNuyen() < $fee)
		{
			$player->message(sprintf('The fee for popping %d items out of your bazar is %s, but you only have %s.', $amt, Shadowfunc::displayNuyen($fee), $player->displayNuyen()));
			return false;
		}

		if ($item->isItemStackable())
		{
			if (false === ($item2 = SR_Item::createByName($iname, $amt, true)))
			{
				$player->message('Database Error 1!');
				return false;
			}
			if (false === $player->giveItems(array($item2)))
			{
				$player->message('Database Error 2!');
				return false;
			}
		}
		else
		{
			for ($i = 0; $i < $amt; $i++)
			{
				if (false === ($item2 = SR_Item::createByName($iname, 1, true)))
				{
					$player->message('Database Error 1!');
					return false;
				}
				if (false === $player->giveItem($item2))
				{
					$player->message('Database Error 2!');
					return false;
				}
			}
			if (false === $player->updateInventory())
			{
				$player->message('Database Error 3!');
				return false;
			}
		}
		
		if (false === $bitem->onPurchased($amt))
		{
			$player->message('Database Error 5!');
			return false;
		} 
		
//		if (false === $shop->increase('sr4bs_itemcount', -$amt))
//		{
//			$player->message('Database Error 4!');
//			return false;
//		}

		if (false === ($shop->fixItemCount()))
		{
			$player->message('Database Error 21!');
		}
		
		$player->giveNuyen(-$fee);
		
		return $player->message(sprintf('You pay the fee of %s and remove %d %s from your bazar and put it into your inventory.', Shadowfunc::displayNuyen($fee), $amt, $iname));
	}
	
	###########
	### Buy ###
	###########
	public function calcBuyPrice($price)
	{
		return $price * round(self::FEE / 100 + 1.00, 2);
	}
	
	public function on_buy(SR_Player $player, array $args)
	{
		$count = count($args);
		
		# Bad args?
		if ( ($count === 0) || ($count > 4) )
		{
			$player->message(Shadowhelp::getHelp($player, 'bazar_buy'));
			return false;
		}

		# Player name
		$pname = $args[0];
		if ($pname === $player->getName())
		{
			$player->message('You cannot buy items from your own shop.');
			return false;
		}
		
		# Show single shop?
		if ($count === 1)
		{
			return $this->onViewShop($player, $pname);
		}
		
		$iname = $args[1];
		$amt = isset($args[2]) ? intval($args[2], 10) : 1;
		
		if (false === ($shop = SR_BazarShop::getShop($pname)))
		{
			$player->message('This player does not have a shop.');
			return false;
		}
		
		if (false === ($bi = SR_BazarItem::getBazarItem($pname, $iname)))
		{
			$player->message('This shop does not offer this item.');
			return false;
		}
		
		if ($amt > $bi->getVar('sr4ba_iamt'))
		{
			$player->message(sprintf('You tried to purchase %d %s, but the shop only offers %d.', $amt, $iname, $bi->getVar('sr4ba_iamt')));
			return false;
		}
		
		$price = $this->calcBuyPrice($bi->getVar('sr4ba_price')) * $amt;
		if ($price > $player->getNuyen())
		{
			$player->message(sprintf('The price for %d %s is %s in this shop, but you only have %s.', $amt, $iname, Shadowfunc::displayNuyen($price), $player->displayNuyen()));
			return false;
		}
		
		
		if (false === ($item = $bi->createItemClass()))
		{
			$player->message('The item seems invalid! Report this to gizmore!');
			return false;
		}
		$iname = $item->getItemName();
		
		# Confirm!
		$msg = sprintf('%s::%s::%s::%s', $pname, $iname, $amt, $price);
		$old_msg = $player->getTemp(self::TEMP_BUY_CONFIRM, '');
		if ($old_msg !== $msg)
		{
			$player->setTemp(self::TEMP_BUY_CONFIRM, $msg);
			$player->message(sprintf('You attempt to purchase %d %s from %s for %s. Retype to confirm.', $amt, $iname, $pname, Shadowfunc::displayNuyen($price)));
			return true;
		}
		
		# Do it!
		if ($item->isItemStackable())
		{
			$item2 = SR_Item::createByName($iname, $amt, true);
			$player->giveItems(array($item2), "purchasing from {$pname}'s bazar.");
		}
		
		else
		{
			for ($i = 0; $i < $amt; $i++)
			{
				$item2 = SR_Item::createByName($iname, 1, true);
				$player->giveItem($item2);
			}
			$player->updateInventory();
			$player->getParty()->notice(sprintf('%s purchased %d %s from %s\'s bazar.', $player->getName(), $amt, $iname, $pname));
		}

		if (false === $shop->increase('sr4bs_itemcount', -$amt))
		{
			$player->message('Database error 19!');
			return false;
		}

		
		if (false === $bi->onPurchased($amt))
		{
			$player->message('Database error 19!');
			return false;
		}
		
		if (false === $bi->onPayOwner($player, $amt))
		{
			$player->message('Shop owner could not been paid, because the player is probably deleted.');
//			return false;
		}
		
		if (false === ($shop->fixItemCount()))
		{
			$player->message('Database Error 21!');
		}
		
		SR_BazarHistory::insertPurchase($player->getName(), $pname, $iname, $bi->getVar('sr4ba_price'), $amt);
		
		$player->giveNuyen(-$price);
		
		return true;
	}
	
	###############
	### Buyslot ###
	###############
	public function on_buyslot(SR_Player $player, array $args)
	{
		$c = count($args);
		if ($c === 0)
		{
			return $this->onBuyslotInfo($player);
		}
		elseif ($c === 1)
		{
			if ($args[0] === 'yesplease')
			{
				return $this->onBuySlot($player);
			}
			else
			{
				$player->message('Type "#buyslot yesplease" to confirm.');
				return false;
			}
		}
		else
		{
			$player->message(Shadowhelp::getHelp($player, 'bazar_buyslot'));
			return false;
		}
	}
	
	private function onBuyslotInfo(SR_Player $player)
	{
		$pname = $player->getName();
		if (false === ($shop = SR_BazarShop::getShop($pname)))
		{
			$used_slots = 0;
		}
		else
		{
			$used_slots = SR_BazarItem::getUsedSlots($pname);
		}
		$avail_slots = $this->getBazarSlots($player);
		$price = $this->calcBuySlotPrice($player);
		return $player->message(sprintf('You currently have %d of %d bazar slots in use. Another slot would cost you %s. Type #buyslot yesplease to confirm.', $used_slots, $avail_slots, Shadowfunc::displayNuyen($price)));
	}
	
	private function calcBuySlotPrice(SR_Player $player)
	{
		$ps = SR_PlayerVar::getVal($player, '__BAZAAR_SLOTS', 0);
		if ($ps >= self::MAX_SLOTS_BUY)
		{
			return -1;
		}
		
		$price = self::SLOT_PRICE;
		for ($i = 0; $i < $ps; $i++)
		{
			$price += $price;
		}
		return $price;
	}
	
	private function onBuySlot(SR_Player $player)
	{
		$price = $this->calcBuySlotPrice($player);
		$avail_slots = $this->getBazarSlots($player);
		if ($player->getNuyen() < $price)
		{
			$player->message(sprintf('It would cost %s to purchase slot number %s, but you only have %s.', Shadowfunc::displayNuyen($price), $avail_slots+1, $player->displayNuyen()));
			return false;
		}
		
		if (false === $player->giveNuyen(-$price))
		{
			$player->message('Database Error 1!');
			return false;
		}
		
		$ps = SR_PlayerVar::getVal($player, '__BAZAAR_SLOTS', 0);
		if (false === SR_PlayerVar::setVal($player, '__BAZAAR_SLOTS', $ps+1))
		{
			$player->message('Database Error 1!');
			return false;
		}
		
		return $player->message(sprintf('You pay the fee of %s and now have %s bazar slots.', Shadowfunc::displayNuyen($price), $avail_slots+1));
	}
	
	##############
	### Slogan ###
	##############
	public function on_slogan(SR_Player $player, array $args)
	{
		return count($args) === 0 ? $this->onShowSlogan($player) : $this->onSetSlogan($player, implode(' ', $args));
	}
	
	private function onShowSlogan(SR_Player $player)
	{
		$pname = $player->getName();
		if (false === ($shop = SR_BazarShop::getShop($pname)))
		{
			$player->message('You did not create a shop yet. You can do so by #push or #buyslot.');
			return false;
		}
		return $player->message(sprintf('Your shop\'s slogan: %s.', $shop->getSlogan()));
	}
	
	private function onSetSlogan(SR_Player $player, $new_slogan)
	{
		$pname = $player->getName();
		if (false === ($shop = SR_BazarShop::getShop($pname)))
		{
			SR_BazarShop::createShop($pname);
		}

		if (GWF_String::strlen($new_slogan) > SR_BazarShop::MAX_SLOGAN_LEN)
		{
			$player->message(sprintf('Your new slogan exceeds the max length of %d characters.', SR_BazarShop::MAX_SLOGAN_LEN));
			return false;
		}

		if (false === $shop->saveVar('sr4bs_message', $new_slogan))
		{
			$player->message('Database error!');
			return false;
		}
		
		$player->message(sprintf('Your slogan has been set to: %s.', $new_slogan));
		return true;
	}
	
	#############
	### Price ###
	#############
	public function on_price(SR_Player $player, array $args)
	{
		if (count($args) !== 2)
		{
			$player->message(Shadowhelp::getHelp($player, 'bazar_price'));
			return false;
		}
		$pname = $player->getName();
		$iname = $args[0];
		$price = (int)$args[1];
		
		if (false === ($shop = SR_BazarShop::getShop($pname)))
		{
			$player->message('You don\'t have a shop yet.');
			return false;
		}
		
		if (false === ($bitem = SR_BazarItem::getBazarItem($pname, $iname)))
		{
			$player->message('You don\'t have this item in your bazar.');
			return false;
		}
		
		if ($price < self::MIN_PRICE)
		{
			$player->message(sprintf('The minimum price for an item is %s.', Shadowfunc::displayNuyen(self::MIN_PRICE)));
			return false;
		}
		if ($price > self::MAX_PRICE)
		{
			$player->message("Your price exceeds the max price.");
			return false;
		}
		
		if (false === $bitem->saveVar('sr4ba_price', $price))
		{
			$player->message('Database Error 1!');
			return false;
		}
		
		$price2 = $this->calcBuyPrice($price);
		return $player->message(sprintf('You now offer %d %s for %s each.', $bitem->getVar('sr4ba_iamt'), $iname, Shadowfunc::displayNuyen($price2)));
	}
	
	##############
	### Search ###
	##############
	public function on_search(SR_Player $player, array $args)
	{
		$ipp = 5;
		
		$count = count($args);
		if ($count !== 1)
		{
			$player->message(Shadowhelp::getHelp($player, 'bazar_search'));
			return false;
		}
		
		$term = $args[0];
		$table = GDO::table('SR_BazarItem');
		
		if (false === ($conditions = GWF_QuickSearch::getQuickSearchConditions($table, array('sr4ba_iname'), $term)))
		{
			$player->message(Shadowhelp::getHelp($player, 'bazar_search'));
			return false;
		}
		$orderby = 'sr4ba_price ASC';
		$nItems = $table->countRows($conditions);
		
		if ($nItems === 0)
		{
			$player->message('No item matches your search query :(');
			return false;
		}
		
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);

		$old_term = $player->getTemp(self::TEMP_SEARCH, '');
		if ($old_term === $term)
		{
			$page = $player->getTemp(self::TEMP_PAGE, 1);
			$player->setTemp(self::TEMP_PAGE, $page+1);
		}
		else
		{
			$player->setTemp(self::TEMP_SEARCH, $term);
			$player->setTemp(self::TEMP_PAGE, 2);
			$page = 1;
		}
		
		if ($page > $nPages)
		{
			$player->message('There are no more matches.');
			return false;
		}
		
		$from = GWF_PageMenu::getFrom($page, $ipp);

		if (false === ($result = $table->select('*', $conditions, $orderby, NULL, $ipp, $from)))
		{
			$player->message('Database error!');
			return false;
		}
		
		$out = '';
		while (false !== ($row = $table->fetch($result, GDO::ARRAY_A)))
		{
			$amt = $row['sr4ba_iamt'];
			$amt = $amt > 1 ? "({$amt}x)" : '';
			$out .= sprintf(", %s \X02%s\X02 %s%s", $row['sr4ba_pname'], $row['sr4ba_iname'], $row['sr4ba_price'], $amt);
		}
		
		$table->free($result);
		
		return $player->message(sprintf('Matches %d/%d: %s.', $page, $nPages, substr($out, 2)));
	}

	################
	### Best Buy ###
	################
	public function on_bestbuy(SR_Player $player, array $args)
	{
		#bestbuy Firstaid 30000 3
		$c = count($args);
		if ( ($c < 2) || ($c > 3) )
		{
			$player->message(Shadowhelp::getHelp($player, 'bazar_bestbuy'));
			return false;
		}
		
		# Wanted Price
		$total = $args[1];
		if ($total < self::MIN_PRICE)
		{
			$player->message(sprintf('The minimum price for a single item is %s. Your total bid should be larger or equal than this.', Shadowfunc::displayNuyen(self::MIN_PRICE)));
			return false;
		}
		if ($total > $player->getNuyen())
		{
			$player->message(sprintf('You want to purchase items worth %s, but you only have %s.', Shadowfunc::displayNuyen($total), $player->displayNuyen()));
			return false;
		}
		
		# Wanted Amount
		$amt = isset($args[2]) ? ((int)$args[2]) : 1;
		if ( ($amt < 1) || ($amt > 1234567123) )
		{
			$player->message(sprintf('Please buy a positive amount of items.'));
			return false;
		}
		
		# Search
		$table = GDO::table('SR_BazarItem');
		$iname = $args[0];
		$einame = GDO::escape($iname);
		$conditions = "sr4ba_iname='$einame'";
//		if (false === ($conditions = GWF_QuickSearch::getQuickSearchConditions($table, array('sr4ba_iname'), $term)))
//		{
//			$player->message(Shadowhelp::getHelp($player, 'bazar_bestbuy'));
//			return false;
//		}
		
		if (false === ($result = $table->select('sr4ba_iname,sr4ba_price,sr4ba_iamt', $conditions, 'sr4ba_price ASC')))
		{
			$player->message('Database Error');
			return false;
		}
		
		$have_price = 0;
		$have_amt = 0;
		
		while (false !== ($row = $table->fetch($result, GDO::ARRAY_N)))
		{
			list($_name, $_price, $_amt) = $row;
			$iname = $_name;
			for ($i = 0; $i < $_amt; $i++)
			{
				$have_amt += 1;
				$_price = $this->calcBuyPrice($_price);
				$have_price += $_price;
				if ($have_amt >= $amt)
				{
					break;
				}
			}
			if ($have_amt >= $amt)
			{
				break;
			}
		}
		
		$table->free($result);

		# Check Result
		if ($have_amt < $amt)
		{
			$player->message(sprintf('You want to purchase %d %s, but you can only find %d.', $amt, $iname, $have_amt));
			$player->unsetTemp(self::TEMP_BBUY_CONFIRM);
			return false;
		}
		
		if ($have_price > $total)
		{
			$player->message(sprintf('You want to pay %s for %d %s, but the best price is %s.', Shadowfunc::displayNuyen($total), $amt, $iname, Shadowfunc::displayNuyen($have_price)));
			$player->unsetTemp(self::TEMP_BBUY_CONFIRM);
			return false;
		}
		
		$msg = implode(' ', $args);
		$old_msg = $player->getTemp(self::TEMP_BBUY_CONFIRM, '');
		if ($old_msg === $msg)
		{
			$player->unsetTemp(self::TEMP_BBUY_CONFIRM);
			return $this->onBestBuy2($player, $iname, $amt, $total);
		}
		else
		{
			$player->setTemp(self::TEMP_BBUY_CONFIRM, $msg);
			$player->message(sprintf('You are about to buy %d %s for %s in total. Retype your command to confirm.', $amt, $iname, Shadowfunc::displayNuyen($have_price)));
			return true;
		}
	}
	
	private function onBestBuy2(SR_Player $player, $iname, $amt, $total)
	{
		if (false === ($item = SR_Item::createByName($iname, 1, false)))
		{
			$player->message('The item seems invalid. Report to gizmore!');
			return false;
		}
		
		$table = GDO::table('SR_BazarItem');
		$einame = GDO::escape($iname);
		$conditions = "sr4ba_iname='$einame'";
		if (false === ($result = $table->select('*', $conditions, 'sr4ba_price ASC')))
		{
			$player->message('Datbase error 2!');
			return false;
		}
		
		$buyer = $player->getName();
		$have_amt = 0;
		$have_price = 0;
		
		while (false !== ($bitem = $table->fetch($result, GDO::ARRAY_O)))
		{
			$bitem instanceof SR_BazarItem;
			
			$_amt = $bitem->getVar('sr4ba_iamt');
			$need = $amt - $have_amt;
			if ($_amt > $need)
			{
				$_amt = $need;
			}
			
			$have_amt += $amt;
			
			if (false === $bitem->onPurchased($_amt))
			{
				$player->message('Database error 3!');
				return false;
			}
			
			if (false === $bitem->onPayOwner($player, $_amt))
			{
				$player->message('Database error 5!');
				return false;
			}
			
			
			$_price = $bitem->getVar('sr4ba_price');
			$_price = $this->calcBuyPrice($_price) * $_amt;
			$have_price += $_price;
			
			$seller = $bitem->getVar('sr4ba_pname');
			if (false === SR_BazarHistory::insertPurchase($buyer, $seller, $iname, $bitem->getVar('sr4ba_price'), $_amt))
			{
				$player->message('Database error 4!');
				return false;
			}
			
			if ($have_amt >= $amt)
			{
				break;
			}
		}
		$table->free($result);
		
		# Stackable
		if ($item->isItemStackable())
		{
			if (false === ($item2 = SR_Item::createByName($iname, $amt, true)))
			{
				$player->message('Database error 6!');
				return false;
			}
			if (false === $player->giveItems(array($item2), 'the bazar'))
			{
				$player->message('Database error 7!');
				return false;
			}
		}
		# Equipment
		else
		{
			for ($i = 0; $i < $amt; $i++)
			{
				if (false === ($item2 = SR_Item::createByName($iname, 1, true)))
				{
					$player->message('Database error 6!');
					return false;
				}
				
				if (false === $player->giveItem($item2))
				{
					$player->message('Database error 7!');
					return false;
				}
			}
			if (false === $player->updateInventory())
			{
				$player->message('Database error 7!');
				return false;
			}
			
			$player->getParty()->notice(sprintf('%s purchased %d %s from the bazar.', $player->getName(), $amt, $iname));
		}
		
		SR_BazarShop::fixAllItemCounts();
		
		$player->giveNuyen(-$have_price);
		$player->message(sprintf('You purchased %d %s for a total price of %s.', $amt, $iname, Shadowfunc::displayNuyen($have_price)));
		
		return true;
	}
}
?>