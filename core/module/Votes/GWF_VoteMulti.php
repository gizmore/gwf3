<?php
/**
 * A Multi Vote is a Poll.
 * Supported are multiple choice, single choice, guest votes, expiration dates.
 * @author gizmore
 * @version 1.0
 */
final class GWF_VoteMulti extends GDO
{
	# Constant
	const DATE_LEN = GWF_Date::LEN_SECOND;
	
	# Options
	const ENABLED = 0x01;
	const GUEST_VOTES = 0x02;
	const MULTIPLE_CHOICE = 0x04;
	const EXPIRES = 0x08;
	const SHOW_RESULT_ALWAYS = 0x10;
	const SHOW_RESULT_VOTED = 0x20;
	const SHOW_RESULT_NEVER = 0x40;
	const VIEW_FLAGS = 0x70;
	const INTERNAL_VOTE = 0x80; # (we are not publicy visible, or a thread_poll etc)
	const IRREVERSIBLE = 0x100;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'vote_multi'; }
	public function getOptionsName() { return 'vm_options'; }
	public function getColumnDefines()
	{
		return array(
			'vm_id' => array(GDO::AUTO_INCREMENT),
			'vm_uid' => array(GDO::UINT|GDO::INDEX), 
		
			'vm_gid' => array(GDO::UINT|GDO::INDEX),
			'vm_level' => array(GDO::UINT|GDO::INDEX),
		
			'vm_date' => array(GDO::DATE, GDO::NOT_NULL, self::DATE_LEN),
//			'vm_expiredate' => array(GDO::DATE, GDO::NOT_NULL, self::DATE_LEN),
			'vm_name' => array(GDO::TOKEN, GDO::NOT_NULL, 63),
			'vm_title' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'vm_options' => array(GDO::UINT, 0),
		
			# The choices as array
//			'vm_vmo' => array(GDO::GDO_ARRAY, false, array('GWF_VoteMultiOpt', 'vmo_vmoid', 'vm_id', 'vmo_vmid'), array('votemulti')),
			'vm_votes' => array(GDO::UINT, 0), # total votes
			
//			'choices' => array(GDO::JOIN, false, array('GWF_VoteMultiOpt', 'vmo_vmid', 'vm_id')),
		);
	}
	
	##################
	### Convinient ###
	##################
	public function getUserID() { return $this->getVar('vm_uid'); }
	public function getGroupID() { return $this->getVar('vm_gid'); }
	public function getLevel() { return $this->getVar('vm_level'); }
	public function getChoices() { return $this->getVar('vm_vmo', array()); }
	public function getNumChoices() { return count($this->getChoices()); }
	public function getVotecount() { return $this->getVar('vm_votes'); }
	public function getViewFlag() { return $this->getVar('vm_options') & 0x70; }
	public function isGlobal() { return !$this->isOptionEnabled(self::INTERNAL_VOTE); }
	public function isEnabled() { return $this->isOptionEnabled(self::ENABLED); }
	public function isMultipleChoice() { return $this->isOptionEnabled(self::MULTIPLE_CHOICE); }
	public function isGuestVoteAllowed() { return $this->isOptionEnabled(self::GUEST_VOTES); }
	public function isIrreversible() { return $this->isOptionEnabled(self::IRREVERSIBLE); }
	
	#############
	### HREFs ###
	#############
	public function hrefEdit() { return GWF_WEB_ROOT.'index.php?mo=Votes&me=EditPoll&vmid='.$this->getVar('vm_id'); }
	public function hrefShow() { return GWF_WEB_ROOT.'show_poll/'.$this->getVar('vm_id').'/'.$this->urlencodeSEO('vm_title'); }
	
	###############
	### Display ###
	###############
	public function canSeeOutcome($user)
	{
		switch ($this->getOptions()&self::VIEW_FLAGS)
		{
			case self::SHOW_RESULT_NEVER: return false;
			case self::SHOW_RESULT_VOTED: return $this->hasVoted($user);
			case self::SHOW_RESULT_ALWAYS: return true;
		}
	}
	
	public function hasVoted($user)
	{
		if ($user === false) {
			return $this->hasVotedGuest();
		}
		return $this->hasVotedUser($user);
	}
	
	public function hasVotedUser(GWF_User $user)
	{
		return GWF_VoteMultiRow::hasVotedUser($this->getID(), $user->getID());
	}
	
	public function hasVotedGuest()
	{
		return GWF_VoteMultiRow::hasVotedGuest($this->getID(), GWF_IP6::getIP(GWF_IP_QUICK) );
	}
	
	public function displayVotecount($user, $index)
	{
		return $this->gdo_data['vm_vmo'][$index]['vmo_votes'];
	}
	
	public function displayTopAnswers()
	{
		$max = 0;
		
		foreach ($this->gdo_data['vm_vmo'] as $i => $data)
		{
			$votes = (int) $data['vmo_votes'];
			if ($votes > $max) {
				$max = $votes;
			}
		}
		
		$top = array();
		foreach ($this->gdo_data['vm_vmo'] as $i => $data)
		{
			if ($max === (int) $data['vmo_votes']) {
				$top[] = $data['vmo_text'];
			}
		}

		return implode(', ', $top);
	}
	
	#################
	### Validator ###
	#################
	public static function isValidViewFlag($bit)
	{
		$bit = (int) $bit;
		return $bit === 0x10 || $bit === 0x20 || $bit === 0x40;
	}

	##################
	### Permission ###
	##################
	public static function permqueryRead($user)
	{
		if ($user instanceof GWF_User)
		{
			$ug = GWF_TABLE_PREFIX.'usergroup';
			$uid = $user->getID();
			$lvl = $user->getLevel();
			return " (vm_level<=$lvl AND (vm_gid=0 OR (SELECT 1 FROM $ug WHERE ug_groupid=vm_gid AND ug_userid=$uid)))";
		}
		else
		{
			return "vm_level=0 AND vm_gid=0";
		}
	}

	public function mayVote($user)
	{
		if (!$this->isEnabled()) {
			return false;
		}
		
		if ($user instanceof GWF_User)
		{
			if ($user->isWebspider()) {
				return false;
			}
			if (!$user->isInGroupID($this->getVar('vm_gid'))) {
				return false;
			}
			if ($user->getLevel() < $this->getLevel()) {
				return false;
			}
			
			return true;
		}
		
		else
		{
			return $this->isOptionEnabled(self::GUEST_VOTES);
		}
	}
	
	public function mayEdit($user)
	{
		if ($user === false) {
			return false;
		}
		if ($user->isAdmin()) {
			return true;
		}
		return $user->getID() === $this->getUserID();
	}
	
	##############
	### Static ###
	##############
	/**
	 * Get a poll.
	 * @param int $vmid
	 * @return GWF_VoteMulti
	 */
	public static function getByID($vmid)
	{
//		return self::table(__CLASS__)->getBy('vm_id', $vmid, GDO::ARRAY_O, array('choices'));
		if(false === ($back = self::table(__CLASS__)->getRow($vmid)))
		{
			return false;
		}
		$back->loadVoteOptions();
		return $back;
	}
	
	public function loadVoteOptions()
	{
		return $this->setVar('vm_vmo', $this->loadVoteOptionsB());
	}
	
	private function loadVoteOptionsB()
	{
		$id = $this->getID();
		return GDO::table('GWF_VoteMultiOpt')->selectArrayMap('vmo_vmoid,vmo_text,vmo_votes', "vmo_vmid={$id}", 'vmo_vmoid ASC');
	}
	
	/**
	 * Get a poll by name.
	 * @param string $name
	 * @return GWF_VoteMulti
	 */
	public static function getByName($name)
	{
		$t = self::table(__CLASS__);
		return $t->selectFirstObject('*', sprintf("vm_name='%s'", $t->escape($name)));
	}
	
	/**
	 * Create a unique identifier for a poll.
	 * @param unknown_type $user
	 * @return unknown_type
	 */
	public static function createPollName($user)
	{
		$t = self::table(__CLASS__);
		if ($user === false)
		{
			$uid = 0;
			$uname = '_x_guest';
		}
		else
		{
			$uid = $user->getVar('user_id');
			$uname = '_y_'.$user->getVar('user_name');
		}
		
		if (false === ($name = $t->selectVar('vm_name', "vm_uid=$uid", 'vm_date DESC'))) {
			$count = 1;
		} else {
			if (1 === preg_match('/^_(?:x|y)_.+_(\\d+)$/D', $name, $matches)) {
				$count = $matches[1]+1;
			}
			else {
				$count = 1;
			}
		}
//		$count = $t->countRows("vm_uid=$uid") + 1;
		return $uname.'_'.$count;
	}
	
	################
	### Creation ###
	################
	/**
	 * @param unknown_type $name
	 * @param unknown_type $title
	 * @param unknown_type $user
	 * @param unknown_type $options
	 * @param unknown_type $gid
	 * @param unknown_type $level
	 * @return GWF_VoteMulti
	 */
	public static function fakePoll($name, $title, $user, $options=0, $gid=0, $level=0)
	{
//		if (!self::getByName($name) === false) {
//			return false;
//		}
		return new self(array(
			'vm_id' => 0,
			'vm_uid' => $user === false ? 0 : $user->getID(),
			'vm_gid' => $gid,
			'vm_level' => $level,
			'vm_date' => GWF_Time::getDate(self::DATE_LEN),
			'vm_name' => $name,
			'vm_title' => $title,
			'vm_options' => $options,
			'vm_votes' => 0,
		));
	}
	
	public function insertPoll(array $options)
	{
		if (false === ($this->insert())) {
			return false;
		}
		
		$i = 1;
		$pollid = $this->getID();
		foreach ($options as $opt)
		{
			$opt = new GWF_VoteMultiOpt(array(
				'vmo_vmid' => $pollid,
				'vmo_vmoid' => $i++,
				'vmo_text' => $opt,
				'vmo_votes' => 0,
			));
			if (false === ($opt->insert())) {
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Get a select for result viewmode.
	 * @param Module_Votes $module
	 * @param string $name
	 * @return string html select
	 */
	public static function getViewSelect(Module_Votes $module, $name='view', $selected=self::SHOW_RESULT_VOTED)
	{
		$data = array(
			array(self::SHOW_RESULT_NEVER, $module->lang('vmview_never')),
			array(self::SHOW_RESULT_VOTED, $module->lang('vmview_voted')),
			array(self::SHOW_RESULT_ALWAYS, $module->lang('vmview_allways')),
		);
		return GWF_Select::display($name, $data, $selected);
	}
	
	
	public function showResults($pixels=100)
	{
		if (false === ($module = GWF_Module::getModule('Votes'))) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array( 'Votes'));
		}
		
		$module->onLoadLanguage();
		
		$tVars = array(
			'form_action' => $module->getMethodURL('VotePoll'),
			'poll' => $this,
			'pixels' => $pixels,
			'href_edit' => $this->hrefEdit(),
		);
		return $module->templatePHP('poll.php', $tVars);
	}
	
	############
	### Vote ###
	############
	public function onVote($user, array $chosen)
	{
		if ($user === false)
		{
			return $this->onVoteGuest(GWF_IP6::getIP(GWF_IP_QUICK), $chosen);
		}
		else
		{
			return $this->onVoteUser($user, $chosen);
		}
	}

	public function onVoteUser(GWF_User $user, array $chosen)
	{
		$pid = $this->getID();
		$uid = $user->getID();
		$choices = implode(':', $chosen);
		
		if (false !== ($row = GWF_VoteMultiRow::getVoteRowUser($pid, $uid)))
		{
			if (false === $this->onRevert($row)) {
				return false;
			}
			
			if (false === GDO::table('GWF_VoteMultiRow')->update("vmr_choices='$choices'", "vmr_vmid=$pid AND vmr_uid=$uid")) {
				return false;
			}
			
			if (count($chosen) > 0)
			{
				if (false === $this->onApply($chosen)) {
					return false;
				}
			}
		}
		elseif (count($chosen) > 0)
		{
			$row = new GWF_VoteMultiRow(array(
				'vmr_vmid' => $pid,
				'vmr_uid' => $uid,
				'vmr_ip' => 'NULL',
				'vmr_time' => time(),
				'vmr_choices' => $choices,
			));
			if (false === $row->insert()) {
				return false;
			}
			if (false === $this->onApply($chosen)) {
				return false;
			}
		}
		
		return true;
	}
	
	private function onRevert(GWF_VoteMultiRow $row)
	{
		$t = GDO::table('GWF_VoteMultiOpt');
		$pid = $this->getID();
		$choices = $row->getChoicesArray();
		foreach ($choices as $id)
		{
			$id = intval($id);
			if ($id >= 1 && $id <= $this->getNumChoices())
			{
				if (false === $t->update("vmo_votes=vmo_votes-1", "vmo_vmid=$pid AND vmo_vmoid=$id AND vmo_votes>0")) {
					echo GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
					break;
				}
			}
		}
		return $this->update('vm_votes=vm_votes-1', "vm_id=$pid AND vm_votes>0");
	}
	
	private function onApply(array $chosen)
	{
		$t = GDO::table('GWF_VoteMultiOpt');
		$pid = $this->getID();
		foreach ($chosen as $id)
		{
			if (false === $t->update("vmo_votes=vmo_votes+1", "vmo_vmid=$pid AND vmo_vmoid=$id")) {
				return false;
			}
		}
		
		return $this->increase('vm_votes', 1);
	}
	
	public function onVoteGuest($ip, array $chosen)
	{
		$pid = $this->getID();
		$eip = self::escape($ip);
		$choices = implode(':', $chosen);
		
		if (false !== ($row = GWF_VoteMultiRow::getVoteRowGuest($pid, $ip)))
		{
			if (false === $this->onRevert($row)) {
				return false;
			}
			
			if (false === GDO::table('GWF_VoteMultiRow')->update("vmr_choices='$choices'", "vmr_vmid=$pid AND vmr_ip='$eip'")) {
				return false;
			}
			
			if (false === $this->onApply($chosen)) {
				return false;
			}
		}
		else
		{
			$row = new GWF_VoteMultiRow(array(
				'vmr_vmid' => $pid,
				'vmr_uid' => 0,
				'vmr_ip' => $ip,
				'vmr_time' => time(),
				'vmr_choices' => $choices,
			));
			if (false === $row->insert()) {
				return false;
			}
			if (false === $this->onApply($chosen)) {
				return false;
			}
		}

		return true;
	}
	
}

?>
