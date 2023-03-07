<?php
abstract class SR_City
{
	private $name = '';
	private $npcs = array();
	private $locations = array();
	
	public abstract function getArriveText(SR_Player $player);
	public abstract function getMinLevel();
	
	public function __construct($name) { $this->name = $name; }
	public function getName() { return $this->name; }
	public function getNPCs() { return $this->npcs; }
	public function getLocations() { return $this->locations; }
	public function getSquareKM() { return sqrt(count($this->locations) * 2) + 1; }
	public function getRespawnLocation(SR_Player $player) { return 'Redmond_Hotel'; }
	public function onEvents(SR_Party $party) { return false; }
	public function getImportNPCS() { return array(); }
	public function isDungeon() { return false; }
	public function getGotoTime() { return $this->getSquareKM() * 38; }
	public function getGotoETA(SR_Party $party) { return $this->calcETA($party, $this->getGotoTime()); }
	public function getExploreTime() { return $this->getSquareKM() * 45; }
	public function getExploreETA(SR_Party $party) { return $this->calcETA($party, $this->getExploreTime()); }
	public function getAreaSize() { return 99999.9; }
	
	############
	### Lang ###
	############
	/**
	 * @var GWF_LangTrans
	 */
	private $lang = NULL;
	public function onLoadLanguage()
	{
		$cityname = $this->getName();
		$path = sprintf('%scity/%s/lang/%s', Shadowrun4::getShadowDir(), $cityname, strtolower($cityname));
		return $this->lang = new GWF_LangTrans($path);
	}
	public function lang(SR_Player $player, $key, $args=NULL)
	{
		return $this->lang->langISO($player->getLangISO(), $key, $args);
	}
	
	private function calcETA(SR_Party $party, $eta=60, $tpq=1.0, $mintime=5, $randtime=10)
	{
		if (!$this->isDungeon())
		{
			if (false !== ($mount = $party->getCriticalMount()))
			{
				$eta = $mount->getMountTime($eta);
// 				$eta -= ($mount->getMountTuneup() * 2);
			}
		}
		$eta += rand(0, $randtime);
		$eta = Common::clamp(round($eta), $mintime);
		return $eta;
	}
	
	public function initNPCS($filename, $fullpath)
	{
		$name = substr($filename, 0, -4);
		$classname = "{$this->name}_{$name}";
// 		Dog_Log::debug("Loading NPC $classname...");
		SR_NPC::$NPC_COUNTER++;
		require_once $fullpath;
		$npc = new $classname(NULL);
		$npc->setNPCClassName($classname);
		$this->npcs[$classname] = $npc;
		$this->checkNPC($npc);
	}
	
	private function checkNPC(SR_NPC $npc)
	{
// 		$this->checkNPCLang($npc);
		$this->checkNPCEquipment($npc);
		$this->checkNPCStats($npc);
		$this->checkNPCSpells($npc);
	}

	private function checkNPCLang(SR_NPC $npc)
	{
		if ($npc instanceof SR_TalkingNPC)
		{
			$npc->setChatPartner(Shadowrun4::getDummyPlayer());
			$npc->langNPC('default');
		}
	}
	
	private function checkNPCEquipment(SR_NPC $npc)
	{
		foreach ($npc->getNPCEquipment() as $key => $value)
		{
			$this->checkNPCEquipmentB($npc, $key, $value);
		}
		$this->checkNPCEquipmentB($npc, NULL, $npc->getNPCInventory());
		$this->checkNPCEquipmentB($npc, NULL, $npc->getNPCCyberware());
	}
	
	private function checkNPCEquipmentB(SR_NPC $npc, $key=NULL, $items=null)
	{
		if ($items === '')
		{
			return;
		}
		
		foreach (GWF_Array::arrify($items) as $iname)
		{
			if (false === ($item = SR_Item::createByName($iname, true, false)))
			{
				die(sprintf('The NPC %s has an invalid item: %s.', get_class($npc), $iname));
			}
			
			if ( ($key !== NULL) && ($item->getItemType() !== $key) )
			{
				die(sprintf('The NPC %s has %s item in wrong slot %s: %s.', get_class($npc), $item->getItemType(), $key, $iname));
			}
		}
	}
	
	private function checkNPCStats(SR_NPC $npc)
	{
		$mods = $npc->getNPCModifiers();
		
		foreach ($mods as $key => $value)
		{
			if (!$this->checkNPCStat($key))
			{
				die(sprintf('The NPC %s has an invalid modifier: %s.', get_class($npc), $key));
			}
		}
	}
	
	private function checkNPCStat($key)
	{
		$specials = array('nuyen', 'base_hp', 'base_mp', 'race', 'gender', 'distance');
		if (  (in_array($key, SR_Player::$ATTRIBUTE))
			||(in_array($key, $specials))
			||(in_array($key, SR_Player::$SKILL))
			||(in_array($key, SR_Player::$KNOWLEDGE))
		)
		{
			return true;
		}
		
		return false;
	}
	
	private function checkNPCSpells(SR_NPC $npc)
	{
		foreach ($npc->getNPCSpells() as $spell => $level)
		{
			if (false === SR_Spell::getSpell($spell))
			{
				die(sprintf('The NPC %s has an unknown spell: %s.', get_class($npc), $spell));
			}
		}
	}
	
	public function initLocations($filename, $fullpath)
	{
		$name = substr($filename, 0, -4);
		$classname = "{$this->name}_{$name}";
// 		Dog_Log::debug("Loading Location $classname...");
		SR_Location::$LOCATION_COUNT++;
		require_once $fullpath;
		$location = new $classname($classname);
		$location instanceof SR_Location;
		$this->locations[strtolower($name)] = $location;
	}

	public function validateLocations()
	{
		foreach ($this->locations as $location)
		{
			$location instanceof SR_Location;
			$location->checkLocation();
		}
	}
		
	public function onInit()
	{
		foreach ($this->getImportNPCS() as $classname)
		{
			if (false === ($npc = Shadowrun4::getNPC($classname)))
			{
				die("Unknown import_npc {$classname} in city {$this->getName()}.\n");
			}
			$this->npcs[$classname] = $npc;
		}
	}
	
	public function initQuests($filename, $fullpath)
	{
		SR_Quest::includeQuest($filename, $fullpath, $this->getName());
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
	 * Get a location in this city by abbreviation.
	 * @param $arg
	 * @return SR_Location
	 */
	public function getLocationByAbbrev($arg)
	{
		$candidates = $this->getLocationsByAbbrev($arg);
		return count($candidates) === 1 ? $candidates[0] : false;
	}
	
	public function getLocationsByAbbrev($arg)
	{
		$arg = strtolower($arg);
		$back = array();
		foreach ($this->locations as $key => $location)
		{
			$location instanceof SR_Location;
			$name = strtolower($location->getName());
			
			if ($name === $arg)
			{
				return $location;
			}
			elseif (strpos($name, $arg) !== false)
			{
				$back[] = $location;
			}
		}
		return $back;
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
// 		$party->notice($this->getArriveText());
		$this->onCityEnter($party);
// 		if (false !== ($location = $party->getLocationClass('inside')))
// 		{
// 			$location->onEnter($party->getLeader());
// 		}
	}
	
	public function onCityEnter(SR_Party $party)
	{
		foreach ($this->locations as $location)
		{
			$location instanceof SR_Location;
			$location->onCityEnter($party);
		}
		
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$text = $this->getArriveText($member);
			$member->msg('5257', array($this->getName(), $text));
		}
	}
	
	public function onCityExit(SR_Party $party)
	{
		foreach ($this->locations as $location)
		{
			$location instanceof SR_Location;
			$location->onCityExit($party);
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
			$party->ntice('5024', array($party->getTarget()));
// 			$party->notice('Your target for hijacking ('.$party->getTarget().') gone away.');
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
		if (false === ($target = $party->getHuntTarget()))
		{
			# Fail
		}
		elseif ($target->getParty()->getCity() !== $party->getCity())
		{
			$party->ntice('5025', array($target->getName(), $party->getCity()));
// 			$party->notice(sprintf('%s has left %s.', $target->getName(), $party->getCity()));
		}
		elseif ($target->getPartyID() === $party->getID())
		{
			$party->ntice('5026', array($target->getName()));
// 			$party->notice(sprintf('%s is in your party now.', $target->getName()));
		}
		else
		{
			return false;
		}
		
		# Fail
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
			
			if ($perc > 0)
			{
				$total += $perc;
				$possible[] = array($l, $perc);
			}
		}
		
		if (count($possible) === 0)
		{
			$party->ntice('5027', array($cityname));
// 			$party->notice(sprintf('You explored %s again, but it seems you know every single corner of it.', $cityname));
			$party->pushAction(SR_Party::ACTION_OUTSIDE, $cityname, 0);
		}
		elseif (false === ($l = Shadowfunc::randomData($possible, $total, 500)))
		{
			$party->ntice('5028', array($cityname));
// 			$party->notice(sprintf('You explored %s again, but could not find anything new.', $cityname));
			$party->pushAction(SR_Party::ACTION_OUTSIDE, $cityname, 0);
		}
		else
		{
			$l instanceof SR_Location;
			$n = $l->getName();
			$party->giveKnowledge('places', $n);
			$party->ntice('5029', array($n, $l->getFoundText($leader)));
// 			$party->notice($l->getFoundText($leader));
			$leader->hlp('hlp_in_outside');
// 			$leader->help('When you find locations, you are outside of them. Use #goto or #enter to enter them. You can #(exp)lore again to find more locations.');
			$party->pushAction(SR_Party::ACTION_OUTSIDE, $n);
		}
	}
	
	private function onWentTo(SR_Party $party)
	{
		$target = $party->getTarget();
		$location = $this->getLocation($target);
		$party->giveKnowledge('places', $target);
		$party->pushAction(SR_Party::ACTION_OUTSIDE, $target);
		if ($location->isEnterAllowedParty($party))
		{
			$location->onEnter($party->getLeader());
		}
	}
	
	private function onLostHuntTarget(SR_Party $party)
	{
		$loc = $party->getCity();
		$party->ntice('5031', array($loc));
// 		$party->notice(sprintf('You have lost your target and continue in the streets of %s.', $loc));
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
				$party->ntice('5032', array($target->getName(), $loc, $ep->getMemberCount()));
// 				$party->notice(sprintf('You found %s at %s with a party of %s members.', $target->getName(), $loc, $ep->getMemberCount()));
				$party->pushAction(SR_Party::ACTION_OUTSIDE, $loc);
				break;
			case SR_Party::ACTION_EXPLORE:
			case SR_Party::ACTION_GOTO:
			case SR_Party::ACTION_HUNT:
				$loc = $party->getCity();
				$party->ntice('5033', array($target->getName(), $loc));
// 				$party->notice(sprintf('You found %s in the streets of %s.', $target->getName(), $loc));
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
		if (rand(0, 60) > 0) # 0 ok, 1-4 fail
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
		$dice = $friendly ? 18 : 8;
		if (rand(1, $dice) !== 1)
		{
			return false;
		}
		$mc = $party->getMemberCount();
		$level = $party->getMax('level', true);
		
		$possible = array();
		$total = 0;
		foreach ($this->npcs as $npc)
		{
			$npc instanceof SR_NPC;
			if ( ($npc->getNPCLevel() <= $level) && ($npc->isNPCFriendly($party)===$friendly) && ($npc->canNPCMeet($party)) )
			{
				$multi = $friendly === true ? 1 : 1;
				$percent = round($npc->getNPCMeetPercent($party) * $multi * 100);
				$total += $percent;
				$possible[] = array($npc->getNPCClassName(), $percent);
			}
		}
		
		$npcs = array();
		$x = 200; // 200% chance nothing
		do 
		{
			$contact = false;
			
			if (false !== ($npc = Shadowfunc::randomData($possible, $total, $x*100)))
			{
				$contact = true;
				$npcs[] = $npc;
				$x += 120 - Common::clamp($mc*10, 0, 50);
			}
			
			if (count($npcs) >= ($this->maxEnemies($party)))
			{
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
	
	private function maxEnemies(SR_Party $party)
	{
		$mc = $party->getMemberCount();
		return Common::clamp(round($party->getSum('level', true)/14)+1, $mc, 9);
	}
}
?>
