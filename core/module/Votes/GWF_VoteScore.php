<?php

final class GWF_VoteScore extends GDO #implements GDO_Sortable, GDO_Editable
{
	#################
	### Constants ###
	#################
	const DATE_LEN = GWF_Date::LEN_SECOND;
	const ENABLED = 0x01;
	const GUEST_VOTES = 0x02; 
	const SHOW_RESULT_ALWAYS = 0x10;
	const SHOW_RESULT_VOTED = 0x20;
	const SHOW_RESULT_NEVER = 0x40;
	const IRREVERSIBLE = 0x100;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'vote_score'; }
	public function getOptionsName() { return 'vs_options'; }
	public function getColumnDefines()
	{
		return array(
			'vs_id' => array(GDO::AUTO_INCREMENT),
			'vs_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::UNIQUE, GDO::NOT_NULL, 63),
			'vs_date' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, self::DATE_LEN),
			'vs_expire_date' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, self::DATE_LEN),
			'vs_options' => array(GDO::UINT, 0),
			
			'vs_min' => array(GDO::INT, GDO::NOT_NULL),
			'vs_max' => array(GDO::INT, GDO::NOT_NULL),
			'vs_avg' => array(GDO::DECIMAL, GDO::NULL, array('4', '4')),
			'vs_sum' => array(GDO::INT, GDO::NULL),
			'vs_count' => array(GDO::UINT, 0),
		);
	}
//	public function __toString() { return $this->display('vs_name'); }
	
	####################
	### GDO_Editable ###
	####################
//	public function getEditableFields(GWF_User $user)
//	{
//		return array(
//			'vs_name',
//			'vs_date',
//			'vs_expire_date',
//			'vs_options&'.self::ENABLED,
//			'vs_options&'.self::GUEST_VOTES,
//			'vs_options&&1&'.self::SHOW_RESULT_ALWAYS,
//			'vs_options&&1&'.self::SHOW_RESULT_VOTED,
//			'vs_options&&1&'.self::SHOW_RESULT_NEVER,
//			'vs_min',
//			'vs_max',
//			'vs_avg',
//			'vs_sum',
//			'vs_count',
//		);
//	}
	
//	public function getEditableFormData(GWF_User $user)
//	{
//		return array();
//	}
//	
//	public function getEditableActions(GWF_User $user)
//	{
//		return array('edit', 'delete', 'recalc');
//	}
//	
	
	####################
	### GDO_Sortable ###
	####################
//	public function getSortableDefaultBy(GWF_User $user) { return 'vs_id'; }
//	public function getSortableDefaultDir(GWF_User $user) { return 'ASC'; }
//	public function getSortableFields(GWF_User $user)
//	{
//		return array(
//			'vs_id',
//			'vs_name',
//			'vs_date',
//			'vs_expire_date',
//			'vs_options&'.self::ENABLED,
//			'vs_options&'.self::GUEST_VOTES,
//			'vs_options&&1&'.self::SHOW_RESULT_ALWAYS,
//			'vs_options&&1&'.self::SHOW_RESULT_VOTED,
//			'vs_options&&1&'.self::SHOW_RESULT_NEVER,
//			'vs_min',
//			'vs_max',
//			'vs_avg',
//			'vs_sum',
//			'vs_count',
//		);
//	}
//	
//	public function getDisplayableFields(GWF_User $user) { return array(); }
//	public function displayColumn(GWF_Module $module, GWF_User $user, $field)
//	{
//		switch ($field)
//		{
//			case 'vs_id':
//				return GWF_Button::edit($this->getEditHREF(), $this->getID());
//			case 'vs_name':
//				return GWF_Button::show($this->display('vs_name'), $this->getOverviewHREF());
//			case 'vs_date': 
//			case 'vs_expire_date':
//				return GWF_Time::displayDate(field);
////			case 'vs_options&'.self::ENABLED:
////				return GWF_Button::checkmark($this->isOptionEnabled(self::ENABLED), '', $this->getEditHREF());
////			case 'vs_options&'.self::GUEST_VOTES:
////			case 'vs_options&&1&'.self::SHOW_RESULT_ALWAYS:
////			case 'vs_options&&1&'.self::SHOW_RESULT_VOTED:
////			case 'vs_options&&1&'.self::SHOW_RESULT_NEVER:
//				
//			case 'vs_min':
//			case 'vs_max':
//			case 'vs_avg':
//			case 'vs_sum':
//			case 'vs_count':
//				return $this->getVar($field);
//			default:
//				return $field;
//		}
//	}
	
	public function getEditHREF() { return GWF_WEB_ROOT.sprintf('index.php?mo=Votes&me=Staff&editvs=%s', $this->getID()); }
	public function getShowHREF() { return GWF_WEB_ROOT.sprintf('index.php?mo=Votes&me=Staff&showvs=%s', $this->getID()); }
	
	##################
	### Convinient ###
	##################
	public function getID() { return $this->getVar('vs_id'); }
	public function getSum() { return $this->getVar('vs_sum'); }
	public function getCount() { return $this->getVar('vs_count'); }
	public function getMin() { return $this->getVar('vs_min'); }
	public function getMax() { return $this->getVar('vs_max'); }
	public function getAvg() { return $this->getVar('vs_avg'); }
	public function getMiddle() { return (double)(($this->getVar('vs_max') - $this->getVar('vs_min')) / 2); }
	public function isGuestVote() { return $this->isOptionEnabled(self::GUEST_VOTES); }
	public function isDisabled() { return !$this->isOptionEnabled(self::ENABLED); }
	public function isInRange($score) { return $score >= $this->getVar('vs_min') && $score <= $this->getVar('vs_max'); }
	public function isIrreversible() { return $this->isOptionEnabled(self::IRREVERSIBLE); }
	public function isExpired()
	{
		if ('' === ($vsed = $this->getVar('vs_expire_date'))) {
			return false;
		}
		return $vsed < GWF_Time::getDate(self::DATE_LEN);
	}
	
	public function getAvgPercent()
	{
		$avg = $this->getAvg();
		$min = $this->getMin();
		$max = $this->getMax();
		$max -= $min;
		$avg -= $min;
		return $max == 0 ? 0 : $avg / $max * 100;
	}
	
	
	######################
	### Static Getters ###
	######################
	/**
	 * Get a votescore by id.
	 * @param int $votescore_id
	 * @return GWF_VoteScore
	 */
	public static function getByID($votescore_id)
	{
		return self::table(__CLASS__)->getRow($votescore_id);
	}
	
	/**
	 * Get a votescore by name.
	 * @param string $name
	 * @return GWF_VoteScore
	 */
	public static function getByName($name)
	{
		return self::table(__CLASS__)->selectFirstObject('*', "vs_name='".self::escape($name)."'");
	}
	
	################
	### Creation ###
	################
	/**
	 * Create new Voting table. Name is an identifier for yourself, for example module links has all voting table named as link_%d. An expire time of 0 means no expire
	 * @param string $name
	 * @param int $min
	 * @param int $max
	 * @param int $expire_time
	 * @param int $options
	 * @return GWF_VoteScore
	 */
	public static function newVoteScore($name, $min, $max, $expire_time, $options)
	{
		# Valid expire time.
		if (!is_int($expire_time)) {
			$expire_time = 0;
		} else {
			$expire_time = ($expire_time > 0) ? $expire_time + time() : 0;
		}
		
		$min = (int) $min;
		$max = (int) $max;
		
		if ($max === $min)
		{
			GWF_Log::logCritical('NOTHING TO VOTE! (MIN==MAX=='.$min.')');
			return false;
		}
		
		if (false !== ($vs = self::getByName($name))) {
			if (false === $vs->resetVotes($min, $max, $expire_time, $options)) {
				return false;
			}
			return $vs;
		}
		
		return new self(array(
			'vs_name' => $name,
			'vs_date' => GWF_Time::getDate(self::DATE_LEN),
			'vs_expire_date' => $expire_time === 0 ? '' : GWF_Time::getDate(self::DATE_LEN, $expire_time),
			'vs_options' => $options,
			'vs_min' => $min,
			'vs_max' => $max,
			'vs_avg' => ($max + $min ) / 2,
			'vs_count' => 0,
			'vs_sum' => 0,
		));
	}
	
	public function resetVotes($min, $max, $expire_time, $options)
	{
		$id = $this->getVar('vs_id');
		if (false === GDO::table('GWF_VoteScoreRow')->deleteWhere("vsr_vsid=$id")) {
			return false;
		}
		
		return $this->saveVars(array(
			'vs_expire_date' => $expire_time <= 0 ? '' : GWF_Time::getDate(self::DATE_LEN, $expire_time),
			'vs_options' => $options,
			'vs_min' => $min,
			'vs_max' => $max,
			'vs_avg' => ($max + $min ) / 2,
			'vs_count' => 0,
			'vs_sum' => 0,
		));
	}
	
	public function resetVotesSameSettings()
	{
		if ('' === ($expire_time = $this->getVar('vs_expire_date'))) {
			$expire_time = 0;
		} else {
			$expire_time = GWF_Time::getTimestamp($expire_time);
		}
		return $this->resetVotes($this->getMin(), $this->getMax(), $expire_time, $this->getOptions());
	}

	public function getInitialAvg()
	{
		return ($this->getVar('vs_min') + $this->getVar('vs_max')) / 2;
	}
	
	################
	### Rollback ###
	################
	public function countVote(GWF_VoteScoreRow $row, $negative=1)
	{
		if ($negative !== -1 && $negative !== 1) {
			return false;
		} 
		
		$newCount = $this->getVar('vs_count') + $negative;
		$newSum = $this->getVar('vs_sum') + ($row->getScore() * $negative);
		$newAvg = ($newCount === 0) ? ($this->getInitialAvg()) : ($newSum / $newCount);
		return $this->saveVars(array(
			'vs_count' => $newCount,
			'vs_sum' => $newSum,
			'vs_avg' => $newAvg,
		));
	}
	
	public function revertVote(GWF_VoteScoreRow $row, $ip, $userid)
	{
//		echo '<div>REVERT VOTE!</div>';
		if (false === $this->countVote($row, -1)) {
//			echo GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
			return false;
		}
		
		$vsid = $this->getID();
//		$ip = (int) $ip;
		if ($ip === 0) {
			$userid = (int) $userid;
			return $row->deleteWhere("vsr_vsid=$vsid AND vsr_uid=$userid");
		} else {
			$ip = GDO::escape($ip);
			return $row->deleteWhere("vsr_vsid=$vsid AND vsr_ip='$ip'");
		}
	}
	
	############
	### Vote ###
	############
	public function onGuestVote($score, $ip)
	{
		return $this->onUserVote($score, 0, $ip);
	}
	
	public function onUserVote($score, $userid, $ip)
	{
		$vsr = new GWF_VoteScoreRow(array(
			'vsr_vsid' => $this->getVar('vs_id'),
			'vsr_uid' => $userid,
			'vsr_ip' => $ip,
			'vsr_time' => time(),
			'vsr_score' => $score,
		));
		if (false === ($vsr->insert())) {
			return false;
		}
		return $this->countVote($vsr, 1);
	}
	
	public function hasVoted($user)
	{
		if ($user === false) {
			return $this->hasVotedGuest();
		} else {
			return $this->hasVotedUser($user);
		}
	}
	
	private function hasVotedGuest()
	{
		return GWF_VoteScoreRow::getByIP($this->getID(), GWF_IP6::getIP(GWF_IP_QUICK)) !== false;
	}
	
	private function hasVotedUser(GWF_User $user)
	{
		return GWF_VoteScoreRow::getByUID($this->getID(), $user->getID()) !== false;
	}
	
	/**
	 * Vote and revert votes safely. Return false or error msg.
	 * @param int $score
	 * @param int $userid
	 * @return error msg or false
	 */
	public function onUserVoteSafe($score, $userid)
	{
		$userid = (int)$userid;
		$vsid = $this->getID();
		
		# Revert Guest Vote with same IP
		$ip = GWF_IP6::getIP(GWF_IP_QUICK);
//		var_dump($ip);
		if (false !== ($vsr = GWF_VoteScoreRow::getByIP($vsid, $ip)))
		{
//			echo '<div>HAVE GUEST VOTE</div>';
//			var_dump($vsr);
			if (!$vsr->isGuestVoteExpired(GWF_Module::getModule('Votes')->cfgGuestTimeout())) {
				if (false === $this->revertVote($vsr, $ip, 0)) {
					return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
				}
			}
		}

		# Revert Users Vote
		if (false !== ($vsr = GWF_VoteScoreRow::getByUID($vsid, $userid)))
		{
//			echo '<div>HAVE OLD VOTE</div>';
			if (false === $this->revertVote($vsr, 0, $userid)) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}

		# And Vote it
		if (false === $this->onUserVote($score, $userid, 0)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return false; # No error
	}
	
	###############
	### Display ###
	###############
	public function displayButtons()
	{
		if (false === ($module = GWF_Module::getModule('Votes'))) {
			return '';
		}
		$module instanceof Module_Votes;
		return $module->templateVoteScore($this);
	}
	
	public function displayPercent()
	{
		return sprintf('%.02f%%', $this->getAvgPercent());
	}
	
	#############
	### HREFs ###
	#############
	public function hrefVote($score)
	{
		return GWF_WEB_ROOT.'vote/'.$this->getVar('vs_id').'/with/'.$score;
	}

	public function hrefButton($score, $size='16')
	{
		return sprintf('%svotes/button/%s/%s/of/%s.png', GWF_WEB_ROOT, $size, $score, $this->getVar('vs_max'));
	}
	
	############
	### Ajax ###
	############
	public function getOnClick($score)
	{
//		$score = (int) $score;
		$vsid = $this->getVar('vs_id');
		return "gwfVoteScore($vsid, $score); return false;";
	}
	
	##############
	### Delete ###
	##############
	/**
	 * Delete this voting table and it`s votes.
	 * @return boolean
	 */
	public function onDelete()
	{
		if (false === GDO::table('GWF_VoteScoreRow')->deleteWhere('vsr_vsid='.$this->getID())) {
			return false;
		}
		
		return $this->delete();
	}
	
	/**
	 * Refresh the votescore from votescorerows.
	 */
	public function refreshCache()
	{
		$vsid = $this->getID();
		if (false === ($result = GDO::table('GWF_VoteScoreRow')->selectFirst("AVG(vsr_score), SUM(vsr_score), COUNT(*)", "vsr_vsid={$vsid}", '', NULL, GDO::ARRAY_N)))
		{
			return false;
		}
		return $this->saveVars(array(
			'vs_avg' => $result[0] === NULL ? $this->getInitialAvg() : $result[0],
			'vs_sum' => $result[1],
			'vs_count' => $result[2],
		));
	}
}

?>