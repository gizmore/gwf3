<?php
/**
 * A WeChall Challenge.
 * @author gizmore
 */
final class WC_Challenge extends GDO
{
	const CHALL_CASE_S = 0;
	const CHALL_CASE_I = 1;
	const CHALL_NO_SPACES = 2;
	const CHALL_HASHED_PW = 4;
	
	const MIN_SCORE = 1;
	const MAX_SCORE = 10;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_chall'; }
	public function getOptionsName() { return 'chall_options'; }
	public function getColumnDefines()
	{
		return array(
			# Keys
			'chall_id' => array(GDO::AUTO_INCREMENT),
			'chall_gid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'chall_creator' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			'chall_creator_name' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),

			# The Challenge
			'chall_url' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'chall_tags' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'chall_score' => array(GDO::UINT, GDO::NOT_NULL),
			'chall_title' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'chall_views' => array(GDO::UINT, 0),
			'chall_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'chall_solution' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 32),
			'chall_solvecount' => array(GDO::UINT, 0),
		
			# Score Votings
			'chall_votecount' => array(GDO::UINT, 0),
			'chall_dif' => array(GDO::DECIMAL, 5.0, array(5,4)),
			'chall_edu' => array(GDO::DECIMAL, 5.0, array(5,4)),
			'chall_fun' => array(GDO::DECIMAL, 5.0, array(5,4)),
//			'chall_vote_dif' => array(GDO::OBJECT, GDO::NOT_NULL, array('GWF_VoteScore', 'chall_vote_dif')),
//			'chall_vote_edu' => array(GDO::OBJECT, GDO::NOT_NULL, array('GWF_VoteScore', 'chall_vote_edu')),
//			'chall_vote_fun' => array(GDO::OBJECT, GDO::NOT_NULL, array('GWF_VoteScore', 'chall_vote_fun')),
			'chall_vote_dif' => array(GDO::UINT, 0),
			'chall_vote_edu' => array(GDO::UINT, 0),
			'chall_vote_fun' => array(GDO::UINT, 0),
		
			# Forum Boards
			'chall_board' => array(GDO::UINT|GDO::INDEX, 0),
			'chall_sboard' => array(GDO::UINT|GDO::INDEX, 0),
		
			'chall_options' => array(GDO::UINT, 0),
		
			'chall_token' => array(GDO::TOKEN, '', 8),
				
// 			'solved' => array(GDO::JOIN, GDO::NULL, array('WC_ChallSolved', 'chall_id', 'csolve_cid')),
		);
	}
	
	###################
	### Convenience ###
	###################
	public function getID() { return $this->getVar('chall_id'); }
	public function getGID() { return $this->getVar('chall_gid'); }
	public function getDate() { return $this->getVar('chall_date'); }
	public function getScore() { return $this->getVar('chall_score'); }
	public function getTitle() { return $this->getVar('chall_title'); }
	public function getName() { return $this->getTitle(); }
	public function getVotecount() { return $this->getVar('chall_votecount'); }
	public function hasTag($tag) { return false !== strpos($this->getVar('chall_tags'),",$tag,"); }
	public function isCaseI() { return $this->isOptionEnabled(self::CHALL_CASE_I); }
	public function isHashedPassword() { return $this->isOptionEnabled(self::CHALL_HASHED_PW); }
	public function isSpacesRemoved() { return $this->isOptionEnabled(self::CHALL_NO_SPACES); }
	public function setSolution($solution, $case_i=false) { $this->setVar('chall_solution', self::hashSolution($solution, $case_i)); }
	
	/**
	 * Get the usergroup associated with the challenge.
	 * @return GWF_Group
	 */
	public function getGroup() { return GWF_Group::getByID($this->getVar('chall_gid')); }
	
	public function getSolverHREF() { return GWF_WEB_ROOT.'challenge_solvers_for/'.$this->getVar('chall_id').'/'.$this->urlencode('chall_title'); }
	
	/**
	 * Get a challenge by title.
	 * @param string $title
	 * @return WC_Challenge
	 */
	public static function getByTitle($title, $store_look=true)
	{
		$back = self::table(__CLASS__)->getBy('chall_title', $title);

		# The challenge is installed
		if ($back !== false)
		{
			# Get the solved row and store 1st-look-at date.
			if ($back !== false && $store_look && (0 !== ($userid = GWF_Session::getUserID())))
			{
				require_once 'WC_ChallSolved.php';
				$back->solveRow = WC_ChallSolved::getSolvedRow($userid, $back->getID());
			}
			
			# Increase viewcount
			if (false === $back->increase('chall_views', 1)) {
				echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		return $back;
	}
	
	/**
	 * Get a challenge by boardid.
	 * @param int $bid
	 * @return WC_Challenge
	 */
	public static function getByBoardID($bid)
	{
		$bid = (int)$bid;
		return self::table(__CLASS__)->selectFirstObject('*', "chall_board={$bid} OR chall_sboard={$bid}");
	}
	
	/**
	 * Get a challenge by ID.
	 * @param int $id
	 * @return WC_Challenge
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getRow($id);
	}
	
	/**
	 * @return GWF_ForumBoard
	 */
	public function getBoard()
	{
		return GWF_ForumBoard::getBoard($this->getVar('chall_board'));
//		return GDO::table('GWF_ForumBoard')->getRow($this->getVar('chall_board'));
	}
	
	/**
	 * @return GWF_ForumBoard
	 */
	public function getSolutionBoard()
	{
		return GWF_ForumBoard::getBoard($this->getVar('chall_sboard'));
//		return GDO::table('GWF_ForumBoard')->getRow($this->getVar('chall_sboard'));
	}
	
	/**
	 * @return GWF_VoteScore
	 */
	public function getVotesDif()
	{
		return GWF_VoteScore::getByID($this->getVar('chall_vote_dif', 0));
//		return $this->getVar('chall_vote_dif', false);
	}
	
	/**
	 * @return GWF_VoteScore
	 */
	public function getVotesEdu()
	{
		return GWF_VoteScore::getByID($this->getVar('chall_vote_edu', 0));
	}
	
	/**
	 * @return GWF_VoteScore
	 */
	public function getVotesFun()
	{
		return GWF_VoteScore::getByID($this->getVar('chall_vote_fun', 0));
//		return $this->getVar('chall_vote_fun', false);
	}
	
	public function getHREF()
	{
		return GWF_WEB_ROOT.$this->getVar('chall_url');
	}
	
	public function displayLink($solved=true)
	{
		static $by = NULL;
		if ($by === NULL) {
			$by = GWF_HTML::lang('by');
		}
		$title = $this->display('chall_title');
		return sprintf('<a href="%s" title="%s" class="wc_chall_solved_%s">%s</a> %s %s',$this->getHREF(), $title, $solved ? '1' : ($solved === NULL ? '' : '0'), $title, $by, $this->displayCreators());
//		'<a href="'.$this->getHREF().'">'  GWF_HTML::anchor($this->getHREF(), $this->getVar('chall_title'), "wc_chall_solved_$solved", $chall->displayTitle());
//		 "$by $creators");
	}
	
	public function displayTags()
	{
		$back = '';
		$tags = explode(',', trim($this->getVar('chall_tags'), ', '));
		foreach ($tags as $tag)
		{
			$back .= sprintf(', <a href="%s">%s</a>', GWF_WEB_ROOT.'challs/'.urlencode($tag), htmlspecialchars($tag));
		}
		return substr($back, 1);
	}
	
	public function displayCreators()
	{
		$creators = array();
//		$cr = ;
		foreach (explode(',', $this->getVar('chall_creator_name')) as $c)
		{
			if ($c !== '')
			{
				$creators[] = "<a href=\"".GWF_WEB_ROOT."profile/$c\">$c</a>";# GWF_HTML::anchor(GWF_WEB_ROOT.'profile/'.urlencode($c), $c);
			}
		}
		return GWF_Array::implodeHuman($creators);
	}
	
	public function displayAge()
	{
		return GWF_Time::displayAge($this->getVar('chall_date'));
	}
	
	/* At least for difficulty votes it makes more sense to display higher values tinted towards
		red rather than green. Use the $reverse parameter for that. */
	public function displayVoteNumber($value, $reverse=false)
	{
		return sprintf('<b style="color:#%s;">%.02f</b>',
						WC_HTML::getColorForPercent(($reverse ? (10-$value) : $value)*10),
						$value);
	}
	
	public function displayDif()
	{
//		return $this->displayVoteNumber($this->getVotesDif()->getVar('vs_avg'));
		return $this->displayVoteNumber($this->getVar('chall_dif'), $reverse=true);
	}
	
	public function displayEdu()
	{
		return $this->displayVoteNumber($this->getVar('chall_edu'));
//		return $this->displayVoteNumber($this->getVotesEdu()->getVar('vs_avg'));
	}
	
	public function displayFun()
	{
		return $this->displayVoteNumber($this->getVar('chall_fun'));
//		return $this->displayVoteNumber($this->getVotesFun()->getVar('vs_avg'));
	}
	
	public function displayBoardLinks($help_link=true, $sol_link=true)
	{
		$back = '';
		if ($help_link === true)
		{
			$back .= $this->getChallBoardLink().' ';
		}
		if ($sol_link === true)
		{
			$back .= $this->getSolutionBoardLink();
		}
		return $back;
	}

	/**
	 * Display the single vote icon for challenge description pages.
	 * @return string
	 */
	public function displayVoteLink()
	{
		if (false === ($user = GWF_Session::getUser()))
		{
			return '';
		}
		
		require_once GWF_CORE_PATH.'module/Votes/GWF_VoteScore.php';
		require_once GWF_CORE_PATH.'module/Votes/GWF_VoteScoreRow.php';
		
		if (false === ($votes = $this->getVotesDif()))
		{
			return '';
		}
		
		$d = $votes->hasVoted($user) ? 'd' : '';
		
		$title = WC_HTML::lang('alt_challvotes');
		$alt = WC_HTML::lang('btn_vote');
		$imgurl = GWF_WEB_ROOT."tpl/wc4/ico/vote{$d}.gif";
		
		return
			sprintf('&nbsp;<a href="%s"><img title="%s" alt="%s" src="%s" /></a>&nbsp;<span title="diffi">%.01f</span>',
				$this->hrefVotes(), $title, $alt, $imgurl, $votes->getVar('vs_avg')
			);
	}
	
	public function getEditHREF()
	{
		return GWF_WEB_ROOT.'chall/edit/'.$this->getVar('chall_id').'/'.$this->urlencode('chall_title');
	}
	
	public function getEditButton()
	{
		return GWF_Button::edit($this->getEditHREF(), WC_HTML::lang('btn_edit_chall'));
	}
	
	################################
	### Access / Look At Timings ###
	################################
	/**
	 * On access we trigger the first look at.
	 * @param int $user
	 * @return boolean true or false
	 */
	public function onAccess($userid)
	{
		if (false === ($solved = WC_ChallSolved::getSolvedRow($userid, $this->getID()))) {
			return false;
		}
		return true;
	}
	
	/**
	 * Get ChallSolvedRow for this challenge and a userid.
	 * @param int $userid
	 * @return WC_ChallSolved
	 */
	public function getSolvedRow($userid)
	{
		require_once 'WC_ChallSolved.php';
		return WC_ChallSolved::getSolvedRow($userid, $this->getID());
	}
	
	#########################
	### Solve Count Cache ###
	#########################
	public static function repairSolveCount()
	{
		$solved = GWF_TABLE_PREFIX.'wc_chall_solved';
		return self::table(__CLASS__)->update("chall_solvecount=(SELECT COUNT(*) FROM $solved WHERE csolve_cid=chall_id AND csolve_date!='')");
	}
	
	
	
	#######################
	### Static Creation ###
	#######################

	/**
	 * Get an array of users for a creator string separated by comma.
	 * @param string $creators
	 * @return array
	 */
	public static function installGetCreators($creators='', $verbose=true)
	{
		$back = array();
		foreach (explode(',', $creators) as $c)
		{
			if ('' === ($c = trim($c))) {
				continue;
			}
			if (false === ($user = GWF_User::getByName($c))) {
				if ($verbose) {
					echo GWF_HTML::error('WC_Chall_Install', 'Unknown creator for challenge: '.htmlspecialchars($c));
				}
			}
			else {
				$back[] = $user;
			}
		}
		
		return $back;
	}
	
	public static function installChallenge($title, $solution, $score, $url, $creators='', $tags='', $verbose=true, $options=0)
	{
		GWF_Module::loadModuleDB('Votes', true);
		
		if (false !== (self::getByTitle($title, false))) {
			if ($verbose) {
				echo GWF_HTML::error('WeChall', 'The challenge is already installed.');
			}
			return true;
		}
		
		$tags = trim($tags, ' ,');
		
		$chall = new WC_Challenge(array(
			'chall_id' => 0,
			'chall_gid' => 0,
			'chall_creator' => ',',
			'chall_creator_name' => ',',
			'chall_url' => $url,
			'chall_tags' => ','.$tags.',',
			'chall_score' => $score,
			'chall_title' => $title,
			'chall_views' => 0,
			'chall_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'chall_solution' => self::hashSolution($solution, ($options&self::CHALL_CASE_I)>0),
			'chall_solvecount' => 0,
			'chall_dif' => 5.0,
			'chall_edu' => 5.0,
			'chall_fun' => 5.0,
			'chall_vote_dif' => null,
			'chall_vote_edu' => null,
			'chall_vote_fun' => null,
			'chall_board' => null,
			'chall_sboard' => null,
			'chall_votecount' => 0,
			'chall_options' => $options,
			'chall_token' => GWF_Random::randomKey(8),
		));
		
		if (false === $chall->insertChallenge(0, $creators, true, $verbose)) {
			if ($verbose) {
				echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			return false;
		}
		
		if ($verbose) {
			echo WC_HTML::message('msg_chall_installed', array($chall->display('chall_title')));
		}
		
		self::recalcWeChall();
		
		return true;
	}
	
	public static function hashSolution($string, $case_i=false)
	{
		if (!is_string($string)) {
			return 'xxxx';
		}
		
		if ($case_i===true) {
			$string = strtolower($string);
		}

		return GWF_Password::md5($string);
	}
	
	/**
	 * Recalc scores for wechall, after challenge install / scorechange.
	 * @return boolean
	 */
	private static function recalcWeChall()
	{
		if (false !== ($wechall = WC_Site::getWeChall()))
		{
			if (false === $wechall->saveVar('site_challcount', self::table(__CLASS__)->countRows())) {
				return false;
			}
			if (false === $wechall->saveVar('site_maxscore', self::getMaxScore())) {
				return false;
			}
			$wechall->recalcSite();
			return true;
		}
		return false;
	}
	
	
	/**
	 * Insert a new challenge to database.
	 * Create Voting tables.
	 * Create Usergroup and add founders.
	 * @param WC_Challenge $chall
	 * @param int $founderid
	 * @param string $created_by
	 * @param boolean $createBoards Create forum boards for the challenge (important for DBImports)
	 * @return boolean
	 */
	public function insertChallenge($founderid, $created_by='', $createBoards=true, $verbose=true)
	{
		if (false === ($this->replace())) {
			return false;
		}
		
		$success = true;
		$challid = $this->getID();
		$title = $this->getTitle();
		
		// Voting tables.
		if (false === ($this->getVotesDif())) {
			if (false === ($votes = Module_Votes::installVoteScoreTable('ch_dif_'.$challid, 0, 10, false, false, GWF_VoteScore::SHOW_RESULT_VOTED, false))) {
				echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
				$success = false;
			} else {
				$this->saveVar('chall_vote_dif', $votes->getID());
			}
		}
		
		if (false === ($this->getVotesEdu())) {
			if (false === ($votes = Module_Votes::installVoteScoreTable('ch_edu_'.$challid, 0, 10, false, false, GWF_VoteScore::SHOW_RESULT_VOTED, false))) {
				echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
				$success = false;
			} else {
				$this->saveVar('chall_vote_edu', $votes->getID());
			}
		}
		
		if (false === ($this->getVotesFun())) {
			if (false === ($votes = Module_Votes::installVoteScoreTable('ch_fun_'.$challid, 0, 10, false, false, GWF_VoteScore::SHOW_RESULT_VOTED, false))) {
				echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
				$success = false;
			} else {
				$this->saveVar('chall_vote_fun', $votes->getID());
			}
		}
		
		if (false === ($group = GWF_Group::getByName($title))) {
			// Create a group for that challenge
			$group = new GWF_Group(array(
				'group_id' => 0,
				'group_name' => $title,
				'group_options' => GWF_Group::FULL|GWF_Group::SCRIPT,
				'group_lang' => 0,
				'group_country' => 0,
				'group_founder' => 0,
				'group_memberc' => 0,
				'group_bid' => 0,
				'group_date' => GWF_Time::getDate(GWF_Time::LEN_SECOND),
			));
			if (false === $group->insert())
			{
				echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
//			$group = GWF_Group::insertNewGroup($title, $founderid, 0, 0);
		}

		$this->saveVar('chall_gid', $group->getID());
//		$this->setVar('chall_gid', $group->getID());
		
		
		### Authors ###
		if (false === $this->updateCreators($created_by)) {
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		
		// Create Forum Challenge And Solution Boards
		if ($createBoards)
		{
			if (false === ($module = GWF_Module::getModule('WeChall'))) {
				echo GWF_HTML::err('ERR_MODULE_MISSING', array('WeChall'));
				return false;
			}
			
			$module instanceof Module_WeChall;
			
			if (false === ($board = $this->getBoard())) {
				if (false === ($board = GWF_ForumBoard::createBoard(
					'Challenge: '.$this->getTitle(), 
				$module->langAdmin('chall_help_desc', array($this->getTitle())),
					$module->cfgChallengeBoardID(),
					GWF_ForumBoard::ALLOW_THREADS|GWF_ForumBoard::GUEST_VIEW
				))) {
					echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
					$success = false;
				}
				else {
					$this->saveVar('chall_board', $board->getID());
				}
			}
			if (false === ($board = $this->getSolutionBoard())) {
				if (false === ($board = GWF_ForumBoard::createBoard(
					'Solution: '.$this->getTitle(), 
				$module->langAdmin('chall_solution_desc', array($this->getTitle())),
					$module->cfgSolutionBoardID(),
					GWF_ForumBoard::ALLOW_THREADS|GWF_ForumBoard::GUEST_VIEW,
					$group->getID()
					))) {
					echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
					$success = false;
				}
				else {
					$this->saveVar('chall_sboard', $board->getID());
				}
			}
		}

		Module_WeChall::instance()->cacheChallTags();
		
		return $success;
	}
	
//	public function updateTags($tags)
//	{
//		Module_WeChall::instance()->cacheChallTags();
//	}
	
	
	public function updateCreators($creators_csv, $verbose=true)
	{
		$creators = self::installGetCreators($creators_csv, $verbose);
		if (count($creators) === 0) {
			if ($verbose) {
				echo GWF_HTML::error('WC_Chall_Install', 'No Creator for challenge');
			}
			return true;
		}
		else
		{
			$create_by_cache = ',';
			$create_by_cacheN = ',';
			foreach ($creators as $user)
			{
				$create_by_cache .= $user->getVar('user_id').',';
				$create_by_cacheN .= $user->getVar('user_name').',';
			}
			
			if (false === $this->saveVars(array(
				'chall_creator' => $create_by_cache,
				'chall_creator_name' => $create_by_cacheN,
			))) {
				return false;
			}
		}
		return true;
	}
	
	##########################
	### Delete a challenge ###
	##########################
	/**
	 * Delete all stuff associtated with this challenge.
	 * @return boolean
	 */
	public function onDelete()
	{
		# Delete Votes
		if (false === ($mo_votes = GWF_Module::loadModuleDB('Votes', true)))
		{
			if (false !== ($v = $this->getVotesDif())) {
				$v->onDelete();
			}
			if (false !== ($v = $this->getVotesEdu())) {
				$v->onDelete();
			}
			if (false !== ($v = $this->getVotesFun())) {
				$v->onDelete();
			}
		}
		
		# Delete Boards
		if (false !== ($module = GWF_Module::loadModuleDB('Forum', true)))
		{
			# Include Forum
			GWF_ForumBoard::init();
			
			if (false !== ($b = $this->getBoard())) {
				$b->deleteBoard();
			}
			if (false !== ($b = $this->getSolutionBoard())) {
				$b->deleteBoard();
			}
		}
		# Delete Solved
		require_once 'WC_ChallSolved.php';
		GDO::table('WC_ChallSolved')->deleteWhere('csolve_cid='.$this->getID());
		
		# Delete Challenge
		return $this->delete();
	}
	
	####################
	### Update Votes ###
	####################
	/**
	 * @param int $vsid
	 * @return WC_Site
	 */
	public static function getByVSID($vsid)
	{
		$vsid = (int)$vsid;
		return self::table(__CLASS__)->selectFirstObject('*', "chall_vote_dif=$vsid OR chall_vote_edu=$vsid OR chall_vote_fun=$vsid");
	}
	
	private static function getRecalcVoteQuery()
	{
		$votes = GDO::table('GWF_VoteScore')->getTableName();
		return "chall_votecount=(SELECT vs_count FROM $votes WHERE vs_id=chall_vote_dif), chall_dif=(SELECT vs_avg FROM $votes WHERE vs_id=chall_vote_dif), chall_edu=(SELECT vs_avg FROM $votes WHERE vs_id=chall_vote_edu), chall_fun=(SELECT vs_avg FROM $votes WHERE vs_id=chall_vote_fun)";
	}
	
	public function onRecalcVotes()
	{
		return $this->updateRow(self::getRecalcVoteQuery());
	}
	
	public static function onRecalcAllVotes()
	{
		return GDO::table(__CLASS__)->update(self::getRecalcVoteQuery());
	}
	
	public function hrefVotes()
	{
		return GWF_WEB_ROOT.'challvotes/'.$this->getVar('chall_id').'/'.urlencode($this->getVar('chall_title'));
	}
	
	public function hrefSolvers()
	{
		return GWF_WEB_ROOT.'challenge_solvers_for/'.$this->getVar('chall_id').'/'.urlencode($this->getVar('chall_title'));
	}
	
	public function hrefChallenge()
	{
		return GWF_WEB_ROOT.$this->getVar('chall_url');
	}
	
	#########################
	### Solve a challenge ###
	#########################
	/**
	 * Submit an answer to a challenge.
	 * @param GWF_User $user
	 * @param string $answer
	 * @return string html
	 */
	public function onSolve($user, $answer)
	{
		if (false !== ($error = $this->isAnswerBlocked($user)))
		{
			echo $error;
			return false;
		}
		
		if ($this->isHashedPassword()) {
			if ($this->isCaseI()) {
				$answer = mb_strtolower($answer);
			}
			if ($this->isSpacesRemoved()) {
				$answer = str_replace(' ', '');
			}
			for ($i = 0; $i < 313370612; $i++) {
				$answer = mb_strtolower(sha1($answer));
			}
		}
		
		if (self::hashSolution($answer, $this->isCaseI()) !== $this->getVar('chall_solution'))
		{
			echo WC_HTML::error('err_wrong');
			return false;
		}
		
		return $this->onChallengeSolved($user === false ? 0 : $user->getID());
	}
	
	public function isAnswerBlocked($user)
	{
		if (false === Common::getPostString('answer'))
		{
			return false;
		}
			
		// CSRF
		if (function_exists('formSolutionboxValidate'))
		{
			if (false !== ($error = formSolutionboxValidate($this)))
			{
				return $error;
			}
		}
		require_once 'WC_SolutionBlock.php';
		if (false !== ($wait = WC_SolutionBlock::isBlocked($user)))
		{
			return WC_HTML::error('err_solution_block', array(GWF_Time::humanDuration($wait)));
		}
		if (!$this->increaseTries())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return false;
	}
	
	public function validate_answer($module, $arg)
	{
		if ($arg === '') {
			return WC_HTML::lang('err_wrong');
		}
		return false;
	}
	
	public function increaseTries()
	{
		if (false !== ($row = $this->getSolvedRow(GWF_Session::getUserID())))
		{
			return $row->increase('csolve_tries');
		}
		return true;
	}
	
	public function onChallengeSolved($userid = NULL)
	{
		if ($userid === NULL)
		{
			$userid = GWF_Session::getUserID();
		}
		$userid = (int) $userid;
		
		if ($userid === 0) {
			echo WC_HTML::message('msg_correct_guest');
			return true;
		}
		
		if ($this->getID() === '0') {
			echo WC_HTML::message('msg_correct_alpha');
			return true;
		}
		
		$user = GWF_Session::getUser();
		if ($user !== false && GWF_Session::getUser()->isBot())
		{
			echo WC_HTML::error('err_bot_challenge');
			return false;
		}
		
		if (false === ($row = $this->getSolvedRow($userid)))
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return false;
		}

		if ($row->isSolved())
		{
			echo WC_HTML::message('msg_correct_again', array($this->hrefVotes()));
			return true;
		}
		
		$row->markSolved();
		
		if (false !== ($user = GWF_User::getByID($userid)))
		{
			if (false === GWF_UserGroup::addToGroup($userid, $this->getGID()))
			{
				echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
				return false;
			}
		}
		
		GWF_ForumBoard::init(false, true);
		if (false !== ($solboard = $this->getSolutionBoard())) {
			$href_sb = $solboard->getShowBoardHREF();
		} else {
			$href_sb = '#';
		}
		
		echo WC_HTML::message('msg_correct', array($this->hrefVotes(), $href_sb));
		
		if (false !== ($wechall = WC_Site::getWeChall()))
		{
			echo $wechall->onUpdateUser($user)->display('WeChall');
		}

		# Increase solvecount.
		$cid = $this->getID();
		$solved = GWF_TABLE_PREFIX.'wc_chall_solved';
		$this->updateRow("chall_solvecount=(SELECT COUNT(*) FROM {$solved} WHERE csolve_cid={$cid} AND csolve_date!='')");
		
		return true;
	}
	
	###############
	### Scoring ###
	###############
	public static function getScoreForUser(GWF_User $user)
	{
		$db = gdo_db();
		$challs = GWF_TABLE_PREFIX.'wc_chall';
		$solved = GWF_TABLE_PREFIX.'wc_chall_solved';
		$userid = $user->getVar('user_id');
		$query = "SELECT SUM(chall_score) s FROM $solved INNER JOIN $challs ON chall_id=csolve_cid WHERE csolve_uid=$userid AND csolve_date!=''";
		if (false === ($result = $db->queryFirst($query))) {
			return -1;
		}
		return intval($result['s']);
	}
	
	public static function getMaxScore()
	{
		return self::table(__CLASS__)->selectVar('IFNULL(SUM(chall_score), 0)');
	}
	
	public static function getChallCount()
	{
		return self::table(__CLASS__)->countRows();
	}
	
	
	#####################
	### Old Functions #########
	### Compatible with WC3 ##############
	### Did not break much for challs! ###
	######################################
	/**
	 * Get a challenge that is not installed yet.
	 * @param string $title
	 * @param int $score
	 * @param string $url
	 * @param string $solution
	 * @return WC_Challenge
	 */
	public static function dummyChallenge($title, $score=1, $url=false, $solution=false, $options=0)
	{
		return new self(array(
			'chall_id' => '0',
			'chall_gid' => 0,
			'chall_creator' => '',
			'chall_creator_name' => '',
			'chall_url' => $url === false ? 'index.php' : $url,
			'chall_tags' => '',
			'chall_score' => $score,
			'chall_title' => $title,
			'chall_views' => 0,
			'chall_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'chall_solution' => self::hashSolution($solution, ($options&self::CHALL_CASE_I)>0),
			'chall_solvecount' => 0,
			'chall_vote_dif' => false,
			'chall_vote_edu' => false,
			'chall_vote_fun' => false,
			'chall_board' => 0,
			'chall_sboard' => 0,
			'chall_options' => $options,
			'chall_dif' => '5.0',
			'chall_edu' => '5.0',
			'chall_fun' => '5.0',
		));
	}
	
	/**
	 * Display the default Challenge Header, containing votes and dates and stuff.
	 * Also display the WC Menu, in case we are not embedded.
	 * @param boolean $embed
	 * @return string html
	 */
	public function showHeader($embed=true)
	{
		if (isset($_GET['ajax']))
		{
			return;
		}
		
		if (!$embed)
		{
			echo WC_HTML::displayMenu();
			echo WC_HTML::displayHeader();
			echo '<div id="wc_banner_space"></div>'.PHP_EOL;
			echo WC_HTML::displaySidebar2();
			echo '<div id="page">'.PHP_EOL;
		}
		
		GWF_ForumBoard::init(true, false);
		
		if ('0' === ($uid = GWF_Session::getUserID())) {
			$isSolved = false;
		} else {
			require_once 'WC_ChallSolved.php';
			$isSolved = WC_ChallSolved::hasSolved($uid, $this->getID());
		}
		
		$div = '&nbsp;|&nbsp;'.PHP_EOL; // divider space
		$href_votes = $this->hrefVotes();
		
		echo '<div class="chall_head box box_c">'.PHP_EOL;
		echo '<span>'.$this->displayBoardLinks(true, $isSolved).'</span>'.PHP_EOL.$div;
		echo '<span>'.WC_HTML::lang('score').': '.$this->getVar('chall_score').'</span>'.PHP_EOL.$div;
		echo '<span class="gwf_num" title="'.WC_HTML::lang('th_dif').'">'.sprintf('<a class="gwf_num" href="%s">%s</a>', $href_votes, $this->displayDif()).'</span>'.PHP_EOL;
		echo '<span class="gwf_num" title="'.WC_HTML::lang('th_edu').'">'.sprintf('<a class="gwf_num" href="%s">%s</a>', $href_votes, $this->displayEdu()).'</span>'.PHP_EOL;
		echo '<span class="gwf_num" title="'.WC_HTML::lang('th_fun').'">'.sprintf('<a class="gwf_num" href="%s">%s</a>', $href_votes, $this->displayFun()).'</span>'.$div.PHP_EOL;
		echo '<span>'.GWF_HTML::anchor($this->hrefSolvers(), WC_HTML::lang('chall_solvecount', array($this->getVar('chall_solvecount')))).'</span>'.PHP_EOL.$div;
		echo '<span>'.$this->getVar('chall_views').' '.WC_HTML::lang('views').'</span>'.PHP_EOL.$div;
		echo '<span>'.WC_HTML::lang('chall_added').' '.GWF_Time::displayDate($this->getVar('chall_date')).'</span>';
		echo '</div>'.PHP_EOL;

		echo sprintf('<h2><a href="%s">%s</a><span class="wc_chall_tagtitle"> (%s)</span></h2>', $this->getHREF(), $this->display('chall_title'), trim($this->displayTags()));
	}
	
	public function getSolutionBoardLink()
	{
		static $alt = NULL, $sol, $ico;

		if ($alt === NULL) {
			$alt = WC_HTML::lang('alt_solboard');
			$sol = WC_HTML::lang('solutions');
			$ico = GWF_WEB_ROOT.'tpl/wc4/ico/solutionboard.gif';
		}
		
		if (false !== ($b = $this->getSolutionBoard())) {
			return sprintf('<a href="%s" title="%s"><img src="%s" alt="%s" title="%s" /></a>', $b->getShowBoardHREF(), $sol, $ico, $alt, $alt);
		}
		return '';
	}
		
	
	public function getChallBoardLink()
	{
		static $alt = NULL, $help, $icon;
		if ($alt === NULL) {
			$alt = WC_HTML::lang('alt_challboard');
			$help = WC_HTML::lang('helpboard');
			$icon = GWF_WEB_ROOT.'tpl/wc4/ico/challboard.gif';
		}
		if (false !== ($b = $this->getBoard())) {
			$href = $b->getShowBoardHREF();
			return "<a href=\"$href\" title=\"$help\"><img src=\"$icon\" alt=\"$alt\" title=\"$alt\" /></a>";#, $b->getShowBoardHREF(), $help, $icon, $alt, $alt);
		}
		return '';
	}
	
	public function copyrightFooter()
	{
		$now = date('Y');
		$cye = intval(substr($this->getVar('chall_date'), 0, 4), 10);
		$arr = array();
		for ($y = $cye; $y <= $now; $y++)
		{
			$arr[] = $y;
		}

		return '<div class="box box_c">&copy;&nbsp;'.GWF_Array::implodeHuman($arr).'&nbsp;'.WC_HTML::lang('by').'&nbsp;'.$this->displayCreators().'</div>';
	}
	
	##############################
	### Challenge Translations ###
	##############################
	private $challLang = true;
	
	/**
	 * Get the challenge translation helper.
	 * @return GWF_LangTrans
	 */
	public function getLang()
	{
		if ($this->challLang === true)
		{
			$this->challLang = new GWF_LangTrans(dirname($this->getVar('chall_url')).'/lang/chall');
		}
		return $this->challLang;
	}
	
	/**
	 * Get language bit for a key with current browser language.
	 * Has arbitrary number of arguments, ..., ...
	 * @param string $key
	 * @return string
	 */
	public function lang($key, $args=NULL)
	{
		return false === ($lang = $this->getLang()) ? $key : $lang->lang($key, $args);
	}
	
	public static function isValidScore($score)
	{
		return $score >= 1 && $score <= 10;
	}
	
	public function onCheckSolution($answer=true)
	{
		if (!is_string($answer))
		{
			if (false === ($answer = Common::getPostString('answer', false)))
			{
				return false;
			}
		}

		$this->onSolve(GWF_Session::getUser(), $answer);
	}
}
