<?php
abstract class SR_City
{
	private $name = '';
	private $npcs = array();
	private $locations = array();
	
	public abstract function getArriveText();
	
	public function __construct($name) { $this->name = $name; }
	public function getName() { return $this->name; }
	public function getSquareKM() { return sqrt(count($this->locations) * 2) + 1; }
	public function getRespawnLocation(SR_Player $player) { return 'Redmond_Hotel'; }
	public function onEvents(SR_Party $party) { return false; }
	public function getImportNPCS() { return array(); }
	public function isDungeon() { return false; }
	public function getGotoTime() { return $this->getSquareKM() * 38; }
	public function getGotoETA(SR_Party $party) { return $this->calcETA($party, $this->getGotoTime()); }
	public function getExploreTime() { return $this->getSquareKM() * 45; }
	public function getExploreETA(SR_Party $party) { return $this->calcETA($party, $this->getExploreTime()); }
	
	private function calcETA(SR_Party $party, $eta=60, $tpq=1.0, $mintime=5, $randtime=10)
	{
		$mount = $party->getBestMount();
		$eta = $mount->getMountTime($eta);
		$eta -= ($mount->getMountTuneup() * 10);
		$eta += rand(0, $randtime);
		$eta = Common::clamp(round($eta), $mintime);
		return $eta;
	}
	
	public function initNPCS($filename, $fullpath)
	{
		$name = substr($filename, 0, -4);
		$classname = "{$this->name}_{$name}";
		Lamb_Log::logDebug("Loading NPC $classname...");
		SR_NPC::$NPC_COUNTER++;
		require_once $fullpath;
		$npc = new $classname(false);
		$npc->setNPCClassName($classname);
		$this->npcs[$classname] = $npc;
	}
	
	public function initLocations($filename, $fullpath)
	{
		$name = substr($filename, 0, -4);
		$classname = "{$this->name}_{$name}";
		Lamb_Log::logDebug("Loading Location $classname...");
		SR_Location::$LOCATION_COUNT++;
		require_once $fullpath;
		$location = new $classname($classname);
		$this->locations[strtolower($name)] = $location;
	}
	
	public function onInit()
	{
		foreach ($this->getImportNPCS() as $classname)
		{
			$this->npcs[$classname] = Shadowrun4::getNPC($classname);
		}
	}
	
	/**
	 * Get a location in this city by Full_Name
	 * @param $name
	 * @return SR_Location
	 */
	public function getLocation($name)
	{
		$name = str_replace(strtolower($this->getName()).'_', '', strtolower($name));
		return isset($this->locations[$name]) ? $this->locations[$name] : false;
	}
	
	/**
	 * Get an NPC class from this city.
	 * @param string $name
	 * @return SR_NPC
	 */
	public function getNPC($name)
	{
		return isset($this->npcs[$name]) ? $this->npcs[$name] : false;
	}
	
	#############
	### Timer ###
	#############
	public function onArrive(SR_Party $party)
	{
		$party->notice($this->getArriveText());
		$this->onCityEnter($party);
	}
	
	public function onCityEnter(SR_Party $party)
	{
		foreach ($this->locations as $location)
		{
			$location instanceof SR_Location;
			$location->onCityEnter($party);
		}
	}
	
	public function onExplore(SR_Party $party, $done)
	{
		if ($done === true)
		{
			$this->onExplored($party);
		}
		else
		{
			$this->cityMovement($party);
		}
	}
	
	public function onGoto(SR_Party $party, $done)
	{
		if ($done === true)
		{
			$this->onWentTo($party);
		}
		else
		{
			$this->cityMovement($party);
		}
	}
	
	public function onHunt(SR_Party $party, $done)
	{
		if ($done === true)
		{
			$this->onHunted($party);
		}
		elseif (!$this->hasLostHuntTarget($party))
		{
			$this->cityMovement($party);
		}
	}
	
	public function onHijack(SR_Party $party, $done)
	{
		# Still have valid target?
		if (
			(false === ($target = $party->getHijackTarget())) ||
			($target->getParty()->getLocation('inside') !== $party->getLocation())
		)
		{
			$party->notice('Your target for hijacking ('.$party->getTarget().') gone away.');
			$party->pushAction('outside', $party->getLocation());
			return false;
		}
		
		# Time over?
		if ($done)
		{
			$party->pushAction('outside', $party->getLocation());
			$target->getMount()->onHijack($party->getLeader());
			return true;
		}
	}
	
	private function hasLostHuntTarget(SR_Party $party)
	{
		if (false === ($target = $party->getHuntTarget())) {
			
		}
		elseif ($target->getParty()->getCity() !== $party->getCity()) {
			$party->notice(sprintf('%s has left %s.', $target->getName(), $party->getCity()));
		}
		elseif ($target->getPartyID() === $party->getID()) {
			$party->notice(sprintf('%s is in your party now.', $target->getName()));
		}
		else {
			return false;
		}
		
		$this->onLostHuntTarget($party);
		return true;
	}
	
	private function onExplored(SR_Party $party)
	{
		$cityname = $this->getName();
		$leader = $party->getLeader();
		$total = 0;
		$possible = array();
		foreach ($this->locations as $l)
		{
			$l instanceof SR_Location;
			$n = $l->getName();
			if ($leader->hasKnowledge('places', $n)) {
				continue;
			}
			$perc = round($l->getFoundPercentage()*100);
			$total += $perc;
			$possible[] = array($l, $perc);
		}
		
		if (count($possible) === 0) {
			$party->notice(sprintf('You explored %s again, but it seems you know every single corner of it.', $cityname));
			$party->pushAction(SR_Party::ACTION_OUTSIDE, $cityname, 0);
		}
		elseif (false === ($l = Shadowfunc::randomData($possible, $total, 500))) {
			$party->notice(sprintf('You explored %s again, but can not find anything new.', $cityname));
			$party->pushAction(SR_Party::ACTION_OUTSIDE, $cityname, 0);
		}
		else {
			$n = $l->getName();
			$party->giveKnowledge('places', $n);
			$party->notice($l->getFoundText($leader));
			$leader->help('When you find locations, you are outside of them. Use #goto or #enter to enter them.');
			$party->pushAction(SR_Party::ACTION_OUTSIDE, $n);
		}
	}
	
	private function onWentTo(SR_Party $party)
	{
		$target = $party->getTarget();
		$location = $this->getLocation($target);
		$party->giveKnowledge('places', $target);
		$party->pushAction(SR_Party::ACTION_OUTSIDE, $target);
		$location->onEnter($party->getLeader());
		
		# TODO: Announce it!
	}
	
	private function onLostHuntTarget(SR_Party $party)
	{
		$loc = $party->getCity();
		$party->notice(sprintf('You have lost your target and continue in the streets of %s.', $loc));
		$party->pushAction(SR_Party::ACTION_OUTSIDE, $loc);
	}
	
	private function onHunted(SR_Party $party)
	{
		if (false === ($target = $party->getHuntTarget()))
		{
			$this->onLostHuntTarget($party);
			return;
		}
		
		$ep = $target->getParty();
		switch ($ep->getAction())
		{
			case SR_Party::ACTION_OUTSIDE:
			case SR_Party::ACTION_SLEEP:
			case SR_Party::ACTION_INSIDE:
				$loc = $ep->getLocation();
				$party->giveKnowledge('places', $loc);
				$party->notice(sprintf('You found %s at %s with a party of %s members.', $target->getName(), $loc, $ep->getMemberCount()));
				$party->pushAction(SR_Party::ACTION_OUTSIDE, $loc);
				break;
			case SR_Party::ACTION_EXPLORE:
			case SR_Party::ACTION_GOTO:
			case SR_Party::ACTION_HUNT:
				$loc = $party->getCity();
				$party->notice(sprintf('You found %s in the streets of %s.', $target->getName(), $loc));
				$party->pushAction(SR_Party::ACTION_OUTSIDE, $loc);
				$party->talk($ep, true);
				break;
				
			case SR_Party::ACTION_TALK:
			case SR_Party::ACTION_FIGHT:
				$party->setETA(rand(10, 30));
				$party->setContactEta(rand(5, 20));
				break;
			
			case SR_Party::ACTION_DELETE:
			case SR_Party::ACTION_TRAVEL:
				$this->onLostHuntTarget($party);
				break;
		}
	}
	
	/**
	 * Dice City Movement.
	 * @param SR_Party $party
	 * return boolean
	 */
	private function cityMovement(SR_Party $party)
	{
		if (!$party->canMeetEnemies())
		{
			return false;
		}
		
		$b = false;
		
		switch (rand(1, 6))
		{
			case 1:
				$b = $this->partyContact($party);
				break;
				
			case 2:
				$b = $this->enemyContact($party, false);
				break;
			
			case 3:
				$b = $this->enemyContact($party, true);
				break;
				
			case 4:
				$b = $this->onEvents($party);
				break;
		}
		
		return $b;
	}
	
	private function partyContact(SR_Party $p)
	{
		if (rand(0, 20) > 0) # 0 ok, 1-4 fail
		{
			return false; # fail
		}
		
		foreach (Shadowrun4::getParties() as $ep)
		{
			if ( ($ep->isMoving()) && ($p->getCity() === $ep->getCity()) && ($ep->getID() !== $p->getID()) )
			{
				$p->talk($ep, true);
				return true;
			}
		}
		return false;
				
//		$sqkm = $this->getSquareKM();
//		$possible = array();
//		$total = 0;
//		$total_sqkm = $sqkm * 3; // total slots in city
//		
//		foreach (Shadowrun4::getParties() as $ep)
//		{
//			if ( ($ep->isMoving()) && ($p->getCity() === $ep->getCity()) && ($ep->getID() !== $p->getID()) )
//			{
////				$total += 50;
////				$possible[] = array($ep, 50);
//				$possible[] = array($ep, 1);
//			}
//		}
//		
////		$chance_none = $sqkm * 30 - count($possible);
////		$chance_none = Common::clamp($chance_none, 50);
//		
//		$chance_none = $total_sqkm - count($possible);
//		$chance_none = Common::clamp($chance_none, round($sqkm*2.5)); // at least N empty slots
//		
//		if (false === ($ep = Shadowfunc::randomData($possible, $total, $chance_none))) {
//			return false;
//		}
//		
//		$p->talk($ep, true);
//		
//		return true;
	}
	
	private function enemyContact(SR_Party $party, $friendly=false)
	{
		$dice = $friendly ? 7 : 6;
		if (rand(1, $dice) !== 1)
		{
			return false;
		}
		$mc = $party->getMemberCount();
		$level = $party->getMax('level');
		
		$possible = array();
		$total = 0;
		foreach ($this->npcs as $npc)
		{
			$npc instanceof SR_NPC;
			if ( ($npc->getNPCLevel() <= $level) && ($npc->isNPCFriendly($party)===$friendly) && ($npc->canNPCMeet($party)) )
			{
				$multi = $friendly === true ? 100 : 100;
				$percent = round($npc->getNPCMeetPercent($party) * $multi);
				$total += $percent;
				$possible[] = array($npc->getNPCClassName(), $percent);
			}
		}
		
		$npcs = array();
		$x = 200;
		do 
		{
			$contact = false;
			
			if (false !== ($npc = Shadowfunc::randomData($possible, $total, $x*100)))
			{
				$contact = true;
				$npcs[] = $npc;
				$x += 100;
			}
			
			if (count($npcs) >= ($mc+1)) {
				break;
			}
		}
		while ($contact === true);
		
		if (count($npcs) === 0) {
			return false;
		}

		$ep = SR_NPC::createEnemyParty($npcs);
		if ($friendly === true) {
			$party->talk($ep, true);
		}
		else {
			$party->fight($ep, true);
		}
		
		return true;
	}
}
?>
