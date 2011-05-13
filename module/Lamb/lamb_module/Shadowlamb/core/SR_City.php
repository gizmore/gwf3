<?php
abstract class SR_City
{
	private $name = '';
	private $npcs = array();
	private $locations = array();
	
	public abstract function getArriveText();
	
	public function __construct($name) { $this->name = $name; }
	public function getName() { return $this->name; }
	public function getSquareKM() { return sqrt(count($this->locations) * 2); }
	public function getExploreETA() { return $this->getSquareKM() * 30; }
	public function getGotoETA() { return $this->getSquareKM() * 25; }
	public function getRespawnLocation() { return 'Redmond_Hotel'; }
	
	public function initNPCS($filename, $fullpath)
	{
		$name = substr($filename, 0, -4);
		$classname = "{$this->name}_{$name}";
		Lamb_Log::log("Loading NPC $classname...");
		require_once $fullpath;
		$npc = new $classname(false);
		$npc->setNPCClassName($classname);
		$this->npcs[$classname] = $npc;
	}
	
	public function initLocations($filename, $fullpath)
	{
		$name = substr($filename, 0, -4);
		$classname = "{$this->name}_{$name}";
		Lamb_Log::log("Loading Location $classname...");
		require_once $fullpath;
		$location = new $classname($classname);
		$this->locations[strtolower($name)] = $location;
	}
	
	public function getImportNPCS() { return array(); }
	
	public function onInit()
	{
		foreach ($this->getImportNPCS() as $classname)
		{
			$this->npcs[$classname] = Shadowrun4::getNPC($classname);
		}
	}
	
	/**
	 * @param $name
	 * @return SR_Location
	 */
	public function getLocation($name)
	{
		$name = str_ireplace($this->getName().'_', '', strtolower($name));
		return isset($this->locations[$name]) ? $this->locations[$name] : false;
	}
	
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
			$party->notice($l->getFoundText());
			$party->pushAction(SR_Party::ACTION_OUTSIDE, $n);
		}
	}
	
	private function onWentTo(SR_Party $party)
	{
		$location = $this->getLocation($party->getTarget());
		$party->pushAction(SR_Party::ACTION_OUTSIDE);
		# TODO: Announce it!
		
		$location->onEnter($party->getLeader());
	}
	
	public function onEvents(SR_Party $party) { return false; }
	
	private function cityMovement(SR_Party $party)
	{
		if (!$party->canMeetEnemies()) {
			return false;
		}
		
		switch (rand(1, 4))
		{
			case 1: $b = $this->partyContact($party); break;
			case 2: $b = $this->enemyContact($party, false); break;
			case 3: $b = $this->enemyContact($party, true); break;
			case 4: $b = $this->onEvents($party); break;
		}
		
		if (!$b) {
			$party->setContactEta(2);
		}
		
		return $b;
	}
	
	private function partyContact(SR_Party $p)
	{
		$sqkm = $this->getSquareKM();
		$possible = array();
		$total = 0;
		foreach (Shadowrun4::getParties() as $ep)
		{
			if ( ($ep->isMoving()) && ($p->getCity() === $ep->getCity()) && ($ep->getID() !== $p->getID()) )
			{
				$total += 50;
				$possible[] = array($ep, 50);
			}
		}
		
		$chance_none = $sqkm * 30 - count($possible);
		$chance_none = Common::clamp($chance_none, 50);
		
		if (false === ($ep = Shadowfunc::randomData($possible, $total, $chance_none))) {
			return false;
		}
		
		$p->talk($ep, true);
		
		return true;
	}
	
	private function enemyContact(SR_Party $party, $friendly=false)
	{
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
		do 
		{
			$contact = false;
			
			if (false !== ($npc = Shadowfunc::randomData($possible, $total, $total*1.5)))
			{
				$contact = true;
				$npcs[] = $npc;
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