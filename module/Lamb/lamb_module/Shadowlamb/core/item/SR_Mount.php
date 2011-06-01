<?php
abstract class SR_Mount extends SR_Equipment
{
	######################
	### Abstract Mount ###
	######################
	public function getMountWeight() { return 0; } # How much gramm can the mount carry
	public function getMountPassengers() { return 1; } # How much passengers for reducing goto timer
	public function getMountLockLevel() { return 0; } # Lock level against lockpickers
	public function getMountTime($eta) { return $eta; } # Reduce goto timer
	
	private $mount_inv_weight = -1;
	public function calcMountWeight()
	{
		$this->mount_inv_weight = 0.0;
		$items = $this->getOwner()->getMountInvItems();
		foreach ($items as $item)
		{
			$this->mount_inv_weight += $item->getItemWeightStacked();
		}
		return $this->mount_inv_weight;
	}

	############
	### Item ###
	############
	public function displayType() { return 'Mount LOCK '.$this->getMountLockLevel(); }
	public function displayWeight()
	{
		if (0 == ($max = $this->getMountWeight()))
		{
			return '';
		}
		
		$player = $this->getOwner();
		
		if ( ($player !== false) && ($this->isEquipped($player)) )
		{
			$weight = $this->calcMountWeight($player);
			return sprintf('%s/%s', Shadowfunc::displayWeight($weight), Shadowfunc::displayWeight($max));
		}
		else 
		{
			return sprintf('%s', Shadowfunc::displayWeight($max));
		}
	}
	public function getItemType() { return 'mount'; }
	public function getItemWeight() { return 0; }
	public function getItemUsetime() { return 10; }
	public function isItemStattable() { return false; }
	public function getItemModifiers(SR_Player $player) { return array(); }
	public function onItemEquip(SR_Player $player)
	{
		if ($player->getMountInvItemCount() > 0)
		{
			$player->message('Your mount has to be empty to change it. Try #mount unload.');
			return false;
		}
		return parent::onItemEquip($player);
	}
	
	public function onItemUnequip(SR_Player $player)
	{
		if ($player->getMountInvItemCount() > 0)
		{
			$player->message('Your mount has to be empty to change it. Try #mount unload.');
			return false;
		}
		return parent::onItemUnequip($player);
	}
}
?>