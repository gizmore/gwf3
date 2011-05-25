<?php
class SR_SearchRoom extends SR_Location
{
	public function isLocked() { return false; } 
	public function getLockLevel() { return 0.0; } # 0.0-10.0
	public function onCrackLockFailed(SR_Player $player) { $player->message('Your party members tried to crack the lock, but failed.'); }
	public function onCrackedLock(SR_Player $player, SR_Player $cracker) { $player->getParty->message($cracker, ' cracked the lock!'); }
	
	public function isSearchable() { return true; }
	public function getSearchMaxAttemps() { return 2; }
	public function getSearchLevel() { return 0; }
	
	public function getCommands(SR_Player $player)
	{
		$back = array();
		if ($this->isSearchable())
		{
			$back[] = 'search';
		}
		return $back;
	}
	
	##############
	### Search ###
	##############
	private function getTempKey()
	{
		return $this->getName().'_search__';
	}
	
	public function on_search(SR_Player $player, array $args)
	{
		$key = $this->getTempKey();
		$attemp = $player->getTemp($key, 0);
		
		if ($attemp >= $this->getSearchMaxAttemps())
		{
			$player->message('Not again.');
			return;
		}
		
		$attemp++;
		$player->setTemp($key, $attemp);

		$loot = Shadowfunc::randLoot($player, $this->getSearchLevel());
		if (count($loot) > 0) {
			$player->message(sprintf('You search the %s...', $this->getName()));
			$player->giveItems($loot);
		} else {
			$player->message(sprintf('You search the %s... but find nothing.', $this->getName()));
		}
	}
	
	
	public function clearSearchCache(SR_Party $party)
	{
		$k = $this->getTempKey();
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$member->unsetTemp($k);
		}
	}
	
	#############
	### Locks ###
	#############
	private $LOCK = array();
	public function onReleaseLocks()
	{
		$this->LOCK = array();
	}
	
	public function onReleaseLock(SR_Party $party)
	{
		foreach ($party->getMembers() as $member)
		{
			unset($this->LOCK[$member->getID()]);
		}
	}
	
	public function onSetLock(SR_Party $party, $state=0)
	{
		foreach ($party->getMembers() as $member)
		{
			$this->onSetLockPlayer($player, $state);
		}
	}
	
	public function onSetLockPlayer(SR_Player $player, $state=0)
	{
		$this->LOCK[$player->getID()] = $state;
	}
	
	public function isLockOpen(SR_Party $party)
	{
		foreach ($party->getMembers() as $member)
		{
			if ($this->isLockOpenPlayer($member))
			{
				return true;
			}
		}
		return false;
	}

	public function isLockOpenPlayer(SR_Player $player)
	{
		$pid = $player->getID();
		return ( (isset($this->LOCK[$pid])) && ($this->LOCK[$pid] === 1) );
	}
	
	public function isLockClosedPlayer(SR_Player $player)
	{
		$pid = $player->getID();
		return ( (isset($this->LOCK[$pid])) && ($this->LOCK[$pid] === 0) );
	}
	
	#############
	### Enter ###
	############# 
	public function onCityEnter(SR_Party $party)
	{
		parent::onCityEnter($party);
		$this->clearSearchCache($party);
		$this->onReleaseLock($party);
	}
	
	public function onEnter(SR_Player $player)
	{
		if ($this->isLocked())
		{
			if (!$this->onEnterLocked($player))
			{
				return true;
			}
		}
		parent::onEnter($player);
	}

	##################
	### Crack Lock ###
	##################
	public function onEnterLocked(SR_Player $player)
	{
		$party = $player->getParty();
//		$members = $party->getMembers();
		if ($this->isLockOpen($party))
		{
			return true;
		}
		
		if (false === ($crackers = $this->onCrackLockInit($party)))
		{
			$this->onLocked($player);
			return false;
		}
		
		foreach ($crackers as $member)
		{
			if ($this->onCrackLock($player, $member))
			{
				return true;
			}
		}
		
		$this->onCrackLockFailed($player);
		
		return false;; 
	}
		
	private function onCrackLock(SR_Player $player, SR_Player $member)
	{
		$lvl = $this->getLockLevel();
		$loc = $member->get('lockpicking');
		
		$atk = Shadowfunc::diceFloat($loc, $loc * 2.0 + 1.0, 2);
		$def = Shadowfunc::diceFloat($lvl, $lvl * 1.5 + 2.0, 2);
		
		echo sprintf('%s tries to crack lock lvl %s with locpicking %s. DEF:%s ... ATK: %s', $member->getName(), $lvl, $loc, $def, $atk).PHP_EOL;
		
		if ($atk >= $def)
		{
			$this->onSetLockPlayer($member, 1);
			$this->onCrackedLock($player, $member);
		}
	}

	private function onCrackLockInit(SR_Party $party)
	{
		$crackers = array();
		foreach ($party->getMembers() as $member)
		{
			if (!$this->isLockClosedPlayer($member))
			{
				$crackers[] = $member;
				$this->onSetLockPlayer($member, 0);
			}
		}
		shuffle($crackers);
		return $crackers;
	}
}
?>