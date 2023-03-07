<?php
require_once 'SR_Usable.php';

abstract class SR_Equipment extends SR_Usable
{
	public function isItemStackable() { return false; }
	public function isItemStattable() { return true; }
	public function getItemDuration() { return 3600*24*60; } # 60 days
	
	public function getItemEquipTime() { return 60; }
	public function getItemUnequipTime() { return 60; }
		
	public function isEquipped(SR_Player $player)
	{
		$type = $this->getItemType();
		if (!$player->hasEquipment($type)) {
			return false;
		}
		if (false === ($item = $player->getEquipment($type))) {
			return false;
		}
		return $item->getID() === $this->getID();
	}
	
	public function onItemUnequip(SR_Player $player)
	{
		return $player->unequip($this, true);
	}
	
	public function onItemEquip(SR_Player $player)
	{
		if (false !== ($error = Shadowfunc::checkRequirements($player, $this->getItemRequirements())))
		{
			$player->message($error);
			return false;
		}
		
// 		if ($this->isBroken())
// 		{
// 			die('HEHE AZBY');
// // 			$player->msg('', array());
// // 			$player->message(sprintf('Your %s is broken and needs to get repaired first.', $this->getItemName()));
// 			return false;
// 		}
		
		$type = $this->getItemType();
		$combat = $player->isFighting();
		$unequipped = NULL;
		
		# Unequip first
		if ($player->hasEquipment($type))
		{
			$unequipped = $player->getEquipment($type);
			if (false === $player->unequip($unequipped, false))
			{
				return false;
			}
		}
		
		# Equip
		if (false === $player->equip($this))
		{
			return false;
		}
		
		# Announce
		$type = $this->displayEquipmentType($player);
		$unam = $unequipped !== NULL ? $unequipped->displayFullName($player) : NULL;
		$fnam = $this->displayFullName($player);
		if ($combat)
		{
			$busy = $player->busy($this->getItemEquipTime());
			if ($unequipped !== NULL)
			{
				$player->msg('5267', array($unam, $fnam, $type, $busy));
			}
			else
			{
				$player->msg('5268', array($fnam, $type, $busy));
			}
			
			# Additional combat announce
			$this->announceEquipChange($player, $unam, $fnam, $type, $busy);
		}
		else
		{
			if ($unequipped !== NULL)
			{
				$player->msg('5269', array($unam, $fnam, $type));
			}
			else
			{
				$player->msg('5270', array($fnam, $type));
			}
		}
		
		$player->modify();
		$player->healHP(0);
		$player->healMP(0);
		
// 		$player->setOption(SR_Player::EQ_DIRTY|SR_Player::INV_DIRTY|SR_Player::STATS_DIRTY);
		
		return true;
	}
	
	private function announceEquipChange(SR_Player $player, $unam, $fnam, $type, $busy)
	{
		$pnam = $player->getName();
		
		$p = $player->getParty();
		$ep = $p->getEnemyParty();
		
		if ($unam !== NULL)
		{
			$args = array($pnam, $unam, $fnam, $type, $busy);
			$p->ntice('5271', $args, $player);
			$ep->ntice('5271', $args);
		}
		else
		{
			$args = array($pnam, $fnam, $type, $busy);
			$p->ntice('5272', $args, $player);
			$ep->ntice('5272', $args);
		}
		
		return true;
	}
	
	
	public function onItemUse(SR_Player $player, array $args)
	{
		$player->msg('1155');
// 		$player->message('This equipment has no special usage. You can equip it with '.$c.'equip.');
		return false;
	}
}

/**
 * Always statted, like ring etc
 * @author gizmore
 */
abstract class SR_StattedEquipment extends SR_Equipment
{
	public function getItemDuration() { return 3600*24*120; } # 60 days
}

?>
