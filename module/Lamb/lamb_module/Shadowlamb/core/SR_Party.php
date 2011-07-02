<?php
final class SR_Party extends GDO
{
	const MAX_MEMBERS = 7;
	const XP_PER_LEVEL = 50;
	const X_COORD_INC = 4; # increment x coord per member like 1, 2, 3
	
	const NPC_PARTY = 0x01;
	const BAN_ALL = 0x02;
	
	const LOOT_CYCLE = 0x10;
	const LOOT_KILL = 0x20;
	const LOOT_RAND = 0x40;
	const LOOT_USER = 0x80;
	const LOOT_BITS = 0xF0;
	
	public static $ACTIONS = array('delete','talk','fight','inside','outside','sleep','travel','explore','goto','hunt','hijack');
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
		$i = 1;
		$pid = $player->getID();
		foreach ($this->members as $m)
		{
			if ($m->getID() === $pid)
			{
				return $i;
			}
			$i++;
		}
		return false;
	}
	
	public function getMemberByEnum($n)
	{
		$n = (int)$n;
		if ( ($n < 1) || ($n > $this->getMemberCount()) )
		{
			return false;
		}
		$back = array_slice($this->members, $n-1, 1, false);
		return $back[0];
	}
	
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
	public function getLeader() { foreach($this->members as $pid => $player) { return $player; } }
	
	/**
	 * Get the current city name.
	 * @return string
	 */
	public function getCity()
	{
		$l = $this->getLocation();
		return Common::substrUntil($l, '_', $l);
//		
//		if ($this->isFighting()||$this->isTalking()) {
//			$c = $this->getVar('sr4pa_last_target');
//		}
//		elseif ($this->isHunting()) {
//			return $this->getHuntTargetCity();
//		}
//		else {
//			$c = $this->getTarget();
//		}
//		return Common::substrUntil($c, '_', $c);
	}
	/**
	 * @return SR_City
	 */
	public function getCityClass() { return Shadowrun4::getCity($this->getCity()); }
	
	/**
	 * Get the current location Full_Name.
	 * @param string $action
	 * @return
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
		if ($target === NULL) {
			$target = $this->getTarget();
		}
		if ($eta >= 0) {
			$eta = round(Shadowrun4::getTime() + $eta);
		} else {
			$eta = 0;
		}
		
		$this->timestamp = time();
		
		$this->setMemberOptions(SR_Player::PARTY_DIRTY|SR_Player::CMD_DIRTY, true);
		
		return $this->saveVars(array(
			'sr4pa_action' => $action,
			'sr4pa_target' => $target,
			'sr4pa_eta' => $eta,
			'sr4pa_last_action' => $this->getAction(),
			'sr4pa_last_target' => $this->getTarget(),
			'sr4pa_last_eta' => $this->getETA(),
		));
	}
	
	public function popAction($announce=false)
	{
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

		$this->setMemberOptions(SR_Player::PARTY_DIRTY|SR_Player::CMD_DIRTY, true);
		if ($announce === true)
		{
			$this->notice('You continue '.$this->displayAction());
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
					$this->notice(sprintf('%s thanked you and left the party.', $member->getName()));
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
		}
	}
	
	public function kickUser(SR_Player $player, $update=true)
	{
		$pid = $player->getID();
		unset($this->members[$pid]);
		unset($this->distance[$pid]);
		if ($update === true)
		{
			$this->updateMembers();
			if ($this->getMemberCount() === 0)
			{
				$this->deleteParty();
			}
		}
	}
	
	public function updateMembers()
	{
		$this->timestamp = time();
		$this->setMemberOptions(SR_Player::PARTY_DIRTY, true);
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
		return $this->updateMembers();
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
		$this->pushAction(self::ACTION_FIGHT, $party->getID(), 0);
		$party->pushAction(self::ACTION_FIGHT, $this->getID(), 0);
		$this->initFightBusy(1);
		$party->initFightBusy(-1);
		$this->setContactEta(rand(8,25));
		$party->setContactEta(rand(8,25));
		if ($announce === true)
		{
			$this->notice(sprintf('You encounter %s.', $party->displayMembers(true)));
			$party->notice(sprintf('You encounter %s.', $this->displayMembers(true)));
		}
		$this->setMemberOptions(SR_Player::PARTY_DIRTY, true);
		$party->setMemberOptions(SR_Player::PARTY_DIRTY, true);
	}
	
	public function talk(SR_Party $party, $announce=true)
	{
		$this->pushAction(self::ACTION_TALK, $party->getID(), 0);
		$party->pushAction(self::ACTION_TALK, $this->getID(), 0);
		$this->setContactEta(60);
		$party->setContactEta(60);
		
		if ($announce === true)
		{
			$this->notice(sprintf('You meet %s.%s', $party->displayMembers(), SR_Bounty::displayBountyParty($party)));
			$party->notice(sprintf('You meet %s.%s', $this->displayMembers(), SR_Bounty::displayBountyParty($this)));
		}
		
		$this->setMemberOptions(SR_Player::PARTY_DIRTY, true);
		$party->setMemberOptions(SR_Player::PARTY_DIRTY, true);
	}
	
	private function initFightBusy($neg=1)
	{
		$this->direction = $neg > 0 ? -1 : +1;
		
		foreach ($this->members as $member)
		{
			$member instanceof SR_Player;
			$pid = $member->getID();
			$member->busy(SR_Player::FIGHT_INIT_BUSY);
			$member->combatPush('');
			$this->distance[$pid] = $neg * $member->getBase('distance');
		}
	}
	
	##############
	### Static ###
	##############
	public static function getByID($partyid)
	{
		if (false === ($party = self::table(__CLASS__)->getRow($partyid))) {
			return false;
		}
		if (false === $party->initMembers()) {
			return false;
		}
		return $party;
	}
	
	public function initMembers()
	{
		foreach (explode(',',$this->getVar('sr4pa_members')) as $playerid)
		{
			if (false !== ($player = Shadowrun4::getPlayerByPID($playerid)))
			{
				$this->addUser($player, false);
			} 
		}
		if (false === $this->updateMembers()) {
			return false;
		}
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
		if (false === ($party->insert())) {
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
			$member->deletePlayer();
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
	
	public function notice($message)
	{
		foreach ($this->members as $player)
		{
			$player->message($message);
		}
		return true;
	}
	
	public function message(SR_Player $player, $message)
	{
		return $this->notice($player->getName().$message);
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
	
	#############
	### Stats ###
	#############
	public function getMin($field)
	{
		$min = PHP_INT_MAX;
		foreach ($this->members as $member)
		{
			$t = $member->get($field);
			if ($t < $min) {
				$min = $t;
			}
		}
		return $min;
	}
	
	public function getMax($field)
	{
		$max = -1;
		foreach ($this->members as $member)
		{
			$t = $member->get($field);
			if ($t > $max) {
				$max = $t;
			}
		}
		return $max;
	}
	
	public function getSum($field)
	{
		$sum = 0;
		foreach ($this->members as $member)
		{
			$sum += $member->get($field);
		}
		return $sum;
	}
	
	################
	### Distance ###
	################
//	public function forward(SR_Player $player, $neg=1)
//	{
//		$d = (1.0 + $player->get('quickness')/2) * $neg;
//		$old = $this->distance[$player->getID()];
//		$this->distance[$player->getID()] += $d;
//		$this->updateMembers();
//		$busy = $player->busy(15);
//		$name = $player->getName();
//		$this->notice(sprintf('%s walks %.01f meters towards the enemy. %ds busy.', $name, $d, $busy));
//		$this->getEnemyParty()->notice(sprintf('%s walks %.01f meters towards you.', $name, $d));
//	}
//	
//	public function backward(SR_Player $player)
//	{
//		return $this->forward($player, -1);
//	}
	public function moveTowards(SR_Player $player, SR_Player $target)
	{
		$move = $player->getMovePerSecond();
//		$busy = $player->busy(25);
		$d1 = $player->getDistance();
		$d2 = $target->getDistance();
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
		$this->distance[$player->getID()] -= $move;
		$new_d = $this->distance[$player->getID()];
		$this->updateMembers();
		$busy = $player->busy(25);
		$name = $player->getName();
		$tn = $target->getName();
		$this->notice(sprintf('%s walks %.01f meters towards %s and is now on position %.01f meters. %ds busy.', $name, -$move, $tn, $new_d, $busy));
		$this->getEnemyParty()->notice(sprintf('%s walks %.01f meters towards %s and is now on position %.01f meters.', $name, -$move, $tn, $new_d));
	}
	
	###############
	### FW / BW ###
	###############
	public function forward(SR_Player $player, $busy=-1) { return $this->forwardB($player, $this->direction, 'forwards', $busy); }
	public function backward(SR_Player $player, $busy=-1) { return $this->forwardB($player, -$this->direction, 'backwards', $busy); }
	private function forwardB(SR_Player $player, $dir, $fwbw, $busy=-1)
	{
		$move = $dir * $player->getMovePerSecond();
		$d = $this->distance[$player->getID()] + $move;
		$this->distance[$player->getID()] = $d;
		$this->updateMembers();
		
		$busy = $busy > 0 ? ', '.Shadowfunc::displayBusy($player->busy($busy)) : '';
		$message = sprintf(' moves %sm %s and is now on position %.02fm%s.', $move, $fwbw, $d, $busy);
		$this->message($player, $message);
		$this->getEnemyParty()->message($player, $message);
		return true;
	}
	
	public function movePlayer(SR_Player $player, $forward=true, $metres=0)
	{
		if ( ($metres <= 0) )
		{
			return false;
		} 
		
		$dir = $forward ? 1 : -1;
		$move = $dir * $metres;
		$d = $this->distance[$player->getID()] + $move;
		$this->distance[$player->getID()] = $d;
		$this->updateMembers();
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
	
	
	public function displayAction()
	{
		$b = chr(2);
		$action = $this->getAction();
		switch ($action)
		{
			case 'delete': return "{$b}beeing deleted{$b}.";
			case 'talk':
				$ep = $this->getEnemyParty();
				$epm = $ep === false ? 'Empty party' : $ep->displayMembers();
				return sprintf("{$b}talking{$b} to %s. %s remaining.%s", $epm, $this->displayContactETA(), $this->displayLastAction());
			case 'fight': return sprintf("{$b}fighting{$b} against %s.%s", $this->getEnemyParty()->displayMembers(true), $this->displayLastAction());
			case 'inside': return sprintf("{$b}inside{$b} %s.", $this->getLocation());
			case 'outside':
				$city = $this->getCityClass();
				if ($this->isAtLocation() || (!$city->isDungeon()))
				{
					return sprintf("{$b}outside{$b} of %s.", $this->getLocation());
				}
				else
				{
					return sprintf("somewhere inside %s.", $this->getLocation());
				}
			case 'sleep': return sprintf("{$b}sleeping{$b} inside %s.", $this->getLocation());
			case 'travel': return sprintf("{$b}travelling{$b} to %s. %s remaining.", $this->getLocation(), $this->displayETA());
			case 'explore': return sprintf("{$b}exploring{$b} %s. %s remaining.", $this->getLocation(), $this->displayETA());
			case 'goto': return sprintf("{$b}going{$b} to %s. %s remaining.", $this->getLocation(), $this->displayETA());
			case 'hunt': return sprintf("{$b}hunting{$b} %s. %s remaining.", $this->getTarget(), $this->displayETA());
			case 'hijack': return sprintf("{$b}hijacking{$b} %s at %s. %s remaining.", $this->getTarget(), $this->getLocation(), $this->displayETA());
			default: return 'UNKNOWN PARTY ACTION IS UNKNOWN.';
		}
	}
	
	public function displayLastAction()
	{
		$la = $this->getVar('sr4pa_last_action');
		
		switch ($la)
		{
			case 'goto':
			case 'hunt':
			case 'explore':
			case 'travel':
				$lt = $this->getVar('sr4pa_last_target');
				$le = $this->displayLastETA();
				return sprintf(' Last action: %s %s. %s.', $la, $lt, $le);
				
			default:
				return '';
		}
	}
	
	public function displayMembers($with_distance=false)
	{
		if ($this->getMemberCount() === 0) {
			return 'This party is empty! (should not see me)';
		}
		$b = chr(2);
		$i = 1;
		$back = '';
		foreach ($this->members as $player)
		{
			$player instanceof SR_Player;
			$dist = $with_distance ? sprintf('(%.01fm)', $this->distance[$player->getID()]) : '';
			$back .= sprintf(', %s-%s%s', $b.($i++).$b, $player->getName(), $dist);
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
				Lamb_Log::logError(sprintf('Human party %d got action delete!', $this->getID()));
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
				$player instanceof SR_Player;
				$player->combatTimer();
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
		$this->popAction(true);
		$this->setContactEta(rand(15,25));
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
			$player->healHP(0.1);
			$player->healMP(0.1);
			if ($player->hasFullHPMP()) {
				$player->message('You awake and have a delicious breakfast.');
			}
		}
		if ($sleeping === 0)
		{
			$this->popAction();
			$this->notice('You are ready to go.');
		}
	}
	
	
	public function on_travel($done)
	{
		$this->timestamp = time();
		if ($done === true)
		{
			$this->pushAction(self::ACTION_INSIDE);
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
		$city = $this->getCityClass();
		$city->onHijack($this, $done);
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
	public function givePartyXP($xp)
	{
		$xp_gain = (int)round($xp*100);
		if ($xp_gain <= 0) {
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
		
		if (false === ($this->saveVars($data))) {
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}
		
		if ($gain > 0) {
			$this->notice(sprintf('The party advanced to level %s.', $this->getPartyLevel()));
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
			if ($member->hasEquipment('mount'))
			{
				$back[] = $member->getEquipment('mount');
			}
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
		
		if (count($mounts) === 0)
		{
			return $this->getLeader()->getPockets();
		}
		
		usort($mounts, array(__CLASS__, 'sort_mount_eta_asc'));
		
		return $mounts[0];
	}
}
?>
