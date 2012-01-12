<?php
/**
 * @author gizmore
 */
final class Admin_GroupEdit extends GWF_Method
{
	/**
	 * @var GWF_Group
	 */
	private $group;
	
	##################
	### GWF_Method ###
	##################
	public function getUserGroups() { return GWF_Group::ADMIN; }
	public function execute(GWF_Module $module)
	{
		if (false !== ($error = $this->sanitize($this->_module))) {
			return $error;
		}
		
		if (false !== ($uid = Common::getGet('rem'))) {
			return $this->_module->templateNav().$this->onRemFromGroup($this->_module, $uid).$this->templateEdit($this->_module);
		}
		if (false !== (Common::getPost('edit'))) {
			return $this->_module->templateNav().$this->onEditGroup($this->_module).$this->templateEdit($this->_module);
		}
		if (false !== (Common::getPost('add_to_group'))) {
			return $this->_module->templateNav().$this->onAddToGroup($this->_module).$this->templateEdit($this->_module);
		}
		
		return $this->_module->templateNav().$this->templateEdit($this->_module);
	}
	
	################
	### Sanitize ###
	################
	private function sanitize(Module_Admin $module)
	{
		if (false === ($this->group = GWF_Group::getByID(Common::getGetString('gid')))) {
			return $this->_module->error('err_group');
		}
		return false;
	}
	
	###############
	### Selects ###
	###############
	public function getGroupViewSelect(Module_Admin $module, $selected, $name)
	{
		$data = array(
			array((string)0x100, $this->_module->lang('th_group_options&'.((string)0x100))),
			array((string)0x200, $this->_module->lang('th_group_options&'.((string)0x200))),
			array((string)0x400, $this->_module->lang('th_group_options&'.((string)0x400))),
			array((string)0x800, $this->_module->lang('th_group_options&'.((string)0x800))),
		);
		return GWF_Select::display($name, $data, $selected);
	}
	
	public function getGroupInviteSelect(Module_Admin $module, $selected, $name)
	{
		$data = array(
			array((string)0x01, $this->_module->lang('th_group_options&'.((string)0x01))),
			array((string)0x02, $this->_module->lang('th_group_options&'.((string)0x02))),
			array((string)0x04, $this->_module->lang('th_group_options&'.((string)0x04))),
			array((string)0x08, $this->_module->lang('th_group_options&'.((string)0x08))),
			array((string)0x10, $this->_module->lang('th_group_options&'.((string)0x10))),
		);
		return GWF_Select::display($name, $data, $selected);
	}
	################
	### Template ###
	################
	private function getForm(Module_Admin $module)
	{
		$g = $this->group;
		$data = array(
			'group_name' => array(GWF_Form::STRING, $g->getVar('group_name'), $this->_module->lang('th_group_name')),
			'view' => array(GWF_Form::SELECT, $this->getGroupViewSelect($this->_module, $g->getVisibleMode(), 'view'), $this->_module->lang('th_group_sel_view')),
			'join' => array(GWF_Form::SELECT, $this->getGroupInviteSelect($this->_module, $g->getJoinMode(), 'join'), $this->_module->lang('th_group_sel_join')),
			'lang' => array(GWF_Form::SELECT, GWF_LangSelect::single(0, 'lang', $g->getVar('group_lang')), $this->_module->lang('th_group_lang')),
			'country' => array(GWF_Form::SELECT, GWF_CountrySelect::single('country', $g->getVar('group_country')), $this->_module->lang('th_group_country')),
			'founder' => array(GWF_Form::STRING, $g->getFounder()->getVar('user_name'), $this->_module->lang('th_group_founder')),
			'edit' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_edit')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function getFormAdd(Module_Admin $module)
	{
		$data = array(
			'username' => array(GWF_Form::STRING, '', $this->_module->lang('th_user_name')),
			'add_to_group' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_add_to_group')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateEdit(Module_Admin $module)
	{
		$groups = GDO::table('GWF_UserGroup');
		$gid = $this->group->getID();
		$conditions = "ug_groupid=$gid";
		$ipp = $this->_module->cfgUsersPerPage();
		$nItems = $groups->countRows($conditions);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGet('page', 1), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$tVars = array(
			'group' => $this->group,
			'form' => $this->getForm($this->_module)->templateY($this->_module->lang('ft_edit_group', array($this->group->display('group_name')))),
			'form_add' => $this->getFormAdd($this->_module)->templateX($this->_module->lang('ft_add_to_group'),$this->getMethodHREF('&gid='.$gid)),
//			'users' => $groups->selectColumn('ug_userid', $conditions),
			'userids' => $groups->selectColumn('ug_userid', $conditions, '', NULL, $ipp, $from),
			'pagemenu' => GWF_PageMenu::display($page, $nPages, $this->getMethodHref(sprintf('&gid=%d&page=%%PAGE%%', $gid))),
			'sort_url' => '',
			'headers' => GWF_Table::displayHeaders1(array(array($this->_module->lang('th_user_name')),array(''),), ''),
		);
		return $this->_module->template('groupedit.tpl', $tVars);
	}
	
	###############
	### On Edit ###
	###############
	private function onEditGroup(Module_Admin $module)
	{
		$form = $this->getForm($this->_module);
		if (false !== ($errors = $form->validate($this->_module))) {
			return $errors;
		}

		# View+Join
		if (false === $this->group->saveOption(GWF_Group::VIEW_FLAGS|GWF_Group::JOIN_FLAGS, false)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		if (false === $this->group->saveOption($form->getVar('view')+$form->getVar('join'), true)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_edit_group');
	}
	
	#######################+
	### On Add To Group ###
	#######################
	private function onAddToGroup(Module_Admin $module)
	{
		$form = $this->getFormAdd($this->_module);
		if (false !== ($errors = $form->validate($this->_module))) {
			return $errors;
		}
		
		$user = GWF_User::getByName($form->getVar('username'));
		$userid = $user->getID();
		if (false === (GWF_UserGroup::addToGroup($userid, $this->group->getID()))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__,  __LINE__));
		}
		
		return $this->_module->message('msg_added_to_grp', array($user->displayUsername(), $this->group->display('group_name')));
	}
	
	public function onRemFromGroup(Module_Admin $module, $uid)
	{
		$uid = (int)$uid;
		$gid = $this->group->getID();
		if (false === GDO::table('GWF_UserGroup')->deleteWhere("ug_userid={$uid} AND ug_groupid={$gid}"))
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__,  __LINE__));
		}
		if (false === GWF_UserGroup::fixGroupMC())
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__,  __LINE__));
		}
		
		return $this->_module->message('msg_removed_from_grp', array(GWF_User::getByID($uid)->displayUsername(), $this->group->display('group_name')));
	}
	
	##################
	### Validators ###
	##################
	public function validate_username(Module_Admin $m, $arg) { return GWF_Validator::validateUsername($m, 'username', $arg, false, $arg); }
	public function validate_group_name(Module_Admin $m, $arg) { return false; }
	public function validate_view(Module_Admin $m, $arg) { return GWF_GroupSelect::isValidViewFlag((int)$arg) ? false : $m->lang('err_group_view'); }
	public function validate_join(Module_Admin $m, $arg) { return GWF_GroupSelect::isValidJoinFlag((int)$arg) ? false : $m->lang('err_group_join'); }
	public function validate_lang(Module_Admin $m, $arg) { return GWF_LangSelect::validate_langid($arg, true); }
	public function validate_country(Module_Admin $m, $arg) { return GWF_CountrySelect::validate_countryid($arg, true); }
	public function validate_founder(Module_Admin $m, $arg) { return GWF_Validator::validateUserID($arg, true, 'founder', true); }
}

?>
