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
				self::rply($player, '1035');
// 				Shadowrap::instance($player)->reply('In dungeons you don\'t have mounts.');
				return false;
			}
		}
		
		if ($player->isFighting())
		{
			self::rply($player, '1036');
// 			$player->message('This command does not work in combat.');
			return false;
		}
		
 		if (0 === ($cnt = count($args)))
 		{
 			$args = array('1');
 		}
		
		switch ($args[0])
		{
//			case 'load': return self::on_load($player, $args);
//			case 'unload': return self::on_unload($player, $args);
			case 'push': return self::on_push($player, $args);
			case 'pop': return self::on_pop($player, $args);
			case 'clean': return self::on_clean($player, $args);
			
			default:
				$items = $player->getMountInvItems();
				$text = array(
					'prefix' => $player->lang('mount'),
				);
				return self::rply($player, '5129', array(Shadowfunc::getGenericViewI($player, $items, $args, $text)));
		}
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
	 * Push an item to your mount.
	 * @param SR_Player $player
	 * @param array $args
	 * @return boolean
	 */
	private static function on_push(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		$mount = $player->getMount();
		
		array_shift($args);
		
		# Item
		$itemname = array_shift($args);
		if (false === ($item = $player->getInvItem($itemname)))
		{
			self::rply($player, '1029');
// 			$bot->reply('You don\'t have that item.');
			return false;
		}
		$itemname = $item->getItemName();

		# Is Storage Mount?
		if (0 >= ($max = $mount->getMountWeightB()))
		{
			self::rply($player, '1037');
// 			$bot->reply(sprintf('You cannot store items in your %s.', $mount->getName()));
			return false;
		}
		
		# Amt
		$amt = isset($args[0]) ? intval(array_shift($args)) : 1;
		if ($amt < 1)
		{
			self::rply($player, '1038');
// 			$bot->reply('Please store a positive amount of items.');
			return false;
		}
		
		# Is mount in mount?
		if ($item instanceof SR_Mount)
		{
			self::rply($player, '1039', array($mount->getName()));
// 			$bot->reply(sprintf('You cannot put mounts in your %s.', $mount->getName()));
			return false;
		}
		
		# Make sure we have enough items in invemtory.
		# N.B.: $have_amt/$items2 is used later on!
		if ($item->isItemStackable())
		{
			$have_amt = $item->getAmount();
			if ($amt > $have_amt)
			{
				self::rply($player, '1040', array($item->getItemName()));
// 				$bot->reply(sprintf('You have not that much %s.', $item->getItemName()));
				return false;
			}
		}
		else
		{
			$items2 = $player->getInvItems($item->getItemName(), $amt);
			if (count($items2) < $amt)
			{
				self::rply($player, '1040', array($item->getItemName()));
// 				$bot->reply(sprintf('You have not that much %s.', $item->getItemName()));
				return false;
			}
		}

		# Is room in mount?
		$iw = $item->getItemWeight() * $amt;
		$we = $mount->calcMountWeight();
		if ( ($iw + $we) > $max )
		{
			self::rply($player, '1041', array(
				$mount->getName(), Shadowfunc::displayWeight($we), Shadowfunc::displayWeight($max), 
				$amt, $item->getName(), Shadowfunc::displayWeight($iw))
			);
// 			$bot->reply(sprintf('Your %s(%s/%s) has no room for %d of your %s (%s).', $mount->getName(), Shadowfunc::displayWeight($we), Shadowfunc::displayWeight($max), $amt, $item->getName(), Shadowfunc::displayWeight($iw)));
			return false;
		}
		
		# A stackable?
		if ($item->isItemStackable())
		{
//			$have_amt = $item->getAmount();

			$item->useAmount($player, $amt);
			$item2 = SR_Item::createByName($item->getItemName(), $amt, true);
			$item2->saveVar('sr4it_uid', $player->getID());
			$player->putInMountInv($item2);
			$stored = $amt;
		}
		
		# Not stackable
		else
		{
//			$items2 = $player->getInvItems($item->getItemName(), $amt);

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
		
		self::rply($player, '5080', array($stored, $itemname, $mount->getName()));
// 		$message = sprintf('You stored %d of your %s in your %s.', $stored, $itemname, $mount->getName());
// 		return $player->message($message);
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
		
		array_shift($args);
		
// 		if (0 === ($cnt = count($args)))
// 		{
// 			return self::on_show($player, $args);
// 		}
// 		if ($cnt > 2)
// 		{
// 			return self::on_help($player, $args);
// 		}
		
		# Is Storage Mount?
		if (0 >= ($max = $mount->getMountWeight()))
		{
			self::rply($player, '1037');
// 			$bot->reply(sprintf('You cannot store items in your %s.', $mount->getName()));
			return false;
		}
		
		# GetItem
		$itemname = array_shift($args);
		if (false === ($item = $player->getMountInvItem($itemname)))
		{
			self::rply($player, '1042');
// 			$bot->reply('You don`t have that item in your mount.');
			return false;
		}
		$itemname = $item->getItemName();
		$amt = isset($args[0]) ? intval(array_shift($args)) : 1;
		$collected = 0;
		
		# Pre-Amt
		if ($amt <= 0)
		{
			self::rply($player, '1038');
// 			$bot->reply('Please pop a positve amount of items.');
			return false;
		}
		
		# Stack
		if ($item->isItemStackable())
		{
			$have_amt = $item->getAmount();
			if ($amt > $have_amt)
			{
				self::rply($player, '1043', array($itemname, $mount->getName()));
// 				$bot->reply(sprintf('You don\'t have that much %s in your %s.', $itemname, $mount->getName()));
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
			
// 			$player->giveItem($item2);
			$collected = $amt;
		}
		
		# NonStackable
		else
		{
			while (false !== ($item2 = $player->getMountInvItemByName($itemname)))
			{
				if (false !== $player->removeFromMountInv($item2))
				{
// 					if (false !== $player->giveItem($item2))
// 					{
						$collected++;
						if ($collected >= $amt)
						{
							break;
						}
// 					}
				}
			}
		}
		
// 		$player->updateInventory();
		
		$invid = -1;
		if (false !== ($invItem = $player->getInvItemByName($itemname)))
		{
			$invid = $invItem->getInventoryID();
		}
		return self::rply($player, '5081', array($collected, $itemname, $mount->getName(), $invid));
// 		$reply = sprintf('You collect %d %s from your %s and put it into your inventory.', $collected, $itemname, $mount->getName());

		// append inventory id if it can be determined
// 		$invItem = $player->getInvItemByName($itemname);
// 		if ($invItem !== false)
// 		{
// 			$reply .= sprintf(' Inventory ID: %d.', $invItem->getInventoryID());
// 		}
		
// 		return $bot->reply($reply);
	}
	
	private static function on_clean(SR_Player $player, array $args)
	{	
		if (count($args) !== 1)
		{
			return self::on_help($player, $args);
		}
		
		while (count($player->getMountInvItems()) > 0)
		{
			$item = $player->getMountInvItemByID(1);
			$player->removeFromMountInv($item);
// 			$player->giveItem($item);
		}
		
// 		$player->updateInventory();
		return self::rply($player, '5082');
// 		$player->message('You have cleaned your mount.');
// 		return true;
	}
}
?>
