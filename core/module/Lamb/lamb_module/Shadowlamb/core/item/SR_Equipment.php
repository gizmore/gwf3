<?php
abstract class SR_Equipment extends SR_Usable
{
	public function isItemStackable() { return false; }
	public function isItemStattable() { return true; }
	public function getItemDuration() { return 3600*24*60; } # 60 days
	
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
		return $player->unequip($this);
	}
	
	public function onItemEquip(SR_Player $player)
	{
		if (false !== ($error = Shadowfunc::checkRequirements($player, $this->getItemRequirements())))
		{
			$player->message($error);
			return false;
		}
		
		if ($this->isBroken())
		{
			$player->message(sprintf('Your %s is broken and needs to get repaired first.', $this->getItemName()));
			return false;
		}
		
		$msg = '';
		$busy = 0;
		$type = $this->getItemType();
		$combat = $player->isFighting();
		
		# Unequip first
		if ($player->hasEquipment($type))
		{
			$item = $player->getEquipment($type);
			$msg .= 'You put your '.$item->getItemName().' into the inventory. ';
			$player->unequip($item, false);
			$busy += $combat === true ? 15 : 0;
		}
		
		# Equip
		$player->equip($this);
		$msg .= sprintf('You use %s as %s from now on.', $this->getItemName(), $type);
		$busy += $combat === true ? $this->getItemUsetime() : 0;
		
		if ($busy > 0)
		{
			$busy = $player->busy($busy);
			$msg .= sprintf(' %s busy.', GWF_Time::humanDuration($busy));
		}
		$player->modify();
		$player->setOption(SR_Player::EQ_DIRTY|SR_Player::INV_DIRTY|SR_Player::STATS_DIRTY);
		$player->message($msg);
		return true;
	}
	
	public function onItemUse(SR_Player $player, array $args)
	{
		$c = Shadowrun4::SR_SHORTCUT;
		$player->message('This equipment has no special usage. You can equip it with '.$c.'equip.');
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