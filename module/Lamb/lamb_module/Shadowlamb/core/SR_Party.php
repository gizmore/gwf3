<?php
final class SR_Party extends GDO
{
	const NPC_PARTY = 0x01;
	const BAN_ALL = 0x02;
	
	public static $ACTIONS = array('delete', 'talk', 'fight',/* 'search', 'inroom',*/ 'inside', 'outside', 'sleep', 'travel', 'explore', 'goto', 'hunt');
	const ACTION_DELETE = 'delete';
	const ACTION_TALK = 'talk';
	const ACTION_FIGHT = 'fight';
//	const ACTION_SEARCH = 'search';
//	const ACTION_IN_ROOM = 'inroom';
	const ACTION_INSIDE = 'inside';
	const ACTION_OUTSIDE = 'outside';
	const ACTION_SLEEP = 'sleep';
	const ACTION_TRAVEL = 'travel';
	const ACTION_EXPLORE = 'explore';
	const ACTION_GOTO = 'goto';
	const ACTION_HUNT = 'hunt';
	
	private $deleted = false;
	private $members = array();
	private $distance = array();
	
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
			'sr4pa_members' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, '', 255),
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
		);
	}
	
	###################
	### Contact ETA ###
	###################
	public function canMeetEnemies()
	{
		return $this->getVar('sr4pa_contact_eta') < Shadowrun4::getTime();
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
	public function isTalking() { return $this->getAction() === self::ACTION_TALK; }
	public function isFighting() { return $this->getAction() === self::ACTION_FIGHT; }
	public function getDistance(SR_Player $player) { return $this->distance[$player->getID()]; }
	public function isMoving() { return in_array($this->getAction(), array('explore','goto','hunt'), true); }
	public function isDeleted() { return $this->deleted; }
	public function setDeleted($b) { $this->deleted = $b; }
	public function isDone($sr_time)
	{
		if ('0' === ($eta = $this->getETA())) {
			return false; # Unlimited
		}
		return $eta <= $sr_time;
	}
	/**
	 * @return SR_Player
	 */
	public function getLeader() { foreach($this->members as $pid => $player) { return $player; } }
	public function getCity()
	{
		if ($this->isFighting() || $this->isTalking()) {
			$c = $this->getVar('sr4pa_last_target');
		} else {
			$c = $this->getTarget();
		}
		return Common::substrUntil($c, '_', $c);
	}
	/**
	 * @return SR_City
	 */
	public function getCityClass() { return Shadowrun4::getCity($this->getCity()); }
	
	public function getLocation($where='inside')
	{
		if ($this->getAction() !== $where) {
			return false;
		}
		return $this->getVar('sr4pa_target');
	}
	
	/**
	 * @param string $where
	 * @return SR_Location
	 */
	public function getLocationClass($where='inside')
	{
		if (false === ($location = $this->getLocation($where))) {
			return false;
		}
		$city = Common::substrUntil($location, '_');
		$location = Common::substrFrom($location, '_');
		return Shadowrun4::getCity($city)->getLocation($location);
	}
	
	public function getAction() { return $this->getVar('sr4pa_action'); }
	public function getTarget() { return $this->getVar('sr4pa_target'); }
	public function getETA() { return $this->getVar('sr4pa_eta'); }
	public function setETA($eta) { return $this->saveVar('sr4pa_eta', $eta+Shadowrun4::getTime()); }
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
			$eta = Shadowrun4::getTime() + $eta;
		} else {
			$eta = 0;
		}
		
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

		$this->setMemberOptions(SR_Player::PARTY_DIRTY|SR_Player::CMD_DIRTY, true);
		if ($announce === true)
		{
			$this->notice('You continue '.$this->displayAction());
		}

		
		return true;
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
		return Shadowfunc::getFriendlyTarget($this->getLeader(), $name);
//		$name = strtolower($name);
//		foreach ($this->members as $member)
//		{
//			$member instanceof SR_Player;
//			if (strtolower($member->getName()) === $name)
//			{
//				return $member;
//			}
//		}
//		return false;
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
		$this->setMemberOptions(SR_Player::PARTY_DIRTY, true);
		return $this->saveVars(array(
			'sr4pa_members' => implode(',', array_keys($this->members)),
			'sr4pa_distance' => implode(',', array_values($this->distance)),
		));
	}
	
	public function sharesLocation(SR_Party $p)
	{
		$a = $this->getAction();
		if ($a !== self::ACTION_INSIDE && $a !== self::ACTION_OUTSIDE) {
			return false;
		}
		if ($p->getAction() !== $a) {
			return false;
		}
		if ($p->getTarget() !== $this->getTarget()) {
			return false;
		}
		
		if (strpos($p->getTarget(), '_') === false) {
			return false; # just outside town!
		}
		
		return true;
	}
	
	public function setLeader(SR_Player $player)
	{
		if ($player->getPartyID() !== $this->getID()) {
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
			$this->notice(sprintf('You meet %s.', $party->displayMembers()));
			$party->notice(sprintf('You meet %s.', $this->displayMembers()));
		}
		$this->setMemberOptions(SR_Player::PARTY_DIRTY, true);
		$party->setMemberOptions(SR_Player::PARTY_DIRTY, true);
	}
	
	private function initFightBusy($neg=1)
	{
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
			'sr4pa_options' => 0,
			'sr4pa_ban' => NULL,
			'sr4pa_distance' => '',
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
	}
	
	public function notice($message)
	{
		foreach ($this->members as $player)
		{
			$player->message($message);
		}
	}
	
	public function message(SR_Player $player, $message)
	{
		$this->notice($player->getName().$message);
//		$pid = $player->getID();
//		foreach ($this->members as $member)
//		{
//			$member instanceof SR_Player;
//			
////			if ($pid === $member->getID()) {
////				$who = 'You';
////			}
////			else {
////				$who = ;
////			}
//			
//			$member->message($player->getName().$message);
//		}
	}
	
	#################
	### Knowledge ###
	#################
	public function giveKnowledge($field, $knowledge)
	{
		foreach ($this->members as $player)
		{
			$player instanceof SR_Player;
			$player->giveKnowledge($field, $knowledge);
		}
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
		$move = 2.0; #(1.0 + $player->get('quickness')/2);
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
		$this->notice(sprintf('%s walks %.01f meters towards %s and is now on distance %.01f meters. %ds busy.', $name, $move, $tn, $new_d, $busy));
		$this->getEnemyParty()->notice(sprintf('%s walks %.01f meters towards %s and is now on distance %.01f meters.', $name, $move, $tn, $new_d));
	}
	
	public function flee(SR_Player $player)
	{
		$move = 6.0; #(1.0 + $player->get('quickness')/2);
		$d1 = $player->getDistance();
		if ($d1 < 0) {
			$move = -$move;
		}
		$this->distance[$player->getID()] += $move;
		
		$this->updateMembers();
		$busy = $player->busy(12);
		
		$name = $player->getName();
//		$this->notice(sprintf('%s flees %.01f meters from the enemy. %ds busy.', $name, $move, $busy));
//		$this->getEnemyParty()->notice(sprintf('%s flees %.01f meters from you.', $name, $move));
		
		$d2 = $this->getSmallestDistance($player);
		return $d2 >= 10.0;
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
		return $duration <= 0 ? '0s' : GWF_Time::humanDurationEN($duration);
	}
	
	public function displayContactETA()
	{
		$duration = $this->getVar('sr4pa_contact_eta')-Shadowrun4::getTime();
		return $duration <= 0 ? '0s' : GWF_Time::humanDurationEN($duration);
	}
	
	
	public function displayAction()
	{
		$action = $this->getAction();
		switch ($action)
		{
			case 'delete': return 'beeing deleted.';
			case 'talk': return sprintf('talking to %s. %s remaining.', $this->getEnemyParty()->displayMembers(), $this->displayContactETA());
			case 'fight': return sprintf('fighting against %s.', $this->getEnemyParty()->displayMembers(true));
//			case 'search': return sprintf('searching inside %s. %s remaining.', $this->getLocation($action), $this->displayETA());
//			case 'inroom': return sprintf('inside %s in %s.', $this->getLocation($action), $this->getLocation($action));
			case 'inside': return sprintf('inside %s.', $this->getLocation($action));
			case 'outside': return sprintf('outside of %s.', $this->getLocation($action));
			case 'sleep': return sprintf('sleeping inside %s.', $this->getLocation($action));
			case 'travel': return sprintf('travelling to %s. %s remaining.', $this->getLocation($action), $this->displayETA());
			case 'explore': return sprintf('exploring %s. %s remaining.', $this->getLocation($action), $this->displayETA());
			case 'goto': return sprintf('going to %s. %s remaining.', $this->getLocation($action), $this->displayETA());
			case 'hunt': return sprintf('hunting %s. %s remaining.', $this->getTarget(), $this->displayETA());
		}
	}
	
	public function displayMembers($with_distance=false)
	{
		if ($this->getMemberCount() === 0) {
			return 'This party is empty! (should not see me)';
		}
		$back = '';
		foreach ($this->members as $player)
		{
			$player instanceof SR_Player;

			$dist = $with_distance ? sprintf('(%.01fm)', $this->distance[$player->getID()]) : '';
			
			$back .= sprintf(', %s%s', $player->getName(), $dist);
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
		if ($this->getMemberCount() > 0 && $this->getLeader()->isHuman())
		{
			Lamb_Log::log(sprintf('Human party got action delete!'));
		}
		else
		{
			$this->deleteParty();
		}
	}
	
	
	public function on_talk($done)
	{
		if ($this->canMeetEnemies())
		{
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

	public function on_inside($done) {}
	
	public function on_outside($done) {}

	public function on_sleep($done)
	{
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
		if ($done === true)
		{
			$this->pushAction(self::ACTION_INSIDE);
			$this->getCityClass()->onArrive($this);
		}
	}
	
	public function on_explore($done)
	{
		$city = $this->getCityClass();
		$city->onExplore($this, $done);
	}
	
	public function on_goto($done)
	{
		$city = $this->getCityClass();
		$city->onGoto($this, $done);
	}
	
	public function on_hunt($done)
	{
		
	}
}
?>
