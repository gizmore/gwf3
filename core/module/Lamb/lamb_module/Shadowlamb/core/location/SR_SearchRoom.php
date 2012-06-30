<?php
abstract class SR_SearchRoom extends SR_Tower
{
	public function getAbstractClassName() { return __CLASS__; }
	
	public function isLocked() { return $this->getLockLevel() >= 0; } 
	public function getLockLevel() { return -1; } # 0.0-10.0
// 	public function onCrackLockFailed(SR_Player $player) { $player->message('Your party members tried to crack the lock, but failed.'); }
	public function onCrackLockFailed(SR_Player $player) { $player->msg('1149'); }
	public function onCrackedLock(SR_Player $player, SR_Player $cracker) { $player->getParty()->ntice('5187', array($cracker->getName())); }
	
	public function isSearchable() { return $this->getSearchLevel() >= 0; }
	public function getSearchMaxAttemps() { return 1; }
	public function getSearchLevel() { return -1; }
	public function getSearchLoot(SR_Player $player) { return array(); }
	public function getSearchChanceNone() { return 1.85; }
	
	public function getHelpText(SR_Player $player)
	{
		$back = '';
		if (count($this->getComputers()) > 0)
		{
			$back .= $player->lang('hlp_hack');# You can use a Cyberdeck here to hack into a computer.';
		}
		if ($this->isSearchable())
		{
			$back .= $player->lang('hlp_search'); # ' You can use #search here to search the room for items.';
		}
		return $back === '' ? false : substr($back, 1);
	}
	
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
			$player->msg('1148');
// 			$player->message('Not again.');
			return;
		}
		
		$attemp++;
		$player->setTemp($key, $attemp);

		$loot = array_merge(Shadowfunc::randLoot($player, $this->getSearchLevel(), array(), $this->getSearchChanceNone()), $this->getSearchLoot($player));
		
		if (count($loot) > 0)
		{
			$player->msg('5185', array($this->getName()));
// 			$player->message(sprintf('You search the %s...', $this->getName()));
			$player->giveItems($loot, 'searching '.$this->getName());
		}
		else
		{
			$player->msg('5186', array($this->getName()));
// 			$player->message(sprintf('You search the %s... But find nothing.', $this->getName()));
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
				return false;
			}
		}
		return parent::onEnter($player);
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
			$this->onCrackLockFailed($player);
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
		
		printf('%s tries to crack lock lvl %s with lockpicking %s. DEF:%s ... ATK: %s', $member->getName(), $lvl, $loc, $def, $atk).PHP_EOL;
		
		if ($atk >= $def)
		{
			$this->onSetLockPlayer($member, 1);
			$this->onCrackedLock($player, $member);
			return true;
		}
		else
		{
			$this->onSetLockPlayer($member, 0);
			return false;
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
