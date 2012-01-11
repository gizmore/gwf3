<?php
final class Shadowcmd_mount extends Shadowcmd
{
	# mount push cap 4
	public static function execute(SR_Player $player, array $args)
	{
		$p = $player->getParty();
		if (false !== ($city = $p->getCityClass()))
		{
			if ($city->isDungeon())
			{
				Shadowrap::instance($player)->reply('In dungeons you don\'t have mounts.');
				return false;
			}
		}
		
		if ($player->isFighting())
		{
			$player->message('This command does not work in combat.');
			return false;
		}
		
		if (0 === ($cnt = count($args)))
		{
			return self::on_show_page($player, 1);
			return false;
// 			return self::on_show($player, $args);
		}
		
		$command = array_shift($args);
		
		switch ($command)
		{
//			case 'load': return self::on_load($player, $args);
//			case 'unload': return self::on_unload($player, $args);
			case 'push': return self::on_push($player, $args);
			case 'pop': return self::on_pop($player, $args);
			case 'clean': return self::on_clean($player, $args);
			
			default:
				if (Common::isNumeric($command))
				{
					return self::on_show_page($player, $command);
				}
				else
				{
					return self::on_search($player, $command, $args); 
				}
// 				self::on_help($player, $args); return false;
		}
	}

	/**
	 * Show a full mount page
	 */ 
	private static function on_show_page(SR_Player $player, $page)
	{
		$bot = Shadowrap::instance($player);
		$ipp = 10;
		$page = (int)$page;
		$items = $player->getMountInvSorted();
		$nItems = count($items);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		if ( ($page < 1) || ($page > $nPages) )
		{
			$bot->reply('This mount page is empty.');
			return false;
		}
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$items = array_slice($items, $from, $ipp, true);
		return $bot->reply(sprintf('Your mount page %s/%s: %s.', $page, $nPages, Shadowfunc::getItemsSorted($player, $items, $from)));
	}
	
	private static function on_search(SR_Player $player, $term, array $args)
	{
		$b = chr(2);
		$bot = Shadowrap::instance($player);
		
		if (strlen($term) < 3)
		{
			$bot->reply('In Shadowlamb, most shortcuts require at least 3 chars. This applies also to searchterm lengths.');
			return false;
		}
		
		$i = 1;
		$ipp = 10;
		
		$items = $player->getMountInvSorted();
		$matches = array();
		
		foreach ($items as $itemname => $data)
		{
			if (false !== stristr($itemname, $term))
			{
				$count = $data[0];
				$itemid = $data[1];
				$count = $count > 1 ? "($count)" : '';
				$matches[] = sprintf('%s-%s%s', $b.($i++).$b, $itemname, $count);
			}
			$i++;
		}
		
		$page = isset($args[0]) ? (int)$args[0] : 1;
		$nItems = count($matches);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		if ( ($page < 1) || ($page > $nPages) )
		{
			$bot->reply('This mount page is empty.');
			return false;
		}
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$items = array_slice($matches, $from, $ipp);
		return $bot->reply(sprintf('Matches in your mount page %s/%s: %s.', $page, $nPages, implode(', ', $items)));
	}
	
	/**
	 * Show help for the mount command.
	 * @param SR_Player $player
	 * @param array $args
	 * @return true
	 */
	private static function on_help(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		return $bot->reply(Shadowhelp::getHelp($player, 'mount'));
	}

	/**
	 * Show items stored in your mount.
	 * @param SR_Player $player
	 * @param array $args
	 * @return true
	 */
	private static function on_show(SR_Player $player, array $args)
	{
		$mount = $player->getMount();
		$weight = $mount->displayWeight();
		if ($weight !== '')
		{
			$weight = ', '.$weight;
		}
		$message = sprintf('Mount: %s(LOCK %s%s): ', $mount->getName(), $mount->getMountLockLevelB(), $weight);
		return self::reply($player, $message.Shadowfunc::getMountInv($player).'.');
	}

	/**
	 * Push an item to your mount.
	 * @param SR_Player $player
	 * @param array $args
	 * @return boolean
	 */
	private static function on_push(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$mount = $player->getMount();
		

		# Item
		$itemname = array_shift($args);
		if (false === ($item = $player->getItem($itemname)))
		{
			$bot->reply('You don\'t have that item.');
			return false;
		}
		$itemname = $item->getItemName();

		# Is Storage Mount?
		if (0 >= ($max = $mount->getMountWeightB()))
		{
			$bot->reply(sprintf('You cannot store items in your %s.', $mount->getName()));
			return false;
		}
		
		# Amt
		$amt = isset($args[0]) ? intval(array_shift($args)) : 1;
		if ($amt < 1)
		{
			$bot->reply('Please store a positive amount of items in your mount.');
			return false;
		}
		
		# Is mount in mount?
		if ($item instanceof SR_Mount)
		{
			$bot->reply(sprintf('You cannot put mounts in your %s.', $mount->getName()));
			return false;
		}
		
		# Is room in mount?
//		$iw = $item->getItemWeightStacked();
		$iw = $item->getItemWeight() * $amt;
		$we = $mount->calcMountWeight();
		if ( ($iw + $we) > $max )
		{
			$bot->reply(sprintf('The %s(%s) is too heavy to store in your %s(%s/%s)', $item->getName(), Shadowfunc::displayWeight($iw), $mount->getName(), Shadowfunc::displayWeight($we), Shadowfunc::displayWeight($max)));
			return false;
		}
		
		# Equipped?
		if ($item->isEquipped($player))
		{
			$player->unequip($item);
			$player->removeFromInventory($item);
			$player->putInMountInv($item);
			$stored = 1;
		}
		
		# A stackable?
		elseif ($item->isItemStackable())
		{
			$have_amt = $item->getAmount();
			# Split item
			if ($amt > $have_amt)
			{
				$bot->reply(sprintf('You have not that much %s.', $item->getItemName()));
				return false;
			}
				
			$item->useAmount($player, $amt);
			$item2 = SR_Item::createByName($item->getItemName(), $amt, true);
			$item2->saveVar('sr4it_uid', $player->getID());
			$player->putInMountInv($item2);
			$stored = $amt;
		}
		
		# Not stackable
		else
		{
			$items2 = $player->getInvItems($item->getItemName(), $amt);
			if (count($items2) < $amt)
			{
				$bot->reply(sprintf('You have not that much %s.', $item->getItemName()));
				return false;
			}
				
			$stored = 0;
			foreach ($items2 as $item2)
			{
				if ($player->removeFromInventory($item2))
				{
					if ($player->putInMountInv($item2))
					{
						$stored++;
					}
				}
			}
		}
		
		$message = sprintf('You stored %d of your %s in your %s.', $stored, $itemname, $mount->getName());
		return $player->message($message);
	}
	
	/**
	 * Pop an item from your mount.
	 * @param SR_Player $player
	 * @param array $args
	 */
	private static function on_pop(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$mount = $player->getMount();
		
		if (0 === ($cnt = count($args)))
		{
			return self::on_show($player, $args);
		}
		if ($cnt > 2)
		{
			return self::on_help($player, $args);
		}
		
		# Is Storage Mount?
		if (0 >= ($max = $mount->getMountWeight()))
		{
			$bot->reply(sprintf('You cannot store items in your %s.', $mount->getName()));
			return false;
		}
		
		# GetItem
		$itemname = array_shift($args);
		if (false === ($item = $player->getMountInvItem($itemname)))
		{
			$bot->reply('You don`t have that item in your mount.');
			return false;
		}
		$itemname = $item->getItemName();
		$amt = isset($args[0]) ? intval(array_shift($args)) : 1;
		$collected = 0;
		
		# Pre-Amt
		if ($amt <= 0)
		{
			$bot->reply('Please pop a positve amount of items.');
			return false;
		}
		
		# Stack
		if ($item->isItemStackable())
		{
			$have_amt = $item->getAmount();
			if ($amt > $have_amt)
			{
				$bot->reply(sprintf('You don\'t have that much %s in your %s.', $itemname, $mount->getName()));
				return false;
			}
			
			if (false === ($item2 = SR_Item::createByName($itemname, $amt, true)))
			{
				$bot->reply(sprintf('Cannot create item in %s line %s.', __FILE__, __LINE__));
				return false;
			}

			if (false === $item->useAmount($player, $amt))
			{
				$bot->reply(sprintf('Cannot use item amount in %s line %s.', __FILE__, __LINE__));
				return false;
			}
			
			if ($item->getAmount() <= 0)
			{
				if (false === $player->removeFromMountInv($item))
				{
					$bot->reply(sprintf('Cannot remove from mount inventory in %s line %s.', __FILE__, __LINE__));
				}
			}
			
			$player->giveItem($item2);
			$collected = $amt;
		}
		
		# NonStackable
		else
		{
			while (false !== ($item2 = $player->getMountInvItemByName($itemname)))
			{
				if (false !== $player->removeFromMountInv($item2))
				{
					if (false !== $player->giveItem($item2))
					{
						$collected++;
						if ($collected >= $amt)
						{
							break;
						}
					}
				}
			}
		}
		
		$player->updateInventory();
		
		$reply = sprintf('You collect %d %s from your %s and put it into your inventory.', $collected, $itemname, $mount->getName());

		// append inventory id if it can be determined
		$invItem = $player->getInvItemByName($itemname);
		if ($invItem !== false)
		{
			$reply .= sprintf(' Inventory ID: %d.', $invItem->getInventoryID());
		}
		
		return $bot->reply($reply);
		/*
		# Whole stack or single
		if (count($args) === 1)
		{
			if (!$player->removeFromBank($item))
			{
				$bot->reply('You don`t have that item in your bank.');
				return false;
			}
			if (!$player->giveItems($item))
			{
				$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
				return false;
			}

			$collected = $item->getAmount();
		}
		
		else
		{
			# Args
			$amt = (int)$args[1];
			if ($amt <= 0)
			{
				$bot->reply('Please pop a positve amount of items.');
				return false;
			}
			
			# Limits
			if ($item->isItemStackable())
			{
				$have_amt = $item->getAmount();
			}
			else
			{
				$items2 = $player->getBankItemsByItemName($item->getItemName());
				$have_amt = count($items2);
			}
			if ($amt > $have_amt)
			{
				$bot->reply(sprintf('You do not have that much %s in your bank.', $item->getItemName()));
				return false;
			}
			
			# Split Stack
			if ($item->isItemStackable())
			{
				if (false === $item->useAmount($player, $amt))
				{
					$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					return false;
				}
				
				if (false === $item2 = SR_Item::createByName($item->getItemName(), $amt, true))
				{
					$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					return false;
				}

				if (false === $player->giveItem($item2))
				{
					$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					return false;
				}
				
				$collected = $amt;
			}
			
			# Multi Equipment
			else
			{
				$collected = 0;
				foreach ($items2 as $item2)
				{
					if (false === $player->removeFromBank($item2))
					{
						$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					}
					elseif (false === $player->giveItem($item2))
					{
						$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					}
					else
					{
						$collected++;
						if ($collected >= $amt)
						{
							break;
						}
					}
				}
			}
		}
		
		$player->updateInventory();
		
		/*
		$itemname = $args[0];

		# Whole stack or single
		if (count($args) === 1)
		{
			if (!$player->removeFromBank($item))
			{
				$bot->reply('You don`t have that item in your bank.');
				return false;
			}
			if (!$player->giveItems($item))
			{
				$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
				return false;
			}

			$collected = $item->getAmount();
		}
		
		else
		{
			# Args
			$amt = (int)$args[1];
			if ($amt <= 0)
			{
				$bot->reply('Please pop a positve amount of items.');
				return false;
			}
			
			# Limits
			if ($item->isItemStackable())
			{
				$have_amt = $item->getAmount();
			}
			else
			{
				$items2 = $player->getBankItemsByItemName($item->getItemName());
				$have_amt = count($items2);
			}
			if ($amt > $have_amt)
			{
				$bot->reply(sprintf('You do not have that much %s in your bank.', $item->getItemName()));
				return false;
			}
			
			# Split Stack
			if ($item->isItemStackable())
			{
				if (false === $item->useAmount($player, $amt))
				{
					$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					return false;
				}
				
				if (false === $item2 = SR_Item::createByName($item->getItemName(), $amt, true))
				{
					$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					return false;
				}

				if (false === $player->giveItem($item2))
				{
					$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					return false;
				}
				
				$collected = $amt;
			}
			
			# Multi Equipment
			else
			{
				$collected = 0;
				foreach ($items2 as $item2)
				{
					if (false === $player->removeFromBank($item2))
					{
						$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					}
					elseif (false === $player->giveItem($item2))
					{
						$bot->reply(sprintf('Database error in %s line %s.', __FILE__, __LINE__));
					}
					else
					{
						$collected++;
						if ($collected >= $amt)
						{
							break;
						}
					}
				}
			}
		}
		*/
//		$player->updateInventory();
//		if ('' === ($paymsg = $this->pay($player))) {
//			$paymsg .= 'You ';
//		}
//		$paymsg .= sprintf('remove %d %s from your bank account and put it into your inventory.', $collected, $item->getItemName());
//		$bot->reply($paymsg);
//		return true;
		
		
//		$player->getMountInvItem();
//		
//		$player->getMountInvItemByName($itemname)
//		
//		if (false === ($item = $player->removeFromMountInv($arg)))
//		{
//			$bot->reply(sprintf('You don\'t have that item in your %s.', $mount->getName()));
//			return false;
//		}
//		
//		$message = sprintf('You collect your %s from your %s.', $item->getItemName(), $mount->getName());
//		$bot->reply($message);
//		
//		return true;
	}
	
	private static function on_clean(SR_Player $player, array $args)
	{	
		if (count($args) !== 0)
		{
			return self::on_help($player, $args);
		}
		while (count($player->getMountInvItems()) > 0)
		{
			$item = $player->getMountInvItemByID(1);
			$player->removeFromMountInv($item);
			$player->giveItem($item);
		}
		$player->updateInventory();
		$player->message('You have cleaned your mount.');
		return true;
	}
}
?>
