<?php
final class Shadowcleanup
{
	public static function cleanup()
	{
#		self::cleanupParties();
#		self::cleanupNPCs();
#		self::cleanupItems();
#		self::adjustKarmas();
	}

// 	private static function adjustKarmas()
// 	{
// 		$players = GDO::table('SR_Player');
// 		if (false === ($result = $players->select('sr4pl_id')))
// 		{
// 			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
// 			return false;
// 		}
		
// 		while (false !== ($row = $players->fetch($result, GDO::ARRAY_N)))
// 		{
// 			if (false === ($player = SR_Player::getByID($row[0])))
// 			{
// 				echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
// 			}
// 			else
// 			{
// 				if ($player->isHuman())
// 				{
// 					self::adjustKarma($player);
// 				}
// 			}
// 		}
		
// 		$players->free($result);
// 	}
	
// 	private static function adjustKarma(SR_Player $player)
// 	{
// 		$level = $player->getBase('level');
// 		$karma = ($level * ($level+1)) / 2;
		
// 		printf("Giving %s karma to %s (L%s).\n", $karma, $player->getName(), $level);
// 		$player->giveKarma($karma);
// 	}
	
	private static function cleanupParties()
	{
		$parties = GDO::table('SR_Party');
		
		if (false === ($result = $parties->select('sr4pa_id', 'sr4pa_id = 23387')))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		
		while (false !== ($row = $parties->fetch($result, GDO::ARRAY_N)))
		{
			self::cleanupParty($row[0]);
		}
		
		$parties->free($result);
		
	}
	
	private static function cleanupParty($partyid)
	{
		if (false === ($party = SR_Party::getByID($partyid, false)))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		
		if ($party->isHuman())
		{
			return true;
		}
		
		if ($party->getMemberCount() === 0)
		{
			echo "Deleted empty party!\n";
			$party->deleteParty();
			return true;
		}
		
		if ( $party->isIdle() || $party->isDeleting() )
		{
			echo "Deleted idle NPC party!\n";
			$party->deleteParty();
			return true;
		}
		
		return true;
	}

	private static function cleanupNPCs()
	{
		$players = GDO::table('SR_Player');
		if (false === ($result = $players->select('sr4pl_id', "sr4pl_classname != ''")))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		
		while (false !== ($row = $players->fetch($result, GDO::ARRAY_N)))
		{
			self::cleanupNPC($row[0]);
		}
		
		$players->free($result);
	}

	private static function cleanupNPC($player_id)
	{
		if (false === ($player = SR_Player::getByID($player_id)))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		
		if ($player->isHuman())
		{
			return true;
		}
		
		if (false === ($party = SR_Party::getByID($player->getPartyID(), false)))
		{
			printf("Deleting lonely NPC %s.\n", $player->getVar('sr4pl_classname'));
			$player->deletePlayer();
			return true;
		}
		
		if (false === $party->getMemberByPID($player_id))
		{
			printf("NPC is not in that party! deleting!\n", $player->getVar('sr4pl_classname'));
			$player->deletePlayer();
			return true;
		}
	}

	####################
	### Item cleanup ###
	####################
	private static function cleanupItems()
	{
		# Cleanup players
		$players = GDO::table('SR_Player');
		if (false === ($result = $players->select('sr4pl_id')))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		while (false !== ($row = $players->fetch($result, GDO::ARRAY_N)))
		{
			self::cleanupItemsForPlayer($row[0]);
		}
		$players->free($result);
		
		# Delete items without owner
		$items = GDO::table('SR_Item');
		$items->deleteWhere('sr4it_uid = 0');
		$numDeleted = $items->affectedRows();
		if ($numDeleted > 0)
		{
			printf("Deleted %d items without owner.\n", $numDeleted);
		}
		
		# Delete Items with deleted owner
		$ptab = $players->getTableName();
		$items->deleteWhere("IF((SELECT 1 FROM $ptab WHERE sr4pl_id=sr4it_uid), 0, 1)");
		$numDeleted = $items->affectedRows();
		if ($numDeleted > 0)
		{
			printf("Deleted %d items with deleted owner.\n", $numDeleted);
		}
	}
	
	private static function cleanupItemsForPlayer($player_id)
	{
		if (false === ($player = SR_Player::getByID($player_id)))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		
		$items = GDO::table('SR_Item');
		
		if (false === ($itemIDs = $items->selectColumn('sr4it_id', "sr4it_uid=$player_id")))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		
		foreach ($itemIDs as $itemID)
		{
			if (!self::hasItem($player, $itemID))
			{
				printf("Deleted lonely item %d for player %s.\n", $itemID, $player->getName());
				$items->deleteWhere("sr4it_id=$itemID");
			}
		}
	}
	
	private static function hasItem(SR_Player $player, $itemID)
	{
		$items = array_merge(
			$player->getAllEquipment(false),
			$player->getInventory(),
			$player->getBankItems(),
			$player->getMountInvItems(),
			$player->getCyberware()
		);
		
		foreach ($items as $item)
		{
			$item instanceof SR_Item;
			if ($item->getID() == $itemID)
			{
// 				printf("Found item :)\n");
				return true;
			}
		}
		
		return false;
	}
}
?>
