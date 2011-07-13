<?php
abstract class SR_Mount extends SR_Equipment
{
	# Times to hijack a mount, if time elapsed we roll a dice.
	const HIJACK_TIME_MIN = 120; 
	const HIJACK_TIME_MAX = 300;
	const HIJACK_TIME_MAXLVL = 100; # And the level is a percentage in between like 280.
	const HIJACK_TIME_BONUS = 20; # - 20 sec rand.
	const HIJACK_TIME_ADD = 30; # And for every attemp we add N seconds ...
	const HIJACK_TIME_MULTI = 1.5; # and afterwards multiply by N.
	
	# Hijack dice
	
	
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

	public function getMountWeightB()
	{
		if (0 >= ($max = $this->getMountWeight()))
		{
			return 0;
		}
		$mods = $this->getItemModifiersB();
		$trans = isset($mods['transport']) ? $mods['transport'] : 0;
		return $max + ($trans*1000);
	}
	
	public function getMountLockLevelB()
	{
		$lock = $this->getMountLockLevel();
		$mods = $this->getItemModifiersB();
		$lock2 = isset($mods['lock']) ? $mods['lock'] : 0;
		return $lock + $lock2;
	}
	
	public function getMountTuneup()
	{
		$mods = $this->getItemModifiersB();
		return isset($mods['tuneup']) ? $mods['tuneup'] : 0;
	}
	
	############
	### Item ###
	############
	public function displayType() { return 'Mount LOCK '.$this->getMountLockLevelB(); }
	public function displayWeight()
	{
		if (0 == ($max = $this->getMountWeightB()))
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
	
	##############
	### Hijack ###
	##############
	public function initHijackBy(SR_Player $player)
	{
		$player->setConst('_SL4_HIJACK', 0);
		$eta = $this->calcHijackTime($player);
		$player->message(sprintf('You start to to crack the lock on %s\'s %s. ETA: %s', $this->getOwner()->getName(), $this->getName(), GWF_Time::humanDuration($eta)));
		return $this->hijackBy($player, $eta);
	}
	
	public function hijackBy(SR_Player $player, $eta)
	{
		$party = $player->getParty();
		if (false === ($loc = $party->getLocation()))
		{
			return false;
		}
		return $party->pushAction(SR_Party::ACTION_HIJACK, $this->getOwner()->getName().' at '.$loc, $eta);
	}
	
	public function onHijack(SR_Player $player)
	{
		$attemp = $player->getConst('_SL4_HIJACK') + 1;
		$thief = $player->get('thief');
		$locpic = $player->get('lockpicking');
		$lock = $this->getMountLockLevelB();

		$atk = Shadowfunc::diceFloat($locpic, $locpic * 2.0 + 1.0, 2);
		$def = Shadowfunc::diceFloat($lock, $lock * 1.5 + 4.0 + $attemp, 2);
		
		if ($atk >= $def)
		{
			$this->onHijacked($player);
		}
		else
		{
			$eta = $this->calcHijackTime($player);
			$player->message(sprintf('You failed to crack the lock on %s\'s %s. You try again. ETA: %s', $this->getOwner()->getName(), $this->getName(), GWF_Time::humanDuration($eta)));
			$player->getParty()->popAction(false);
			$this->hijackBy($player, $eta);
		}
	}
	
	public function calcHijackTime(SR_Player $player)
	{
		$thief = $player->get('thief');
		$locpic = $player->get('lockpicking');
		$lock = $this->getMountLockLevelB();
		$lockB = $lock + 5 - $thief - $locpic;
		
//		$pl = Common::clamp(round($thief + $locpic, 2), 0, self::HIJACK_TIME_MAXLVL);
//		$pl = 1 - ($pl / self::HIJACK_TIME_MAXLVL);
//		$pl += $lock / 10;
		
		$min = SR_Mount::HIJACK_TIME_MIN + $lockB * 10;
		$max = SR_Mount::HIJACK_TIME_MAX + $lockB * 40;
//		$rng = $max - $min;
		
		$rand = rand($min, $max);
		
		return Common::clamp($rand, SR_Mount::HIJACK_TIME_MIN);
//		return round($rng * $pl + $min - rand(0, self::HIJACK_TIME_BONUS));
	}
	
	private function onHijacked(SR_Player $player)
	{
		$party = $player->getParty();
		$party->pushAction('outside', $party->getLocation());
		
		$owner = $this->getOwner();
		$items = $owner->getMountInvItems();
		if (count($items) > 0)
		{
			$item = $items[array_rand($items, 1)];
			$player->message(sprintf('You managed to crack the lock on %s\'s %s and stole a %s.', $this->getOwner()->getName(), $this->getName(), $item->getItemName()));
			$player->giveItems(array($item), 'hijacking '.$owner->getName());
			$owner->message(sprintf('%s stole a %s out of your %s.', $player->getName(), $item->getItemName(), $this->getName()));
		}
			
		$player->message(sprintf('You managed to crack the lock on %s\'s %s but it seems empty.', $this->getOwner()->getName(), $this->getName()));
		
		return true;
	}
}
?>