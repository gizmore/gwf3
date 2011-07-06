<?php
/**
 * Links Module
 * @author gizmore
 */
final class Module_Links extends GWF_Module
{
	const USERDATA_MARK = 'gwf_links_readmark';
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.02; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/links'); }
	public function getAdminSectionURL() { return $this->getMethodURL('Staff'); }
	public function getDependencies() { return array('Votes'=>1.00); }
	public function onCronjob() { require_once 'GWF_LinksCronjob.php'; GWF_LinksCronjob::onCronjob($this); }
	public function getClasses() { return array('GWF_Links','GWF_LinksFavorite','GWF_LinksTag','GWF_LinksTagMap','GWF_LinksValidator'); }
	public function onInstall($dropTable) { require_once 'GWF_LinksInstall.php'; GWF_LinksInstall::onInstall($this, $dropTable); }
	##############
	### Config ###
	##############
	public function cfgLongDescription() { return $this->getModuleVar('link_long_descr', '0') === '1'; }
	public function cfgGuestLinks() { return $this->getModuleVar('link_guests', '1') === '1'; }
	public function cfgGuestModerated() { return $this->getModuleVar('link_guests_mod', '1') === '1'; }
	public function cfgGuestVotes() { return $this->getModuleVar('link_guests_votes', '0') === '1'; }
	public function cfgGuestCaptcha() { return $this->getModuleVar('link_guests_captcha', '1') === '1'; }
	public function cfgGuestUnreadTime() { return (int)$this->getModuleVar('link_guests_unread', 604800); }
	public function cfgLinksPerPage() { return (int)$this->getModuleVar('link_per_page', 50); }
	public function cfgMinScore() { return (int)$this->getModuleVar('link_min_level', 0); }
	public function cfgMinTagScore() { return (int)$this->getModuleVar('link_tag_min_level', 0); }
	public function cfgScorePerLink() { return (int)$this->getModuleVar('link_cost', 0); }
	public function cfgMaxTagLen() { return (int)$this->getModuleVar('link_max_tag_len', 32); }
	public function cfgMaxUrlLen() { return (int)$this->getModuleVar('link_max_url_len', 255); }
	public function cfgMinDescrLen() { return (int)$this->getModuleVar('link_min_descr_len', 8); }
	public function cfgMaxDescrLen() { return (int)$this->getModuleVar('link_max_descr_len', 255); }
	public function cfgMinDescr2Len() { return (int)$this->getModuleVar('link_min_descr2_len', 0); }
	public function cfgMaxDescr2Len() { return (int)$this->getModuleVar('link_max_descr2_len', 512); }
	public function cfgVoteMin() { return (int)$this->getModuleVar('link_vote_min', 1); }
	public function cfgVoteMax() { return (int)$this->getModuleVar('link_vote_max', 5); }
	public function cfgShowPermitted() { return $this->getModuleVar('show_permitted', '1') === '1'; }
	public function cfgWantCheck() { return $this->cfgCheckInterval() > 0; }
	public function cfgCheckInterval() { return (int)$this->getModuleVar('link_check_int', 0); }
	public function cfgCheckAmount() { return (int)$this->getModuleVar('link_check_amt', 5); }
	
	public function saveModuleVar($key, $value)
	{
		if (false === parent::saveModuleVar($key, $value)) {
			return false;
		}
		if ($key === 'link_guests_votes')
		{
			if (false === ($mod_vote = GWF_Module::getModule('Votes'))) {
				return true;
			}
			
			$mod_vote->onInclude();
			
			$guest_votes = GWF_VoteScore::GUEST_VOTES;
			switch ($value)
			{
				case 'YES':
					if (false === (GDO::table('GWF_VoteScore')->update("vs_options=vs_options|$guest_votes", "vs_name LIKE 'link_%' "))) {
						return false;
					}
					break;
				case 'NO':
					if (false === (GDO::table('GWF_VoteScore')->update("vs_options=vs_options-$guest_votes", "vs_options&$guest_votes AND vs_name LIKE 'link_%' "))) {
						return false;
					}
					break;
				default: 
					var_dump(sprintf('Error: Module_Links::saveModuleVar(%s, %s): ', $key, $value));
					break;
			}
		}
		return true;
	}
	
	#############
	### HREFs ###
	#############
	public function hrefSearch() { return GWF_WEB_ROOT.'link/search'; }
	public function hrefOverview() { return GWF_WEB_ROOT.'links/overview'; }
	
	###############
	### Startup ###
	###############
//	public function onAddMenu()
//	{
//		if (false !== ($user = GWF_Session::getUser()))
//		{
//			$append = $this->menuAppend($user);
//		}
//		else
//		{
//			$append = '';
//		}
//		GWF_TopMenu::addMenu('links', $this->hrefOverview(), $append, $this->isSelected());
//	}
	
	public function onAddHooks()
	{
		GWF_Hook::add(GWF_Hook::VOTED_SCORE, array(__CLASS__, 'hookVoted'));
		GWF_Hook::add(GWF_Hook::DELETE_USER, array(__CLASS__, 'hookDeleteUser'));
	}
	

	public function hookVoted(GWF_User $user, array $args)
	{
		$vsid = (int)$args[0];
		$this->onInclude();
		if (false !== ($link = GWF_Links::getByVSID($vsid))) {
			return $link->onCalcPopularity();
		}
		return true;
	}

	public function hookDeleteUser(GWF_User $user, array $args)
	{
		return true;
	}
	
	/**
	 * Raw DB Menu Hack, to avoid include.
	 * @param GWF_User $user
	 * @return unknown_type
	 */
//	private function menuAppend(GWF_User $user)
//	{
//		if (0 <= ($count = $this->countUnread($user))) {
//			return '';
//		}
//		return sprintf('&nbsp;[%d]', $count);
//	}
	
	public function countUnread($user)
	{
//		var_dump($this->getUnreadConditions($user));
//		static $count = -1;
//		if ($count < 0)
//		{
			return GDO::table('GWF_Links')->selectVar('COUNT(*)', $this->getUnreadConditions($user));
//			$db = gdo_db();
//			$table = GWF_TABLE_PREFIX.'links';
//			$conditions = ;
//			$query = "SELECT COUNT(*) FROM $table WHERE $conditions";
//			if (false === ($result = $db->queryFirst($query, false))) {
//				$count = 0;
//			} else {
//				$count = (int) $result[0];
//			}
//		}
//		return $count;
	}
	
	public function getUnreadConditions($user)
	{
		return sprintf('(%s) AND (%s)', $this->getPermQuery($user), $this->getUnreadQuery($user));
	}
	
	##################
	### On Request ###
	##################
	public function execute($methodname)
	{
		GWF_Module::loadModuleDB('Votes')->onInclude();
		return parent::execute($methodname);
	}
	
	###############
	### Queries ###
	###############
	public function getUnreadQuery($user)
	{
		if (is_object($user) && $user->isLoggedIn())
		{
			$user instanceof GWF_User;
			$uid = $user->getID();
			$data = $user->getUserData();
			$mark = isset($data[self::USERDATA_MARK]) ? $data[self::USERDATA_MARK] : $user->getVar('user_regdate');
			return "(link_date>'$mark') AND (link_readby NOT LIKE '%:$uid:%')";
		}
		else
		{
			$cut = GWF_Time::getDate(GWF_Date::LEN_SECOND, time() - $this->cfgGuestUnreadTime());
			return "link_date>'$cut'";
		}
	}
	
	public function getPermQuery($user)
	{
		$mod = 0x02;
		$member = 0x08;
		$private = 0x10;
		if (!is_object($user) || !$user->isLoggedIn()) { # Guest
			return "link_score=0 AND link_gid=0 AND (link_options&$private=0) AND (link_options&$member=0) AND (link_options&$mod=0)";
		}
		else if ($user->isStaff()) {
			return "1";
		}
		else { # Member
			$ug = GWF_TABLE_PREFIX.'usergroup';
			$level = $user->getVar('user_level');
			$uid = $user->getID();
			return "((link_score<=$level) AND ((link_gid=0) OR (link_gid=(SELECT ug_groupid FROM $ug WHERE ug_userid=$uid AND ug_groupid=link_gid))) AND (link_options&$private=0 OR link_user=$uid))";
		}
	}
	
	#################
	### Links API ###
	#################
	public function templateCloud()
	{
		$tVars = array(
			'tags' => GWF_LinksTagMap::getCloud($this),
		);
		return $this->templatePHP('_cloud.php', $tVars);
	}
	
	public function templateLinks(array $links, $sortURL, $by='', $dir='', $preview=false, $staff=false, $showWhenEmpty=false, $with_votes=true)
	{
		if (count($links) === 0 && !$showWhenEmpty) {
			return '';
		}
		$tVars = array(
			'links' => $links,
			'guest_votes' => $this->cfgGuestVotes(),
			'sort_url' => $sortURL,
//			'by' => $by,
//			'dir' => $dir,
			'preview' => $preview,
			'staff' => $staff,
			'with_votes' => $with_votes,
		);
		return $this->templatePHP('_links.php', $tVars);
	}
	
	public function templateSearch()
	{
		$search = $this->getMethod('Search');
		return $search->templateQuickSearch($this);
	}
}

?>
