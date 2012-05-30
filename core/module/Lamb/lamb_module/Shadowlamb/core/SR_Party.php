<?php
final class SR_Party extends GDO
{
	const MAX_MEMBERS = 7;
	const XP_PER_LEVEL = 50;
	const X_COORD_INI = 2;
	const X_COORD_INC = 4; # increment X coord per member enum, like X = 2, 6, 10, 14, and so on.
	
	const NPC_PARTY = 0x01;
	const BAN_ALL = 0x02;
	
	const LOOT_CYCLE = 0x10;
	const LOOT_KILL = 0x20;
	const LOOT_RAND = 0x40;
	const LOOT_USER = 0x80;
	const LOOT_BITS = 0xF0;
	
	public static $ACTIONS = array('delete','talk','fight','inside','outside','sleep','travel','explore','goto','hunt','hijack');
	private static $ACTIONS_LEAVE = array('delete', 'fight', 'outside', 'travel', 'explore', 'goto', 'hunt');
	const ACTION_DELETE = 'delete';
	const ACTION_TALK = 'talk';
	const ACTION_FIGHT = 'fight';
	const ACTION_INSIDE = 'inside';
	const ACTION_OUTSIDE = 'outside';
	const ACTION_SLEEP = 'sleep';
	const ACTION_TRAVEL = 'travel';
	const ACTION_EXPLORE = 'explore';
	const ACTION_GOTO = 'goto';
	const ACTION_HUNT = 'hunt';
	const ACTION_HIJACK = 'hijack';
	
	private $loot_user = -1;
	private $loot_cycle = -1;
	private $deleted = false;
	private $members = array();
	private $distance = array();
	
	private $timestamp = 0; # last event.
	private $direction = 1; # forward
	private $max_dist = 0; # combat max dist
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_party'; }
	public function getOptionsName() { return 'sr4pa_options'; }
	public function getColumnDefines()
	{
		return array(
			'sr4pa_id' => array(GDO::AUTO_INCREMENT),
			'sr4pa_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NULL, 63),
			'sr4pa_members' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, '', 255),
			'sr4pa_contact_eta' => array(GDO::UINT, 0),
		
			'sr4pa_action' => array(GDO::ENUM, 'delete', self::$ACTIONS),
			'sr4pa_target' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, NULL, 255),
			'sr4pa_eta' => array(GDO::UINT, 0),
		
			'sr4pa_last_action' => array(GDO::ENUM, 'delete', self::$ACTIONS),
			'sr4pa_last_target' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, NULL, 255),
			'sr4pa_last_eta' => array(GDO::UINT, 0),

			'sr4pa_options' => array(GDO::UINT, 0),
			'sr4pa_ban' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			'sr4pa_distance' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, '', 255),
		
			'sr4pa_xp' => array(GDO::UINT, 0),
			'sr4pa_xp_total' => array(GDO::UINT, 0),
			'sr4pa_level' => array(GDO::UINT, 0),
		);
	}
	
	###################
	### Contact ETA ###
	###################
	public function canMeetEnemies()
	{
		return $this->getVar('sr4pa_contact_eta') <= Shadowrun4::getTime();
	}
	
	public function setContactEta($seconds)
	{
		return $this->saveVar('sr4pa_contact_eta', Shadowrun4::getTime()+$seconds);
	}
	
	###################
	### Convinienve ###
	###################
	public function getID() { return $this->getInt('sr4pa_id'); }
	public function getName() { return sprintf('%s(%s)', $this->getVar('sr4pa_name'), $this->getVar('sr4pa_id')); }
	public function getMembers() { return $this->members; }
	public function getMemberCount() { return count($this->members); }
	public function isLeader(SR_Player $player) { return $this->getLeader()->getID() === $player->getID(); }
	public function isMember(SR_Player $player) { return isset($this->members[$player->getID()]); }
	public function isOutsideLocation() { return $this->getLocationClass(self::ACTION_OUTSIDE) !== false; }
	public function isInsideLocation() { return $this->getAction() === self::ACTION_INSIDE; }
	public function isAtLocation() { return $this->isInsideLocation() || $this->isOutsideLocation(); }
	public function getDistance(SR_Player $player) { return $this->distance[$player->getID()]; }
	public function isMoving() { return in_array($this->getAction(), array('explore','goto','hunt'), true); }
	public function isIdle() { return in_array($this->getAction(), array('inside','outside'), true); }
	public function isTalking() { return $this->getAction() === self::ACTION_TALK; }
	public function isFighting() { return $this->getAction() === self::ACTION_FIGHT; }
	public function isHijacking() { return $this->getAction() === self::ACTION_HIJACK; }
	public function isHunting() { return $this->getAction() === self::ACTION_HUNT; }
	public function isSleeping() { return $this->getAction() === self::ACTION_SLEEP; }
	public function isDeleted() { return $this->deleted; }
	public function isHuman() { return (false === ($leader = $this->getLeader())) ? false : $leader->isHuman(); }
	public function isFull() { return $this->getMemberCount() >= self::MAX_MEMBERS; }
	public function setDeleted($b) { $this->deleted = $b; }
	public function getTimestamp() { return $this->timestamp; }
	public function setTimestamp($time) { $this->timestamp = $time; }
	
	/**
	 * Get the enum for a party member.
	 * @param SR_Player $player
	 * @return int|false
	 */
	public function getEnum(SR_Player $player)
	{
		return $player->getEnum();
	}
	
	public function getMemberByEnum($n)
	{
		$n = (int)$n;
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			if ($member->getEnum() === $n)
			{
				return $member;
			}
		}
		return false;
	}
	
	/**
	 * Get an NPC by classname.
	 * @param string $classname
	 * @return SR_NPC
	 */
	public function getNPCMemberByClassname($classname)
	{
		foreach ($this->members as $member)
		{
			if ($member instanceof $classname)
			{
				return $member;
			}
		}
		return false;
	}
	
	/**
	 * Get a party member by argument.
	 * @param string $arg
	 * @return SR_Player
	 */
	public function getMemberByArg($arg)
	{
		return Shadowfunc::getTarget($this->getMembers(), $arg, true);
	}
	
	public function hasHireling()
	{
		if (!$this->getLeader()->isNPC())
		{
			foreach ($this->getMembers() as $member)
			{
				if ($member->isNPC())
				{
					return true;
				}
			}
		}		
		return false;
	}
	
	public function isDone($sr_time)
	{
		if ('0' === ($eta = $this->getETA()))
		{
			return false; # Unlimited
		}
		return $eta <= $sr_time;
	}
	
	/**
	 * @return SR_Player
	 */
	public function getLeader()
	{
		foreach($this->members as $pid => $player)
		{
			return $player;
		}
		return false;
	}
	
	/**
	 * Get the current city name.
	 * @return string
	 */
	public function getCity()
	{
		$l = $this->getLocation();
		return Common::substrUntil($l, '_', $l);
	}
	/**
	 * @return SR_City
	 */
	public function getCityClass() { return Shadowrun4::getCity($this->getCity()); }
	
	/**
	 * Get the current location Full_Name.
	 * @param string $action
	 * @return SR_Location
	 */
	public function getLocation($action=NULL)
	{
		$a = $this->getAction();
		if ( ($action !== NULL) && ($action !== $a) )
		{
			return false;
		}
		switch ($a)
		{
			case 'talk': case 'fight': case 'hijack':
				return $this->getVar('sr4pa_last_target');
			case 'explore': case 'goto': case 'inside':  case 'outside': case 'sleep':
				return $this->getVar('sr4pa_target');
			case 'hunt':  
				return $this->getHuntTargetCity();
			case 'hijack':  
				return $this->getHijackTargetCity();
			case 'travel':
				return Common::substrUntil($this->getVar('sr4pa_last_target'), '_', false);
			case 'delete':
				return false;
			default:
				return false;
		}
	}
	
	/**
	 * Get the current location class for a party.
	 * @param string $where
	 * @return SR_Location
	 */
	public function getLocationClass($action=NULL)
	{
		return (false === ($location = $this->getLocation($action))) ? false : Shadowrun4::getLocationByTarget($location);
	}
	public function getAction() { return $this->getVar('sr4pa_action'); }
	public function getTarget() { return $this->getVar('sr4pa_target'); }
	public function getETA() { return $this->getVar('sr4pa_eta'); }
	public function setETA($eta) { return $this->saveVar('sr4pa_eta', $eta+Shadowrun4::getTime()); }
	
	/**
	 * @return SR_Player
	 */
	public function getHuntTarget() { return Shadowrun4::getPlayerByName($this->getHuntTargetName()); }
	public function getHuntTargetCity() { return Common::substrFrom($this->getTarget(), ' in '); }
	public function getHuntTargetName() { return Common::substrUntil($this->getTarget(), ' in '); }
	
	/**
	 * @return SR_Player
	 */
	public function getHijackTarget() { return Shadowrun4::getPlayerByName($this->getHijackTargetName()); }
	public function getHijackTargetCity() { return Common::substrFrom($this->getTarget(), ' at '); }
	public function getHijackTargetName() { return Common::substrUntil($this->getTarget(), ' at '); }
	
	/**
	 * @return SR_Party
	 */
	public function getEnemyParty() { return Shadowrun4::getParty($this->getTarget()); }

	public function cloneAction(SR_Party $party)
	{
		return $this->saveVars(array(
			'sr4pa_action' => $party->getAction(),
			'sr4pa_target' => $party->getTarget(),
			'sr4pa_eta' => $party->getETA(),
		));
	}
	
	public function clonePreviousAction(SR_Party $party)
	{
		return $this->saveVars(array(
			'sr4pa_last_action' => $party->getVar('sr4pa_last_action'),
			'sr4pa_last_target' => $party->getVar('sr4pa_last_target'),
			'sr4pa_last_eta' => $party->getVar('sr4pa_last_eta'),
		));
	}
	
	public function pushAction($action, $target=NULL, $eta=-1)
	{
		$with_events = $action !== self::ACTION_DELETE;
		
		# Diff Commands
		if ($with_events)
		{
			$old_cmds = $this->getCurrentCommands();
		}
		
		if ($target === NULL)
		{
			$target = $this->getTarget();
		}
		
		$eta = $eta >= 0 ? round(Shadowrun4::getTime() + $eta) : 0;
		
		$this->timestamp = time();
		
// 		$this->setMemberOptions(SR_Player::PARTY_DIRTY|SR_Player::CMD_DIRTY, true);

		# Announce leaving a location.
// 		if (in_array($action, self::$ACTIONS_LEAVE, true))
// 		{
// 			$this->onPartyLeft($action);
// 		}
		
		$old_action = $this->getAction();
		$oldcity = $this->getCityClass();
		
		# Save new vars
		if (false === $this->saveVars(array(
			'sr4pa_action' => $action,
			'sr4pa_target' => $target,
			'sr4pa_eta' => $eta,
			'sr4pa_last_action' => $this->getAction(),
			'sr4pa_last_target' => $this->getTarget(),
			'sr4pa_last_eta' => $this->getETA(),
		)))
		{
			return false;
		}
		
		# Event stuff
		if ($with_events)
		{
			# Announce reaching a location.
			if ( ($action === self::ACTION_INSIDE) || ($action === self::ACTION_OUTSIDE) )
			{
				$this->onPartyArrived($old_action);
			}
			
			# Fire city left events
			if ($oldcity !== false)
			{
				if (false !== ($newcity = $this->getCityClass()))
				{
					if ($oldcity->getName() !== $newcity->getName())
					{
						$oldcity->onCityExit($this);
					}
				}
			}
			
			# Diff Commands
			$new_cmds = $this->getCurrentCommands();
			$this->sendCommandDiffs($old_cmds, $new_cmds);
			
			# Auto Look
			if ( ($action === self::ACTION_INSIDE) || ($action === self::ACTION_OUTSIDE) )
			{
				$this->sendAutoLook();
			}
		}
		
		return true;
	}
	
	private function getCurrentCommands()
	{
		$back = array();
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			if ($member->getLangISO() === 'bot')
			{
				$back[$member->getID()] = Shadowcmd::getCurrentCommands($member, false, false, false, false);
			}
		}
		return $back;
	}
	
	private function sendCommandDiffs(array &$old_cmds, array &$new_cmds)
	{
		foreach ($old_cmds as $pid => $ocmds)
		{
			$ncmds = $new_cmds[$pid];
			$this->sendCommandDiffsB($this->getMemberByPID($pid), $ocmds, $ncmds);
		}
	}
	
	private function sendCommandDiffsB(SR_Player $player, array &$old_cmds, array &$new_cmds)
	{
		$out = '';
		foreach ($old_cmds as $cmd)
		{
			if (!in_array($cmd, $new_cmds))
			{
				$out .= ',-'.$cmd;
			}
		}
		
		foreach ($new_cmds as $cmd)
		{
			if (!in_array($cmd, $old_cmds))
			{
				$out .= ',+'.$cmd;
			}
		}
		
		if (strlen($out) > 0)
		{
			$player->msg('9000', array(substr($out, 1)));
		}
	}
	
	private function sendAutoLook()
	{
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			if ($member->isHuman())
			{
				Shadowcmd_look::executeLook($member, false);
			}
		}
	}
	
	/**
	 * Announce when a party arrives somewhere.
	 * @param string $action
	 */
	public function onPartyArrived($old_action='delete')
	{
		if (false !== ($loc = $this->getLocationClass()))
		{
			$loc->onEnterLocation($this);
			$this->onPartyArriveLeft($loc, $old_action, $this->getAction());
		}
	}
	
	/**
	 * Announce when a party has left a location.
	 */ 
// 	public function onPartyLeft($new_action)
// 	{
// 		if (false !== ($loc = $this->getLocationClass()))
// 		{
// 			$loc->onLeaveLocation($this);
// 			$this->onPartyArriveLeft($loc, $this->getAction(), $new_action, false);
// 		}
// 	}
	
	/**
	 * Announce when a party leaves/enters a location.
	 * @param string $text_snippet
	 */
	private function onPartyArriveLeft(SR_Location $loc, $old_action, $new_action)
	{
		if (!$this->isHuman())
		{
			return;
		}
		
		$arrive = !in_array($old_action, array(self::ACTION_INSIDE, self::ACTION_SLEEP));

		$args =  array('___LOCNAME', $this->displayMembers(false, true));
		
		# Check all parties
		foreach (Shadowrun4::getParties() as $p)
		{
			$p instanceof SR_Party;
			$pa = $p->getAction();
			if (
				($p->getID() === $this->getID()) || # Own
				(!$p->isAtLocation()) || # other not at location
				($this->getTarget() !== $p->getTarget()) || # not same location
				(($pa === self::ACTION_INSIDE) && ($new_action === self::ACTION_OUTSIDE) && ($arrive)) # The checked party does not see our outside activity.
			)
			{
				continue;
			}
			
			printf("Arrive=%d, old=%s, new=%s\n", $arrive, $old_action, $new_action);
			
			# Different event keys allow easy managing of #look list.
			if (!$arrive)
			{
				if ($new_action === self::ACTION_OUTSIDE)
				{
					$key = '5284'; # %2$s is now outside of %1$s.
				}
				else
				{
					$key = '5283'; # %2$s left the %1$s and went away.
				}
			}
			elseif ($new_action === self::ACTION_OUTSIDE)
			{
				$key = '5282'; # %2$s just arrived outside of %1$s.
			}
			elseif ($new_action !== $pa)
			{
				$key = '5281'; # %2$s walk(s) by and enter(s) the %1$s.
			}
			else
			{
				$key = '5280'; # %2$s just entered the %1$s.
			}
			
			# Send events
			foreach ($p->getMembers() as $member)
			{
				$member instanceof SR_Player;
				$args[0] = $loc->displayName($member);
				$member->msg($key, $args);
			}
		}
	}
	
	public function popAction($announce=false)
	{
		# Diff Commands
		$old_cmds = $this->getCurrentCommands();
		
		if ('0' === ($last_eta = $this->getVar('sr4pa_last_eta'))) {
			$new_eta = 0;
		} else {
			$new_eta = $last_eta - $this->getETA() + Shadowrun4::getTime();
		}
		if (false === $this->saveVars(array(
			'sr4pa_action' => $this->getVar('sr4pa_last_action'),
			'sr4pa_target' => $this->getVar('sr4pa_last_target'),
			'sr4pa_eta' => $new_eta,
			'sr4pa_last_action' => 'delete',
			'sr4pa_last_target' => NULL,
			'sr4pa_last_eta' => 0,
		))) {
			return false;
		}
		
		$this->onCleanupHirelings();

// 		$this->setMemberOptions(SR_Player::PARTY_DIRTY|SR_Player::CMD_DIRTY, true);
		
		if ($announce === true)
		{
			foreach ($this->members as $member)
			{
				$member instanceof SR_Player;
				$member->msg('5093', array($this->displayAction($member)));
			}
// 			$this->notice('You continue '.$this->displayAction());
		}
		
			
		# Diff Commands
		$new_cmds = $this->getCurrentCommands();
		$this->sendCommandDiffs($old_cmds, $new_cmds);
		
		# Auto Look
		$action = $this->getAction();
		if ( ($action === self::ACTION_INSIDE) || ($action === self::ACTION_OUTSIDE) )
		{
			$this->sendAutoLook();
		}
		
		$this->timestamp = time();
		
		return true;
	}
	
	private function onCleanupHirelings()
	{
		foreach ($this->members as $member)
		{
			if ($member instanceof SR_HireNPC)
			{
				if ($member->hasToLeave())
				{
					$this->ntice('5094', array($member->getName()));
// 					$this->notice(sprintf('%s thanked you and left the party.', $member->getName()));
					$this->kickUser($member, true);
				}
			}
		}
	}
	
	public function setMemberOptions($bits, $bool)
	{
		foreach ($this->members as $member)
		{
			$member->setOption($bits, $bool);
		}
	}
	
	/**
	 * @param string $name
	 * @return SR_Player
	 */
	public function getMemberByName($name)
	{
		return Shadowfunc::getTarget($this->getMembers(), $name, false);
	}
	
	/**
	 * Get a member by PlayerID.
	 * @param int $pid
	 * @return SR_Player
	 */
	public function getMemberByPID($pid)
	{
		foreach ($this->members as $member)
		{
			if ($member->getID() === $pid)
			{
				return $member;
			}
		}
		return false;
	}
	
	public function addUser(SR_Player $player, $update=true)
	{
		$pid = $player->getID();
		$this->members[$pid] = $player;
		$this->distance[$pid] = 0;
		if ($update === true)
		{
			$player->saveVar('sr4pl_partyid', $this->getID());
			$this->updateMembers();
			$this->recomputeEnums();
		}
	}
	
	public function kickUser(SR_Player $player, $update=true)
	{
		$pid = $player->getID();
		
		if (!isset($this->members[$pid]))
		{
			return false;
		}
		
		unset($this->members[$pid]);
		unset($this->distance[$pid]);
		if ($update === true)
		{
			$this->updateMembers();
			if ($this->getMemberCount() === 0)
			{
				if ( $this->isFighting() )
				{
					$this->getEnemyParty()->onFightDone();
				}
				$this->deleteParty();
			}
		}
		return true;
	}
	
	public function updateMembers()
	{
		$this->timestamp = time();
// 		$this->setMemberOptions(SR_Player::PARTY_DIRTY, true);
		return $this->saveVars(array(
			'sr4pa_members' => implode(',', array_keys($this->members)),
			'sr4pa_distance' => implode(',', array_values($this->distance)),
		));
	}
	
	public function sharesLocation(SR_Party $p)
	{
		if (!$this->isAtLocation())
		{
			return false;
		}
		return ($p->getAction() === $this->getAction()) && ($p->getTarget() === $this->getTarget());
	}
	
	public function setLeader(SR_Player $player)
	{
		if ($player->getPartyID() !== $this->getID())
		{
			return false;
		}
		$pid = $player->getID();
		$td = $this->distance[$pid];
		unset($this->members[$pid]);
		unset($this->distance[$pid]);
		$t1 = array($pid=>$player);
		$t2 = array($pid=>$td);
		foreach ($this->members as $pid2 => $member)
		{
			$t1[$pid2] = $member;
			$t2[$pid2] = $this->distance[$pid2];
		}
		$this->members = $t1;
		$this->distance = $t2;
		if (false === $this->updateMembers())
		{
			return false;
		}
		$this->recomputeEnums();
		return true;
	}
	
	###########
	### Ban ###
	###########
	public function banAll($bool)
	{
		$this->saveOption(self::BAN_ALL, $bool);
		$this->saveVar('sr4pa_ban', NULL);
	}
	
	public function hasBanned(SR_Player $player)
	{
		if ($this->isOptionEnabled(self::BAN_ALL)) {
			return true;
		}
		if (NULL === ($bans = $this->getVar('sr4pa_ban'))) {
			return false;
		}
		$pid = $player->getID();
		return strpos(",$pid,", $bans) !== false;
	}
	
	public function ban(SR_Player $player)
	{
		if ($this->hasBanned($player)) {
			return true;
		}
		$pid = $player->getID();
		if (NULL === ($bans = $this->getVar('sr4pa_ban'))) {
			$bans = $pid;
		} else {
			$bans .= ','.$pid;
		}
		return $this->saveVar('sr4pa_ban', $bans);
	}
	
	public function unban(SR_Player $player)
	{
		if (!$this->hasBanned($player)) {
			return true;
		}
		$this->saveOption(self::BAN_ALL, false);
		$pid = $player->getID();
		$bans = trim(str_replace(",$pid,", ',', $this->getVar('sr4pa_ban')), ',');
		$s = $bans === '' ? NULL : $bans;
		return $this->saveVar('sr4pa_ban', $s);
	}
	
	#############
	### Fight ###
	#############
	/**
	 * Set two parties fighting each other.
	 * @param SR_Party $party
	 */
	public function fight(SR_Party $party, $announce=true)
	{
		if ($this->getID() === $party->getID())
		{
			Lamb_Log::logError('Party should not fight itself!');
			return false;
		}
		
		if ($party->getMemberCount() === 0)
		{
			Lamb_Log::logError('Cannot fight empty party!');
			return false;
		}
		
		if ($party->getAction() === self::ACTION_DELETE)
		{
			$party->cloneAction($this);
		}
		elseif ($this->getAction() === self::ACTION_DELETE)
		{
			$this->cloneAction($party);
		}
		
		$this->pushAction(self::ACTION_FIGHT, $party->getID(), 0);
		$party->pushAction(self::ACTION_FIGHT, $this->getID(), 0);
		$this->initNPCb($party);
		$this->setContactEta(rand(10,25));
		$party->setContactEta(rand(10,25));
		$this->initFightBusy(1);
		$party->initFightBusy(-1);
		if ($announce === true)
		{
			$this->ntice('5095', array($party->displayMembers(true, true)));
			$party->ntice('5095', array($this->displayMembers(true, true)));
// 			$this->notice(sprintf('You encounter %s.', $party->displayMembers(true, true)));
// 			$party->notice(sprintf('You encounter %s.', $this->displayMembers(true, true)));
		}
// 		$this->setMemberOptions(SR_Player::PARTY_DIRTY, true);
// 		$party->setMemberOptions(SR_Player::PARTY_DIRTY, true);
		return true;
	}
	
	private function initNPCb(SR_Party $ep)
	{
		if (!$this->isHuman())
		{
			$this->initNPCc($this, $ep);
		}
		if (!$ep->isHuman())
		{
			$this->initNPCc($ep, $this);
		}
	}
	
	private function initNPCc(SR_Party $p, SR_Party $ep)
	{
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_NPC;
			$member->onInitNPC($ep);
		}
	}
	
	public function talk(SR_Party $party, $announce=true)
	{
		if ($party->getMemberCount() === 0)
		{
			Lamb_Log::logError('Cannot talk to empty party!');
			return false;
		}
		
		Shadowcmd_bye::onPartyMeet($party, $this);
		$this->pushAction(self::ACTION_TALK, $party->getID(), 0);
		$party->pushAction(self::ACTION_TALK, $this->getID(), 0);
		$this->setContactEta(60);
		$party->setContactEta(60);
		$this->initFightBusy(1);
		$party->initFightBusy(-1);
		
		if ($announce === true)
		{
			$this->ntice('5096', array($party->displayMembers(true, true), SR_Bounty::displayBountyParty($party), SR_BadKarma::displayBadKarmaParty($party)));
			$party->ntice('5096', array($this->displayMembers(true, true), SR_Bounty::displayBountyParty($this), SR_BadKarma::displayBadKarmaParty($this)));
// 			$this->notice(sprintf('You meet %s.%s%s', $party->displayMembers(false, true), SR_Bounty::displayBountyParty($party), SR_BadKarma::displayBadKarmaParty($party)));
// 			$party->notice(sprintf('You meet %s.%s%s', $this->displayMembers(false, true), SR_Bounty::displayBountyParty($this), SR_BadKarma::displayBadKarmaParty($this)));
		}
		
// 		$this->setMemberOptions(SR_Player::PARTY_DIRTY, true);
// 		$party->setMemberOptions(SR_Player::PARTY_DIRTY, true);
	}
	
	private function initFightBusy($neg=1)
	{
		$this->direction = $neg > 0 ? -1 : +1;
		
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			$pid = $member->getID();
			$member->busy(SR_Player::FIGHT_INIT_BUSY);
			$member->initCombatStack();
			$this->setupMaxDist();
			$dist = Common::clamp($member->getBase('distance'), 1, $this->max_dist);
			$this->distance[$pid] = $neg * $dist;
		}
		return $this->updateMembers();
	}

	/**
	 * Setup max-distance when fighting
	 */
	private function setupMaxDist()
	{
		if (false !== ($location = $this->getLocationClass()))
		{
			$this->max_dist = $location->getAreaSize();
// 			printf("SR_Party::setupMaxDist() with location %s = %s.\n", $location->getName(), $this->max_dist);
		}
		elseif (false !== ($city = $this->getCityClass()))
		{
			$this->max_dist = $city->getAreaSize();
// 			printf("SR_Party::setupMaxDist() with city %s = %s.\n", $city->getName(), $this->max_dist);
		}
		else
		{
			$this->max_dist = 15.0;
// 			printf("SR_Party::setupMaxDist() with default%s.\n", $this->max_dist);
		}
		$this->max_dist = Common::clamp(round($this->max_dist/2, 1), 1.0, 99999.9);
	}
	
	##############
	### Static ###
	##############
	public static function getByID($partyid)
	{
		if (false === ($party = self::table(__CLASS__)->getRow($partyid)))
		{
			return false;
		}
		
		$party instanceof SR_Party;
		
		if (false === $party->initMembers())
		{
			return false;
		}
		
		$party->onPartyArrived();
		
		return $party;
	}
	
	public function initMembers()
	{
		$dist = explode(',', $this->getVar('sr4pa_distance'));
		
		foreach (explode(',', $this->getVar('sr4pa_members')) as $i => $playerid)
		{
			if (false !== ($player = Shadowrun4::getPlayerByPID($playerid)))
			{
				$this->addUser($player, false);
				$this->distance[$player->getID()] = $dist[$i];
			}
		}
		
		$this->recomputeEnums();
		
		if (false === $this->updateMembers())
		{
			return false;
		}
		
		$this->setupMaxDist();
		
		return true;
	}
	
	/**
	 * @return SR_Party
	 */
	public static function createParty()
	{
		$party = new self(array(
			'sr4pa_id' => 0,
			'sr4pa_name' => NULL,
			'sr4pa_members' => '',
			'sr4pa_contact_eta' => 0,
			'sr4pa_action' => 'delete',
			'sr4pa_target' => NULL,
			'sr4pa_eta' => 0,
			'sr4pa_last_action' => 'delete',
			'sr4pa_last_target' => NULL,
			'sr4pa_last_eta' => 0,
			'sr4pa_options' => SR_Party::LOOT_KILL,
			'sr4pa_ban' => NULL,
			'sr4pa_distance' => '',
			'sr4pa_xp' => 0,
			'sr4pa_xp_total' => 0,
			'sr4pa_level' => 0,
		));
		
		if (false === ($party->insert()))
		{
			return false;
		}
		
		Shadowrun4::addParty($party);
		return $party;
	}

	##############
	### Delete ###
	##############
	public function deleteParty()
	{
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			if ($member->isHuman())
			{
				$member->deletePlayer();
			}
		}
		$this->delete();
		Shadowrun4::removeParty($this);
	}

	
	###############
	### Message ###
	###############
	public function help($message)
	{
		foreach ($this->members as $player)
		{
			$player->help($message);
		}
		return true;
	}
	
	/**
	 * Notice a raw message to all members.
	 * @param string $message
	 * @param SR_Player|null $but
	 * @return true
	 */
	public function notice($message, $but=NULL)
	{
		$butid = $but === NULL ? 0 : $but->getID();
		foreach ($this->members as $player)
		{
			$player instanceof SR_Player;
			if ($player->getID() !== $butid)
			{
				$player->message($message);
			}
		}
		return true;
	}
	
	/**
	 * Language setting aware notice.
	 * @see self::notice
	 * @param string $key
	 * @param array|null $args
	 * @param SR_Player|null $but
	 * @return true
	 */
	public function ntice($key, $args=NULL, $but=NULL)
	{
		$butid = $but === NULL ? 0 : $but->getID();
		foreach ($this->members as $player)
		{
			$player instanceof SR_Player;
			if ($player->getID() !== $butid)
			{
				$player->msg($key, $args);
			}
		}
		return true;
	}
	
	/**
	 * @deprecated
	 * @param SR_Player $player
	 * @param unknown_type $message
	 */
	public function message(SR_Player $player, $message)
	{
		$this->notice($player->getEnum().'-'.$player->getName().$message);
	}
	
	#################
	### Knowledge ###
	#################
	public function giveKnowledge($field, $knowledge)
	{
		foreach ($this->members as $player)
		{
			$player instanceof SR_Player;
			if (false === $player->giveKnowledge($field, $knowledge))
			{
				return false;
			}
		}
		return true;
	}
	
	#################
	### Quest NPC ###
	#################
	public function hasNPCNamed($name)
	{
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			if ($member->isNPC())
			{
				if ($member->getName() === $name)
				{
					return true;
				}
			}
		}
		return false;
	}
	
	public function hasNPCClassed($classname)
	{
		foreach ($this->members as $member)
		{
			if (get_class($member) === $classname)
			{
				return true;
			}
		}
		return false;
	}
	
	#################
	### Temp Vars ###
	#################
	public function setTemp($key, $value)
	{
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			$member->setTemp($key, $value);
		}
	}
	
	public function unsetTemp($key)
	{
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			$member->unsetTemp($key);
		}
	}
	
	public function hasTemp($key)
	{
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			if ($member->hasTemp($key))
			{
				return true;
			}
		}
		return false;
	}
	
	public function getTemp($key, $default=false)
	{
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			if ($member->hasTemp($key))
			{
				return $member->getTemp($key, $default);
			}
		}
		return $default;
	}
	
	##################
	### Const Vars ###
	##################
	public function setConst($key, $value)
	{
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			$member->setConst($key, $value);
		}
	}
	
	public function unsetConst($key)
	{
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			$member->unsetConst($key);
		}
	}
	
	public function hasConst($key)
	{
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			if ($member->hasConst($key))
			{
				return true;
			}
		}
		return false;
	}
	
	public function getConst($key, $default=false)
	{
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			if ($member->hasConst($key))
			{
				return $member->getConst($key);
			} 
		}
		return $default;
	}
	
	#############
	### Stats ###
	#############
	public function getMin($field, $base=false)
	{
		$min = PHP_INT_MAX;
		foreach ($this->members as $member)
		{
			$t = $base === true ? $member->getBase($field) : $member->get($field);
//			$t = $member->get($field);
			if ($t < $min)
			{
				$min = $t;
			}
		}
		return $min;
	}
	
	public function getMax($field, $base=false)
	{
		$max = -1;
		foreach ($this->members as $member)
		{
			$t = $base === true ? $member->getBase($field) : $member->get($field);
//			$t = $member->get($field);
			if ($t > $max)
			{
				$max = $t;
			}
		}
		return $max;
	}
	
	public function getSum($field, $base=false)
	{
		$sum = 0;
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			$t = $base === true ? $member->getBase($field) : $member->get($field);
			$sum += $t;
//			$sum += $member->get($field);
		}
		return $sum;
	}
	
	################
	### Distance ###
	################

	public function moveTowards(SR_Player $player, SR_Player $target)
	{
		$move = $player->getMovePerSecond();
		$d1 = $player->getY();
		$d2 = $target->getY();
		$dt = $d1 - $d2;
		if ($dt < 0) {
			$dt = -$dt;
			if ($move > $dt) {
				$move = $dt;
			}
			$move = -$move;
		} else {
			if ($move > $dt) {
				$move = $dt;
			}
		}
		$pid = $player->getID();
		$move = -$move;
		$new_d = 0;
		$move = round($move, 1);
		$this->movePlayerB($pid, $move, $new_d);
		$new_d = round($new_d, 1);
		$busy = $player->busy(25);
		$name = $player->displayNameNB();
		$tn = $target->displayNameNB();
		
		$ep = $this->getEnemyParty();
		$args = array($name, abs($move), $tn, $new_d, $busy);
		$this->ntice('5097', $args);
		$ep->ntice('5097', $args);
// 		$ep->ntice('5098', array($name, abs($move), $tn, $new_d));
// 		$this->notice(sprintf('%s moves %.01f meters towards %s and is now on position %.01f meters. %ds busy.', $name, abs($move), $tn, $new_d, $busy));
// 		$this->getEnemyParty()->notice(sprintf('%s moves %.01f meters towards %s and is now on position %.01f meters.', $name, abs($move), $tn, $new_d));
		return true;
	}
	
	###############
	### FW / BW ###
	###############
	public function forward(SR_Player $player, $busy=-1) { return $this->forwardB($player, $this->direction, $player->lang('forwards'), $busy); }
	public function backward(SR_Player $player, $busy=-1) { return $this->forwardB($player, -$this->direction, $player->lang('backwards'), $busy); }
	private function forwardB(SR_Player $player, $dir, $fwbw, $busy=-1)
	{
		$by = $dir * $player->getMovePerSecond();
		$pid = $player->getID();
		$new_d = 0;
		$this->movePlayerB($pid, $by, $new_d);
		$busy = $busy > 0 ? ', '.Shadowfunc::displayBusy($player->busy($busy)) : '.';
		
		$by = round($by, 1);
		$new_d = round($new_d, 1);
		
		$ep = $this->getEnemyParty();
		$pname = $player->getName();
		$this->ntice('5090', array($pname, abs($by), $fwbw, $new_d, $busy));
		$ep->ntice('5091', array($pname, abs($by), $fwbw, $new_d, $busy));
// 		$message = sprintf(' moves %.01f meters %s and is now on position %.01f meters%s', abs($by), $fwbw, $new_d, $busy);
// 		$this->message($player, $message);
// 		$this->getEnemyParty()->message($player, $message);
		return true;
	}
	
	public function movePlayer(SR_Player $player, $forward=true, $metres=0)
	{
		$dir = $forward ? 1 : -1;
		$by = $dir * $metres;
		$new_d = 0;
		return $this->movePlayerB($player->getID(), $by, $new_d);
	}
	
	private function movePlayerB($pid, &$by, &$new_d)
	{
		$max = $this->max_dist;
		$old = $this->distance[$pid];
		$new_d = round(Common::clamp($old+$by, -$max, $max), 1);
		$by = $new_d - $old;
		$this->distance[$pid] = $new_d;
		return $this->updateMembers();
	}
	
	
	############
	### Flee ###
	############
	public function flee(SR_Player $player)
	{
		$ep = $this->getEnemyParty();
		
		$q1 = $player->get('quickness');
		$q2 = $ep->getMax('quickness');
		
		$min1 = 0;
		$max1 = $q1 * 8 + $player->get('luck');
		$r1 = rand($min1, $max1);
		
		$min2 = 10 + 10 * $ep->getMemberCount();
		$max2 = $min2 + $q2 + $ep->getMax('luck');
		$r2 = rand($min2, $max2);
		
		return $r1 >= $r2;
	}
	
	/**
	 * Calculate the smallest distance the player has from any enemy.
	 * @param $player
	 */
	private function getSmallestDistance(SR_Player $player)
	{
		$d1 = $this->distance[$player->getID()];
		$ep = $player->getEnemyParty();
		$back = 1000;
		foreach ($ep->distance as $pid => $d2)
		{
			$d3 = abs($d1-$d2);
			if ($d3 < $back) {
				$back = $d3;
			}
		}
		return $back;
	}
	
	###############
	### Display ###
	###############
	public function displayETA()
	{
		$duration = $this->getETA()-Shadowrun4::getTime();
		return $duration <= 0 ? '0s' : GWF_Time::humanDuration($duration);
	}
	
	public function displayLastETA()
	{
		$duration = $this->getVar('sr4pa_last_eta') - $this->getETA();# + Shadowrun4::getTime();
//		$duration = $this->getVar('sr4pa_last_eta') - Shadowrun4::getTime();
		return $duration <= 0 ? '0s' : GWF_Time::humanDuration($duration);
	}
	
	public function displayContactETA()
	{
		$duration = $this->getVar('sr4pa_contact_eta')-Shadowrun4::getTime();
		return $duration <= 0 ? '0s' : GWF_Time::humanDuration($duration);
	}
	
	public function displayAction(SR_Player $player)
	{
		return $this->displayActionB($player, $this->getAction(), $this->displayETA());
	}
	
	private function displayActionB(SR_Player $player, $action, $display_eta)
	{
		$b = chr(2);
// 		$action = $this->getAction();
		
		switch ($action)
		{
			case 'delete':
				return $player->lang('pa_delete');
				
			case 'talk':
				$ep = $this->getEnemyParty();
				$epm = $ep === false ? $player->lang('empty_party') : $ep->displayMembers();
				return $player->lang('pa_talk', array(
						$epm, $this->displayContactETA(), $this->displayLastAction($player)));
// 				return sprintf("{$b}talking{$b} to %s. %s remaining.%s", $epm, $this->displayContactETA(), $this->displayLastAction());
			
			case 'fight':
				return $player->lang('pa_fight', array(
					$this->getEnemyParty()->displayMembers(true), $this->displayLastAction($player)));
// 				return sprintf("{$b}fighting{$b} against %s.%s", $this->getEnemyParty()->displayMembers(true), $this->displayLastAction());
			
			case 'inside':
				return $player->lang('pa_inside', array($this->getLocation()));
// 				return sprintf("{$b}inside{$b} %s.", $this->getLocation());
				
			case 'outside':
				$city = $this->getCityClass();
				if ($this->isAtLocation() || (!$city->isDungeon()))
				{
					return $player->lang('pa_outside1', array($this->getLocation()));
// 					return sprintf("{$b}outside{$b} of %s.", $this->getLocation());
				}
				else
				{
					return $player->lang('pa_outside2', array($this->getLocation()));
// 					return sprintf("somewhere inside %s.", $this->getLocation());
				}
				
			case 'sleep':
				return $player->lang('pa_sleep', array($this->getLocation()));
// 				return sprintf("{$b}sleeping{$b} inside %s.", $this->getLocation());
				
			case 'travel':
				return $player->lang('pa_travel', array($this->getTarget(), $display_eta));
// 				return sprintf("{$b}travelling{$b} to %s. %s remaining.", $this->getTarget(), $this->displayETA());
			
			case 'explore':
				return $player->lang('pa_explore', array($this->getLocation(), $display_eta));
// 				return sprintf("{$b}exploring{$b} %s. %s remaining.", $this->getLocation(), $this->displayETA());
			
			case 'goto':
				return $player->lang('pa_goto', array($this->getLocation(), $display_eta));
// 				return sprintf("{$b}going{$b} to %s. %s remaining.", $this->getLocation(), $this->displayETA());
			
			case 'hunt':
				return $player->lang('pa_hunt', array($this->getTarget(), $display_eta));
// 				return sprintf("{$b}hunting{$b} %s. %s remaining.", $this->getTarget(), $this->displayETA());
			
			case 'hijack':
				return $player->lang('pa_hijack', array($this->getTarget(), $this->getLocation(), $display_eta));
// 				return sprintf("{$b}hijacking{$b} %s at %s. %s remaining.", $this->getTarget(), $this->getLocation(), $this->displayETA());
			
			default:
				return 'UNKNOWN PARTY ACTION IS UNKNOWN.';
		}
	}
	
	public function displayLastAction(SR_Player $player)
	{
		$action = $this->getVar('sr4pa_last_action');
		# Do a switch here to prevent a nice deadloop condition :)
		switch ($action)
		{
			case 'fight':
			case 'talk':
				return '';
			default:
				return $this->displayActionB($player, $action, $this->displayLastETA());
		}
	}
	
	public function displayMembers($with_distance=false, $with_levels=false)
	{
		if ($this->getMemberCount() === 0)
		{
			return 'This party is empty! (should not see me)';
		}
		$b = chr(2);
		$back = '';
		foreach ($this->members as $player)
		{
			$player instanceof SR_Player;
			$dist = $with_distance ? sprintf('(%.01fm)', $this->distance[$player->getID()]) : '';
			$level = $with_levels ? Shadowfunc::displayLevel($player) : '';
			$pbot = $player->isOptionEnabled(SR_Player::PLAYER_BOT) ? '[Bot]' : '';
			$back .= sprintf(', %s-%s%s%s%s', $b.($player->getEnum()).$b, $player->getName(), $dist, $level, $pbot);
		}
		return substr($back, 2);
	}
	
	#############
	### Timer ###
	#############
	public function needsToRest()
	{
		foreach ($this->members as $player)
		{
			$player instanceof SR_Player;
			if (!$player->hasFullHPMP())
			{
				return true;
			}
		}
		return false;
	}
	
	public function timer($sr_time)
	{
		foreach ($this->members as $player)
		{
			$player instanceof SR_Player;
			Shadowcmd::$CURRENT_PLAYER = $player;
			$player->effectsTimer();
		}
		
		call_user_func(array($this, 'on_'.$this->getAction()), $this->isDone($sr_time));
	}
	
	public function on_delete($done)
	{
		foreach ($this->getMembers() as $member)
		{
			if ($member->isHuman())
			{
				$this->pushAction('outside', 'Redmond', 0);
				$this->pushAction('outside', 'Redmond', 0);
				Lamb_Log::logError(sprintf('ERROR: Human party %d got action delete!', $this->getID()));
				return;
			}
		}
		$this->deleteParty();
	}
	
	
	public function on_talk($done)
	{
		$this->timestamp = time();
		if ($this->canMeetEnemies())
		{
			if (false !== ($p = $this->getEnemyParty()))
			{
				$p->popAction(true);
				$p->setContactEta(20);
			}
			$this->popAction(true);
			$this->setContactEta(20);
		}
	}
	
	public function on_fight($done)
	{
		if (false === ($ep = $this->getEnemyParty())) {
			$this->popAction(true);
		}
		else
		{
			$this->timestamp = time();
			foreach ($this->members as $player)
			{
				# Make sure player hasn't left because of something like #cast bunny.
				if ( $player->getParty() !== $this )
				{
					continue;
				}

// 				$player instanceof SR_Player;
// 				if (NULL !== ($user = $player->getUser()))
// 				{
// 					Lamb::instance()->setCurrentUser($user);
// 				}
				Shadowcmd::$CURRENT_PLAYER = $player;

				if ( $player->combatTimer() )
				{
					# No more enemies! \o/
					break;
				}
			}
		}
	}
	
	public function giveLoot($xp, $nuyen)
	{
		$mc = $this->getMemberCount();
		$xp /= $mc;
		$nuyen /= $mc;
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			$member->giveXP($xp);
			$member->giveNuyen($nuyen);
		}
	}
	
	public function onFightDone()
	{
		if ($this->isHuman())
		{
			$this->popAction(true);
			$this->setContactEta(rand(15,25));
			$this->iExecAnyway();
			$this->recomputeEnums();
			$this->reloadAfterFight();
		}
		else
		{
			$this->deleteParty();
		}
	}
	
	private function reloadAfterFight()
	{
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			$weapon = $member->getWeapon();
			if (false === $weapon->isFullyLoaded())
			{
				$weapon->onReload($member);
			}
		}
	}
	
	private function iExecAnyway()
	{
		foreach ($this->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$member->iExecAnyway();
		}
	}
	

	public function on_inside($done) { if (!$this->isHuman()) { $this->pushAction(self::ACTION_DELETE); } }

	public function on_outside($done) { if (!$this->isHuman()) { $this->pushAction(self::ACTION_DELETE); } }

	public function on_sleep($done)
	{
		$this->timestamp = time();
		$sleeping = count($this->members);
		foreach ($this->members as $playerid => $player)
		{
			$player instanceof SR_Player;
			if ($player->hasFullHPMP()) { $sleeping--; continue; }
			
			$body = Common::clamp($player->getBase('body'), 1);
			$magic = Common::clamp($player->getBase('magic'), 1);
			$player->healHP($body/10);
			$player->healMP($magic/10);
			
			if ($player->hasFullHPMP())
			{
				$sleeping--;
				$player->msg('5001'); # You awake and have a delicous breakfast.
			}
		}
		if ($sleeping === 0)
		{
			$this->popAction();
			$this->ntice('5002'); # You are ready to go.
		}
	}
	
	
	public function on_travel($done)
	{
		$this->timestamp = time();
		if ($done === true)
		{
			$this->pushAction(self::ACTION_INSIDE);
			if ($this->getLocation() instanceof SR_Exit)
			{
				$this->pushAction(self::ACTION_OUTSIDE);
			}
			$this->giveKnowledge('places', $this->getLocation());
			$this->getCityClass()->onArrive($this);
		}
	}
	
	public function on_explore($done)
	{
		$this->timestamp = time();
		$city = $this->getCityClass();
		$city->onExplore($this, $done);
	}
	
	public function on_goto($done)
	{
		$this->timestamp = time();
		$city = $this->getCityClass();
		$city->onGoto($this, $done);
	}
	
	public function on_hunt($done)
	{
		$this->timestamp = time();
		$city = $this->getCityClass();
		$city->onHunt($this, $done);
	}
	
	public function on_hijack($done)
	{
		$this->timestamp = time();
		if (false === ($city = $this->getCityClass()))
		{
			$this->popAction(true);
		}
		else
		{
			$city->onHijack($this, $done);
		}
	}
	
	public function getRandomMember()
	{
		return $this->members[array_rand($this->getMembers())];
	}
	
	#################
	### Loot Mode ###
	#################
	public function getLootMode() { return $this->getOptions() & self::LOOT_BITS; }
	public function setLootMode($loot_mode) { $this->saveOption(self::LOOT_BITS, false); if ($loot_mode === self::LOOT_CYCLE) { $this->loot_cycle = -1; } return $this->saveOption($loot_mode, true); }
	public function getKiller(SR_Player $player)
	{
		switch ($this->getLootMode())
		{
			case self::LOOT_RAND: return $this->getRandomMember();
			case self::LOOT_CYCLE: return $this->getKillerCycle($player);
			case self::LOOT_USER: return $this->getKillerUser($player);
			default:
			case self::LOOT_KILL: return $player;
		}
	}	
	private function getKillerCycle(SR_Player $player)
	{
		$this->loot_cycle++;
		if ($this->loot_cycle >= $this->getMemberCount())
		{
			$this->loot_cycle = 0;
		}
		$killer = array_slice($this->members, $this->loot_cycle, 1);
		return $killer[0];
	}
	
	public function getKillerUser(SR_Player $player)
	{
		if (false === ($killer = $this->getMemberByPID($this->loot_user))) {
			return $player;
		}
		return $killer;
	}
	
	###################
	### Party Level ###
	###################
	public function getPartyXP() { return $this->getVar('sr4pa_xp') / 100; }
	public function getPartyXPTotal() { return $this->getVar('sr4pa_xp_total') / 100; }
	public function getPartyLevel() { return $this->getVar('sr4pa_level'); }
	public function savePartyLevel($level) { return $this->saveVar('sr4pa_level', $level); }
	public function givePartyXP($xp)
	{
		$xp_gain = (int)round($xp*100);
		
		if ($xp_gain <= 0)
		{
			return true;
		}
		
		$xpl = self::XP_PER_LEVEL*100;
		$xp = $this->getVar('sr4pa_xp') + $xp_gain;
		$data = array('sr4pa_xp_total'=>$this->getVar('sr4pa_xp_total')+$xp);
		$gain = (int)($xp/$xpl);
		
		if ($gain > 0)
		{
			$data['sr4pa_level'] = $this->getVar('sr4pa_level') + $gain;
			$xp = $xp % $xpl;
		}
		$data['sr4pa_xp'] = $xp;
		
		if (false === ($this->saveVars($data)))
		{
			return false;
		}
		
		if ($gain > 0)
		{
			$this->ntice('5003', array($this->getPartyLevel()));
// 			$this->notice(sprintf('The party advanced to level %s.', $this->getPartyLevel()));
		}
		
		return true;
	}
	
	#############
	### Mount ###
	#############
	public function getMounts()
	{
		$back = array();
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			$back[] = $member->getMount();
		}
		return $back;
	}
	
	private function filterSmallMounts($mounts)
	{
		$mc = $this->getMemberCount();
		foreach ($mounts as $i => $mount)
		{
			$mount instanceof SR_Mount;
			if ($mount->getMountPassengers() < $mc)
			{
				unset($mounts[$i]);
			}
		}
		return array_values($mounts);
	}
	
	public static function sort_mount_eta_asc($a, $b)
	{
		$b->getMountTime(1000) - $a->getMountTime(1000);
	}
	
	/**
	 * Get the best available mount for this party.
	 * @return SR_Mount
	 */
	public function getBestMount()
	{
		$mounts = $this->getMounts();
		$mounts = $this->filterSmallMounts($mounts);
		
		usort($mounts, array(__CLASS__, 'sort_mount_eta_asc'));
		
		return $mounts[0];
	}

	/**
	 * Get a cricital mount for this party.
	 * Assume a distribution of all players over a subset of their mounts
	 * such that the travel time is minimal. (Travel time being determined
	 * by the slowest mount in the subset.) We call the slowest mount in
	 * such a subset a critical mount.
	 * @return SR_Mount
	 */
	public function getCriticalMount()
	{
		$mounts = $this->getMounts();
		
		$mc = $this->getMemberCount();
		
		usort($mounts, array(__CLASS__, 'sort_mount_eta_asc'));

		/**
		 * Essentially we fill the fastest mount with the owner and
		 * the (unassigned) owners of the slowest mounts. Then the
		 * second fastest etc.
		 */
		$critical = -1;
		while ( $mc > 0 )
		{
			$mc -= $mounts[++$critical]->getMountPassengers();
		}

		return $mounts[$critical];
	}
	
	################
	### New Enum ###
	################
	public function recomputeEnums()
	{
		$enum = 1;
		foreach ($this->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$member->setEnum($enum++);
		}
	}

	public function swapMembers(SR_Player $a, SR_Player $b)
	{
		$this->members = GWF_Array::swapAssoc($this->members, $a->getID(), $b->getID());
		$this->recomputeEnums();
		return $this->updateMembers();
	}
}
?>
