<?php
final class Module_Usergroups extends GWF_Module
{
	##################
	### GWF_Module ###
	##################
	public function onInstall($dropTable) { require_once 'GWF_UsergroupsInstall.php'; GWF_UsergroupsInstall::onInstall($this, $dropTable); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/ug'); }
	public function getDefaultPriority() { return 60; }
	public function getClasses() { return array('GWF_UsergroupsInvite', 'GWF_AvatarGallery'); }
	public function getDependencies() { return array('Forum'=>1.00); }
	public function getDefaultAutoLoad() { return false; }
	##############
	### Config ###
	##############
	public function cfgLevel() { return (int)$this->getModuleVar('ug_level', 0); }
	public function cfgMinLen() { return (int)$this->getModuleVar('ug_minlen', 3); }
	public function cfgMaxLen() { return (int)$this->getModuleVar('ug_maxlen', 48); }
//	public function cfgBID() { return intval($this->getModuleVar('ug_bid', 0)); }
	public function cfgIPP() { return (int)$this->getModuleVar('ug_ipp', 25); }
	public function cfgAvatarsX() { return (int)$this->getModuleVar('ug_ax', 5); }
	public function cfgAvatarsY() { return (int)$this->getModuleVar('ug_ay', 5); }
//	public function cfgMenu() { return intval($this->getModuleVar('ug_menu', true)); }
//	public function cfgSubMenu() { return intval($this->getModuleVar('ug_submenu', true)); }
//	public function cfgSubMenuGroup() { return $this->getModuleVar('ug_submenugroup', 'members'); }
	public function cfgMaxGroups() { return (int)$this->getModuleVar('ug_grp_per_usr', 1); }
	public function cfgLevelPerGroup() { return (int)$this->getModuleVar('ug_lvl_per_grp', 0); }
	
	public function onStartup()
	{
//		if (GWF_User::isLoggedIn())
//		{
//			$invites = $this->getInvites();
//			if (count($invites) > 0)
//			{
//				$msgs = array();
//				foreach ($invites as $group)
//				{
//					$href = GWF_WEB_ROOT.'index.php?mo=Usergroups&amp;me=Join&amp;gid='.$group->getID();
//					$href2 = GWF_WEB_ROOT.'index.php?mo=Usergroups&amp;me=Join&amp;deny='.$group->getID();
//					$msgs[] = $this->lang('pi_invited', $group->getFounder()->displayUsername(), $group->displayName(), $href, $href2);
//				}
//				GWF_Website::addDefaultOutput(GWF_HTML::messageA('Usergroups', $msgs, false));
//			}
//		}
	}
	
//	public function onAddMenu()
//	{
//		if ($this->cfgMenu())
//		{
//			if (GWF_Session::isLoggedIn())
//			{
//				GWF_TopMenu::addSubMenu('account', 'usergroup', $this->getMethodURL('ShowGroups'), '', $this->isMethodSelected('ShowGroups')||$this->isMethodSelected('Create')||$this->isMethodSelected('Edit'));
//			}
//			
//			$parent = $this->cfgSubMenuGroup();
//			$href1 = GWF_WEB_ROOT.'users';
//			$href2 = GWF_WEB_ROOT.'avatar/gallery';
//			$sel1 = $this->isMethodSelected('Users');			
//			$sel2 = $this->isMethodSelected('AvatarGallery');
//			if ($this->cfgSubMenu() && $parent !== '')
//			{
//				GWF_TopMenu::addSubMenu($parent, 'users', $href1, '', $sel1);
//				GWF_TopMenu::addSubMenu($parent, 'avatars', $href2, '', $sel2);
//			}
//			else
//			{
//				GWF_TopMenu::addMenu('users', $href1, '', $sel1);
//				GWF_TopMenu::addMenu('avatars', $href2, '', $sel2);
//			}
//		}
//	}
	
//	private function getInvites()
//	{
//		$db = gdo_db();
//		$groups = GDO::table('GWF_Group')->getTableName();
//		$invites = GWF_TABLE_PREFIX.'ug_invite';
//		$userid = GWF_Session::getUserID();
//		$query = "SELECT $groups.* FROM $groups JOIN $invites ON ugi_gid=group_id AND ugi_uid=$userid";
//		$back = array();
//		if (false === ($result = $db->queryRead($query))) {
//			return $back;
//		}
//		
//		while (false !== ($row = $db->fetchAssoc($result)))
//		{
//			$group = new GWF_Group($row);
//			$group->setVar('group_founder', GWF_User::getByID($row['group_founder']));
//			$back[] = $group;
//		}
//		
//		$db->free($result);
//		return $back;
//	}
	
	###########
	### API ###
	###########
	public function getForumBoard()
	{
		// Include Forum
		if (false === ($mod_forum = GWF_Module::getModule('Forum'))) {
			return false;
		}
		$mod_forum->onInclude();
		
		// Get or Create Usergroup Forum
		if (false === ($board = GWF_ForumBoard::getByTitle('Usergroups'))) {
			$options = GWF_ForumBoard::GUEST_VIEW;
			if (false === ($board = GWF_ForumBoard::createBoard('Usergroups', 'Usergroup Forum Boards', 1, $options, 0))) {
				echo GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
				return false;
			}
		}
		
		return $board;
	}
	
	public function hrefCreate() { return GWF_WEB_ROOT.'index.php?mo=Usergroups&me=Create'; }
//	public function hrefEdit() { return GWF_WEB_ROOT.'index.php?mo=Usergroups&me=Edit'; }
	
	public function adjustFlags(GWF_Group $group)
	{
		if (false === ($mod_forum = GWF_Module::getModule('Forum'))) {
			return false;
		}
		$mod_forum->onInclude();
		
		if (false === ($board = GWF_ForumBoard::getByID($group->getBoardID()))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		# Adjust Board and Thread Flags
		$gid = 0;
		$guestview = true;
		switch($group->getViewFlag())
		{
			case GWF_Group::VISIBLE:
//				$board->saveVar('board_gid', 0);
//				$board->saveGuestView(true);
//				$board->saveOption(GWF_ForumBoard::GUEST_VIEW, true);
//				$this->adjustThreads($board, 0, true);
//				return false;
				break;
			case GWF_Group::COMUNITY:
//				$board->saveVar('board_gid', 0);
//				$board->saveGuestView(false);
//				$board->saveOption(GWF_ForumBoard::GUEST_VIEW, false);
				$guestview = false;
				break;
			case GWF_Group::HIDDEN:
			case GWF_Group::SCRIPT:
//				$board->saveVar('board_gid', $group->getID());
//				$board->saveGuestView(false);
//				$board->saveOption(GWF_ForumBoard::GUEST_VIEW, false);
				$gid = $group->getID();
				$guestview = false;
				break;
			default:
				return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		
		$board->saveGroupID($gid);
		$board->saveGuestView($guestview);
		
	}
	
	public function canCreateGroup($user)
	{
		if ($user === false || $user->getID() === 0) {
			return false;			
		}
		
		// Not min level
		if ($user->getLevel() < $this->cfgLevel()) {
			return false;
		}
		
		// Max Exceeded
		if ($this->getNumGroups($user) >= $this->cfgMaxGroups()) {
			return false;
		}
		
		// Not enough points
		if ($user->getLevel() < $this->levelForNextGroup($user)) {
			return false;
		}
		
		
		return true;
	}
	
	private function getNumGroups($user)
	{
		$uid = $user->getID();
		return GDO::table('GWF_Group')->countRows("group_founder=$uid");
	}
	
	private function levelForNextGroup($user)
	{
		$level = $this->cfgLevel();
		$numGroups = $this->getNumGroups($user) + 1;
		$level += $numGroups * $this->cfgLevelPerGroup();
		return $level;
	}
	
	public function hasGroup($user)
	{
		return $this->getGroup($user) !== false;
	}
	
	public function getGroup($user)
	{
		$userid = $user->getID();
		return GDO::table('GWF_Group')->selectFirst("group_founder=$userid");
	}
	
	public function getGroups($user)
	{
		$userid = $user->getID();
		return GDO::table('GWF_Group')->selectObjects('*', "group_founder=$userid");
	}
	
	public function selectJoinType($selected=0, $name='join')
	{
		$data = array(
			array($this->lang('sel_join_type'), 0)
		);
		$jointypes = GWF_Group::getJoinFlags();
		foreach ($jointypes as $type)
		{
			$data[] = array($this->lang('sel_join_'.$type), $type);
		}
		return GWF_Select::display($name, $data, intval($selected));
	}

	public function selectViewType($selected=0, $name='view')
	{
		$data = array(
			array($this->lang('sel_view_type'), 0)
		);
		$jointypes = GWF_Group::getViewFlags();
		foreach ($jointypes as $type)
		{
			$data[] = array($this->lang('sel_view_'.$type), $type);
		}
		return GWF_Select::display($name, $data, intval($selected));
	}
	
	public function validate_name($arg) { return GWF_Form::validateUsername($this, 'name', $arg, false, ' '); }
	public function validate_join($arg) { return GWF_Group::isValidJoinFlag($arg) ? false : $this->lang('err_join'); }
	public function validate_view($arg) { return GWF_Group::isValidViewFlag($arg) ? false : $this->lang('err_view'); }
	public function validate_username($arg)
	{
		$arg = $_POST['username'] = trim($arg);
		if (false === GWF_User::getByName($arg)) {
			$_POST['username'] = '';
			return GWF_HTML::lang('ERR_UNKNOWN_USER');
		}
		return false;
	}
	
	
	###############
	### Buttons ###
	###############
	public function hrefUsers() { return GWF_WEB_ROOT.'users'; }
	public function hrefGroups() { return GWF_WEB_ROOT.'my_groups'; }
	public function hrefGallery() { return GWF_WEB_ROOT.'avatar/gallery'; }
	public function hrefSearchUser() { return $this->getMethodURL('Search'); }
	public function getUserGroupButtons()
	{
		static $template = true;
		if ($template === true)
		{
			$tVars = array(
				'href_users' => $this->hrefUsers(),
				'href_groups' => $this->hrefGroups(),
				'href_gallery' => $this->hrefGallery(),
				'href_search' => $this->hrefSearchUser(),
			);
			$template = $this->templatePHP('_buttons.php', $tVars);
		}
		return $template;
	}
}
?>