<?php
/**
 * Multi Purpose Voting Module.
 * @author gizmore
 */
final class Module_Votes extends GWF_Module
{
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.00; }
	public function getDefaultPriority() { return GWF_Module::DEFAULT_PRIORITY - 10; } # we might have deps
	public function onLoadLanguage() { return $this->loadLanguage('lang/voting'); }
	public function getAdminSectionURL() { return $this->getMethodURL('Staff'); }
	public function getClasses() { return array('GWF_VoteMulti', 'GWF_VoteMultiOpt', 'GWF_VoteMultiRow', 'GWF_VoteScore', 'GWF_VoteScoreRow'); }
	public function onIncludeAjax() { GWF_Website::addJavascript(GWF_WEB_ROOT.'tpl/module/Votes/js/gwf_vote.js'); }
	
	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'vote_guests' => array('YES', 'bool'),
			'vote_guests_timeout' => array('1 Day', 'time', 60*30, GWF_Time::ONE_YEAR),
			'vote_iconlimit' => array('10', 'int', '0', '32'),
			'vote_title_min' => array('1', 'int', '1', '16'),
			'vote_title_max' => array('255', 'int', '17', '1024'),
			'vote_option_min' => array('1', 'int', '1', '16'),
			'vote_option_max' => array('255', 'int', '17', '1024'),
			'vote_poll_level' => array('0', 'int', '0', PHP_INT_MAX),
			'vote_poll_group' => array('moderator', 'text', '0', GWF_Group::NAME_LEN),
		));
	}
	##############
	### Config ###
	##############
	public function cfgGuestVotes() { return $this->getModuleVar('vote_guests', '1') === '1'; }
	public function cfgGuestTimeout() { return (int)$this->getModuleVar('vote_guests_timeout', 86400); }
	public function cfgIconLimit() { return (int)$this->getModuleVar('vote_iconlimit', 10); }
	public function cfgMinTitleLen() { return (int)$this->getModuleVar('vote_title_min', 1); }
	public function cfgMaxTitleLen() { return (int)$this->getModuleVar('vote_title_max', 255); }
	public function cfgMinOptionLen() { return (int)$this->getModuleVar('vote_option_min', 1); }
	public function cfgMaxOptionLen() { return (int)$this->getModuleVar('vote_option_max', 255); }
	public function cfgPollLevel() { (int)$this->getModuleVar('vote_poll_level', 0); }
	public function cfgPollGroup() { $this->getModuleVar('vote_poll_group', 'moderator'); }
	
	############
	### HREF ###
	############
	public function hrefOverview() { return GWF_WEB_ROOT.'poll_overview'; }
	
	#########################
	### Voting Module API ###
	#########################
	/**
	 * Create a new VoteScore Table. Returns GWF_Votescore or false.
	 * @param string $name tablename (not really used)
	 * @param int $min Minimum votescore 
	 * @param int $max
	 * @param bool $allowGuests
	 * @param int $expires
	 * @param int $results
	 * @return GWF_VoteScore
	 */
	public static function installVoteScoreTable($name, $min=1, $max=10, $allowGuests=true, $expires=0, $results=GWF_VoteScore::SHOW_RESULT_ALWAYS, $enabled=true)
	{
		if ($max < $min) {
			echo GWF_HTML::err('ERR_PARAMETER', array( __FILE__, __LINE__, 'max < min'));
			return false;
		}
		
		$options = 0;
		$options |= $enabled ? GWF_VoteScore::ENABLED : 0;
		$options |= $allowGuests ? GWF_VoteScore::GUEST_VOTES : 0;
		$options |= $results;
		
//		var_dump($options);
		
		if (false === ($votes = GWF_VoteScore::newVoteScore($name, $min, $max, $expires, $options))) {
			echo GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			return false;
		}
		
		if (false === $votes->replace()) {
			echo GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			return false;
		}
	
		return $votes;
	}
	
	public static function templateVoteScoreS($votescore_id)
	{
		if (false === ($module = GWF_Module::getModule('Votes'))) {
			return '';
		}
		if (false === ($vs = GWF_VoteScore::getByID($votescore_id))) {
			return '';
		}
		return $module->templateVoteScore($vs);
	}

	public function templateVoteScore(GWF_VoteScore $votescore)
	{
		$this->onIncludeAjax();
		$this->onLoadLanguage();
		$tVars = array(
			'votescore' => $votescore,
		);
		return $this->templatePHP('votebutton.php', $tVars);
	}
	
	################
	### Poll API ###
	################
	public static function hrefAddPoll()
	{
		return GWF_WEB_ROOT.'poll/add';
	}
	
	public static function mayAddPoll($user)
	{
		if (false === ($module = GWF_Module::getModule('Votes'))) {
			echo GWF_HTML::err('ERR_MODULE_MISSING', array( 'Votes'));
			return false;
		}
		
		if ($user instanceof GWF_User)
		{
			if ($user->isAdmin()) {
				return true;
			}
			
			if ($user->getLevel() < $module->cfgPollLevel()) {
				return false;
			}
			
			if ('' !== ($group = $module->cfgPollGroup())) {
				if (!($user->isInGroupName($group))) {
					return false;
				}
			}
			return true;
		}
		return false;
	}
	
	public static function mayAddGlobalPoll($user)
	{
		if ($user instanceof GWF_User)
		{
			return $user->isAdmin();
		}
		return false;
	}

	public static function installPollTable($user, $name, $title, array $options, $gid=0, $level=0, $is_multi, $guest_votes, $is_public=false, $result=GWF_VoteMulti::SHOW_RESULT_ALWAYS, $reverse=true)
	{
		if ('' !== ($error = self::installPollTableB($user, $name, $title, $options, $gid, $level, $is_multi, $guest_votes, $is_public, $result, $reverse))) {
			return $error;
		}
		
		if (false === ($module = GWF_Module::getModule('Votes'))) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array( 'Votes'));
		}
		
		$module->onLoadLanguage();
		
		return $module->message('msg_mvote_added');
	}
	public static function installPollTableB($user, $name, $title, array $options, $gid=0, $level=0, $is_multi, $guest_votes, $is_public=false, $result=GWF_VoteMulti::SHOW_RESULT_ALWAYS, $reverse=true)
	{
		
		if (false === ($module = GWF_Module::getModule('Votes'))) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array( 'Votes'));
		}
		
		// Poll exists
		if (false !== ($poll = GWF_VoteMulti::getByName($name))) {
			return $module->error('err_pollname_taken');
		}
		
		// View flag ok
		if (!GWF_VoteMulti::isValidViewFlag($result)) {
			return $module->error('err_multiview');
		}
		
		$taken = array();
		$errors = array();
		foreach ($options as $i => $option)
		{
			if ('' === ($option = trim($option))) {
				$errors[] = $module->lang('err_option_empty', array( $i+1));
			}
			elseif (in_array($option, $taken, true)) {
				$errors[] = $module->lang('err_option_twice', array( GWF_HTML::display($option)));
			}
			else {
				$taken[] = $option;
			}
		}
		
		if (count($taken) === 0) {
			$errors[] = $module->lang('err_no_options');
		}
		
		if (count($errors) > 0) {
			return GWF_HTML::errorA('Votes', $errors);
		}
		
		
		$flags = 0;
		$flags |= GWF_VoteMulti::ENABLED;
		$flags |= $is_multi ? GWF_VoteMulti::MULTIPLE_CHOICE : 0;
		$flags |= $guest_votes ? GWF_VoteMulti::GUEST_VOTES : 0;
		$flags |= $is_public ? 0 : GWF_VoteMulti::INTERNAL_VOTE;
		$flags |= $reverse === false ? GWF_VoteMulti::IRREVERSIBLE : 0;
		$flags |= $result;
		
		if (false === ($poll = GWF_VoteMulti::fakePoll($name, $title, $user, $flags, $gid, $level))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}

		if (false === $poll->insertPoll($taken)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return '';
	}
	
}
?>
