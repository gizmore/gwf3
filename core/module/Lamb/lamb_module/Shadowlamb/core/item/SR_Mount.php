<?php
abstract class SR_Mount extends SR_Equipment
{
	# Times to hijack a mount, if time elapsed we roll a dice.
	const HIJACK_TIME_MIN = 140; 
	const HIJACK_TIME_MAX = 900;
	const HIJACK_TIME_MAXLVL = 50; # And the level is a percentage in between like 1/50*900.
	const HIJACK_TIME_BONUS = 20; # - 20 sec rand.
	const HIJACK_TIME_ADD = 30; # And for every attemp we add N seconds ...
	const HIJACK_TIME_MULTI = 1.5; # and afterwards multiply by N.
	const HIJACK_BAD_KARMA = 0.07; # Bad karma for trying.
	const HIJACK_POLIZIA = 10.0; # Chance polizia in percent.
	
	# Hijack dice
	
	######################
	### Abstract Mount ###
	######################
	public function getMountWeight() # How much gramm can the mount carry
	{
		return $this->getOwner()->get('transport') * 1000;
// 		$mods = $this->getItemModifiersA($this->getOwner());
// 		return isset($mods['transport']) ? $mods['transport'] * 1000 : 0;
	} 
	public function getMountPassengers() { return 1; }  # How much passengers for reducing goto timer
	public function getMountLockLevel() { return 0; }   # Lock level against lockpickers
	public function getMountTime($eta) { return $eta; } # Reduce goto timer
	
	public function getItemEquipTime() { return 30; }
	public function getItemUnequipTime() { return 30; }
	
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
	public function displayType() { return 'Mount'; } #LOCK '.$this->getMountLockLevelB(); }
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
	public function onItemEquip(SR_Player $player)
	{
		if ($player->getMountInvItemCount() > 0)
		{
			$player->msg('1164');
// 			$player->message('Your mount has to be empty to change it. Try #mount clean.');
			return false;
		}
		return parent::onItemEquip($player);
	}
	
	public function onItemUnequip(SR_Player $player)
	{
		if ($player->getMountInvItemCount() > 0)
		{
			$player->msg('1164');
// 			$player->message('Your mount has to be empty to change it. Try #mount clean.');
			return false;
		}
		return parent::onItemUnequip($player);
	}
	
	##############
	### Hijack ###
	##############
	/**
	 * Init a hijack. Call hijack by.
	 * @param SR_Player $player
	 */
	public function initHijackBy(SR_Player $player)
	{
// 		$player->setConst('_SL4_HIJACK', 0);
		$eta = $this->calcHijackTime($player);
		$player->msg('5218', array($this->getOwner()->getName(), $this->getName(), GWF_Time::humanDuration($eta)));
// 		$player->message(sprintf('You start to to crack the lock on %s\'s %s. Time penalty: %s', $this->getOwner()->getName(), $this->getName(), GWF_Time::humanDuration($eta)));
		return $this->hijackBy($player, $eta);
	}
	
	public function hijackBy(SR_Player $player, $eta)
	{
		# Give bad karma for trying.
		SR_BadKarma::addBadKarma($player, self::HIJACK_BAD_KARMA);
	
		# Announce to owner.
		if (false === ($owner = $this->getOwner()))
		{
			return false;
		}
		$owner->msg('5219', array($player->getName(), $this->getName()));
// 		$owner->message(sprintf("%s is trying to \X02crack the LOCK\X02 on your %s!", $player->getName(), $this->getName()));
		
		$party = $player->getParty();
		if (false === ($loc = $party->getLocation()))
		{
			return false;
		}
		
		if (false === $this->onHijackAttempt($player))
		{
			$eta = $this->calcHijackTime($player);
			$party->pushAction(SR_Party::ACTION_HIJACK, $this->getOwner()->getName().' at '.$loc, $eta);
		}

		return true;
	}
	
	private function onHijackAttempt(SR_Player $player)
	{
		# The bro has to master 3 skills.
		$thief = max(array($player->get('thief'), 0));
		$locpic = max(array($player->get('lockpicking'), 0));
		$elec = max(array($player->get('electronics'), 0));
		
		# The mounts LOCK level + cracking attempt.
		$lock = $this->getMountLockLevelB();
		// 		$attempt = $player->getConst('_SL4_HIJACK') + 1;
		
		# Dice!
		$atkmin = 0;     $atkmax = $locpic + $elec + $thief;
		$defmin = $lock; $defmax = $lock * 1.5 + 1.0;
		$atk = Shadowfunc::diceFloat($atkmin, $atkmax);
		$def = Shadowfunc::diceFloat($defmin, $defmax);
		if ($atk >= $def)
		{
			$this->onHijacked($player); # Success!
		}
		else
		{
			if ($this->onHijackPolizia($player))
			{
				return true; # Polizia!
			}
			$player->msg('5220', array($this->getOwner()->getName(), $this->getName()));
// 			$player->message(sprintf('You failed to crack the lock on %s\'s %s.', $this->getOwner()->getName(), $this->getName()));
// 			$this->hijackBy($player, $eta);
		}
		return false;
	}
	
	/**
	 * Do one hijack attempt.
	 * @param SR_Player $player
	 */
	public function onHijack(SR_Player $player)
	{
		$p = $player->getParty();
		return $p->ntice('5221');
// 		return $p->notice("You are done with cracking your target's lock.");
	}
	
	/**
	 * Hijacker got caught by polizia!
	 * @param SR_Player $player
	 */
	private function onHijackPolizia(SR_Player $player)
	{
		if (!Shadowfunc::dicePercent(self::HIJACK_POLIZIA))
		{
			return false; # No polizia.
		}
		$p = $player->getParty();
		$p->ntice('5222');
// 		$p->notice('"Hey, what are you doing!!!" ... You spot a police officer approaching!');
		SR_NPC::createEnemyParty('Seattle_BlackOp')->fight($p);
		return true;
	}
	
	/**
	 * Calculate the time needed for a hijack attempt.
	 * @param SR_Player $player
	 * @return int seconds
	 */
	public function calcHijackTime(SR_Player $player)
	{
		$thief = $player->get('thief');
		$locpic = $player->get('lockpicking');
		$lock = $this->getMountLockLevelB();
		$lockB = $lock + 5 - $thief - $locpic;
		
		$min = SR_Mount::HIJACK_TIME_MIN + $lockB * 10;
		$max = SR_Mount::HIJACK_TIME_MAX + $lockB * 40;
		
		$rand = rand($min, $max);
		
		return Common::clamp($rand, SR_Mount::HIJACK_TIME_MIN);
	}
	
	/**
	 * Hijack success!
	 * @param SR_Player $player The hijacker
	 */
	private function onHijacked(SR_Player $player)
	{
		$party = $player->getParty();
		$party->pushAction('outside', $party->getLocation());
		
		$owner = $this->getOwner();
		$oname = $owner->getName();
		$mname = $this->getName();
		
		$items = $owner->getMountInvItems();
		
		
		if (count($items) === 0)
		{
			$player->msg('5223', array($oname, $mname));
// 			$player->message(sprintf('You managed to crack the lock on %s\'s %s but it seems empty.', $this->getOwner()->getName(), $this->getName()));
			return true;
		}
		
		$player->msg('5224', array($oname, $mname));
		$player->msg('5225', array($player->getName(), $mname));
		
		$item = $items[array_rand($items, 1)];
		$item instanceof SR_Item;
		$iname = $item->getItemName();
		if (false === $item->isItemDropable())
		{
			$player->msg('5226'); # In the last second you see military forces approaching and decide to interrupt your activities.
			return true;
		}
		
		if (false === $owner->removeFromMountInv($item))
		{
			$player->message('Database error 4!');
			return false;
		}
		
		$player->giveItems(array($item), "hijacking {$oname}");
// 		$player->message(sprintf('You managed to crack the lock on %s\'s %s and stole a %s.', $this->getOwner()->getName(), $this->getName(), $item->getItemName()));

		
		$owner->msg('5227', array($pname, $item->getAmount(), $iname, $oname));
// 		$owner->message(sprintf('%s stole %dx%s out of your %s.', $player->getName(), $item->getItemName(), $this->getName()));
		
		return true;
	}
}
?>
