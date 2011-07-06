<?php

final class Usergroups_Create extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		$user = GWF_Session::getUser();
		
//		if (false !== ($group = $module->getGroup($user))) {
//			return GWF_Website::redirect($module->hrefEdit());
//		}
		
		if (!$module->canCreateGroup($user)) {
			return $module->error('err_perm');
		}
		
//		if ($module->hasGroup($user)) {
//			return $module->error('err_group_exists');
//		}
		
		if (false !== Common::getPost('create')) {
			return $this->onCreate($module).$module->requestMethodB('ShowGroups');
		}
		return $this->templateCreate($module);
	}
	
	private function templateCreate(Module_Usergroups $module)
	{
		
		$form = $this->formCreate($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_create')),
		);
		return $module->templatePHP('create.php', $tVars);
	}
	
	private function formCreate(Module_Usergroups $module)
	{
		$data = array(
			'name' => array(GWF_Form::STRING, '', $module->lang('th_name')),
			'join' => array(GWF_Form::SELECT, $module->selectJoinType(Common::getPost('join')), $module->lang('th_join')),
			'view' => array(GWF_Form::SELECT, $module->selectViewType(Common::getPost('view')), $module->lang('th_view')),
			'create' => array(GWF_Form::SUBMIT, $module->lang('btn_create')),
		);
		return new GWF_Form($this, $data);
	}

	public function validate_name(Module_Usergroups $module, $arg) { return $module->validate_name($arg); }
	public function validate_join(Module_Usergroups $module, $arg) { return $module->validate_join($arg); }
	public function validate_view(Module_Usergroups $module, $arg) { return $module->validate_view($arg); }
	private function onCreate(Module_Usergroups $module)
	{
		$form = $this->formCreate($module);
		if (false !== ($errors = $form->validate($module))) {
			return $errors.$this->templateCreate($module);
		}
		
		$user = GWF_Session::getUser();
		
		$groupname = $form->getVar('name');
		
		$options = 0;
		$options |= intval(Common::getPost('join', 0));
		$options |= intval(Common::getPost('view', 0));
		
		$group = new GWF_Group(array(
			'group_id' => 0,
			'group_name' => $groupname,
			'group_options' => $options,
			'group_lang' => $user->getLangID(),
			'group_country' => $user->getCountryID(),
			'group_founder' => $user->getID(),
			'group_memberc' => 0,
			'group_bid' => 0,
			'group_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		));
		
		if (false === $group->insert()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === GWF_UserGroup::addToGroup($user->getID(), $group->getID(), GWF_UserGroup::LEADER))
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false !== ($error = $this->createBoard($module, $group))) {
			return $error;
		}
		
		return $module->message('msg_created');
	}
	
	private function createBoard(Module_Usergroups $module, GWF_Group $group)
	{
		$name = $group->getName();
		
		$pid = $module->getForumBoard()->getID();
//		$pid = Common::clamp($module->cfgBID(), 1);
		
		if (false === GWF_ForumBoard::getByID($pid)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$groupid = $group->getID();
		$options = GWF_ForumBoard::ALLOW_THREADS;
		if (false === ($board = GWF_ForumBoard::createBoard('Usergroup: '.$name, 'Board for the '.$name.' group', $pid, $options, $groupid))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === $group->saveVar('group_bid', $board->getID())) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false !== ($error = $module->adjustFlags($group))) {
			return $error;
		}
		
		return false;
	}
	
}

?>